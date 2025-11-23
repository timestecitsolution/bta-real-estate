<div class="modal fade" id="cancelDealModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-danger">Cancel Deal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="cancelDealForm">
                @csrf
                <input type="hidden" name="deal_id" id="cancel_price_id">

                <div class="modal-body">
                    <label>Cancel Reason *</label>
                    <textarea id="cancel_reason" name="reason" class="form-control" rows="3" required></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="cancelDealSubmit">Cancel Deal</button>
                </div>
            </form>
        </div>
    </div>
</div>
