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

          <section class="booking-wrap">
    <div class="container">
      <div class="booking-content">
        <div class="row align-items-center">
          <div class="col-lg-5 ps-5">
            <h3>Contact us</h3>
            <p class="mb-5">
              Get in touch with Building Technology Architecture (BTA) for project inquiries, consultations, or partnership opportunities.
            </p>
            <h5 class="mt-5">Phone / Email</h5>
            <p><img src="{{ URL::asset('assets/frontend_new/assets/images/icon/23.svg') }}" alt=""> +{{ Helper::GeneralSiteSettings("contact_t3") }}</p> 
            <p><img src="{{ URL::asset('assets/frontend_new/assets/images/icon/24.svg') }}" alt=""> {{ Helper::GeneralSiteSettings("contact_t6") }}</p> 
            <p><img src="{{ URL::asset('assets/frontend_new/assets/images/icon/25.svg') }}" alt=""> {{ Helper::GeneralSiteSettings("contact_t1_" . @Helper::currentLanguage()->code) }}</p>
            <a href="https://wa.me/{!! Helper::GeneralSiteSettings('contact_t3') !!}" class="whatsapp-button" target="_blank">
                  <i class="fa-brands fa-whatsapp"></i> Message us on WhatsApp
              </a>
            <h5 class="mt-5">Business Hours:</h5>
            <p>{{ Helper::GeneralSiteSettings("contact_t7_" . @Helper::currentLanguage()->code) }}</p>
          </div>


          <div class="col-lg-7">
            <div class="booking-form">
              {{Form::open(['route'=>['contactPageSubmit'],'method'=>'POST','class'=>'php-email-form','id'=>''])}}
                <div class="row">
                  <div class="col-lg-12">
                    <input type="text" name="contact_name" id="contact_name" class="form-control" placeholder="Full name" required>
                  </div>
                  <div class="col-lg-6">
                    <input type="email" name="contact_email" id="contact_email" class="form-control" placeholder="Email" required>
                  </div>
                  <div class="col-lg-6">
                    <input type="number" name="contact_phone" id="contact_phone" class="form-control" placeholder="Phone" required>
                  </div>
                  <div class="col-lg-12">
                    <select name="contact_subject" id="contact_subject" class="form-select" aria-label="Default select example" required>
                      <option selected>Choose a service</option>
                      <option value="Civil Solutions">Civil Solutions</option>
                      <option value="Architect Solution">Architect Solution</option>
                      <option value="Interior Design">Interior Design</option>
                      <option value="3d Animation">3d Animation</option>
                    </select>
                  </div>
                  <div class="col-lg-12" required>
                    <textarea name="contact_message" id="contact_message" placeholder="Your Message / Inquiry" class="form-control"></textarea>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-7 form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                      Yes, I would like to receive news and email
                    </label>
                  </div>


                  <div class="col-lg-5 text-end">
                    <button type="submit" id="contactFormSubmit" class="btn btn-primary"> Submit <i class="fa-solid fa-arrow-up-right-from-square"></i></button>
                  </div>
                </div>
              {{Form::close()}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="ourlocation">
    <div class="container">
      <div class="title-two mb-5">
        <h1>Our Location Map</h1>
      </div>
      <iframe src="{{ strip_tags($Topic->details_en) }}" width="100%" height="600" style="border:0;border-radius: 30px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

    </div>
  </section>



@if(request()->has('msg'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ request()->get('msg') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <script>
        setTimeout(function () {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
@endif
        
        
   
    @include('frontEnd.layouts.popup',['Popup'=>@$Popup])
@endsection

@push('before-styles')
    <link rel="stylesheet"
          href="{{ URL::asset('assets/frontend/vendor/intl-tel-input/css/intlTelInput.min.css') }}?v={{ Helper::system_version() }}"/>
@endpush
@push('after-scripts')
    <script
        src="{{ URL::asset('assets/frontend/vendor/intl-tel-input/js/intlTelInput.min.js') }}?v={{ Helper::system_version() }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
                $('#contactForm').submit(function (evt) {
                    evt.preventDefault();
                    let btn = $('#contactFormSubmit');
                    btn.html("<img src=\"{{ asset('assets/dashboard/images/loading.gif') }}\" style=\"height: 20px\"/> {!! __('frontend.sendMessage') !!}");
                    btn.prop('disabled', true);

                    var formData = new FormData(this);
                    $.ajax({
                        type: "POST",
                        url: "{{ route("contactPageSubmit") }}",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            if (result.stat === 'success') {
                                // ✅ redirect with success message
                                window.location.href = result.redirect + '?msg=' + encodeURIComponent(result.msg);
                            } else {
                                // ❌ Error message show
                                let confirm = '<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">' + result.msg + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                                $("#contactForm .submit-message").html(confirm);
                            }
                            btn.html('<i class="fa-solid fa-paper-plane"></i> {!! __('frontend.sendMessage') !!}');
                            btn.prop('disabled', false);
                        }
                    });
                    return false;
                });
            });


        var iti = window.intlTelInput(document.querySelector("#contact_phone"), {
            showSelectedDialCode: true,
            countrySearch: true,
            initialCountry: "auto",
            separateDialCode: true,
            hiddenInput: function() {
                return {
                    phone: "contact_phone_full",
                    country: "contact_phone_country_code"
                };
            },
            geoIpLookup: function (callback) {
                $.get('https://ipinfo.io', function () {
                }, "jsonp").always(function (resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "us";
                    callback(countryCode.toLowerCase());
                    iti.setCountry(countryCode.toLowerCase());
                });
            },
            utilsScript: "{{ URL::asset('assets/frontend/vendor/intl-tel-input/js/utils.js') }}?v={{ Helper::system_version() }}",
        });
    </script>
@endpush
