<?php
$projects = Helper::Topics(8);
?>
@extends('dashboard.layouts.master')
@section('title', "Create Notice")
@push("after-styles")
    <link href="{{ asset("assets/dashboard/js/iconpicker/fontawesome-iconpicker.min.css") }}" rel="stylesheet">
@endpush
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3><i class="material-icons">&#xe02e;</i> Client Notice</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                    <a href="{{ route('client-notice.create') }}">Create Notice</a> /
                    <a href="{{ route('client-notice') }}">List of Notices</a>
                </small>
            </div>
            <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline">
                        <a class="nav-link" href="{{ route('client-notice') }}">
                            <i class="material-icons md-18">×</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="box-body p-a-2">
                    {{Form::open(['route'=>['client-notice.store'],'method'=>'POST','files'=>true])}}
                    <div class="form-group row">
                        <label for="customer_id" class="col-sm-2 form-control-label">Client/Landlord *</label>
                        <div class="col-sm-10">
                            <select name="customer_id" id="customer_id" class="form-control c-select select2" required>
                                <option value="0">- - Select Client/Landlord - -</option>
                                @foreach ($contacts as $contact)
                                    <option value="{{ $contact->id  }}" {{ old('customer_id') == $contact->id ? 'selected' : '' }}>{{ $contact->first_name . ' ' . $contact->last_name . ' (' . $contact->phone  . ')' }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Subject *</label>
                        <div class="col-sm-10">
                            <select name="subject_id" id="subject_id" class="form-control" required>
                                <option value="all">-- Subject --</option>
                                @foreach($applicationSubjects as $applicationSubject)
                                    <option value="{{ $applicationSubject->id }}">
                                        {{ $applicationSubject->subject }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">
                            Body
                        </label>

                        <div class="col-sm-10">
                            <textarea
                                id="application_body"
                                name="application_body"
                                rows="6"
                                class="form-control"
                                placeholder="Type your message within 250 words..."></textarea>

                            <div class="text-muted mt-1" id="wordCount">
                                0 / 250 words
                            </div>
                        </div>
                    </div>
                    <div class="form-group row m-t-md">
                        <div class="offset-sm-2 col-sm-10"> 
                            <button type="submit" class="btn btn-lg btn-primary m-t"><i class="material-icons">
                                    &#xe31b;</i> Create</button>
                            <a href="{{ route('price') }}"
                            class="btn btn-lg btn-default m-t"><i class="material-icons">
                                    &#xe5cd;</i> {!! __('backend.cancel') !!}</a>
                        </div>
                    </div>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
@endsection
@push("after-scripts")
<style>
    .ck-editor__editable_inline {
        min-height: 300px; 
    }
</style>
<script src="{{ asset("assets/dashboard/js/iconpicker/fontawesome-iconpicker.js") }}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
<script>
    let applicationEditor; 
    const maxWords = 250;

    // ===============================
    // CKEDITOR INIT
    // ===============================
    ClassicEditor.create(document.querySelector('#application_body'))
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
            applicationEditor.setData('<p>Dear <strong>BTA,</strong></p>');
            return;
        }

        applicationEditor.setData(data);
    }
</script>
@endpush
