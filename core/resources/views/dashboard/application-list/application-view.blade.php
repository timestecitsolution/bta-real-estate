@extends('dashboard.layouts.master')
@section('title', "Edit Application Subject")

@push("after-styles")
<link href="{{ asset("assets/dashboard/js/iconpicker/fontawesome-iconpicker.min.css") }}" rel="stylesheet">
@endpush

@section('content')
<div class="padding">
    <div class="box">
        <div class="box-header dker">
            <h3><i class="material-icons">&#xe3c9;</i> Edit Application Subject</h3>
            <small>
                <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                <a>Edit Application Subject</a>
            </small>
        </div>
        <div class="box-tool">
            <ul class="nav">
                <li class="nav-item inline">
                    <a class="nav-link" href="{{ route('price') }}">
                        <i class="material-icons md-18">×</i>
                    </a>
                </li>
            </ul>
        </div>

        <div class="box-body p-4" style="background:#fff; border:1px solid #ddd; max-width:900px; margin:auto">

            <!-- Header -->
            <div class="text-center mb-4">
                <h3 style="text-transform: uppercase; letter-spacing:1px;">
                    Application
                </h3>
                <hr style="width:120px;">
            </div>

            <!-- Subject -->
            <div class="mb-4">
                <strong>Subject:</strong>
                <span style="margin-left:10px;">
                    {{ $applications->subject->subject }}
                </span>
            </div>

            <!-- Body -->
            <div style="line-height:1.8; text-align:justify; white-space:pre-line;">
                {!! $applications->body !!}
            </div>

            <!-- Footer -->
            <div class="mt-5 text-left">
                <p>
                    <strong>Submitted By</strong><br>
                    {{ $applications->creator->first_name ?? 'Applicant' }}<br>
                    <small class="text-muted">
                        Date: {{ $applications->created_at->format('d M Y') }}
                    </small>
                </p>
            </div>

            <div style="border-top:1px dashed #ccc; padding-top:25px;">

                <h5 class="mb-3">Feedback & Decision History</h5>

                {{-- Status & Feedback Form --}}
                @php
                    $isReadonly = in_array($applications->status, ['approved', 'rejected']);
                @endphp

                <form action="{{ route('application.approve-reject', $applications->id) }}" method="POST">
                    @csrf

                    {{-- Status --}}
                    <div class="form-group mb-3">
                        <label class="d-block"><strong>Application Status</strong></label>

                        <label class="mr-3">
                            <input type="radio" name="status" value="approved"
                                {{ $applications->status == 'approved' ? 'checked' : '' }}
                                {{ $isReadonly ? 'disabled' : '' }}>
                            Approve
                        </label>

                        <label class="mr-3">
                            <input type="radio" name="status" value="rejected"
                                {{ $applications->status == 'rejected' ? 'checked' : '' }}
                                {{ $isReadonly ? 'disabled' : '' }}>
                            Reject
                        </label>

                        <label>
                            <input type="radio" name="status" value="hold"
                                {{ $applications->status == 'hold' ? 'checked' : '' }}
                                {{ $isReadonly ? 'disabled' : '' }}>
                            Hold
                        </label>
                    </div>

                    {{-- New Feedback --}}
                    <div class="form-group mb-4">
                        <label><strong>Add New Feedback</strong></label>

                        <textarea name="feedback"
                                class="form-control"
                                rows="3"
                                placeholder="Write your reply here..."></textarea>

                        <small class="text-muted">
                            This will be added as a new reply in the conversation.
                        </small>
                    </div>

                    {{-- Submit --}}
                    <div class="text-right">
                        <button type="submit" class="btn btn-success">
                            <i class="material-icons">&#xe876;</i> Submit
                        </button>
                        <a href="{{ route('price') }}" class="btn btn-default">
                            Back
                        </a>
                    </div>
                </form>
                <hr>
                {{-- Existing Feedback Thread --}}
                <div class="mb-4">

                    @forelse($applications->feedbacks as $item)
                        <div class="mb-3 p-3"
                            style="background:#f9f9f9; border-left:4px solid #007bff; border-radius:4px;">

                            <div class="d-flex justify-content-between mb-1">
                                <strong>
                                    {{ optional($item->feedbackCreator)->first_name ?? 'System/User' }}
                                </strong>
                                <small class="text-muted">
                                    {{ $item->created_at->format('d M Y, h:i A') }}
                                </small>
                            </div>

                            <div style="white-space:pre-line;">
                                {{ $item->feedback }}
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No feedback yet.</p>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push("after-scripts")
<script src="{{ asset("assets/dashboard/js/iconpicker/fontawesome-iconpicker.js") }}"></script>
@endpush
