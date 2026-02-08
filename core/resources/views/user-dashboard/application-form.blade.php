@php
    if($Contact->status == '2'){
        $priceJsData = $allocated_flats->map(function ($item) {
            return [
                'project_id' => optional($item->project)->id,
                'flat_id'    => optional($item->flat)->id,
                'flat_title' => optional($item->flat)->flat_name,
            ];
        })->values();


        $projects = $allocated_flats
        ->pluck('project')
        ->filter()
        ->unique('id')
        ->values();
    }else{
        $priceJsData = $all_prices_details->map(function ($item) {
            return [
                'project_id' => $item->project->id,
                'flat_id'    => $item->flat->id,
                'flat_title' => $item->flat->flat_name,
            ];
        })->values();


        $projects = $all_prices_details
        ->pluck('project')
        ->filter()
        ->unique('id')
        ->values();
    }
@endphp

<h3>Application</h3>

<!-- Tabs -->
<ul class="nav nav-tabs" id="smsTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="application_form-tab" style="color: black !important;" data-bs-toggle="tab" data-bs-target="#application_form" type="button" role="tab">Application Form</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="application_list-tab" style="color: black !important;" data-bs-toggle="tab" data-bs-target="#application_list" type="button" role="tab">Application list</button>
    </li>
</ul>

<div class="tab-content mt-3" id="smsTabContent">
    <!-- Send SMS Tab -->
    <div class="tab-pane fade show active" id="application_form" role="tabpanel">
        <form id="smsForm" method="POST" action="{{ route('central-application.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row mb-2">
                <div class="form-group col-4">
                    <label>Project * </label>
                    <div class="col-sm-10">
                        <select name="project_id" id="project_id" class="form-control c-select" required>
                                <option value="">- - Select Project - -</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" data-project_id="{{ $project->id }}"
                                        {{ old('project_id') == $project->id ? 'selected' : '' }} >
                                        {{ $project->title_en }}
                                    </option>
                                @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group col-4" id="flat_section">
                    <label>Flat *</label>
                    <div class="col-sm-10">
                        <select class="form-control c-select" id="flat_id" name="flat_id" required>
                            <option selected disabled>Select Flat</option>
                        </select>
                    </div>
                    @error('flat_id')
                        <small class="text-white">{{ $message }}</small>   
                    @enderror
                </div>
                <div class="form-group col-4 mb-3">
                    <label>Subject *</label>
                    <select name="subject_id" id="subject_id" class="form-control" required>
                        <option value="all">-- Subject --</option>
                        @foreach($applicationSubjects as $applicationSubject)
                            <option value="{{ $applicationSubject->id }}">
                                {{ $applicationSubject->subject }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('subject_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group mb-1">
                <label>Application Body</label>
                <textarea id="application_body" name="application_body" rows="5" class="form-control" placeholder="Type your message within 250 words..."></textarea>
                <div class="text-muted mt-1" id="wordCount">0 / 250 words</div>
            </div>

            @error('application_body')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <div class="form-group mb-3">
                <label>Attachments (Optional)</label>

                <input type="file"
                    name="attachments[]"
                    id="attachments"
                    class="form-control"
                    multiple
                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">

                <small class="text-muted">
                    You can upload multiple files (PDF, DOC, JPG, PNG). Max 5MB per file.
                </small>
                <div class="text-danger mt-1 d-none" id="attachmentError"></div>
            </div>

            @error('attachments')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror

            @error('attachments.*')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <div class="text-end">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-paper-plane"></i> Send Application
                </button>
            </div>
        </form>
    </div>

    <!-- SMS History Tab -->
    <div class="tab-pane fade" id="application_list" role="tabpanel">
        <table class="table table-bordered" id="applicaton-list-table">
            <thead>
                <tr>
                    <th>Sl No</th>
                    <th>Subject</th>
                    <th>Body</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Preview</th>
                </tr>
            </thead>
            <tbody>
                @php
                $key = 1;
                @endphp
                @foreach($applicationdata as $data)
                <tr>
                    <td>{{ $key++ }}</td>
                    <td>{{ $data->subject->subject }}</td>

                    <td>
                        <div class="application-preview">
                            {!! $data->body !!}
                        </div>
                    </td>

                    <td>{{ ucfirst($data->status) }}</td>
                    <td>{{ $data->created_at->format('d M Y, h:i A') }}</td>

                    <td>
                        <button
                            class="btn btn-sm btn-primary preview-btn"
                            data-id="{{ $data->id }}"
                            data-project="{{ e($data->project->title_en) }}"
                            data-flat="{{ e($data->flat->flat_name) }}"
                            data-subject="{{ e($data->subject->subject) }}"
                            data-body="{{ base64_encode($data->body) }}"
                            data-date="{{ $data->created_at->format('d M Y, h:i A') }}"
                            data-status="{{ ucfirst($data->status) }}"
                            data-feedback='@json($data->feedbacks)'
                            data-attachments='@json($data->attachments)'
                        >
                            👁 Preview
                        </button>
                    </td>
                </tr>
                @endforeach
                @include('user-dashboard.application-preview')
            </tbody>
        </table>
    </div>
</div>
@push('scripts')
<script>
    window.priceData = @json($priceJsData);
</script>

<script>
    $(document).ready(function () {

        $('#project_id').on('change', function () {

            let projectId = $(this).val();
            let $flat = $('#flat_id');

            $flat.html('<option value="">Select Flat</option>');

            if (!projectId) return;

            // filter flats for selected project
            let flats = window.priceData.filter(item => item.project_id == projectId);

            // remove duplicate flats (important)
            let uniqueFlats = {};
            flats.forEach(f => uniqueFlats[f.flat_id] = f);

            Object.values(uniqueFlats).forEach(flat => {
                $flat.append(
                    `<option value="${flat.flat_id}">${flat.flat_title}</option>`
                );
            });
        });

    });

    function formatDate(dateString) {
        const date = new Date(dateString);

        return date.toLocaleString('en-GB', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        });
    }
    $(document).on('click', '.preview-btn', function () {

        // Base64 decode the body
        const encodedBody = $(this).attr('data-body');
        let decodedBody = '';

        try {
            decodedBody = atob(encodedBody);
        } catch(e) {
            console.error('Failed to decode body:', e);
            decodedBody = $(this).attr('data-body'); // fallback
        }

        // Set main fields
        $('#previewProject').text($(this).data('project'));
        $('#previewFlat').text($(this).data('flat'));
        $('#previewSubject').text($(this).data('subject'));
        $('#previewDate').text($(this).data('date'));
        $('#status').text($(this).data('status'));

        // Set body HTML
        const $preview = $('#previewBody');
        $preview.empty();       // clear previous
        $preview.append(decodedBody);  // append decoded HTML

        // Current auth user ID
        window.authUserId = {{ auth()->guard('user')->id() }};

        // Set hidden input for feedback form (if exists)
        let appId = $(this).data('id');
        $('#feedbackApplicationId').val(appId);

        // Render feedbacks
        let feedbacks = $(this).data('feedback');
        let feedbackHtml = '';

        if (feedbacks && feedbacks.length > 0) {
            feedbacks.forEach(function (item) {
                const isOwn = item.created_by == window.authUserId;

                feedbackHtml += `
                    <div class="feedback-row ${isOwn ? 'feedback-right' : 'feedback-left'}">
                        <div class="feedback-bubble ${isOwn ? 'feedback-user' : 'feedback-admin'}">
                            <strong>${item.feedback_creator?.first_name ?? 'Admin'}</strong>
                            <br>
                            <small class="text-muted">${formatDate(item.created_at)}</small>
                            <div style="margin-top:6px;">${item.feedback}</div>
                        </div>
                    </div>
                `;
            });

            $('#previewFeedback').html(feedbackHtml);
            $('#feedbackSection').show();
        } else {
            $('#previewFeedback').hide();
            $('#feedbackSection').hide();
        }
        
        // 🔹 Attachments
        let attachments = $(this).data('attachments');
        const $attachSection = $('#attachmentSection');
        const $attachList = $('#attachmentList');
        $attachList.empty();

        if (attachments && attachments.length > 0) {
            attachments.forEach(function(att) {
                const url = `{{ asset('uploads') }}/${att.file_path}`;
                const ext = att.file_name.split('.').pop().toLowerCase();
                const isImage = ['jpg','jpeg','png','gif'].includes(ext);

                if (isImage) {
                    $attachList.append(`
                        <li>
                            <a href="#" class="attachment-preview" data-url="${url}" data-name="${att.file_name}">
                                ${att.file_name}
                            </a>
                        </li>
                    `);
                } else {
                    $attachList.append(`
                        <li>
                            <a href="${url}" target="_blank">${att.file_name}</a>
                        </li>
                    `);
                }
            });
            $attachSection.show();
        } else {
            $attachSection.hide();
        }

        // Image preview modal
        $('.attachment-preview').on('click', function(e) {
            e.preventDefault();
            $('#attachmentPreviewTitle').text($(this).data('name'));
            $('#attachmentPreviewImage').attr('src', $(this).data('url'));
            $('#attachmentPreviewModal').modal('show');
        });

        // Show modal after everything is ready
        $('#applicationPreviewModal').modal('show');

    });

    let applicationEditor; // global editor instance
    const maxWords = 250;

    // ===============================
    // CKEDITOR INIT
    // ===============================
    ClassicEditor
        .create(document.querySelector('#application_body'))
        .then(editor => {
            applicationEditor = editor;

            const counter = document.getElementById('wordCount');

            editor.model.document.on('change:data', () => {
                let text = editor.getData()
                    .replace(/<[^>]*>/g, '')
                    .trim();

                let words = text.split(/\s+/).filter(w => w.length > 0);

                if (words.length > maxWords) {
                    let trimmed = words.slice(0, maxWords).join(' ');
                    editor.setData(trimmed);
                    words = trimmed.split(/\s+/);
                }

                counter.innerText = words.length + ' / ' + maxWords + ' words';
            });
        })
        .catch(error => {
            console.error(error);
        });


    $('#subject_id').on('change', function () {
        let subjectId = $(this).val();
        if (!subjectId) {
            setEditorData('');
            return;
        }

        $.ajax({
            url: '/application-subject/' + subjectId + '/body',
            type: 'GET',
            success: function (response) {
                setEditorData(response.body);
            },
            error: function () {
                alert('Failed to load subject body');
            }
        });
    });

    function setEditorData(data) {
        if (!applicationEditor) return;

        if (data === null || data === undefined || data.trim() === '') {
            applicationEditor.setData('');
            return;
        }

        applicationEditor.setData(data);
    }


</script>
<script>
document.getElementById('attachments').addEventListener('change', function () {

    const allowedExtensions = ['pdf','doc','docx','jpg','jpeg','png'];
    const maxSize = 5 * 1024 * 1024; 
    const errorDiv = document.getElementById('attachmentError');

    errorDiv.classList.add('d-none');
    errorDiv.innerHTML = '';

    for (let i = 0; i < this.files.length; i++) {

        const file = this.files[i];
        const fileSize = file.size;
        const fileName = file.name;
        const fileExt = fileName.split('.').pop().toLowerCase();

        // Size validation
        if (fileSize > maxSize) {
            errorDiv.innerHTML = `❌ "${fileName}" is larger than 5MB`;
            errorDiv.classList.remove('d-none');
            this.value = '';
            return;
        }

        //  Extension validation
        if (!allowedExtensions.includes(fileExt)) {
            errorDiv.innerHTML = `❌ "${fileName}" format is not allowed`;
            errorDiv.classList.remove('d-none');
            this.value = '';
            return;
        }
    }
});
</script>
@if(session('success'))
    <script>
        toastr.success("{{ session('success') }}", "Success", {
            closeButton: true,
            progressBar: true,
            timeOut: 4000,
            positionClass: "toast-top-right"
        });
    </script>
@endif

@if(session('error'))
    <script>
        toastr.error("{{ session('error') }}", "Error", {
            closeButton: true,
            progressBar: true,
            timeOut: 4000,
            positionClass: "toast-top-right"
        });
    </script>
@endif
@endpush
<style>
.ck-editor__editable_inline {
    min-height: 300px; 
}
.application-preview {
    max-height: 90px;              
    overflow: hidden;
    position: relative;
}
.application-preview::after {
    content: ".......";
    position: absolute;
    bottom: 0;
    right: 0;
    background: white;
    padding-left: 10px;
}

.feedback-row {
    display: flex;
    margin-bottom: 12px;
}

.feedback-left {
    justify-content: flex-start;
}

.feedback-right {
    justify-content: flex-end;
}

.feedback-bubble {
    max-width: 70%;
    padding: 10px 12px;
    border-radius: 8px;
    font-size: 14px;
}

.feedback-admin {
    background: #f1f1f1;
    border-left: 4px solid #0d6efd;
}

.feedback-user {
    background: #e9f7ef;
    border-right: 4px solid #28a745;
    text-align: right;
}
</style>