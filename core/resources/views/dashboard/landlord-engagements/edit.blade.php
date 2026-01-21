@extends('dashboard.layouts.master')
@section('title', "Edit Engagement")

@push("after-styles")
<link href="{{ asset("assets/dashboard/js/iconpicker/fontawesome-iconpicker.min.css") }}" rel="stylesheet">
<style>
    .d-none{display:none!important;}
    .card{border:1px solid #ddd;margin-bottom:15px;}
</style>
@endpush

@section('content')
<div class="padding">
    <div class="box">
        <div class="box-header dker">
            <h3><i class="material-icons">&#xe3c9;</i> Edit Engagement</h3>
        </div>

        <div class="box-body p-a-2">

            <form method="POST"
                action="{{ route('landlord-engagements.update', $project->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- PROJECT --}}
                <div class="form-group row">
                    <label class="col-sm-2 form-control-label">Project *</label>
                    <div class="col-sm-10">
                        <select class="form-control" disabled>
                            <option>{{ $project->title_en }}</option>
                        </select>
                        <input type="hidden" id="project_id" name="project_id" value="{{ $project->id }}">
                    </div>
                </div>

                <div class="document-wrapper project-doc-wrapper">

                {{-- ===== EXISTING PROJECT DOCUMENTS ===== --}}
                @if(isset($project_documents) && $project_documents->count())
                    @foreach($project_documents as $i => $doc)
                        <div class="form-group row document-item">

                            {{-- LABEL --}}
                            <label class="col-sm-2 form-control-label">
                                {{ $i == 0 ? 'Project Documents (Max 10MB- pdf,jpg,jpeg,png)' : '' }}
                            </label>

                            {{-- TYPE + HIDDEN --}}
                            <div class="col-sm-4">
                                <select name="project_document_type_id[]" class="form-control c-select">
                                    <option value="">-- Select Document Type --</option>
                                    @foreach($documentTypes as $documentType)
                                        <option value="{{ $documentType->id }}"
                                            {{ $doc->document_type_id == $documentType->id ? 'selected' : '' }}>
                                            {{ $documentType->document_type }}
                                        </option>
                                    @endforeach
                                </select>

                                {{-- existing id --}}
                                <input type="hidden"
                                    name="project_document_id[]"
                                    value="{{ $doc->id }}">

                                {{-- old file --}}
                                <input type="hidden"
                                    name="old_project_document[]"
                                    value="{{ $doc->file_path }}">
                            </div>

                            {{-- FILE --}}
                            <div class="col-sm-4">
                                <div class="file-preview mb-1">
                                    <a href="{{ asset('storage/'.$doc->file_path) }}"
                                    target="_blank"
                                    class="btn btn-sm btn-info">
                                        View
                                    </a>
                                </div>

                                <input type="file"
                                    name="project_document[]"
                                    class="form-control"
                                    accept="application/pdf,image/*">
                            </div>

                            {{-- ACTION --}}
                            <div class="col-sm-2">
                                @if($i == 0)
                                    <button type="button" class="btn btn-success add-doc">+</button>
                                @else
                                    <button type="button" class="btn btn-danger remove-doc remove-old-project-doc">-</button>
                                @endif
                            </div>

                        </div>
                    @endforeach


                {{-- ===== NO EXISTING DOCS (FIRST TIME) ===== --}}
                @else
                    <div class="form-group row document-item">

                        <label class="col-sm-2 form-control-label">
                            Project Documents (Max 10MB- pdf,jpg,jpeg,png)
                        </label>

                        <div class="col-sm-4">
                            <select name="project_document_type_id[]" class="form-control c-select">
                                <option value="">-- Select Document Type --</option>
                                @foreach($documentTypes as $documentType)
                                    <option value="{{ $documentType->id }}">
                                        {{ $documentType->document_type }}
                                    </option>
                                @endforeach
                            </select>

                            {{-- empty = new --}}
                            <input type="hidden" name="project_document_id[]" value="">
                            <input type="hidden" name="old_project_document[]" value="">
                        </div>

                        <div class="col-sm-4">
                            <input type="file"
                                name="project_document[]"
                                class="form-control"
                                accept="application/pdf,image/*">
                        </div>

                        <div class="col-sm-2">
                            <button type="button" class="btn btn-success add-doc">+</button>
                        </div>

                    </div>
                @endif

                </div>


                {{-- ================= ENGAGEMENT SETS ================= --}}
                <div id="engagement-wrapper">

                @foreach($engagements as $eIndex => $engagement)
                <div class="engagement-set card flat-section" style="padding: 20px;">

                    <input type="hidden" name="engagement_id[{{ $eIndex }}]" value="{{ $engagement->id }}">

                    {{-- LANDLORD --}}
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">Landlord *</label>
                        <div class="col-sm-10">
                            <select name="landlord_id[]" class="form-control landlord-select" required>
                                <option value="">-- Select Landlord --</option>
                                @foreach($contacts as $c)
                                    <option value="{{ $c->id }}"
                                        {{ $engagement->landlord_id == $c->id ? 'selected' : '' }}>
                                        {{ $c->first_name }} {{ $c->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- FLAT --}}
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">Flat *</label>
                        <div class="col-sm-10">
                            <select name="flats[{{ $eIndex }}][flat_id]" class="form-control flat-select">
                                <option value="{{ $engagement->flat->id }}" selected>
                                    {{ $engagement->flat->title }}
                                </option>
                            </select>
                        </div>
                    </div>

                    {{-- ================= FLAT DOCUMENTS ================= --}}
                    <div class="document-wrapper flat-doc-wrapper">
                    @forelse($engagement->flatDocuments as $dIndex => $doc)
                    <div class="form-group row document-item">
                        <label class="col-sm-2 form-control-label">
                            {{ $dIndex == 0 ? 'Flat Documents' : '' }}
                        </label>

                        <div class="col-sm-4">
                            <select name="flat_document_type_id[{{ $engagement->flat->id }}][]" class="form-control">
                                <option value="">-- Select Type --</option>
                                @foreach($documentTypes as $dt)
                                    <option value="{{ $dt->id }}"
                                        {{ $doc->document_type_id == $dt->id ? 'selected' : '' }}>
                                        {{ $dt->document_type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-4">
                            <input type="file" name="flat_document[{{ $engagement->flat->id }}][]" class="form-control">
                            <div class="file-preview">
                                <small class="text-muted">Existing: {{ basename($doc->file_path) }}</small>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            @if($dIndex==0)
                                <button type="button" class="btn btn-success add-doc">+</button>
                            @else
                                <button type="button" class="btn btn-danger remove-doc remove-old-flat-doc">-</button>
                            @endif
                        </div>
                        <input type="hidden" name="flat_document_id[{{ $engagement->flat->id }}][]" value="{{ $doc->id }}">
                        <input type="hidden" name="old_flat_document[{{ $engagement->flat->id }}][]" value="{{ $doc->file_path }}">
                    </div>
                    @empty
                    {{-- default --}}
                    <div class="form-group row document-item">
                        <label class="col-sm-2 form-control-label">Flat Documents</label>
                        <div class="col-sm-4">
                            <select name="flat_document_type_id[{{ $engagement->flat->id }}][]" class="form-control">
                                <option value="">-- Select Type --</option>
                                @foreach($documentTypes as $dt)
                                    <option value="{{ $dt->id }}">{{ $dt->document_type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <input type="file" name="flat_document[{{ $engagement->flat->id }}][]" class="form-control">
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-success add-doc">+</button>
                        </div>
                    </div>
                    @endforelse
                    </div>

                    {{-- ================= MATERIALS ================= --}}
                    <div class="document-wrapper material-wrapper">
                    @forelse($engagement->materials as $mIndex => $m)
                    <div class="form-group row material-item document-item">
                        <label class="col-sm-2 form-control-label">
                            {{ $mIndex==0 ? 'Materials' : '' }}
                        </label>

                        <div class="col-sm-4">
                            <select name="material_type_id[{{ $engagement->flat->id }}][]" class="form-control">
                                <option value="">-- Select --</option>
                                @foreach($materialTypes as $mt)
                                    <option value="{{ $mt->id }}"
                                        {{ $m->material_type_id == $mt->id ? 'selected' : '' }}>
                                        {{ $mt->material_type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-2">
                            <input type="text"
                                name="material_details[{{ $engagement->flat->id }}][]"
                                class="form-control"
                                value="{{ $m->material_details }}">
                        </div>

                        <div class="col-sm-2">
                            <input type="file" name="material_document[{{ $engagement->flat->id }}][]" class="form-control">
                            @if($m->material_documents)
                            <div class="file-preview">
                                <small>{{ basename($m->material_documents) }}</small>
                            </div>
                            @endif
                        </div>

                        <div class="col-sm-2">
                            @if($mIndex==0)
                                <button type="button" class="btn btn-success add-material">+</button>
                            @else
                                <button type="button" class="btn btn-danger remove-material remove-old-material">-</button>
                            @endif
                        </div>
                        <input type="hidden" name="material_id[{{ $engagement->flat->id }}][]" value="{{ $m->id }}">
                        <input type="hidden" name="old_material_document[{{ $engagement->flat->id }}][]" value="{{ $m->material_documents }}">
                    </div>
                    @empty
                    <div class="form-group row material-item">
                        <label class="col-sm-2 form-control-label">Materials</label>
                        <div class="col-sm-4">
                            <select name="material_type_id[{{ $engagement->flat->id }}][]" class="form-control">
                                <option value="">-- Select --</option>
                                @foreach($materialTypes as $mt)
                                    <option value="{{ $mt->id }}">{{ $mt->material_type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" name="material_details[{{ $engagement->flat->id }}][]" class="form-control">
                        </div>
                        <div class="col-sm-2">
                            <input type="file" name="material_document[{{ $engagement->flat->id }}][]" class="form-control">
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-success add-material">+</button>
                        </div>
                    </div>
                    @endforelse
                    </div>

                    <button type="button" class="btn btn-danger remove-engagement mt-2 {{ $eIndex==0?'d-none':'' }}" data-id="{{ $engagement->id }}">
                        Remove Engagement
                    </button>

                    </div>
                    @endforeach

                    </div>

                    <button type="button" id="addEngagementSet" class="btn btn-primary mt-3">
                        Add More Engagement
                    </button>

                    <hr>

                    <div class="form-group row mt-4">
                    <div class="col-sm-12 text-right">
                        <button type="submit" class="btn btn-lg btn-success">
                            <i class="material-icons">&#xe161;</i> Update
                        </button>
                        <a href="{{ route('landlordEngagements') }}" class="btn btn-lg btn-default">
                            Cancel
                        </a>
                    </div>
                </div>
                <div id="removed-project-docs"></div>
                <div id="removed-flat-docs"></div>
                <div id="removed-materials"></div>
                <div id="removed-engagements"></div>
            </form>
        </div>
    </div>
</div>
@endsection
@push("after-scripts")
<script>
$(document).ready(function () {

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

    /* ===============================
        FLAT DUPLICATE PREVENT
    =============================== */
    function rebuildUsedPairs() {
        let arr = [];
        $(".flat-select").each(function () {
            let flatId = $(this).val();
            let index = $(this).closest('.engagement-set').index();
            if (flatId) arr.push(index + "-" + flatId);
        });
        return arr;
    }

    let projectId = $('#project_id').val();
    let usedPairs = rebuildUsedPairs();

    $(".flat-select").each(function () {
        updateFlatOptions($(this), projectId);
    });

    function updateFlatOptions(flatSelect, projectId) {

        let currentFlat = flatSelect.val();

        $.ajax({
            url: "{{ route('get.project.flats') }}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                project_id: projectId
            },
            success: function (response) {

                let options = '<option value="">-- Select Flat --</option>';

                response.tags.forEach(tag => {

                    let usedElsewhere = usedPairs.some(pair => {
                        let [, fId] = pair.split("-");
                        return fId == tag.id && tag.id != currentFlat;
                    });

                    if (!usedElsewhere) {
                        options += `
                            <option value="${tag.id}" ${tag.id == currentFlat ? 'selected' : ''}>
                                ${tag.title}
                            </option>`;
                    }
                });

                flatSelect.html(options);
            }
        });
    }

    /* ===============================
        DOCUMENT ADD / REMOVE
    =============================== */
    $(document).on("click", ".add-doc", function () {

        let wrapper = $(this).closest(".document-wrapper");
        let item = $(this).closest(".document-item");

        let selectPrefix = "";

        if (wrapper.hasClass("project-doc-wrapper")) {
            selectPrefix = "project_document_type_id";
        } else {
            // flat documents are always inside engagement-set
            selectPrefix = "flat_document_type_id";
        }

        let allSelected = true;

        wrapper.find(`select[name^='${selectPrefix}']`).each(function () {
            if (!$(this).val()) {
                allSelected = false;
                return false; // break loop
            }
        });

        if (!allSelected) {
            alert("Please select a document type in all rows before adding a new one.");
            return;
        }

        let usedTypes = [];
        wrapper.find(`select[name^='${selectPrefix}']`).each(function () {
            if ($(this).val()) usedTypes.push($(this).val());
        });

        let clone = item.clone(false);

        clone.find("select").val("");
        clone.find("input[type=file]").val("");
        clone.find(".file-preview").html("");
        clone.find("label").html("&nbsp;");


        clone.find(`select[name^='${selectPrefix}'] option`).each(function () {
            if (usedTypes.includes($(this).val())) $(this).remove();
        });

        clone.find(".add-doc")
            .removeClass("btn-success add-doc")
            .addClass("btn-danger remove-doc")
            .text("-");

        wrapper.append(clone);
    });

    $(document).on("click", ".remove-doc", function () {
        $(this).closest(".document-item").remove();
    });

    $(document).on("click", ".add-material", function () {

        let set     = $(this).closest(".engagement-set");
        let wrapper = set.find(".material-wrapper");
        let item    = $(this).closest(".material-item");

        /* =========================
        1️⃣ VALIDATE ALL SELECTS
        ========================= */
        let allSelected = true;

        wrapper.find("select[name^='material_type_id[']").each(function () {
            if (!$(this).val()) {
                allSelected = false;
                return false;
            }
        });

        if (!allSelected) {
            alert("Please select a material type in all rows before adding a new one.");
            return;
        }

        /* =========================
        2️⃣ COLLECT USED TYPES
        ========================= */
        let usedTypes = [];

        wrapper.find("select[name^='material_type_id[']").each(function () {
            if ($(this).val()) {
                usedTypes.push($(this).val());
            }
        });

        /* =========================
        3️⃣ CLONE ROW
        ========================= */
        let clone = item.clone(false);

        clone.find("select").val("");
        clone.find("input[type='text']").val("");
        clone.find("input[type='file']").val("");
        clone.find(".file-preview").html("");
        clone.find("label").html("&nbsp;");
        clone.find("input[type='hidden']").remove();

        /* =========================
        4️⃣ REMOVE USED OPTIONS
        ========================= */
        clone.find("select[name^='material_type_id['] option").each(function () {
            if (usedTypes.includes($(this).val())) {
                $(this).remove();
            }
        });

        /* =========================
        5️⃣ + ➜ -
        ========================= */
        clone.find(".add-material")
            .removeClass("btn-success add-material")
            .addClass("btn-danger remove-material")
            .text("-");

        wrapper.append(clone);
    });



    $(document).on("click", ".remove-material", function () {
        $(this).closest(".material-item").remove();
    });

    /* ===============================
        ADD ENGAGEMENT
    =============================== */
    $("#addEngagementSet").on("click", function () {

        let last = $(".engagement-set").last();

        if (
            !last.find(".landlord-select").val() ||
            !last.find(".flat-select").val()
        ) {
            alert("Select landlord & flat first");
            return;
        }

        let index = $(".engagement-set").length;
        let clone = last.clone(false);

        /* =========================
        BASIC RESET
        ========================== */
        clone.find("select").val("");
        clone.find("input").val("");
        clone.find("input[type='file']").val("");
        clone.find(".file-preview").html("");

        /* =========================
        REMOVE OLD HIDDEN IDS
        ========================== */
        clone.find("input[type='hidden']")
            .not("[name='project_id']")
            .remove();

        /* =========================
        FLAT SELECT NAME FIX
        ========================== */
        clone.find(".flat-select").attr(
            "name",
            "flats[" + index + "][flat_id]"
        );

        /* =========================
        RESET FLAT DOCUMENTS
        ========================== */
        clone.find(".flat-doc-wrapper .document-item")
            .not(":first")
            .remove();

        clone.find(".flat-doc-wrapper .document-item:first")
            .find("select, input")
            .val("");

        clone.find(".flat-doc-wrapper .file-preview").html("");

        /* =========================
        RESET MATERIALS
        ========================== */
        clone.find(".material-wrapper .material-item")
            .not(":first")
            .remove();

        clone.find(".material-wrapper .material-item:first")
            .find("select, input")
            .val("");

        clone.find(".material-wrapper .file-preview").html("");

        /* =========================
        SHOW REMOVE BUTTON
        ========================== */
        clone.find(".remove-engagement").removeClass("d-none");

        $("#engagement-wrapper").append(clone);

        usedPairs = rebuildUsedPairs();
    });

});
</script>
<script>
    // PROJECT DOC REMOVE
    $(document).on('click', '.remove-old-project-doc', function () {
        let id = $(this).closest('.document-item')
            .find("input[name='project_document_id[]']").val();

        if (id) {
            $('#removed-project-docs').append(
                `<input type="hidden" name="removed_project_docs[]" value="${id}">`
            );
        }
    });

    // FLAT DOC REMOVE
    $(document).on('click', '.remove-old-flat-doc', function () {

        let item = $(this).closest('.document-item');

        let id = item.find("input[name^='flat_document_id']").first().val();

        if (id) {
            $('#removed-flat-docs').append(
                `<input type="hidden" name="removed_flat_docs[]" value="${id}">`
            );
        }

        item.remove(); 
    });


    // MATERIAL REMOVE
    $(document).on('click', '.remove-old-material', function () {

        let item = $(this).closest('.material-item');

        let id = item.find("input[name^='material_id']").first().val();

        if (id) {
            $('#removed-materials').append(
                `<input type="hidden" name="removed_materials[]" value="${id}">`
            );
        }

        item.remove(); 
    });


    // ENGAGEMENT REMOVE
    $(document).on('click', '.remove-engagement', function () {
        let id = $(this).data('id');

        if (id) {
            $('#removed-engagements').append(
                `<input type="hidden" name="removed_engagements[]" value="${id}">`
            );
        }

        $(this).closest('.engagement-set').remove();
    });

</script>
@endpush
