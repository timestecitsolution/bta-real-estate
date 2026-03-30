<div class="modal fade" id="bookingDetailsModal{{ $booking->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="printArea{{ $booking->id }}">
            <div class="modal-header">
                <h4 class="modal-title fw-bold" id="detailsModalLabel{{ $booking->id }}">
                    Invoice
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <!-- Company Header -->
                <div class="text-center mb-4">
                    <img src="{{ asset('uploads/settings/logo-short.svg') }}" alt="Company Logo" class="mb-2" style="max-height: 60px;">
                    <h2 class="fw-bold text-uppercase">Building Technology Architecture</h2>
                    <p class="mb-0">Client Name: {{ $customer->first_name ?? 'N/A' }} {{ $customer->last_name ?? '' }}</p>
                    <p class="mb-0">
                        Project: 
                        @foreach($booking->flatBookingDetails as $flat)

                            {{ $flat->projects->title_en ?? 'N/A' }}
                            ({{ $flat->flats->flat_name ?? 'N/A' }} ({{ $flat->flats->flat_size ?? 'N/A' }} sqft))

                            @if(!$loop->last)
                                ,
                            @endif

                        @endforeach
                    </p>
                    <small>Invoice No: {{ $flat->invoices->invoice_no ?? 'N/A' }}</small>
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
                            <th>Booking Amount</th>
                            <td>{{ number_format($booking->booking_amount, 2) ?? 'N/A' }} Tk</td>

                            <th>Downpayment Amount</th>
                            <td>{{ number_format($booking->downpayment_amount, 2) ?? 'N/A' }} Tk</td>
                        </tr>
                        <tr>
                            <th>Due Amount</th>
                            <td>{{ number_format(($booking->due_amount_total + $booking->extras_total), 2) ?? 'N/A' }} Tk</td>

                            <th>Total EMI Amount (Per Month)</th>
                            <td>{{ number_format($booking->total_emi_amount, 2) ?? 'N/A' }} Tk</td>
                        </tr>
                        <tr>
                            <th>Total EMI Count</th>
                            <td>{{ $booking->emi_count ?? 'N/A' }}</td>

                            <th>EMI Starts From</th>
                            <td>{{ $booking->emi_start_date ?? 'N/A' }}</td>
                        </tr>
                    </tbody>
                </table>
                <!-- Invoice Footer -->
                <div class="mt-2 text-end">
                    <h5 class="fw-bold">Grand Total: {{ number_format($booking->total_price, 2) ?? 'N/A' }} Tk</h5>
                </div>
                <!-- <div class="signature-section mt-3 d-flex justify-content-between">
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
                </div> -->
                 <div class="mt-3 text-center">
                    <p><b>Note:</b> This is a system-generated invoice. Please keep it for your records.</p>
                </div>
            </div>
            <div class="modal-footer no-print">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="printModal('printArea{{ $flat->id }}')">Print Invoice</button>
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