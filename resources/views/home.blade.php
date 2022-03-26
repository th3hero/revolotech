@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs justify-content-around" data-bs-tabs="tabs">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="true" data-bs-toggle="tab" href="#Trucks">All Trucks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#MyBookings">My Bookings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#MyOrdersTab">My Orders</a>
                </li>
            </ul>
        </div>
        <div class="card-body tab-content">
            <div class="tab-pane active" id="Trucks">
                <div class="container">
                    <div class="container mb-3 mt-2">
                        <div class="d-flex justify-content-between">
                            <h4 class="text-black">All the Trucks in System</h4>
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                    data-bs-target="#ModalTriggerAddTruck">Add Truck
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table" id="TrucksAll" style="width: 100%">
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
            </div>
            <div class="tab-pane" id="MyBookings">
                <div class="container">
                    <div class="container mb-3">
                        <div class="d-flex justify-content-start">
                            <h4 class="text-black">My Bookings</h4>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table" id="MyBooks" style="width: 100%">
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
            </div>
            <div class="tab-pane" id="MyOrdersTab">
                <div class="container">
                    <div class="container">
                        <h4 class="text-black">My Trucks Order</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table" id="MyOrders" style="width: 100%">
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

@section('script-js')
    <script type="text/javascript">
        $(document).ready(function () {
            const ListingURL = "{{ route('listing.truck') }}";
            $(function () {
                $("#TrucksAll").DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: ListingURL,
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'registration_number', name: 'registration_number'},
                        {data: 'availability', name: 'availability'},
                        {data: 'available_capacity', name: 'available_capacity', render: $.fn.dataTable.render.number(',', '.', 0,'',' Tons')},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ]
                });
            });

            const BookingURL = "{{ route('bookings') }}";
            $(function () {
                $("#MyBooks").DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: BookingURL,
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'booking_date', name: 'booking_date'},
                        {data: 'registration_number', name: 'registration_number'},
                        {data: 'booked_from', name: 'booked_from'},
                        {data: 'delivery_to', name: 'delivery_to'},
                        {data: 'booking_weight', name: 'booking_weight', render: $.fn.dataTable.render.number(',', '.', 0,'',' Tons')},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ]
                });
            });

            const OrdersURL = "{{ route('orders') }}";
            $(function () {
                $("#MyOrders").DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: OrdersURL,
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'booking_date', name: 'booking_date'},
                        {data: 'company_name', name: 'company_name'},
                        {data: 'booked_from', name: 'booked_from'},
                        {data: 'delivery_to', name: 'delivery_to'},
                        {data: 'booking_weight', name: 'booking_weight', render: $.fn.dataTable.render.number(',', '.', 0,'',' Tons')},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ]
                });
            });
            $('input[name="available_date"]').daterangepicker({
                startDate: moment().startOf('day'),
                endDate: moment().startOf('day').add(4, 'day'),
            });
            $('input[name="booking_date"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
            })
        });
    </script>
@endsection
