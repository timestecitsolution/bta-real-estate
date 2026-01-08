<div class="modal fade" id="landlordmaterialsModal{{ $allocated_flat->id }}" tabindex="-1" aria-labelledby="landlord_materialsModalLabel{{ $allocated_flat->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="landlord_materialsModalLabel{{ $allocated_flat->id }}">
                    {{ $allocated_flat->customer->first_name ?? 'N/A' }} {{ $allocated_flat->customer->last_name ?? '' }} - 
                    Materials for Flat: {{ $allocated_flat->flat->title ?? 'N/A' }} 
                    (Project: {{ $allocated_flat->project->title_en ?? 'N/A' }})
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Material Type</th>
                            <th>Material Details</th>
                            <th>Documents</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($existingMaterials as $material)
                            <tr>
                                <td>
                                    {{ $material->materialType->material_type ?? 'Unknown' }}
                                </td>
                                <td>
                                    {{ $material->material_details ?? '-' }}
                                </td>
                                <td>
                                    @if($material->material_documents)
                                        <a href="{{ asset($material->material_documents) }}"
                                        class="btn btn-sm btn-success"
                                        download>
                                            Download
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">
                                    No materials found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>