<?php

namespace App\Http\Controllers\Truck;

use App\Http\Controllers\Controller;
use App\Models\Trucks;
use Auth;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function AddTruck(Request $request) {
        $data = $this->validate($request, [
            'registration_number' => 'required|string|min:8',
            'capacity' => 'required|integer|min:1',
            'manufacturing_year' => 'required|date_format:Y',
            'available_date' => 'required|string'
        ]);
        $date_range = explode(' - ', $data['available_date']);
        $from_date = $date_range[0];
        $to_date = $date_range[1];
        $owner = null;
        if (Auth::user()) {
            $owner = Auth::user()->id;
        }
        $create = Trucks::create([
            'owner_id' => $owner,
            'registration_number' => $data['registration_number'],
            'total_capacity' => $data['capacity'],
            'manufacturing_year' => $data['manufacturing_year'],
            'available_from_date' => date('Y-m-d', strtotime($from_date)),
            'available_to_date' => date('Y-m-d', strtotime($to_date)),
            'available_capacity' => $data['capacity']
        ]);
        if (!$create) {
            return redirect()->back()->with('error', 'Something went wrong, try again.');
        }
        return redirect()->back()->with('success', 'Truck Added Successfully');
    }
}
