@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mt-3">
            <div class="card-header">
                <div class="row">
                    <h3 class="card-title">Truck Booking Form</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-8">
                        <form method="post" action="{{ route('book') }}">@csrf
                            <div class="mb-1">
                                <label for="Company" class="col-form-label">Booking Company Name:</label>
                                <input type="text" class="form-control @error('company_name') is-invalid @enderror" id="Company" value="{{ old('company_name') }}" name="company_name" placeholder="Enter Name of booker company" required>
                                @error('company_name')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-1">
                                <label for="RegisterationNumber" class="col-form-label">Truck Registration Number</label>
                                <input type="text" class="form-control @error('registration_number') is-invalid @enderror" id="RegisterationNumber" value="{{ $truck->registration_number }}" name="registration_number" readonly required>
                                <input type="hidden" name="truck_id" value="{{ Crypt::encrypt($truck->id) }}">
                                @error('registration_number')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-1">
                                <label for="BookingDate" class="col-form-label">Booking Date</label>
                                <input type="text" class="form-control @error('booking_date') is-invalid @enderror" id="BookingDate" value="{{ old('booking_date') }}" name="booking_date" placeholder="Select the date of booking" required>
                                @error('booking_date')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-1">
                                <label for="Weight" class="col-form-label">Booking Weight</label>
                                <input class="form-control @error('booking_weight') is-invalid @enderror" id="Weight" name="booking_weight" placeholder="Enter the Booking Weight" maxLoad="{{ $truck->available_capacity }}" type="text" required value="{{ old('booking_weight') }}">
                                <span class="text-danger" id="WeightError">@error('booking_weight'){{ $message }}@enderror</span>
                            </div>
                            <div class="mb-1">
                                <label for="BookedFrom" class="col-form-label">Booking From Location</label>
                                <input class="form-control @error('booking_from') is-invalid @enderror" id="BookedFrom" name="booking_from" placeholder="Enter the Booking Address" value="{{ old('booking_from') }}" type="text" required>
                                @error('booking_from')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-4">
                                <label for="DeliveryLocation" class="col-form-label">Delivery Location</label>
                                <input class="form-control @error('delivery_location') is-invalid @enderror" id="DeliveryLocation" name="delivery_location" placeholder="Enter the Booking Delivery Address" value="{{ old('delivery_location') }}" type="text" required>
                                @error('delivery_location')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="d-flex justify-content-center mb-3">
                                <button type="submit" class="btn btn-primary">Book Now</button>&nbsp;&nbsp;&nbsp;
                                <a href="{{ url('/') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('input[name="booking_date"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
            })
            $(document).on('keyup', '#Weight', function () {
                const ErrorBox = $('#WeightError');
                const MaxLoad = parseFloat($('#Weight').attr('maxLoad'));
                if (MaxLoad < parseFloat($('#Weight').val())) {
                    ErrorBox.empty();
                    ErrorBox.append('Available Capacity of the Vehicle should be less then or equal to '+MaxLoad+' Tons');
                } else {
                    ErrorBox.empty();
                }
            });
        });
    </script>
@endsection
