<div class="modal fade" id="detailsModal{{ $price->id }}" tabindex="-1" aria-labelledby="detailsModalLabel{{ $price->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="printArea{{ $price->id }}">
            <div class="modal-header">
                <h4 class="modal-title fw-bold" id="detailsModalLabel{{ $price->id }}">
                    Invoice - Flat: {{ $price->flat->title ?? 'N/A' }}
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <!-- Company Header -->
                <div class="text-center mb-4">
                    <img src="{{ asset('uploads/settings/logo-short.svg') }}" alt="Company Logo" class="mb-2" style="max-height: 60px;">
                    <h2 class="fw-bold text-uppercase">Building Technology Architecture</h2>
                    <p class="mb-0">Client Name: {{ $price->customer->first_name ?? 'N/A' }} {{ $price->customer->last_name ?? '' }}</p>
                    <p class="mb-0">Project: {{ $price->project->title_en ?? 'N/A' }} (Flat: {{ $price->flat->title ?? 'N/A' }})</p>
                    <p class="mb-0">Flat Size: {{ $price->flat_size ?? 'N/A' }} sqft</p>
                    <small>Invoice No: {{ $price->invoices->invoice_no ?? 'N/A' }}</small>
                </div>

                <!-- Invoice Table -->
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th colspan="4" class="text-center">Flat & Price Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Price (Per sqft)</th>
                            <td>{{ number_format($price->price_per_sqft, 2) ?? 'N/A' }} Tk</td>

                            <th>Total Price</th>
                            <td>{{ number_format($price->price, 2) ?? 'N/A' }} Tk</td>
                        </tr>
                        <tr>
                            <th>Booking Amount</th>
                            <td>{{ number_format($price->booking_amount, 2) ?? 'N/A' }} Tk</td>

                            <th>Downpayment Amount</th>
                            <td>{{ number_format($price->downpayment_amount, 2) ?? 'N/A' }} Tk</td>
                        </tr>
                        <tr>
                            <th>Due Amount</th>
                            <td>{{ number_format(($price->due_amount + $price->extras_amount), 2) ?? 'N/A' }} Tk</td>

                            <th>EMI Amount (Per Month)</th>
                            <td>{{ number_format($price->emi, 2) ?? 'N/A' }} Tk</td>
                        </tr>
                        <tr>
                            <th>Total EMI Count</th>
                            <td>{{ $price->emi_count ?? 'N/A' }}</td>

                            <th>EMI Starts From</th>
                            <td>{{ $price->emi_start_date ?? 'N/A' }}</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Optional Charges -->
                <table class="table table-bordered mt-3">
                    <thead class="table-light">
                        <tr>
                            <th colspan="2" class="text-center">Additional Charges & Facilities</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Govt Gas Connection</th>
                            <td>{{ $price->is_applicable_govt_gas == 1 ? 'Included' : 'Not Included' }}</td>
                        </tr>
                        @if($price->is_govt_gas_connection_paid == 1)
                        <tr>
                            <th>Gas Connection Fee</th>
                            <td>{{ number_format($price->gas_amount, 2) ?? 'N/A' }} Tk</td>
                        </tr>
                        @endif

                        <tr>
                            <th>Parking</th>
                            <td>{{ $price->is_applicable_parking == 1 ? 'Included' : 'Not Included' }}</td>
                        </tr>
                        @if($price->is_parking_paid == 1)
                        <tr>
                            <th>Parking Fee</th>
                            <td>{{ number_format($price->parking_amount, 2) ?? 'N/A' }} Tk</td>
                        </tr>
                        @endif

                        <tr>
                            <th>Utility</th>
                            <td>{{ $price->is_utility_included == 1 ? 'Included' : 'Special Offer by BTA' }}</td>
                        </tr>
                        @if($price->is_utility_included == 1)
                        <tr>
                            <th>Utility Charge</th>
                            <td>{{ number_format($price->utility_amount, 2) ?? 'N/A' }} Tk</td>
                        </tr>
                        @endif

                        @if($price->is_discount_applicable == 1)
                        <tr>
                            <th>Discount</th>
                            <td>- {{ number_format($price->discount_amount, 2) ?? 'N/A' }} Tk</td>
                        </tr>
                        @endif

                        @if($price->extras_amount != null)
                        <tr>
                            <th>Extras (Gas, Parking, Utility)</th>
                            <td>{{ number_format($price->extras_amount, 2) ?? 'N/A' }} Tk</td>
                        </tr>
                        @endif
                    </tbody>
                </table>

                <!-- Invoice Footer -->
                <div class="mt-2 text-end">
                    <h5 class="fw-bold">Grand Total: {{ number_format($price->price, 2) ?? 'N/A' }} Tk</h5>
                </div>
                <div class="signature-section mt-3 d-flex justify-content-between">
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
                 <div class="mt-3 text-center">
                    <p><b>Note:</b> This is a system-generated invoice. Please keep it for your records.</p>
                </div>
            </div>
            <div class="modal-footer no-print">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="printModal('printArea{{ $price->id }}')">Print Invoice</button>
            </div>
        </div>
    </div>
</div>

<script>
function printModal(divId) {
    var content = document.querySelector('#' + divId + ' .modal-body').innerHTML;

    var printWindow = window.open('', '_blank', 'width=900,height=650');

    printWindow.document.open();
    printWindow.document.write(`
        <html>
            <head>
                <title>Invoice</title>
                <!-- Bootstrap CSS যোগ করো -->
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    h2, h3, h4, h5 { margin: 0; }
                    .invoice-header { margin-bottom: 30px; }
                    .table th, .table td { vertical-align: middle; }
                    .text-end { text-align: right; }
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
