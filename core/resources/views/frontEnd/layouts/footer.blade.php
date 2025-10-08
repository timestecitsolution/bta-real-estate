<!-- Footer -->
  <footer>
    <div class="container">
      <div class="footer-container flex-wrap">
        <div class="footer-logo-section pe-5">
          <img src="{{ URL::to('uploads/settings/'.Helper::GeneralSiteSettings("style_logo_" . @Helper::currentLanguage()->code)) }}" alt="BTA Logo" class="footer-logo" height="80">
          <p class="footer-description">
            {!! Helper::GeneralSiteSettings("site_desc_en") !!}
          </p>
        </div>


        @if(Helper::GeneralWebmasterSettings("footer_menu_id") >0)
                        <?php
                        // Get list of footer menu links by group Id
                        $MenuLinks = \App\Helpers\SiteMenu::List(Helper::GeneralWebmasterSettings("footer_menu_id"));
                        $max_menu_cols = 2;
                        if (!Helper::GeneralSiteSettings("style_subscribe")) {
                            $max_menu_cols = 4;
                        }
                        $mi = 0;
                        ?>
                        @if(count($MenuLinks) == $max_menu_cols)
                            @foreach($MenuLinks as $MenuLink)
                                <div class="footer-column">
                                  
                                        <h4>{{ @$MenuLink->title }}</h4>
                                 
                                    @if(@$MenuLink->sub)
                                        <ul>
                                            @foreach($MenuLink->sub as $SubLink)
                                                <li><a class="" href="{{ @$SubLink->url }}"
                                                       target="{{ @$SubLink->target }}">{!! (@$SubLink->icon)?"<i class='".@$SubLink->icon."'></i> ":"" !!} {{ @$SubLink->title }}
                                                    </a>
                                                </li>
                                                @if(@$SubLink->sub)
                                                    @foreach($SubLink->sub as $SubLink2)
                                                        <li><a
                                                                class=""
                                                                href="{{ @$SubLink2->url }}"
                                                                target="{{ @$SubLink2->target }}">
                                                                &nbsp;&nbsp; {!! (@Helper::currentLanguage()->direction=="rtl")?"&#8617;":"&#8618;" !!} {!! (@$SubLink2->icon)?"<i class='".@$SubLink2->icon."'></i> ":"" !!} {{ @$SubLink2->title }}</a>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                @php($mi++)
                            @endforeach
                        @elseif(count($MenuLinks) > $max_menu_cols)
                            <div class="footer-column">
                               
                                    <h4>{{ __('frontend.quickLinks') }}</h4>
                                
                                <ul>
                                    @foreach($MenuLinks as $MenuLink)
                                        <li><a class="" href="{{ @$MenuLink->url }}"
                                               target="{{ @$MenuLink->target }}">{!! (@$MenuLink->icon)?"<i class='".@$MenuLink->icon."'></i> ":"" !!} {{ @$MenuLink->title }}
                                            </a>
                                        </li>
                                        @if(@$MenuLink->sub)
                                            @foreach($MenuLink->sub as $SubLink)
                                                <li><a
                                                        class=""
                                                        href="{{ @$SubLink->url }}"
                                                        target="{{ @$SubLink->target }}">
                                                        &nbsp;&nbsp; {!! (@Helper::currentLanguage()->direction=="rtl")?"&#8617;":"&#8618;" !!} {!! (@$SubLink->icon)?"<i class='".@$SubLink->icon."'></i> ":"" !!} {{ @$SubLink->title }}</a>
                                                </li>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endif


        <div class="footer-column contact-info">
          <h4>Contact Info</h4>
          <p><i class="fa fa-map-marker-alt"></i>{!! Helper::GeneralSiteSettings("contact_t1_en") !!}</p>
          <p><i class="fa fa-phone"></i>+{!! Helper::GeneralSiteSettings("contact_t3") !!}</p>
          <p><i class="fa fa-envelope"></i>{!! Helper::GeneralSiteSettings("contact_t6") !!}</p>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
          <p class="mb-0">Copyright © {{date('Y')}} <strong>BTA</strong>. All Rights Reserved.</p>
          <div class="social-icons">
            <a href="{!! Helper::GeneralSiteSettings("social_link1") !!}"><i class="fab fa-facebook-f"></i></a>
            <a href="{!! Helper::GeneralSiteSettings("social_link6") !!}"><i class="fab fa-instagram"></i></a>
            <a href="{!! Helper::GeneralSiteSettings("social_link4") !!}"><i class="fab fa-linkedin"></i></a>
            <a href="{!! Helper::GeneralSiteSettings("social_link2") !!}"><i class="fab fa-twitter"></i></a>
          </div>
        </div>
      </div>
    </div>
  </footer>