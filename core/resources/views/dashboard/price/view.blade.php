@extends('dashboard.layouts.master')
@section('title', "Edit Price")

@push("after-styles")
    <link href="{{ asset("assets/dashboard/js/iconpicker/fontawesome-iconpicker.min.css") }}" rel="stylesheet">
@endpush

@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3><i class="material-icons">&#xe3c9;</i> Price View</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                    <a>View Price</a>
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
                    <div class="form-group row">
                        <label for="project_id" class="col-sm-2 form-control-label">Project</label>
                        <div class="col-sm-10">
                            <select name="project_id" id="project_id" class="form-control c-select" disabled>
                                <option value="0">-- Select Project --</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}" data-project_id="{{ $project->id }}" {{ $project->id == old('project_id', $prices->project_id) ? 'selected' : '' }}>
                                        {{ $project->title_en }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row" id="flat_section">
                        <label for="flat_id" class="col-sm-2 form-control-label">Flat </label>
                        <div class="col-sm-10">
                            <select class="form-control c-select" id="flat_id" name="flat_id" required disabled>
                                <option selected disabled>Select Flat</option>
                                @if($prices->flat)
                                    <option value="{{ $prices->flat->id }}" selected>{{ $prices->flat->title }}</option>
                                @endif
                            </select>
                        </div>
                        @error('flat_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group row">
                        <label for="customer_id" class="col-sm-2 form-control-label">Customer </label>
                        <div class="col-sm-10">
                            <select name="customer_id" id="customer_id" class="form-control c-select" disabled>
                                <option value="0">-- Select Customer --</option>
                                @foreach ($contacts as $contact)
                                    <option value="{{ $contact->id }}"
                                        {{ $contact->id == old('customer_id', $prices->customer_id) ? 'selected' : '' }}>
                                        {{ $contact->first_name . ' ' . $contact->last_name . ' (' . $contact->phone . ')' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Price --}}
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">Price</label>
                        <div class="col-sm-10">
                            {!! Form::number('price', old('price', $prices->price), ['class' => 'form-control', 'required', 'readonly']) !!}
                        </div>
                    </div>

                    {{-- EMI --}}
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">EMI</label>
                        <div class="col-sm-10">
                            {!! Form::number('emi', old('emi', $prices->emi), ['class' => 'form-control', 'required' , 'readonly']) !!}
                        </div>
                    </div>

                    {{-- Booking Amount --}}
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">Booking Amount</label>
                        <div class="col-sm-10">
                            {!! Form::number('booking_amount', old('booking_amount', $prices->booking_amount), ['class' => 'form-control', 'required' , 'readonly']) !!}
                        </div>
                    </div>

                    {{-- Downpayment --}}
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">Downpayment Amount</label>
                        <div class="col-sm-10">
                            {!! Form::number('downpayment_amount', old('downpayment_amount', $prices->downpayment_amount), ['class' => 'form-control', 'required' , 'readonly']) !!}
                        </div>
                    </div>

                    {{-- EMI Count --}}
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">EMI Count</label>
                        <div class="col-sm-10">
                            {!! Form::number('emi_count', old('emi_count', $prices->emi_count), ['class' => 'form-control', 'required' , 'readonly']) !!}
                        </div>
                    </div>

                    {{-- EMI Start Date --}}
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">EMI Start Date</label>
                        <div class="col-sm-10">
                            {!! Form::date('emi_start_date', old('emi_start_date', $prices->emi_start_date), ['class' => 'form-control', 'required' , 'readonly']) !!}
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection

@push("after-scripts")
    <script src="{{ asset("assets/dashboard/js/iconpicker/fontawesome-iconpicker.js") }}"></script>
    <script>
        $(document).ready(function () {
        $('#project_id').on('change', function () {
            let projectId = $(this).val();
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
                            options += `<option value="${tag.id}" 
                                ${tag.id == "{{ $prices->flat_id }}" ? 'selected' : ''}>
                                ${tag.title}
                            </option>`;
                        });
                        $('#flat_id').html(options);
                        $('#flat_section').show();
                    } else {
                        $('#flat_id').html('<option>No flats found</option>');
                        $('#flat_section').hide();
                    }
                }
            });
        });

        // 🚀 এই লাইন যোগ করুন যেন edit page load এ auto-call হয়
        if ($('#project_id').val() > 0) {
            $('#project_id').trigger('change');
        }
    });

    </script>
@endpush
