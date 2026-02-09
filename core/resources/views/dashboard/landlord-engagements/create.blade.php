<?php
$projects = Helper::Topics(8);
?>
@extends('dashboard.layouts.master')
@section('title', "Create Engagement")
@push("after-styles")
    <link href="{{ asset("assets/dashboard/js/iconpicker/fontawesome-iconpicker.min.css") }}" rel="stylesheet">
    <style>
        .d-none{
            display: none !important;
        }
    </style>
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
@endpush
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3><i class="material-icons">&#xe02e;</i> Add Engagement</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                    <a href="{{ route('landlord-engagements.create') }}">Add Engagement</a> /
                    <a href="{{ route('landlordEngagements') }}">List of Engagements</a>
                </small>
            </div>
            <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline">
                        <a class="nav-link" href="{{ route('landlordEngagements') }}">
                            <i class="material-icons md-18">×</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="box-body p-a-2">
                {{Form::open(['route'=>['landlord-engagements.store'],'method'=>'POST','files'=>true])}}
                
                    <div class="form-group row">
                        <label for="project_id" class="col-sm-2 form-control-label">Project * </label>
                        <div class="col-sm-10">
                            <select name="project_id" id="project_id" class="form-control c-select" required>
                                <option value="">-- Select Project --</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" data-project_id="{{ $project->id }}"
                                        {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                        {{ $project->title_en }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="document-wrapper project-doc-wrapper">
                        @if(old('project_document_type_id'))
                            @foreach(old('project_document_type_id') as $i => $docTypeId)
                                <div class="form-group row document-item">
                                    @if($i == 0)
                                        <label class="col-sm-2 form-control-label">Project Documents</label>
                                    @else
                                        <label class="col-sm-2 form-control-label">&nbsp;</label>
                                    @endif

                                    <div class="col-sm-4">
                                        <select name="project_document_type_id[]" class="form-control c-select">
                                            <option value="">-- Select Document Type --</option>
                                            @foreach($documentTypes as $documentType)
                                                <option value="{{ $documentType->id }}"
                                                    {{ $docTypeId == $documentType->id ? 'selected' : '' }}>
                                                    {{ $documentType->document_type }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-4">
                                        {!! Form::file('project_document[]', [
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
                                <label class="col-sm-2 form-control-label">Project Documents(Max 10MB- pdf,jpg,jpeg,png)</label>
                                <div class="col-sm-4">
                                    <select name="project_document_type_id[]" class="form-control c-select">
                                        <option value="">-- Select Document Type --</option>
                                        @foreach($documentTypes as $documentType)
                                            <option value="{{ $documentType->id }}">{{ $documentType->document_type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    {!! Form::file('project_document[]', [
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
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label class="form-control-label">Facilities </label>
                        </div>
                        <div class="col-sm-3">
                            <label for="number_of_parking" class="form-control-label">Number of parking </label>
                            <input type="number" name="number_of_parking" id="number_of_parking" class="form-control" value="{{ old('number_of_parking') }}" min="0">
                        </div>
                        <div class="col-sm-3">
                            <label for="no_of_gas_connection" class="form-control-label">Number of Gas Connection </label>
                            <input type="number" name="number_of_gas_connection" id="number_of_gas_connection" class="form-control" value="{{ old('number_of_gas_connection') }}" min="0">
                        </div>
                        <div class="col-sm-3">
                            <label for="no_of_utility" class="form-control-label">Number of Utility </label>
                            <input type="number" name="number_of_utility" id="number_of_utility" class="form-control" value="{{ old('number_of_utility') }}" min="0">
                        </div>
                    </div> 
                    <div id="engagement-wrapper" >
                        <div class="engagement-set card flat-section"  style="padding: 20px;" >
                            <div class="form-group row">
                                <label for="landlord_id" class="col-sm-2 form-control-label">Landlord *</label>
                                <div class="col-sm-10">
                                    <select name="landlord_id[]" id="landlord_id" class="form-control c-select landlord-select" required>
                                        <option value="0">-- Select Landlord --</option>
                                        @foreach ($contacts as $contact)
                                            <option value="{{ $contact->id  }}" {{ old('landlord_id') == $contact->id ? 'selected' : '' }}>{{ $contact->first_name . ' ' . $contact->last_name . ' (' . $contact->phone  . ')' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row" id="flat_section">
                                <label for="flat_id" class="col-sm-2 form-control-label">Flat *</label>
                                <div class="col-sm-10">
                                    <select class="form-control c-select flat-select" id="flat_id" name="flat_id[]" required>
                                        <option selected disabled>Select Flat</option>
                                    </select>
                                </div>
                                @error('flat_id')
                                    <small class="text-white">{{ $message }}</small>   
                                @enderror
                            </div>
                            <div class="document-wrapper flat-doc-wrapper">
                                @if(old('flat_document_type_id'))
                                    @foreach(old('flat_document_type_id') as $i => $docTypeId)
                                        <div class="form-group row document-item">
                                            @if($i == 0)
                                                <label class="col-sm-2 form-control-label">Flat Documents</label>
                                            @else
                                                <label class="col-sm-2 form-control-label">&nbsp;</label>
                                            @endif

                                            <div class="col-sm-4">
                                                <select name="flat_document_type_id[][]" class="form-control c-select">
                                                    <option value="">-- Select Document Type --</option>
                                                    @foreach($documentTypes as $documentType)
                                                        <option value="{{ $documentType->id }}"
                                                            {{ $docTypeId == $documentType->id ? 'selected' : '' }}>
                                                            {{ $documentType->document_type }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-sm-4">
                                                {!! Form::file('flat_document[][]', [
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
                                        <label class="col-sm-2 form-control-label">Flat Documents(Max 10MB- pdf,jpg,jpeg,png)</label>
                                        <div class="col-sm-4">
                                            <select name="flat_document_type_id[0][]" class="form-control c-select">
                                                <option value="">-- Select Document Type --</option>
                                                @foreach($documentTypes as $documentType)
                                                    <option value="{{ $documentType->id }}">{{ $documentType->document_type }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            {!! Form::file('flat_document[0][]', [
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

                            <div class="material-wrapper" id="material-wrapper">

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
                                                    @foreach($materials as $material)
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
                                                    class="form-control"
                                                    placeholder="Note"
                                                    value="{{ old('material_details')[$i] ?? '' }}">
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
                                            <select name="material_type_id[0][]" class="form-control material-type">
                                                <option value="">-- Select Material --</option>
                                                @foreach($materialTypes as $material)
                                                    <option value="{{ $material->id }}">{{ $material->material_type }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-sm-2">
                                            <input type="text" 
                                                name="material_details[0][]" 
                                                class="form-control"
                                                placeholder="Note">
                                        </div>

                                        <div class="col-sm-2">
                                            <input type="file" 
                                                name="material_document[0][]" 
                                                class="form-control"
                                                placeholder="Material Document"
                                                value="">
                                        </div>

                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-success add-material">+</button>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group row">
                                    <div class="col-sm-12 text-right">
                                        <button type="button" class="btn btn-danger remove-engagement d-none">Remove Engagement</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" id="addEngagementSet">Add More</button>
                </div>
                <div class="form-group row m-t-md">
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-lg btn-primary m-t"><i class="material-icons">
                                &#xe31b;</i> Save</button>
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
        /* ------------------ BASIC INITIALIZERS ------------------ */
        $(function () {
            $('.icp-auto').iconpicker({
                placement: '{{ (@Helper::currentLanguage()->direction=="rtl")?"topLeft":"topRight" }}'
            });
        });

        $(document).ready(function () {

            /* ------------------ PROJECT → FLAT LOAD ------------------ */
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
                            response.flats.forEach(flat => {
                                options += `<option value="${flat.id}">${flat.flat_name}</option>`;
                            });

                            $('#flat_id').html(options);
                            // $('#flat_section').show();
                        } else {
                            $('#flat_id').html('<option>No flats found</option>');
                            // $('#flat_section').hide();
                        }
                    }
                });
            });

            $(document).on('change', '.flat-select', function () {

                let flatId = $(this).val();
                if (!flatId) return;

                // closest flat section
                let $section = $(this).closest('.flat-section');

                // Flat Documents (only inside this section)
                $section.find('.flat-doc-wrapper')
                    .find('select[name], input[type="file"][name]')
                    .each(function () {

                        let name = $(this).attr('name');
                        name = name.replace(/\[\d+\]/g, '[' + flatId + ']');
                        $(this).attr('name', name);
                    });

                // Materials (only inside this section)
                $section.find('.material-wrapper')
                    .find('select[name], input[name]')
                    .each(function () {

                        let name = $(this).attr('name');
                        name = name.replace(/\[\d+\]/g, '[' + flatId + ']');
                        $(this).attr('name', name);
                    });

            });

            function toggleAddButton(wrapper) {
                let select = wrapper.find("select").first();
                let totalOptions = select.find("option").not("[value='']").length;

                let selectedValues = [];
                wrapper.find("select").each(function () {
                    if ($(this).val()) {
                        selectedValues.push($(this).val());
                    }
                });

                if (selectedValues.length >= totalOptions) {
                    wrapper.find(".add-doc").hide();
                } else {
                    wrapper.find(".add-doc").show();
                }
            }

            /* ------------------ DOCUMENT LOGIC ------------------ */
            function updateDocumentTypeOptions(wrapper) {
                let selectName = wrapper.hasClass("project-doc-wrapper")
                    ? "project_document_type_id[]"
                    : "flat_document_type_id";

                let selectedValues = [];

                wrapper.find(`select[name^='${selectName}']`).each(function () {
                    let val = $(this).val();
                    if (val) selectedValues.push(val);
                });
                wrapper.find(`select[name^='${selectName}']`).each(function () {
                    let currentVal = $(this).val();

                    $(this).find("option").each(function () {
                        let optVal = $(this).val();

                        if (optVal === "") {
                            $(this).show();
                        } else if (optVal == currentVal) {
                            $(this).show();
                        } else if (selectedValues.includes(optVal)) {
                            $(this).hide();
                        } else {
                            $(this).show();
                        }
                    });

                    let fileInput = $(this).closest(".document-item").find("input[type='file']");
                    fileInput.prop("required", !!currentVal);
                });

                toggleAddButton(wrapper);
            }


            $(document).on("click", ".add-doc", function () {

                let wrapper = $(this).closest(".document-wrapper");

                let selectName = wrapper.hasClass("project-doc-wrapper")
                    ? "project_document_type_id[]"
                    : "flat_document_type_id";

                let allSelected = true;

                wrapper.find(`select[name^='${selectName}']`).each(function () {
                    if ($(this).val() === "") {
                        allSelected = false;
                        return false;
                    }
                });

                if (!allSelected) {
                    alert("Please select a document type in all rows before adding a new one.");
                    return;
                }

                let item = $(this).closest(".document-item");
                let clone = item.clone(false, false);

                clone.find("select").val("");
                clone.find("input[type='file']").val("");
                clone.find("label").html("&nbsp;");

                clone.find(".add-doc")
                    .removeClass("btn-success add-doc")
                    .addClass("btn-danger remove-doc")
                    .text("-");

                wrapper.append(clone);

                updateDocumentTypeOptions(wrapper);
            });


            // REMOVE DOCUMENT
            $(document).on("click", ".remove-doc", function () {
                let wrapper = $(this).closest(".document-wrapper");
                $(this).closest(".document-item").remove();
                updateDocumentTypeOptions(wrapper);
            });


            // ON CHANGE UPDATE
            $(document).on(
                "change",
                "select[name^='project_document_type_id'], select[name^='flat_document_type_id']",
                function () {
                    let wrapper = $(this).closest(".document-wrapper");
                    updateDocumentTypeOptions(wrapper);
                }
            );

            // INITIAL UPDATE
            $(".document-wrapper").each(function () {
                updateDocumentTypeOptions($(this));
            });

            function toggleMaterialAddButton(wrapper) {
                let totalOptions = wrapper.find("select.material-type:first option")
                    .not('[value=""]').length;

                let selectedCount = wrapper.find("select.material-type")
                    .filter(function () {
                        return $(this).val() !== "";
                    }).length;

                let addBtn = wrapper.find(".add-material");

                if (selectedCount >= totalOptions) {
                    addBtn.hide();
                } else {
                    addBtn.show();
                }
            }

            /* ------------------ MATERIAL LOGIC ------------------ */
            function updateMaterialOptions(wrapper) {
                if (!wrapper) return;

                let selectedValues = [];
                wrapper.find("select.material-type").each(function () {
                    let val = $(this).val();
                    if (val) selectedValues.push(val);
                });
                wrapper.find("select.material-type").each(function () {
                    let currentVal = $(this).val();
                    $(this).find("option").each(function () {
                        if ($(this).val() === "") $(this).show();
                        else if ($(this).val() == currentVal) $(this).show();
                        else if (selectedValues.includes($(this).val())) $(this).hide();
                        else $(this).show();
                    });

                    let detailsInput = $(this).closest(".material-item").find("input[name='material_details[][]']");
                    detailsInput.prop("required", !!$(this).val());
                });
                toggleMaterialAddButton(wrapper);
            }

            $(document).on("click", ".add-material", function () {
                let wrapper = $(this).closest(".engagement-set");
                let matWrapper = wrapper.find("#material-wrapper");


                let allSelected = true;
                wrapper.find("select.material-type").each(function () {
                    if ($(this).val() === "") {
                        allSelected = false;
                        return false;
                    }
                });
                if (!allSelected) {
                    alert("Please select a material type in all rows before adding a new one.");
                    return;
                }

                let item = $(this).closest(".material-item");
                let clone = item.clone(false, false);

                clone.find("select").val("");
                clone.find("input").val("");
                clone.find("label").html("&nbsp;");

                clone.find(".add-material")
                    .removeClass("btn-success add-material")
                    .addClass("btn-danger remove-material")
                    .text("-");

                matWrapper.append(clone);
                updateMaterialOptions(wrapper);
            });

            $(document).on("click", ".remove-material", function () {
                let wrapper = $(this).closest(".engagement-set");
                $(this).closest(".material-item").remove();
                updateMaterialOptions(wrapper);
            });

            $(document).on("change", "select.material-type", function () {
                let wrapper = $(this).closest(".engagement-set");
                updateMaterialOptions(wrapper);
            });

            $(".engagement-set").each(function () {
                updateMaterialOptions($(this));
            });


            $("form").on("submit", function (e) {
                let valid = true;
                $(".material-item").each(function () {
                    let type = $(this).find("select.material-type").val();
                    let details = $(this).find("input[name^='material_details']").val();
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

            /* ------------------ ENGAGEMENT SET LOGIC ------------------ */
            let usedPairs = [];
            let setIndex = 1;

            function updateFlatOptions(flatSelect, projectId) {
                $.ajax({
                    url: "{{ route('get.project.flats') }}",
                    type: "POST",
                    data: { _token: '{{ csrf_token() }}', project_id: projectId },
                    success: function (response) {
                        let options = '<option value="">-- Select Flat --</option>';
                        response.flats.forEach(flat => {
                            let alreadyUsed = usedPairs.some(pair => pair.split("-")[1] == flat.id);
                            if (!alreadyUsed) options += `<option value="${flat.id}">${flat.flat_name}</option>`;
                        });
                        flatSelect.html(options);
                        flatSelect.closest(".flat-row").show();
                    }
                });
            }

            $(document).on("change", ".landlord-select", function () {
                let landlordId = $(this).val();
                let projectId = $("#project_id").val();
                let flatSelect = $(this).closest(".engagement-set").find(".flat-select");

                if (!projectId) {
                    alert("Please select a Project first!");
                    $(this).val("");
                    return;
                }

                updateFlatOptions(flatSelect, projectId);
            });

            $("#addEngagementSet").on("click", function () {
                let lastSet = $(".engagement-set").last();
                let landlord = lastSet.find(".landlord-select").val();
                let flat = lastSet.find(".flat-select").val();

                if (!landlord || !flat) {
                    alert("Please select both Landlord & Flat before adding a new set.");
                    return;
                }

                let pairKey = landlord + "-" + flat;
                if (usedPairs.includes(pairKey)) {
                    alert("This Landlord + Flat combination is already used.");
                    return;
                }

                usedPairs.push(pairKey);

                let clone = lastSet.clone(false);

                // reset inputs
                clone.find("select").val("");
                clone.find("input").val("");

                // hide flat row
                clone.find(".flat-row").hide();

                // reset document rows (keep first only)
                clone.find(".document-item").not(":first").remove();
                clone.find(".document-item").first().find("select").val("");
                clone.find(".document-item").first().find("input[type='file']").val("");

                // reset material rows (keep first only)
                clone.find(".material-item").not(":first").remove();
                clone.find(".material-item").first().find("select").val("");
                clone.find(".material-item").first().find("input").val("");

                // show remove engagement button
                clone.find(".remove-engagement").removeClass("d-none");

                $("#engagement-wrapper").append(clone);
                setIndex++;


                $(".engagement-set").each(function () {
                    updateDocumentTypeOptions($(this));
                    updateMaterialOptions($(this));
                });
            });

            $(document).on("click", ".remove-engagement", function () {
                let removedSet = $(this).closest(".engagement-set");
                let landlord = removedSet.find(".landlord-select").val();
                let flat = removedSet.find(".flat-select").val();

                if (landlord && flat) {
                    let index = usedPairs.indexOf(landlord + "-" + flat);
                    if (index > -1) usedPairs.splice(index, 1);
                }

                removedSet.remove();

                $(".engagement-set").each(function () {
                    updateDocumentTypeOptions($(this));
                    updateMaterialOptions($(this));
                });
            });

        });
    </script>
@endpush
