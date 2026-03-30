<h3>EMI Payment Form</h3>
<form method="POST" action="{{ route('emi.store') }}" enctype="multipart/form-data">
  @csrf
  <div class="form-group">
    <input type="hidden" name="booking_id">
    <input type="hidden" name="client_id">
    
    <label>Client*</label>
    <select name="client_id_select" class="custom-select form-control" required>
        <option value="">Select Client</option>
        @foreach($all_prices_details->pluck('customer')->unique('id') as $client)
            <option value="{{ $client->id }}">
                {{ $client->first_name }} {{ $client->last_name }}
            </option>
        @endforeach
    </select>
    @error('client_id_select')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group">
    <label>Flat*</label>
    <select name="flat_id[]" class="custom-select form-control select2-multiple" data-placeholder="Select Flats" multiple required>
        <option value="">Select Flat(s)</option>
    </select>
    @error('flat_id[]')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <div class="form-group" id="extras_amount_check_group">
    <input class="form-check-input" type="checkbox" name="extras_amount_check" value="1" id="extras_amount_check">
    <label class="form-check-label" for="extras_amount_check">
      Paying Extras Amount?
    </label>
    @error('extras_amount_check')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group" id="extras_amount_group">
    <label >Extras Amount*</label>
    <input type="text" class="form-control" id="extras_amount" name="extras_amount" placeholder="Extras Amount">
    @error('extras_amount')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group" id="current_installment_amount_group">
    <label >Current Installment Amount*</label>
    <input type="text" id="current_installment_amount" class="form-control" name="current_installment_amount" placeholder="Current Installment Amount">
    @error('current_installment_amount')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group" id="emi_due_date_group">
    <label >EMI Due Date</label>
    <input type="date" id="emi_due_date" class="form-control" name="emi_due_date" placeholder="EMI Due Date">
    @error('emi_due_date')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group">
    <label>Payment Method</label>
    <select name="payment_method" class="custom-select form-control" required>
        <option value="">Select Payment Method*</option>
        <option value="cash">Cash</option>
        <option value="check">Cheque</option>
        <option value="bank_transfer">Bank Transfer</option>
    </select>
    @error('payment_method')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group" id="transaction_no_amount_group">
    <label >Transaction No (Ex: Cheque No/Bank Transfer Ref No).</label>
    <input type="text" id="transaction_no" class="form-control" name="transaction_no" placeholder="Transaction No">
    @error('transaction_no')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group" id="check_ds_image_amount_group">
    <label >Documents (Ex: Cheque/Deposit Slip Image)</label>
    <input type="file" id="check_ds_image" class="form-control" name="check_ds_image" placeholder="Cheque/DS Image">
    @error('check_ds_image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group">
    <label >Voucher No</label>
    <input type="text" class="form-control" name="voucher_no" placeholder="Voucher No">
    @error('voucher_no')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group" id="paying_date_group">
    <label >Paying Date*</label>
    <input type="date" id="emi_paying_date" class="form-control" name="emi_paying_date" placeholder="Paying Date" required>
    @error('emi_paying_date')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group">
    <label >Note</label>
    <textarea class="form-control" name="note" placeholder="Note"></textarea>
    @error('note')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <button type="submit" class="btn btn-primary mt-3">Submit</button>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {

    $('#extras_amount_check_group').hide();
    $('#extras_amount_group').hide();
    $('#extras_amount').prop('required', false);

    $('#transaction_no_amount_group').hide();
    $('#check_ds_image_amount_group').hide();
    $('#transaction_no').prop('required', false).val('');
    $('#check_ds_image').prop('required', false).val('');

    $('select[name="payment_method"]').on('change', function() {
        var paymentMethod = $(this).val();
        if(paymentMethod === 'check' || paymentMethod === 'bank_transfer') {
            $('#transaction_no_amount_group').show();
            $('#check_ds_image_amount_group').show();
            // $('#transaction_no').prop('required', true);
            // $('#check_ds_image').prop('required', true);
        } else {
            $('#transaction_no_amount_group').hide();
            $('#check_ds_image_amount_group').hide();
            $('#transaction_no').prop('required', false).val('');
            $('#check_ds_image').prop('required', false).val('');
        }
    });


    $('select[name="client_id_select"]').on('change', function() {
        var clientId = $(this).val();
        var flatSelect = $('select[name="flat_id[]"]');

        $('#current_installment_amount').val('');
        $('#emi_due_date').val('');

        flatSelect.html('<option value="">Select Flat</option>');
        // flatSelect.html('<option value="all">Select All</option>');

        if(clientId) {
            $.ajax({
                url: "{{ route('emi.client.flats') }}",
                type: "GET",
                data: { client_id: clientId },
                success: function(response) {
                    console.log(response);
                    if(response.length === 0) {
                        flatSelect.html('<option value="">No Flats Found</option>');
                        return;
                    }
                    $.each(response, function(index, flat) {
                        flatSelect.append(
                            '<option value="'+flat.flat_id+'">'+flat.flat_title+' ('+flat.project_title+')</option>'
                        );
                    });
                },
                error: function() {
                    alert("Failed to load flats!");
                }
            });
        }
    });

    $('select[name="flat_id[]"]').on('change', function() {
        var flatId = $(this).val();

        if(flatId) {
            $.ajax({
                url: "{{ route('emi.flat.details') }}",
                type: "GET",
                data: { flat_id: flatId },
                success: function(response) {
                    console.log(response);
                    if(response.latest_status === 'pending') {
                        alert('The latest EMI for this flat is still pending approval. Please wait until it is approved before making another payment.');
                        $('select[name="flat_id[]"]').val('');
                        return;
                    }

                    if(response.error) {
                        alert(response.error);
                        return;
                    }
                    if(response.is_cancelled == 1) {
                        let cancelledModal = $(`
                            <div class="modal fade" id="cancelledDealModal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">Deal Cancelled</h5>
                                        </div>
                                        <div class="modal-body text-center">
                                            <p class="h4">Your deal is cancelled!</p>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <button type="button" class="btn btn-light" id="acknowledgeCancelled">OK</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);

                        $('body').append(cancelledModal);

                        $('#cancelledDealModal').modal({
                            backdrop: 'static', 
                            keyboard: false     
                        });

                        $('#cancelledDealModal').modal('show');

                        $('#acknowledgeCancelled').on('click', function() {
                            $('#cancelledDealModal').modal('hide');
                            $('#cancelledDealModal').remove();
                            $('select[name="flat_id[]"]').val('');
                        });

                        return;
                    }

                    // Base data
                    $('input[name="booking_id"]').val(response.booking_id);
                    $('input[name="client_id"]').val(response.client_id);
                    $('input[name="total_amount"]').val(response.total_price).prop('readonly', true);
                    $('input[name="total_emi_count"]').val(response.emi_count).prop('readonly', true);
                    $('input[name="remaining_emi_count"]').val(response.remaining_emi_count).prop('readonly', true);
                    $('input[name="due_amount"]').val(response.due_amount).prop('readonly', true);
                    $('input[name="remaining_due_amount"]').val(response.remaining_due_amount).prop('readonly', true);
                    $('input[name="emi_due_date"]').val(response.emi_due_date).prop('readonly', true);

                    // Set current installment
                    var $currentInstallmentInput = $('#current_installment_amount');
                    $currentInstallmentInput.val(response.emi);

                    // Base totals
                    var totalPaidPrevious = parseFloat(response.total_paid_amount) || 0;
                    var totalPaidWithExtrasPrevious = parseFloat(response.total_paid_amount_with_extras) || 0;

                    $('input[name="total_paid_amount"]').val(response.total_paid_amount).prop('readonly', true);
                    $('input[name="total_paid_amount_with_extras"]').val(response.total_paid_amount_with_extras).prop('readonly', true);
                    $('input[name="due_amount_with_extras"]').val(response.due_amount_with_extras).prop('readonly', true);
                    $('input[name="remaining_due_amount_with_extras"]').val(response.remaining_due_amount_with_extras).prop('readonly', true);

                    // Extras handling
                    if(response.extras_amount > 0){
                        $('#extras_amount_check_group').show();
                        $('#extras_amount_check_group label').text('Paying Extras Amount? (' + response.extras_amount + ') Tk');
                        $('#total_paid_amount_with_extras_group label').text('Total Paid Amount (Booking + Downpayment + All Installments + Extras: ' + response.total_extras_paid + ') Tk');
                        $('#total_due_amount_with_extras_group label').text('Total Due Amount (With Extras: ' + response.extras_amount + ') Tk');
                        $('#remaining_due_amount_with_extras_group label').text('Remaining Due Amount (With Extras: ' + response.extras_amount + ') Tk');
                    } else {
                        $('#extras_amount_check_group').hide();
                        $('#extras_amount_group').hide();
                        $('#extras_amount_check').prop('checked', false);
                        $('#extras_amount').prop('required', false).val('');
                    }

                    // Extras input validation
                    $('#extras_amount').on('input keyup', function() {
                        var val = parseFloat($(this).val()) || 0;
                        if(val > response.extras_amount) {
                            alert('Extras amount cannot exceed remaining extra amount: ' + response.extras_amount + ' Tk');
                            $(this).val(response.extras_amount);
                        }
                        // updateTotals();
                    });

                    $('#extras_amount_check').on('change', function() {
                        if ($(this).is(':checked')) {
                            $('#extras_amount_group').show();
                            $('#extras_amount').prop('required', true).val(response.extras_amount);
                            $('#total_amount, #current_installment_amount, #emi_due_date').val('');
                            $('#current_installment_amount_group, #emi_due_date_group')
                                .hide()
                                .find('input, select, textarea')
                                .prop('required', false);
                        } else {
                            $('#extras_amount_group').hide();
                            $('#extras_amount').prop('required', false).val('');


                            $('#current_installment_amount_group, #emi_due_date_group')
                                .show()
                                .find('input, select, textarea')
                                .prop('required', true);

                            $('input[name="booking_id"]').val(response.booking_id);
                            $('input[name="client_id"]').val(response.client_id);
                            $('input[name="total_amount"]').val(response.total_price).prop('readonly', true);
                            $('input[name="total_emi_count"]').val(response.emi_count).prop('readonly', true);
                            $('input[name="remaining_emi_count"]').val(response.remaining_emi_count).prop('readonly', true);
                            $('input[name="total_paid_amount"]').val(response.total_paid_amount).prop('readonly', true);
                            $('input[name="due_amount"]').val(response.due_amount).prop('readonly', true);
                            $('input[name="remaining_due_amount"]').val(response.remaining_due_amount).prop('readonly', true);
                            $('input[name="current_installment_amount"]').val(response.emi);
                            $('input[name="emi_due_date"]').val(response.emi_due_date).prop('readonly', true);

                            $('input[name="total_paid_amount_with_extras"]').val(response.total_paid_amount_with_extras).prop('readonly', true);
                            $('input[name="due_amount_with_extras"]').val(response.due_amount_with_extras).prop('readonly', true);
                            $('input[name="remaining_due_amount_with_extras"]').val(response.remaining_due_amount_with_extras).prop('readonly', true);
                        }
                        // updateTotals();
                    });

                },
                error: function() {
                    alert("Something went wrong!");
                }
            });
        }
    });
});
</script>
