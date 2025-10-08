@extends('frontEnd.layouts.master')
@section('content')
<section class="booking-wrap">
    <div class="container">
        <div class="booking-content">
        <div class="row justify-content-center">
            <div class="booking-form col-lg-6">
                <!-- resources/views/booking/form.blade.php -->
                <form action="{{ route('booking.loginbookinguser') }}" method="POST" id="bookingForm" enctype="multipart/form-data">
                        @csrf
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                            @error('email')
                                <small class="text-white">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-lg-12">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                            @error('password')
                                <small class="text-white">{{ $message }}</small>
                            @enderror                               
                        </div>
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
</section>
@include('frontEnd.layouts.popup',['Popup'=>@$Popup])
@endsection