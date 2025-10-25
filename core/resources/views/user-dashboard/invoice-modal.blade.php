<div class="modal fade" id="invoiceModal{{ $emi->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content shadow-lg">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title text-white">Invoice</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-5">
                <!-- Company Header -->
                <div class="row mb-4">
                    <div class="col-8">
                        <img src="{{ asset('uploads/settings/logo-short.svg') }}" alt="Company Logo" class="mb-2 text-center" style="max-height: 60px;">
                        <h2 class="fw-bold">Building Technology Architecture</h2>
                        <p class="mb-1">Missionpara, Narayanganj</p>
                        <p class="mb-1">Phone: +880 1841883887</p>
                        <p>Email: info@bta.com</p>
                    </div>
                    <div class="col-4 text-end">
                        <h4 class="fw-bold">Invoice</h4>
                        <p><b>Invoice No:</b> {{ $emi->invoices->invoice_no ?? 'N/A' }}</p>
                    </div>
                </div>

                <hr>

                <!-- Customer & Flat Info -->
                <div class="row mb-4">
                    <div class="col-6">
                        <h5>Bill To:</h5>
                        <p class="mb-1"><b>{{ $customer->first_name ?? 'N/A' }} {{ $customer->last_name ?? '' }}</b></p>
                        <p class="mb-1">Flat: {{ $price->flat->title ?? 'N/A' }}</p>
                        <p>Project: {{ $price->project->title_en ?? 'N/A' }}</p>
                    </div>
                    <div class="col-6 text-end">
                        <p class="mb-1"><b>Due Date:</b> {{ $emi->emi_due_date ? \Carbon\Carbon::parse($emi->emi_due_date)->format('d M Y') : 'N/A' }}</p>
                        <p class="mb-1"><b>Paid Date:</b> {{ $emi->emi_paid_date ? \Carbon\Carbon::parse($emi->emi_paid_date)->format('d M Y') : 'N/A' }}</p>
                        <p class="mb-1">
                            <b>Next EMI Date:</b> 
                            {{ $emi->emi_due_date ? \Carbon\Carbon::parse($emi->emi_due_date)->addMonth()->format('d M Y') : 'N/A' }}
                        </p>
                        <p><b>Status:</b>
                            <span class="badge {{ $emi->status == 'approved' ? 'bg-success' : ($emi->status == 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                {{ ucfirst($emi->status) }}
                            </span>
                        </p>
                    </div>
                </div>
                <span>Extras = (Gas, Parking, Utility Charges that not included with downpayment or EMI)</span>
                <table class="table table-bordered mb-4">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" colspan="4">EMI Overview</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><b>Total Paid (Booking + Downpayment + EMI)</b></td>
                            <td class="text-end">{{ number_format($emi->total_paid_amount, 2) }} ৳</td>

                            <td><b>Remaining Due (EMI)</b></td>
                            <td class="text-end">{{ number_format($emi->remaining_due, 2) }} ৳</td>
                        </tr>
                        <tr>
                            <td><b>Total Paid (With Extras)</b></td>
                            <td class="text-end">{{ number_format($emi->total_paid_amount_with_extras, 2) }} ৳</td>

                            <td><b>Remaining Due (With Extras)</b></td>
                            <td class="text-end">
                                {{ $emi->remaining_due_amount_with_extras ? number_format($emi->remaining_due_amount_with_extras, 2).' ৳' : 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                            <td><b>Total EMI Count</b></td>
                            <td class="text-end">{{ $price->emi_count ?? 'N/A' }}</td>

                            <td><b>Remaining EMI Count</b></td>
                            <td class="text-end">{{ $emi->remaining_emi_count ?? 'N/A' }}</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Payment Details Table -->
                <table class="table table-bordered">
                    <thead class="table-dark text-white">
                        <tr>
                            <th class="text-center" colspan="2">Payment Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($emi->emi_amount)
                        <tr>
                            <td>EMI Paid Amount</td>
                            <td class="text-end">{{ number_format($emi->emi_amount, 2) }} ৳</td>
                        </tr>
                        @endif
                        @if($emi->extras_amount)
                        <tr>
                            <td>Extras Paid Amount</td>
                            <td class="text-end">{{ number_format($emi->extras_amount, 2) }} ৳</td>
                        </tr>
                        @endif
                    </tbody>
                    <tfoot>
                        <tr class="table-success fw-bold">
                            <td class="text-end">Total Paid This Transaction</td>
                            <td class="text-end">
                                {{ number_format(($emi->emi_amount ?? 0) + ($emi->extras_amount ?? 0), 2) }} ৳
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <div class="signature-section mt-5 d-flex justify-content-between">
                    <div class="signature text-center">
                        <div class="signature-line" style="margin-top:60px;border-top:1px solid #000;width:200px;"></div>
                        <p>Client Signature</p>
                    </div>
                    <div class="signature text-center">
                        <div class="signature-line" style="margin-top:60px;border-top:1px solid #000;width:200px;"></div>
                        <p>Accountants Signature</p>
                    </div>
                    <div class="signature text-center">
                        <div class="signature-line" style="margin-top:60px;border-top:1px solid #000;width:200px;"></div>
                        <p>Authority Signature</p>
                    </div>
                </div>
                <!-- Footer Notes -->
                <div class="mt-5">
                    <p><b>Note:</b> This is a system-generated invoice. Please keep it for your records.</p>
                </div>
            </div>
            <div class="modal-footer">
                @if($emi->status == 'approved' )
                    <button class="btn btn-success" onclick="printInvoice({{ $emi->id }})">Print</button>
                @endif
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
function printInvoice(id) {
    var content = document.querySelector('#invoiceModal' + id + ' .modal-body').innerHTML;

    var printWindow = window.open('', '_blank', 'width=900,height=650');

    printWindow.document.open();
    printWindow.document.write(`
    <html>
        <head>
            <title>Invoice</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                h2, h3, h4, h5 { margin: 0; }
                .invoice-header { margin-bottom: 30px; }
                .table th, .table td { vertical-align: middle; }

                /* Force color in print */
                @media print {
                    body {
                        -webkit-print-color-adjust: exact;
                        print-color-adjust: exact;
                    }
                    .table-dark th, 
                    .table-dark td {
                        background-color: #212529 !important;
                        color: #fff !important;
                    }
                    .table-light th, 
                    .table-light td {
                        background-color: #f8f9fa !important;
                        color: #000 !important;
                    }
                }
            </style>
        </head>
        <body>
            ${content}
        </body>
    </html>
    `);
    printWindow.document.close();

    printWindow.onload = function() {
        printWindow.print();
        printWindow.close();
    };
}
</script>
