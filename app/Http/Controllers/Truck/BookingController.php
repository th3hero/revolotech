<?php

namespace App\Http\Controllers\Truck;

use App\Http\Controllers\Controller;
use App\Models\Trucks;
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
}
