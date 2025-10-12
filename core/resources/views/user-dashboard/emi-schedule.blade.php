<h3>EMI Payment Form</h3>
<form method="POST" action="{{ route('emi.store') }}" enctype="multipart/form-data">
  @csrf
  <div class="form-group">
    <input type="hidden" name="price_id">
    <input type="hidden" name="customer_id">
    
    <label>Customer</label>
    <select name="customer_id_select" class="custom-select form-control" required>
        <option value="">Select Customer</option>
        @foreach($prices_details->pluck('customer')->unique('id') as $customer)
            <option value="{{ $customer->id }}">
                {{ $customer->first_name }} {{ $customer->last_name }}
            </option>
        @endforeach
    </select>
    @error('customer_id_select')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group">
    <label>Flat</label>
    <select name="flat_id" class="custom-select form-control" required>
        <option value="">Select Flat</option>
    </select>
    @error('flat_id')
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
    <label >Extras Amount</label>
    <input type="text" class="form-control" id="extras_amount" name="extras_amount" placeholder="Extras Amount">
    @error('extras_amount')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group" id="total_amount_group">
    <label >Total Amount</label>
    <input type="text" id="total_amount" class="form-control" name="total_amount" placeholder="Total Amount" readonly>
    @error('total_amount')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group" id="total_emi_count_group">
    <label >Total EMI Count</label>
    <input type="text" id="total_emi_count" class="form-control" name="total_emi_count" placeholder="Total EMI Count" readonly>
    @error('total_emi_count')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group" id="remaining_emi_count_group">
    <label >Remaining EMI Count</label>
    <input type="text" id="remaining_emi_count" class="form-control" name="remaining_emi_count" placeholder="Remaining EMI Count" readonly>
    @error('remaining_emi_count')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group" id="total_paid_amount_group">
    <label >Total Paid Amount (Booking + Downpayment + All Installments)</label>
    <input type="text" id="total_paid_amount" class="form-control" name="total_paid_amount" placeholder="Total Paid Amount (EMI)" readonly>
    @error('total_paid_amount')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group" id="total_paid_amount_with_extras_group">
    <label >Total Paid Amount (Booking + Downpayment + All Installments + Extras)</label>
    <input type="text" id="total_paid_amount_with_extras" class="form-control" name="total_paid_amount_with_extras" placeholder="Total Paid Amount (With Extras)" readonly>
    @error('total_paid_amount_with_extras')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group" id="total_due_amount_group">
    <label >Total Due Amount (EMI)</label>
    <input type="text" id="due_amount" class="form-control" name="due_amount" placeholder="Total Due Amount (EMI)" readonly>
    @error('due_amount')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group" id="total_due_amount_with_extras_group">
    <label >Total Due Amount (With Extras)</label>
    <input type="text" id="due_amount_with_extras" class="form-control" name="due_amount_with_extras" placeholder="Total Due Amount (With Extras)" readonly>
    @error('due_amount_with_extras')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group" id="remaining_due_amount_group">
    <label >Remaining Due Amount (EMI)</label>
    <input type="text" id="remaining_due_amount" class="form-control" name="remaining_due_amount" placeholder="Remaining Due Amount (EMI)" readonly>
    @error('remaining_due_amount')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group" id="remaining_due_amount_with_extras_group">
    <label >Remaining Due Amount (With Extras)</label>
    <input type="text" id="remaining_due_amount_with_extras" class="form-control" name="remaining_due_amount_with_extras" placeholder="Remaining Due Amount (With Extras)" readonly>
    @error('remaining_due_amount_with_extras')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group" id="current_installment_amount_group">
    <label >Current Installment Amount</label>
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
        <option value="">Select Payment Method</option>
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
  <div class="form-group" id="paying_date_group">
    <label >Paying Date</label>
    <input type="date" id="emi_paying_date" class="form-control" name="emi_paying_date" placeholder="Paying Date">
    @error('emi_paying_date')
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


    $('select[name="customer_id_select"]').on('change', function() {
        var customerId = $(this).val();
        var $flatSelect = $('select[name="flat_id"]');
        $flatSelect.html('<option value="">Select Flat</option>');

        if(customerId) {
            $.ajax({
                url: "{{ route('emi.customer.flats') }}",
                type: "GET",
                data: { customer_id: customerId },
                success: function(response) {
                    if(response.length === 0) {
                        $flatSelect.html('<option value="">No Flats Found</option>');
                        return;
                    }
                    $.each(response, function(index, flat) {
                        $flatSelect.append(
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

    $('select[name="flat_id"]').on('change', function() {
    var flatId = $(this).val();

    if(flatId) {
        $.ajax({
            url: "{{ route('emi.flat.details') }}",
            type: "GET",
            data: { flat_id: flatId },
            success: function(response) {
                if(response.latest_status === 'pending') {
                    alert('The latest EMI for this flat is still pending approval. Please wait until it is approved before making another payment.');
                    $('select[name="flat_id"]').val('');
                    return;
                }

                if(response.error) {
                    alert(response.error);
                    return;
                }

                // Base data
                $('input[name="price_id"]').val(response.price_id);
                $('input[name="customer_id"]').val(response.customer_id);
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

                // Function to update totals based on current installment and extras
                function updateTotals() {
                    var currentInstallment = parseFloat($currentInstallmentInput.val()) || 0;
                    var totalPaid = totalPaidPrevious + currentInstallment;

                    var extrasAmountInput = 0;
                    if($('#extras_amount_check').is(':checked')) {
                        extrasAmountInput = parseFloat($('#extras_amount').val()) || 0;
                    }

                    var totalPaidWithExtras = totalPaidWithExtrasPrevious + currentInstallment + extrasAmountInput;
                    var dueWithExtras = parseFloat(response.due_amount_with_extras) - extrasAmountInput;
                    var remainingDueWithExtras = parseFloat(response.remaining_due_amount_with_extras) - extrasAmountInput;

                    $('input[name="total_paid_amount"]').val(totalPaid).prop('readonly', true);
                    $('input[name="total_paid_amount_with_extras"]').val(totalPaidWithExtras).prop('readonly', true);
                    $('input[name="due_amount_with_extras"]').val(dueWithExtras).prop('readonly', true);
                    $('input[name="remaining_due_amount_with_extras"]').val(remainingDueWithExtras).prop('readonly', true);
                }

                // Initial update
                updateTotals();

                // Live update when current_installment_amount changes
                $currentInstallmentInput.on('input keyup change', function() {
                    updateTotals();
                });

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
                        alert('Extras amount cannot exceed remaining amount: ' + response.extras_amount + ' Tk');
                        $(this).val(response.extras_amount);
                    }
                    updateTotals();
                });

                $('#extras_amount_check').on('change', function() {
                    if ($(this).is(':checked')) {
                        $('#extras_amount_group').show();
                        $('#extras_amount').prop('required', true).val(response.extras_amount);
                    } else {
                        $('#extras_amount_group').hide();
                        $('#extras_amount').prop('required', false).val('');
                    }
                    updateTotals();
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
