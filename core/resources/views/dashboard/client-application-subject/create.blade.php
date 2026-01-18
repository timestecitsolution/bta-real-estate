<?php
$projects = Helper::Topics(8);
?>
@extends('dashboard.layouts.master')
@section('title', "Create Application Subject")
@push("after-styles")
    <link href="{{ asset("assets/dashboard/js/iconpicker/fontawesome-iconpicker.min.css") }}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
@endpush
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3><i class="material-icons">&#xe02e;</i> Application Subject</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                    <a href="{{ route('client-application-subject.create') }}">Add Application Subject</a> /
                    <a href="{{ route('client-application-subject') }}">List of Application Subjects</a>
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
            <div class="box-body p-a-2">
                    {{Form::open(['route'=>['client-application-subject.store'],'method'=>'POST','files'=>true])}}
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Application Subject *</label>
                            <div class="col-sm-10">
                                {!! Form::text('application_subject', null, array('id' => 'application_subject', 'placeholder' => 'Enter Application Subject','class' => 'form-control','required'=>'true')) !!}
                            </div>
                        </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">
                            Application Body
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
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">
                            Type <span class="text-danger">*</span>
                        </label>

                        <div class="col-sm-10">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="notice" value="notice" required>
                                <label class="form-check-label" for="notice">
                                    Notice
                                </label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="application" value="application" required>
                                <label class="form-check-label" for="application">
                                    Application
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row m-t-md">
                        <div class="offset-sm-2 col-sm-10"> 
                            <button type="submit" class="btn btn-lg btn-primary m-t"><i class="material-icons">
                                    &#xe31b;</i> {!! __('backend.add') !!}</button>
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
    ClassicEditor
        .create(document.querySelector('#application_body'))
        .then(editor => {
            const maxWords = 250;
            const counter = document.getElementById('wordCount');

            editor.model.document.on('change:data', () => {
                let text = editor.getData().replace(/<[^>]*>/g, '').trim();
                let words = text.split(/\s+/).filter(w => w.length > 0);
                
                if(words.length > maxWords){
                    // Trim content to maxWords
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
    </script>
@endpush
