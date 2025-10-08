<h3>Payment Overview</h3>
<div class="table-responsive">
    <table id="payment-table" class="table table-striped table-bordered">
        <thead class="d-md-table-header-group">
            <tr>
                <th>Customer Name</th>
                <th>Project</th>
                <th>Flat</th>
                <th>EMI Amount</th>
                <th>Extras Amount</th>
                <th>Status</th>
                @if($user->status == '1')
                    <th>Action</th>
                @endif
                <th>Document</th>
                <th>Invoice</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prices_details as $price)
                @php
                    $customer = $price->customer;
                    $emis = $emi_details->where('price_id', $price->id);
                @endphp

                @foreach($emis as $emi)
                    <tr>
                        <td data-label="Customer Name">{{ $customer->first_name ?? 'N/A' }} {{ $customer->last_name ?? '' }}</td>
                        <td data-label="Project">{{ $price->project->title_en ?? 'N/A' }}</td>
                        <td data-label="Flat">{{ $price->flat->title ?? 'N/A' }}</td>
                        <td data-label="EMI Amount">{{ $emi->emi_amount ? number_format($emi->emi_amount, 2) : 'N/A' }}</td>
                        <td data-label="Extras Amount">{{ $emi->extras_amount ? number_format($emi->extras_amount, 2) : 'N/A' }}</td>
                        <td data-label="Status">
                            <span class="badge {{ $emi->status == 'approved' ? 'bg-success' : 'bg-danger' }}">
                                {{ $emi->status ? ucfirst($emi->status) : 'N/A' }}
                            </span>
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
                                <div class="d-flex gap-2">
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