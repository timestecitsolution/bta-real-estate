@extends('frontEnd.layouts.master')

@section('content')

@if(session('success'))
    <div class="alert alert-success mt-2" id="success-alert">
        {{ session('success') }}
    </div>
@endif
  <section class="home-about">
    <div class="container">
      <div class="home-about-content">
        <div class="row align-items-center">
          <div class="col-lg-5">
            <img src="{{ URL::to('uploads/settings/'.Helper::GeneralSiteSettings("about_us_image")) }}" alt="" width="100%">
          </div>

          <div class="col-lg-7 py-3">
            <div class="p-2 p-lg-5">
              <h6>{!! Helper::GeneralSiteSettings("about_us_title") !!}</h6>
              <h1>{!! Helper::GeneralSiteSettings("about_us_heading") !!}</h1>
              <p>
                {!! Helper::GeneralSiteSettings("about_us_description") !!}
              </p>
              <a href="/.{!! Helper::GeneralSiteSettings("about_us_button_link") !!}" class="btn btn-secondary">Read More About Us <i
                  class="fa-solid fa-arrow-up-right-from-square"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="feature">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="feature-single">
            <img src="{{ URL::to('uploads/settings/'.Helper::GeneralSiteSettings("architecture_icon1")) }}" alt="">
            <h3>{!! Helper::GeneralSiteSettings("architecture_title1") !!}</h3>
            <p>{!! Helper::GeneralSiteSettings("architecture_heading1") !!}</p>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="feature-single">
            <img src="{{ URL::to('uploads/settings/'.Helper::GeneralSiteSettings("architecture_icon2")) }}" alt="">
            <h3>{!! Helper::GeneralSiteSettings("architecture_title2") !!}</h3>
            <p>{!! Helper::GeneralSiteSettings("architecture_heading2") !!}</p>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="feature-single">
            <img src="{{ URL::to('uploads/settings/'.Helper::GeneralSiteSettings("architecture_icon3")) }}" alt="">
            <h3>{!! Helper::GeneralSiteSettings("architecture_title3") !!}</h3>
            <p>{!! Helper::GeneralSiteSettings("architecture_heading3") !!}</p>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="feature-single">
            <img src="{{ URL::to('uploads/settings/'.Helper::GeneralSiteSettings("architecture_icon4")) }}" alt="">
            <h3>{!! Helper::GeneralSiteSettings("architecture_title4") !!}</h3>
            <p>{!! Helper::GeneralSiteSettings("architecture_heading4") !!}</p>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php
$Topics_on_going = Helper::Topics(8,30,4);
$Topics_upcoming = Helper::Topics(8,31,4);

?>
  <section class="upcoming-project ongoing-project">
    <div class="container">
      <div class="title-one mb-5">
        <h1>On going project</h1>
      </div>
      <div class="row">

        @foreach($Topics_on_going as $key => $project)
        <div class="col-lg-3">
          <div class="project-single">

            <img src="{{ URL::to('uploads/topics/'.$project->photo_file) }}" alt="">
            <div class="bottom-content">
              <h3>{{$project->title_en}}</h3>
              <a href="{{ route('details', $project->id) }}">View projects <i class="fa-solid fa-arrow-right"></i></a>
            </div>
          </div>
        </div>
        @endforeach
        
      </div>
    </div>
  </section>

  <section class="upcoming-project">
    <div class="container">
      <div class="title-two mb-5">
        <h1>Upcoming Project</h1>
      </div>
      <div class="row">


        @foreach($Topics_upcoming as $key_u => $project_u)
        <div class="col-lg-3">
          <div class="project-single">

            <img src="{{ URL::to('uploads/topics/'.$project_u->photo_file) }}" alt="">
            <div class="bottom-content">
              <h3>{{$project_u->title_en}}</h3>
              <a href="{{ route('details', $project->id) }}">View projects <i class="fa-solid fa-arrow-right"></i></a>
            </div>
          </div>
        </div>
        @endforeach
        
      </div>
    </div>
  </section>

  <section class="home-about why-choose">
    <div class="container">
      <div class="home-about-content ps-5">
        <div class="row align-items-center">
          <div class="col-lg-6 py-3">
            <div class="p-5">
              <h6>{!! Helper::GeneralSiteSettings("why_choose_us_title") !!}</h6>
              <h1>{!! Helper::GeneralSiteSettings("why_choose_us_heading") !!}</h1>
              <p>
                {!! Helper::GeneralSiteSettings("why_choose_us_description") !!}
              </p>
              <div class="row">
                <div class="col-lg-4">
                  <div class="statistics-single">
                    <h3>{!! Helper::GeneralSiteSettings("experience_years") !!} </h3>
                    <p>{!! Helper::GeneralSiteSettings("experience_years_title") !!}</p>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="statistics-single">
                    <h3>{!! Helper::GeneralSiteSettings("successful_projects") !!}</h3>
                    <p>{!! Helper::GeneralSiteSettings("successful_projects_title") !!}</p>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="statistics-single">
                    <h3>{!! Helper::GeneralSiteSettings("expert_title") !!}</h3>
                    <p>{!! Helper::GeneralSiteSettings("investment_title") !!}</p>
                  </div>
                </div>
              </div>
              <a href="{!! Helper::GeneralSiteSettings("why_choose_us_button_link") !!}" class="btn btn-secondary">Read More About Us <i
                  class="fa-solid fa-arrow-up-right-from-square"></i></a>
            </div>
          </div>
          <div class="col-lg-6">
            <img src="{{ URL::to('uploads/settings/'.Helper::GeneralSiteSettings("why_choose_us_image")) }}" alt="" width="100%">
          </div>

        </div>
      </div>
    </div>
  </section>

  <!-- <section class="land-query">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <div class="form-content">
            <div>
              <h3>Land Query</h3>
              <p>Use the contact form to reach us. Your feedback and<br> suggestions help to improve this platform.</p>
            </div>
            <div>
              <h6 class="mb-3">Phone / Email</h6>
              <p><i class="fa fa-phone me-1"></i>+{!! Helper::GeneralSiteSettings("contact_t3") !!}</p>
              <p><i class="fa fa-envelope me-1"></i> {!! Helper::GeneralSiteSettings("contact_t6") !!}</p>
              <a href="https://wa.me/{!! Helper::GeneralSiteSettings('contact_t3') !!}" class="whatsapp-button" target="_blank">
                  <i class="fa-brands fa-whatsapp"></i> Message us on WhatsApp
              </a>

            </div>
            <div>
              <p>This site is protected by reCAPTCHA and the Google Privacy Policy and Terms of Service apply.</p>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <form action="{{ route('land.query.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-lg-12">
                <input type="text" name="owner_name" placeholder="Land owner Name" class="form-control" required>
              </div>
              <div class="col-lg-6">
                <input type="email" name="email" placeholder="Email" class="form-control" required>
              </div>
              <div class="col-lg-6">
                <input type="text" name="phone" placeholder="Phone No" class="form-control" required>
              </div>
              <div class="col-lg-12">
                <input type="text" name="land_address" placeholder="Land address" class="form-control" required>
              </div>
              <div class="col-lg-12">
                <input type="text" name="land_info" placeholder="Land info ( jl no, mouja, dag no, khotian, rs, cs, sa )" class="form-control" required>
              </div>
              <div class="col-lg-6">
                <input type="text" name="land_area" placeholder="Land area" class="form-control" required>
              </div>
              <div class="col-lg-6">
                <input type="text" name="road_size" placeholder="Road size" class="form-control" required>
              </div>
              <div class="col-lg-12">
                <div class="upload-gallery">
                  <div class="upload-box" onclick="document.getElementById('fileInput').click()">
                    <div class="upload-icon">
                      <img src="{{ asset('assets/frontend_new/assets/images/icon/5.svg') }}" alt="">
                    </div>
                    <p>Upload land picture or video</p>
                    <input type="file" id="fileInput" name="attachments[]" multiple accept="image/*,video/*" style="display:none"
                           onchange="handleFiles(this.files)" />
                  </div>
                  <div class="preview-gallery" id="previewGallery"></div>
                </div>
              </div>
              <div class="col-lg-12">
                <textarea name="review" placeholder="Write your review" class="form-control"></textarea>
              </div>
              <button class="btn btn-secondary mt-3">
                Submit <i class="fa-solid fa-arrow-up-right-from-square"></i>
              </button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </section> -->
  <?php
    $projects = Helper::Topics(8);
  ?>
  <section class="booking-wrap">
    <div class="container">
      <div class="booking-content">
        <div class="row align-items-center">
          <div class="col-lg-5 ps-5">
            <h3>Book a Visit or Inquiry</h3>
            <p class="mb-5">
              Use the form to book your visit, send an inquiry, or express interest in a project. Our team will respond within 24 hours.
            </p>
            <h5 class="mt-5">Business Hours:</h5>
            <p>{{ Helper::GeneralSiteSettings("contact_t7_" . @Helper::currentLanguage()->code) }}</p>
          </div>
          <div class="col-lg-7">
            <div class="booking-form">
              <!-- resources/views/booking/form.blade.php -->

                <form action="{{ route('booking.store') }}" method="POST" id="bookingForm" enctype="multipart/form-data">
                      @csrf
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <input type="text" name="full_name" class="form-control" placeholder="Full name" required>
                            @error('full_name')
                                <small class="text-white">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-lg-6">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                            @error('email')
                                <small class="text-white">{{ $message }}</small>
                            @enderror                               
                        </div>
                        <div class="col-lg-6">
                            <input type="number" name="phone" class="form-control" placeholder="Phone" required>
                            @error('phone')
                                <small class="text-white">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-lg-6">
                            <input type="number" name="nid_no" class="form-control" placeholder="NID No(In Between 10 to 17 Digits)" required>
                            @error('nid_no')
                                <small class="text-white">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-lg-6">
                            <input type="text" name="passport_no" maxlength="9" class="form-control" placeholder="Passport No(Max 9 Digits)" required>
                            @error('passport_no')
                                <small class="text-white">{{ $message }}</small>
                            @enderror       
                        </div>
                        <div class="col-lg-12">
                            <input type="text" name="birth_certificate_no" maxlength="17" class="form-control" placeholder="Birth Certificate No(Max 17 Digits)">
                            @error('birth_certificate_no')
                                <small class="text-white">{{ $message }}</small>
                            @enderror       
                        </div>
                        <div class="col-lg-6">
                            <label class="text-white" for="nid_front_pic">NID Front Pic</label>
                            <input type="file" name="nid_front_pic" class="form-control" placeholder="NID front pic" required>
                            @error('nid_front_pic')
                                <small class="text-white">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-lg-6">
                            <label class="text-white" for="nid_back_pic">NID Back Pic</label>
                            <input type="file" name="nid_back_pic" class="form-control" placeholder="NID back pic" required>
                            @error('nid_back_pic')
                                <small class="text-white">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-lg-12">
                            <select class="form-select" id="project_id" name="project_id" required>
                                <option selected disabled>Project of Interest</option>
                                @foreach($projects as $project)
                                    <option data-project_id="{{ $project->id }}" value="{{ $project->title_en }}">{{ $project->title_en }}</option>
                                @endforeach
                            </select>
                            @error('project_id')
                                <small class="text-white">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-lg-12 mt-3" id="flat_section" style="display: none;">
                            <select class="form-select" id="flat_id" name="flat_id" required>
                                <option selected disabled>Select Flat</option>
                            </select>
                            @error('flat_id')
                                <small class="text-white">{{ $message }}</small>   
                            @enderror
                        </div>
                        <div class="col-lg-12">
                            <input type="date" name="preferred_date" class="form-control">
                            @error('preferred_date')
                                <small class="text-white">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-lg-12">
                            <textarea name="message" class="form-control" placeholder="Your Message / Inquiry"></textarea>
                            @error('message')
                                <small class="text-white">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-lg-7 form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="privacyCheck" name="privacy_check">
                            <label class="form-check-label" for="privacyCheck">
                                We respect your privacy. Your data is safe and will only be used for project communication.
                            </label>
                        </div>
                        <div class="col-lg-5 text-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>

            </div>
          </div>
        </div>
      </div>
    </div>
</section>
@include('frontEnd.layouts.popup',['Popup'=>@$Popup])
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$('#fileInput').on('change', function () {
  if (this.files.length > 5) {
    alert('You can only upload up to 5 files.');
    this.value = '';
    return;
  }

  const gallery = $('#previewGallery');
  gallery.html('');

  [...this.files].forEach(file => {
    const reader = new FileReader();
    reader.onload = function (e) {
      gallery.append(`<img src=\"${e.target.result}\" width=\"100\" class=\"me-2 mb-2\">`);
    };
    reader.readAsDataURL(file);
  });
});

    setTimeout(function () {
        let alertBox = document.getElementById('success-alert');
        if (alertBox) {
            alertBox.style.transition = "opacity 0.5s ease-out";
            alertBox.style.opacity = 0;
            setTimeout(() => alertBox.remove(), 500); // remove from DOM after fade
        }
    }, 5000); // 5000ms = 5 seconds
</script>


<script type="text/javascript">
    $(document).ready(function () {
        $('#bookingForm').on('submit', function (e) {
            if (!$('#privacyCheck').is(':checked')) {
                e.preventDefault();
                alert('Please agree to the privacy policy before submitting.');
            }
        });
    });
</script>

    <script>
        $(document).ready(function () {
            $('#project_id').on('change', function () {
                let projectId = $(this).find('option:selected').data('project_id');
              
                $.ajax({
                    url: "{{ route('get.project.flats') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        project_id: projectId
                    },
                    success: function (response) {
                        let options = '<option selected disabled>Select Flat</option>';

                        if (response.tags.length > 0) {
                            response.tags.forEach(function (tag) {
                                options += `<option value="${tag.title}">${tag.title}</option>`;
                            });

                            $('#flat_id').html(options);
                            $('#flat_section').show();
                        } else {
                            $('#flat_id').html('<option>No tags found</option>');
                            $('#flat_section').hide();
                        }
                    }
                });
            });
        });
    </script>
@endsection