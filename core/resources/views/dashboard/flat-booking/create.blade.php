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
                {{Form::open(['route'=>['flat-booking.store'],'method'=>'POST','files'=>true])}}
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
                    @php
                        $oldFlats = old('project_id', []);
                    @endphp
                    <div id="flat-wrapper">
                        @if(count($oldFlats) > 0)
                            @foreach($oldFlats as $flatIndex => $oldProject)
                                <div class="flat-details-wrapper card" style="border: 1px solid #ccc;  border-radius: 5px; padding: 20px;">
                                    <h5 class="flat-title mb-3">Flat Details {{ $flatIndex+1 }}: </h5>
                                    <div class="form-group row">
                                        <label for="project_id" class="col-sm-2 form-control-label">Project * </label>
                                        <div class="col-sm-10">
                                            <select name="project_id[]" id="project_id" class="form-control c-select project_id" required>
                                                <option value="">- - Select Project - -</option>
                                                @foreach($projects as $project)
                                                    <option value="{{ $project->id }}" {{ old("project_id.$flatIndex") == $project->id ? 'selected' : '' }}>
                                                        {{ $project->title_en }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @php
                                        $oldFlatId = old("flat_id.$flatIndex");
                                        $oldProjectId = old("project_id.$flatIndex");
                                    @endphp
                                    <div class="form-group row" id="flat_section">
                                        <label for="flat_id" class="col-sm-2 form-control-label">Flat *</label>
                                        <div class="col-sm-10">
                                            <select class="form-control flat-select c-select" name="flat_id[]" data-old="{{ $oldFlatId }}" required>
                                                <option value="" disabled selected>Select Flat</option>
                                            </select>
                                        </div>
                                        @error('flat_id')
                                            <small class="text-white">{{ $message }}</small>   
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Flat Size *</label>
                                        <div class="col-sm-10">
                                            {!! Form::number('flat_size[]', old('flat_size[]'), [
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
                                            {!! Form::Checkbox('is_negotiable_total_price[]', 1, old('is_negotiable_total_price[]'),
                                                [
                                                    'id' => 'is_negotiate_total_price',
                                                    'class' => 'is_negotiate_total_price'
                                                ]) !!}
                                        </div>
                                    </div>

                                    <div class="form-group row price_per_sqft_group" id="price_per_sqft_group">
                                        <label class="col-sm-2 form-control-label">Price Per Sq.ft *</label>
                                        <div class="col-sm-10">
                                            {!! Form::number('price_per_sqft[]', old('price_per_sqft[]'), [
                                                'placeholder' => 'Price Per Sq.ft',
                                                'class' => 'form-control price_per_sqft',
                                                'required' => true
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Is Govt Gas Included?</label>
                                        <div class="col-sm-10">
                                            {!! Form::checkbox('is_govt_gas_included[]', 1, old('is_govt_gas_included[]'), [
                                                'class' => 'is_govt_gas_included'
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="form-group row is_govt_gas_connection_paid_group" id="is_govt_gas_connection_paid_group">
                                        <label class="col-sm-2 form-control-label">Is Govt Gas Connection Paid?</label>
                                        <div class="col-sm-10">
                                            {!! Form::Checkbox('is_govt_gas_connection_paid[]', 1, old('is_govt_gas_connection_paid[]'),
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
                                                {!! Form::radio("govt_gas_connection_payment_scheme[$flatIndex]", 'downpayment', old("govt_gas_connection_payment_scheme.$flatIndex") == 'downpayment', ['id' => 'gas_downpayment', 'class' => 'form-check-input gas_downpayment govt_gas_connection_payment_scheme']) !!}
                                                <label class="form-check-label" for="gas_downpayment">Including with Downpayment</label>
                                            </div>

                                            <div class="form-check">
                                                {!! Form::radio("govt_gas_connection_payment_scheme[$flatIndex]", 'emi', old("govt_gas_connection_payment_scheme.$flatIndex") == 'emi', ['id' => 'gas_emi', 'class' => 'form-check-input gas_emi govt_gas_connection_payment_scheme']) !!}
                                                <label class="form-check-label" for="gas_emi">Including with EMI</label>
                                            </div>
                                            <div class="form-check">
                                                {!! Form::radio("govt_gas_connection_payment_scheme[$flatIndex]", 'handover', old("govt_gas_connection_payment_scheme.$flatIndex") == 'handover', ['id' => 'gas_pay_scheme_others', 'class' => 'form-check-input gas_pay_scheme_others govt_gas_connection_payment_scheme']) !!}
                                                <label class="form-check-label" for="gas_pay_scheme_others">Others</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row gas_amount_group" id="gas_amount_group">
                                        <label class="col-sm-2 form-control-label">Gas Connection Fee *</label>
                                        <div class="col-sm-10">
                                            {!! Form::number('gas_amount[]', old('gas_amount[]'), [
                                                'id' => 'gas_amount',
                                                'placeholder' => 'Gas Connection Fee',
                                                'class' => 'form-control gas_amount'
                                            ]) !!}
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Is Parking Included?</label>
                                        <div class="col-sm-10">
                                            {!! Form::Checkbox('is_parking_included[]', 1, old('is_parking_included[]'), 
                                                ['id' => 'is_parking_included', 'class' => 'is_parking_included']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group row is_parking_paid_group" id="is_parking_paid_group">
                                        <label class="col-sm-2 form-control-label">Is Parking Paid?</label>
                                        <div class="col-sm-10">
                                            {!! Form::Checkbox('is_parking_paid[]', 1, old('is_parking_paid[]'), 
                                                ['id' => 'is_parking_paid', 'class' => 'is_parking_paid']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group row parking_pay_scheme" id="parking_pay_scheme">
                                        <label class="col-sm-2 form-control-label">Select Payment Scheme For Parking *</label>
                                        <div class="col-sm-10">
                                            <div class="form-check">
                                                {!! Form::radio("parking_payment_scheme[$flatIndex]", 'downpayment', old("parking_payment_scheme.$flatIndex") == 'downpayment', ['id' => 'parking_downpayment', 'class' => 'form-check-input parking_payment_scheme']) !!}
                                                <label class="form-check-label" for="parking_downpayment">Including with Downpayment</label>
                                            </div>

                                            <div class="form-check">
                                                {!! Form::radio("parking_payment_scheme[$flatIndex]", 'emi', old("parking_payment_scheme.$flatIndex") == 'emi', ['id' => 'parking_emi', 'class' => 'form-check-input parking_payment_scheme']) !!}
                                                <label class="form-check-label" for="parking_emi">Including with EMI</label>
                                            </div>

                                            <div class="form-check">
                                                {!! Form::radio("parking_payment_scheme[$flatIndex]", 'others', old("parking_payment_scheme.$flatIndex") == 'others', ['id' => 'parking_others', 'class' => 'form-check-input parking_payment_scheme']) !!}
                                                <label class="form-check-label" for="parking_others">Others</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row parking_fee_group" id="parking_fee_group">
                                        <label class="col-sm-2 form-control-label">Parking Fee *</label>
                                        <div class="col-sm-10">
                                            {!! Form::number('parking_amount[]', old('parking_amount[]'), [
                                                'id' => 'parking_amount',
                                                'placeholder' => 'Parking Fee',
                                                'class' => 'form-control parking_amount'
                                            ]) !!}
                                        </div>
                                    </div>
                                    

                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Is Utility Included?</label>
                                            <div class="col-sm-10">
                                                {!! Form::Checkbox('is_utility_included[]', 1, old('is_utility_included[]'), 
                                                ['id' => 'is_utility_included', 'class' => 'is_utility_included']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group row utility_pay_scheme" id="utility_pay_scheme">
                                        <label class="col-sm-2 form-control-label">Select Payment Scheme For Utility *</label>
                                        <div class="col-sm-10">
                                            <div class="form-check">
                                                {!! Form::radio("utility_payment_scheme[$flatIndex]", 'downpayment', old("utility_payment_scheme.$flatIndex") == 'downpayment', ['id' => 'utility_downpayment', 'class' => 'form-check-input utility_payment_scheme']) !!}
                                                <label class="form-check-label" for="utility_downpayment">Including with Downpayment</label>
                                            </div>

                                            <div class="form-check">
                                                {!! Form::radio("utility_payment_scheme[$flatIndex]", 'emi', old("utility_payment_scheme.$flatIndex") == 'emi', ['id' => 'utility_emi', 'class' => 'form-check-input utility_payment_scheme']) !!}
                                                <label class="form-check-label" for="utility_emi">Including with EMI</label>
                                            </div>

                                            <div class="form-check">
                                                {!! Form::radio("utility_payment_scheme[$flatIndex]", 'others', old("utility_payment_scheme.$flatIndex") == 'others', ['id' => 'utility_others', 'class' => 'form-check-input utility_payment_scheme']) !!}
                                                <label class="form-check-label" for="utility_others">Others</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row utility_amount_group" id="utility_amount_group">
                                        <label class="col-sm-2 form-control-label">Utility Fee *</label>
                                        <div class="col-sm-10">
                                            {!! Form::number('utility_amount[]', old('utility_amount[]'), [
                                                'id' => 'utility_amount',
                                                'placeholder' => 'Utility Fee',
                                                'class' => 'form-control utility_amount'
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="form-group row extras_group" id="extras" style="display: none;">
                                        <label class="col-sm-2 form-control-label">Extras (Auto Calculate)</label>
                                        <div class="col-sm-10">
                                            {!! Form::number('extras_amount[]', old('extras_amount[]'), [
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
                                            {!! Form::Checkbox('is_discount_applicable[]', 1, old('is_discount_applicable[]'), 
                                                ['id' => 'is_discount_applicable', 'class' => 'is_discount_applicable']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group row discount_amount_group" id="discount_amount_group" style="display: none;">
                                        <label class="col-sm-2 form-control-label">Discounted Amount</label>
                                        <div class="col-sm-10">
                                            {!! Form::number('discount_amount[]', old('discount_amount[]'), [
                                                'id' => 'discount_amount',
                                                'placeholder' => 'Discounted Amount',
                                                'class' => 'form-control discount_amount'
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">Total Price (Flat) *</label>
                                        <div class="col-sm-10">
                                            {!! Form::number('total_price_flat[]', old('total_price_flat[]'), [
                                                'placeholder' => 'Total Price',
                                                'class' => 'form-control total_price_flat',
                                                'required' => true
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">EMI Amount (Per Month)</label>
                                        <div class="col-sm-10">
                                            {!! Form::number('emi_amount_flat[]', old('emi_amount_flat[]'), 
                                                array(
                                                    'placeholder' => 'Enter EMI Amount (Per Month)',
                                                    'class' => 'form-control emi_amount_flat',
                                                    'dir'=>@$ActiveLanguage->direction
                                                )) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-control-label">EMI Start Date</label>
                                        <div class="col-sm-10">
                                            {!! Form::date('emi_start_date_flat[]', old('emi_start_date_flat[]'), array('id' => '', 'placeholder' => 'Enter EMI Start Date','class' => 'form-control emi_start_date_flat', 'dir'=>@$ActiveLanguage->direction)) !!}
                                        </div>
                                    </div>
                                    <div class="document-wrapper">
                                        @php
                                            $flatId = $oldFlatId ?? 'new'; 
                                            $oldDocs = old("document_type_id.$flatId", []);
                                        @endphp

                                        @foreach($oldDocs as $docIndex => $docTypeId)
                                            <div class="form-group row document-item">
                                                @if($docIndex == 0)
                                                    <label class="col-sm-2 form-control-label">Documents</label>
                                                @else
                                                    <label class="col-sm-2">&nbsp;</label>
                                                @endif
                                                <div class="col-sm-4">
                                                    <select name="document_type_id[{{ $flatId }}][{{ $docIndex }}]" class="form-control document-type" required>
                                                        <option value="">-- Select Document Type --</option>
                                                        @foreach($documentTypes as $documentType)
                                                            <option value="{{ $documentType->id }}" {{ $documentType->id == $docTypeId ? 'selected' : '' }}>
                                                                {{ $documentType->document_type }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="file" name="document[{{ $flatId }}][{{ $docIndex }}]" class="form-control">
                                                </div>
                                                <div class="col-sm-2">
                                                    @if($docIndex == 0)
                                                        <button type="button" class="btn btn-success add-doc">+</button>
                                                    @else
                                                        <button type="button" class="btn btn-danger remove-doc">-</button>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach

                                        @if(count($oldDocs) === 0)
                                            {{-- default first row --}}
                                            <div class="form-group row document-item">
                                                <label class="col-sm-2 form-control-label">Documents</label>
                                                <div class="col-sm-4">
                                                    <select name="document_type_id[{{ $flatId }}][0]" class="form-control document-type" required>
                                                        <option value="">-- Select Document Type --</option>
                                                        @foreach($documentTypes as $documentType)
                                                            <option value="{{ $documentType->id }}">{{ $documentType->document_type }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="file" name="document[{{ $flatId }}][0]" class="form-control">
                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="button" class="btn btn-success add-doc">+</button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Materials -->
                                    <div class="material-wrapper">
                                        @if(old("material_type_id.$oldFlatId"))
                                            @foreach(old("material_type_id.$oldFlatId") as $matIndex => $matId)
                                                <div class="form-group row material-item">
                                                    @if($matIndex == 0)
                                                        <label class="col-sm-2 form-control-label">Materials</label>
                                                    @else
                                                        <label class="col-sm-2">&nbsp;</label>
                                                    @endif
                                                    <div class="col-sm-4">
                                                        <select name="material_type_id[{{ $oldFlatId }}][{{ $matIndex }}]" class="form-control material-type" required>
                                                            <option value="">-- Select Material --</option>
                                                            @foreach($materialTypes as $material)
                                                                <option value="{{ $material->id }}" {{ $matId == $material->id ? 'selected' : '' }}>
                                                                    {{ $material->material_type }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="material_details[{{ $oldFlatId }}][{{ $matIndex }}]" class="form-control material_details" placeholder="Material Details" value="{{ old("material_details.$oldFlatId.$matIndex") }}">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="file" name="material_document[{{ $oldFlatId }}][{{ $matIndex }}]" class="form-control">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        @if($matIndex == 0)
                                                            <button type="button" class="btn btn-success add-material">+</button>
                                                        @else
                                                            <button type="button" class="btn btn-danger remove-material">-</button>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <!-- Default first material row -->
                                            <div class="form-group row material-item">
                                                <label class="col-sm-2 form-control-label">Materials</label>
                                                <div class="col-sm-4">
                                                    <select name="material_type_id[{{ $oldFlatId ?? '' }}][0]" class="form-control material-type" required>
                                                        <option value="">-- Select Material --</option>
                                                        @foreach($materialTypes as $material)
                                                            <option value="{{ $material->id }}">{{ $material->material_type }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="text" name="material_details[{{ $oldFlatId ?? '' }}][0]" class="form-control material_details" placeholder="Material Details">
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="file" name="material_document[{{ $oldFlatId ?? '' }}][0]" class="form-control">
                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="button" class="btn btn-success add-material">+</button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                        <div class="flat-details-wrapper card" style="border: 1px solid #ccc;  border-radius: 5px; padding: 20px;">
                            <h5 class="flat-title mb-3">Flat Details 1: </h5>
                            <div class="form-group row">
                                <label for="project_id" class="col-sm-2 form-control-label">Project * </label>
                                <div class="col-sm-10">
                                    <select name="project_id[]" id="project_id" class="form-control c-select project_id" required>
                                        <option value="">- - Select Project - -</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}" data-project_id="{{ $project->id }}"
                                                {{ old('project_id.0') == $project->id ? 'selected' : '' }}>
                                                {{ $project->title_en }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row" id="flat_section">
                                <label for="flat_id" class="col-sm-2 form-control-label">Flat *</label>
                                <div class="col-sm-10">
                                    <select class="form-control flat-select c-select" id="flat_id" name="flat_id[]" data-old="{{ old('flat_id.0') }}" required>
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
                                    {!! Form::number('flat_size[]', old('flat_size[]'), [
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
                                    {!! Form::Checkbox('is_negotiable_total_price[]', 1, old('is_negotiable_total_price[]'),
                                        [
                                            'id' => 'is_negotiate_total_price',
                                            'class' => 'is_negotiate_total_price'
                                        ]) !!}
                                </div>
                            </div>

                            <div class="form-group row price_per_sqft_group" id="price_per_sqft_group">
                                <label class="col-sm-2 form-control-label">Price Per Sq.ft *</label>
                                <div class="col-sm-10">
                                    {!! Form::number('price_per_sqft[]', old('price_per_sqft[]'), [
                                        'placeholder' => 'Price Per Sq.ft',
                                        'class' => 'form-control price_per_sqft',
                                        'required' => true
                                    ]) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label">Is Govt Gas Included?</label>
                                <div class="col-sm-10">
                                    {!! Form::checkbox('is_govt_gas_included[]', 1, old('is_govt_gas_included[]'), [
                                        'class' => 'is_govt_gas_included'
                                    ]) !!}
                                </div>
                            </div>

                            <div class="form-group row is_govt_gas_connection_paid_group" id="is_govt_gas_connection_paid_group">
                                <label class="col-sm-2 form-control-label">Is Govt Gas Connection Paid?</label>
                                <div class="col-sm-10">
                                    {!! Form::Checkbox('is_govt_gas_connection_paid[]', 1, old('is_govt_gas_connection_paid[]'),
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
                                        {!! Form::radio('govt_gas_connection_payment_scheme[]', 'downpayment', old('govt_gas_connection_payment_scheme[]') == 'downpayment', ['id' => 'gas_downpayment', 'class' => 'form-check-input gas_downpayment govt_gas_connection_payment_scheme']) !!}
                                        <label class="form-check-label" for="gas_downpayment">Including with Downpayment</label>
                                    </div>

                                    <div class="form-check">
                                        {!! Form::radio('govt_gas_connection_payment_scheme[]', 'emi', old('govt_gas_connection_payment_scheme[]') == 'emi', ['id' => 'gas_emi', 'class' => 'form-check-input gas_emi govt_gas_connection_payment_scheme']) !!}
                                        <label class="form-check-label" for="gas_emi">Including with EMI</label>
                                    </div>
                                    <div class="form-check">
                                        {!! Form::radio('govt_gas_connection_payment_scheme[]', 'handover', old('govt_gas_connection_payment_scheme[]') == 'handover', ['id' => 'gas_pay_scheme_others', 'class' => 'form-check-input gas_pay_scheme_others govt_gas_connection_payment_scheme']) !!}
                                        <label class="form-check-label" for="gas_pay_scheme_others">Others</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row gas_amount_group" id="gas_amount_group">
                                <label class="col-sm-2 form-control-label">Gas Connection Fee *</label>
                                <div class="col-sm-10">
                                    {!! Form::number('gas_amount[]', old('gas_amount[]'), [
                                        'id' => 'gas_amount',
                                        'placeholder' => 'Gas Connection Fee',
                                        'class' => 'form-control gas_amount'
                                    ]) !!}
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label">Is Parking Included?</label>
                                <div class="col-sm-10">
                                    {!! Form::Checkbox('is_parking_included[]', 1, old('is_parking_included[]'), 
                                        ['id' => 'is_parking_included', 'class' => 'is_parking_included']) !!}
                                </div>
                            </div>

                            <div class="form-group row is_parking_paid_group" id="is_parking_paid_group">
                                <label class="col-sm-2 form-control-label">Is Parking Paid?</label>
                                <div class="col-sm-10">
                                    {!! Form::Checkbox('is_parking_paid[]', 1, old('is_parking_paid[]'), 
                                        ['id' => 'is_parking_paid', 'class' => 'is_parking_paid']) !!}
                                </div>
                            </div>

                            <div class="form-group row parking_pay_scheme" id="parking_pay_scheme">
                                <label class="col-sm-2 form-control-label">Select Payment Scheme For Parking *</label>
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        {!! Form::radio('parking_payment_scheme[]', 'downpayment', old('parking_payment_scheme[]') == 'downpayment', ['id' => 'parking_downpayment', 'class' => 'form-check-input parking_payment_scheme']) !!}
                                        <label class="form-check-label" for="parking_downpayment">Including with Downpayment</label>
                                    </div>

                                    <div class="form-check">
                                        {!! Form::radio('parking_payment_scheme[]', 'emi', old('parking_payment_scheme[]') == 'emi', ['id' => 'parking_emi', 'class' => 'form-check-input parking_payment_scheme']) !!}
                                        <label class="form-check-label" for="parking_emi">Including with EMI</label>
                                    </div>

                                    <div class="form-check">
                                        {!! Form::radio('parking_payment_scheme[]', 'others', old('parking_payment_scheme[]') == 'others', ['id' => 'parking_others', 'class' => 'form-check-input parking_payment_scheme']) !!}
                                        <label class="form-check-label" for="parking_others">Others</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row parking_fee_group" id="parking_fee_group">
                                <label class="col-sm-2 form-control-label">Parking Fee *</label>
                                <div class="col-sm-10">
                                    {!! Form::number('parking_amount[]', old('parking_amount[]'), [
                                        'id' => 'parking_amount',
                                        'placeholder' => 'Parking Fee',
                                        'class' => 'form-control parking_amount'
                                    ]) !!}
                                </div>
                            </div>
                            

                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label">Is Utility Included?</label>
                                    <div class="col-sm-10">
                                        {!! Form::Checkbox('is_utility_included[]', 1, old('is_utility_included[]'), 
                                        ['id' => 'is_utility_included', 'class' => 'is_utility_included']) !!}
                                </div>
                            </div>

                            <div class="form-group row utility_pay_scheme" id="utility_pay_scheme">
                                <label class="col-sm-2 form-control-label">Select Payment Scheme For Utility *</label>
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        {!! Form::radio('utility_payment_scheme[]', 'downpayment', old('utility_payment_scheme[]') == 'downpayment', ['id' => 'utility_downpayment', 'class' => 'form-check-input utility_payment_scheme']) !!}
                                        <label class="form-check-label" for="utility_downpayment">Including with Downpayment</label>
                                    </div>

                                    <div class="form-check">
                                        {!! Form::radio('utility_payment_scheme[]', 'emi', old('utility_payment_scheme[]') == 'emi', ['id' => 'utility_emi', 'class' => 'form-check-input utility_payment_scheme']) !!}
                                        <label class="form-check-label" for="utility_emi">Including with EMI</label>
                                    </div>

                                    <div class="form-check">
                                        {!! Form::radio('utility_payment_scheme[]', 'others', old('utility_payment_scheme[]') == 'others', ['id' => 'utility_others', 'class' => 'form-check-input utility_payment_scheme']) !!}
                                        <label class="form-check-label" for="utility_others">Others</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row utility_amount_group" id="utility_amount_group">
                                <label class="col-sm-2 form-control-label">Utility Fee *</label>
                                <div class="col-sm-10">
                                    {!! Form::number('utility_amount[]', old('utility_amount[]'), [
                                        'id' => 'utility_amount',
                                        'placeholder' => 'Utility Fee',
                                        'class' => 'form-control utility_amount'
                                    ]) !!}
                                </div>
                            </div>

                            <div class="form-group row extras_group" id="extras" style="display: none;">
                                <label class="col-sm-2 form-control-label">Extras (Auto Calculate)</label>
                                <div class="col-sm-10">
                                    {!! Form::number('extras_amount[]', old('extras_amount[]'), [
                                        'id' => 'extras_amount',
                                        'placeholder' => 'Extra Amount(Gas, Utility, Parking, Others)',
                                        'class' => 'form-control extras_amount',
                                        'readonly' => true
                                    ]) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label">Is Applicable Discount?</label>
                                <div class="col-sm-10">
                                    {!! Form::Checkbox('is_discount_applicable[]', 1, old('is_discount_applicable[]'), 
                                        ['id' => 'is_discount_applicable', 'class' => 'is_discount_applicable']) !!}
                                </div>
                            </div>

                            <div class="form-group row discount_amount_group" id="discount_amount_group" style="display: none;">
                                <label class="col-sm-2 form-control-label">Discounted Amount</label>
                                <div class="col-sm-10">
                                    {!! Form::number('discount_amount[]', old('discount_amount[]'), [
                                        'id' => 'discount_amount',
                                        'placeholder' => 'Discounted Amount',
                                        'class' => 'form-control discount_amount'
                                    ]) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label">Total Price (Flat) *</label>
                                <div class="col-sm-10">
                                    {!! Form::number('total_price_flat[]', old('total_price_flat[]'), [
                                        'placeholder' => 'Total Price',
                                        'class' => 'form-control total_price_flat'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label">EMI Amount (Per Month)</label>
                                <div class="col-sm-10">
                                    {!! Form::number('emi_amount_flat[]', old('emi_amount_flat[]'), 
                                        array(
                                            'placeholder' => 'Enter EMI Amount (Per Month)',
                                            'class' => 'form-control emi_amount_flat',
                                            'dir'=>@$ActiveLanguage->direction
                                        )) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label">EMI Start Date</label>
                                <div class="col-sm-10">
                                    {!! Form::date('emi_start_date_flat[]', old('emi_start_date_flat[]'), array('id' => '', 'placeholder' => 'Enter EMI Start Date','class' => 'form-control emi_start_date_flat', 'dir'=>@$ActiveLanguage->direction)) !!}
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
                                            <select name="document_type_id[][]" class="form-control c-select document-type">
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
                                            {!! Form::file('document[][]', [
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
                                        <select name="document_type_id[][]" class="form-control c-select document-type">
                                            <option value="">-- Select Document Type --</option>
                                            @foreach($documentTypes as $documentType)
                                                <option value="{{ $documentType->id }}">{{ $documentType->document_type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        {!! Form::file('document[][]', [
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


                            <div class="material-wrapper">

                                @if(old('material_type_id'))
                                    @foreach(old('material_type_id') as $i => $matId)
                                        <div class="form-group row material-item">

                                            @if($i == 0)
                                                <label class="col-sm-2 form-control-label">Materials</label>
                                            @else
                                                <label class="col-sm-2 form-control-label">&nbsp;</label>
                                            @endif

                                            <div class="col-sm-4">
                                                <select name="material_type_id[][]" class="form-control material-type">
                                                    <option value="">-- Select Material --</option>
                                                    @foreach($materialTypes as $material)
                                                        <option value="{{ $material->id }}"
                                                            {{ $material->id == $matId ? 'selected' : '' }}>
                                                            {{ $material->material_type }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-sm-2">
                                                <input type="text" 
                                                    name="material_details[][]" 
                                                    class="form-control material_details"
                                                    placeholder="Material Details"
                                                    value="">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="file" 
                                                    name="material_document[][]" 
                                                    class="form-control"
                                                    placeholder="Material Document"
                                                    value="">
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
                                            <select name="material_type_id[][]" class="form-control material-type">
                                                <option value="">-- Select Material --</option>
                                                @foreach($materialTypes as $material)
                                                    <option value="{{ $material->id }}">{{ $material->material_type }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-sm-2">
                                            <input type="text" 
                                                name="material_details[][]" 
                                                class="form-control material_details"
                                                placeholder="Material Details">
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="file" 
                                                name="material_document[][]" 
                                                class="form-control"
                                                placeholder="Material Document"
                                                value="">
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-success add-material">+</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="text-right mt-3">
                        <button type="button" id="add-flat" class="btn btn-success">
                            + Add More Flat
                        </button>
                    </div>
                    <div class="form-group row mt-3">
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
                                'class' => 'form-control discount_amount_total'
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">Total Price (Auto Calculate) *</label>
                        <div class="col-sm-10">
                            {!! Form::number('total_price', old('total_price'), [
                                'id' => 'total_price',
                                'placeholder' => 'Total Price',
                                'class' => 'form-control total_price'
                            ]) !!}
                        </div>
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
                                    'class' => 'form-control booking_amount',
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
                                    'class' => 'form-control downpayment_amount',
                                    'required',
                                    'dir' => @$ActiveLanguage->direction
                                ]
                            ) !!}
                        </div>
                    </div>
                    <div class="form-group row extras_group" id="extras">
                        <label class="col-sm-2 form-control-label">Extras Total (Auto Calculate)</label>
                        <div class="col-sm-10">
                            {!! Form::number('extras_amount_total', old('extras_amount_total'), [
                                'id' => 'extras_amount_total',
                                'placeholder' => 'Extra Amount Total(Gas, Utility, Parking, Others)',
                                'class' => 'form-control extras_amount_total',
                                'readonly' => true
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">Due Amount Total(Auto Calculate)</label>
                        <div class="col-sm-10">
                            {!! Form::number('due_amount', old('due_amount'), 
                                array('id' => 'due_amount', 
                                'placeholder' => 'Enter Due Amount',
                                'class' => 'form-control due_amount',
                                'required',
                                'dir' => @$ActiveLanguage->direction,
                                'readonly')) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">Total EMI Amount (Per Month) *</label>
                        <div class="col-sm-10">
                            {!! Form::number('emi_amount', old('emi_amount'),
                                array(
                                    'id' => 'emi_amount', 
                                    'placeholder' => 'Enter EMI Amount (Per Month)',
                                    'class' => 'form-control emi_amount',
                                    'required',
                                    'dir'=>@$ActiveLanguage->direction
                                )) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">EMI Count (Auto Calculate) *</label>
                        <div class="col-sm-10">
                            {!! Form::number('emi_count', old('emi_count'), array('id' => 'emi_count', 'placeholder' => 'Enter EMI Count','class' => 'form-control emi_count','required'=>'','maxlength'=>2, 'dir'=>@$ActiveLanguage->direction,'readonly')) !!}
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label class="col-sm-2 form-control-label">Is EMI Date Combined?</label>
                        <div class="col-sm-10">
                            {!! Form::Checkbox('is_emi_date_combined', 1, old('is_emi_date_combined'), 
                                ['class' => 'is_emi_date_combined']) !!}
                        </div>
                    </div>
                    <div class="form-group row emi_start_date_group">
                        <label class="col-sm-2 form-control-label">EMI Start Date *</label>
                        <div class="col-sm-10">
                            {!! Form::date('emi_start_date', old('emi_start_date'), [
                                'id'=>'emi_start_date', 
                                'class'=>'form-control emi_start_date', 
                                'required'=>'true'
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

        function rebuildUsedFlats(exceptSelect) {
            let used = [];
            $('.flat-select').each(function () {
                if (this === exceptSelect) return;
                let val = $(this).val();
                if (val) used.push(val.toString());
            });
            return used;
        }

        function updateFlatSelectOptions() {
            $('.flat-details-wrapper').each(function () {
                let $section = $(this);
                let flats = $section.data('flats') || [];
                let $flatSelect = $section.find('.flat-select');

                let currentVal = $flatSelect.val() ? $flatSelect.val().toString() : '';
                let usedFlats = rebuildUsedFlats($flatSelect[0]);

                let options = '<option value="" disabled>Select Flat</option>';

                flats.forEach(f => {
                    let fId = f.id.toString();
                    let selected = (currentVal && fId === currentVal) ? 'selected' : '';
                    if (!usedFlats.includes(fId) || fId === currentVal) {
                        options += `<option value="${fId}" ${selected}>${f.flat_name}</option>`;
                    }
                });

                $flatSelect.html(options);

                if (!currentVal) $flatSelect.val('');
            });
        }

        function loadFlats($wrapper, projectId, oldFlatId = null) {
            if (!projectId) return;

            $.ajax({
                url: "{{ route('get.project.flats') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    project_id: projectId,
                    current_flat_id: oldFlatId
                },
                success: function(response) {
                    let flats = response.flats || [];
                    $wrapper.data('flats', flats);

                    let $flatSelect = $wrapper.find('.flat-select');
                    let initialFlat = oldFlatId || $flatSelect.data('old') || '';

                    let options = '<option value="" disabled selected>Select Flat</option>';
                    flats.forEach(f => {
                        let selected = (initialFlat && f.id == initialFlat) ? 'selected' : '';
                        options += `<option value="${f.id}" ${selected}>${f.flat_name}</option>`;
                    });

                    $flatSelect.html(options);
                    updateFlatSelectOptions();
                }
            });
        }
        
        $(document).ready(function () {

            $('.flat-details-wrapper').each(function() {
                let $wrapper = $(this);
                let projectId = $wrapper.find('.project_id').val();
                let oldFlatId = $wrapper.find('.flat-select').data('old');
                loadFlats($wrapper, projectId, oldFlatId);
            });

            // When project changes
            $(document).on('change', '.project_id', function() {
                let $wrapper = $(this).closest('.flat-details-wrapper');
                let projectId = $(this).val();

                // Reset old flat when project changes
                $wrapper.find('.flat-select').data('old', null).val('');
                loadFlats($wrapper, projectId);
            });

            // Flat select change
            $(document).on('change', '.flat-select', function () {

                let $section = $(this).closest('.flat-details-wrapper');
                let selectedFlatId = $(this).val();

                let flats = $section.data('flats') || [];
                let flatData = flats.find(f => f.id.toString() === selectedFlatId);

                if (flatData) {
                    $section.find('.flat_size').val(flatData.flat_size);
                }
                // ------------------------
                // Documents
                // ------------------------
                $section.find('.document-wrapper .document-item').each(function (docIndex) {
                    console.log(docIndex);
                    $(this).find('select[name^="document_type_id"], input[name^="document"]').each(function () {
                        let originalName = $(this).attr('name');

                        // if (originalName.includes('document_type_id')) {
                        //     $(this).attr('name', 'document_type_id[' + selectedFlatId + '][]');
                        // }
                        // if (originalName.includes('document')) {
                        //     $(this).attr('name', 'document[' + selectedFlatId + '][]');
                        // }
                        if ($(this).is('select.document-type')) {
                                $(this).attr('name', 'document_type_id[' + selectedFlatId + '][]');
                            }

                            if ($(this).is('input[type="file"]')) {
                                $(this).attr('name', 'document[' + selectedFlatId + '][]');
                            }
                        });
                });

                // ------------------------
                // Materials
                // ------------------------
                $section.find('.material-wrapper .material-item').each(function (matIndex) {
                    $(this).find('select[name^="material_type_id"], input[name^="material_details"], input[name^="material_document"]').each(function () {
                        let originalName = $(this).attr('name');

                        if (originalName.includes('material_type_id')) {
                            $(this).attr('name', 'material_type_id[' + selectedFlatId + '][]');
                        }
                        if (originalName.includes('material_details')) {
                            $(this).attr('name', 'material_details[' + selectedFlatId + '][]');
                        }
                        if (originalName.includes('material_document')) {
                            $(this).attr('name', 'material_document[' + selectedFlatId + '][]');
                        }
                    });
                });

                updateFlatSelectOptions();
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

                    $section.find('.is_govt_gas_connection_paid')
                        .prop('checked', false)
                        .prop('required', false);

                    $section.find('.govt_gas_connection_payment_scheme')
                        .prop('checked', false)
                        .prop('required', false);
                    $section.find(".gas_amount").val("").prop("required", false);

                    $section.find('.gas_pay_scheme').hide();
                    $section.find('.gas_amount_group').hide();
                }
                calculateFlatTotalPrice($checkbox);
                calculateTotal();
            }


        $(document).on('change', '.is_govt_gas_included', function () {
            toggleGovtGasSection($(this));
        });

        $('.is_govt_gas_included').each(function () {
            toggleGovtGasSection($(this));
        });

        function toggleGovtGaspayment($checkbox){
            let $section = $checkbox.closest('.flat-details-wrapper');
            if($checkbox.is(':checked')){
                $section.find(".gas_pay_scheme").show();
                $section.find(".gas_amount_group").show();

                $section.find(".govt_gas_connection_payment_scheme").prop("required", true);
                $section.find(".gas_amount").prop("required", true);
            }else{
                $section.find(".gas_pay_scheme").hide();
                $section.find(".gas_amount_group").hide();
                $section.find(".govt_gas_connection_payment_scheme").prop("checked", false).prop("required", false);
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

                $section.find(".is_parking_paid")
                    .prop("checked", false)
                    .prop("required", false);

                $section.find(".parking_payment_scheme")
                    .prop("checked", false)
                    .prop("required", false);

                $section.find(".parking_amount").val("").prop("required", false);
                $section.find(".parking_pay_scheme").hide();
                $section.find(".parking_fee_group").hide();
            }
            calculateFlatTotalPrice($checkbox);
            calculateTotal();
        }

        $(document).on('change', '.is_parking_included' , function () {
            toggleParkingSection($(this));
        });

        $('.is_parking_included').each(function () {
            toggleParkingSection($(this));
        });

        function toggleParkingPayment($checkbox){
            let $section = $checkbox.closest('.flat-details-wrapper');
            if($checkbox.is(':checked')){
                $section.find(".parking_pay_scheme").show();
                $section.find(".parking_fee_group").show();
                $section.find(".parking_payment_scheme").prop("required", true);
                $section.find(".parking_amount").prop("required", true);
            }else{
                $section.find(".parking_pay_scheme").hide();
                $section.find(".parking_fee_group").hide();
                $section.find(".parking_payment_scheme").prop("checked", false).prop("required", false);
                $section.find(".parking_amount").val("").prop("required", false);
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
                $section.find(".utility_amount").prop("required", true);
            } else {    
                $section.find(".utility_pay_scheme").hide();
                $section.find(".utility_amount_group").hide();  
                
                $section.find(".utility_payment_scheme").prop("checked", false).prop("required", false);
                $section.find(".utility_amount").val("").prop("required", false);
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
                $section.find(".discount_amount").prop("required", true);
            } else {    
                $section.find(".discount_amount_group").hide();
                $section.find(".discount_amount").val("").prop("required", false);
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

            toggleDiscountFieldTotal();
    
            $("#is_discount_applicable_total").change(function () {
                 toggleDiscountFieldTotal();
            });
            function toggleEmiStartDate(){
                if ($('.is_emi_date_combined').is(':checked')) {
                    $('.emi_start_date_group').show();
                    $('.emi_start_date').prop('required', true);
                } else {
                    $('.emi_start_date_group').hide();
                    $('.emi_start_date').val('').prop('required', false);
                }
            }
            toggleEmiStartDate();
            $('.is_emi_date_combined').change(function(){
                toggleEmiStartDate();
            });
            function validateAmounts() {
                let $section = $(this).closest(".flat-details-wrapper");

                let totalPriceflat   = parseFloat($section.find(".total_price_flat").val()) || 0;
                let gasAmount    = parseFloat($section.find(".gas_amount").val()) || 0;
                let parkingAmount = parseFloat($section.find(".parking_amount").val()) || 0;
                let utilityAmount = parseFloat($section.find(".utility_amount").val()) || 0;

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

        function calculateTotal(){
            let total = 0;
            $('.total_price_flat').each(function() {
                let val = parseFloat($(this).val()) || 0;
                if (!isNaN(val)) {
                    total += val;
                }
            });
            let discount_total = $('.discount_amount_total').val() ? parseFloat($('.discount_amount_total').val()) : 0;
            total = total - discount_total;

            $('#total_price').val(total);
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

                if ($section.find(".govt_gas_connection_payment_scheme:checked").length > 0 
                    && $section.find(".is_govt_gas_connection_paid").is(":checked")) {
                        console.log(gasAmount);
                    total += gasAmount;
                }

                if ($section.find(".parking_payment_scheme:checked").length > 0 
                    && $section.find(".is_parking_paid").is(":checked")) {
                    total += parkingAmount;
                }

                if ($section.find(".utility_payment_scheme:checked").length > 0 
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
            ".flat_size, .price_per_sqft, .is_negotiate_total_price, .gas_amount, .parking_amount, .utility_amount, .flat-select, .govt_gas_connection_payment_scheme, .parking_payment_scheme, .utility_payment_scheme, .is_discount_applicable, input[name='is_discount_applicable_total'], .discount_amount, input[name='discount_amount_total'], .is_govt_gas_connection_paid, .is_parking_paid, .is_utility_included", 
            function() {
                calculateFlatTotalPrice($(this));
                calculateTotal();
            }
        );

        $(document).on("keyup input", ".total_price_flat", function() {
            calculateTotal();
        });


        function updateExtras($selector) {
            let extras = 0;
            let extrasVisible = false;
            let $section = $selector.closest(".flat-details-wrapper");

            if ($section.find(".is_govt_gas_included").is(":checked") &&
                $section.find(".is_govt_gas_connection_paid").is(":checked") &&
                $section.find(".gas_pay_scheme input[type='radio']:checked").val() === "handover") {
                let gasAmount = parseFloat($section.find(".gas_amount").val()) || 0;
                extras += gasAmount;
                extrasVisible = true;
            }

            if ($section.find(".is_parking_included").is(":checked") &&
                $section.find(".is_parking_paid").is(":checked") &&
                $section.find(".parking_pay_scheme input[type='radio']:checked").val() === "others") {
                let parkingAmount = parseFloat($section.find(".parking_amount").val()) || 0;
                extras += parkingAmount;
                extrasVisible = true;
            }

            if ($section.find(".is_utility_included").is(":checked") &&
                $section.find(".utility_pay_scheme input[type='radio']:checked").val() === "others") {
                let utilityAmount = parseFloat($section.find(".utility_amount").val()) || 0;
                extras += utilityAmount;
                extrasVisible = true;
            }   

            if (extrasVisible) {
                console.log('if');
                $section.find(".extras_group").show();
                $section.find(".extras_amount").val(extras);
            } else {
                console.log('else');
                $section.find(".extras_group").hide();
                $section.find(".extras_amount").val("");
            }
        }

        function totalExtras() {
            let total = 0;

            $('.extras_amount').each(function (index) {
                let val = parseFloat($(this).val());

                if (!isNaN(val)) {
                    total += val;
                }
            });

            $('.extras_amount_total').val(total);
        }


        $(document).on("keyup input change", ".gas_amount, .parking_amount, .utility_amount, .gas_pay_scheme , .is_govt_gas_included, .is_govt_gas_connection_paid, .is_parking_included, .is_parking_paid, .is_utility_included, input[type='radio'], .parking_pay_scheme input[type='radio'], .utility_pay_scheme input[type='radio']", function() {
            updateExtras($(this));
            totalExtras();

        });


        function calculateDueAmount($selector) {
            let totalPrice = parseFloat($('.total_price').val()) || 0;
            let booking = parseFloat($('.booking_amount').val()) || 0;
            let downpayment = parseFloat($('.downpayment_amount').val()) || 0;
            let extras = parseFloat($('.extras_amount_total').val()) || 0;

            let due = totalPrice - (booking + downpayment + extras);
            $(".due_amount").val(due);
        }


        $(document).on("keyup input change", ".total_price, .total_price_flat, .is_negotiate_total_price, .price_per_sqft, .flat_size, .booking_amount, .downpayment_amount, .discount_amount_total, .gas_amount, .discount_amount, .parking_amount, .utility_amount, .gas_pay_scheme input[type='radio'], .parking_pay_scheme input[type='radio'], input[name='is_discount_applicable'], input[name='is_discount_applicable_total'], .utility_pay_scheme input[type='radio']", function() {
            calculateDueAmount($(this));
        });

        function calculateEMI(){
            let $emi = 0;
            $('.emi_amount_flat').each(function(){
                let $val = parseFloat($(this).val()) || 0;
                $emi += $val;
                $('.emi_amount').val($emi);
            })
        }
        $(document).on("keyup input change", ".emi_amount_flat", function() {
            calculateEMI();
        });

        function calculateEMICount() {
            let dueAmount = parseFloat($(".due_amount").val()) || 0;
            let emiAmount = parseFloat($(".emi_amount").val()) || 0;
            if (dueAmount > 0 && emiAmount > 0) {
                let emiCount = Math.ceil(dueAmount / emiAmount);
                $(".emi_count").val(emiCount);
            } else {
                $(".emi_count").val("");
            }
        }

        // Events
        $(document).on("keyup input change", ".due_amount, .emi_amount, .emi_amount_flat, .total_price_flat, .is_negotiate_total_price, .price_per_sqft, .flat_size, .discount_amount_total, input[name='is_discount_applicable_total'], .gas_amount, .parking_amount, .utility_amount, .gas_pay_scheme input[type='radio'], .parking_pay_scheme input[type='radio'], input[name='is_discount_applicable'], input[name='is_discount_applicable_total'], .utility_pay_scheme input[type='radio']", function () {
            calculateEMICount();
        });
        // Handled documents field
       function updateDocumentTypeOptions($section) {
            let selectedValues = [];

            // Collect all selected values
            $section.find(".document-type").each(function () {
                let val = $(this).val();
                if (val) selectedValues.push(val);
            });
            // Update options for each select
            $section.find(".document-type").each(function () {
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
            let totalOptions = $section.find(".document-type").first().find("option").length - 1; 
            let selectedCount = $section.find(".document-type").filter(function () {
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
            $section.find(".document-type").each(function () {
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

        $(document).on("change", ".document-type", function () {
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
            $section.find(".material-type").each(function () {
            let val = $(this).val();
                if (val) selectedValues.push(val);
            });


            let totalOptions =
                $section.find(".material-type")
                    .first()
                    .find("option")
                    .not('[value=""]')
                    .length;

            let selectedCount =
                $section.find(".material-type")
                    .filter(function () {
                        return $(this).val() !== "";
                    }).length;

            if (selectedCount >= totalOptions) {
                $section.find(".add-material").hide();
            } else {
                $section.find(".add-material").show();
            }
            // Prevent duplicates
            $section.find(".material-type").each(function () {
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
            $section.find(".material-type").each(function () {
                let detailsInput = $(this).closest(".material-item").find("input[name='material_details[][]']");
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

            $section.find(".material-type").each(function () {
                if ($(this).val() === "") {
                    allSelected = false;
                    return false;
                }
            });

            if (!allSelected) {
                alert("Please select a material type in all rows before adding a new one.");
                return;
            }

            let wrapper = $section.find(".material-wrapper");
            let item = $(this).closest(".material-item");
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
        $(document).on("change", ".material-type", function () {
            let $section = $(this).closest(".flat-details-wrapper");
            updateMaterialOptions($section);
        });

        // Form submit validation
        $("form").on("submit", function (e) {
            let valid = true;

            $(".material-item").each(function () {
                let type = $(this).find(".material-type").val();
                let details = $(this).find(".material_details").val();
                console.log("Type:", type, "Details:", details);

                if ((type && !details) || (!type && details)) {
                    valid = false;
                    return false; 
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
            let index = $('.flat-details-wrapper').length;

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
            clone.find(".govt_gas_connection_payment_scheme").attr('name', 'govt_gas_connection_payment_scheme[' + index + ']');
            clone.find(".parking_payment_scheme").attr('name', 'parking_payment_scheme[' + index + ']');
            clone.find(".utility_payment_scheme").attr('name', 'utility_payment_scheme[' + index + ']');

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
            calculateTotal();
            totalExtras();
            calculateDueAmount($(this));
            calculateEMICount();
        });
    </script>
@endpush
