@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-pills mb-3 justify-content-around" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-trucks-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-trucks" type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true">All Trucks
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-bookings-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-bookings" type="button" role="tab" aria-controls="pills-profile"
                                aria-selected="false">Bookings
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-orders-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-orders" type="button" role="tab" aria-controls="pills-orders"
                                aria-selected="false">My Trucks Orders
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-trucks" role="tabpanel"
                         aria-labelledby="pills-trucks-tab">
                        <div class="container mb-3">
                            <div class="d-flex justify-content-between">
                                <h4 class="text-black">All the Trucks in System</h4>
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                        data-bs-target="#ModalTriggerAddTruck">Add Truck
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table" id="TrucksAll">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Registration Number</th>
                                    <th>Available Date</th>
                                    <th>Capacity</th>
                                    <th>Button</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-bookings" role="tabpanel" aria-labelledby="pills-bookings-tab">
                        <div class="container mb-3">
                            <h4 class="text-black">My Bookings</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table" id="MyBooks">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Booking Date</th>
                                    <th>Registration Number</th>
                                    <th>Booking From</th>
                                    <th>Delivery To</th>
                                    <th>Booked Weight</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-orders" role="tabpanel" aria-labelledby="pills-orders-tab">
                        <div class="container">
                            <h4 class="text-black">My Trucks Order</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table" id="MyOrders">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Booking Date</th>
                                    <th>Booking Company</th>
                                    <th>Booked From</th>
                                    <th>Delivery To</th>
                                    <th>Booked Weight</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ModalTriggerAddTruck" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="{{ route('add.truck') }}">@csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Truck for Load</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="RegNumber" class="col-form-label">Truck Registration Number:</label>
                            <input type="text" class="form-control" id="RegNumber" name="registration_number"
                                   placeholder="Enter Truck Registration Number." required>
                        </div>
                        <div class="mb-3">
                            <label for="CapacityInput" class="col-form-label">Capacity</label>
                            <input type="number" class="form-control" id="CapacityInput" name="capacity"
                                   placeholder="Enter the Capacity of the Loading." required>
                        </div>
                        <div class="mb-3">
                            <label for="ManufacturingYear" class="col-form-label">Manufacturing year</label>
                            <input type="number" class="form-control" id="ManufacturingYear" name="manufacturing_year"
                                   placeholder="Enter the manufacturing year of Vehicle." required>
                        </div>
                        <div class="mb-3">
                            <label for="AvailableDates" class="col-form-label">Available Date Range</label>
                            <input class="form-control" id="AvailableDates" name="available_date"
                                   placeholder="Select available date range" type="text"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Truck</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal Code :: Ends -->
@endsection
