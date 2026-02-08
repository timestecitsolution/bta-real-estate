<?php
$projects = Helper::Topics(8);
?>
@extends('dashboard.layouts.master')
@section('title', "Flat Booking")
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
                <h3><i class="material-icons">&#xe02e;</i> Add Booking</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                    <a>Add Booking</a> /
                    <a>List of Bookings</a>
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
                {{Form::open(['route'=>['price.store'],'method'=>'POST','files'=>true])}}
                    <div class="form-group row">
                        <label for="customer_id" class="col-sm-2 form-control-label">Customer *</label>
                        <div class="col-sm-10">
                            <select name="customer_id" id="customer_id" class="form-control c-select" required>
                                <option value="0">- - Select Customer - -</option>
                                @foreach ($contacts as $contact)
                                    <option value="{{ $contact->id  }}" {{ old('customer_id') == $contact->id ? 'selected' : '' }}>{{ $contact->first_name . ' ' . $contact->last_name . ' (' . $contact->phone  . ')' }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="project_id" class="col-sm-2 form-control-label">Project * </label>
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
                    <div id="flat-wrapper">
                        <div class="flat-details-wrapper card" style="border: 1px solid #ccc;  border-radius: 5px; padding: 20px;">
                            <h5 class="flat-title mb-3">Flat Details 1: </h5>
                            <div class="form-group row" id="flat_section">
                                <label for="flat_id" class="col-sm-2 form-control-label">Flat *</label>
                                <div class="col-sm-10">
                                    <select class="form-control flat-select c-select" id="flat_id" name="flat_id[]" required>
                                        <option selected disabled>Select Flat</option>
                                    </select>
                                </div>
                                @error('flat_id')
                                    <small class="text-white">{{ $message }}</small>   
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label">Flat Size *</label>
                                <div class="col-sm-10">
                                    {!! Form::number('flat_size', old('flat_size'), [
                                        'id' => 'flat_size',
                                        'placeholder' => 'Enter Flat Size (Per Sq.ft)',
                                        'class' => 'form-control flat_size',
                                        'required' => true
                                    ]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label">Is Negotiate Total Price?</label>
                                <div class="col-sm-10">
                                    {!! Form::Checkbox('is_negotiable_total_price', 1, old('is_negotiable_total_price'),
                                        [
                                            'id' => 'is_negotiate_total_price',
                                            'class' => 'is_negotiate_total_price'
                                        ]) !!}
                                </div>
                            </div>

                            <div class="form-group row price_per_sqft_group" id="price_per_sqft_group">
                                <label class="col-sm-2 form-control-label">Price Per Sq.ft *</label>
                                <div class="col-sm-10">
                                    {!! Form::number('price_per_sqft', old('price_per_sqft'), [
                                        'placeholder' => 'Price Per Sq.ft',
                                        'class' => 'form-control price_per_sqft',
                                        'required' => true
                                    ]) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label">Is Applicable for Govt Gas?</label>
                                <div class="col-sm-10">
                                    {!! Form::checkbox('is_applicable_govt_gas', 1, old('is_applicable_govt_gas'), [
                                        'id' => 'is_applicable_govt_gas',
                                        'class' => 'is_applicable_govt_gas'
                                    ]) !!}
                                </div>
                            </div>

                            <div class="form-group row is_govt_gas_connection_paid_group" id="is_govt_gas_connection_paid_group">
                                <label class="col-sm-2 form-control-label">Is Govt Gas Connection Paid?</label>
                                <div class="col-sm-10">
                                    {!! Form::Checkbox('is_govt_gas_connection_paid', 1, old('is_govt_gas_connection_paid'),
                                        [
                                            'id' => 'is_govt_gas_connection_paid',
                                            'class' => 'is_govt_gas_connection_paid'
                                        ]) !!}
                                </div>
                            </div>

                            <div class="form-group row gas_pay_scheme" id="gas_pay_scheme">
                                <label class="col-sm-2 form-control-label">Select Payment Scheme For Gas *</label>
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        {!! Form::radio('govt_gas_connection_payment_scheme', 'downpayment', old('govt_gas_connection_payment_scheme') == 'downpayment', ['id' => 'gas_downpayment', 'class' => 'form-check-input gas_downpayment']) !!}
                                        <label class="form-check-label" for="gas_downpayment">Including with Downpayment</label>
                                    </div>

                                    <div class="form-check">
                                        {!! Form::radio('govt_gas_connection_payment_scheme', 'emi', old('govt_gas_connection_payment_scheme') == 'emi', ['id' => 'gas_emi', 'class' => 'form-check-input gas_emi']) !!}
                                        <label class="form-check-label" for="gas_emi">Including with EMI</label>
                                    </div>
                                    <div class="form-check">
                                        {!! Form::radio('govt_gas_connection_payment_scheme', 'handover', old('govt_gas_connection_payment_scheme') == 'handover', ['id' => 'gas_pay_scheme_others', 'class' => 'form-check-input gas_pay_scheme_others']) !!}
                                        <label class="form-check-label" for="gas_pay_scheme_others">Others</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row gas_amount_group" id="gas_amount_group">
                                <label class="col-sm-2 form-control-label">Gas Connection Fee *</label>
                                <div class="col-sm-10">
                                    {!! Form::number('gas_amount', old('gas_amount'), [
                                        'id' => 'gas_amount',
                                        'placeholder' => 'Gas Connection Fee',
                                        'class' => 'form-control gas_amount'
                                    ]) !!}
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label">Is Applicable for Parking?</label>
                                <div class="col-sm-10">
                                    {!! Form::Checkbox('is_applicable_parking', 1, old('is_applicable_parking'), 
                                        ['id' => 'is_applicable_parking', 'class' => 'is_applicable_parking']) !!}
                                </div>
                            </div>

                            <div class="form-group row is_parking_paid_group" id="is_parking_paid_group">
                                <label class="col-sm-2 form-control-label">Is Parking Paid?</label>
                                <div class="col-sm-10">
                                    {!! Form::Checkbox('is_parking_paid', 1, old('is_parking_paid'), 
                                        ['id' => 'is_parking_paid', 'class' => 'is_parking_paid']) !!}
                                </div>
                            </div>

                            <div class="form-group row parking_pay_scheme" id="parking_pay_scheme">
                                <label class="col-sm-2 form-control-label">Select Payment Scheme For Parking *</label>
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        {!! Form::radio('parking_payment_scheme', 'downpayment', old('parking_payment_scheme') == 'downpayment', false, ['id' => 'parking_downpayment', 'class' => 'form-check-input']) !!}
                                        <label class="form-check-label" for="parking_downpayment">Including with Downpayment</label>
                                    </div>

                                    <div class="form-check">
                                        {!! Form::radio('parking_payment_scheme', 'emi', old('parking_payment_scheme') == 'emi', false, ['id' => 'parking_emi', 'class' => 'form-check-input']) !!}
                                        <label class="form-check-label" for="parking_emi">Including with EMI</label>
                                    </div>

                                    <div class="form-check">
                                        {!! Form::radio('parking_payment_scheme', 'others', old('parking_payment_scheme') == 'others', false, ['id' => 'parking_others', 'class' => 'form-check-input']) !!}
                                        <label class="form-check-label" for="parking_others">Others</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row parking_fee_group" id="parking_fee_group">
                                <label class="col-sm-2 form-control-label">Parking Fee *</label>
                                <div class="col-sm-10">
                                    {!! Form::number('parking_amount', old('parking_amount'), [
                                        'id' => 'parking_amount',
                                        'placeholder' => 'Parking Fee',
                                        'class' => 'form-control parking_amount'
                                    ]) !!}
                                </div>
                            </div>
                            

                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label">Is Utility Included?</label>
                                <div class="col-sm-10">
                                    {!! Form::Checkbox('is_utility_included', 1, old('is_utility_included'), 
                                        ['id' => 'is_utility_included', 'class' => 'is_utility_included']) !!}
                                </div>
                            </div>

                            <div class="form-group row utility_pay_scheme" id="utility_pay_scheme">
                                <label class="col-sm-2 form-control-label">Select Payment Scheme For Utility *</label>
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        {!! Form::radio('utility_payment_scheme', 'downpayment', old('utility_payment_scheme') == 'downpayment', ['id' => 'utility_downpayment', 'class' => 'form-check-input']) !!}
                                        <label class="form-check-label" for="utility_downpayment">Including with Downpayment</label>
                                    </div>

                                    <div class="form-check">
                                        {!! Form::radio('utility_payment_scheme', 'emi', old('utility_payment_scheme') == 'emi', ['id' => 'utility_emi', 'class' => 'form-check-input']) !!}
                                        <label class="form-check-label" for="utility_emi">Including with EMI</label>
                                    </div>

                                    <div class="form-check">
                                        {!! Form::radio('utility_payment_scheme', 'others', old('utility_payment_scheme') == 'others', ['id' => 'utility_others', 'class' => 'form-check-input']) !!}
                                        <label class="form-check-label" for="utility_others">Others</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row utility_amount_group" id="utility_amount_group">
                                <label class="col-sm-2 form-control-label">Utility Fee *</label>
                                <div class="col-sm-10">
                                    {!! Form::number('utility_amount', old('utility_amount'), [
                                        'id' => 'utility_amount',
                                        'placeholder' => 'Utility Fee',
                                        'class' => 'form-control utility_amount'
                                    ]) !!}
                                </div>
                            </div>

                            <div class="form-group row extras_group" id="extras" style="display: none;">
                                <label class="col-sm-2 form-control-label">Extras (Auto Calculate)</label>
                                <div class="col-sm-10">
                                    {!! Form::number('extras_amount', old('extras_amount'), [
                                        'id' => 'extras_amount',
                                        'placeholder' => 'Extra Amount(Gas, Utility, Parking, Others)',
                                        'class' => 'form-control extras_amount',
                                        'readonly' => true
                                    ]) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label">Is Application Discount?</label>
                                <div class="col-sm-10">
                                    {!! Form::Checkbox('is_discount_applicable', 1, old('is_discount_applicable'), 
                                        ['id' => 'is_discount_applicable', 'class' => 'is_discount_applicable']) !!}
                                </div>
                            </div>

                            <div class="form-group row discount_amount_group" id="discount_amount_group" style="display: none;">
                                <label class="col-sm-2 form-control-label">Discounted Amount *</label>
                                <div class="col-sm-10">
                                    {!! Form::number('discount_amount', old('discount_amount'), [
                                        'id' => 'discount_amount',
                                        'placeholder' => 'Discounted Amount',
                                        'class' => 'form-control discount_amount'
                                    ]) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label">Total Price (Flat) *</label>
                                <div class="col-sm-10">
                                    {!! Form::number('price', old('price'), [
                                        'id' => 'total_price_flat',
                                        'placeholder' => 'Total Price',
                                        'class' => 'form-control total_price_flat'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="document-wrapper">
                            @if(old('document_type_id'))
                                @foreach(old('document_type_id') as $i => $docTypeId)
                                    <div class="form-group row document-item">
                                        @if($i == 0)
                                            <label class="col-sm-2 form-control-label">Documents</label>
                                        @else
                                            <label class="col-sm-2 form-control-label">&nbsp;</label>
                                        @endif

                                        <div class="col-sm-4">
                                            <select name="document_type_id[]" class="form-control c-select">
                                                <option value="">- - Select Document Type - -</option>
                                                @foreach($documentTypes as $documentType)
                                                    <option value="{{ $documentType->id }}"
                                                        {{ $docTypeId == $documentType->id ? 'selected' : '' }}>
                                                        {{ $documentType->document_type }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-sm-4">
                                            {!! Form::file('document[]', [
                                                'class' => 'form-control',
                                                'accept' => 'application/pdf,image/*'
                                            ]) !!}
                                        </div>

                                        <div class="col-sm-2">
                                            @if($i == 0)
                                                <button type="button" class="btn btn-success add-doc">+</button>
                                            @else
                                                <button type="button" class="btn btn-danger remove-doc">-</button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <!-- Default first row if no old input -->
                                <div class="form-group row document-item">
                                    <label class="col-sm-2 form-control-label">Documents(Max 10MB- pdf,jpg,jpeg,png)</label>
                                    <div class="col-sm-4">
                                        <select name="document_type_id[]" class="form-control c-select">
                                            <option value="">-- Select Document Type --</option>
                                            @foreach($documentTypes as $documentType)
                                                <option value="{{ $documentType->id }}">{{ $documentType->document_type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        {!! Form::file('document[]', [
                                            'class' => 'form-control',
                                            'accept' => 'application/pdf,image/*'
                                        ]) !!}
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="button" class="btn btn-success add-doc">+</button>
                                    </div>
                                </div>
                            @endif
                            </div>


                            <div id="material-wrapper">

                                @if(old('material_type_id'))
                                    @foreach(old('material_type_id') as $i => $matId)
                                        <div class="form-group row material-item">

                                            @if($i == 0)
                                                <label class="col-sm-2 form-control-label">Materials</label>
                                            @else
                                                <label class="col-sm-2 form-control-label">&nbsp;</label>
                                            @endif

                                            <div class="col-sm-4">
                                                <select name="material_type_id[]" class="form-control material-type">
                                                    <option value="">-- Select Material --</option>
                                                    @foreach($materialTypes as $material)
                                                        <option value="{{ $material->id }}"
                                                            {{ $material->id == $matId ? 'selected' : '' }}>
                                                            {{ $material->material_type }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-sm-4">
                                                <input type="text" 
                                                    name="material_details[]" 
                                                    class="form-control"
                                                    placeholder="Material Details"
                                                    value="{{ old('material_details')[$i] ?? '' }}">
                                            </div>

                                            <div class="col-sm-2">
                                                @if($i == 0)
                                                    <button type="button" class="btn btn-success add-material">+</button>
                                                @else
                                                    <button type="button" class="btn btn-danger remove-material">-</button>
                                                @endif
                                            </div>

                                        </div>
                                    @endforeach

                                @else
                                    <!-- Default first row -->
                                    <div class="form-group row material-item">
                                        <label class="col-sm-2 form-control-label">Materials</label>

                                        <div class="col-sm-4">
                                            <select name="material_type_id[]" class="form-control material-type">
                                                <option value="">-- Select Material --</option>
                                                @foreach($materialTypes as $material)
                                                    <option value="{{ $material->id }}">{{ $material->material_type }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="text" 
                                                name="material_details[]" 
                                                class="form-control"
                                                placeholder="Material Details">
                                        </div>

                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-success add-material">+</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="text-right mt-3">
                        <button type="button" id="add-flat" class="btn btn-success">
                            + Add More Flat
                        </button>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">Booking Amount *</label>
                        <div class="col-sm-10">
                            {!! Form::number(
                                'booking_amount', 
                                old('booking_amount'), 
                                [
                                    'id' => 'booking_amount',
                                    'placeholder' => 'Enter Booking Amount',
                                    'class' => 'form-control',
                                    'required',
                                    'dir' => isset($ActiveLanguage) ? $ActiveLanguage->direction : 'ltr'
                                ]
                            ) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">Downpayment Amount *</label>
                        <div class="col-sm-10">
                            {!! Form::number(
                                'downpayment_amount', old('downpayment_amount'), 
                                [
                                    'id' => 'downpayment_amount',
                                    'placeholder' => 'Enter Downpayment Amount',
                                    'class' => 'form-control',
                                    'required',
                                    'dir' => @$ActiveLanguage->direction
                                ]
                            ) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">Due Amount (Auto Calculate)</label>
                        <div class="col-sm-10">
                            {!! Form::number('due_amount', old('due_amount'), 
                                array('id' => 'due_amount', 
                                'placeholder' => 'Enter Due Amount',
                                'class' => 'form-control',
                                'required',
                                'dir' => @$ActiveLanguage->direction,
                                'readonly')) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">EMI Amount (Per Month) *</label>
                        <div class="col-sm-10">
                            {!! Form::number('emi', old('emi'), 
                                array(
                                    'id' => 'emi_amount', 
                                    'placeholder' => 'Enter EMI Amount (Per Month)',
                                    'class' => 'form-control',
                                    'required',
                                    'dir'=>@$ActiveLanguage->direction
                                )) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">EMI Count (Auto Calculate) *</label>
                        <div class="col-sm-10">
                            {!! Form::number('emi_count', old('emi_count'), array('id' => 'emi_count', 'placeholder' => 'Enter EMI Count','class' => 'form-control','required'=>'','maxlength'=>2, 'dir'=>@$ActiveLanguage->direction,'readonly')) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">EMI Start Date *</label>
                        <div class="col-sm-10">
                            {!! Form::date('emi_start_date', old('emi_start_date'), array('id' => 'emi_start_date', 'placeholder' => 'Enter EMI Start Date','class' => 'form-control','required'=>'true', 'dir'=>@$ActiveLanguage->direction)) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">Is Applicable Discount on Total?</label>
                        <div class="col-sm-10">
                            {!! Form::Checkbox('is_discount_applicable_total', 1, old('is_discount_applicable_total'), 
                                ['id' => 'is_discount_applicable_total', 'class' => 'is_discount_applicable_total']) !!}
                        </div>
                    </div>

                    <div class="form-group row" id="discount_amount_group_total">
                        <label class="col-sm-2 form-control-label">Discounted Amount *</label>
                        <div class="col-sm-10">
                            {!! Form::number('discount_amount_total', old('discount_amount_total'), [
                                'id' => 'discount_amount_total',
                                'placeholder' => 'Discounted Amount on Total Price',
                                'class' => 'form-control'
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">Total Price (Auto Calculate) *</label>
                        <div class="col-sm-10">
                            {!! Form::number('price', old('price'), [
                                'id' => 'total_price',
                                'placeholder' => 'Total Price',
                                'class' => 'form-control'
                            ]) !!}
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
    <script>
        $(function () {
            $('.icp-auto').iconpicker({placement: '{{ (@Helper::currentLanguage()->direction=="rtl")?"topLeft":"topRight" }}'});
        });

        let projectFlats = [];
        $(document).ready(function () {
            $('#project_id').on('change', function () {
                let projectId = $(this).find('option:selected').data('project_id');
                $.ajax({
                    url: "{{ route('get.project.flats') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        project_id: projectId
                    },
                    success: function (response) {
                        let options = '<option selected disabled>Select Flat</option>';
    
                        if (response.flats.length > 0) {
                            response.flats.forEach(function (flat) {
                                projectFlats = response.flats;
                                options += `<option value="${flat.id}">${flat.flat_name}</option>`;
                            });
                            $('#flat_id').html(options);
                        } else {
                            $('#flat_id').html('<option>No flats found</option>');
                        }
                    }
                });
            });

            $(document).on('change', '.flat-select', function () {

                let selectedFlatId = $(this).val();
                let flatCard = $(this).closest('.flat-details-wrapper');

                let flatData = projectFlats.find(f => f.id == selectedFlatId);

                if (flatData) {
                    flatCard.find('.flat_size').val(flatData.flat_size);
                }
            });

        $(document).on('change', '.is_negotiate_total_price', function () {

            let $section = $(this).closest('.flat-details-wrapper');

            if ($(this).is(':checked')) {
                $section.find('.price_per_sqft_group').hide();

                $section.find('.price_per_sqft')
                    .prop('required', false)
                    .val('');

                $section.find('.emi_count, .emi_start_date')
                    .prop('required', false)
                    .val('');

                $section.find('#booking_amount, #downpayment_amount, #due_amount, #emi_amount')
                    .val('');

            } else {

                $section.find('.price_per_sqft_group').show();
                $section.find('.price_per_sqft').prop('required', true);
            }

            calculateFlatTotalPrice($section);
        });

        function toggleGovtGasSection($checkbox) {
            let $section = $checkbox.closest('.flat-details-wrapper');

            if ($checkbox.is(':checked')) {
                $section.find('.is_govt_gas_connection_paid_group').show();
            } else {
                $section.find('.is_govt_gas_connection_paid_group').hide();

                $section.find("input[name='is_govt_gas_connection_paid']")
                    .prop("checked", false)
                    .prop("required", false);

                $section.find("input[name='govt_gas_connection_payment_scheme']")
                    .prop("checked", false)
                    .prop("required", false);

                $section.find(".gas_pay_scheme").hide();
                $section.find(".gas_amount_group").hide();
            }
        }


        $(document).on('change', '.is_applicable_govt_gas', function () {
            toggleGovtGasSection($(this));
        });

        $('.is_applicable_govt_gas').each(function () {
            toggleGovtGasSection($(this));
        });

        function toggleGovtGaspayment($checkbox){
            let $section = $checkbox.closest('.flat-details-wrapper');
            if($checkbox.is(':checked')){
                $section.find(".gas_pay_scheme").show();
                $section.find(".gas_amount_group").show();

                $section.find("input[name='govt_gas_connection_payment_scheme']").prop("required", true);
                $section.find(".gas_amount").prop("required", true);
            }else{
                $section.find(".gas_pay_scheme").hide();
                $section.find(".gas_amount_group").hide();
                $section.find("input[name='govt_gas_connection_payment_scheme']").prop("checked", false).prop("required", false);
                $section.find(".gas_amount").val("").prop("required", false);
            }
        }

        $(document).on('change', '.is_govt_gas_connection_paid', function () {
            toggleGovtGaspayment($(this))
        });

        $('.is_govt_gas_connection_paid').each(function () {
            toggleGovtGaspayment($(this));
        });

        function toggleParkingSection($checkbox) {
            let $section = $checkbox.closest('.flat-details-wrapper');

            if ($checkbox.is(':checked')) {
                $section.find('.is_parking_paid_group').show();
            } else {
                $section.find('.is_parking_paid_group').hide();

                $section.find("input[name='is_parking_paid']")
                    .prop("checked", false)
                    .prop("required", false);

                $section.find("input[name='parking_payment_scheme']")
                    .prop("checked", false)
                    .prop("required", false);

                $section.find(".parking_pay_scheme").hide();
                $section.find(".parking_fee_group").hide();
            }
        }

        $(document).on('change', '.is_applicable_parking' , function () {
            toggleParkingSection($(this));
        });

        $('.is_applicable_parking').each(function () {
            toggleParkingSection($(this));
        });

        function toggleParkingPayment($checkbox){
            let $section = $checkbox.closest('.flat-details-wrapper');
            if($checkbox.is(':checked')){
                $section.find(".parking_pay_scheme").show();
                $section.find(".parking_fee_group").show();
                $section.find("input[name='parking_payment_scheme']").prop("required", true);
                $section.find("#parking_amount").prop("required", true);
            }else{
                $section.find(".parking_pay_scheme").hide();
                $section.find(".parking_fee_group").hide();
                $section.find("input[name='parking_payment_scheme']").prop("checked", false).prop("required", false);
                $section.find("#parking_amount").val("").prop("required", false);
            }
        }

        $(document).on('change', '.is_parking_paid' , function() {
            toggleParkingPayment($(this));
        });

        $('.is_parking_paid').each(function () {
            toggleParkingPayment($(this));
        });

        
        function togglePaymentSchemeForUtility($checkbox) {
            let $section = $checkbox.closest('.flat-details-wrapper');
            if ($checkbox.is(":checked")) {
                $section.find(".utility_pay_scheme").show();
                $section.find(".utility_amount_group").show();

                $section.find("input[name='utility_payment_scheme']").prop("required", true);
                $section.find("#utility_amount").prop("required", true);
            } else {    
                $section.find(".utility_pay_scheme").hide();
                $section.find(".utility_amount_group").hide();  
                
                $section.find("input[name='utility_payment_scheme']").prop("checked", false).prop("required", false);
                $section.find("#utility_amount").val("").prop("required", false);
            }
        }

        $(document).on("change", ".is_utility_included", function () {
            togglePaymentSchemeForUtility($(this));
        });

        $('.is_utility_included').each(function () {
            togglePaymentSchemeForUtility($(this));
        });

        function toggleDiscountField($checked) {
            let $section = $checked.closest('.flat-details-wrapper');
            if ($checked.is(":checked")) {
                $section.find(".discount_amount_group").show();
                $section.find("#discount_amount").prop("required", true);
            } else {    
                $section.find(".discount_amount_group").hide();
                $section.find("#discount_amount").val("").prop("required", false);
            }
        }
        $(document).on("change", ".is_discount_applicable", function () {
            toggleDiscountField($(this));
        });

        $('.is_discount_applicable').each(function () {
            toggleDiscountField($(this));
        });

        function toggleDiscountFieldTotal() {
            if ($("#is_discount_applicable_total").is(":checked")) {
                $("#discount_amount_group_total").show();
                $("#discount_amount_total").prop("required", true);
            } else {    
                $("#discount_amount_group_total").hide();
                $("#discount_amount_total").val("").prop("required", false);
            }
        }



        function calculateFlatTotalPrice($selector) {
            let $section = $selector.closest('.flat-details-wrapper');

            let flatSize = parseFloat($section.find(".flat_size").val()) || 0;
            let pricePerSqft = parseFloat($section.find(".price_per_sqft").val()) || 0;
            let gasAmount = parseFloat($section.find(".gas_amount").val()) || 0;
            let parkingAmount = parseFloat($section.find(".parking_amount").val()) || 0;
            let utilityAmount = parseFloat($section.find(".utility_amount").val()) || 0;
            let discountAmount = parseFloat($section.find(".discount_amount").val()) || 0;
            if (!$section.find(".is_negotiate_total_price").is(":checked")) {
                let total = flatSize * pricePerSqft;

                if ($section.find("input[name='govt_gas_connection_payment_scheme']:checked").length > 0 
                    && $section.find(".is_govt_gas_connection_paid").is(":checked")) {
                    total += gasAmount;
                }

                if ($section.find("input[name='parking_payment_scheme']:checked").length > 0 
                    && $section.find(".is_parking_paid").is(":checked")) {
                    total += parkingAmount;
                }

                if ($section.find("input[name='utility_payment_scheme']:checked").length > 0 
                    && $section.find(".is_utility_included").is(":checked")) {
                    total += utilityAmount;
                }

                if ($section.find(".is_discount_applicable").is(":checked")) {
                    total -= discountAmount;
                }

                if ($section.find("#is_discount_applicable_total").is(":checked")) {
                    let discountAmountTotal = parseFloat($section.find("#discount_amount_total").val()) || 0;
                    total -= discountAmountTotal;
                }


                $section.find(".total_price_flat").val(total);
            } else {
                $section.find(".total_price_flat").val(""); 
            }
        }

        $(document).on("keyup input change", 
            ".flat_size, .price_per_sqft, .gas_amount, .parking_amount, .utility_amount, .flat-select, input[name='govt_gas_connection_payment_scheme'], input[name='parking_payment_scheme'], input[name='utility_payment_scheme'], input[name='is_discount_applicable'], input[name='is_discount_applicable_total'], input[name='discount_amount'], input[name='discount_amount_total'], .is_govt_gas_connection_paid, .is_parking_paid, .is_utility_included", 
            function() {
                calculateFlatTotalPrice($(this));
            }
        );

            // toggleDiscountField();
            toggleDiscountFieldTotal();
            // calculateTotalPrice();


            // $("#is_discount_applicable").change(function () {
            //      toggleDiscountField();
            // });

            $("#is_discount_applicable_total").change(function () {
                 toggleDiscountFieldTotal();
            });

            // $("#flat_size, .price_per_sqft").on("input", function () {
            //     calculateTotalPrice();
            // });

            function updateExtras($selector) {
                let extras = 0;
                let extrasVisible = false;
                let $section = $selector.closest(".flat-details-wrapper");

                if ($section.find(".gas_pay_scheme input[type='radio']:checked").val() === "handover") {
                    let gasAmount = parseFloat($section.find(".gas_amount").val()) || 0;
                    extras += gasAmount;
                    extrasVisible = true;
                }

                if ($section.find(".parking_pay_scheme input[type='radio']:checked").val() === "others") {
                    let parkingAmount = parseFloat($section.find(".parking_amount").val()) || 0;
                    extras += parkingAmount;
                    extrasVisible = true;
                }

                if ($section.find(".utility_pay_scheme input[type='radio']:checked").val() === "others") {
                    let utilityAmount = parseFloat($section.find(".utility_amount").val()) || 0;
                    extras += utilityAmount;
                    extrasVisible = true;
                }

                if (extrasVisible) {
                    console.log("Extras amount: " + extras);
                    $section.find(".extras_group").show();
                    $section.find(".extras_amount").val(extras);
                } else {
                    $section.find(".extras_group").hide();
                    $section.find(".extras_amount").val("");
                }
            }

            $(document).on("keyup input change", ".gas_amount, .parking_amount, .utility_amount, .gas_pay_scheme input[type='radio'], .parking_pay_scheme input[type='radio'], .utility_pay_scheme input[type='radio']", function() {
                updateExtras($(this));
            });

            function calculateDueAmount() {
                let totalPrice = parseFloat($("#total_price").val()) || 0;
                let booking = parseFloat($("#booking_amount").val()) || 0;
                let downpayment = parseFloat($("#downpayment_amount").val()) || 0;

                let due = totalPrice - (booking + downpayment);

                if ($("#gas_pay_scheme input[type='radio']:checked").val() === "handover") {
                    let gasAmount = parseFloat($("#gas_amount").val()) || 0;
                    due -= gasAmount;
                }

                if ($("#parking_pay_scheme input[type='radio']:checked").val() === "others") {
                    let parkingAmount = parseFloat($("#parking_amount").val()) || 0;
                    due -= parkingAmount;
                }

                if ($("#utility_pay_scheme input[type='radio']:checked").val() === "others") {
                    let utilityAmount = parseFloat($("#utility_amount").val()) || 0;
                    due -= utilityAmount;
                }

                $("#due_amount").val(due);
            }

            calculateDueAmount();

            

            $(document).on("keyup input change", "#total_price, .price_per_sqft, #flat_size, #booking_amount, #downpayment_amount, #discount_amount, .gas_amount, .parking_amount, .utility_amount, .gas_pay_scheme input[type='radio'], .parking_pay_scheme input[type='radio'], input[name='is_discount_applicable'], input[name='is_discount_applicable_total'], .utility_pay_scheme input[type='radio']", function() {
                calculateDueAmount();
            });

            function calculateEMICount() {
                let dueAmount = parseFloat($("#due_amount").val()) || 0;
                let emiAmount = parseFloat($("#emi_amount").val()) || 0;
                if (dueAmount > 0 && emiAmount > 0) {
                    let emiCount = Math.ceil(dueAmount / emiAmount);
                    $("#emi_count").val(emiCount);
                } else {
                    $("#emi_count").val("");
                }
            }

            // Events
            $(document).on("keyup input change", "#due_amount, #emi_amount, #discount_amount, .price_per_sqft, #flat_size, #gas_amount, #parking_amount, #utility_amount, input[name='is_discount_applicable'], input[name='is_discount_applicable_total']", function () {
                calculateEMICount();
            });


            calculateEMICount();


            function validateAmounts() {
                let $section = $(this).closest(".flat-details-wrapper");

                let totalPriceflat   = parseFloat($section.find(".total_price_flat").val()) || 0;
                // let booking      = parseFloat($section.find("#booking_amount").val()) || 0;
                // let discount     = parseFloat($section.find("#discount_amount").val()) || 0;
                let gasAmount    = parseFloat($section.find(".gas_amount").val()) || 0;
                let parkingAmount = parseFloat($section.find(".parking_amount").val()) || 0;
                let utilityAmount = parseFloat($section.find(".utility_amount").val()) || 0;
                // let downpayment  = parseFloat($section.find("#downpayment_amount").val()) || 0;
                // let emiAmount    = parseFloat($section.find("#emi_amount").val()) || 0;   
                // let emiCount     = parseFloat($section.find("#emi_count").val()) || 0;
                // let emiTotal     = emiAmount * emiCount;
                // let totalPayable = booking + downpayment + emiTotal;

                // if (booking > totalPriceflat) {
                //     alert("Booking Amount cannot be greater than Total Price!");
                //     $("#booking_amount").val("");   
                //     return false;
                // }

                // if (discount > totalPriceflat) {
                //     alert("Discount Amount cannot be greater than Total Price!");
                //     $("#discount_amount").val("");   
                //     return false;
                // }

                if (gasAmount > totalPriceflat) {
                    alert("Gas Amount cannot be greater than Total Price!");
                    $("#gas_amount").val("");   
                    return false;
                }
                if (utilityAmount > totalPriceflat) {
                    alert("Utility Amount cannot be greater than Total Price!");
                    $("#utility_amount").val("");   
                    return false;
                }
                if (parkingAmount > totalPriceflat) {
                    alert("Parking Amount cannot be greater than Total Price!");
                    $("#parking_amount").val("");   
                    return false;
                }

                // if (downpayment >  totalPriceflat) {
                //     alert("Downpayment Amount cannot be greater than Total Price!");
                //     $("#downpayment_amount").val(""); 
                //     return false;
                // }

                // if (emiAmount > totalPriceflat) {
                //     alert("EMI Amount cannot be greater than Total Price!");
                //     $("#emi_amount").val(""); 
                //     return false;
                // }

                return true;
            }

            $(".total_price_flat, .gas_amount, .parking_amount, .utility_amount").on("input", function () {
                validateAmounts();
            });

            $("form").on("submit", function (e) {
                if (!validateAmounts()) {
                    e.preventDefault();
                }
            });

        });


        // Handled documents field
       function updateDocumentTypeOptions($section) {
            let selectedValues = [];

            // Collect all selected values
            $section.find("select[name='document_type_id[]']").each(function () {
                let val = $(this).val();
                if (val) selectedValues.push(val);
            });
            // Update options for each select
            $section.find("select[name='document_type_id[]']").each(function () {
                let currentVal = $(this).val();
                $(this).find("option").each(function () {
                    if ($(this).val() === "") {
                        $(this).show(); 
                    } else if ($(this).val() === currentVal) {
                        $(this).show(); 
                    } else if (selectedValues.includes($(this).val())) {
                        $(this).hide(); 
                    } else {
                        $(this).show();
                    }
                });

                let fileInput = $(this).closest(".document-item").find("input[type='file']");
                if ($(this).val()) {
                    fileInput.prop("required", true);
                } else {
                    fileInput.prop("required", false);
                    fileInput.val(''); 
                }
            });

            // Hide + button if all options are selected
            let totalOptions = $section.find("select[name='document_type_id[]']").first().find("option").length - 1; 
            let selectedCount = $section.find("select[name='document_type_id[]']").filter(function () {
                return $(this).val() !== "";
            }).length;

            if (selectedCount >= totalOptions) {
                $section.find(".add-doc").hide();
            } else {
                $section.find(".add-doc").show();
            }
        }

        $(document).on("click", ".add-doc", function () {
            let $section = $(this).closest(".flat-details-wrapper");
            // Validate all selects
            let allSelected = true;
            $section.find("select[name='document_type_id[]']").each(function () {
                if ($(this).val() === "") {
                    allSelected = false;
                    return false;
                }
            });

            if (!allSelected) {
                alert("Please select a document type in all rows before adding a new one.");
                return;
            }

            let wrapper = $section.find(".document-wrapper");
            let item = $(this).closest(".document-item");
            let clone = item.clone(false, false);

            // Clear values in clone
            clone.find("select").val("");
            clone.find("input[type='file']").val("");

            // Hide label in cloned rows
            clone.find("label").html("&nbsp;");

            // Change + to -
            let btn = clone.find(".add-doc");
            btn.removeClass("btn-success add-doc")
            .addClass("btn-danger remove-doc")
            .text("-");

            wrapper.append(clone);

            updateDocumentTypeOptions($section);
        });

        $(document).on("click", ".remove-doc", function () {
            let $section = $(this).closest(".flat-details-wrapper");
            $(this).closest(".document-item").remove();
            updateDocumentTypeOptions($section);
        });

        $(document).on("change", "select[name='document_type_id[]']", function () {
            let $section = $(this).closest(".flat-details-wrapper");
            updateDocumentTypeOptions($section);
        });

        // Initial call
        $(".flat-details-wrapper").each(function () {
            updateDocumentTypeOptions($(this));
        });



       function updateMaterialOptions($section) {
            let selectedValues = [];

            // Collect selected material types
            $section.find("select[name='material_type_id[]']").each(function () {
            let val = $(this).val();
                if (val) selectedValues.push(val);
            });


            let totalOptions =
                $section.find("select[name='material_type_id[]']")
                    .first()
                    .find("option")
                    .not('[value=""]')
                    .length;

            let selectedCount =
                $section.find("select[name='material_type_id[]']")
                    .filter(function () {
                        return $(this).val() !== "";
                    }).length;

            if (selectedCount >= totalOptions) {
                $section.find(".add-material").hide();
            } else {
                $section.find(".add-material").show();
            }
            // Prevent duplicates
            $section.find("select[name='material_type_id[]']").each(function () {
                let currentVal = $(this).val();

                $(this).find("option").each(function () {
                    if ($(this).val() === "") {
                        $(this).show();
                    } else if ($(this).val() === currentVal) {
                        $(this).show();
                    } else if (selectedValues.includes($(this).val())) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            });

            // Make material details mandatory if material type selected
            $section.find("select[name='material_type_id[]']").each(function () {
                let detailsInput = $(this).closest(".material-item").find("input[name='material_details[]']");
                if ($(this).val() !== "") {
                    detailsInput.prop("required", true);
                } else {
                    detailsInput.prop("required", false);
                }
            });
        }

        // Add New Material Row
        $(document).on("click", ".add-material", function () {
            let $section = $(this).closest(".flat-details-wrapper");
            let allSelected = true;

            $section.find("select[name='material_type_id[]']").each(function () {
                if ($(this).val() === "") {
                    allSelected = false;
                    return false;
                }
            });

            if (!allSelected) {
                alert("Please select a material type in all rows before adding a new one.");
                return;
            }

            let wrapper = $section.find("#material-wrapper");
            let item = $(this).closest(".miaterial-item");
            let clone = item.clone(false, false);

            clone.find("select").val("");
            clone.find("input").val("");
            clone.find("label").html("&nbsp;");

            clone.find(".add-material")
                .removeClass("btn-success add-material")
                .addClass("btn-danger remove-material")
                .text("-");

            wrapper.append(clone);

            updateMaterialOptions($section);
        });

        // Remove Row
        $(document).on("click", ".remove-material", function () {
            let $section = $(this).closest(".flat-details-wrapper");
            $(this).closest(".material-item").remove();
            updateMaterialOptions($section);
        });

        // On change of material dropdown
        $(document).on("change", "select[name='material_type_id[]']", function () {
            let $section = $(this).closest(".flat-details-wrapper");
            updateMaterialOptions($section);
        });

        // Form submit validation
        $("form").on("submit", function (e) {
            let valid = true;

            $(".material-item").each(function () {
                let type = $(this).find("select[name='material_type_id[]']").val();
                let details = $(this).find("input[name='material_details[]']").val();

                if ((type && !details) || (!type && details)) {
                    valid = false;
                    return false; // break loop
                }
            });

            if (!valid) {
                alert("Please fill out both Material Type and Material Details for all rows.");
                e.preventDefault();
            }
        });

        $(".flat-details-wrapper").each(function () {
            updateMaterialOptions($(this));
        });
    </script>
    <script>
        function updateFlatNumbering() {
            $('#flat-wrapper .flat-details-wrapper').each(function (index) {
                $(this).find('.flat-title').text('Flat Details ' + (index + 1) + ':');
            });
        }

        function isFlatValid(flat) {
            let isValid = true;

            flat.find('[required]').each(function () {
                if (!this.checkValidity()) {
                    this.reportValidity(); 
                    isValid = false;
                    return false; 
                }
            });

            return isValid;
        }

        $('#add-flat').on('click', function () {

            let wrapper = $('#flat-wrapper');
            let lastFlat = wrapper.find('.flat-details-wrapper:last');

            if (!isFlatValid(lastFlat)) {
                alert('Please fill out all required fields in the last flat before adding a new one.');
                return;
            }

            let clone = wrapper.find('.flat-details-wrapper:first').clone();

            //  Reset all inputs
            clone.find('input').each(function () {
                if ($(this).is(':checkbox, :radio')) {
                    $(this).prop('checked', false);
                } else {
                    $(this).val('');
                }
            });

            clone.find('select').val('');
            clone.find("option").show();
            clone.find('textarea').val('');
            clone.find('input[type="file"]').val('');

            //  Remove extra document/material rows
            clone.find('.document-item:not(:first)').remove();
            clone.find('.material-item:not(:first)').remove();


            //  FORCE hide all conditional UI
            clone.find(
                '#utility_pay_scheme, \
                #utility_amount_group, \
                #parking_fee_group, \
                #parking_pay_scheme, \
                #gas_amount_group, \
                #gas_pay_scheme, \
                #is_govt_gas_connection_paid_group, \
                #is_parking_paid_group, \
                #discount_amount_group, \
                #extras'
            ).hide();

            //  Reset conditional UI
            clone.find('#discount_amount_group, #extras').hide();

            //  Add Remove button (inside card)
            clone.find('.flat-remove-btn').remove(); 

            clone.append(`
                <div class="text-right mt-3 flat-remove-btn">
                    <button type="button" class="btn btn-danger remove-flat">
                        Remove Flat
                    </button>
                </div>
            `);

            wrapper.append(clone);
            updateFlatNumbering();
        });

        //  Remove flat
        $(document).on('click', '.remove-flat', function () {
            $(this).closest('.flat-details-wrapper').remove();
            updateFlatNumbering();
            updateFlatDropdowns();
        });
    </script>
@endpush
