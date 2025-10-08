@extends('dashboard.layouts.master')
@section('title', "Edit Price")

@push("after-styles")
<link href="{{ asset("assets/dashboard/js/iconpicker/fontawesome-iconpicker.min.css") }}" rel="stylesheet">
@endpush

@section('content')
<div class="padding">
    <div class="box">
        <div class="box-header dker">
            <h3><i class="material-icons">&#xe3c9;</i> Edit Price</h3>
            <small>
                <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                <a>Edit Price</a>
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
            {{ Form::model($prices, ['route' => ['price.update', $prices->id], 'method' => 'POST', 'files' => true, 'id'=>'priceForm']) }}

            {{-- Project --}}
            <div class="form-group row">
                <label for="project_id" class="col-sm-2 form-control-label">Project</label>
                <div class="col-sm-10">
                    <select name="project_id" id="project_id" class="form-control c-select">
                        <option value="0">-- Select Project --</option>
                        @foreach ($projects as $project)
                        <option value="{{ $project->id }}" {{ $project->id == old('project_id', $prices->project_id) ? 'selected' : '' }}>
                            {{ $project->title_en }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Flat --}}
            <div class="form-group row" id="flat_section">
                <label for="flat_id" class="col-sm-2 form-control-label">Flat </label>
                <div class="col-sm-10">
                    <select class="form-control c-select" id="flat_id" name="flat_id" required>
                        <option selected disabled>Select Flat</option>
                        @if($prices->flat)
                        <option value="{{ $prices->flat->id }}" selected>{{ $prices->flat->title }}</option>
                        @endif
                    </select>
                </div>
            </div>

            
            {{-- Flat Size --}}
            <div class="form-group row">
                <label class="col-sm-2 form-control-label">Flat Size</label>
                <div class="col-sm-10">
                    {!! Form::number('flat_size', old('flat_size', $prices->flat_size), ['id'=>'flat_size','class'=>'form-control']) !!}
                </div>
            </div>

            {{-- Customer --}}
            <div class="form-group row">
                <label for="customer_id" class="col-sm-2 form-control-label">Customer </label>
                <div class="col-sm-10">
                    <select name="customer_id" id="customer_id" class="form-control c-select">
                        <option value="0">-- Select Customer --</option>
                        @foreach ($contacts as $contact)
                        <option value="{{ $contact->id }}" {{ $contact->id == old('customer_id', $prices->customer_id) ? 'selected' : '' }}>
                            {{ $contact->first_name . ' ' . $contact->last_name . ' (' . $contact->phone . ')' }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Price Per Sqft --}}
            <div class="form-group row">
                <label class="col-sm-2 form-control-label">Is Negotiate Total Price?</label>
                <div class="col-sm-10">
                    <input type="hidden" name="is_negotiable_total_price" value="0">
                    {!! Form::checkbox('is_negotiable_total_price', 1, old('is_negotiable_total_price', $prices->is_negotiable_total_price), ['id'=>'is_negotiable_total_price']) !!}
                </div>
            </div>

            <div class="form-group row" id="price_per_sqft_group">
                <label class="col-sm-2 form-control-label">Price Per Sq.ft</label>
                <div class="col-sm-10">
                    {!! Form::number('price_per_sqft', old('price_per_sqft', $prices->price_per_sqft), ['id'=>'price_per_sqft','class'=>'form-control']) !!}
                </div>
            </div>

            {{-- Total Price --}}
            <div class="form-group row">
                <label class="col-sm-2 form-control-label">Total Price</label>
                <div class="col-sm-10">
                    {!! Form::number('price', old('price', $prices->price), ['id'=>'total_price','class'=>'form-control']) !!}
                </div>
            </div>

            {{-- Booking --}}
            <div class="form-group row">
                <label class="col-sm-2 form-control-label">Booking Amount</label>
                <div class="col-sm-10">
                    {!! Form::number('booking_amount', old('booking_amount', $prices->booking_amount), ['id'=>'booking_amount','class'=>'form-control']) !!}
                </div>
            </div>

            {{-- Downpayment --}}
            <div class="form-group row">
                <label class="col-sm-2 form-control-label">Downpayment Amount</label>
                <div class="col-sm-10">
                    {!! Form::number('downpayment_amount', old('downpayment_amount', $prices->downpayment_amount), ['id'=>'downpayment_amount','class'=>'form-control']) !!}
                </div>
            </div>

            {{-- Due Amount --}}
            <div class="form-group row">
                <label class="col-sm-2 form-control-label">Due Amount</label>
                <div class="col-sm-10">
                    {!! Form::number('due_amount', old('due_amount', $prices->due_amount), ['id'=>'due_amount','class'=>'form-control','readonly']) !!}
                </div>
            </div>

            {{-- EMI --}}
            <div class="form-group row">
                <label class="col-sm-2 form-control-label">EMI Amount (Per Month)</label>
                <div class="col-sm-10">
                    {!! Form::number('emi', old('emi', $prices->emi), ['id'=>'emi','class'=>'form-control']) !!}
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 form-control-label">EMI Count</label>
                <div class="col-sm-10">
                    {!! Form::number('emi_count', old('emi_count', $prices->emi_count), ['id'=>'emi_count','class'=>'form-control','readonly']) !!}
                </div>
            </div>

            {{-- EMI Start Date --}}
            <div class="form-group row">
                <label class="col-sm-2 form-control-label">EMI Start Date</label>
                <div class="col-sm-10">
                    {!! Form::date('emi_start_date', old('emi_start_date', $prices->emi_start_date), ['class'=>'form-control']) !!}
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
<script>
$(document).ready(function(){

    // Project → Flat AJAX
    $('#project_id').on('change', function(){
        let projectId = $(this).val();
        $.ajax({
            url: "{{ route('get.project.flats') }}",
            type: "POST",
            data: {_token:'{{ csrf_token() }}', project_id: projectId},
            success: function(response){
                let options = '<option selected disabled>Select Flat</option>';
                if(response.tags.length>0){
                    response.tags.forEach(function(tag){
                        let selected = tag.id == "{{ old('flat_id', $prices->flat_id) }}" ? 'selected' : '';
                        options += `<option value="${tag.id}" ${selected}>${tag.title}</option>`;
                    });
                    $('#flat_id').html(options).show();
                    $('#flat_section').show();
                } else {
                    $('#flat_id').html('<option>No flats found</option>');
                    $('#flat_section').hide();
                }
            }
        });
    });
    if($('#project_id').val() > 0) { $('#project_id').trigger('change'); }

    // Show/Hide price_per_sqft based on negotiate
    function togglePricePerSqft() {
        if($('#is_negotiable_total_price').is(':checked')) {
            $('#price_per_sqft_group').hide();
        } else {
            $('#price_per_sqft_group').show();
        }
    }
    $('#is_negotiable_total_price').change(togglePricePerSqft);
    togglePricePerSqft();


    function fieldEmptyifchecked() {
        if($('#is_negotiable_total_price').is(':checked')) {
            $("#total_price").val("");
            $("#price_per_sqft").val("");
            $("#booking_amount").val("");
            $("#downpayment_amount").val("");
            $("#due_amount").val("");
            $("#emi_amount").val("");
            $("#emi").val("");
            $("#emi_count").val("");

        } else {
            $("#total_price").val("");
            $("#price_per_sqft").val("");
            $("#booking_amount").val("");
            $("#downpayment_amount").val("");
            $("#due_amount").val("");
            $("#emi_amount").val("");
            $("#emi").val("");
            $("#emi_count").val("");
        }
    }

    $('#is_negotiable_total_price').change(function () {
        togglePricePerSqft();
        fieldEmptyifchecked();
    });

    // Total Price auto calculate (flat_size * price_per_sqft)
    function calculateTotalPrice() {
        let flatSize = parseFloat($('#flat_size').val()) || 0;
        let priceSqft = parseFloat($('#price_per_sqft').val()) || 0;
        let total = flatSize * priceSqft;
        $('#total_price').val(total);
        calculateDueAmount();
        calculateEMICount();
    }
    $('#flat_size, #price_per_sqft').on('input', calculateTotalPrice);

    // Due Amount = Total - (Booking + Downpayment)
    function calculateDueAmount() {
        let totalPrice = parseFloat($('#total_price').val()) || 0;
        let booking = parseFloat($('#booking_amount').val()) || 0;
        let downpayment = parseFloat($('#downpayment_amount').val()) || 0;
        let due = totalPrice - (booking + downpayment);
        $('#due_amount').val(due);
        calculateEMICount();
    }
    $('#booking_amount, #downpayment_amount').on('input', calculateDueAmount);

    // EMI Count = ceil(Due / EMI)
    function calculateEMICount() {
        let due = parseFloat($('#due_amount').val()) || 0;
        let emi = parseFloat($('#emi').val()) || 0;
        if(emi>0){
            let count = Math.ceil(due / emi);
            $('#emi_count').val(count);
        } else {
            $('#emi_count').val('');
        }
    }
    $('#emi').on('input', calculateEMICount);

    // Validation: Booking, Downpayment, EMI cannot exceed Total
    function validateAmounts() {
        let totalPrice = parseFloat($('#total_price').val()) || 0;
        let booking = parseFloat($('#booking_amount').val()) || 0;
        let downpayment = parseFloat($('#downpayment_amount').val()) || 0;
        let emi = parseFloat($('#emi').val()) || 0;
        let emiCount = parseFloat($('#emi_count').val()) || 0;
        let emiTotal = emi*emiCount;
        let totalPayable = booking + downpayment + emiTotal;

        if(booking>totalPrice){ 
            alert('Booking Amount cannot be greater than Total Price!'); $('#booking_amount').val(''); return false;
        }
        if(downpayment>totalPrice){ 
            alert('Downpayment Amount cannot be greater than Total Price!'); $('#downpayment_amount').val(''); return false;
        }
        if(emiTotal>totalPrice){ 
            alert('Total EMI (EMI × Count) cannot be greater than Total Price!'); $('#emi').val(''); $('#emi_count').val(''); return false;
        }
        if(totalPayable>totalPrice){ 
            alert('Booking + Downpayment + EMI total cannot be greater than Total Price!'); return false;
        }

        return true;
    }

    $('#booking_amount, #downpayment_amount, #emi, #emi_count, #total_price').on('input', validateAmounts);

    $('#priceForm').on('submit', function(e){
        if(!validateAmounts()){ e.preventDefault(); }
    });

});

</script>
@endpush
