<header id="page-topbar">
  <div class="layout-width">
    <div class="navbar-header">
      <div class="d-flex">
        <!-- LOGO -->
        <div class="navbar-brand-box horizontal-logo">
          <a href="/" class="logo logo-dark">
            <span class="logo-sm">
              <img src="{{ URL::asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
              <img src="{{ URL::asset('assets/images/logo_light.jpg') }}" alt="" height="50">
            </span>
          </a>

          <a href="/" class="logo logo-light">
            <span class="logo-sm">
              <img src="{{ URL::asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
              <img src="{{ URL::asset('assets/images/logo-light.png') }}" alt="" height="17">
            </span>
          </a>
        </div>

        <button type="button" class="btn btn-sm fs-16 header-item vertical-menu-btn topnav-hamburger px-3"
                id="topnav-hamburger-icon">
          <span class="hamburger-icon">
            <span></span>
            <span></span>
            <span></span>
          </span>
        </button>

        <!-- App Search
                <form class="app-search d-none d-md-block">
                    <div class="position-relative">
                        <input type="text" class="form-control" placeholder="Menü Arama..." autocomplete="off"
                            id="search-options" value="">
                        <span class="mdi mdi-magnify search-widget-icon"></span>
                        <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none"
                            id="search-close-options"></span>
                    </div>

                </form>
                -->
      </div>


      <div class="d-flex align-items-center">

        <div class="dropdown ms-sm-3 header-item topbar-user">
          <button type="button" class="btn shadow-none" id="page-header-user-dropdown"
                  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="d-flex align-items-center">
              <img class="rounded-circle header-profile-user"
                   src="{{ URL::asset('assets/images/users/avatar-3.jpg') }}" alt="Header Avatar">
              <span class="text-start ms-xl-2">
                <span
                      class="d-none d-xl-inline-block ms-1 fw-medium text-primary user-name-text">{{ Session::get('userData')->name }}
                  {{ Session::get('userData')->surname }}</span>

                <span class="d-none d-xl-block ms-1 fs-12 text-success">
                  {{ Session::get('secili_firma_adi') }}
                </span>
              </span>
            </span>
          </button>
          <div class="dropdown-menu dropdown-menu-end">
            <!-- item-->
            <h6 class="dropdown-header">Hoşgeldin {{ Session::get('userData')->name }}</h6>

            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#firma_secModal"><i
                 class="mdi mdi-store-outline text-muted fs-16 me-1 align-middle"></i> <span
                    class="align-middle">Firma Seç</span></a>
            <a class="dropdown-item" href="/signout"><i
                 class="ri-logout-box-r-line text-muted fs-16 me-1 align-middle"></i> <span
                    class="align-middle">Çıkış</span></a>
          </div>
        </div>

      </div>

    </div>
  </div>
</header>
