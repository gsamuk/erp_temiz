<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('assets/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index" class="logo logo-light">
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
                    <a class="nav-link menu-link" href="/signout">
                        <i class="mdi mdi-sticker-text-outline"></i> <span>Purchase</span>
                    </a>
                </li>
                @endif


                @if(Session::get('userData')->sale_view == 1)
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/signout">
                        <i class="mdi mdi-sticker-text-outline"></i> <span>Sale</span>
                    </a>
                </li>
                @endif


                @if(Session::get('userData')->purchase_approve == 1)
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/signout">
                        <i class="mdi mdi-sticker-text-outline"></i> <span>Purchase Approve</span>
                    </a>
                </li>
                @endif


                @if(Session::get('userData')->sale_approve == 1)
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/signout">
                        <i class="mdi mdi-sticker-text-outline"></i> <span>Sale Approve</span>
                    </a>
                </li>
                @endif


                <li class="nav-item">
                    <a class="nav-link menu-link" href="/signout">
                        <i class="mdi mdi-puzzle-outline"></i> <span>Çıkış</span>
                    </a>
                </li>


                <li class="menu-title"><i class="ri-more-fill"></i> <span>@lang('translation.components')</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarMaps" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarMaps">
                        <i class="ri-map-pin-line"></i> <span>@lang('translation.maps')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarMaps">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="maps-google" class="nav-link" data-key="t-google">
                                    Google
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="maps-vector" class="nav-link" data-key="t-vector">
                                    Vector
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="maps-leaflet" class="nav-link" data-key="t-leaflet">
                                    Leaflet
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>