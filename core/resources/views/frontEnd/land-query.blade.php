@extends('frontEnd.layouts.master')

@section('content')
    
        <?php
        $title_var = "title_" . @Helper::currentLanguage()->code;
        $title_var2 = "title_" . config('smartend.default_language');
        $details_var = "details_" . @Helper::currentLanguage()->code;
        $details_var2 = "details_" . config('smartend.default_language');
        // if ($Topic->$title_var != "") {
        //     $title = $Topic->$title_var;
        // } else {
        //     $title = $Topic->$title_var2;
        // }
        // if ($Topic->$details_var != "") {
        //     $details = $details_var;
        // } else {
        //     $details = $details_var2;
        // }
        // $section = "";
        // try {
        //     if ($Topic->section->$title_var != "") {
        //         $section = $Topic->section->$title_var;
        //     } else {
        //         $section = $Topic->section->$title_var2;
        //     }
        // } catch (Exception $e) {
        //     $section = "";
        // }

        $projects = Helper::Topics(8);
    
        ?>

        


            <!-- <section class="booking-wrap">
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
            </section> -->

            <section class="land-query">
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
            </section>
        
   
    @include('frontEnd.layouts.popup',['Popup'=>@$Popup])

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                        let stat = 'alert-danger';
                        if (result.stat === 'success') {
                            stat = 'alert-success';
                            $('#contactForm')[0].reset();
                        }
                        let confirm = '<div class="alert ' + stat + ' alert-dismissible fade show mt-3" role="alert">' + result.msg + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                        $("#contactForm .submit-message").html(confirm);
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
