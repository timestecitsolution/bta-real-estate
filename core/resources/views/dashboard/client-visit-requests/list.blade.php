@extends('dashboard.layouts.master')
@section('title', "Booking Details Module")
@section('content')
    <div class="padding">
        <div class="box">
            <div class="b-t">
                @if(count($requests) < 0)
                    <div class="row p-a">
                        <div class="col-sm-12">
                            <div class=" p-a text-center ">
                                <div class="text-muted m-b"><i class="fa fa-laptop fa-4x"></i></div>
                                <h6>{{ __('backend.noData') }}</h6>
                            </div>
                        </div>
                    </div>
                @endif 

                @if(count($requests) > 0)
                    {{-- {{Form::open(['route'=>['categoriesUpdateAll',8],'method'=>'post'])}} --}}
                    <div class="table-responsive">
                        <table id="bookingRequestTable" class="table table-bordered m-a-0">
                            <thead class="dker">
                            <tr>
                                <th class="text-center w-64">Sl No</th>
                                <th class="text-center" style="width:100px;">Project</th>
                                <th class="text-center" style="width:100px;">Flat</th>
                                <th class="text-center" style="width:100px;">Full Name</th>
                                <th class="text-center" style="width:100px;">Email</th>
                                <th class="text-center" style="width:100px;">Phone</th>
                                <th class="text-center" style="width:100px;">Preferred Date</th>
                                <th class="text-center" style="width:60px;">{{ __('backend.options') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $title_var = "title_" . @Helper::currentLanguage()->code;
                            $title_var2 = "title_" . config('smartend.default_language');
                            $x = 0;
                            ?>
                            @foreach($requests as $request)
                                <?php
                                    $x++;
                                ?>
                                <tr class="{{ $request->is_cancelled ? 'table-danger' : '' }}">
                                    <td class="text-center">{{ $x }}</td>
                                    <td class="text-center">{{ $request->project ? $request->project->title_en : 'N/A' }}</td>
                                    <td class="text-center">{{ $request->flat_id ? $request->flat_id : 'N/A' }}</td>
                                     <td class="text-center">{{ $request->full_name ? $request->full_name : 'N/A' }}</td>
                                    <td class="text-center">{{ $request->email }}</td>
                                    <td class="text-center">{{ $request->phone }}</td>
                                    <td class="text-center">{{ $request->preferred_date }}</td>
                                    {{-- <td class="h6 nowrap">
                                        {!! Form::text('row_no_'.$request->id,$request->row_no, array('class' => 'form-control row_no light','autocomplete'=>'off')) !!}
                                        @if (@Auth::user()->permissionsGroup->edit_status)
                                            <a href="{{ route("categoriesEdit",["id"=>$request->id]) }}">
                                                @if($request->icon !="")
                                                    <i class="fa {!! $request->icon !!} "></i>
                                                @endif
                                                {{ $title }}
                                            </a>
                                        @else
                                            @if($Section->icon !="")
                                                <i class="fa {!! $Section->icon !!} "></i>
                                            @endif
                                            {{ $title }}
                                        @endif
                                    </td> --}}
                                    
                                    <td class="text-center">
                                        <div class="dropdown {{ (($x+1) >= count($requests))?"dropup":"" }}">
                                            <button type="button" class="btn btn-sm light dk dropdown-toggle"
                                                    data-toggle="dropdown"><i class="material-icons">&#xe5d4;</i>
                                                {{ __('backend.options') }}
                                            </button>
                                            <div class="dropdown-menu pull-right">
                                                @if(@Auth::user()->permissionsGroup->delete_status && !$request->is_cancelled)
                                                    <a href="javascript:void(0)" class="dropdown-item" onclick="visitPreview({{ $request->id }})">
                                                        <i
                                                        class="material-icons">&#xe8f4;</i> Preview Visit
                                                    </a>
                                                @endif
                                                 @if(@Auth::user()->permissionsGroup->delete_status)
                                                    <a class="dropdown-item text-danger"
                                                       onclick="DeleteCustomerVisit('{{ $request->id }}')"><i
                                                            class="material-icons">&#xe872;</i> {{ __('backend.delete') }}
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>

                    </div>
                    <footer class="dker p-a">
                        <div class="row">
                            <div class="col-sm-3 hidden-xs">
                                <!-- .modal -->
                                <div id="m-all" class="modal fade" data-backdrop="true">
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
                                                <button type="submit"
                                                        class="btn danger p-x-md">{{ __('backend.yes') }}</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div>
                                </div>
                                <!-- / .modal -->
                            </div>

                        </div>
                    </footer>
                    {{Form::close()}} 
                @endif
            </div>
        </div>
    </div>
    <!-- .modal -->
    <div id="delete-category" class="modal fade" data-backdrop="true">
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
                    <a type="button" id="category_delete_btn" href=""
                       class="btn danger p-x-md">{{ __('backend.yes') }}</a>
                </div>
            </div><!-- /.modal-content -->
        </div>
    </div>
@endsection
@push("after-scripts")
@include('dashboard.client-visit-requests.preview') 
    <script type="text/javascript">
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
        $("#action").change(function () {
            if (this.value == "delete") {
                $("#submit_all").css("display", "none");
                $("#submit_show_msg").css("display", "inline-block");
            } else {
                $("#submit_all").css("display", "inline-block");
                $("#submit_show_msg").css("display", "none");
            }
        });

        function DeleteCustomerVisit(id) {
            $("#category_delete_btn").attr("href", '{{ route("client-visit-request.destroy", ":id") }}'.replace(':id', id));
            $("#delete-category").modal("show");
        }

        // SHOW MODAL
       function visitPreview(id) {

            if (!id) {
                alert('ID missing');
                return;
            }

            // Clear previous data
            $('#visitpreviewModal span').text('');
            $('#visitpreviewModal p').text('');
            $('#nid_front_pic, #nid_back_pic').attr('src', '');

            $.ajax({
                url: "{{ route('client-visit-requests.show', ':id') }}".replace(':id', id),
                type: "GET",
                dataType: "json",
                beforeSend: function () {
                    // optional loader
                    // $('#visitpreviewModal').modal('show');
                },
                success: function (res) {

                    $('#full_name').text(res.full_name ?? '—');
                    $('#email').text(res.email ?? '—');
                    $('#phone').text(res.phone ?? '—');
                    $('#passport_no').text(res.passport_no ?? '—');
                    $('#nid_no').text(res.nid_no ?? '—');
                    $('#birth_certificate_no').text(res.birth_certificate_no ?? '—');
                    $('#project_id').text(res.project_id ?? '—');
                    $('#flat_id').text(res.flat_id ?? '—');
                    $('#preferred_date').text(res.preferred_date ?? '—');
                    $('#message').text(res.message ?? '—');

                    if (res.nid_front_pic) {
                        $('#nid_front_pic').attr('src', '/' + res.nid_front_pic).show();
                    } else {
                        $('#nid_front_pic').hide();
                    }

                    if (res.nid_back_pic) {
                        $('#nid_back_pic').attr('src', '/' + res.nid_back_pic).show();
                    } else {
                        $('#nid_back_pic').hide();
                    }

                    $('#visitpreviewModal').modal('show');
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert('Failed to load visit preview');
                }
            });
        }
    </script>

    <script>
        $(document).ready(function () {
            $('#bookingRequestTable').DataTable({
                pageLength: 10,
                ordering: true,
                searching: true,
                responsive: true,
                dom: 'Bfrtip',

                columnDefs: [
                    {
                        targets: -1,        
                        orderable: false,   
                        searchable: false, 
                        exportable: false  
                    }
                ],
                buttons: [
                    {
                        extend: 'print',
                        text: '🖨 Print',
                        title: 'Visit Requests',
                        exportOptions: {
                            columns: ':not(:last-child)' 
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        text: '📊 Excel',
                        title: 'Visit Requests',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '📄 PDF',
                        title: 'Visit Requests',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
                ]
            });
        });
    </script>
@endpush
