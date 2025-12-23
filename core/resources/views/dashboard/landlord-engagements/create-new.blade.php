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
<style>
    .select2-container {
        width: 100% !important;
    }

    /* Make search box full width & slightly tall like textarea */
    .select2-container .select2-search__field {
        width: 100% !important;
        min-height: 35px;
        line-height: 20px;
    }
</style>

@endpush
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3><i class="material-icons">&#xe02e;</i> Add Engagement</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                    <a>Add Engagement</a> /
                    <a>List of Engagements</a>
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
                    <div class="form-group row">
                        <label for="customer_id" class="col-sm-2 form-control-label">Landlord *</label>
                        <div class="col-sm-10">
                            <select name="customer_id" id="customer_id" class="form-control select2-multi" required>
                                <option value="0">- - Select Landlord - -</option>
                                @foreach ($contacts as $contact)
                                    <option value="{{ $contact->id }}">{{ $contact->first_name . ' ' . $contact->last_name . ' (' . $contact->phone  . ')' }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="section-wrapper">
                        <div class="section-item">
                            <!-- Shareholders -->
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label">Landlord Shareholders*</label>
                                <div class="col-sm-10">
                                    <select name="customer_shareholders[0][]" class="form-control select2 shareholder-select" multiple required>
                                        <option value="">-- Select Landlord Shareholders --</option>
                                        @foreach ($contacts as $contact)
                                            <option value="{{ $contact->id }}">{{ $contact->first_name . ' ' . $contact->last_name . ' (' . $contact->phone  . ')' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Flat -->
                            <div class="form-group row flat-section" style="display: none;">
                                <label class="col-sm-2 form-control-label">Flat *</label>
                                <div class="col-sm-10">
                                    <select class="form-control select2 flat-select" name="flat_id[0][]" multiple required>
                                        <option disabled>Select Flat</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Documents -->
                            <div class="document-wrapper">
                                <div class="form-group row document-item">
                                    <label class="col-sm-2 form-control-label">Documents</label>
                                    <div class="col-sm-4">
                                        <select name="document_type_id[0][]" class="form-control c-select">
                                            <option value="">-- Select Document Type --</option>
                                            @foreach($documentTypes as $documentType)
                                                <option value="{{ $documentType->id }}">{{ $documentType->document_type }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-4">
                                        <input type="file" name="document[0][]" class="form-control" accept="application/pdf,image/*">
                                    </div>
                                </div>
                            </div>

                            <!-- Materials -->
                            <div class="material-wrapper">
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
                                    <div class="col-sm-4">
                                        <input type="text" name="material_details[0][]" class="form-control" placeholder="Material Details">
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-danger btn-sm remove-section">−</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success btn-sm mt-2" id="add-section">+</button>
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

                            // $('#flat_id').html(options);
                            // $('#flat_section').show();
                        } else {
                            $('#flat_id').html('<option>No tags found</option>');
                            $('#flat_section').hide();
                        }
                    }
                });
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

    <script>
        $(document).ready(function() {

            // Apply Select2 to ALL select boxes with the class
            $('.select2-multi').select2({
                placeholder: '-- Select --',
                allowClear: true,
                width: '100%'
            });

            // Flat ID special AJAX loader
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
                        let html = "";

                        if (response.tags.length > 0) {
                            response.tags.forEach(function(tag){
                                html += `<option value="${tag.id}">${tag.title}</option>`;
                            });

                            $('#flat_id').html(html).trigger('change');
                            $('#flat_section').show();
                        } else {
                            $('#flat_id').html("").trigger('change');
                            $('#flat_section').hide();
                        }
                    }
                });
            });
            // Add new section
            // // Show flat section only if at least one shareholder selected
            // function updateOptions() {
            //     // Collect all selected shareholders (ignore empty/0)
            //     let selectedShareholders = $(".shareholder-select").map(function() {
            //         return $(this).val() || [];
            //     }).get().flat();
            //     $(".shareholder-select").each(function() {
            //         let currentVal = $(this).val() || [];
            //         $(this).find("option").each(function() {
            //             let val = $(this).val();
            //             if(val !== "0" && selectedShareholders.includes(val) && !currentVal.includes(val)){
            //                 $(this).hide();
            //             } else {
            //                 $(this).show();
            //             }
            //         });
            //     });

            //     // Collect all selected flats (ignore empty)
            //     let selectedFlats = $(".flat-select").map(function() {
            //         return $(this).val() || [];
            //     }).get().flat();
            //     console.log(selectedFlats);
            //     $(".flat-select").each(function() {
            //         let currentVal = $(this).val() || [];
            //         $(this).find("option").each(function() {
            //             let val = $(this).val();
            //             if(val !== "" && selectedFlats.includes(val) && !currentVal.includes(val)){
            //                 $(this).hide();
            //             } else {
            //                 $(this).show();
            //             }
            //         });
            //     });
            // }

            // // Show/hide flat_section based on shareholder selection
            // $(document).on('change', ".shareholder-select", function(){
            //     let selected = $(this).val();
            //     $(this).closest(".section-item").find("#flat_section").toggle(selected && selected.length > 0);
            //     updateOptions();
            // });

            // // Add more section
            // $(document).on("click", ".add-section", function(){
            //     let section = $(this).closest(".section-item");

            //     // Shareholder selected?
            //     let shareholderVal = section.find(".shareholder-select").val();
            //     if(!shareholderVal || shareholderVal.length == 0){
            //         alert("Please select at least one shareholder!");
            //         return;
            //     }

            //     // Flat selected?
            //     let flatVal = section.find(".flat-select").val();
            //     let validFlats = flatVal ? flatVal.filter(v => v != "" && v != null) : [];
            //     if(validFlats.length == 0){
            //         alert("Please select at least one flat!");
            //         return;
            //     }
            //     // Clone section
            //     let clone = section.clone();

            //     // Reset selects and inputs in clone
            //     clone.find(".shareholder-select").val(null).trigger('change');
            //     clone.find(".flat-select").val(null).trigger('change');
            //     clone.find("input[type=file]").val("");

            //     // Change add button to remove button
            //     clone.find(".add-section")
            //         .removeClass("btn-success add-section")
            //         .addClass("btn-danger remove-section")
            //         .text("-");

            //     // Append clone
            //     $("#section-wrapper").append(clone);

            //     // Update options to prevent duplicates in all sections
            //     updateOptions();
            // });

            // // Remove section
            // $(document).on("click", ".remove-section", function(){
            //     $(this).closest(".section-item").remove();
            //     updateOptions();
            // });

            let index = 1;

$(document).ready(function () {

    // Initialize all select2
    $('.select2,.select2-multi').select2({
        width: '100%'
    });

    // PROJECT → LOAD FLATS
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

                let options = "";

                if (response.tags.length > 0) {
                    response.tags.forEach(tag => {
                        options += `<option value="${tag.id}">${tag.title}</option>`;
                    });

                    // Update all flat dropdowns
                    $(".flat-select").each(function () {
                        $(this).html(options);
                    });

                    $(".flat-section").show();
                } else {
                    $(".flat-select").html("");
                    $(".flat-section").hide();
                }
            }
        });
    });

    // ADD NEW SECTION
    $("#add-section").click(function () {

        let clone = $(".section-item:first").clone();

        // reset values
        clone.find("select").val(null).trigger("change");
        clone.find("input[type=file]").val("");

        // update name indexes
        clone.find("select, input").each(function () {
            let name = $(this).attr("name");
            if (name) { // only proceed if name exists
                let newName = name.replace("[0]", "[" + index + "]");
                $(this).attr("name", newName);
            }
        });


        index++;

        // Re-init select2
        clone.find(".select2").select2({
            width: '100%'
        });

        // Change last button to remove
        clone.find(".remove-section").show();

        $("#section-wrapper").append(clone);
    });

    // REMOVE SECTION
    $(document).on("click", ".remove-section", function () {
        if ($(".section-item").length > 1) {
            $(this).closest(".section-item").remove();
        }
    });

});


        });
    </script>
@endpush
