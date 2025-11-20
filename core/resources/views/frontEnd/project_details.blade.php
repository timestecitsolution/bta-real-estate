
@extends('frontEnd.layouts.master')

@section('content')

@php
    $commercialBrochure = $page_data->fields->where('field_id', 55)->first();
@endphp
  <section class="project-details-wrap py-5">
    <div class="container">
      <div class="project-info-top">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <h3>{{$page_data->title_en}}</h3>
            <p><i class="fa-solid fa-location-dot"></i>{{$page_data->address}}</p>
          </div>
          <div class="col-lg-3 text-end">
            <a href="{{ URL::to('uploads/topics/'.$page_data['attach_file']) }}" download class="btn btn-primary">
                Brochure (Residential)
            </a>
          </div>
          @if($commercialBrochure)
          <div class="col-lg-3 text-end">
                <a href="{{ URL::to('uploads/topics/'.$commercialBrochure->field_value) }}" download class="btn btn-primary">
                    Brochure (Commercial)
                </a>
          </div>
          @endif
        </div>
        <div class="row mt-5">
          <div class="col-lg-6">
            <h5>Project Overview</h5>
          </div>
          <div class="col-lg-6">
            <p>{{ strip_tags($page_data->details_en) }}</p>
            <a href="#" class="btn btn-primary btn-sm">{{Helper::category($page_data->categories[0]->section_id);}}</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="keyfeatures">
    <div class="container">
      <nav>
        <ul class="nav justify-content-center">
          <li class="nav-item"><a class="nav-link active" href="#features">Key Features</a></li>
          <li class="nav-item"><a class="nav-link" href="#construction">Construction Details</a></li>
          <li class="nav-item"><a class="nav-link" href="#gallery">Gallery</a></li>
          <li class="nav-item"><a class="nav-link" href="#locations">Location & Connectivity</a></li>
          <li class="nav-item"><a class="nav-link" href="#floorplan">Available Floor Plans</a></li>
          <li class="nav-item"><a class="nav-link" href="#walkthrough">Project Walkthrough</a></li>
        </ul>
      </nav>

      <div class="keyfeature-wrap" id="features">
        <h3>Key Features</h3>
        <div class="keyfeatures-wrapper">
          <div class="keyfeature-single">
            <img src="{{ URL::asset('assets/frontend_new/assets/images/icon/6.svg') }}" alt="Feature Icon">
            <p>{{Helper::TopicCustomField($page_data->fields,19)}}</p>
          </div>
          <div class="keyfeature-single">
            <img src="{{ URL::asset('assets/frontend_new/assets/images/icon/6.svg') }}" alt="Feature Icon">
            <p>{{Helper::TopicCustomField($page_data->fields,20)}}</p>
          </div>
          <div class="keyfeature-single">
            <img src="{{ URL::asset('assets/frontend_new/assets/images/icon/6.svg') }}" alt="Feature Icon">
            <p>{{Helper::TopicCustomField($page_data->fields,21)}}</p>
          </div>
          <div class="keyfeature-single">
            <img src="{{ URL::asset('assets/frontend_new/assets/images/icon/6.svg') }}" alt="Feature Icon">
            <p>{{Helper::TopicCustomField($page_data->fields,22)}}</p>
          </div>
          <div class="keyfeature-single">
            <img src="{{ URL::asset('assets/frontend_new/assets/images/icon/6.svg') }}" alt="Feature Icon">
            <p>{{Helper::TopicCustomField($page_data->fields,23)}}</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="construction-details" id="construction">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <h5>Project Overview </h5>
          <h3>Everything You Need to Know</h3>
          <p>{{Helper::TopicCustomField($page_data->fields,39)}}</p>
        </div>
        <div class="col-lg-8 ps-5">
          <h4>At a Glance</h4>
          <div class="table-responsive">
            <table>
            <tr>

              <td><img src="{{ URL::asset('assets/frontend_new/assets/images/icon/7.svg') }}" alt="Status Icon"> Project Status</td>
              <td>{{Helper::TopicCustomField($page_data->fields,24)}}</td>
            </tr>
            <tr>
              <td><img src="{{ URL::asset('assets/frontend_new/assets/images/icon/8.svg') }}" alt="Address Icon"> Project Address</td>
              <td>{{Helper::TopicCustomField($page_data->fields,25)}}</td>
            </tr>
            <tr>
              <td><img src="{{ URL::asset('assets/frontend_new/assets/images/icon/9.svg') }}" alt="Land Area Icon"> Land Area</td>
              <td>{{Helper::TopicCustomField($page_data->fields,26)}}</td>
            </tr>
            <tr>
              <td><img src="{{ URL::asset('assets/frontend_new/assets/images/icon/10.svg') }}" alt="Orientation Icon"> Land Orientation</td>
              <td>{{Helper::TopicCustomField($page_data->fields,27)}}</td>
            </tr>
            <tr>
              <td><img src="{{ URL::asset('assets/frontend_new/assets/images/icon/11.svg') }}" alt="Floors Icon"> Number of Floors</td>
              <td>{{Helper::TopicCustomField($page_data->fields,28)}}</td>
            </tr>
            <tr>
              <td><img src="{{ URL::asset('assets/frontend_new/assets/images/icon/12.svg') }}" alt="Apartments Icon"> Number of Apartments</td>
              <td>{{Helper::TopicCustomField($page_data->fields,29)}}</td>
            </tr>
            <tr>
              <td><img src="{{ URL::asset('assets/frontend_new/assets/images/icon/13.svg') }}" alt="Size Icon"> Unit Size Range</td>
              <td>{{Helper::TopicCustomField($page_data->fields,30)}}</td>
            </tr>
            <tr>
              <td><img src="{{ URL::asset('assets/frontend_new/assets/images/icon/14.svg') }}" alt="Basement Icon"> Basements</td>
              <td>{{Helper::TopicCustomField($page_data->fields,31)}}</td>
            </tr>
            <tr>
              <td><img src="{{ URL::asset('assets/frontend_new/assets/images/icon/15.svg') }}" alt="Parking Icon"> Car Parking</td>
              <td>{{Helper::TopicCustomField($page_data->fields,32)}}</td>
            </tr>
            <tr>
              <td><img src="{{ URL::asset('assets/frontend_new/assets/images/icon/16.svg') }}" alt="RAJUK Icon"> RAJUK Approval No.</td>
              <td>{{Helper::TopicCustomField($page_data->fields,33)}}</td>
            </tr>
          </table>
          </div>
          
          <h4>Construction & Engineering Details</h4>
          <div class="table-responsive">
          <table>
            <tr>
              <td><img src="{{ URL::asset('assets/frontend_new/assets/images/icon/17.svg') }}" alt="Architect Icon"> Architectural Firm:</td>
              <td>{{Helper::TopicCustomField($page_data->fields,34)}}</td>
            </tr>
            <tr>
              <td><img src="{{ URL::asset('assets/frontend_new/assets/images/icon/18.svg') }}" alt="Engineers Icon"> Structural Engineers:</td>
              <td>{{Helper::TopicCustomField($page_data->fields,35)}}</td>
            </tr>
            <tr>
              <td><img src="{{ URL::asset('assets/frontend_new/assets/images/icon/19.svg') }}" alt="Start Date Icon"> Start Date:</td>
              <td>{{Helper::TopicCustomField($page_data->fields,36)}}</td>
            </tr>
            <tr>
              <td><img src="{{ URL::asset('assets/frontend_new/assets/images/icon/20.svg') }}" alt="Handover Icon"> Expected Handover:</td>
              <td>{{Helper::TopicCustomField($page_data->fields,37)}}</td>
            </tr>
            <tr>
              <td><img src="{{ URL::asset('assets/frontend_new/assets/images/icon/21.svg') }}" alt="Legal Status Icon"> Legal Status:</td>
              <td>{{Helper::TopicCustomField($page_data->fields,38)}}</td>
            </tr>
          </table>
          </div>

        </div>
      </div>
    </div>
  </section>

  <section class="project-gallery" id="gallery">
    <div class="container">
      <h3>Gallery</h3>
      <div class="grid d-flex flex-wrap gap-3">
        @foreach($page_data->photos as $value)
        <img src="{{ URL::to('uploads/topics/'.$value->file) }}" alt="">
        @endforeach
      </div>
      
    </div>
  </section>

  <section class="ourlocation" id="locations">
        <div class="container">
          <div class="row mt-5">
                <div class="col-lg-6">
                  <h1>Location & Connectivity</h1>
                </div>
                <div class="col-lg-6">
                  <p><b>{{Helper::TopicCustomField($page_data->fields,40)}}</b></p>
                </div>
              </div>
         </div>
         </br>
      
        <div class="container">
          <div class="title-two mb-5">
            <h1>Project Location Map</h1>
          </div>
          <iframe src="{{Helper::TopicCustomField($page_data->fields,54)}}" width="100%" height="600" style="border:0;border-radius: 30px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    
        </div>
      
    </section>
  
@if(Helper::TopicCustomField($page_data->fields,41))
  <section class="floorplan" id="floorplan">
    <div class="container">
      <h3>Available Floor Plans</h3>
      <div class="row">

        @if(Helper::TopicCustomField($page_data->fields,41))
            <div class="col-lg-4">
                <div class="inner-project-single">
                    <img src="{{ URL::to('uploads/topics/'.Helper::TopicCustomField($page_data->fields,42)) }}" alt="">
                    <a href="{{ URL::to('uploads/topics/'.Helper::TopicCustomField($page_data->fields,42)) }}" class="btn btn-primary w-100" download>
                        <img src="./assets/images/icon/22.svg" alt="" class="mb-0">
                        {{ Helper::TopicCustomField($page_data->fields,41) }}
                    </a>
                </div>
            </div>
        @endif
        
        @if(Helper::TopicCustomField($page_data->fields,43))
            <div class="col-lg-4">
                <div class="inner-project-single">
                    <img src="{{ URL::to('uploads/topics/'.Helper::TopicCustomField($page_data->fields,44)) }}" alt="">
                    <a href="{{ URL::to('uploads/topics/'.Helper::TopicCustomField($page_data->fields,44)) }}" class="btn btn-primary w-100" download>
                        <img src="./assets/images/icon/22.svg" alt="" class="mb-0">
                        {{ Helper::TopicCustomField($page_data->fields,43) }}
                    </a>
                </div>
            </div>
        @endif
        
        @if(Helper::TopicCustomField($page_data->fields,45))
            <div class="col-lg-4">
                <div class="inner-project-single">
                    <img src="{{ URL::to('uploads/topics/'.Helper::TopicCustomField($page_data->fields,46)) }}" alt="">
                    <a href="{{ URL::to('uploads/topics/'.Helper::TopicCustomField($page_data->fields,46)) }}" class="btn btn-primary w-100" download>
                        <img src="./assets/images/icon/22.svg" alt="" class="mb-0">
                        {{ Helper::TopicCustomField($page_data->fields,45) }}
                    </a>
                </div>
            </div>
        @endif
        
        @if(Helper::TopicCustomField($page_data->fields,48))
            <div class="col-lg-4">
                <div class="inner-project-single">
                    <img src="{{ URL::to('uploads/topics/'.Helper::TopicCustomField($page_data->fields,49)) }}" alt="">
                    <a href="{{ URL::to('uploads/topics/'.Helper::TopicCustomField($page_data->fields,49)) }}" class="btn btn-primary w-100" download>
                        <img src="./assets/images/icon/22.svg" alt="" class="mb-0">
                        {{ Helper::TopicCustomField($page_data->fields,48) }}
                    </a>
                </div>
            </div>
        @endif
        
        @if(Helper::TopicCustomField($page_data->fields,50))
            <div class="col-lg-4">
                <div class="inner-project-single">
                    <img src="{{ URL::to('uploads/topics/'.Helper::TopicCustomField($page_data->fields,51)) }}" alt="">
                    <a href="{{ URL::to('uploads/topics/'.Helper::TopicCustomField($page_data->fields,51)) }}" class="btn btn-primary w-100" download>
                        <img src="./assets/images/icon/22.svg" alt="" class="mb-0">
                        {{ Helper::TopicCustomField($page_data->fields,50) }}
                    </a>
                </div>
            </div>
        @endif

        @if(Helper::TopicCustomField($page_data->fields,52))
            <div class="col-lg-4">
                <div class="inner-project-single">
                    <img src="{{ URL::to('uploads/topics/' . Helper::TopicCustomField($page_data->fields,53)) }}" alt="">
                    <a 
                        href="{{ URL::to('uploads/topics/' . Helper::TopicCustomField($page_data->fields,53)) }}" 
                        class="btn btn-primary w-100" 
                        download
                    >
                        <img src="./assets/images/icon/22.svg" alt="" class="mb-0">
                        {{ Helper::TopicCustomField($page_data->fields,52) }}
                    </a>
                </div>
            </div>
        @endif

      </div>
    </div>
  </section>
@endif
@if(Helper::TopicCustomField($page_data->fields,18))
  <section class="project-workthough">
    <div class="container">
      <div class="title-two mb-5">
        <h1>Project Walkthrough</h1>
      </div>
      <iframe width="100%" height="500" src="{{Helper::TopicCustomField($page_data->fields,18)}}"
        title="YouTube video player" frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

      <div class="calltoaction">
        <h1>Interested in {{$page_data->title_en}}?</h1>
        <p> Book a Visit or Contact Our Sales Team</p>
        <a href="/contact" class="btn btn-primary">Contact Us</a>
      </div>
    </div>
  </section>
@endif

  <section class="relatedproject">
    <div>
      <div class="container">
        <h3>You May Also Like</h3>
        <div class="row">

        @foreach($page_data->relatedTopics as $value_rp)
            @php
                $rp_details = Helper::Topic($value_rp->topic2_id)
            @endphp
          <div class="col-lg-4">
            <div class="inner-project-single">
              <img src="{{ URL::to('uploads/topics/'.$rp_details['photo_file']) }}" alt="">
              <h3>{{$rp_details->title_en}}</h3>
              <p>{!! substr($rp_details->seo_description_en, 0, 150) . '...' !!}</p>
              <a href="{{ route('details', $rp_details->id) }}" class="btn btn-primary">View Details <i
                  class="fa-solid fa-arrow-up-right-from-square"></i></a>
            </div>
          </div>
          @endforeach
          
        </div>
      </div>

    </div>
  </section>


@endsection