@extends('dashboard.layouts.master')
@section('title', "Client Notices")
@section('content')
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <div class="row">
                    <div class="col-lg-8 col-sm-6">
                        <h3>List of Notices</h3>
                        <small>
                            <a href="{{ route('adminHome') }}">{{ __('backend.home') }}</a> /
                            <a>Client Notices</a> /
                            <a>List of Notices</a>
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
                                       href="{{route('client-notice.create')}}">
                                        <i class="material-icons">&#xe02e;</i>
                                        &nbsp; Create notice</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="b-t">
                @if(count($ClientNotices) < 0)
                    <div class="row p-a">
                        <div class="col-sm-12">
                            <div class=" p-a text-center ">
                                <div class="text-muted m-b"><i class="fa fa-laptop fa-4x"></i></div>
                                <h6>{{ __('backend.noData') }}</h6>
                            </div>
                        </div>
                    </div>
                @endif 

                @if(count($ClientNotices) > 0)
                    {{-- {{Form::open(['route'=>['categoriesUpdateAll',8],'method'=>'post'])}} --}}
                    <div class="table-responsive">
                        <table class="table table-bordered m-a-0">
                            <thead class="dker">
                            <tr>
                                <th class="text-center w-64">Sl No</th>
                                <th class="text-center" style="width:100px;">Client</th>
                                <th class="text-center" style="width:100px;">Subject</th>
                                <th class="text-center" style="width:100px;">Body</th>
                                {{-- <th class="text-center" style="width:50px;">{{ __('backend.status') }}</th> --}}
                                <th class="text-center" style="width:60px;">{{ __('backend.options') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $title_var = "title_" . @Helper::currentLanguage()->code;
                            $title_var2 = "title_" . config('smartend.default_language');
                            $x = 0;
                            ?>
                            @foreach($ClientNotices as $ClientNotice)
                                <?php
                                    $x++;
                                ?>
                                <tr>
                                    <td class="text-center">{{ $x }}</td>
                                    <td class="text-center">{{ $ClientNotice->client->first_name }} {{ $ClientNotice->client->last_name }} ({{ $ClientNotice->client->phone }})</td>
                                    <td class="text-center">{{ $ClientNotice->subject->subject }}</td>
                                    <td class="text-center">
                                        {!! $ClientNotice->notice_body !!}
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="dropdown {{ (($x+1) >= count($ClientNotices))?"dropup":"" }}">
                                            <button type="button" class="btn btn-sm light dk dropdown-toggle"
                                                    data-toggle="dropdown"><i class="material-icons">&#xe5d4;</i>
                                                {{ __('backend.options') }}
                                            </button>
                                            <div class="dropdown-menu pull-right">
                                                @if(@Auth::user()->permissionsGroup->edit_status)
                                                    <a class="dropdown-item"
                                                       href="{{ route('client-notice.edit', ['id'=>$ClientNotice->id]) }}"><i
                                                            class="material-icons">&#xe3c9;</i> {{ __('backend.edit') }}
                                                    </a>
                                                @endif
                                                @if(@Auth::user()->permissionsGroup->delete_status)
                                                    <a class="dropdown-item text-danger"
                                                       onclick="DeleteNotice('{{ $ClientNotice->id }}')"><i
                                                            class="material-icons">&#xe872;</i> {{ __('backend.delete') }}
                                                    </a>
                                                @endif
                                                @if(@Auth::user()->permissionsGroup->action_status)
                                                    <a class="dropdown-item"
                                                       onclick="ActionNotice('{{ $ClientNotice->id }}')"><i
                                                            class="material-icons">assignment_turned_in</i> Action
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
    @include('dashboard.client-notice.action-modal')
@endsection
@push("after-scripts")
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

        function DeleteNotice(id) {
            $("#category_delete_btn").attr("href", '{{ route("client-notice.destroy", ":id") }}'.replace(':id', id));
            $("#delete-category").modal("show");
        }

    </script>
    <script>
        function ActionNotice(id){
            $('#notice_id').val(id);
            $('#actionNoticeModal').modal('show');
        }
    </script>
@endpush
