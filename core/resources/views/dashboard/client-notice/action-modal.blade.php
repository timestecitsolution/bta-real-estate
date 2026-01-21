<div class="modal fade" id="actionNoticeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Take Action</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form id="actionNoticeForm">
                <div class="modal-body">

                    <input type="hidden" name="notice_id" id="notice_id">

                    <!-- Radio buttons -->
                    <div class="form-group">
                        <label><strong>Status</strong></label><br>

                        <label class="mr-3">
                            <input type="radio" name="status" value="approved" required>
                            Approve
                        </label>

                        <label>
                            <input type="radio" name="status" value="rejected">
                            Reject
                        </label>
                    </div>

                    <!-- Feedback -->
                    <div class="form-group">
                        <label>Feedback</label>
                        <textarea class="form-control"
                                  name="feedback"
                                  rows="3"
                                  placeholder="Write feedback..."></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>

        </div>
    </div>
</div>
@push("after-scripts")
<script>
$('#actionNoticeForm').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        url: "{{ route('client-notice.action') }}", 
        type: "POST",
        data: $(this).serialize(),
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function (res) {
            $('#actionNoticeModal').modal('hide');
            location.reload(); 
        }
    });
});
</script>
@endpush

