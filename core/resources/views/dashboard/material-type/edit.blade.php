@extends('dashboard.layouts.master')
@section('title', "Edit Material Type")

@push("after-styles")
<link href="{{ asset("assets/dashboard/js/iconpicker/fontawesome-iconpicker.min.css") }}" rel="stylesheet">
@endpush

@section('content')
<div class="padding">
    <div class="box">
        <div class="box-header dker">
            <h3><i class="material-icons">&#xe3c9;</i> Edit Material Type</h3>
            <small>
                <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                <a>Edit Material Type</a>
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
            {{ Form::model($materialType, ['route' => ['material-type.update', $materialType->id], 'method' => 'POST', 'files' => true, 'id'=>'materialTypeForm']) }}

            {{-- Material Type --}}
            <div class="form-group row">
                <label class="col-sm-2 form-control-label">Material Type</label>
                <div class="col-sm-10">
                    {!! Form::text('material_type', old('material_type', $materialType->material_type), ['id'=>'material_type','class'=>'form-control']) !!}
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
