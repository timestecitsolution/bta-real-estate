@extends('dashboard.layouts.master')
@section('title', "Booking Details Module")
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <div class="row">
                    <div class="col-lg-8 col-sm-6">
                        <h3>List of Bookings</h3>
                        <small>
                            <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                            <a>Bookings</a> /
                            <a>List of Bookings</a>
                        </small>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="row">
                            {{-- <div class="col-sm-7">
                                {{Form::open(['route'=>['categories',8],'method'=>'GET', 'role'=>'search', 'class' => "form-inline" ])}}

                                <div class="form-group">
                                    <div class="input-group"><input type="text" name="q" value="{{ @$_GET['q'] }}"
                                                                    class="form-control p-x" autocomplete="off"
                                                                    placeholder="{{ __('backend.searchIn')." ".__('backend.price') }}">
                                        <span
                                            class="input-group-btn"><button type="submit"
                                                                            class="btn white b-a no-shadow"><i
                                                    class="fa fa-search"></i></button></span></div>
                                </div>
                                {{Form::close()}}
                            </div> --}}
                            <div class="col-sm-5" style="float: right !important;">
                                @if(@Auth::user()->permissionsGroup->add_status)
                                    <a class="btn btn-fw primary w-100" style="overflow: hidden"
                                       href="{{route('flat-booking.create')}}">
                                        <i class="material-icons">&#xe02e;</i>
                                        &nbsp; Add Booking Details</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if($flatBookingDetails->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Client</th>
                            <th>Project</th>
                            <th>Flat</th>
                            <th>Flat Documents</th>
                            <th>Materials</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $sl = 1; @endphp

                        @foreach($flatBookingDetails as $booking)
                            @php
                                $client = $booking->client;
                                $clientRowSpan = $booking->flatBookingDetails->count(); // rowspan for client
                                $isFirstClientRow = true;

                                // Group booked flats by project
                                $projects = $booking->flatBookingDetails->groupBy('project_id');
                            @endphp

                            @foreach($projects as $projectId => $projectFlats)
                                @php
                                    $project = $projectFlats->first()->projects ?? null;
                                    $projectRowSpan = $projectFlats->count(); // rowspan for project
                                    $isFirstProjectRow = true;
                                @endphp

                                @foreach($projectFlats as $flatDetail)
                                    <tr>

                                        {{-- SL --}}
                                        @if($isFirstClientRow)
                                            <td rowspan="{{ $clientRowSpan }}" class="text-center">{{ $sl }}</td>
                                        @endif

                                        {{-- Client --}}
                                        @if($isFirstClientRow)
                                            <td rowspan="{{ $clientRowSpan }}">
                                                {{ $client->first_name ?? '' }} {{ $client->last_name ?? '' }}
                                            </td>
                                        @endif

                                        {{-- Project --}}
                                        @if($isFirstProjectRow)
                                            <td rowspan="{{ $projectRowSpan }}">
                                                {{ $project->title_en ?? 'N/A' }}
                                            </td>
                                        @endif

                                        {{-- Flat --}}
                                        <td>{{ $flatDetail->flats->flat_name ?? 'No Flat' }}</td>

                                        {{-- Flat Documents --}}
                                        <td>
                                            @forelse($flatDetail->flatDocuments as $doc)
                                                <div>
                                                    <strong>{{ $doc->documentType->name ?? 'Document' }}</strong><br>
                                                    <a href="{{ asset('uploads/' . $doc->file_path) }}" 
                                                    class="btn btn-xs btn-info" target="_blank">Download</a>
                                                </div>
                                                <hr>
                                            @empty
                                                <span class="text-muted">No Documents</span>
                                            @endforelse
                                        </td>

                                        {{-- Materials --}}
                                        <td>
                                            @php
                                                $materials = $flatDetail->materialDocuments
                                                    ->where('booked_flat_id', $flatDetail->id);
                                            @endphp

                                            @forelse($materials as $m)
                                                <div>
                                                    <strong>{{ $m->materialType->material_type ?? '' }}</strong><br>
                                                    {{ $m->details }}<br>
                                                    @if($m->material_document)
                                                        <a href="{{ asset('uploads/' . $m->material_document) }}"
                                                        class="btn btn-xs btn-warning" target="_blank">Download</a>
                                                    @endif
                                                </div>
                                                <hr>
                                            @empty
                                                <span class="text-muted">No Materials</span>
                                            @endforelse
                                        </td>

                                        {{-- Options --}}
                                        @if($isFirstProjectRow)
                                            <td class="text-center" rowspan="{{ $projectRowSpan }}">
                                                <div class="dropdown">
                                                    <button class="btn btn-sm light dk dropdown-toggle" data-toggle="dropdown">
                                                        <i class="material-icons">&#xe5d4;</i> Options
                                                    </button>

                                                    <div class="dropdown-menu pull-right">
                                                        @if(@Auth::user()->permissionsGroup->edit_status && app()->environment('local'))
                                                            <a class="dropdown-item"
                                                            href="{{ route('flat-booking.edit', $booking->id) }}">
                                                                <i class="material-icons">&#xe3c9;</i> Edit
                                                            </a>
                                                        @endif
                                                        <a class="dropdown-item text-danger"
                                                        onclick="DeleteBooking('{{ $booking->id }}')">
                                                            <i class="material-icons">&#xe872;</i> Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                    @php
                                        $isFirstClientRow = false;
                                        $isFirstProjectRow = false;
                                    @endphp
                                @endforeach
                            @endforeach
                            @php $sl++; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <div class="text-center p-3">No Booking Found</div>
            @endif
        </div>
    </div>
    <!-- .modal -->
    <div id="delete-booking" class="modal fade" data-backdrop="true">
        <div class="modal-dialog" id="animate">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('backend.confirmation') }}</h5>
                </div>
                <div class="modal-body text-center p-lg">
                    <p>
                        {{ __('backend.confirmationDeleteMsg') }}
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark-white p-x-md"
                            data-dismiss="modal">{{ __('backend.no') }}</button>
                    <a type="button" id="booking_delete_btn" href=""
                       class="btn danger p-x-md">{{ __('backend.yes') }}</a>
                </div>
            </div><!-- /.modal-content -->
        </div>
    </div>
@endsection
@push("after-scripts")
<script>
function DeleteBooking(bookingId) {
    let url = "{{ route('flat-booking.destroy', ':id') }}";
    url = url.replace(':id', bookingId);

    $("#booking_delete_btn").attr("href", url);
    $("#delete-booking").modal("show");
}
</script>
@endpush