@extends('frontEnd.layouts.master')

@section('content')
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
$social_activities = Helper::Topics(15,35,4);
$services = Helper::Topics(16,37,4);
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
              <a href="{{ route('details', $project->id) }}">View details <i class="fa-solid fa-arrow-right"></i></a>
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
  <!-- Social Activities -->
  <section class="upcoming-project">
    <div class="container">
      <div class="title-two mb-5">
        <h1>Social Activities</h1>
      </div>
      <div class="row">
        @foreach($social_activities as $key_s => $activities)
        <div class="col-lg-3">
          <div class="project-single">

            <img src="{{ URL::to('uploads/topics/'.$activities->photo_file) }}" alt="">
            <div class="bottom-content">
              <h3>{{$activities->title_en}}</h3>
              <a href="{{ route('social.activity.details', $activities->id) }}">View details <i class="fa-solid fa-arrow-right"></i></a>
            </div>
          </div>
        </div>
        @endforeach
        
      </div>
    </div>
  </section>
  <!-- Service section -->
  <section class="upcoming-project">
    <div class="container">
      <div class="title-two mb-5">
        <h1>Services</h1>
      </div>
      <div class="row">
        @foreach($services as $key_s => $service)
        <div class="col-lg-3">
          <div class="project-single">

            <img src="{{ URL::to('uploads/topics/'.$service->photo_file) }}" alt="">
            <div class="bottom-content">
              <h3>{{$service->title_en}}</h3>
              <a href="{{ route('service.details', $service->id) }}">View details <i class="fa-solid fa-arrow-right"></i></a>
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
                            <label class="text-white" for="full_name">Full Name *</label>
                            <input type="text" name="full_name" value="{{ old('full_name') }}" class="form-control" placeholder="Full name *" required>
                            @error('full_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-lg-6">
                            <label class="text-white" for="email">Email *</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email *" required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror                               
                        </div>
                        <div class="col-lg-6">
                            <label class="text-white" for="phone">Phone *</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="Phone *" maxlength="11" pattern="[0-9]{11}" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g,'').slice(0,11);" required>
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-lg-6">
                            <label class="text-white"for="nid_no">NID No *</label>
                            <input type="number" name="nid_no" value="{{ old('nid_no') }}" class="form-control" placeholder="NID No(In Between 10 to 17 Digits) *" required>
                            @error('nid_no')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-lg-6">
                            <label class="text-white" for="passport_no">Passport No *</label>
                            <input type="text" name="passport_no" value="{{ old('passport_no') }}" maxlength="9" class="form-control" placeholder="Passport No(Max 9 Digits) *" required>
                            @error('passport_no')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror       
                        </div>
                        <div class="col-lg-12">
                            <label class="text-white" for="birth_certificate_no">Birth Certificate No</label>
                            <input type="text" name="birth_certificate_no" value="{{ old('birth_certificate_no') }}" maxlength="17" class="form-control" placeholder="Birth Certificate No(Max 17 Digits)">
                            @error('birth_certificate_no')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror       
                        </div>
                        <div class="col-lg-6">
                            <label class="text-white" for="nid_front_pic">NID Front Pic(Jpg, Jpeg, Png, max: 2MB)</label>
                            <input type="file" name="nid_front_pic" id="nid_front_pic" class="form-control" accept="image/jpeg,image/png" placeholder="NID front pic">
                            <small class="text-danger d-none" id="nid_front_error"></small>
                            @error('nid_front_pic')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-lg-6">
                            <label class="text-white" for="nid_back_pic">NID Back Pic(Jpg, Jpeg, Png, max: 2MB)</label>
                            <input type="file" name="nid_back_pic" id="nid_back_pic" class="form-control" accept="image/jpeg,image/png" placeholder="NID back pic">
                            <small class="text-danger d-none" id="nid_back_error"></small>
                            @error('nid_back_pic')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-lg-12">
                            <label class="text-white" for="project_id">Project of Interest *</label>
                            <select class="form-select" id="project_id" name="project_id" required>
                                <option disabled {{ old('project_id') ? '' : 'selected' }}>Project of Interest</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}"
                                        {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                        {{ $project->title_en }}
                                    </option>
                                @endforeach
                            </select>
                            @error('project_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-lg-12 mt-3" id="flat_section">
                            <label class="text-white" for="flat_id">Select Flat *</label>
                            <select class="form-select" id="flat_id" name="flat_id" required>
                                <option selected disabled>Select Flat *</option>
                            </select>
                            @error('flat_id')
                                <small class="text-danger">{{ $message }}</small>   
                            @enderror
                        </div>
                        <div class="col-lg-12">
                            <label class="text-white" for="preferred_date">Preferred Date *</label>
                            <input type="date" name="preferred_date" value="{{ old('preferred_date') }}" class="form-control" required>
                            @error('preferred_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-lg-12">
                            <label class="text-white" for="message">Your Message / Inquiry</label>
                            <textarea name="message" class="form-control" placeholder="Your Message / Inquiry">{{ old('message') }}</textarea>
                            @error('message')
                                <small class="text-danger">{{ $message }}</small>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@if(session('success'))
<script>
    $(document).ready(function () {
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
        };
        toastr.success("{{ session('success') }}");
    });
</script>
@endif

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
                // let projectId = $(this).find('option:selected').data('project_id');
                let projectId = $(this).val();
                $.ajax({
                    url: "{{ route('get.project.flats') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        project_id: projectId
                    },
                    success: function (response) {
                        let options = '<option selected disabled>Select Flat *</option>';

                        if (response.tags.length > 0) {
                            response.tags.forEach(function (tag) {
                                options += `<option value="${tag.title}">${tag.title}</option>`;
                            });

                            $('#flat_id').html(options);
                            // $('#flat_section').show();
                        } else {
                            $('#flat_id').html('<option>No tags found</option>');
                            // $('#flat_section').hide();
                        }
                    }
                });
            });
        });


        function validateNIDFile(inputId, errorId) {
          const input = document.getElementById(inputId);
          const error = document.getElementById(errorId);

          input.addEventListener('change', function () {
              error.classList.add('d-none');
              error.innerText = '';

              if (!this.files.length) return;

              const file = this.files[0];
              const allowedTypes = ['image/jpeg', 'image/png'];
              const maxSize = 2 * 1024 * 1024; 

              // File type check
              if (!allowedTypes.includes(file.type)) {
                  this.value = '';
                  error.innerText = '❌ Only JPG, JPEG or PNG files are allowed.';
                  error.classList.remove('d-none');
                  return;
              }

              // File size check
              if (file.size > maxSize) {
                  this.value = '';
                  error.innerText = '❌ File size must be less than 2MB.';
                  error.classList.remove('d-none');
                  return;
              }
          });
      }

      validateNIDFile('nid_front_pic', 'nid_front_error');
      validateNIDFile('nid_back_pic', 'nid_back_error');
    </script>
@endsection