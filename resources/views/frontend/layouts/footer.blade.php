<!-- Main Footer -->
@if(app()->getLocale() == 'en')
  <footer class="main-footer">
      <div class="auto-container">
        <!--Widgets Section-->
        <div class="widgets-section">
          <div class="row clearfix">
            <!--Column-->
            <div class="column col-xl-4 col-lg-6 col-md-6 col-sm-12" style="text-align: center">
              <div class="footer-widget logo-widget">
                <div class="widget-content">
                  <h6>{{ $about_us->en_about_title }}</h6>
                  <div class="text">
                    {{ $about_us->en_about_text }}
                  </div>
                  <ul class="social-links clearfix">
                    <li>
                      <a href="{{ $contact_us->facebook }}"
                        ><span class="fab fa-facebook-square"></span
                      ></a>
                    </li>
                    <li>
                      <a href="{{ $contact_us->twitter }}"><span class="fab fa-twitter"></span></a>
                    </li>
                    <li>
                      <a href="{{ $contact_us->instagram }}"><span class="fab fa-instagram"></span></a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>

            <!--Column-->
            <div class="column col-xl-4 col-lg-6 col-md-6 col-sm-12" style="text-align: center">
              <div class="footer-widget links-widget">
                <div class="widget-content">
                  <h6>Explore</h6>
                  <div class="row clearfix">
                    <div class="col-md-12 col-sm-12">
                      <ul>
                        <li><a href="{{ route('about-us') }}">About</a></li>
                        <li><a href="{{ route('team') }}">Meet Our Team</a></li>
                        <li><a href="{{ route('portfolio') }}">Our Portfolio</a></li>
                        <li><a href="{{ route('blogs') }}">Latest News</a></li>
                        <li><a href="{{ route('contact-us') }}">Contact</a></li>
                      </ul>
                    </div>
                    {{-- <div class="col-md-6 col-sm-12">
                      <ul>
                        <li><a href="#">Support</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Use</a></li>
                        <li><a href="#">Help</a></li>
                      </ul>
                    </div> --}}
                  </div>
                </div>
              </div>
            </div>

            <!--Column-->
            <div class="column col-xl-4 col-lg-6 col-md-6 col-sm-12" style="text-align: center">
              <div class="footer-widget info-widget">
                <div class="widget-content">
                  <h6>Contact</h6>
                  <ul class="contact-info">
                    <li class="address">
                      <span class="icon flaticon-pin-1"></span> {{ $contact_us->en_address }}
                    </li>
                    <li>
                      <span class="icon flaticon-call"></span>
                      {{ $contact_us->phone }}
                    </li>
                    <li>
                      <span class="icon flaticon-email-2"></span>
                      {{ $contact_us->email }}
                    </li>
                  </ul>
                </div>
              </div>
            </div>

            <!--Column-->
            {{-- <div class="column col-xl-3 col-lg-6 col-md-6 col-sm-12">
              <div class="footer-widget newsletter-widget">
                <div class="widget-content">
                  <h6>Newsletter</h6>
                  <div class="newsletter-form">
                    <form
                      method="post"
                      action="http://layerdrops.com/linoorhtml/contact.html"
                    >
                      <div class="form-group clearfix">
                        <input
                          type="email"
                          name="email"
                          value=""
                          placeholder="Email Address"
                          required=""
                        />
                        <button type="submit" class="theme-btn">
                          <span class="fa fa-envelope"></span>
                        </button>
                      </div>
                    </form>
                  </div>
                  <div class="text">
                    Sign up for our latest news & articles. We won’t give you
                    spam mails.
                  </div>
                </div>
              </div>
            </div> --}}
          </div>
        </div>
      </div>

      <!-- Footer Bottom -->
      <div class="footer-bottom">
        <div class="auto-container">
          <div class="inner clearfix">
            <div class="copyright">
               All copyrights reserved by Digital Bond &copy; 2020
            </div>
          </div>
        </div>
      </div>
  </footer>
@else
  <footer class="main-footer">
    <div class="auto-container">
      <!--Widgets Section-->
      <div class="widgets-section">
        <div class="row clearfix">
          <!--Column-->
          <div class="column col-xl-4 col-lg-6 col-md-6 col-sm-12" style="text-align: center">
            <div class="footer-widget logo-widget">
              <div class="widget-content">
                <h6>{{ $about_us->ar_about_title }}</h6>
                <div class="text">
                  {{ $about_us->ar_about_text }}
                </div>
                <ul class="social-links clearfix">
                  <li>
                    <a href="{{ $contact_us->facebook }}"
                      ><span class="fab fa-facebook-square"></span
                    ></a>
                  </li>
                  <li>
                    <a href="{{ $contact_us->twitter }}"><span class="fab fa-twitter"></span></a>
                  </li>
                  <li>
                    <a href="{{ $contact_us->instagram }}"><span class="fab fa-instagram"></span></a>
                  </li>
                </ul>
              </div>
            </div>
          </div>

          <!--Column-->
          <div class="column col-xl-4 col-lg-6 col-md-6 col-sm-12" style="text-align: center">
            <div class="footer-widget links-widget">
              <div class="widget-content">
                <h6>اكتشف</h6>
                <div class="row clearfix">
                  <div class="col-md-12 col-sm-12">
                    <ul>
                      <li><a href="{{ route('about-us') }}">من نحن</a></li>
                      <li><a href="{{ route('team') }}">قابل فريقنا</a></li>
                      <li><a href="{{ route('portfolio') }}">مشاريعنا</a></li>
                      <li><a href="{{ route('blogs') }}">اخر الاخبار</a></li>
                      <li><a href="{{ route('contact-us') }}">تواصل معنا</a></li>
                    </ul>
                  </div>
                  {{-- <div class="col-md-6 col-sm-12">
                    <ul>
                      <li><a href="#">Support</a></li>
                      <li><a href="#">Privacy Policy</a></li>
                      <li><a href="#">Terms of Use</a></li>
                      <li><a href="#">Help</a></li>
                    </ul>
                  </div> --}}
                </div>
              </div>
            </div>
          </div>

          <!--Column-->
          <div class="column col-xl-4 col-lg-6 col-md-6 col-sm-12" style="text-align: center">
            <div class="footer-widget info-widget">
              <div class="widget-content">
                <h6>تواصل معنا</h6>
                <ul class="contact-info">
                  <li class="address">
                    {{ $contact_us->ar_address }} <span class="icon flaticon-pin-1" style="float: right"></span>
                  </li>
                  <li>
                    <span class="icon flaticon-call"></span>
                    {{ $contact_us->phone }}
                  </li>
                  <li>
                    <span class="icon flaticon-email-2"></span>
                    {{ $contact_us->email }}
                  </li>
                </ul>
              </div>
            </div>
          </div>

          <!--Column-->
          {{-- <div class="column col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="footer-widget newsletter-widget">
              <div class="widget-content">
                <h6>Newsletter</h6>
                <div class="newsletter-form">
                  <form
                    method="post"
                    action="http://layerdrops.com/linoorhtml/contact.html"
                  >
                    <div class="form-group clearfix">
                      <input
                        type="email"
                        name="email"
                        value=""
                        placeholder="Email Address"
                        required=""
                      />
                      <button type="submit" class="theme-btn">
                        <span class="fa fa-envelope"></span>
                      </button>
                    </div>
                  </form>
                </div>
                <div class="text">
                  Sign up for our latest news & articles. We won’t give you
                  spam mails.
                </div>
              </div>
            </div>
          </div> --}}
        </div>
      </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
      <div class="auto-container">
        <div class="inner clearfix">
          <div class="copyright">
             جميع الحقوق محفوظة لدي ديجيتال بوند 2020 &copy;
          </div>
        </div>
      </div>
    </div>
  </footer>
@endif