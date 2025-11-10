<?php
$projects = Helper::Topics(8);
?>
@extends('dashboard.layouts.master')
@section('title', "Create Price")
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
                <h3><i class="material-icons">&#xe02e;</i> {{ __('backend.addprice') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                    <a>Add Price</a> /
                    <a>List of Prices</a>
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
                    <div class="form-group row" id="flat_section" style="display: none;">
                        <label for="flat_id" class="col-sm-2 form-control-label">Flat *</label>
                        <div class="col-sm-10">
                            <select class="form-control c-select" id="flat_id" name="flat_id" required>
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
                                'class' => 'form-control',
                                'required' => true
                            ]) !!}
                        </div>
                    </div>
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
                        <label class="col-sm-2 form-control-label">Is Negotiate Total Price?</label>
                        <div class="col-sm-10">
                            {!! Form::Checkbox('is_negotiable_total_price', 1, old('is_negotiable_total_price'),
                                ['id' => 'is_negotiate_total_price']) !!}
                        </div>
                    </div>

                    <div class="form-group row" id="price_per_sqft_group">
                        <label class="col-sm-2 form-control-label">Price Per Sq.ft *</label>
                        <div class="col-sm-10">
                            {!! Form::number('price_per_sqft', old('price_per_sqft'), [
                                'id' => 'price_per_sqft',
                                'placeholder' => 'Price Per Sq.ft',
                                'class' => 'form-control',
                                'required' => true
                            ]) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">Is Applicable for Govt Gas?</label>
                        <div class="col-sm-10">
                            {!! Form::checkbox('is_applicable_govt_gas', 1, old('is_applicable_govt_gas'), ['id' => 'is_applicable_govt_gas']) !!}
                        </div>
                    </div>

                    <div class="form-group row" id="is_govt_gas_connection_paid_group">
                        <label class="col-sm-2 form-control-label">Is Govt Gas Connection Paid?</label>
                        <div class="col-sm-10">
                            {!! Form::Checkbox('is_govt_gas_connection_paid', 1, old('is_govt_gas_connection_paid'),
                                ['id' => 'is_govt_gas_connection_paid']) !!}
                        </div>
                    </div>

                    <div class="form-group row" id="gas_pay_scheme">
                        <label class="col-sm-2 form-control-label">Select Payment Scheme For Gas *</label>
                        <div class="col-sm-10">
                            <div class="form-check">
                                {!! Form::radio('govt_gas_connection_payment_scheme', 'downpayment', old('govt_gas_connection_payment_scheme') == 'downpayment', ['id' => 'gas_downpayment', 'class' => 'form-check-input']) !!}
                                <label class="form-check-label" for="gas_downpayment">Including with Downpayment</label>
                            </div>

                            <div class="form-check">
                                {!! Form::radio('govt_gas_connection_payment_scheme', 'emi', old('govt_gas_connection_payment_scheme') == 'emi', ['id' => 'gas_emi', 'class' => 'form-check-input']) !!}
                                <label class="form-check-label" for="gas_emi">Including with EMI</label>
                            </div>
                            <div class="form-check">
                                {!! Form::radio('govt_gas_connection_payment_scheme', 'handover', old('govt_gas_connection_payment_scheme') == 'handover', ['id' => 'gas_pay_scheme_others', 'class' => 'form-check-input']) !!}
                                <label class="form-check-label" for="gas_pay_scheme_others">Others</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row" id="gas_amount_group">
                        <label class="col-sm-2 form-control-label">Gas Connection Fee *</label>
                        <div class="col-sm-10">
                            {!! Form::number('gas_amount', old('gas_amount'), [
                                'id' => 'gas_amount',
                                'placeholder' => 'Gas Connection Fee',
                                'class' => 'form-control'
                            ]) !!}
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">Is Applicable for Parking?</label>
                        <div class="col-sm-10">
                            {!! Form::Checkbox('is_applicable_parking', 1, old('is_applicable_parking'), 
                                ['id' => 'is_applicable_parking']) !!}
                        </div>
                    </div>

                    <div class="form-group row" id="is_parking_paid_group">
                        <label class="col-sm-2 form-control-label">Is Parking Paid?</label>
                        <div class="col-sm-10">
                            {!! Form::Checkbox('is_parking_paid', 1, old('is_parking_paid'), 
                                ['id' => 'is_parking_paid']) !!}
                        </div>
                    </div>

                    <div class="form-group row" id="parking_pay_scheme">
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

                    <div class="form-group row" id="parking_fee_group">
                        <label class="col-sm-2 form-control-label">Parking Fee *</label>
                        <div class="col-sm-10">
                            {!! Form::number('parking_amount', old('parking_amount'), [
                                'id' => 'parking_amount',
                                'placeholder' => 'Parking Fee',
                                'class' => 'form-control'
                            ]) !!}
                        </div>
                    </div>
                    

                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">Is Utility Included?</label>
                        <div class="col-sm-10">
                            {!! Form::Checkbox('is_utility_included', 1, old('is_utility_included'), 
                                ['id' => 'is_utility_included']) !!}
                        </div>
                    </div>

                    <div class="form-group row" id="utility_pay_scheme">
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

                    <div class="form-group row" id="utility_amount_group">
                        <label class="col-sm-2 form-control-label">Utility Fee *</label>
                        <div class="col-sm-10">
                            {!! Form::number('utility_amount', old('utility_amount'), [
                                'id' => 'utility_amount',
                                'placeholder' => 'Utility Fee',
                                'class' => 'form-control'
                            ]) !!}
                        </div>
                    </div>

                    <div class="form-group row" id="extras" style="display: none;">
                        <label class="col-sm-2 form-control-label">Extras (Auto Calculate)</label>
                        <div class="col-sm-10">
                            {!! Form::number('extras_amount', old('extras_amount'), [
                                'id' => 'extras_amount',
                                'placeholder' => 'Extra Amount(Gas, Utility, Parking, Others)',
                                'class' => 'form-control',
                                'readonly' => true
                            ]) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">Is Application Discount?</label>
                        <div class="col-sm-10">
                            {!! Form::Checkbox('is_discount_applicable', 1, old('is_discount_applicable'), 
                                ['id' => 'is_discount_applicable']) !!}
                        </div>
                    </div>

                    <div class="form-group row" id="discount_amount_group" style="display: none;">
                        <label class="col-sm-2 form-control-label">Discounted Amount *</label>
                        <div class="col-sm-10">
                            {!! Form::number('discount_amount', old('discount_amount'), [
                                'id' => 'discount_amount',
                                'placeholder' => 'Discounted Amount',
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
                            {!! Form::date('emi_start_date', old('emi_start_date'), array('placeholder' => 'Enter EMI Start Date','class' => 'form-control','required'=>'true', 'dir'=>@$ActiveLanguage->direction)) !!}
                        </div>
                    </div>
                    <div id="document-wrapper">
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
                                            @foreach($materials as $material)
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

                        if (response.tags.length > 0) {
                            response.tags.forEach(function (tag) {
                                options += `<option value="${tag.id}">${tag.title}</option>`;
                            });

                            $('#flat_id').html(options);
                            $('#flat_section').show();
                        } else {
                            $('#flat_id').html('<option>No tags found</option>');
                            $('#flat_section').hide();
                        }
                    }
                });
            });


            function togglePriceField() {
            if ($("#is_negotiate_total_price").is(":checked")) {
                $("#price_per_sqft_group").hide();
                $("#price_per_sqft").val("");
                $("#booking_amount").val("");
                $("#downpayment_amount").val("");
                $("#due_amount").val("");
                $("#emi_amount").val("");
                $("#emi_count").val("");
            } else {
                $("#price_per_sqft_group").show();
            }
        }

        function toggleGasField() {
            if ($("#is_applicable_govt_gas").is(":checked")) {
                $("#is_govt_gas_connection_paid_group").show();
            } else {    
                $("#is_govt_gas_connection_paid_group").hide();
                $("#gas_pay_scheme").hide();
                $("#gas_amount_group").hide();
                $("input[name='is_govt_gas_connection_paid']").prop("checked", false);
                $("#gas_amount").val("");
            }
        }

        function toggleParkingField() {
            if ($("#is_applicable_parking").is(":checked")) {
                $("#is_parking_paid_group").show();
            } else {    
                $("#is_parking_paid_group").hide();
                $("#parking_pay_scheme").hide();
                $("#parking_fee_group").hide();
                $("input[name='is_parking_paid']").prop("checked", false);
                $("#parking_amount").val("");
            }
        }

        function togglePaymentSchemeForGas() {
            if ($("#is_govt_gas_connection_paid").is(":checked")) {
                $("#gas_pay_scheme").show();
                $("#gas_amount_group").show();

                $("input[name='govt_gas_connection_payment_scheme']").prop("required", true);
                $("#gas_amount").prop("required", true);
            } else {    
                $("#gas_pay_scheme").hide();
                $("#gas_amount_group").hide();

                $("input[name='govt_gas_connection_payment_scheme']").prop("checked", false).prop("required", false);
                $("#gas_amount").val("").prop("required", false);
            }
        }

        
        function togglePaymentSchemeForParking() {
            if ($("#is_parking_paid").is(":checked")) {
                $("#parking_pay_scheme").show();
                $("#parking_fee_group").show();

                $("input[name='parking_payment_scheme']").prop("required", true);
                $("#parking_amount").prop("required", true);
            } else {    
                $("#parking_pay_scheme").hide();
                $("#parking_fee_group").hide();

                $("input[name='parking_payment_scheme']").prop("checked", false).prop("required", false);
                $("#parking_amount").val("").prop("required", false);

            }
        }

        function togglePaymentSchemeForUtility() {
            if ($("#is_utility_included").is(":checked")) {
                $("#utility_pay_scheme").show();
                $("#utility_amount_group").show();

                $("input[name='utility_payment_scheme']").prop("required", true);
                $("#utility_amount").prop("required", true);
            } else {    
                $("#utility_pay_scheme").hide();
                $("#utility_amount_group").hide();  
                
                $("input[name='utility_payment_scheme']").prop("checked", false).prop("required", false);
                $("#utility_amount").val("").prop("required", false);
            }
        }

        function toggleDiscountField() {
            if ($("#is_discount_applicable").is(":checked")) {
                $("#discount_amount_group").show();
                $("#discount_amount").prop("required", true);
            } else {    
                $("#discount_amount_group").hide();
                $("#discount_amount").val("").prop("required", false);
            }
        }

        function calculateTotalPrice() {
            let flatSize = parseFloat($("#flat_size").val()) || 0;
            let pricePerSqft = parseFloat($("#price_per_sqft").val()) || 0;
            let gasAmount = parseFloat($("#gas_amount").val()) || 0;
            let parkingAmount = parseFloat($("#parking_amount").val()) || 0;
            let utilityAmount = parseFloat($("#utility_amount").val()) || 0;
            let discountAmount = parseFloat($("#discount_amount").val()) || 0;

            if (!$("#is_negotiate_total_price").is(":checked")) {
                let total = flatSize * pricePerSqft;

                if ($("input[name='govt_gas_connection_payment_scheme']:checked").length > 0 
                    && $("#is_govt_gas_connection_paid").is(":checked")) {
                    total += gasAmount;
                }

                if ($("input[name='parking_payment_scheme']:checked").length > 0 
                    && $("#is_parking_paid").is(":checked")) {
                    total += parkingAmount;
                }

                if ($("input[name='utility_payment_scheme']:checked").length > 0 
                    && $("#is_utility_included").is(":checked")) {
                    total += utilityAmount;
                }

                if ($("#is_discount_applicable").is(":checked")) {
                    total -= discountAmount;
                }


                $("#total_price").val(total);
            } else {
                $("#total_price").val(""); 
            }
        }

            togglePriceField();
            toggleGasField();
            toggleParkingField();
            togglePaymentSchemeForGas();
            togglePaymentSchemeForParking();
            togglePaymentSchemeForUtility();
            toggleDiscountField()
            calculateTotalPrice();

            $("#is_negotiate_total_price").change(function () {
                togglePriceField();
                calculateTotalPrice();
            });

            $("#is_applicable_govt_gas").change(function () {
                 toggleGasField();
            });

            $("#is_applicable_parking").change(function () {
                 toggleParkingField();
            });

            $("#is_govt_gas_connection_paid").change(function () {
                 togglePaymentSchemeForGas();
            });

            $("#is_parking_paid").change(function () {
                 togglePaymentSchemeForParking();
            });

            $("#is_utility_included").change(function () {
                 togglePaymentSchemeForUtility();
            });

            $("#is_discount_applicable").change(function () {
                 toggleDiscountField();
            });

            $("#flat_size, #price_per_sqft").on("input", function () {
                calculateTotalPrice();
            });

            function updateExtras() {
                let extras = 0;
                let extrasVisible = false;

                if ($("#gas_pay_scheme input[type='radio']:checked").val() === "handover") {
                    let gasAmount = parseFloat($("#gas_amount").val()) || 0;
                    extras += gasAmount;
                    extrasVisible = true;
                }

                if ($("#parking_pay_scheme input[type='radio']:checked").val() === "others") {
                    let parkingAmount = parseFloat($("#parking_amount").val()) || 0;
                    extras += parkingAmount;
                    extrasVisible = true;
                }

                if ($("#utility_pay_scheme input[type='radio']:checked").val() === "others") {
                    let utilityAmount = parseFloat($("#utility_amount").val()) || 0;
                    extras += utilityAmount;
                    extrasVisible = true;
                }

                if (extrasVisible) {
                    $("#extras").show();
                    $("#extras_amount").val(extras);
                } else {
                    $("#extras").hide();
                    $("#extras_amount").val("");
                }
            }

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

            $(document).on("keyup input change", "#gas_amount, #parking_amount, #utility_amount, #gas_pay_scheme input[type='radio'], #parking_pay_scheme input[type='radio'], #utility_pay_scheme input[type='radio']", function() {
                updateExtras();
            });

            $(document).on("keyup input change", 
                "#flat_size, #price_per_sqft, #gas_amount, #parking_amount, #utility_amount, input[name='govt_gas_connection_payment_scheme'], input[name='parking_payment_scheme'], input[name='utility_payment_scheme'], input[name='is_discount_applicable'], input[name='discount_amount'], #is_govt_gas_connection_paid, #is_parking_paid, #is_utility_included", 
                function() {
                    calculateTotalPrice();
                }
            );

            $(document).on("keyup input change", "#total_price, #price_per_sqft, #flat_size, #booking_amount, #downpayment_amount, #discount_amount, #gas_amount, #parking_amount, #utility_amount, #gas_pay_scheme input[type='radio'], #parking_pay_scheme input[type='radio'], input[name='is_discount_applicable'], #utility_pay_scheme input[type='radio']", function() {
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
            $(document).on("keyup input change", "#due_amount, #emi_amount, #discount_amount, #price_per_sqft, #flat_size, #gas_amount, #parking_amount, #utility_amount, input[name='is_discount_applicable']", function () {
                calculateEMICount();
            });


            calculateEMICount();


            function validateAmounts() {
                let totalPrice   = parseFloat($("#total_price").val()) || 0;
                let booking      = parseFloat($("#booking_amount").val()) || 0;
                let discount     = parseFloat($("#discount_amount").val()) || 0;
                let gasAmount    = parseFloat($("#gas_amount").val()) || 0;
                let parkingAmount = parseFloat($("#parking_amount").val()) || 0;
                let utilityAmount = parseFloat($("#utility_amount").val()) || 0;
                let downpayment  = parseFloat($("#downpayment_amount").val()) || 0;
                let emiAmount    = parseFloat($("#emi_amount").val()) || 0;   
                let emiCount     = parseFloat($("#emi_count").val()) || 0;
                let emiTotal     = emiAmount * emiCount;
                let totalPayable = booking + downpayment + emiTotal;

                if (booking > totalPrice) {
                    alert("Booking Amount cannot be greater than Total Price!");
                    $("#booking_amount").val("");   
                    return false;
                }

                if (discount > totalPrice) {
                    alert("Discount Amount cannot be greater than Total Price!");
                    $("#discount_amount").val("");   
                    return false;
                }

                if (gasAmount > totalPrice) {
                    alert("Gas Amount cannot be greater than Total Price!");
                    $("#gas_amount").val("");   
                    return false;
                }
                if (utilityAmount > totalPrice) {
                    alert("Utility Amount cannot be greater than Total Price!");
                    $("#utility_amount").val("");   
                    return false;
                }
                if (parkingAmount > totalPrice) {
                    alert("Parking Amount cannot be greater than Total Price!");
                    $("#parking_amount").val("");   
                    return false;
                }

                if (downpayment > totalPrice) {
                    alert("Downpayment Amount cannot be greater than Total Price!");
                    $("#downpayment_amount").val(""); 
                    return false;
                }

                if (emiAmount > totalPrice) {
                    alert("EMI Amount cannot be greater than Total Price!");
                    $("#emi_amount").val(""); 
                    return false;
                }

                return true;
            }

            $("#total_price, #booking_amount, #downpayment_amount, #emi_amount, #emi_count, #discount_amount, #gas_amount, #parking_amount, #utility_amount").on("input", function () {
                validateAmounts();
            });

            $("form").on("submit", function (e) {
                if (!validateAmounts()) {
                    e.preventDefault();
                }
            });

        });


        // Handled documents field
       function updateDocumentTypeOptions() {
            let selectedValues = [];

            // Collect all selected values
            $("select[name='document_type_id[]']").each(function () {
                let val = $(this).val();
                if (val) selectedValues.push(val);
            });

            // Update options for each select
            $("select[name='document_type_id[]']").each(function () {
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
            let totalOptions = $("select[name='document_type_id[]']").first().find("option").length - 1; // exclude empty
            let selectedCount = $("select[name='document_type_id[]']").filter(function () {
                return $(this).val() !== "";
            }).length;

            if (selectedCount >= totalOptions) {
                $(".add-doc").hide();
            } else {
                $(".add-doc").show();
            }
        }

        $(document).on("click", ".add-doc", function () {
            // Validate all selects
            let allSelected = true;
            $("select[name='document_type_id[]']").each(function () {
                if ($(this).val() === "") {
                    allSelected = false;
                    return false;
                }
            });

            if (!allSelected) {
                alert("Please select a document type in all rows before adding a new one.");
                return;
            }

            let wrapper = $("#document-wrapper");
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

            updateDocumentTypeOptions();
        });

        $(document).on("click", ".remove-doc", function () {
            $(this).closest(".document-item").remove();
            updateDocumentTypeOptions();
        });

        $(document).on("change", "select[name='document_type_id[]']", function () {
            updateDocumentTypeOptions();
        });

        // Initial call
        updateDocumentTypeOptions();


       function updateMaterialOptions() {
            let selectedValues = [];

            // Collect selected material types
            $("select[name='material_type_id[]']").each(function () {
                let val = $(this).val();
                if (val) selectedValues.push(val);
            });

            // Prevent duplicates
            $("select[name='material_type_id[]']").each(function () {
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
            $("select[name='material_type_id[]']").each(function () {
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
            let allSelected = true;

            $("select[name='material_type_id[]']").each(function () {
                if ($(this).val() === "") {
                    allSelected = false;
                    return false;
                }
            });

            if (!allSelected) {
                alert("Please select a material type in all rows before adding a new one.");
                return;
            }

            let wrapper = $("#material-wrapper");
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

            updateMaterialOptions();
        });

        // Remove Row
        $(document).on("click", ".remove-material", function () {
            $(this).closest(".material-item").remove();
            updateMaterialOptions();
        });

        // On change of material dropdown
        $(document).on("change", "select[name='material_type_id[]']", function () {
            updateMaterialOptions();
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

        // Initial load
        updateMaterialOptions();


    </script>
@endpush
