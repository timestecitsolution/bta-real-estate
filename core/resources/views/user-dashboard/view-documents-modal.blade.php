<div class="modal fade" id="documentsModal{{ $price->id }}" tabindex="-1" aria-labelledby="documentsModalLabel{{ $price->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="documentsModalLabel{{ $price->id }}">
                    {{ $price->customer->first_name ?? 'N/A' }} {{ $price->customer->last_name ?? '' }} - 
                    Documents for Flat: {{ $price->flat->title ?? 'N/A' }} 
                    (Project: {{ $price->project->title_en ?? 'N/A' }})
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    @foreach($existingDocuments as $doc)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $doc->documentType->document_type ?? 'Unknown' }}
                            <a href="{{ route('price.downloadDocument', $doc->id) }}" class="btn btn-sm btn-success" download>Download</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>