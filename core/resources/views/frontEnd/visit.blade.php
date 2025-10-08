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

                            <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
                                 @csrf
                                <div class="row g-3">
                                    <div class="col-lg-12">
                                        <input type="text" name="full_name" class="form-control" placeholder="Full name" required>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="number" name="phone" class="form-control" placeholder="Phone" required>
                                    </div>
                                    <div class="col-lg-12">
                                        <select class="form-select" id="project_id" name="project_id" required>
                                            <option selected disabled>Project of Interest</option>
                                            @foreach($projects as $project)
                                                <option data-project_id="{{ $project->id }}" value="{{ $project->title_en }}">{{ $project->title_en }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-12 mt-3" id="flat_section" style="display: none;">
                                        <select class="form-select" id="flat_id" name="flat_id" required>
                                            <option selected disabled>Select Flat</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-12">
                                        <input type="date" name="preferred_date" class="form-control">
                                    </div>
                                    <div class="col-lg-12">
                                        <textarea name="message" class="form-control" placeholder="Your Message / Inquiry"></textarea>
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
