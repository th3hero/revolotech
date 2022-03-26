<?php

namespace App\Http\Controllers\Truck;

use App\Http\Controllers\Controller;
use App\Models\Bookings;
use App\Models\Trucks;
use Auth;
use Carbon\Carbon;
use Crypt;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\True_;

class BookingController extends Controller
{
    /**
     * Returning the View Page for Booking truck.
     *
     * @param $truck
     * @return Application|Factory|View
     */
    public function BookTruck($truck) {
        $truck = $this->DecryptAndReturnTruckInfo($truck);
        return view('book', compact('truck'));
    }

    /**
     * Decrypting the Truck ID from URI to find the truck which is going to book.
     *
     * @param $hash
     * @return mixed
     */
    private function DecryptAndReturnTruckInfo($hash) {
        $id = Crypt::decrypt($hash);
        return Trucks::find($id);
    }

    public function HandleBookRequestData(Request $request) {
        $data = $this->validate($request, [
            'company_name' => 'required|string',
            'registration_number' => 'required|string|min:8',
            'booking_date' => 'required|date_format:m/d/Y',
            'booking_weight' => 'required|numeric',
            'booking_from' => 'required|string',
            'delivery_location' => 'required|string',
            'truck_id' => 'required|string'
        ]);
        $truck = $this->DecryptAndReturnTruckInfo($data['truck_id']);
        $forge = $this->CheckIfDataForgedOrManipulated($data['registration_number'], $truck['registration_number']);
        if ($forge !== true) {
            return redirect()->back()->withErrors(['registration_number' => 'Registration Number is Incorrect'])->withInput();
        }
        $available = $this->CheckAvailabilityIsValidOnBookingDate($data['booking_date'], $truck->available_from_date, $truck->available_to_date);
        if ($available !== true) {
            return redirect()->back()->withErrors(['booking_date' => 'Booking Date is Invalid, should be between '.date('d M, Y', strtotime($truck->available_from_date)).' to '.date('d M, Y', strtotime($truck->available_to_date))])->withInput();
        }
        $weight_issue = $this->CheckWeightIsValid($data['booking_weight'], $truck['available_capacity']);
        if ($weight_issue !== false) {
            return redirect()->back()->withErrors(['booking_weight' => 'Booking Weight is Invalid, should be less than '.$truck->available_capacity.' Tons'])->withInput();
        }
        $uid = IdGenerator::generate(['table' => 'bookings', 'field' => 'booking_id', 'length' => 6, 'prefix' => 'BK']);
        $status = $this->ChangeStatusOrNot($data['booking_weight'], $truck['available_capacity']);
        $booking = Bookings::create([
            'user_id' => Auth::user()->id,
            'booking_id' => $uid,
            'truck_id' => $truck->id,
            'company_name' => $data['company_name'],
            'booking_date' => date('Y-m-d', strtotime($data['booking_date'])),
            'booking_weight' => $data['booking_weight'],
            'booked_from' => $data['booking_from'],
            'delivery_to' => $data['delivery_location']
        ]);
        if ($booking !== null) {
            $truck->update([
                'available_from_date' => $booking->booking_date,
                'available_to_date' => $booking->booking_date,
                'available_for_book' => $status,
                'available_capacity' => $truck['available_capacity']-$booking['booking_weight']
            ]);
            return redirect()->route('home')->with('success', 'Truck Booked Successfully');
        } else {
            return redirect()->back()->with('error', 'Something Went Wrong!');
        }
    }

    private function CheckIfDataForgedOrManipulated($val1, $val2) {
        if ($val1 !== $val2) {
            return false;
        }
        return true;
    }

    private function CheckAvailabilityIsValidOnBookingDate($book_date, $from_date, $to_date) {
        if (strtotime($from_date) > strtotime($book_date) || strtotime($to_date) < strtotime($book_date)) {
            return false;
        }
        return true;
    }

    private function CheckWeightIsValid($input_weight, $db_weight) {
        if ($input_weight <= $db_weight) {
            return false;
        }
        return true;
    }

    private function ChangeStatusOrNot($input_weight, $db_weight) {
        $weight = $db_weight-$input_weight;
        if ($weight >= 1) {
            return true;
        }
        return false;
    }

    public function BookingsByUser() {
        $data = Bookings::with('Truck')->where(['user_id' => Auth::user()->id])->get();
        return \DataTables::of($data)->addIndexColumn()->addColumn('action', function ($data) {
            return '<a href="/book/cancel/'. \Illuminate\Support\Facades\Crypt::encrypt($data->id).'" class="handle btn btn-outline-primary btn-sm">Cancel Book</a>';
        })->addColumn('booking_date', function ($data) { return date('d M, Y', strtotime($data->booking_date)); })->addColumn('registration_number', function ($data) { return $data->Truck->registration_number; })->rawColumns(['action'])->make(true);
    }

    public function BookingsOfOwner() {
        $data = Bookings::whereHas('Truck', function($q){$q->where('owner_id', '=', Auth::user()->id);})->get();
        return \DataTables::of($data)->addIndexColumn()->addColumn('action', function ($data) {
            return '<a href="/order/deny/'. \Illuminate\Support\Facades\Crypt::encrypt($data->id).'" class="handle btn btn-outline-primary btn-sm">Deny Booking</a>';
        })->addColumn('booking_date', function ($data) { return date('d M, Y', strtotime($data->booking_date)); })->addColumn('registration_number', function ($data) { return $data->Truck->registration_number; })->rawColumns(['action'])->make(true);
    }
}
