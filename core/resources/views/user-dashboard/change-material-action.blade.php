<div class="modal fade" id="changeMaterialactionModal{{ $mat->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('material.action', $mat->id) }}" method="POST">
            @csrf
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Change Material Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <label>Change Details <span class="text-danger">*</span></label>
                    <textarea name="change_details" class="form-control" rows="4" required
                        placeholder="Describe what material you want to change..." readonly>{{ $mat->change_details ?? '' }}</textarea>

                    <hr>

                    <label>Admin Action <span class="text-danger">*</span></label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="admin_status" value="approved" id="approve{{ $mat->id }}">
                        <label class="form-check-label" for="approve{{ $mat->id }}">
                            Approve
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="admin_status" value="rejected" id="reject{{ $mat->id }}">
                        <label class="form-check-label" for="reject{{ $mat->id }}">
                            Reject
                        </label>
                    </div>

                    <label class="mt-3">Admin Note</label>
                    <textarea name="admin_note" class="form-control" rows="2" placeholder="Optional note from admin">{{ $mat->admin_note ?? '' }}</textarea>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </div>
        </form>
    </div>
</div>