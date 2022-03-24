<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Revolotech Task</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/cr-1.5.5/date-1.1.2/fc-4.0.2/fh-3.2.2/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.2/sp-2.0.0/sl-1.3.4/sr-1.1.0/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
</head>
<body>
<main>
    <div class="container">
        @if(Session::has('success'))
            <div class="alert alert-success mt-5" role="alert">
                {{Session::get('success')}}
            </div>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-success mt-5" role="alert">
                {{Session::get('error')}}
            </div>
        @endif
        <div class="card mt-5">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h3 class="card-title">Trucks List</h3>
                    </div>
                    <div class="col-4 d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                data-bs-target="#ModalTriggerAddTruck">Add Truck
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="ListingTable">
                        <thead>
                        <tr>
                            <th>S.no</th>
                            <th>Truck Registration No.</th>
                            <th>Available Date.</th>
                            <th>Capacity</th>
                            <th>Button</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Modal Code :: Starts -->
<div class="modal fade" id="TruckBookingModal" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="{{ route('add.truck') }}">@csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Book Truck</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-1">
                        <label for="Company" class="col-form-label">Booking Company Name:</label>
                        <input type="text" class="form-control" id="Company" name="company_name" placeholder="Enter Name of booker company" required>
                    </div>
                    <div class="mb-1">
                        <label for="RegisterationNumber" class="col-form-label">Truck Registration Number</label>
                        <input type="text" class="form-control" id="RegisterationNumber" name="registration_number" readonly required>
                    </div>
                    <div class="mb-1">
                        <label for="BookingDate" class="col-form-label">Booking Date</label>
                        <input type="text" class="form-control" id="BookingDate" name="booking_date" placeholder="Select the date of booking" required>
                    </div>
                    <div class="mb-1">
                        <label for="Weight" class="col-form-label">Booking Weight</label>
                        <input class="form-control" id="Weight" name="booking_weight" placeholder="Enter the Booking Weight" type="text" required>
                    </div>
                    <div class="mb-1">
                        <label for="BookedFrom" class="col-form-label">Booking From Location</label>
                        <input class="form-control" id="BookedFrom" name="booking_from" placeholder="Enter the Booking Address" type="text" required>
                    </div>
                    <div class="mb-1">
                        <label for="DeliveryLocation" class="col-form-label">Delivery Location</label>
                        <input class="form-control" id="DeliveryLocation" name="delivery_location" placeholder="Enter the Booking Delivery Address" type="text" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Book Now</button>
                </div>
            </div>
        </form>
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
                        <input type="text" class="form-control" id="RegNumber" name="registration_number" placeholder="Enter Truck Registration Number." required>
                    </div>
                    <div class="mb-3">
                        <label for="CapacityInput" class="col-form-label">Capacity</label>
                        <input type="number" class="form-control" id="CapacityInput" name="capacity" placeholder="Enter the Capacity of the Loading." required>
                    </div>
                    <div class="mb-3">
                        <label for="ManufacturingYear" class="col-form-label">Manufacturing year</label>
                        <input type="number" class="form-control" id="ManufacturingYear" name="manufacturing_year" placeholder="Enter the manufacturing year of Vehicle." required>
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/cr-1.5.5/date-1.1.2/fc-4.0.2/fh-3.2.2/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.2/sp-2.0.0/sl-1.3.4/sr-1.1.0/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        const ListingURL = "{{ route('listing.truck') }}";
        $(function () {
            $(".table").DataTable({
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
        $('input[name="available_date"]').daterangepicker({
            startDate: moment().startOf('day'),
            endDate: moment().startOf('day').add(4, 'day'),
        });
        $('input[name="booking_date"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
        })
        $(document).on('click', '.booking-reference-button', function () {

        });
    });
</script>
</body>
</html>
