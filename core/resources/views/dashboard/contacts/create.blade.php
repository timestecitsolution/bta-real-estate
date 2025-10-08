
<!-- column -->
<div class="col-sm-6 col-md-7">
    <div class="row-col">
        <div class="p-a-sm">
            <h6 class="m-b-0 m-t-sm"><i class="material-icons">
                    &#xe02e;</i> {{ __('backend.newContacts') }}
            </h6>
        </div>
        <div class="row-row">
            <div class="row-body">
                <div class="row-inner">
                    <div class="padding p-y-sm ">
                        {{Form::open(['route'=>['contactsStore'],'method'=>'POST', 'files' => true ])}}
                        <div class="row-col h-auto m-b-1">
                            <div class="col-sm-3">
                                <div class="avatar w-64 inline">
                                    <img id="photo_preview"
                                         src="{{ asset('uploads/contacts/profile.jpg') }}"
                                         style="opacity: 0.2">
                                </div>
                                <div class="form-file inline">
                                    <input id="photo_file" type="file" name="file" accept="image/*">
                                    <button class="btn white btn-sm">
                                        <small>
                                            <small>{{ __('backend.selectFile') }} ..</small>
                                        </small>
                                    </button>
                                </div>
                            </div>
                            <div class="col-sm-9 v-m h2 _300">
                                <div class="p-l-xs">
                                    {!! Form::text('first_name','', array('placeholder' =>__('backend.firstName'),'class' => 'form-control w-sm inline','id'=>'first_name','required'=>'')) !!}
                                    {!! Form::text('last_name','', array('placeholder' =>__('backend.lastName'),'class' => 'form-control w-sm inline','id'=>'last_name')) !!}
                                </div>
                            </div>
                        </div>
                        <!-- fields -->
                        <div class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">{{ __('backend.contactPhone') }}</label>
                                <div class="col-sm-9">
                                    {!! Form::text('phone','', array('placeholder' =>'','class' => 'form-control','id'=>'phone','required'=>'required')) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">{{ __('backend.contactEmail') }}</label>
                                <div class="col-sm-9">
                                    {!! Form::email('email','', array('placeholder' =>'','class' => 'form-control','id'=>'email','required'=>'required')) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">NID No(10 to 17 Digits)</label>
                                <div class="col-sm-9">
                                    {!! Form::number('nid_no','', array('placeholder' =>'','class' => 'form-control','id'=>'nid_no')) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="nid_front">NID Front</label>
                                    <div class="avatar w-64 inline">
                                        <img id="nid_front_preview"
                                            src="{{ asset('uploads/contacts/profile.jpg') }}"
                                            style="opacity:0.2">
                                    </div>
                                    <div class="form-file inline">
                                        <input id="nid_front" type="file" name="nid_front" accept="image/*">
                                        <button class="btn white btn-sm">
                                            <small><small>{{ __('backend.selectFile') }} ..</small></small>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <label for="nid_back">NID Back</label>
                                    <div class="avatar w-64 inline">
                                        <img id="nid_back_preview"
                                            src="{{ asset('uploads/contacts/profile.jpg') }}"
                                            style="opacity:0.2">
                                    </div>
                                    <div class="form-file inline">
                                        <input id="nid_back" type="file" name="nid_back" accept="image/*">
                                        <button class="btn white btn-sm">
                                            <small><small>{{ __('backend.selectFile') }} ..</small></small>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">Passport No (Max 9 Digits)</label>
                                <div class="col-sm-9">
                                    {!! Form::text('passport_no','', [
                                        'placeholder' => 'Passport No (Max 9 Digits)',
                                        'class' => 'form-control',
                                        'id' => 'passport_no',
                                        'maxlength' => 9,
                                    ]) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">Birth Certificate No (Max 17 Digits)</label>
                                <div class="col-sm-9">
                                    {!! Form::text('birth_certificate_no','', [
                                        'placeholder' => '',
                                        'class' => 'form-control',
                                        'id' => 'birth_certificate_no',
                                        'maxlength' => 17,
                                        'oninput' => "this.value = this.value.replace(/[^0-9]/g, '')"
                                    ]) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">{{ __('backend.notes') }}</label>
                                <div class="col-sm-9">
                                    {!! Form::textarea('notes','', array('placeholder' => '','class' => 'form-control','rows'=>'2')) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-primary"><i
                                            class="material-icons">
                                            &#xe31b;</i> {!! __('backend.add') !!}</button>
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
