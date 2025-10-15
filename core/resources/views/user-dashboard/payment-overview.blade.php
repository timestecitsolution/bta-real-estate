<h3>Payment Overview</h3>
<form method="POST" action="{{ route('dashboard-new-post') }}">
@csrf
    <div class="row">
        <div class="col-md-3">
            <label>Client <span>*</span></label>
            <select name="filter_customer_id" class="custom-select form-control" required>
                <option value="">Select Client</option>
                @foreach($all_prices_details->pluck('customer')->unique('id') as $customer)
                    <option value="{{ $customer->id }}" {{ $filter_customer_id == $customer->id ? 'selected' : '' }}>
                        {{ $customer->first_name }} {{ $customer->last_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label>From Date</label>
            <input type="date" class="form-control" name="filter_from_date" value="{{ $filter_from_date ?? '' }}" placeholder="From Date">
        </div>
        <div class="col-md-3">
            <label>To Date</label>
            <input type="date" class="form-control" name="filter_to_date" value="{{ $filter_to_date ?? '' }}" placeholder="To Date">
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-success w-100">Filter</button>
        </div>
    </div>
</form>
@if($prices_details->isNotEmpty())
<div class="table-responsive">
    <table id="payment-table" class="table table-striped table-bordered">
        <thead class="d-md-table-header-group">
            <tr>
                <th>SL No</th>
                <th>Customer Name</th>
                <th>Project (Flat)</th>
                <th>EMI Amount</th>
                <th>Extras Amount</th>
                <th>Total / Remaining EMI</th>
                <th>Paid Date</th>
                <th>Status</th>
                <th>Voucher No</th>
                <th>Note</th>
                @if($user->status == '1')
                    <th>Action</th>
                @endif
                <th>Document</th>
                <th>Invoice</th>
            </tr>
        </thead>
        <tbody>
            @php $sl = 1; @endphp
            @foreach($prices_details as $price)
                @php
                    $customer = $price->customer;
                    $emis = $emi_details->where('price_id', $price->id);
                @endphp

                @foreach($emis as $emi)
                    <tr>
                        <td data-label="SL No">{{ $sl++ }}</td>
                        <td data-label="Customer Name">{{ $customer->first_name ?? 'N/A' }} {{ $customer->last_name ?? '' }}</td>
                        <td data-label="Project (Flat)">
                            {{ $price->project->title_en ?? 'N/A' }}
                            ({{ $price->flat->title ?? 'N/A' }})
                        </td>
                        <td data-label="EMI Amount">{{ $emi->emi_amount ? number_format($emi->emi_amount, 2) : 'N/A' }}</td>
                        <td data-label="Extras Amount">{{ $emi->extras_amount ? number_format($emi->extras_amount, 2) : 'N/A' }}</td>
                        <td data-label="Total / Remaining EMI">
                            {{ $price->emi_count ?? '0' }} / {{ $emi->remaining_emi_count ?? '0' }}
                        </td>
                        <td data-label="Paid Date">
                            {{ $emi->emi_paid_date ? \Carbon\Carbon::parse($emi->emi_paid_date)->format('d M Y') : 'N/A' }}
                        </td>
                        <td data-label="Status">
                            <span class="badge {{ $emi->status == 'approved' ? 'bg-success' : 'bg-danger' }}">
                                {{ $emi->status ? ucfirst($emi->status) : 'N/A' }}
                            </span>
                        </td>
                        <td data-label="Voucher No">
                            {{ $emi->voucher_no ?? 'N/A' }}
                        </td>
                        <td data-label="Note">
                            {{ $emi->note ?? 'N/A' }}
                        </td>
                        @if($emi->status == 'pending' && $user->status == '1')
                            <td data-label="Action">
                                    <a href="{{ route('emi.approve', $emi->id) }}" class="btn btn-sm btn-success">Approve</a>
                                    <a href="{{ route('emi.reject', $emi->id) }}" class="btn btn-sm btn-warning">Reject</a>
                                <form action="{{ route('emi.destroy', $emi->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this record?');">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        @endif
                        @if($emi->status == 'approved' && $user->status == '1')
                            <td data-label="Action"></td>
                        @endif
                        <td data-label="Document">
                            @if($emi->document_path)
                                <div>
                                    {{-- Preview Button --}}
                                    <a href="{{ route('emi.document.show', $emi->id) }}" target="_blank" class="btn btn-sm btn-info">
                                        Preview
                                    </a>

                                    {{-- Download Button --}}
                                    <a href="{{ route('emi.document.download', $emi->id) }}" class="btn btn-sm btn-success">
                                        Download
                                    </a>
                                </div>
                            @else
                                N/A
                            @endif
                        </td>
                        <td data-label="Invoice">
                            <!-- Details Modal Trigger -->
                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#invoiceModal{{ $emi->id }}">
                                View Details
                            </button>
                            @include('user-dashboard.invoice-modal', ['emi' => $emi])
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
@else
    <p class="text-center text-muted mt-3">
        Please select a client to view EMI data.
    </p>
@endif
<script>
function printInvoice(id) {
    const modalBody = document.querySelector(`#invoiceModal${id} .modal-body`);
    const printWindow = window.open('', '', 'height=700,width=900');
    printWindow.document.write('<html><head><title>Invoice</title></head><body>');
    printWindow.document.write(modalBody.innerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}
</script>
<style>
/*  Make table vertical on small screens */
@media (max-width: 767px) {
    table#payment-table,
    table#payment-table thead,
    table#payment-table tbody,
    table#payment-table th,
    table#payment-table td,
    table#payment-table tr {
        display: block;
        width: 100%;
    }

    table#payment-table tr {
        margin-bottom: 1rem;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 0.5rem;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    table#payment-table td {
        display: flex;
        justify-content: space-between;
        text-align: right;
        padding: 8px;
        border: none;
        border-bottom: 1px solid #eee;
    }

    table#payment-table td::before {
        content: attr(data-label);
        font-weight: 600;
        text-transform: capitalize;
        text-align: left;
    }

    table#payment-table td:last-child {
        border-bottom: none;
    }
}
</style>