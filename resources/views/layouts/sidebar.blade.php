<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="/" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('assets/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="/" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('assets/images/logo-light.png') }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>@lang('translation.menu')</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="widgets">
                        <i class="mdi mdi-puzzle-outline"></i> <span>DashBoard</span>
                    </a>
                </li>


                @if(Session::get('userData')->purchase_view == 1)
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#m1" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarMaps">
                        <i class="ri-map-pin-line"></i> <span>Satın Alma</span>
                    </a>
                    <div class="collapse menu-dropdown" id="m1">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-key="t-google">
                                    Satın Alma Oluştur
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-key="t-google">
                                    Satın Onay Durum
                                </a>
                            </li>


                            @if(Session::get('userData')->purchase_approve == 1)
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#">
                                    <span>Purchase Approve</span>
                                </a>
                            </li>
                            @endif


                        </ul>
                    </div>
                </li>
                @endif






                @if(Session::get('userData')->sale_view == 1)
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#m2" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarMaps">
                        <i class="ri-map-pin-line"></i> <span>Satış </span>
                    </a>
                    <div class="collapse menu-dropdown" id="m2">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-key="t-google">
                                    Satış Oluştur
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-key="t-google">
                                    Satış Onay Durum
                                </a>
                            </li>
                            @if(Session::get('userData')->sale_approve == 1)
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#">
                                    <span>Sale Approve</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link menu-link" href="/signout">
                        <i class="mdi mdi-puzzle-outline"></i> <span>Çıkış</span>
                    </a>
                </li>


                @if(Session::get('userData')->is_admin == 1)

                <li class="menu-title"><i class="ri-more-fill"></i> <span>Admin Yetki Alanı</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarMaps" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarMaps">
                        <i class="ri-map-pin-line"></i> <span>Yönetim</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarMaps">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('users'); }}" class="nav-link" data-key="t-google">
                                    Kullanıcı Yönetimi
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-key="t-vector">
                                    Ayarlar
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                @endif
            </ul>



        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>