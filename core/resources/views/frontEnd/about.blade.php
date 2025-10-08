@extends('frontEnd.layouts.master')

@section('content')
   
        <?php
        $title_var = "title_" . @Helper::currentLanguage()->code;
        $title_var2 = "title_" . config('smartend.default_language');
        $details_var = "details_" . @Helper::currentLanguage()->code;
        $details_var2 = "details_" . config('smartend.default_language');
        if ($Topic->$title_var != "") {
            $title = $Topic->$title_var;
        } else {
            $title = $Topic->$title_var2;
        }
        if ($Topic->$details_var != "") {
            $details = $details_var;
        } else {
            $details = $details_var2;
        }
        $section = "";
        try {
            if ($Topic->section->$title_var != "") {
                $section = $Topic->section->$title_var;
            } else {
                $section = $Topic->section->$title_var2;
            }
        } catch (Exception $e) {
            $section = "";
        }
        ?>

        <section class="home-about">
            <div class="container">
              <div class="home-about-content">
                <div class="row align-items-center">
                  <div class="col-lg-5">
                    <img src="{{ URL::to('uploads/settings/'.Helper::GeneralSiteSettings("about_us_image9")) }}" alt="" width="100%">
                  </div>
                  <div class="col-lg-7 py-3">
                    <div class="p-2 p-lg-5">
                      <h6>{!! Helper::GeneralSiteSettings("about_us_title9") !!}</h6>
                      <h1>{!! Helper::GeneralSiteSettings("about_us_heading9") !!}</h1>
                      <p>
                        {!! Helper::GeneralSiteSettings("about_us_description9") !!}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </section>

          <section class="why-choose-us">
            <div class="container">
              <div class="title-two mb-5">
                <h1>Why Choose Us</h1>
              </div>
              <div class="row">
                <div class="col-lg-3">
                  <div class="why-choose-single">
                    <img src="{{ URL::to('uploads/settings/'.Helper::GeneralSiteSettings("architecture_icon19")) }}" alt="">
                    <h3>{!! Helper::GeneralSiteSettings("architecture_title19") !!}</h3>
                  </div>
                </div>
                <div class="col-lg-3">
                  <div class="why-choose-single">
                    <img src="{{ URL::to('uploads/settings/'.Helper::GeneralSiteSettings("architecture_icon29")) }}" alt="">
                    <h3>{!! Helper::GeneralSiteSettings("architecture_title29") !!}</h3>
                  </div>
                </div>
                <div class="col-lg-3">
                  <div class="why-choose-single">
                    <img src="{{ URL::to('uploads/settings/'.Helper::GeneralSiteSettings("architecture_icon39")) }}" alt="">
                    <h3>{!! Helper::GeneralSiteSettings("architecture_title39") !!}</h3>
                  </div>
                </div>
                <div class="col-lg-3">
                  <div class="why-choose-single">
                    <img src="{{ URL::to('uploads/settings/'.Helper::GeneralSiteSettings("architecture_icon49")) }}" alt="">
                    <h3>{!! Helper::GeneralSiteSettings("architecture_title49") !!}</h3>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <section class="we-speacializes">
            <div class="container">
              <div class="title-two mb-5">
                <h1>We are specializes in providing<br> comprehensive solutions</h1>
              </div>
              <div class="speacialize-single">
                <div class="row align-items-center">
                  <div class="col-lg-7">
                    <h6>01</h6>
                    <h3>{!! Helper::GeneralSiteSettings("architecture_title17") !!}</h3>
                    <p>{!! Helper::GeneralSiteSettings("architecture_heading17") !!}</p>
                  </div>
                  <div class="col-lg-5">
                    <img src="{{ URL::to('uploads/settings/'.Helper::GeneralSiteSettings("architecture_icon17")) }}" alt="" width="">
                  </div>
                </div>
              </div>
              <div class="speacialize-single">
                <div class="row align-items-center">
                  <div class="col-lg-5">
                    <img src="{{ URL::to('uploads/settings/'.Helper::GeneralSiteSettings("architecture_icon27")) }}" alt="">
                  </div>
                  <div class="col-lg-7">
                    <h6>02</h6>
                    <h3>{!! Helper::GeneralSiteSettings("architecture_title27") !!}</h3>
                    <p>{!! Helper::GeneralSiteSettings("architecture_heading27") !!}</p>
                  </div>
                </div>
              </div>
              <div class="speacialize-single">
                <div class="row align-items-center">
                  <div class="col-lg-7">
                    <h6>03</h6>
                    <h3>{!! Helper::GeneralSiteSettings("architecture_title37") !!}</h3>
                    <p>{!! Helper::GeneralSiteSettings("architecture_heading37") !!}</p>
                  </div>
                  <div class="col-lg-5">
                    <img src="{{ URL::to('uploads/settings/'.Helper::GeneralSiteSettings("architecture_icon37")) }}" alt="" width="">
                  </div>
                </div>
              </div>
              <div class="speacialize-single">
                <div class="row align-items-center">
                  <div class="col-lg-5">
                    <img src="{{ URL::to('uploads/settings/'.Helper::GeneralSiteSettings("architecture_icon47")) }}" alt="">
                  </div>
                  <div class="col-lg-7">
                    <h6>04</h6>
                    <h3>{!! Helper::GeneralSiteSettings("architecture_title47") !!}</h3>
                    <p>{!! Helper::GeneralSiteSettings("architecture_heading47") !!}</p>
                  </div>
                </div>
              </div>
              <div class="speacialize-single">
                <div class="row align-items-center">
                  <div class="col-lg-7">
                    <h6>05</h6>
                    <h3>{!! Helper::GeneralSiteSettings("architecture_title57") !!}</h3>
                    <p>{!! Helper::GeneralSiteSettings("architecture_heading57") !!}</p>
                  </div>
                  <div class="col-lg-5">
                    <img src="{{ URL::to('uploads/settings/'.Helper::GeneralSiteSettings("architecture_icon57")) }}" alt="" width="">
                  </div>
                </div>
              </div>
              <div class="speacialize-single">
                <div class="row align-items-center">
                  <div class="col-lg-5">
                    <img src="{{ URL::to('uploads/settings/'.Helper::GeneralSiteSettings("architecture_icon67")) }}" alt="">
                  </div>
                  <div class="col-lg-7">
                    <h6>06</h6>
                    <h3>{!! Helper::GeneralSiteSettings("architecture_title67") !!}</h3>
                    <p>{!! Helper::GeneralSiteSettings("architecture_heading67") !!}</p>
                  </div>
                </div>
              </div>
            </div>
          </section>
        
   
    @include('frontEnd.layouts.popup',['Popup'=>@$Popup])
@endsection


