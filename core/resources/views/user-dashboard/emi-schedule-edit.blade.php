<div class="modal fade" id="editEmiModal{{ $emi->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form class="editEmiForm" action="{{ route('emi.update', $emi->id) }}" method="POST">
            @csrf
            @method('POST')
            <input type="hidden" name="emi_id" value="{{ $emi->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit EMI #{{ $emi->id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    @if($emi->emi_amount > 0)
                    <div class="mb-3">
                        <label>EMI Amount</label>
                        <input type="number" name="emi_amount" value="{{ $emi->emi_amount }}" class="form-control" required>
                    </div>
                    @endif
                    @if($emi->extras_amount > 0)
                    <div class="mb-3">
                        <label>Extras Amount</label>
                        <input type="number" name="extras_amount" value="{{ $emi->extras_amount }}" class="form-control" required>
                    </div>
                    @endif
                    <div class="mb-3">
                        <label>Payment Method</label>
                        <select name="payment_method_edit" class="form-control" required>
                            <option value="cash" {{ $emi->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="check" {{ $emi->payment_method == 'check' ? 'selected' : '' }}>Cheque</option>
                            <option value="bank_transfer" {{ $emi->payment_method == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        </select>
                    </div>
                    <div class="mb-3" id="transaction_no_amount_group_edit">
                        <label>Transaction No (Ex: Cheque No/Bank Transfer Ref No).</label>
                        <input type="text" name="transaction_no_edit" value="{{ $emi->trx_no }}" class="form-control" placeholder="Transaction No">
                    </div>
                    <div class="mb-3" id="check_ds_image_amount_group_edit">
                        <label>Documents (Ex: Cheque/Deposit Slip Image)</label>
                        <input type="file" name="check_ds_image_edit" class="form-control">
                        @if($emi->document_path)
                            <div class="mt-2">
                                <p>Current Document:</p>
                                <a href="{{ route('emi.document.show', $emi->id) }}" target="_blank" class="btn btn-sm btn-info">
                                    Preview
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label>Voucher No</label>
                        <input type="text" name="voucher_no" value="{{ $emi->voucher_no }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Paid Date</label>
                        <input type="date" name="paying_date" value="{{ $emi->emi_paid_date }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Note</label>
                        <textarea name="note" class="form-control">{{ $emi->note }}</textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update EMI</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>
$(document).on('shown.bs.modal', '#editEmiModal{{ $emi->id }}', function () {
    var modal = $(this);

    function togglePaymentGroups() {
        var paymentMethod = modal.find('select[name="payment_method_edit"]').val();

        if (paymentMethod === 'check' || paymentMethod === 'bank_transfer') {
            modal.find('#transaction_no_amount_group_edit').show();
            modal.find('#check_ds_image_amount_group_edit').show();
        } else {
            modal.find('#transaction_no_amount_group_edit').hide();
            modal.find('#check_ds_image_amount_group_edit').hide();
            modal.find('input[name="transaction_no_edit"]').prop('required', false).val('');
            modal.find('input[name="check_ds_image_edit"]').prop('required', false).val('');
        }
    }

    // Onload inside modal
    togglePaymentGroups();

    // Onchange inside modal
    modal.find('select[name="payment_method_edit"]').on('change', function () {
        togglePaymentGroups();
    });
});


$(document).off('submit', '.editEmiForm').on('submit', '.editEmiForm', function (e) {
    e.preventDefault();

    let form = $(this);
    let formData = new FormData(this);
    let actionUrl = form.attr('action');
    let submitBtn = form.find('button[type="submit"]');

    $.ajax({
        url: actionUrl,
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        beforeSend: function () {
            submitBtn.prop('disabled', true).text('Updating...');
        },
        success: function (res) {
            submitBtn.prop('disabled', false).text('Update EMI');
            if (res.success) {
                toastr.success(res.message);
                form.closest('.modal').modal('hide');
                setTimeout(() => location.reload(), 1000);
            } else {
                toastr.error('Failed to update EMI');
            }
        },
        error: function (xhr) {
            submitBtn.prop('disabled', false).text('Update EMI');
            let errors = xhr.responseJSON?.errors;
            if (errors) {
                $.each(errors, function (key, value) {
                    toastr.error(value[0]);
                });
            } else {
                toastr.error('Unexpected error occurred.');
            }
        }
    });
});

</script>
@endpush


