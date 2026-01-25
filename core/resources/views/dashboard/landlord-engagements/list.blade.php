@extends('dashboard.layouts.master')
@section('title', "Landlord Engagements Module")
@section('content')
<div class="padding">
    <div class="box">
        <div class="box-header dker">
            <div class="row">
                <div class="col-lg-8 col-sm-6">
                    <h3>List of Engagements</h3>
                    <small>
                        <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                        <a href="{{ route('landlord-engagements.create') }}">Add Engagements</a> /
                        <a href="{{ route('landlordEngagements') }}">List of Engagements</a>
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
                                    href="{{route('landlord-engagements.create')}}">
                                    <i class="material-icons">&#xe02e;</i>
                                    &nbsp; Add Engagement</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="b-t">
            @if($engagements->count() > 0)

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="dker">
                        <tr>
                            <th class="text-center">SL</th>
                            <th>Project</th>
                            <th>Landlord</th>
                            <th>Flat</th>
                            <th>Flat Documents</th>
                            <th>Materials</th>
                            <th class="text-center">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sl = 1;

                            // Group by project
                            $projects = $engagements->groupBy(function ($item) {
                                return $item->project->id ?? 0;
                            });
                        @endphp

                        @foreach($projects as $projectId => $projectEngagements)

                            @php
                                $projectTitle = $projectEngagements->first()->project->title_en ?? 'N/A';

                                // Group by landlord under project
                                $landlords = $projectEngagements->groupBy(function ($item) {
                                    return $item->customer->id ?? 0;
                                });

                                // Total rows for this project (for rowspan)
                                $projectRowSpan = $landlords->sum(function ($group) {
                                    return max(1, $group->count());
                                });

                                $isFirstProjectRow = true;
                            @endphp

                            @foreach($landlords as $landlordId => $landlordEngagements)

                                @php
                                    $landlord = $landlordEngagements->first()->customer;
                                    $landlordRowSpan = max(1, $landlordEngagements->count());
                                    $isFirstLandlordRow = true;
                                @endphp

                                @foreach($landlordEngagements as $engagement)
                                    <tr>
                                        {{-- SL --}}
                                        @if($isFirstProjectRow)
                                            <td class="text-center" rowspan="{{ $projectRowSpan }}">
                                                {{ $sl }}
                                            </td>
                                        @endif

                                        {{-- Project --}}
                                        @if($isFirstProjectRow)
                                            <td rowspan="{{ $projectRowSpan }}">
                                                {{ $projectTitle }}
                                            </td>
                                        @endif

                                        {{-- Landlord --}}
                                        @if($isFirstLandlordRow)
                                            <td rowspan="{{ $landlordRowSpan }}">
                                                {{ $landlord->first_name ?? '' }}
                                                {{ $landlord->last_name ?? '' }}
                                            </td>
                                        @endif

                                        {{-- Flat --}}
                                        <td>
                                            {{ $engagement->flat->title ?? 'No Flat' }}
                                        </td>

                                        {{-- Flat Documents --}}
                                        <td>
                                            @forelse($engagement->flatDocuments as $fd)
                                                <div class="mb-1">
                                                    <strong>{{ $fd->documentType->name ?? 'Document' }}</strong><br>
                                                    <a href="{{ asset('uploads/' . $fd->file_path) }}"
                                                    class="btn btn-xs btn-info" target="_blank">
                                                        Download
                                                    </a>
                                                </div>
                                                <hr class="m-0">
                                            @empty
                                                <span class="text-muted">No Flat Documents</span>
                                            @endforelse
                                        </td>

                                        {{-- Materials --}}
                                        <td>
                                            @forelse($engagement->materials as $m)
                                                <div class="mb-1">
                                                    <strong>{{ $m->materialType->material_type ?? 'Material' }}</strong><br>
                                                    Note: {{ $m->material_details ?? '' }}<br>

                                                    @if($m->material_documents)
                                                        <a href="{{ asset('uploads/' . $m->material_documents) }}"
                                                        class="btn btn-xs btn-warning" target="_blank">
                                                            Download
                                                        </a>
                                                    @endif
                                                </div>
                                                <hr class="m-0">
                                            @empty
                                                <span class="text-muted">No Materials</span>
                                            @endforelse
                                        </td>

                                        {{-- OPTIONS (PROJECT LEVEL – ONE TIME) --}}
                                        @if($isFirstProjectRow)
                                            <td class="text-center" rowspan="{{ $projectRowSpan }}">
                                                <div class="dropdown">
                                                    <button class="btn btn-sm light dk dropdown-toggle" data-toggle="dropdown">
                                                        <i class="material-icons">&#xe5d4;</i> Options
                                                    </button>

                                                    <div class="dropdown-menu pull-right">
                                                        @if(@Auth::user()->permissionsGroup->edit_status && app()->environment('local'))
                                                            <a class="dropdown-item"
                                                            href="{{ route('landlord-engagements.edit', $projectId) }}">
                                                                <i class="material-icons">&#xe3c9;</i> Edit
                                                            </a>
                                                        @endif
                                                        <a class="dropdown-item text-danger"
                                                        onclick="DeleteProjectEng('{{ $projectId }}')">
                                                            <i class="material-icons">&#xe872;</i> Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                    @php
                                        $isFirstLandlordRow = false;
                                        $isFirstProjectRow  = false;
                                    @endphp
                                @endforeach
                            @endforeach
                            @php $sl++; @endphp
                        @endforeach
                    </tbody>
                </table>

            </div>
            @else
            <div class="p-a text-center">No Engagements Found</div>
            @endif
        </div>
    </div>
</div>
@include('dashboard.price.deal-cancel-modal')
@include('dashboard.price.deal-reopen-modal')

<!-- Delete Modal -->
<div id="delete-eng" class="modal fade" data-backdrop="true">
    <div class="modal-dialog" id="animate">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('backend.confirmation') }}</h5>
            </div>
            <div class="modal-body text-center p-lg">
                <p>{{ __('backend.confirmationDeleteMsg') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">{{ __('backend.no') }}</button>
                <a type="button" id="eng_delete_btn" href="" class="btn danger p-x-md">{{ __('backend.yes') }}</a>
            </div>
        </div>
    </div>
</div>

@endsection

@push("after-scripts")
<script>
function DeleteProjectEng(projectId) {
    console.log(projectId);
    let url = "{{ route('landlord-engagements.destroy', ':id') }}";
    url = url.replace(':id', projectId);

    $("#eng_delete_btn").attr("href", url);
    $("#delete-eng").modal("show");
}
</script>
@endpush
