<!-- Header -->
  <header class="text-white">
    <div>
      <nav id="mainNavbar" class="navbar navbar-expand-lg navbar-light">
        <div class="container d-flex justify-content-between align-items-center">
          <a class="navbar-brand d-none d-lg-block" href="{{ Helper::homeURL() }}">
            @if(Helper::GeneralSiteSettings("style_logo_" . @Helper::currentLanguage()->code) !="")
                
                <img src="{{ URL::to('uploads/settings/'.Helper::GeneralSiteSettings("style_logo_" . @Helper::currentLanguage()->code)) }}" alt="Desktop Logo">
            @else
                <img alt="{{ Helper::GeneralSiteSettings("site_title_" . @Helper::currentLanguage()->code) }}" src="{{ URL::to('uploads/settings/nologo.png') }}"  class="img-fluid"  width="172" height="50">
            @endif


            
          </a>
          <a class="navbar-brand d-block d-lg-none" href="#">
            <img src="{{ URL::asset('assets/frontend_new/assets/images/logo-sm.svg') }}" alt="Mobile Logo">
          </a>

          

          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          
          @include('frontEnd.layouts.menu')

        </div>
      </nav>
    </div>


@php
    $slug = Request::segment(1); 
@endphp

    @if(empty($slug))
      <!-- Hero Section -->
        <section class="hero-banner">
          <div class="container">
            <div class="hero-banner-content ps-0 ps-lg-5">
              <div class="row align-items-center">
                <div class="col-md-6">
                  <h6>{!! Helper::GeneralSiteSettings("banner_title") !!}</h6>
                  <h1>{!! Helper::GeneralSiteSettings("banner_heading") !!}</h1>
                  <p>{!! Helper::GeneralSiteSettings("banner_description") !!}</p>

                  <a href='/.{!! Helper::GeneralSiteSettings("banner_button_link") !!}' class="btn btn-primary">
                    Explore Our Projects <i class="fa-solid fa-arrow-up-right-from-square"></i>
                  </a>
                </div>

                <!-- Hidden on mobile/tablet, visible only on large (≥992px) and up -->
                <div class="col-md-6 text-center d-none d-lg-block">
                  <img src="{{ URL::to('uploads/settings/'.Helper::GeneralSiteSettings("banner_image")) }}" class="img-fluid" alt="Building">
                </div>
              </div>
            </div>
          </div>

          <div class="shape1 d-none d-lg-block">
            <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/2.png') }}" alt="">
          </div>
          <div class="shape3 d-none d-lg-block">
            <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/3.png') }}" alt="">
          </div>
          <div class="shape4 d-none d-lg-block">
            <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/4.png') }}" alt="">
          </div>
          <div class="shape5 d-none d-lg-block">
            <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/5.png') }}" alt="">
          </div>
        </section>
        <div class="shape2 d-none d-lg-block">
          <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/1.svg') }}" alt="">
        </div>
    @elseif($slug == 'projects')

      <!-- Hero Section -->
        <section class="hero-banner">
          <div class="container">
            <div class="innerheader ps-0 ps-lg-5">
              <h6>Our projects</h6>
              <h1>Our Real Estate Projects<br> Across Bangladesh</h1>
            </div>
          </div>

          <div class="shape1 d-none d-lg-block">
            <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/2.svg') }}" alt="">
          </div>
          <div class="shape3 d-none d-lg-block">
            <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/3.svg') }}" alt="">
          </div>
          <div class="shape4 d-none d-lg-block">
            <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/4.svg') }}" alt="">
          </div>
          <div class="shape5 d-none d-lg-block">
            <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/5.svg') }}" alt="">
          </div>
        </section>
        <div class="shape2 d-none d-lg-block">
          <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/1.svg') }}" alt="">
        </div>
    @elseif($slug == 'details')
   
      <!-- Hero Section -->
        <section class="project-banner">
          <div class="container">
            <img style="display:none;" src="{{ URL::to('uploads/topics/'.$page_data['photo_file_banner']) }}" alt="" width="100%">
            <h1 class="project_details">{{$page_data->title_en}}</h1>
          </div>
      </section>
    @elseif($slug == 'book')
          <!-- Hero Section -->
        <section class="hero-banner">
          <div class="container">
            <div class="innerheader ps-0 ps-lg-5">  
              <h6>{{ $PageTitle }}</h6>
              <h1>Ready To Get Started?</h1>
            </div>
          </div>

          <div class="shape1 d-none d-lg-block">
            <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/2.svg') }}" alt="">
          </div>
          <div class="shape3 d-none d-lg-block">
            <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/3.svg') }}" alt="">
          </div>
          <div class="shape4 d-none d-lg-block">
            <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/4.svg') }}" alt="">
          </div>
          <div class="shape5 d-none d-lg-block">
            <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/5.svg') }}" alt="">
          </div>
        </section>
        <div class="shape2 d-none d-lg-block">
          <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/1.svg') }}" alt="">
        </div>
    @elseif($slug == 'change-password')
      <!-- Hero Section -->
    <section class="hero-banner">
      <div class="container">
        <div class="innerheader ps-0 ps-lg-5">  
          <h6>Change Your Old Password First</h6>
        </div>
      </div>

      <div class="shape1 d-none d-lg-block">
        <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/2.svg') }}" alt="">
      </div>
      <div class="shape3 d-none d-lg-block">
        <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/3.svg') }}" alt="">
      </div>
      <div class="shape4 d-none d-lg-block">
        <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/4.svg') }}" alt="">
      </div>
      <div class="shape5 d-none d-lg-block">
        <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/5.svg') }}" alt="">
      </div>
    </section>
    <div class="shape2 d-none d-lg-block">
      <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/1.svg') }}" alt="">
    </div>
    @elseif($slug == 'dashboard-new')
          <!-- Hero Section -->
        <section class="hero-banner">
          <div class="container">
            <div class="innerheader ps-0 ps-lg-5">
              <h6>{!! Helper::GeneralSiteSettings("banner_title") !!}</h6>
              <h1>User Dashboard</h1>
              <a href="/book" class="btn btn-primary">
                    Book Now <i class="fa-solid fa-arrow-up-right-from-square"></i>
                </a>
            </div>
          </div>

          <div class="shape1 d-none d-lg-block">
            <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/2.svg') }}" alt="">
          </div>
          <div class="shape3 d-none d-lg-block">
            <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/3.svg') }}" alt="">
          </div>
          <div class="shape4 d-none d-lg-block">
            <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/4.svg') }}" alt="">
          </div>
          <div class="shape5 d-none d-lg-block">
            <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/5.svg') }}" alt="">
          </div>
        </section>
        <div class="shape2 d-none d-lg-block">
          <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/1.svg') }}" alt="">
        </div>
    @elseif($slug == 'login-new')
    @else
          <!-- Hero Section -->
        <section class="hero-banner">
          <div class="container">
            <div class="innerheader ps-0 ps-lg-5">
              <h6>{!! Helper::GeneralSiteSettings("banner_title") !!}</h6>
              <h1>{{ $PageTitle }}</h1>
              <a href="/book" class="btn btn-primary">
                    Book Now <i class="fa-solid fa-arrow-up-right-from-square"></i>
                  </a>
            </div>
          </div>

          <div class="shape1 d-none d-lg-block">
            <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/2.svg') }}" alt="">
          </div>
          <div class="shape3 d-none d-lg-block">
            <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/3.svg') }}" alt="">
          </div>
          <div class="shape4 d-none d-lg-block">
            <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/4.svg') }}" alt="">
          </div>
          <div class="shape5 d-none d-lg-block">
            <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/5.svg') }}" alt="">
          </div>
        </section>
        <div class="shape2 d-none d-lg-block">
          <img src="{{ URL::asset('assets/frontend_new/assets/images/shape/1.svg') }}" alt="">
        </div>

    @endif

  </header>
