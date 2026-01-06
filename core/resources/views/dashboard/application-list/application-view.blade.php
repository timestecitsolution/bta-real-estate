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

            <!-- Project -->
            <div class="mb-4">
                <strong>Project:</strong>
                <span style="margin-left:10px;">
                    {{ $applications->project->title_en ?? 'N/A' }}
                </span>
            </div>

            <!-- Flat -->
            <div class="mb-4">
                <strong>Flat:</strong>
                <span style="margin-left:10px;">
                    {{ $applications->flat->title ?? 'N/A' }}
                </span>
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

            <!-- Attachments Section -->
            @if($applications->attachments && $applications->attachments->count() > 0)
                <div class="mt-4">
                    <strong>Attachments:</strong>
                    <ul>
                        @foreach($applications->attachments as $attachment)
                            @php
                                $fileUrl = Storage::disk('public')->url($attachment->file_path);
                                $fileExt = pathinfo($attachment->file_name, PATHINFO_EXTENSION);
                                $isImage = in_array(strtolower($fileExt), ['jpg','jpeg','png','gif']);
                            @endphp

                            <li>
                                @if($isImage)
                                    <a href="#" class="attachment-preview" data-url="{{ $fileUrl }}" data-name="{{ $attachment->file_name }}">
                                        {{ $attachment->file_name }}
                                    </a>
                                @else
                                    <a href="{{ $fileUrl }}" target="_blank" download>
                                        {{ $attachment->file_name }}
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Preview Modal -->
                <div class="modal fade" id="attachmentPreviewModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="attachmentPreviewTitle"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img id="attachmentPreviewImage" src="" class="img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                </div>

            @endif

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

                <form id="approveRejectForm" action="{{ route('application.approve-reject', $applications->id) }}" method="POST">
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
                                id="approveFeedback"
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
                <div class="mb-4" id="feedbackList">

                @forelse($applications->feedbacks as $item)

                    @php
                        $authUserId = Auth::id();
                        $isMine = $item->created_by == $authUserId;
                    @endphp

                    <div class="d-flex mb-3 {{ $isMine ? 'justify-content-end' : 'justify-content-start' }}">
                        <div
                            class="p-3 mb-2"
                            style="
                                max-width:70%;
                                background: {{ $isMine ? '#e9f7ef' : '#f1f3f5' }};
                                border-left: {{ $isMine ? '0' : '4px solid #007bff' }};
                                border-right: {{ $isMine ? '4px solid #28a745' : '0' }};
                                border-radius:8px;
                            "
                        >
                            <div class="d-flex justify-content-between mb-1">
                                <strong>
                                    {{ optional($item->feedbackCreator)->first_name ?? 'System' }}
                                </strong>
                                <small class="text-muted">
                                    {{ $item->created_at->format('d M Y, h:i A') }}
                                </small>
                            </div>

                            <div style="white-space:pre-line;">
                                {{ $item->feedback }}
                            </div>
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
<script>   
$('#approveRejectForm').on('submit', function (e) {
    e.preventDefault();

    let form = $(this);

    $.ajax({
        url: form.attr('action'),
        type: "POST",
        data: form.serialize(),
        success: function (res) {
            // textarea clear
            $('#approveFeedback').val('');

            // feedback append
            if(res.feedback){
                let fb = res.feedback;
                $('#feedbackList').append(`
                    <div class="d-flex mb-3 justify-content-end">
                        <div style="
                            max-width:70%;
                            background:#e9f7ef;
                            border-right:4px solid #28a745;
                            border-radius:8px;
                            padding:12px;
                        ">
                            <div class="d-flex justify-content-between mb-1">
                                <strong>${fb.creator_name}</strong>
                                <small class="text-muted">${fb.created_at}</small>
                            </div>
                            <div style="white-space:pre-line;">
                                ${fb.text}
                            </div>
                        </div>
                    </div>
                `);
            }

            // status update
            if(res.status){
                // Update radio selection
                $(`input[name="status"][value="${res.status}"]`).prop('checked', true);

                // Disable all radios if approved/rejected
                if(['approved','rejected'].includes(res.status)){
                    $('input[name="status"]').prop('disabled', true);
                }
            }
        },
        error: function () {
            alert('Failed to submit');
        }
    });
});
</script>
<!-- Attatchment Preview Script -->
<script>
    $(document).ready(function () {
        $('.attachment-preview').on('click', function (e) {
            e.preventDefault();

            let url = $(this).data('url');
            let name = $(this).data('name');

            $('#attachmentPreviewTitle').text(name);
            $('#attachmentPreviewImage').attr('src', url);

            $('#attachmentPreviewModal').modal('show');
        });
    });
</script>
@endpush
