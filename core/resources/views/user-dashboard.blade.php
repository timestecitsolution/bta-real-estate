@extends('frontEnd.layouts.master')
@section('content')
<section class="booking-wrap">
    <div class="container">
        <div class="booking-content">
            <div class="row justify-content-center">
                <div class="d-flex align-items-start">
                <div class="nav flex-column nav-pills me-3 align-items-start" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <button class="nav-link" style="color: black !important;" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Payment Overview</button>
                    <button class="nav-link" style="color: black !important;" id="v-pills-booking-status-tab" data-bs-toggle="pill" data-bs-target="#v-pills-booking-status" type="button" role="tab" aria-controls="v-pills-booking-status" aria-selected="false">Booking Overview</button>
                    <button class="nav-link" style="color: black !important;" id="v-pills-emi-schedule-tab" data-bs-toggle="pill" data-bs-target="#v-pills-emi-schedule" type="button" role="tab" aria-controls="v-pills-emi-schedule" aria-selected="false">EMI Payment Form</button>
                    <!-- <button class="nav-link" style="color: black !important;" id="v-payment-history-tab" data-bs-toggle="pill" data-bs-target="#v-payment-history" type="button" role="tab" aria-controls="v-payment-history" aria-selected="false">Payment History</button> -->
                    <button class="nav-link" style="color: black !important;" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">User Profile</button>
                    <button class="nav-link" style="color: black !important;" id="v-notifications-tab" data-bs-toggle="pill" data-bs-target="#v-notifications" type="button" role="tab" aria-controls="v-notifications" aria-selected="false">Notification Upcoming Installment</button>
                    <form method="POST" action="{{ route('user.logout') }}">
                        @csrf
                        <button class="nav-link" style="color: white !important; background-color: red !important;" type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </div>
                <div class="tab-content d-flex justify-content-center align-items-center" id="v-pills-tabContent" style="width: 65%;">
                    <div class="tab-pane fade" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">@include('user-dashboard.payment-overview')</div>
                    <div class="tab-pane fade" id="v-pills-booking-status" role="tabpanel" aria-labelledby="v-pills-booking-status-tab" tabindex="0">@include('user-dashboard.booking-overview')</div>
                    <div class="tab-pane fade" id="v-pills-emi-schedule" role="tabpanel" aria-labelledby="v-pills-emi-schedule-tab" tabindex="0" style="width: 90%;">@include('user-dashboard.emi-schedule')</div>
                    <!-- <div class="tab-pane fade" id="v-payment-history" role="tabpanel" aria-labelledby="v-payment-history-tab" tabindex="0">@include('user-dashboard.payment-history')</div> -->
                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0">@include('user-dashboard.user-profile')</div>
                    <div class="tab-pane fade" id="v-notifications" role="tabpanel" aria-labelledby="v-notifications-tab" tabindex="0">@include('user-dashboard.notification')</div>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let activeTab = localStorage.getItem("activeTab");

    if (activeTab) {
        let tabTrigger = document.querySelector(`button[data-bs-target="${activeTab}"]`);
        if (tabTrigger) {
            let tab = new bootstrap.Tab(tabTrigger);
            tab.show();
        }
    } else {
        let firstTab = document.querySelector('button[data-bs-toggle="pill"]');
        if (firstTab) {
            new bootstrap.Tab(firstTab).show();
        }
    }

    document.querySelectorAll('button[data-bs-toggle="pill"]').forEach(function (el) {
        el.addEventListener("shown.bs.tab", function (event) {
            localStorage.setItem("activeTab", event.target.getAttribute("data-bs-target"));
        });
    });
});
</script>
@include('frontEnd.layouts.popup',['Popup'=>@$Popup])
@endsection