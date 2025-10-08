
<div class="tab-pane {{  ( Session::get('active_tab') == 'aboutTab') ? 'active' : '' }}"
     id="tab-9">
     <div class="p-a-md"><h5><i class="material-icons">&#xe0ba;</i>
            &nbsp; About Page</h5></div>

       

        <!-- who we are -->

        <div class="p-a-md"><h4><i class="material-icons">&#xe0ba;</i>
            &nbsp; {!!  __('backend.about_us') !!}</h4></div>
        <div class="p-a-md col-md-12">
        
            <div class="form-group">
                <label>{!!  __('backend.about_usTitle') !!}</label>
                {!! Form::text('about_us_title9',$Setting->about_us_title9, array('placeholder' => __('backend.about_usTitle'),'class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <div class="form-group">
                <label>{!!  __('backend.about_usHeading') !!}</label>
                

                @foreach(Helper::languagesList() as $ActiveLanguage)
                                @if($ActiveLanguage->box_status)
                                    
                                       
                                        
                                            @if (Helper::GeneralWebmasterSettings("text_editor") == 2)
                                                <div>
                                                    {!! Form::textarea('about_us_heading9',$Setting->about_us_heading9, array('placeholder' => '','class' => 'form-control ckeditor', 'dir'=>@$ActiveLanguage->direction)) !!}
                                                </div>
                                            @elseif (Helper::GeneralWebmasterSettings("text_editor") == 1)
                                                <div>
                                                    {!! Form::textarea('about_us_heading9',$Setting->about_us_heading9, array('placeholder' => '','class' => 'form-control tinymce', 'dir'=>@$ActiveLanguage->direction)) !!}
                                                </div>
                                            @else
                                                <div class="box p-a-xs">
                                                    {!! Form::textarea('about_us_heading9',$Setting->about_us_heading9, array('ui-jp'=>'summernote','placeholder' => '','class' => 'form-control summernote_'.@$ActiveLanguage->code, 'dir'=>@$ActiveLanguage->direction,'ui-options'=>'{height: 300,callbacks: {
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
                                                    {!! Form::textarea('about_us_description9',$Setting->about_us_description9, array('placeholder' => '','class' => 'form-control ckeditor', 'dir'=>@$ActiveLanguage->direction)) !!}
                                                </div>
                                            @elseif (Helper::GeneralWebmasterSettings("text_editor") == 1)
                                                <div>
                                                    {!! Form::textarea('about_us_description9',$Setting->about_us_description9, array('placeholder' => '','class' => 'form-control tinymce', 'dir'=>@$ActiveLanguage->direction)) !!}
                                                </div>
                                            @else
                                                <div class="box p-a-xs">
                                                    {!! Form::textarea('about_us_description9',$Setting->about_us_description9, array('ui-jp'=>'summernote','placeholder' => '','class' => 'form-control summernote_'.@$ActiveLanguage->code, 'dir'=>@$ActiveLanguage->direction,'ui-options'=>'{height: 300,callbacks: {
                                                        onImageUpload: function(files, editor, welEditable) {
                                                            sendFile(files[0], editor, welEditable,"'.@$ActiveLanguage->code.'");
                                                        }
                                                    }}')) !!}
                                                </div>
                                            @endif
                                        
                                   
                                @endif
                    @endforeach         
            </div>

            

            <label>{{ __('backend.about_usImage') }} : </label>
                <div class="row">
                    <div class="col-sm-6">
                        @if($Setting->about_us_image9!="")
                            <div>
                                <div>
                                    <div id="footer_bg" class="col-sm-8 box p-a-xs">
                                        <a target="_blank"
                                           href="{{ asset('uploads/settings/'.$Setting->about_us_image9) }}"><img
                                                src="{{ asset('uploads/settings/'.$Setting->about_us_image9) }}"
                                                class="img-responsive">
                                            {{ $Setting->about_us_image9 }}
                                        </a>
                                        <br>
                                        <a onclick="document.getElementById('footer_bg').style.display='none';document.getElementById('photo_delete_bi9').value='1';document.getElementById('undo').style.display='block';"
                                           class="btn btn-sm btn-default">{!!  __('backend.delete') !!}</a>
                                    </div>
                                    <div id="undo" class="col-sm-4 p-a-xs" style="display: none">
                                        <a onclick="document.getElementById('footer_bg').style.display='block';document.getElementById('photo_delete_bi9').value='0';document.getElementById('undo').style.display='none';">
                                            <i class="material-icons">
                                                &#xe166;</i> {!!  __('backend.undoDelete') !!}</a>
                                    </div>

                                    {!! Form::hidden('photo_delete_bi9','0', array('id'=>'photo_delete_bi9')) !!}
                                </div>
                            </div>

                        @endif
                        {!! Form::file('about_us_image9', array('class' => 'form-control','id'=>'about_us_image9','accept'=>'image/*')) !!}
                        <small>
                            <i class="material-icons">&#xe8fd;</i>
                            {!!  __('backend.imagesTypes') !!}
                        </small>
                    </div>
                </div>
        </div>
        <!-- who we are -->

        <!-- Why choose us -->
        <div class="p-a-md"><h4><i class="material-icons">&#xe0ba;</i>
            &nbsp; Why Choose US</h4>
        </div>
        <div class="p-a-md col-md-12">
        
            <!-- 1 -->
            <div class="form-group">
                <label>Why Choose Title 1 </label>
                {!! Form::text('architecture_title19',$Setting->architecture_title19, array('placeholder' => 'Choose Title 1','class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>



            <label>Icon 1 : </label>
                    <div class="row">
                        <div class="col-sm-6">
                            @if($Setting->architecture_icon19!="")
                                <div>
                                    <div>
                                        <div id="footer_bg" class="col-sm-8 box p-a-xs">
                                            <a target="_blank"
                                               href="{{ asset('uploads/settings/'.$Setting->architecture_icon19) }}"><img
                                                    src="{{ asset('uploads/settings/'.$Setting->architecture_icon19) }}"
                                                    class="img-responsive">
                                                {{ $Setting->architecture_icon19 }}
                                            </a>
                                            <br>
                                            <a onclick="document.getElementById('footer_bg').style.display='none';document.getElementById('photo_delete_ai19').value='1';document.getElementById('undo').style.display='block';"
                                               class="btn btn-sm btn-default">{!!  __('backend.delete') !!}</a>
                                        </div>
                                        <div id="undo" class="col-sm-4 p-a-xs" style="display: none">
                                            <a onclick="document.getElementById('footer_bg').style.display='block';document.getElementById('photo_delete_ai19').value='0';document.getElementById('undo').style.display='none';">
                                                <i class="material-icons">
                                                    &#xe166;</i> {!!  __('backend.undoDelete') !!}</a>
                                        </div>

                                        {!! Form::hidden('photo_delete_ai19','0', array('id'=>'photo_delete_ai19')) !!}
                                    </div>
                                </div>

                            @endif
                            {!! Form::file('architecture_icon19', array('class' => 'form-control','id'=>'architecture_icon19','accept'=>'image/*')) !!}
                            <small>
                                <i class="material-icons">&#xe8fd;</i>
                                {!!  __('backend.imagesTypes') !!}
                            </small>
                        </div>
                    </div>
            <!-- 1 -->


            <!-- 2 -->
            <div class="form-group">
                <label> Why Choose Title 2 </label>
                {!! Form::text('architecture_title29',$Setting->architecture_title29, array('placeholder' => 'Why Choose Title 2','class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            

            <label>Icon 2 : </label>
                    <div class="row">
                        <div class="col-sm-6">
                            @if($Setting->architecture_icon29!="")
                                <div>
                                    <div>
                                        <div id="footer_bg" class="col-sm-8 box p-a-xs">
                                            <a target="_blank"
                                               href="{{ asset('uploads/settings/'.$Setting->architecture_icon29) }}"><img
                                                    src="{{ asset('uploads/settings/'.$Setting->architecture_icon29) }}"
                                                    class="img-responsive">
                                                {{ $Setting->architecture_icon29 }}
                                            </a>
                                            <br>
                                            <a onclick="document.getElementById('footer_bg').style.display='none';document.getElementById('photo_delete_ai29').value='1';document.getElementById('undo').style.display='block';"
                                               class="btn btn-sm btn-default">{!!  __('backend.delete') !!}</a>
                                        </div>
                                        <div id="undo" class="col-sm-4 p-a-xs" style="display: none">
                                            <a onclick="document.getElementById('footer_bg').style.display='block';document.getElementById('photo_delete_ai29').value='0';document.getElementById('undo').style.display='none';">
                                                <i class="material-icons">
                                                    &#xe166;</i> {!!  __('backend.undoDelete') !!}</a>
                                        </div>

                                        {!! Form::hidden('photo_delete_ai29','0', array('id'=>'photo_delete_ai29')) !!}
                                    </div>
                                </div>

                            @endif
                            {!! Form::file('architecture_icon29', array('class' => 'form-control','id'=>'architecture_icon29','accept'=>'image/*')) !!}
                            <small>
                                <i class="material-icons">&#xe8fd;</i>
                                {!!  __('backend.imagesTypes') !!}
                            </small>
                        </div>
                    </div>
            <!-- 2 -->

            <!-- 3 -->
            <div class="form-group">
                <label> Why Choose Title 3 </label>
                {!! Form::text('architecture_title39',$Setting->architecture_title39, array('placeholder' => 'Why Choose Title 3','class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <label>Icon 3 : </label>
                    <div class="row">
                        <div class="col-sm-6">
                            @if($Setting->architecture_icon39!="")
                                <div>
                                    <div>
                                        <div id="footer_bg" class="col-sm-8 box p-a-xs">
                                            <a target="_blank"
                                               href="{{ asset('uploads/settings/'.$Setting->architecture_icon39) }}"><img
                                                    src="{{ asset('uploads/settings/'.$Setting->architecture_icon39) }}"
                                                    class="img-responsive">
                                                {{ $Setting->architecture_icon39 }}
                                            </a>
                                            <br>
                                            <a onclick="document.getElementById('footer_bg').style.display='none';document.getElementById('photo_delete_ai39').value='1';document.getElementById('undo').style.display='block';"
                                               class="btn btn-sm btn-default">{!!  __('backend.delete') !!}</a>
                                        </div>
                                        <div id="undo" class="col-sm-4 p-a-xs" style="display: none">
                                            <a onclick="document.getElementById('footer_bg').style.display='block';document.getElementById('photo_delete_ai39').value='0';document.getElementById('undo').style.display='none';">
                                                <i class="material-icons">
                                                    &#xe166;</i> {!!  __('backend.undoDelete') !!}</a>
                                        </div>

                                        {!! Form::hidden('photo_delete_ai39','0', array('id'=>'photo_delete_ai39')) !!}
                                    </div>
                                </div>

                            @endif
                            {!! Form::file('architecture_icon39', array('class' => 'form-control','id'=>'architecture_icon39','accept'=>'image/*')) !!}
                            <small>
                                <i class="material-icons">&#xe8fd;</i>
                                {!!  __('backend.imagesTypes') !!}
                            </small>
                        </div>
                    </div>
            <!-- 3 -->

            <!-- 4 -->
            <div class="form-group">
                <label> Why Choose Title 4 </label>
                {!! Form::text('architecture_title49',$Setting->architecture_title49, array('placeholder' => 'Why Choose Title 4','class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <label>Icon 4 : </label>
                    <div class="row">
                        <div class="col-sm-6">
                            @if($Setting->architecture_icon49!="")
                                <div>
                                    <div>
                                        <div id="footer_bg" class="col-sm-8 box p-a-xs">
                                            <a target="_blank"
                                               href="{{ asset('uploads/settings/'.$Setting->architecture_icon49) }}"><img
                                                    src="{{ asset('uploads/settings/'.$Setting->architecture_icon49) }}"
                                                    class="img-responsive">
                                                {{ $Setting->architecture_icon49 }}
                                            </a>
                                            <br>
                                            <a onclick="document.getElementById('footer_bg').style.display='none';document.getElementById('photo_delete_ai49').value='1';document.getElementById('undo').style.display='block';"
                                               class="btn btn-sm btn-default">{!!  __('backend.delete') !!}</a>
                                        </div>
                                        <div id="undo" class="col-sm-4 p-a-xs" style="display: none">
                                            <a onclick="document.getElementById('footer_bg').style.display='block';document.getElementById('photo_delete_ai49').value='0';document.getElementById('undo').style.display='none';">
                                                <i class="material-icons">
                                                    &#xe166;</i> {!!  __('backend.undoDelete') !!}</a>
                                        </div>

                                        {!! Form::hidden('photo_delete_ai49','0', array('id'=>'photo_delete_ai49')) !!}
                                    </div>
                                </div>

                            @endif
                            {!! Form::file('architecture_icon49', array('class' => 'form-control','id'=>'architecture_icon49','accept'=>'image/*')) !!}
                            <small>
                                <i class="material-icons">&#xe8fd;</i>
                                {!!  __('backend.imagesTypes') !!}
                            </small>
                        </div>
                    </div>
            <!-- 4 -->
        <!-- Why choose us -->



        <!-- arvhitecture -->
        <div class="p-a-md"><h4><i class="material-icons">&#xe0ba;</i>
            &nbsp; Comprehensive Solutions</h4>
        </div>
        <div class="p-a-md col-md-12">
        
            <!-- 1 -->
            <div class="form-group">
                <label>  Title 1 </label>
                {!! Form::text('architecture_title17',$Setting->architecture_title17, array('placeholder' => 'Title 1','class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <div class="form-group">
                <label>  Description 1 </label>
                {!! Form::text('architecture_heading17',$Setting->architecture_heading17, array('placeholder' => 'Description 1','class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            

            <label>Image 1 : </label>
                    <div class="row">
                        <div class="col-sm-6">
                            @if($Setting->architecture_icon17!="")
                                <div>
                                    <div>
                                        <div id="footer_bg" class="col-sm-8 box p-a-xs">
                                            <a target="_blank"
                                               href="{{ asset('uploads/settings/'.$Setting->architecture_icon17) }}"><img
                                                    src="{{ asset('uploads/settings/'.$Setting->architecture_icon17) }}"
                                                    class="img-responsive">
                                                {{ $Setting->architecture_icon17 }}
                                            </a>
                                            <br>
                                            <a onclick="document.getElementById('footer_bg').style.display='none';document.getElementById('photo_delete_ai17').value='1';document.getElementById('undo').style.display='block';"
                                               class="btn btn-sm btn-default">{!!  __('backend.delete') !!}</a>
                                        </div>
                                        <div id="undo" class="col-sm-4 p-a-xs" style="display: none">
                                            <a onclick="document.getElementById('footer_bg').style.display='block';document.getElementById('photo_delete_ai17').value='0';document.getElementById('undo').style.display='none';">
                                                <i class="material-icons">
                                                    &#xe166;</i> {!!  __('backend.undoDelete') !!}</a>
                                        </div>

                                        {!! Form::hidden('photo_delete_ai17','0', array('id'=>'photo_delete_ai17')) !!}
                                    </div>
                                </div>

                            @endif
                            {!! Form::file('architecture_icon17', array('class' => 'form-control','id'=>'architecture_icon17','accept'=>'image/*')) !!}
                            <small>
                                <i class="material-icons">&#xe8fd;</i>
                                {!!  __('backend.imagesTypes') !!}
                            </small>
                        </div>
                    </div>
            <!-- 1 -->


            <!-- 2 -->
            <div class="form-group">
                <label>Title 2 </label>
                {!! Form::text('architecture_title27',$Setting->architecture_title27, array('placeholder' => 'Title 2','class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <div class="form-group">
                <label>Description 2 </label>
                {!! Form::text('architecture_heading27',$Setting->architecture_heading27, array('placeholder' => 'Description 2','class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <label>Image 2 : </label>
                    <div class="row">
                        <div class="col-sm-6">
                            @if($Setting->architecture_icon27!="")
                                <div>
                                    <div>
                                        <div id="footer_bg" class="col-sm-8 box p-a-xs">
                                            <a target="_blank"
                                               href="{{ asset('uploads/settings/'.$Setting->architecture_icon27) }}"><img
                                                    src="{{ asset('uploads/settings/'.$Setting->architecture_icon27) }}"
                                                    class="img-responsive">
                                                {{ $Setting->architecture_icon27 }}
                                            </a>
                                            <br>
                                            <a onclick="document.getElementById('footer_bg').style.display='none';document.getElementById('photo_delete_ai27').value='1';document.getElementById('undo').style.display='block';"
                                               class="btn btn-sm btn-default">{!!  __('backend.delete') !!}</a>
                                        </div>
                                        <div id="undo" class="col-sm-4 p-a-xs" style="display: none">
                                            <a onclick="document.getElementById('footer_bg').style.display='block';document.getElementById('photo_delete_ai27').value='0';document.getElementById('undo').style.display='none';">
                                                <i class="material-icons">
                                                    &#xe166;</i> {!!  __('backend.undoDelete') !!}</a>
                                        </div>

                                        {!! Form::hidden('photo_delete_ai27','0', array('id'=>'photo_delete_ai27')) !!}
                                    </div>
                                </div>

                            @endif
                            {!! Form::file('architecture_icon27', array('class' => 'form-control','id'=>'architecture_icon27','accept'=>'image/*')) !!}
                            <small>
                                <i class="material-icons">&#xe8fd;</i>
                                {!!  __('backend.imagesTypes') !!}
                            </small>
                        </div>
                    </div>
            <!-- 2 -->

            <!-- 3 -->
            <div class="form-group">
                <label>Title 3</label>
                {!! Form::text('architecture_title37',$Setting->architecture_title37, array('placeholder' =>'Title 3','class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <div class="form-group">
                <label>Description 3</label>
                {!! Form::text('architecture_heading37',$Setting->architecture_heading37, array('placeholder' => 'Description 3','class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <label>Image 3  : </label>
                    <div class="row">
                        <div class="col-sm-6">
                            @if($Setting->architecture_icon37!="")
                                <div>
                                    <div>
                                        <div id="footer_bg" class="col-sm-8 box p-a-xs">
                                            <a target="_blank"
                                               href="{{ asset('uploads/settings/'.$Setting->architecture_icon37) }}"><img
                                                    src="{{ asset('uploads/settings/'.$Setting->architecture_icon37) }}"
                                                    class="img-responsive">
                                                {{ $Setting->architecture_icon37 }}
                                            </a>
                                            <br>
                                            <a onclick="document.getElementById('footer_bg').style.display='none';document.getElementById('photo_delete_ai37').value='1';document.getElementById('undo').style.display='block';"
                                               class="btn btn-sm btn-default">{!!  __('backend.delete') !!}</a>
                                        </div>
                                        <div id="undo" class="col-sm-4 p-a-xs" style="display: none">
                                            <a onclick="document.getElementById('footer_bg').style.display='block';document.getElementById('photo_delete_ai37').value='0';document.getElementById('undo').style.display='none';">
                                                <i class="material-icons">
                                                    &#xe166;</i> {!!  __('backend.undoDelete') !!}</a>
                                        </div>

                                        {!! Form::hidden('photo_delete_ai37','0', array('id'=>'photo_delete_ai37')) !!}
                                    </div>
                                </div>

                            @endif
                            {!! Form::file('architecture_icon37', array('class' => 'form-control','id'=>'architecture_icon37','accept'=>'image/*')) !!}
                            <small>
                                <i class="material-icons">&#xe8fd;</i>
                                {!!  __('backend.imagesTypes') !!}
                            </small>
                        </div>
                    </div>
            <!-- 3 -->

            <!-- 4 -->
            <div class="form-group">
                <label>Title 4</label>
                {!! Form::text('architecture_title47',$Setting->architecture_title47, array('placeholder' => 'Title 4','class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <div class="form-group">
                <label>Description 4</label>
                {!! Form::text('architecture_heading47',$Setting->architecture_heading47, array('placeholder' => 'Description 4','class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <label>Image 4: </label>
                    <div class="row">
                        <div class="col-sm-6">
                            @if($Setting->architecture_icon47!="")
                                <div>
                                    <div>
                                        <div id="footer_bg" class="col-sm-8 box p-a-xs">
                                            <a target="_blank"
                                               href="{{ asset('uploads/settings/'.$Setting->architecture_icon47) }}"><img
                                                    src="{{ asset('uploads/settings/'.$Setting->architecture_icon47) }}"
                                                    class="img-responsive">
                                                {{ $Setting->architecture_icon47 }}
                                            </a>
                                            <br>
                                            <a onclick="document.getElementById('footer_bg').style.display='none';document.getElementById('photo_delete_ai47').value='1';document.getElementById('undo').style.display='block';"
                                               class="btn btn-sm btn-default">{!!  __('backend.delete') !!}</a>
                                        </div>
                                        <div id="undo" class="col-sm-4 p-a-xs" style="display: none">
                                            <a onclick="document.getElementById('footer_bg').style.display='block';document.getElementById('photo_delete_ai47').value='0';document.getElementById('undo').style.display='none';">
                                                <i class="material-icons">
                                                    &#xe166;</i> {!!  __('backend.undoDelete') !!}</a>
                                        </div>

                                        {!! Form::hidden('photo_delete_ai47','0', array('id'=>'photo_delete_ai47')) !!}
                                    </div>
                                </div>

                            @endif
                            {!! Form::file('architecture_icon47', array('class' => 'form-control','id'=>'architecture_icon47','accept'=>'image/*')) !!}
                            <small>
                                <i class="material-icons">&#xe8fd;</i>
                                {!!  __('backend.imagesTypes') !!}
                            </small>
                        </div>
                    </div>
            <!-- 4 -->


            <!-- 5 -->
            <div class="form-group">
                <label>Title 5 </label>
                {!! Form::text('architecture_title57',$Setting->architecture_title57, array('placeholder' => 'Title 5','class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <div class="form-group">
                <label>Description 5</label>
                {!! Form::text('architecture_heading57',$Setting->architecture_heading57, array('placeholder' => 'Description 5','class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <label>Image 5: </label>
                    <div class="row">
                        <div class="col-sm-6">
                            @if($Setting->architecture_icon57!="")
                                <div>
                                    <div>
                                        <div id="footer_bg" class="col-sm-8 box p-a-xs">
                                            <a target="_blank"
                                               href="{{ asset('uploads/settings/'.$Setting->architecture_icon57) }}"><img
                                                    src="{{ asset('uploads/settings/'.$Setting->architecture_icon57) }}"
                                                    class="img-responsive">
                                                {{ $Setting->architecture_icon57 }}
                                            </a>
                                            <br>
                                            <a onclick="document.getElementById('footer_bg').style.display='none';document.getElementById('photo_delete_ai57').value='1';document.getElementById('undo').style.display='block';"
                                               class="btn btn-sm btn-default">{!!  __('backend.delete') !!}</a>
                                        </div>
                                        <div id="undo" class="col-sm-5 p-a-xs" style="display: none">
                                            <a onclick="document.getElementById('footer_bg').style.display='block';document.getElementById('photo_delete_ai57').value='0';document.getElementById('undo').style.display='none';">
                                                <i class="material-icons">
                                                    &#xe166;</i> {!!  __('backend.undoDelete') !!}</a>
                                        </div>

                                        {!! Form::hidden('photo_delete_ai57','0', array('id'=>'photo_delete_ai57')) !!}
                                    </div>
                                </div>

                            @endif
                            {!! Form::file('architecture_icon57', array('class' => 'form-control','id'=>'architecture_icon57','accept'=>'image/*')) !!}
                            <small>
                                <i class="material-icons">&#xe8fd;</i>
                                {!!  __('backend.imagesTypes') !!}
                            </small>
                        </div>
                    </div>
            <!-- 5 -->


            <!-- 6 -->
            <div class="form-group">
                <label>Title 6</label>
                {!! Form::text('architecture_title67',$Setting->architecture_title67, array('placeholder' => 'Title 6','class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <div class="form-group">
                <label>Description 6</label>
                {!! Form::text('architecture_heading67',$Setting->architecture_heading67, array('placeholder' => 'Description 6','class' => 'form-control', 'dir'=>'ltr')) !!}
            </div>

            <label>Image 6 : </label>
                    <div class="row">
                        <div class="col-sm-6">
                            @if($Setting->architecture_icon67!="")
                                <div>
                                    <div>
                                        <div id="footer_bg" class="col-sm-8 box p-a-xs">
                                            <a target="_blank"
                                               href="{{ asset('uploads/settings/'.$Setting->architecture_icon67) }}"><img
                                                    src="{{ asset('uploads/settings/'.$Setting->architecture_icon67) }}"
                                                    class="img-responsive">
                                                {{ $Setting->architecture_icon67 }}
                                            </a>
                                            <br>
                                            <a onclick="document.getElementById('footer_bg').style.display='none';document.getElementById('photo_delete_ai67').value='1';document.getElementById('undo').style.display='block';"
                                               class="btn btn-sm btn-default">{!!  __('backend.delete') !!}</a>
                                        </div>
                                        <div id="undo" class="col-sm-6 p-a-xs" style="display: none">
                                            <a onclick="document.getElementById('footer_bg').style.display='block';document.getElementById('photo_delete_ai67').value='0';document.getElementById('undo').style.display='none';">
                                                <i class="material-icons">
                                                    &#xe166;</i> {!!  __('backend.undoDelete') !!}</a>
                                        </div>

                                        {!! Form::hidden('photo_delete_ai67','0', array('id'=>'photo_delete_ai67')) !!}
                                    </div>
                                </div>

                            @endif
                            {!! Form::file('architecture_icon67', array('class' => 'form-control','id'=>'architecture_icon67','accept'=>'image/*')) !!}
                            <small>
                                <i class="material-icons">&#xe8fd;</i>
                                {!!  __('backend.imagesTypes') !!}
                            </small>
                        </div>
                    </div>
            <!-- 6 -->
        </div>
        <!-- arvhitecture -->


       
    </div>


</div>
