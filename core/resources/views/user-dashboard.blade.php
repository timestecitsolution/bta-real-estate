@extends('frontEnd.layouts.master')
@section('content')
<section class="booking-wrap">
    <div class="container">
        <!-- ===== Nav Tabs ===== -->
        <ul class="nav nav-tabs mb-4" id="userDashboardTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" style="color: black !important;" id="payment-overview-tab" data-bs-toggle="tab" data-bs-target="#payment-overview" type="button" role="tab" aria-controls="payment-overview" aria-selected="true">
                    Payment Overview
                </button>
            </li>
            <li class="nav-item" style="color: black !important;"role="presentation">
                <button class="nav-link" style="color: black !important;" id="booking-overview-tab" data-bs-toggle="tab" data-bs-target="#booking-overview" type="button" role="tab" aria-controls="booking-overview" aria-selected="false">
                    Booking Overview
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" style="color: black !important;" id="emi-schedule-tab" data-bs-toggle="tab" data-bs-target="#emi-schedule" type="button" role="tab" aria-controls="emi-schedule" aria-selected="false">
                    EMI Payment Form
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" style="color: black !important;" id="user-profile-tab" data-bs-toggle="tab" data-bs-target="#user-profile" type="button" role="tab" aria-controls="user-profile" aria-selected="false">
                    User Profile
                </button>
            </li>
            @if($user->status == '1')
            <li class="nav-item" role="presentation">
                <button class="nav-link" style="color: black !important;" id="bulk-sms-tab" data-bs-toggle="tab" data-bs-target="#bulk-sms" type="button" role="tab" aria-controls="bulk-sms" aria-selected="false">
                    Bulk Sms
                </button>
            </li>
            @endif
            <li class="nav-item" role="presentation">
                <button class="nav-link" style="color: black !important;" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications" type="button" role="tab" aria-controls="notifications" aria-selected="false">
                    Action
                </button>
            </li>
            <div class="ms-3">
                <form method="POST" action="{{ route('user.logout') }}">
                    @csrf
                    <button class="nav-link btn btn-danger" style="color: white !important; background-color: red !important;" type="submit">Logout</button>
                </form>
            </div>
        </ul>

        <!-- ===== Tab Content ===== -->
        <div class="tab-content" id="userDashboardTabsContent">
            <div class="tab-pane fade show active" id="payment-overview" role="tabpanel" aria-labelledby="payment-overview-tab">
                @include('user-dashboard.payment-overview')
            </div>
            <div class="tab-pane fade" id="booking-overview" role="tabpanel" aria-labelledby="booking-overview-tab">
                @include('user-dashboard.booking-overview')
            </div>
            <div class="tab-pane fade" id="emi-schedule" role="tabpanel" aria-labelledby="emi-schedule-tab">
                @include('user-dashboard.emi-schedule')
            </div>
            <div class="tab-pane fade" id="user-profile" role="tabpanel" aria-labelledby="user-profile-tab">
                @include('user-dashboard.user-profile')
            </div>
            @if($user->status == '1')
            <div class="tab-pane fade" id="bulk-sms" role="tabpanel" aria-labelledby="bulk-sms-tab">
                @include('user-dashboard.bulk-sms')
            </div>
            @endif
            <div class="tab-pane fade" id="notifications" role="tabpanel" aria-labelledby="notifications-tab">
                @include('user-dashboard.notification')
            </div>
        </div>
    </div>
    
</section>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Persist active tab
    let activeTab = localStorage.getItem("activeTab");
    if (activeTab) {
        let tabTrigger = document.querySelector(`button[data-bs-target="${activeTab}"]`);
        if (tabTrigger) new bootstrap.Tab(tabTrigger).show();
    }

    document.querySelectorAll('button[data-bs-toggle="tab"]').forEach(function (el) {
        el.addEventListener("shown.bs.tab", function (event) {
            localStorage.setItem("activeTab", event.target.getAttribute("data-bs-target"));
        });
    });
});
</script>

@include('frontEnd.layouts.popup',['Popup'=>@$Popup])
@endsection
