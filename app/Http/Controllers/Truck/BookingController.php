<?php

namespace App\Http\Controllers\Truck;

use App\Http\Controllers\Controller;
use App\Models\Bookings;
use App\Models\Trucks;
use Auth;
use Carbon\Carbon;
use Crypt;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

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
        dd($truck);
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

    public function BookingsByUser() {
        $data = Bookings::where(['user_id' => Auth::user()->id])->get();
        return \DataTables::of($data)->addIndexColumn()->addColumn('action', function ($data) {
            return '<a href="/book/'. \Illuminate\Support\Facades\Crypt::encrypt($data->id).'" class="handle btn btn-outline-primary btn-sm">Book Truck</a>';
        })->addColumn('availability', function ($data) { return date('d M, Y', strtotime($data->available_from_date)).' - '.date('d M, Y', strtotime($data->available_to_date)); })->editColumn('created_at', function($data){ $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d M, Y'); return $formatedDate; })->rawColumns(['action'])->make(true);
    }
}
