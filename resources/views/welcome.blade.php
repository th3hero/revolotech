@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-8">
                    <h3 class="card-title">Trucks List</h3>
                </div>
                <div class="col-4 d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#ModalTriggerAddTruck">Add Truck</button>
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
@endsection

@section('script-js')
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
            });
        });
    </script>
@endsection

