<!-- column -->
<div class="col-sm-6 col-md-7">
    <div class="row-col">
        <div class="p-a-sm">
            <div>
                <h6 class="m-b-0 m-t-sm"><i class="material-icons">&#xe3c9;</i> {{ __('backend.editContacts') }}</h6>
            </div>
        </div>
        <div class="row-row">
            <div class="row-body">
                <div class="row-inner">
                    <div class="padding p-y-sm">
                        @if(Session::has('doneMessage2'))
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        {{ Session::get('doneMessage2') }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{Form::open(['route'=>['contactsUpdate',Session::get('ContactToEdit')->id],'method'=>'POST', 'files' => true])}}

                        <!-- Photo + name -->
                        <div class="row-col h-auto m-b-1">
                            <div class="col-sm-3">
                                <div class="avatar w-64 inline">
                                    @if(Session::get('ContactToEdit')->photo !="")
                                        <img id="photo_preview" src="{{ asset('uploads/contacts/' . Session::get('ContactToEdit')->photo) }}">
                                    @else
                                        <img id="photo_preview" src="{{ asset('uploads/contacts/profile.jpg') }}" style="opacity: 0.2">
                                    @endif
                                </div>
                                <div class="form-file inline">
                                    <input id="photo_file" type="file" name="file" accept="image/*">
                                    <button class="btn white btn-sm"><small>{{ __('backend.selectFile') }} ..</small></button>
                                </div>
                            </div>
                            <div class="col-sm-9 v-m h2 _300">
                                <div class="p-l-xs">
                                    {!! Form::text('first_name',Session::get('ContactToEdit')->first_name, array('placeholder' =>__('backend.firstName'),'class' => 'form-control w-sm inline','id'=>'first_name','required'=>'')) !!}
                                    {!! Form::text('last_name',Session::get('ContactToEdit')->last_name, array('placeholder' =>__('backend.lastName'),'class' => 'form-control w-sm inline','id'=>'last_name')) !!}
                                </div>
                            </div>
                        </div>

                        <!-- fields -->
                        <div class="form-horizontal">
                            <!-- Phone -->
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">{{ __('backend.contactPhone') }}</label>
                                <div class="col-sm-6">
                                    {!! Form::text('phone',Session::get('ContactToEdit')->phone,['class'=>'form-control']) !!}
                                </div>
                                @if(Session::get('ContactToEdit')->phone !="")
                                    <div class="col-sm-3">
                                        <a href="tel:{{Session::get('ContactToEdit')->phone}}" class="btn white pull-right" style="width: 100%">
                                            <small><i class="material-icons">&#xe0b1;</i> {{ __('backend.callNow') }}</small>
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <!-- Email -->
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">{{ __('backend.contactEmail') }}</label>
                                <div class="col-sm-6">
                                    {!! Form::email('email',Session::get('ContactToEdit')->email,['class'=>'form-control','required']) !!}
                                </div>
                                <div class="col-sm-3">
                                    <a href="{{ route("webmails",["group_id"=>"create","stat"=>"email","wid"=>'new',"contact_email"=>Session::get('ContactToEdit')->email]) }}" class="btn white pull-right" style="width: 100%">
                                        <small><i class="material-icons">&#xe151;</i> {{ __('backend.sendEmail') }}</small>
                                    </a>
                                </div>
                            </div>

                            <!-- NID No -->
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">NID No</label>
                                <div class="col-sm-9">
                                    {!! Form::text('nid_no',Session::get('ContactToEdit')->nid_no,['class'=>'form-control','maxlength'=>17,'oninput'=>"this.value=this.value.replace(/[^0-9]/g,'')"]) !!}
                                </div>
                            </div>

                            <!-- NID Front Preview -->
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">NID Front Pic</label>
                                <div class="col-sm-3">
                                    <div class="avatar w-64 inline text-center">
                                        @if(Session::get('ContactToEdit')->nid_front)
                                            <a href="{{ asset('uploads/contacts/'.Session::get('ContactToEdit')->nid_front) }}" 
                                            download 
                                            title="Download NID Front">
                                                <img id="nid_front_preview" 
                                                    src="{{ asset('uploads/contacts/'.Session::get('ContactToEdit')->nid_front) }}" 
                                                    class="img-thumbnail" 
                                                    style="max-width: 120px;">
                                            </a>
                                            <br>
                                        @else
                                            <img id="nid_front_preview" 
                                                src="{{ asset('uploads/contacts/profile.jpg') }}" 
                                                style="opacity:0.2; max-width:120px;" 
                                                class="img-thumbnail">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <input id="nid_front" type="file" name="nid_front" accept="image/*">
                                </div>
                            </div>

                            <!-- NID Back Preview -->
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">NID Back Pic</label>
                                <div class="col-sm-3">
                                    <div class="avatar w-64 inline text-center">
                                        @if(Session::get('ContactToEdit')->nid_back)
                                            <a href="{{ asset('uploads/contacts/'.Session::get('ContactToEdit')->nid_back) }}" 
                                            download 
                                            title="Download NID Back">
                                                <img id="nid_back_preview" 
                                                    src="{{ asset('uploads/contacts/'.Session::get('ContactToEdit')->nid_back) }}" 
                                                    class="img-thumbnail" 
                                                    style="max-width: 120px;">
                                            </a>
                                            <br>
                                        @else
                                            <img id="nid_back_preview" 
                                                src="{{ asset('uploads/contacts/profile.jpg') }}" 
                                                style="opacity:0.2; max-width:120px;" 
                                                class="img-thumbnail">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <input id="nid_back" type="file" name="nid_back" accept="image/*">
                                </div>
                            </div>

                            <!-- Passport -->
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">Passport No</label>
                                <div class="col-sm-9">
                                    {!! Form::text('passport_no',Session::get('ContactToEdit')->passport_no,['class'=>'form-control','maxlength'=>9]) !!}
                                </div>
                            </div>

                            <!-- Birth Certificate -->
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">Birth Certificate No</label>
                                <div class="col-sm-9">
                                    {!! Form::text('birth_certificate_no',Session::get('ContactToEdit')->birth_certificate_no,['class'=>'form-control','maxlength'=>17,'oninput'=>"this.value=this.value.replace(/[^0-9]/g,'')"]) !!}
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">{{ __('backend.notes') }}</label>
                                <div class="col-sm-9">
                                    {!! Form::textarea('notes',Session::get('ContactToEdit')->notes,['class'=>'form-control','rows'=>2]) !!}
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">{{ __('backend.status') }}</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label class="ui-check ui-check-md">
                                            {!! Form::radio('status','1',(Session::get('ContactToEdit')->status==1),['class'=>'has-value']) !!}
                                            <i class="dark-white"></i> {{ __('backend.active') }}
                                        </label>
                                        &nbsp;
                                        <label class="ui-check ui-check-md">
                                            {!! Form::radio('status','0',(Session::get('ContactToEdit')->status==0),['class'=>'has-value']) !!}
                                            <i class="dark-white"></i> {{ __('backend.waitActivation') }}
                                        </label>
                                        &nbsp;
                                        <label class="ui-check ui-check-md">
                                            {!! Form::radio('status','2',(Session::get('ContactToEdit')->status==2),['class'=>'has-value']) !!}
                                            <i class="dark-white"></i> {{ __('backend.notActive') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-9">

                                    @if(@Auth::user()->permissionsGroup->delete_status)
                                        <button class="btn warning pull-right" data-toggle="modal" data-target="#mc-{{ Session::get('ContactToEdit')->id }}">
                                            <small><i class="material-icons">&#xe872;</i> {{ __('backend.deleteContacts') }}</small>
                                        </button>
                                    @endif

                                    <!-- Delete modal -->
                                    <div id="mc-{{ Session::get('ContactToEdit')->id }}" class="modal fade" data-backdrop="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ __('backend.confirmation') }}</h5>
                                                </div>
                                                <div class="modal-body text-center p-lg">
                                                    <p>
                                                        {{ __('backend.confirmationDeleteMsg') }}<br>
                                                        <strong>[ {{ Session::get('ContactToEdit')->first_name }} {{ Session::get('ContactToEdit')->last_name }} ]</strong>
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">{{ __('backend.no') }}</button>
                                                    <a href="{{ route("contactsDestroy",["id"=>Session::get('ContactToEdit')->id]) }}" class="btn danger p-x-md">{{ __('backend.yes') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- / Delete modal -->

                                    <button type="submit" class="btn btn-primary">
                                        <i class="material-icons">&#xe31b;</i> {!! __('backend.save') !!}
                                    </button>
                                </div>
                            </div>

                        </div>
                        <!-- / fields -->

                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /column -->