@if(app()->getLocale() == 'en')
<!-- Main Header -->
<header class="main-header header-style-one">
    <!-- Header Upper -->
    <div class="header-upper">
      <div class="inner-container clearfix">
        <!--Logo-->
        <div class="logo-box">
          <div class="logo">
            <a
              href="{{ route('home') }}"
              title="Digital Bond - Digital Marketing Agency"
              ><img
                src="/frontend/images/Logo-onBlack.png"
                id="thm-logo"
                alt="Digital Bond - Digital Marketing Agency"
                title="Digital Bond - Digital Marketing Agency"
                style="width: 150px; height: 75px !important;"
            /></a>
          </div>
        </div>
        <div class="nav-outer clearfix">
          <!--Mobile Navigation Toggler-->
          <div class="mobile-nav-toggler" style="padding-top: 20px;">
            <span class="icon flaticon-menu-2"></span
            ><span class="txt">Menu</span>
          </div>

          <!-- Main Menu -->
          <nav class="main-menu navbar-expand-md navbar-light" style="padding-top: 25px;">
            <div
              class="collapse navbar-collapse show clearfix"
              id="navbarSupportedContent"
            >
              <ul class="navigation clearfix">
                <li class="{{ request()->segment(2) === NULL ? 'current' : '' }}">
                  <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="{{ request()->segment(2) === 'about-us' ? 'current' : '' }}">
                  <a href="{{ route('about-us') }}">About Us</a>
                </li>
                <li class="{{ request()->segment(2) === 'services' ? 'current' : '' }} dropdown">
                  <a href="{{ route('services') }}">Services</a>
                  <ul>
                    <li><a href="{{ route('services') }}">All Services</a></li>
                    @foreach($services as $service)
                      <li>
                        <a href="{{ route('service', $service->en_slug) }}">{{ $service->en_title }}</a>
                      </li>
                    @endforeach
                  </ul>
                </li>
                <li class="{{ request()->segment(2) === 'portfolio' ? 'current' : '' }}">
                  <a href="{{ route('portfolio') }}">Portfolio</a>
                </li>
                <li class="{{ request()->segment(2) === 'blogs' ? 'current' : '' }}">
                  <a href="{{ route('blogs') }}">Blogs</a>
                </li>
                <li class="{{ request()->segment(2) === 'team' ? 'current' : '' }}">
                  <a href="{{ route('team') }}">Our Team</a>
                </li>
                <li class="{{ request()->segment(2) === 'contact-us' ? 'current' : '' }}">
                  <a href="{{ route('contact-us') }}">Contact Us</a>
                </li>
                @if($ipCountry !== 'Egypt')
                  <li class="">
                    <a href="/ar">اللغة العربية</a>
                  </li>
                @endif
              </ul>
            </div>
          </nav>
        </div>

        <div class="other-links clearfix" style="padding-top: 25px;">
          <!--Search Btn-->
          {{-- <div class="search-btn">
            <button type="button" class="theme-btn search-toggler">
              <span class="flaticon-loupe"></span>
            </button>
          </div> --}}
          <div class="link-box">
            <div class="call-us">
              <a class="link" href="tel:{{ $contact_us->phone }}">
                <span class="icon"></span>
                <span class="sub-text">Call Anytime</span>
                <span class="number">{{ $contact_us->phone }}</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--End Header Upper-->
</header>
  <!-- End Main Header -->

  <!--Mobile Menu-->
  <div class="side-menu__block">
    <div class="side-menu__block-overlay custom-cursor__overlay">
      <div class="cursor"></div>
      <div class="cursor-follower"></div>
    </div>
    <!-- /.side-menu__block-overlay -->
    <div class="side-menu__block-inner">
      <div class="side-menu__top justify-content-end">
        <a href="#" class="side-menu__toggler side-menu__close-btn"
          ><img src="/frontend/images/icons/close-1-1.png" alt=""
        /></a>
      </div>
      <!-- /.side-menu__top -->

      <nav class="mobile-nav__container">
        <!-- content is loading via js -->
      </nav>
      <div class="side-menu__sep"></div>
      <!-- /.side-menu__sep -->
      <div class="side-menu__content">
        <p>
          {{ $about_us->en_about_text }}
        </p>
        <p>
          <a href="{{ $contact_us->email }}"><span class="icon flaticon-email-2"></span> {{ $contact_us->email }}</a>
          <br />
          <a href="tel:{{ $contact_us->phone }}"><span class="icon flaticon-call"></span> {{ $contact_us->phone }}</a>
        </p>
        <div class="side-menu__social">
          <a href="{{ $contact_us->facebook }}"><i class="fab fa-facebook-square"></i></a>
          <a href="{{ $contact_us->twitter }}"><i class="fab fa-twitter"></i></a>
          <a href="{{ $contact_us->instagram }}"><i class="fab fa-instagram"></i></a>
        </div>
      </div>
      <!-- /.side-menu__content -->
    </div>
    <!-- /.side-menu__block-inner -->
  </div>
  <!-- /.side-menu__block -->

  <!--Search Popup-->
  <div class="search-popup">
    <div class="search-popup__overlay custom-cursor__overlay">
      <div class="cursor"></div>
      <div class="cursor-follower"></div>
    </div>
    <!-- /.search-popup__overlay -->
    <div class="search-popup__inner">
      <form action="#" class="search-popup__form">
        <input
          type="text"
          name="search"
          placeholder="Type here to Search...."
        />
        <button type="submit"><i class="fa fa-search"></i></button>
      </form>
    </div>
    <!-- /.search-popup__inner -->
  </div>
  <!-- /.search-popup -->
@else
<!-- Main Header -->
<header class="main-header header-style-one">
  <!-- Header Upper -->
  <div class="header-upper">
    <div class="inner-container clearfix">
      <!--Logo-->
      <div class="logo-box">
        <div class="logo">
          <a
            href="{{ route('home') }}"
            title="Digital Bond - Digital Marketing Agency"
            ><img
              src="/frontend/images/Logo-onBlack.png"
              id="thm-logo"
              alt="Digital Bond - Digital Marketing Agency"
              title="Digital Bond - Digital Marketing Agency"
              style="width: 150px; height: 75px !important;"
          /></a>
        </div>
      </div>
      <div class="nav-outer clearfix">
        <!--Mobile Navigation Toggler-->
        <div class="mobile-nav-toggler" style="padding-top: 20px;">
          <span class="icon flaticon-menu-2"></span
          ><span class="txt">Menu</span>
        </div>

        <!-- Main Menu -->
        <nav class="main-menu navbar-expand-md navbar-light" style="padding-top: 25px;">
          <div
            class="collapse navbar-collapse show clearfix"
            id="navbarSupportedContent"
          >
            <ul class="navigation clearfix">
              <li class="{{ request()->segment(2) === NULL ? 'current' : '' }}">
                <a href="{{ route('home') }}">الرئيسية</a>
              </li>
              <li class="{{ request()->segment(2) === 'about-us' ? 'current' : '' }}">
                <a href="{{ route('about-us') }}">من نحن</a>
              </li>
              <li class="{{ request()->segment(2) === 'services' ? 'current' : '' }} dropdown">
                <a href="{{ route('services') }}">الخدمات</a>
                <ul>
                  <li><a href="{{ route('services') }}">جميع الخدمات</a></li>
                  @foreach($services as $service)
                    <li>
                      <a href="{{ route('service', $service->ar_slug) }}">{{ $service->ar_title }}</a>
                    </li>
                  @endforeach
                </ul>
              </li>
              <li class="{{ request()->segment(2) === 'portfolio' ? 'current' : '' }}">
                <a href="{{ route('portfolio') }}">سابقة الاعمال</a>
              </li>
              <li class="{{ request()->segment(2) === 'blogs' ? 'current' : '' }}">
                <a href="{{ route('blogs') }}">الاخبار</a>
              </li>
              <li class="{{ request()->segment(2) === 'team' ? 'current' : '' }}">
                <a href="{{ route('team') }}">الفريق</a>
              </li>
              <li class="{{ request()->segment(2) === 'contact-us' ? 'current' : '' }}">
                <a href="{{ route('contact-us') }}">تواصل معنا</a>
              </li>
              <li class="">
                <a href="/en">English</a>
              </li>
            </ul>
          </div>
        </nav>
      </div>

      <div class="other-links clearfix" style="padding-top: 25px;">
        <!--Search Btn-->
        {{-- <div class="search-btn">
          <button type="button" class="theme-btn search-toggler">
            <span class="flaticon-loupe"></span>
          </button>
        </div> --}}
        <div class="link-box">
          <div class="call-us">
            <a class="link" href="tel:{{ $contact_us->phone }}">
              <span class="icon"></span>
              <span class="sub-text">اتصل في أي وقت</span>
              <span class="number">{{ $contact_us->phone }}</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--End Header Upper-->
</header>
<!-- End Main Header -->

<!--Mobile Menu-->
<div class="side-menu__block">
  <div class="side-menu__block-overlay custom-cursor__overlay">
    <div class="cursor"></div>
    <div class="cursor-follower"></div>
  </div>
  <!-- /.side-menu__block-overlay -->
  <div class="side-menu__block-inner">
    <div class="side-menu__top justify-content-end">
      <a href="#" class="side-menu__toggler side-menu__close-btn"
        ><img src="/frontend/images/icons/close-1-1.png" alt=""
      /></a>
    </div>
    <!-- /.side-menu__top -->

    <nav class="mobile-nav__container">
      <!-- content is loading via js -->
    </nav>
    <div class="side-menu__sep"></div>
    <!-- /.side-menu__sep -->
    <div class="side-menu__content">
      <p>
        {{ $about_us->ar_about_text }}
      </p>
      <p>
        <a href="mailto:{{ $contact_us->email }}">{{ $contact_us->email }} <span class="icon flaticon-email-2"></span></a>
        <br />
        <a href="tel:{{ $contact_us->phone }}">{{ $contact_us->phone }} <span class="icon flaticon-call" style="float: right; padding-left: 5px;"></span></a>
      </p>
      <div class="side-menu__social">
        <a href="{{ $contact_us->facebook }}" style="margin-left: 10px;"><i class="fab fa-facebook-square"></i></a>
        <a href="{{ $contact_us->twitter }}"><i class="fab fa-twitter"></i></a>
        <a href="{{ $contact_us->instagram }}"><i class="fab fa-instagram"></i></a>
      </div>
    </div>
    <!-- /.side-menu__content -->
  </div>
  <!-- /.side-menu__block-inner -->
</div>
<!-- /.side-menu__block -->

<!--Search Popup-->
<div class="search-popup">
  <div class="search-popup__overlay custom-cursor__overlay">
    <div class="cursor"></div>
    <div class="cursor-follower"></div>
  </div>
  <!-- /.search-popup__overlay -->
  <div class="search-popup__inner">
    <form action="#" class="search-popup__form">
      <input
        type="text"
        name="search"
        placeholder="اكتب هنا للبحث...."
      />
      <button type="submit"><i class="fa fa-search"></i></button>
    </form>
  </div>
  <!-- /.search-popup__inner -->
</div>
<!-- /.search-popup -->
@endif