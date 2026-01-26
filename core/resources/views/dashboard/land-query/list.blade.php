@extends('dashboard.layouts.master')
@section('title', "Land Query List")
@section('content')
    <div class="padding">
        <div class="box">
            <div class="b-t">
                @if(count($landQueries) < 0)
                    <div class="row p-a">
                        <div class="col-sm-12">
                            <div class=" p-a text-center ">
                                <div class="text-muted m-b"><i class="fa fa-laptop fa-4x"></i></div>
                                <h6>{{ __('backend.noData') }}</h6>
                            </div>
                        </div>
                    </div>
                @endif 

                @if(count($landQueries) > 0)
                    {{-- {{Form::open(['route'=>['categoriesUpdateAll',8],'method'=>'post'])}} --}}
                    <div class="table-responsive">
                        <table id="landQueryTable" class="table table-bordered m-a-0">
                            <thead class="dker">
                            <tr>
                                <th class="text-center w-64">Sl No</th>
                                <th class="text-center" style="width:100px;">Owner Name</th>
                                <th class="text-center" style="width:100px;">Phone</th>
                                <th class="text-center" style="width:100px;">Land Address</th>
                                <th class="text-center" style="width:100px;">Land Size</th>
                                <th class="text-center" style="width:100px;">Land Info</th>
                                <th class="text-center" style="width:100px;">Road Size</th>
                                <th class="text-center" style="width:60px;">{{ __('backend.options') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $title_var = "title_" . @Helper::currentLanguage()->code;
                            $title_var2 = "title_" . config('smartend.default_language');
                            $x = 0;
                            ?>
                            @foreach($landQueries as $landquery)
                                <?php
                                    $x++;
                                ?>
                                <tr class="{{ $landquery->is_cancelled ? 'table-danger' : '' }}">
                                    <td class="text-center">{{ $x }}</td>
                                    <td class="text-center">{{ $landquery->owner_name }}</td>
                                    <td class="text-center">{{ $landquery->phone }}</td>
                                    <td class="text-center">{{ $landquery->land_address }}</td>
                                    <td class="text-center">{{ $landquery->land_area }}</td>
                                    <td class="text-center">{{ $landquery->land_info }}</td>
                                    <td class="text-center">{{ $landquery->road_size }}</td>
                                    {{-- <td class="h6 nowrap">
                                        {!! Form::text('row_no_'.$landquery->id,$landquery->row_no, array('class' => 'form-control row_no light','autocomplete'=>'off')) !!}
                                        @if (@Auth::user()->permissionsGroup->edit_status)
                                            <a href="{{ route("categoriesEdit",["id"=>$landquery->id]) }}">
                                                @if($landquery->icon !="")
                                                    <i class="fa {!! $landquery->icon !!} "></i>
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
                                        <div class="dropdown {{ (($x+1) >= count($landQueries))?"dropup":"" }}">
                                            <button type="button" class="btn btn-sm light dk dropdown-toggle"
                                                    data-toggle="dropdown"><i class="material-icons">&#xe5d4;</i>
                                                {{ __('backend.options') }}
                                            </button>
                                            <div class="dropdown-menu pull-right">
                                                @if(@Auth::user()->permissionsGroup->delete_status)
                                                    <a href="javascript:void(0)" class="dropdown-item" onclick="QueryPreview({{ $landquery->id }})">
                                                        <i
                                                        class="material-icons">&#xe8f4;</i> Preview Land Query
                                                    </a>
                                                @endif
                                                 @if(@Auth::user()->permissionsGroup->delete_status)
                                                    <a class="dropdown-item text-danger"
                                                       onclick="DeleteLandQuery('{{ $landquery->id }}')"><i
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
@include('dashboard.land-query.preview') 
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

        function DeleteLandQuery(id) {
            $("#category_delete_btn").attr("href", '{{ route("land-query.destroy", ":id") }}'.replace(':id', id));
            $("#delete-category").modal("show");
        }

        // SHOW MODAL
       function QueryPreview(id) {

            if (!id) {
                alert('ID missing');
                return;
            }

            // Clear previous data
            $('#landquerypreviewModal span').text('—');
            $('#landquerypreviewModal p').text('—');

            $('#attachment_preview').html('');

            $.ajax({
                url: "{{ route('land-query.show', ':id') }}".replace(':id', id),
                type: "GET",
                dataType: "json",
                success: function (res) {

                    $('#owner_name').text(res.owner_name ?? '—');
                    $('#email').text(res.email ?? '—');
                    $('#phone').text(res.phone ?? '—');
                    $('#land_address').text(res.land_address ?? '—');
                    $('#land_area').text(res.land_area ?? '—');
                    $('#land_info').text(res.land_info ?? '—');
                    $('#road_size').text(res.road_size ?? '—');
                    $('#review').text(res.review ?? '—');

                    // Attachments preview
                    if (Array.isArray(res.attachments)) {
                        res.attachments.forEach(function (file) {
                            if (file) {
                                $('#attachment_preview').append(`
                                    <img src="/uploads/land_query/${file}" class="img-thumbnail mr-2 mb-2" width="120">
                                `);
                            }
                        });
                    }

                    $('#landquerypreviewModal').modal('show');
                },
                error: function () {
                    alert('Failed to load land query preview');
                }
            });
        }
    </script>

    <script>
        $(document).ready(function () {
            $('#landQueryTable').DataTable({
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
