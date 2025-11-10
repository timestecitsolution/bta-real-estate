<h3>Flat Material Details</h3>
<form method="POST" action="{{ route('dashboard-new-post') }}">
@csrf
    <div class="row">

        <div class="col-md-3">
            <label>Client <span>*</span></label>
            <select id="filter_customer_id" name="filter_customer_id" class="custom-select form-control" required>
                <option value="">Select Client</option>
                @foreach($all_prices_details->pluck('customer')->unique('id') as $customer)
                    <option value="{{ $customer->id }}" {{ $filter_customer_id == $customer->id ? 'selected' : '' }}>
                        {{ $customer->first_name }} {{ $customer->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label>Flat <span>*</span></label>
            <select id="filter_flat_id" name="filter_flat_id" class="custom-select form-control" required>
                <option value="">-- Select Flat --</option>
            </select>
        </div>

        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-success w-100">Filter</button>
        </div>

    </div>
</form>


@if($material_details->isNotEmpty())
<div class="table-responsive mt-4">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>SL No</th>
                <th>Material Type</th>
                <th>Material Details</th>
                <th>Applied Material</th>
                <th>Status</th>
                <th>Change Application</th>
                @if($user->status == '1')
                    <th>Action</th>
                @endif
                <th>Admin Note</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @foreach($material_details as $mat)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $mat->material_type }}</td>
                <td>{{ $mat->details }}</td>
                <td>{{ $mat->change_details ? : 'Not Applied' }}</td>
                <td>
                    @if($mat->status == 'builtin')
                        <span class="badge bg-success">Built In</span>
                    @elseif($mat->status == 'pending')
                        <span class="badge bg-warning">Pending</span>
                    @elseif($mat->status == 'approved')
                        <span class="badge bg-info">Approved</span>
                    @elseif($mat->status == 'rejected')
                        <span class="badge bg-danger">Rejected</span>
                    @endif
                </td>

                <td>
                    @if($mat->status == 'builtin')
                   <button type="button" class="btn btn-warning btn-sm" 
                            data-bs-toggle="modal" 
                            data-bs-target="#changeMaterialModal{{ $mat->id }}">
                        Change
                    </button>
                    @else
                    <button type="button" class="btn btn-warning btn-sm" disabled>
                        Applied already
                    </button>
                    @endif
                    @include('user-dashboard.change-material-modal', ['mat' => $mat])
                </td>
                @if($user->status == '1')
                    <td>
                        @if($mat->status == 'pending')
                            <button type="button" class="btn btn-warning btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#changeMaterialactionModal{{ $mat->id }}">
                                Approve/Reject
                            </button>
                            @include('user-dashboard.change-material-action', ['mat' => $mat])
                        @endif
                    </td>
                @endif
                <td>{{ $mat->admin_note ?? 'No comment' }}</td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>
@else
<p class="text-center text-muted mt-3">No Material Details Found.</p>
@endif

<script>
    $('#filter_customer_id').on('change', function () {
        let customerId = $(this).val();
        let selectedFlat = "{{ $filter_flat_id ?? '' }}";  

        $('#filter_flat_id').html('<option value="">-- Select Flat --</option>');

        if (customerId) {
            $.ajax({
                url: "{{ route('get.flats.by.customer', '') }}/" + customerId,
                type: "GET",
                success: function (data) {

                    let flatDropdown = '<option value="">Select Flat</option>';

                    if (data.length > 0) {
                        data.forEach(function (flat) {
                            flatDropdown += `<option value="${flat.id}" 
                                ${selectedFlat == flat.id ? 'selected' : ''}>
                                ${flat.title}
                            </option>`;
                        });
                    }

                    $('#filter_flat_id').html(flatDropdown);
                }
            });

        } else {
            $('#filter_flat_id').html('<option value="">Select Flat</option>');
        }
    });

    $(document).ready(function () {
        if ($('#filter_customer_id').val()) {
            $('#filter_customer_id').trigger('change');
        }
    });
</script>
