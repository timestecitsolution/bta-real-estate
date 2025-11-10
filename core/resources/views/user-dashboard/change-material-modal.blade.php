<div class="modal fade" id="changeMaterialModal{{ $mat->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('material.change', $mat->id) }}" method="POST">
                @csrf
                <div class="modal-content">
                    
                    <div class="modal-header">
                        <h5 class="modal-title">Change Material Request</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <label>Change Details <span class="text-danger">*</span></label>
                        <textarea name="change_details" class="form-control" rows="4" required
                            placeholder="Describe what material you want to change..."></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit Change</button>
                    </div>

                </div>
            </form>
        </div>
    </div>