<?php
$projects = Helper::Topics(8);
?>
@extends('dashboard.layouts.master')
@section('title', "Add Flat")
@push("after-styles")
    <link href="{{ asset("assets/dashboard/js/iconpicker/fontawesome-iconpicker.min.css") }}" rel="stylesheet">
    <link href="{{ asset("assets/dashboard/js/jquery-ui/jquery-ui.min.css") }}" rel="stylesheet">
    <link href="{{ asset("assets/dashboard/js/tags-input/tagsinput.min.css") }}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
@endpush
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3><i class="material-icons">&#xe02e;</i> Add Flat</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                    <a href="{{ route('flats.create') }}">Add Flat</a> /
                    <a href="{{ route('flats') }}">List of Flats</a>
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
                {{Form::open(['route'=>['flats.store'],'method'=>'POST','files'=>true])}}
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">Projects *</label>
                        <div class="col-sm-10">
                            <select name="project_id" id="project_id" class="form-control c-select" required>
                                <option value="">- - Select Project - -</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" data-project_id="{{ $project->id }}"
                                        {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                        {{ $project->title_en }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">Flat Name*</label>
                        <div class="col-sm-10">
                            {!! Form::text('flat_name', null, array('id' => 'flat_name', 'placeholder' => 'Enter Flat Name','class' => 'form-control form-flat-names','required'=>'true')) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">Flat Size *</label>
                        <div class="col-sm-10">
                            {!! Form::text('flat_size', null, array('id' => 'flat_size', 'placeholder' => 'Enter Flat Size','class' => 'form-control','required'=>'true')) !!}
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

                {{Form::close()}}
            </div>
        </div>
    </div>
@endsection
@push("after-scripts")
    <script src="{{ asset("assets/dashboard/js/iconpicker/fontawesome-iconpicker.js") }}"></script>
    <script src="{{ asset("assets/dashboard/js/jquery-ui/jquery-ui.min.js") }}"></script>
    <script src="{{ asset("assets/dashboard/js/tags-input/tagsinput.min.js") }}"></script>

    <script>
        $('.form-flat-names').tagsInput({
            placeholder: 'Type Flat Names',
            width: '100%',
            height: 'auto',
            defaultText: '',
            delimiter: [','],
        });
    </script>
@endpush
