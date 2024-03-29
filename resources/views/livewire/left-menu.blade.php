<div>
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
      <button type="button" class="btn btn-sm fs-20 header-item float-end btn-vertical-sm-hover p-0"
              id="vertical-hover">
        <i class="ri-record-circle-line"></i>
      </button>
    </div>

    <div id="scrollbar">
      <div class="container-fluid">


        <ul class="navbar-nav" id="navbar-nav">
          <li class="menu-title"><span>@lang('translation.menu')</span></li>


          <li class="nav-item">
            <a class="nav-link menu-link" href="#" wire:click="$emit('SetPage', '')">
              <i class="ri-dashboard-line"></i> <span>Hızlı Erişim</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link menu-link" href="#m3" data-bs-toggle="collapse" role="button"
               aria-expanded="true" aria-controls="m3">
              <i class="ri-stack-line"></i> <span>Malzeme Yönetimi</span>
            </a>
            <div class="collapse menu-dropdown" id="m3">
              <ul class="nav nav-sm flex-column">

                @if (Erp::izin('items_list'))
                  <li class="nav-item">
                    <a href="javascript:;" wire:click="$emit('SetPage', 'malzemeler.liste')"
                       class="nav-link" data-key="t-google">
                      Malzeme Listesi
                    </a>
                  </li>
                @endif

                @if (Erp::izin('items_create'))
                  <li class="nav-item">
                    <a href="#" wire:click="$emit('SetPage', 'malzemeler.ekle')" class="nav-link"
                       data-key="t-google">
                      Malzeme Ekle
                    </a>
                  </li>
                @endif

                @if (Erp::izin('items_create'))
                  <li class="nav-item">
                    <a href="#" wire:click="$emit('SetPage', 'malzemeler.fotograf')" class="nav-link"
                       data-key="t-google">
                      Fotoğraf Yükle
                    </a>
                  </li>
                @endif

                @if (Erp::izin('items_reports'))
                  <li class="nav-item">
                    <a href="#sidebarCrm_" class="nav-link" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="sidebarCrm_" data-key="t-level-2.2">
                      Malzeme Raporları
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
            <a class="nav-link menu-link" href="#m3" data-bs-toggle="collapse" role="button"
               aria-expanded="true" aria-controls="m3">
              <i class="ri-survey-line"></i> <span>Talep Yönetimi</span>
            </a>
            <div class="collapse menu-dropdown" id="m3">
              <ul class="nav nav-sm flex-column">

                @if (Erp::izin('items_demand'))
                  <li class="nav-item">
                    <a href="#" wire:click="$emit('SetPage', 'malzemeler.talep-listesi')"
                       class="nav-link" data-key="t-level-3.1">
                      Talep Listesi
                    </a>
                  </li>
                @endif

                @if (Erp::izin('items_demand_manage'))
                  <li class="nav-item">
                    <a href="#" wire:click="$emit('SetPage', 'malzemeler.talep-malzeme-onay')"
                       class="nav-link" data-key="t-level-3.1">
                      Malzeme Onay
                    </a>
                  </li>
                @endif


                <li class="nav-item">
                  <a href="#" wire:click="$emit('SetPage', 'malzemeler.taleplerim')"
                     class="nav-link" data-key="t-level-3.2">
                    Taleplerim
                  </a>
                </li>

                <li class="nav-item">
                  <a href="#" class="nav-link"
                     wire:click="$emit('SetPage', 'malzemeler.talep-olustur')"
                     data-key="t-level-3.2">
                    Talep Oluştur
                  </a>
                </li>



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
                  <a href="#"
                     class="nav-link" data-key="t-google">
                    Sipariş Oluştur
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
                  <a href="#" wire:click="$emit('SetPage', 'kantar.file-upload')" class="nav-link"
                     data-key="t-google">
                    Kantar Raporu Yükle
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" wire:click="$emit('SetPage', 'kantar.cariler')" class="nav-link"
                     data-key="t-google">
                    Cari Bakiye Durum
                  </a>
                </li>



              </ul>
            </div>
          </li>




          @if (Erp::izin('is_admin'))
            <li class="menu-title"><i class="ri-more-fill"></i> <span>Admin Yetki Alanı</span></li>

            <li class="nav-item">
              <a class="nav-link menu-link" href="#sidebarMaps" data-bs-toggle="collapse" role="button"
                 aria-expanded="false" aria-controls="sidebarMaps">
                <i class="ri-settings-5-line"></i> <span>Kontrol Paneli</span>
              </a>
              <div class="collapse menu-dropdown" id="sidebarMaps">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="#" wire:click="$emit('SetPage', 'users.liste')" class="nav-link"
                       data-key="t-google">
                      Kullanıcı Yönetimi
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="#" class="nav-link" data-key="t-google">
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
</div>
