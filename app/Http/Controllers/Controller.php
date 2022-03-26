<?php

namespace App\Http\Controllers;

use App\Models\Trucks;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Returning Root Or Welcome page & data for datatables when the request is from ajax request.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function TruckListingData(Request $request) {
        if ($request->ajax()) {
            $data = Trucks::where(['available_for_book' => true])->get();
            return \DataTables::of($data)->addIndexColumn()->addColumn('action', function ($data) {
                return '<a href="/book/'.Crypt::encrypt($data->id).'" class="handle btn btn-outline-primary btn-sm">Book Truck</a>';
            })->addColumn('availability', function ($data) { return date('d M, Y', strtotime($data->available_from_date)).' - '.date('d M, Y', strtotime($data->available_to_date)); })->editColumn('created_at', function($data){ $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d M, Y'); return $formatedDate; })->rawColumns(['action'])->make(true);
        }
        return view('welcome');
    }
}
