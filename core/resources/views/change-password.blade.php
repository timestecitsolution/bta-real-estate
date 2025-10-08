@extends('frontEnd.layouts.master')
@section('content')
@php
    $defaultPassword = '123456';
@endphp
<section class="booking-wrap">
    <div class="container">
        <div class="booking-content">
        <div class="row justify-content-center">
            <div class="booking-form col-lg-6">
                <!-- resources/views/booking/form.blade.php -->
                <form action="{{ route('change-password.update') }}" method="POST" id="bookingForm" enctype="multipart/form-data">
                        @csrf
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <label for="password" style="color: white;">Old Password</label>
                            <input type="password" name="current_password" class="form-control" value="{{ Hash::check($defaultPassword, Auth::guard('user')->user()->password) ? $defaultPassword : '' }}" placeholder="Enter Old Password" required>
                            @error('current_password')
                                <small class="text-white">{{ $message }}</small>
                            @enderror                               
                        </div>
                        <div class="col-lg-12">
                            <label for="new_password" style="color: white;">New Password</label>
                            <input type="password" name="password" class="form-control" placeholder="New Password" required>
                            @error('password')
                                <small class="text-white">{{ $message }}</small>
                            @enderror                               
                        </div>
                        <div class="col-lg-12">
                            <label for="confirm_password" style="color: white;">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm New Password" required>
                            @error('password_confirmation')
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