<div class="container">
    <h3>Booked Flats</h3>
    @if($prices_details->isNotEmpty())
        <table id="booked-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Client</th>
                    <th>Flat</th>
                    <th>Flat Size (sqft)</th>
                    <th>Project</th>
                    <th>Price</th>
                    <th>Booking Amount</th>
                    <th>Due Amount</th>
                    <th>View Documents</th>
                    <th>View Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prices_details as $key => $price)
                    @php
                        $customer = $price->customer;
                        $existingDocuments = App\Models\FlatDocuments::where('price_id', $price->id)->get();
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $customer->first_name ?? 'N/A' }} {{ $customer->last_name ?? '' }}</td>
                        <td>{{ $price->flat->title ?? 'N/A' }}</td>
                        <td>{{ $price->flat_size ?? 'N/A' }}</td>
                        <td>{{ $price->project->title_en ?? 'N/A' }}</td>
                        <td>{{ $price->price ?? 'N/A' }}</td>
                        <td>{{ $price->booking_amount ?? 'N/A' }}</td>
                        <td>{{ $price->due_amount ?? 'N/A' }}</td>
                        <td>
                            @if($existingDocuments->isNotEmpty())
                                <!-- Documents Modal Trigger -->
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#documentsModal{{ $price->id }}">
                                    View Documents
                                </button>
                                @include('user-dashboard.view-documents-modal', ['existingDocuments' => $existingDocuments, 'price' => $price])
                            @else
                                <span>No documents</span>
                            @endif
                        </td>
                        <td>
                            <!-- Details Modal Trigger -->
                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailsModal{{ $price->id }}">
                                View Details
                            </button>
                            @include('user-dashboard.view-details-modal', ['price' => $price])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No flats booked by this client.</p>
    @endif
</div>
