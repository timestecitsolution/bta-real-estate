<form id="resetDefaultForm">
    @csrf

    <div class="form-group">
        <label>Client</label>
        <select name="customer_id_select" id="customer_id_select" class="custom-select form-control" required>
            <option value="">Select Client</option>
            @foreach($all_prices_details->pluck('customer')->unique('id') as $customer)
                <option value="{{ $customer->id }}">
                    {{ $customer->first_name }} {{ $customer->last_name }}
                </option>
            @endforeach
        </select>
        @error('customer_id_select')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="button" id="resetDefaultBtn" class="btn btn-danger mt-2">Reset to Default (123456)</button>
</form>

<div id="resetResult" class="mt-3"></div>

<script>
$(document).ready(function(){
    $('#resetDefaultBtn').on('click', function(e){
        e.preventDefault();
        const clientId = $('#customer_id_select').val();

        if (!clientId) {
            alert('Please select a client first.');
            return;
        }

        if (!confirm('Are you sure you want to reset this client\'s password to default (123456)?')) {
            return;
        }

        $.ajax({
            url: "{{ route('admin.reset.default.password') }}",
            method: "POST",
            data: {
                client_id: clientId,
                _token: "{{ csrf_token() }}"
            },
            beforeSend: function() {
                $('#resetDefaultBtn').prop('disabled', true).text('Resetting...');
                $('#resetResult').html('');
            },
            success: function(res) {
                $('#resetResult').html('<div class="alert alert-success">'+ res.message +'</div>');
            },
            error: function(xhr) {
                let msg = 'Failed to reset password.';
                if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                $('#resetResult').html('<div class="alert alert-danger">'+ msg +'</div>');
            },
            complete: function() {
                $('#resetDefaultBtn').prop('disabled', false).text('Reset to Default (123456)');
            }
        });
    });
});
</script>
