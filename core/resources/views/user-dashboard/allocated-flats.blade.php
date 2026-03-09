<div class="container">
    <h3>Allocated Flats</h3>
    <form method="POST" action="{{ route('dashboard-new-post') }}">
        @csrf
        <div class="row g-2 align-items-center">
            <div class="col-md-3">
                <label>Landlord <span>*</span></label>
                <select name="landlord_id" class="form-select" required>
                    <option value="">Select Landlord</option>
                    @foreach($allocated_flats->pluck('customer')->unique('id') as $customer)
                        <option value="{{ $customer->id }}" 
                            {{ (isset($landlord_id) && $landlord_id==$customer->id) ? 'selected' : '' }}>
                            {{ $customer->first_name }} {{ $customer->last_name }}
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
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-success w-100">Filter</button>
            </div>
        </div>
    </form>
    @if($allocated_flats->isNotEmpty())
    <div class="table-responsive mt-3">
        <table id="allocated-flats-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Landlord</th>
                    <th>Flat</th>
                    <th>Project</th>
                    <th>View Documents</th>
                    <th>Material</th>
                    <!-- <th>View Details</th> -->
                </tr>
            </thead>
            <tbody>
                @foreach($allocated_flats as $allocated_flat)
                @php
                    $existingDocuments = $allocated_flat->flatDocuments;
                    $existingMaterials = $allocated_flat->materials;
                @endphp
                <tr class="{{ $allocated_flat->is_cancelled ? 'table-danger' : '' }}">
                    <td data-label="SL">{{ $loop->iteration }}</td>
                    <td data-label="Landlord">{{ $allocated_flat->customer->first_name ?? 'N/A' }} {{ $allocated_flat->customer->last_name ?? '' }}</td>
                    <td data-label="Flat">{{ $allocated_flat->flat->flat_name ?? 'N/A' }}</td>
                    <td data-label="Project">{{ $allocated_flat->project->title_en ?? 'N/A' }}</td>
                    <td data-label="View Documents">
                        @if($existingDocuments->isNotEmpty())
                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#landlorddocumentsModal{{ $allocated_flat->id }}">
                                View Documents
                            </button>
                            @include('user-dashboard.landlord-document-modal', ['existingDocuments' => $existingDocuments, 'allocated_flat' => $allocated_flat])
                        @else
                            <span>No documents</span>
                        @endif
                    </td>
                    <td data-label="View Materials">
                        @if($existingMaterials->isNotEmpty())
                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#landlordmaterialsModal{{ $allocated_flat->id }}">
                                Materials
                            </button>
                            @include('user-dashboard.landlord-material-modal', ['existingMaterials' => $existingMaterials, 'allocated_flat' => $allocated_flat])
                        @else
                            <span>No material found</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p>No flats allocated to this landlord.</p>
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
