@foreach($allocated_flats as $flat)
    <h2>Project Documents</h2>
    <h3>Project: {{ $flat->project->title_en ?? '' }}</h3>
    <p>Client Name: {{ optional($flat->customer)->first_name . ' ' . optional($flat->customer)->last_name }}</p>
<div class="table-responsive mt-3">
    <table class="table table-bordered" border="1" width="100%">
        <thead>
            <tr>
                <th>Document Type</th>
                <th>File</th>
            </tr>
        </thead>

        <tbody>

        @foreach($flat->projectDocuments as $doc)
            <tr>
                <td>
                    {{ $doc->documentType->document_type ?? '' }}
                </td>

                <td>
                    <a href="{{ asset('uploads/'.$doc->file_path ?? '') }}" class="btn btn-sm btn-info" target="_blank">
                        View Document
                    </a>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>
@endforeach