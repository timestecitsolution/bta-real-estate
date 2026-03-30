<div class="container">
    <h3>Booked Flats</h3>
    <form method="POST" action="{{ route('dashboard-new-post') }}">
        @csrf
        <div class="row align-items-center">
            <div class="col-md-3">
                <label>Client <span>*</span></label>
                <select name="filter_customer_id" class="form-select" required>
                    <option value="">Select Client</option>
                    @foreach($all_booking_details->pluck('client')->unique('id') as $client)
                        <option value="{{ $client->id }}" {{ $filter_customer_id == $client->id ? 'selected' : '' }}>
                            {{ $client->first_name }} {{ $client->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label>From Date</label>
                <input type="date" class="form-control" name="filter_from_date" value="{{ $filter_from_date ?? '' }}">
            </div>
            <div class="col-md-3">
                <label>To Date</label>
                <input type="date" class="form-control" name="filter_to_date" value="{{ $filter_to_date ?? '' }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-success w-100">Filter</button>
            </div>
        </div>
    </form>
    @if($booking_details->isNotEmpty())
    <div class="table-responsive">
        <table id="booked-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Client</th>
                    <th>Flat</th>
                    <th>Flat Size (sqft)</th>
                    <th>Project</th>
                    <th>Price</th>
                    <!-- <th>Booking Amount</th>
                    <th>Due Amount</th> -->
                    <th>View Documents</th>
                    <th>Flat Details</th>
                    <th>Booking Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach($booking_details as $booking)
                    @php
                        $totalFlats = $booking->flatBookingDetails->count();
                    @endphp
                    @foreach($booking->flatBookingDetails as $key => $flat)
                        @php
                            $customer = $booking->client;
                            $existingDocuments = $flat->flatDocuments;
                        @endphp
                    <tr class="{{ $flat->is_cancelled ? 'table-danger' : '' }}">
                        <td data-label="SL">{{ $loop->iteration }}</td>
                        <td data-label="Client">{{ $customer->first_name ?? 'N/A' }} {{ $customer->last_name ?? '' }}</td>
                        <td data-label="Flat">{{ $flat->flats->flat_name ?? 'N/A' }}</td>
                        <td data-label="Flat Size (sqft)">{{ $flat->flat_size ?? 'N/A' }}</td>
                        <td data-label="Project">{{ $flat->projects->title_en ?? 'N/A' }}</td>
                        <td data-label="Price">{{ $flat->total_price_flat ?? 'N/A' }}</td>
                        @if($loop->first)
                            <!-- <td data-label="Booking Amount" rowspan="{{ $totalFlats }}" class="align-middle">
                                {{ $booking->booking_amount ?? 'N/A' }}
                            </td> -->

                            <!-- <td data-label="Due Amount" rowspan="{{ $totalFlats }}" class="align-middle">
                                {{ ($booking->due_amount_total + $booking->extras_total) ?? 'N/A' }}
                            </td> -->
                        @endif
                        <td data-label="View Documents">
                            @if($existingDocuments->isNotEmpty())
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#documentsModal{{ $flat->id }}">
                                    View Documents
                                </button>
                                @include('user-dashboard.view-documents-modal', ['existingDocuments' => $existingDocuments, 'price' => $flat])
                            @else
                                <span>No documents</span>
                            @endif
                        </td>
                        @if($flat->is_cancelled != 1)
                        <td data-label="Flat Details">
                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailsModal{{ $flat->id }}">
                                Flat Details
                            </button>
                            @include('user-dashboard.view-details-modal', ['flat' => $flat])
                        </td>
                        @endif
                        <td>
                            @if($loop->first)
                                <button class="btn btn-info btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#bookingDetailsModal{{ $booking->id }}">
                                    Booking Details
                                </button>
                                @include('user-dashboard.booking-details-modal', ['booking'=>$booking])
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p>No flats booked by this client.</p>
    @endif
</div>

<style>
/*  Desktop view (default) */
@media (min-width: 768px) {
    #booked-table {
        width: 100%;
        border-collapse: collapse;
    }

    #booked-table th, 
    #booked-table td {
        text-align: left;
        vertical-align: middle;
    }

    #booked-table thead {
        display: table-header-group;
    }
}

/*  Mobile view (Vertical style) */
@media (max-width: 767px) {
    #booked-table, 
    #booked-table thead, 
    #booked-table tbody, 
    #booked-table th, 
    #booked-table td, 
    #booked-table tr {
        display: block;
        width: 100%;
    }

    /* Hide table header */
    #booked-table thead {
        display: none;
    }

    #booked-table tr {
        margin-bottom: 1rem;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 10px;
        background: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    #booked-table td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px;
        border: none;
        border-bottom: 1px solid #eee;
    }

    #booked-table td::before {
        content: attr(data-label);
        font-weight: 600;
        text-transform: capitalize;
        text-align: left;
    }

    #booked-table td:last-child {
        border-bottom: none;
    }

    #booked-table button {
        width: 100%;
    }
}
</style>
