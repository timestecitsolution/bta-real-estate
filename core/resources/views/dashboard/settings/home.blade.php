
<div class="tab-pane {{  ( Session::get('active_tab') == 'homeTab') ? 'active' : '' }}"
     id="tab-8">
     <div class="p-a-md"><h5><i class="material-icons">&#xe0ba;</i>
            &nbsp; {!!  __('backend.home') !!} Page</h5></div>

        <!-- home -->
        <div class="p-a-md"><h4><i class="material-icons">&#xe0ba;</i>
            &nbsp; {!!  __('backend.home') !!}</h4>
        </div>
        <div class="p-a-md col-md-12">
        
            <div class="form-group">
                <label>{!!  __('backend.bannerTitle') !!}</label>
                {!! Form::text('banner_title',$Setting->banner_title, array('placeholder' => __('backend.bannerTitle'),'class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <div class="form-group">
                <label>{!!  __('backend.bannerHeading') !!}</label>
                {!! Form::text('banner_heading',$Setting->banner_heading, array('placeholder' => __('backend.bannerHeading'),'class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <div class="form-group">
                <label>{!!  __('backend.bannerDescription') !!}</label>
                {!! Form::text('banner_description',$Setting->banner_description, array('placeholder' => __('backend.bannerDescription'),'class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <div class="form-group">
                <label>{!!  __('backend.bannerButtonLink') !!}</label>
                {!! Form::text('banner_button_link',$Setting->banner_button_link, array('placeholder' => __('backend.bannerButtonLink'),'class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <label>{{ __('backend.bannerImage') }} : </label>
                <div class="row">
                    <div class="col-sm-6">
                        @if($Setting->banner_image!="")
                            <div>
                                <div>
                                    <div id="footer_bg" class="col-sm-8 box p-a-xs">
                                        <a target="_blank"
                                           href="{{ asset('uploads/settings/'.$Setting->banner_image) }}"><img
                                                src="{{ asset('uploads/settings/'.$Setting->banner_image) }}"
                                                class="img-responsive">
                                            {{ $Setting->banner_image }}
                                        </a>
                                        <br>
                                        <a onclick="document.getElementById('footer_bg').style.display='none';document.getElementById('photo_delete_bi').value='1';document.getElementById('undo').style.display='block';"
                                           class="btn btn-sm btn-default">{!!  __('backend.delete') !!}</a>
                                    </div>
                                    <div id="undo" class="col-sm-4 p-a-xs" style="display: none">
                                        <a onclick="document.getElementById('footer_bg').style.display='block';document.getElementById('photo_delete_bi').value='0';document.getElementById('undo').style.display='none';">
                                            <i class="material-icons">
                                                &#xe166;</i> {!!  __('backend.undoDelete') !!}</a>
                                    </div>

                                    {!! Form::hidden('photo_delete_bi','0', array('id'=>'photo_delete_bi')) !!}
                                </div>
                            </div>

                        @endif
                        {!! Form::file('banner_image', array('class' => 'form-control','id'=>'banner_image','accept'=>'image/*')) !!}
                        <small>
                            <i class="material-icons">&#xe8fd;</i>
                            {!!  __('backend.imagesTypes') !!}
                        </small>
                    </div>
                </div>
        </div>
        <!-- home -->

        <!-- about -->

        <div class="p-a-md"><h4><i class="material-icons">&#xe0ba;</i>
            &nbsp; {!!  __('backend.about_us') !!}</h4></div>
        <div class="p-a-md col-md-12">
        
            <div class="form-group">
                <label>{!!  __('backend.about_usTitle') !!}</label>
                {!! Form::text('about_us_title',$Setting->about_us_title, array('placeholder' => __('backend.about_usTitle'),'class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <div class="form-group">
                <label>{!!  __('backend.about_usHeading') !!}</label>
                

                @foreach(Helper::languagesList() as $ActiveLanguage)
                                @if($ActiveLanguage->box_status)
                                    
                                        
                                        
                                        
                                            @if (Helper::GeneralWebmasterSettings("text_editor") == 2)
                                                <div>
                                                    {!! Form::textarea('about_us_heading',$Setting->about_us_heading, array('placeholder' => '','class' => 'form-control ckeditor', 'dir'=>@$ActiveLanguage->direction)) !!}
                                                </div>
                                            @elseif (Helper::GeneralWebmasterSettings("text_editor") == 1)
                                                <div>
                                                    {!! Form::textarea('about_us_heading',$Setting->about_us_heading, array('placeholder' => '','class' => 'form-control tinymce', 'dir'=>@$ActiveLanguage->direction)) !!}
                                                </div>
                                            @else
                                                <div class="box p-a-xs">
                                                    {!! Form::textarea('about_us_heading',$Setting->about_us_heading, array('ui-jp'=>'summernote','placeholder' => '','class' => 'form-control summernote_'.@$ActiveLanguage->code, 'dir'=>@$ActiveLanguage->direction,'ui-options'=>'{height: 300,callbacks: {
                                                        onImageUpload: function(files, editor, welEditable) {
                                                            sendFile(files[0], editor, welEditable,"'.@$ActiveLanguage->code.'");
                                                        }
                                                    }}')) !!}
                                                </div>
                                            @endif
                                        
                                   
                                @endif
                    @endforeach 
            </div>

            <div class="form-group">
                <label>{!!  __('backend.about_usDescription') !!}</label>
                
                    @foreach(Helper::languagesList() as $ActiveLanguage)
                                @if($ActiveLanguage->box_status)
                                    
                                        
                                        
                                        
                                            @if (Helper::GeneralWebmasterSettings("text_editor") == 2)
                                                <div>
                                                    {!! Form::textarea('about_us_description',$Setting->about_us_description, array('placeholder' => '','class' => 'form-control ckeditor', 'dir'=>@$ActiveLanguage->direction)) !!}
                                                </div>
                                            @elseif (Helper::GeneralWebmasterSettings("text_editor") == 1)
                                                <div>
                                                    {!! Form::textarea('about_us_description',$Setting->about_us_description, array('placeholder' => '','class' => 'form-control tinymce', 'dir'=>@$ActiveLanguage->direction)) !!}
                                                </div>
                                            @else
                                                <div class="box p-a-xs">
                                                    {!! Form::textarea('about_us_description',$Setting->about_us_description, array('ui-jp'=>'summernote','placeholder' => '','class' => 'form-control summernote_'.@$ActiveLanguage->code, 'dir'=>@$ActiveLanguage->direction,'ui-options'=>'{height: 300,callbacks: {
                                                        onImageUpload: function(files, editor, welEditable) {
                                                            sendFile(files[0], editor, welEditable,"'.@$ActiveLanguage->code.'");
                                                        }
                                                    }}')) !!}
                                                </div>
                                            @endif
                                        
                                   
                                @endif
                    @endforeach         
            </div>

            <div class="form-group">
                <label>{!!  __('backend.about_usButtonLink') !!}</label>
                {!! Form::text('about_us_button_link',$Setting->about_us_button_link, array('placeholder' => __('backend.about_usButtonLink'),'class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <label>{{ __('backend.about_usImage') }} : </label>
                <div class="row">
                    <div class="col-sm-6">
                        @if($Setting->about_us_image!="")
                            <div>
                                <div>
                                    <div id="footer_bg" class="col-sm-8 box p-a-xs">
                                        <a target="_blank"
                                           href="{{ asset('uploads/settings/'.$Setting->about_us_image) }}"><img
                                                src="{{ asset('uploads/settings/'.$Setting->about_us_image) }}"
                                                class="img-responsive">
                                            {{ $Setting->about_us_image }}
                                        </a>
                                        <br>
                                        <a onclick="document.getElementById('footer_bg').style.display='none';document.getElementById('photo_delete_bi').value='1';document.getElementById('undo').style.display='block';"
                                           class="btn btn-sm btn-default">{!!  __('backend.delete') !!}</a>
                                    </div>
                                    <div id="undo" class="col-sm-4 p-a-xs" style="display: none">
                                        <a onclick="document.getElementById('footer_bg').style.display='block';document.getElementById('photo_delete_bi').value='0';document.getElementById('undo').style.display='none';">
                                            <i class="material-icons">
                                                &#xe166;</i> {!!  __('backend.undoDelete') !!}</a>
                                    </div>

                                    {!! Form::hidden('photo_delete_bi','0', array('id'=>'photo_delete_bi')) !!}
                                </div>
                            </div>

                        @endif
                        {!! Form::file('about_us_image', array('class' => 'form-control','id'=>'about_us_image','accept'=>'image/*')) !!}
                        <small>
                            <i class="material-icons">&#xe8fd;</i>
                            {!!  __('backend.imagesTypes') !!}
                        </small>
                    </div>
                </div>
        </div>
        <!-- about -->

        <!-- arvhitecture -->
        <div class="p-a-md"><h4><i class="material-icons">&#xe0ba;</i>
            &nbsp; {!!  __('backend.architecture') !!}</h4>
        </div>
        <div class="p-a-md col-md-12">
        
            <!-- 1 -->
            <div class="form-group">
                <label>{!!  __('backend.architectureTitle1') !!}</label>
                {!! Form::text('architecture_title1',$Setting->architecture_title1, array('placeholder' => __('backend.architectureTitle1'),'class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <div class="form-group">
                <label>{!!  __('backend.architectureHeading1') !!}</label>
                {!! Form::text('architecture_heading1',$Setting->architecture_heading1, array('placeholder' => __('backend.architectureHeading1'),'class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            

            <label>{{ __('backend.architectureIcon1') }} : </label>
                    <div class="row">
                        <div class="col-sm-6">
                            @if($Setting->architecture_icon1!="")
                                <div>
                                    <div>
                                        <div id="footer_bg" class="col-sm-8 box p-a-xs">
                                            <a target="_blank"
                                               href="{{ asset('uploads/settings/'.$Setting->architecture_icon1) }}"><img
                                                    src="{{ asset('uploads/settings/'.$Setting->architecture_icon1) }}"
                                                    class="img-responsive">
                                                {{ $Setting->architecture_icon1 }}
                                            </a>
                                            <br>
                                            <a onclick="document.getElementById('footer_bg').style.display='none';document.getElementById('photo_delete_ai1').value='1';document.getElementById('undo').style.display='block';"
                                               class="btn btn-sm btn-default">{!!  __('backend.delete') !!}</a>
                                        </div>
                                        <div id="undo" class="col-sm-4 p-a-xs" style="display: none">
                                            <a onclick="document.getElementById('footer_bg').style.display='block';document.getElementById('photo_delete_ai1').value='0';document.getElementById('undo').style.display='none';">
                                                <i class="material-icons">
                                                    &#xe166;</i> {!!  __('backend.undoDelete') !!}</a>
                                        </div>

                                        {!! Form::hidden('photo_delete_ai1','0', array('id'=>'photo_delete_ai1')) !!}
                                    </div>
                                </div>

                            @endif
                            {!! Form::file('architecture_icon1', array('class' => 'form-control','id'=>'architecture_icon1','accept'=>'image/*')) !!}
                            <small>
                                <i class="material-icons">&#xe8fd;</i>
                                {!!  __('backend.imagesTypes') !!}
                            </small>
                        </div>
                    </div>
            <!-- 1 -->


            <!-- 2 -->
            <div class="form-group">
                <label>{!!  __('backend.architectureTitle2') !!}</label>
                {!! Form::text('architecture_title2',$Setting->architecture_title2, array('placeholder' => __('backend.architectureTitle2'),'class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <div class="form-group">
                <label>{!!  __('backend.architectureHeading2') !!}</label>
                {!! Form::text('architecture_heading2',$Setting->architecture_heading2, array('placeholder' => __('backend.architectureHeading2'),'class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <label>{{ __('backend.architectureIcon2') }} : </label>
                    <div class="row">
                        <div class="col-sm-6">
                            @if($Setting->architecture_icon2!="")
                                <div>
                                    <div>
                                        <div id="footer_bg" class="col-sm-8 box p-a-xs">
                                            <a target="_blank"
                                               href="{{ asset('uploads/settings/'.$Setting->architecture_icon2) }}"><img
                                                    src="{{ asset('uploads/settings/'.$Setting->architecture_icon2) }}"
                                                    class="img-responsive">
                                                {{ $Setting->architecture_icon2 }}
                                            </a>
                                            <br>
                                            <a onclick="document.getElementById('footer_bg').style.display='none';document.getElementById('photo_delete_ai2').value='1';document.getElementById('undo').style.display='block';"
                                               class="btn btn-sm btn-default">{!!  __('backend.delete') !!}</a>
                                        </div>
                                        <div id="undo" class="col-sm-4 p-a-xs" style="display: none">
                                            <a onclick="document.getElementById('footer_bg').style.display='block';document.getElementById('photo_delete_ai2').value='0';document.getElementById('undo').style.display='none';">
                                                <i class="material-icons">
                                                    &#xe166;</i> {!!  __('backend.undoDelete') !!}</a>
                                        </div>

                                        {!! Form::hidden('photo_delete_ai2','0', array('id'=>'photo_delete_ai2')) !!}
                                    </div>
                                </div>

                            @endif
                            {!! Form::file('architecture_icon2', array('class' => 'form-control','id'=>'architecture_icon2','accept'=>'image/*')) !!}
                            <small>
                                <i class="material-icons">&#xe8fd;</i>
                                {!!  __('backend.imagesTypes') !!}
                            </small>
                        </div>
                    </div>
            <!-- 2 -->

            <!-- 3 -->
            <div class="form-group">
                <label>{!!  __('backend.architectureTitle3') !!}</label>
                {!! Form::text('architecture_title3',$Setting->architecture_title3, array('placeholder' => __('backend.architectureTitle3'),'class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <div class="form-group">
                <label>{!!  __('backend.architectureHeading3') !!}</label>
                {!! Form::text('architecture_heading3',$Setting->architecture_heading3, array('placeholder' => __('backend.architectureHeading3'),'class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <label>{{ __('backend.architectureIcon3') }} : </label>
                    <div class="row">
                        <div class="col-sm-6">
                            @if($Setting->architecture_icon3!="")
                                <div>
                                    <div>
                                        <div id="footer_bg" class="col-sm-8 box p-a-xs">
                                            <a target="_blank"
                                               href="{{ asset('uploads/settings/'.$Setting->architecture_icon3) }}"><img
                                                    src="{{ asset('uploads/settings/'.$Setting->architecture_icon3) }}"
                                                    class="img-responsive">
                                                {{ $Setting->architecture_icon3 }}
                                            </a>
                                            <br>
                                            <a onclick="document.getElementById('footer_bg').style.display='none';document.getElementById('photo_delete_ai3').value='1';document.getElementById('undo').style.display='block';"
                                               class="btn btn-sm btn-default">{!!  __('backend.delete') !!}</a>
                                        </div>
                                        <div id="undo" class="col-sm-4 p-a-xs" style="display: none">
                                            <a onclick="document.getElementById('footer_bg').style.display='block';document.getElementById('photo_delete_ai3').value='0';document.getElementById('undo').style.display='none';">
                                                <i class="material-icons">
                                                    &#xe166;</i> {!!  __('backend.undoDelete') !!}</a>
                                        </div>

                                        {!! Form::hidden('photo_delete_ai3','0', array('id'=>'photo_delete_ai3')) !!}
                                    </div>
                                </div>

                            @endif
                            {!! Form::file('architecture_icon3', array('class' => 'form-control','id'=>'architecture_icon3','accept'=>'image/*')) !!}
                            <small>
                                <i class="material-icons">&#xe8fd;</i>
                                {!!  __('backend.imagesTypes') !!}
                            </small>
                        </div>
                    </div>
            <!-- 3 -->

            <!-- 4 -->
            <div class="form-group">
                <label>{!!  __('backend.architectureTitle4') !!}</label>
                {!! Form::text('architecture_title4',$Setting->architecture_title4, array('placeholder' => __('backend.architectureTitle4'),'class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <div class="form-group">
                <label>{!!  __('backend.architectureHeading4') !!}</label>
                {!! Form::text('architecture_heading4',$Setting->architecture_heading4, array('placeholder' => __('backend.architectureHeading4'),'class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <label>{{ __('backend.architectureIcon4') }} : </label>
                    <div class="row">
                        <div class="col-sm-6">
                            @if($Setting->architecture_icon4!="")
                                <div>
                                    <div>
                                        <div id="footer_bg" class="col-sm-8 box p-a-xs">
                                            <a target="_blank"
                                               href="{{ asset('uploads/settings/'.$Setting->architecture_icon4) }}"><img
                                                    src="{{ asset('uploads/settings/'.$Setting->architecture_icon4) }}"
                                                    class="img-responsive">
                                                {{ $Setting->architecture_icon4 }}
                                            </a>
                                            <br>
                                            <a onclick="document.getElementById('footer_bg').style.display='none';document.getElementById('photo_delete_ai4').value='1';document.getElementById('undo').style.display='block';"
                                               class="btn btn-sm btn-default">{!!  __('backend.delete') !!}</a>
                                        </div>
                                        <div id="undo" class="col-sm-4 p-a-xs" style="display: none">
                                            <a onclick="document.getElementById('footer_bg').style.display='block';document.getElementById('photo_delete_ai4').value='0';document.getElementById('undo').style.display='none';">
                                                <i class="material-icons">
                                                    &#xe166;</i> {!!  __('backend.undoDelete') !!}</a>
                                        </div>

                                        {!! Form::hidden('photo_delete_ai4','0', array('id'=>'photo_delete_ai4')) !!}
                                    </div>
                                </div>

                            @endif
                            {!! Form::file('architecture_icon4', array('class' => 'form-control','id'=>'architecture_icon4','accept'=>'image/*')) !!}
                            <small>
                                <i class="material-icons">&#xe8fd;</i>
                                {!!  __('backend.imagesTypes') !!}
                            </small>
                        </div>
                    </div>
            <!-- 4 -->
        </div>
        <!-- arvhitecture -->


        <!-- Why choose us -->

        <div class="p-a-md"><h4><i class="material-icons">&#xe0ba;</i>
            &nbsp; {!!  __('backend.why_choose_us') !!}</h4></div>
        <div class="p-a-md col-md-12">
        
            <div class="form-group">
                <label>{!!  __('backend.why_choose_usTitle') !!}</label>
                {!! Form::text('why_choose_us_title',$Setting->why_choose_us_title, array('placeholder' => __('backend.why_choose_usTitle'),'class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <div class="form-group">
                <label>{!!  __('backend.why_choose_usHeading') !!}</label>
                

                @foreach(Helper::languagesList() as $ActiveLanguage)
                                @if($ActiveLanguage->box_status)
                                    
                                        
                                            @if (Helper::GeneralWebmasterSettings("text_editor") == 2)
                                                <div>
                                                    {!! Form::textarea('why_choose_us_heading',$Setting->why_choose_us_heading, array('placeholder' => '','class' => 'form-control ckeditor', 'dir'=>@$ActiveLanguage->direction)) !!}
                                                </div>
                                            @elseif (Helper::GeneralWebmasterSettings("text_editor") == 1)
                                                <div>
                                                    {!! Form::textarea('why_choose_us_heading',$Setting->why_choose_us_heading, array('placeholder' => '','class' => 'form-control tinymce', 'dir'=>@$ActiveLanguage->direction)) !!}
                                                </div>
                                            @else
                                                <div class="box p-a-xs">
                                                    {!! Form::textarea('why_choose_us_heading',$Setting->why_choose_us_heading, array('ui-jp'=>'summernote','placeholder' => '','class' => 'form-control summernote_'.@$ActiveLanguage->code, 'dir'=>@$ActiveLanguage->direction,'ui-options'=>'{height: 300,callbacks: {
                                                        onImageUpload: function(files, editor, welEditable) {
                                                            sendFile(files[0], editor, welEditable,"'.@$ActiveLanguage->code.'");
                                                        }
                                                    }}')) !!}
                                                </div>
                                            @endif
                                        
                                   
                                @endif
                    @endforeach 
            </div>

            <div class="form-group">
                <label>{!!  __('backend.why_choose_usDescription') !!}</label>
                
                    @foreach(Helper::languagesList() as $ActiveLanguage)
                                @if($ActiveLanguage->box_status)
                                    
                                        
                                        
                                            @if (Helper::GeneralWebmasterSettings("text_editor") == 2)
                                                <div>
                                                    {!! Form::textarea('why_choose_us_description',$Setting->why_choose_us_description, array('placeholder' => '','class' => 'form-control ckeditor', 'dir'=>@$ActiveLanguage->direction)) !!}
                                                </div>
                                            @elseif (Helper::GeneralWebmasterSettings("text_editor") == 1)
                                                <div>
                                                    {!! Form::textarea('why_choose_us_description',$Setting->why_choose_us_description, array('placeholder' => '','class' => 'form-control tinymce', 'dir'=>@$ActiveLanguage->direction)) !!}
                                                </div>
                                            @else
                                                <div class="box p-a-xs">
                                                    {!! Form::textarea('why_choose_us_description',$Setting->why_choose_us_description, array('ui-jp'=>'summernote','placeholder' => '','class' => 'form-control summernote_'.@$ActiveLanguage->code, 'dir'=>@$ActiveLanguage->direction,'ui-options'=>'{height: 300,callbacks: {
                                                        onImageUpload: function(files, editor, welEditable) {
                                                            sendFile(files[0], editor, welEditable,"'.@$ActiveLanguage->code.'");
                                                        }
                                                    }}')) !!}
                                                </div>
                                            @endif
                                        
                                   
                                @endif
                    @endforeach         
            </div>

            <div class="form-group">
                <label>{!!  __('backend.experience_years') !!}</label>
                {!! Form::text('experience_years',$Setting->experience_years, array('placeholder' => __('backend.experience_years'),'class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>
            <div class="form-group">
                <label>{!!  __('backend.experience_yearsTitle') !!}</label>
                {!! Form::text('experience_years_title',$Setting->experience_years_title, array('placeholder' => __('backend.experience_yearsTitle'),'class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>
            <div class="form-group">
                <label>{!!  __('backend.successful_projects') !!}</label>
                {!! Form::text('successful_projects',$Setting->successful_projects, array('placeholder' => __('backend.successful_projects'),'class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>
            <div class="form-group">
                <label>{!!  __('backend.successful_projectsTitle') !!}</label>
                {!! Form::text('successful_projects_title',$Setting->successful_projects_title, array('placeholder' => __('backend.successful_projectsTitle'),'class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>
            <div class="form-group">
                <label>{!!  __('backend.expertTitle') !!}</label>
                {!! Form::text('expert_title',$Setting->expert_title, array('placeholder' => __('backend.expertTitle'),'class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>
            <div class="form-group">
                <label>{!!  __('backend.investmentTitle') !!}</label>
                {!! Form::text('investment_title',$Setting->investment_title, array('placeholder' => __('backend.investmentTitle'),'class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <div class="form-group">
                <label>{!!  __('backend.why_choose_usButtonLink') !!}</label>
                {!! Form::text('why_choose_us_button_link',$Setting->why_choose_us_button_link, array('placeholder' => __('backend.why_choose_usButtonLink'),'class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <label>{{ __('backend.why_choose_usImage') }} : </label>
                <div class="row">
                    <div class="col-sm-6">
                        @if($Setting->why_choose_us_image!="")
                            <div>
                                <div>
                                    <div id="footer_bg" class="col-sm-8 box p-a-xs">
                                        <a target="_blank"
                                           href="{{ asset('uploads/settings/'.$Setting->why_choose_us_image) }}"><img
                                                src="{{ asset('uploads/settings/'.$Setting->why_choose_us_image) }}"
                                                class="img-responsive">
                                            {{ $Setting->why_choose_us_image }}
                                        </a>
                                        <br>
                                        <a onclick="document.getElementById('footer_bg').style.display='none';document.getElementById('photo_delete_wcu').value='1';document.getElementById('undo').style.display='block';"
                                           class="btn btn-sm btn-default">{!!  __('backend.delete') !!}</a>
                                    </div>
                                    <div id="undo" class="col-sm-4 p-a-xs" style="display: none">
                                        <a onclick="document.getElementById('footer_bg').style.display='block';document.getElementById('photo_delete_wcu').value='0';document.getElementById('undo').style.display='none';">
                                            <i class="material-icons">
                                                &#xe166;</i> {!!  __('backend.undoDelete') !!}</a>
                                    </div>

                                    {!! Form::hidden('photo_delete_wcu','0', array('id'=>'photo_delete_wcu')) !!}
                                </div>
                            </div>

                        @endif
                        {!! Form::file('why_choose_us_image', array('class' => 'form-control','id'=>'why_choose_us_image','accept'=>'image/*')) !!}
                        <small>
                            <i class="material-icons">&#xe8fd;</i>
                            {!!  __('backend.imagesTypes') !!}
                        </small>
                    </div>
                </div>
        </div>
        <!-- Why choose us -->


        <!-- home -->
        <div class="p-a-md"><h4><i class="material-icons">&#xe0ba;</i>
            &nbsp; Land Query</h4>
        </div>
        <div class="p-a-md col-md-12">
        
            <div class="form-group">
                <label>Land Query Mail</label>
                {!! Form::text('land_query_mail',$Setting->land_query_mail, array('placeholder' => 'Land Query Mail','class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            
        </div>
        <!-- home -->



</div>
