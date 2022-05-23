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
                <img src="{{ URL::asset('assets/images/logo-dark.png') }}" alt="" height="29">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="/" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('assets/images/dark_logo.png') }}" alt="" height="29">
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
                    <a class="nav-link menu-link" href="/">
                        <i class="ri-dashboard-line"></i> <span>DashBoard</span>
                    </a>
                </li>





                <li class="nav-item">
                    <a class="nav-link menu-link" href="#m3" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarMaps">
                        <i class="ri-stack-line"></i> <span>Malzeme Yönetimi </span>
                    </a>
                    <div class="collapse menu-dropdown" id="m3">
                        <ul class="nav nav-sm flex-column">
                            @if(Erp::izin('items_list'))
                            <li class="nav-item">
                                <a href="{{ route('malzemeler') }}" class="nav-link" data-key="t-google">
                                    Malzeme Listesi
                                </a>
                            </li>
                            @endif

                            @if(Erp::izin('items_create'))
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-key="t-google">
                                    Malzeme Ekle
                                </a>
                            </li>
                            @endif

                            <li class="nav-item">
                                <a href="#sidebarCrm" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarCrm" data-key="t-level-2.2"> Malzeme
                                    Talepleri
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarCrm">
                                    <ul class="nav nav-sm flex-column">
                                        @if(Erp::izin('items_demand'))
                                        <li class="nav-item">
                                            <a href="{{ route('malzeme.talep_listesi') }}" class="nav-link"
                                                data-key="t-level-3.1">
                                                Talep Listesi
                                                <span class="badge badge-pill bg-danger" data-key="t-new">8</span>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ route('malzeme.talep_olustur') }}" class="nav-link"
                                                data-key="t-level-3.2">
                                                Talep Oluştur
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </li>

                            @if(Erp::izin('items_reports'))
                            <li class="nav-item">
                                <a href="#sidebarCrm_" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarCrm_" data-key="t-level-2.2"> Malzeme
                                    Raporları
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarCrm_">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">

                                            <a href="#" class="nav-link" data-key="t-google">
                                                Ambar Durum Raporu
                                            </a>


                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link" data-key="t-google">
                                                Minumum Stok Raporu
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            @endif




                        </ul>
                    </div>
                </li>




                <li class="nav-item">
                    <a class="nav-link menu-link" href="#m1" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarMaps">
                        <i class="ri-shopping-basket-line"></i> <span>Satınalma Yönetimi</span>
                    </a>
                    <div class="collapse menu-dropdown" id="m1">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('satinalma.siparis_olustur') }}" class="nav-link" data-key="t-google">
                                    Sipariş Oluştur
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('satinalma.siparis') }}" class="nav-link" data-key="t-google">
                                    Siparişler
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('satinalma.irsaliye') }}" class="nav-link" data-key="t-google">
                                    İrsaliyeler
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('satinalma.fatura') }}" class="nav-link" data-key="t-google">
                                    Faturalar
                                </a>
                            </li>
                            @if(Session::get('userData')->purchase_approve == 1)
                            <li class="nav-item">
                                <a href="{{ route('satinalma.onay') }}" class="nav-link" data-key="t-google">
                                    Onay Bekleyenler
                                    <span class="badge badge-pill bg-danger" data-key="t-new">8</span>
                                </a>
                            </li>
                            @endif

                            <li class="nav-item">
                                <a href="{{ route('satinalma.fatura') }}" class="nav-link" data-key="t-google">
                                    Satın Alma Talepleri
                                    <span class="badge badge-pill bg-success" data-key="t-new">5</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>


                <li class="nav-item">
                    <a class="nav-link menu-link" href="#m2" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarMaps">
                        <i class="ri-money-dollar-circle-line"></i> <span>Satış Yönetimi</span>
                    </a>
                    <div class="collapse menu-dropdown" id="m2">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-key="t-google">
                                    Siparişler
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-key="t-google">
                                    İrsaliyeler
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link" data-key="t-google">
                                    Faturalar
                                </a>
                            </li>

                            @if(Session::get('userData')->sale_approve == 1)
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#">
                                    <span>Onay Bekleyenler</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>



                <li class="nav-item">
                    <a class="nav-link menu-link" href="#m4" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarMaps">
                        <i class="ri-user-2-line"></i> <span>Yönetim Raporları </span>
                    </a>
                    <div class="collapse menu-dropdown" id="m4">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-key="t-google">
                                    Stok Durum Raporu
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-key="t-google">
                                    Cari Hesap Durum Raporu
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link" data-key="t-google">
                                    Satış Raporu
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link" data-key="t-google">
                                    Özel Rapor 1
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link" data-key="t-google">
                                    Özel Rapor 2
                                </a>
                            </li>


                        </ul>
                    </div>
                </li>




                <li class="nav-item">
                    <a class="nav-link menu-link" href="/signout">
                        <i class="ri-login-box-line"></i> <span>Çıkış</span>
                    </a>
                </li>

                @if(Erp::izin('is_admin'))

                <li class="menu-title"><i class="ri-more-fill"></i> <span>Admin Yetki Alanı</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarMaps" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarMaps">
                        <i class="ri-settings-5-line"></i> <span>Kontrol Paneli</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarMaps">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('users'); }}" class="nav-link" data-key="t-google">
                                    Kullanıcı Yönetimi
                                </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{ route('users'); }}" class="nav-link" data-key="t-google">
                                    Log Kayıtları
                                </a>
                            </li>


                            <li class="nav-item">
                                <a href="#" class="nav-link" data-key="t-vector">
                                    Genel Ayarlar
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