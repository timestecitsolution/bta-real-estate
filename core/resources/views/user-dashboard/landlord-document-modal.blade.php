<div class="modal fade" id="landlorddocumentsModal{{ $allocated_flat->id }}" tabindex="-1" aria-labelledby="landlord_documentsModalLabel{{ $allocated_flat->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="landlord_documentsModalLabel{{ $allocated_flat->id }}">
                    {{ $allocated_flat->customer->first_name ?? 'N/A' }} {{ $allocated_flat->customer->last_name ?? '' }} - 
                    Documents for Flat: {{ $allocated_flat->flat->title ?? 'N/A' }} 
                    (Project: {{ $allocated_flat->project->title_en ?? 'N/A' }})
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    @foreach($existingDocuments as $doc)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $doc->documentType->document_type ?? 'Unknown' }}
                            <a href="{{ asset('uploads/'.$doc->file_path) }}" class="btn btn-sm btn-success" target="_blank">Download</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>