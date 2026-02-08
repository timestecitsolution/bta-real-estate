<?php
$projects = Helper::Topics(8);
?>
@extends('dashboard.layouts.master')
@section('title', "Edit Flat")

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
            <h3><i class="material-icons">&#xe3c9;</i> Edit Flats</h3>
            <small>
                <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                <a>Edit Flats</a>
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
            {{ Form::model($flat, ['route' => ['flats.update', $flat->id], 'method' => 'POST', 'files' => true, 'id'=>'flatForm']) }}
            {{-- Project --}}
            <div class="form-group row">
                <label class="col-sm-2 form-control-label">Projects *</label>
                <div class="col-sm-10">
                    <select name="project_id" id="project_id" class="form-control c-select" required>
                        <option value="">-- Select Project --</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" data-project_id="{{ $project->id }}"
                                {{ (old('project_id', $flat->project->id) == $project->id) ? 'selected' : '' }}>
                                {{ $project->title_en }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- Flat Name --}}
            <div class="form-group row">
                <label class="col-sm-2 form-control-label">Flat Name *</label>
                <div class="col-sm-10">
                    {!! Form::text('flat_name', old('flat_name', $flat->flat_name), ['id'=>'flat_name','class'=>'form-control']) !!}
                </div>
            </div>
            {{-- Flat Size --}}
            <div class="form-group row">
                <label class="col-sm-2 form-control-label">Flat Size *</label>
                <div class="col-sm-10">
                    {!! Form::text('flat_size', old('flat_size', $flat->flat_size), ['id'=>'flat_size','class'=>'form-control']) !!}
                </div>
            </div>
            <div class="form-group row m-t-md">
                <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-lg btn-primary m-t">
                        <i class="material-icons">&#xe3c9;</i> Update
                    </button>
                    <a href="{{ route('price') }}" class="btn btn-lg btn-default m-t">
                        <i class="material-icons">&#xe5cd;</i> Cancel
                    </a>
                </div>
            </div>

            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection

@push("after-scripts")
<script src="{{ asset("assets/dashboard/js/iconpicker/fontawesome-iconpicker.js") }}"></script>
@endpush
