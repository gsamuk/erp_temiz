<!-- App Sidebar -->
<div class="modal fade panelbox panelbox-left" id="sidebarPanel" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">

                <!-- profile box -->
                <div class="profileBox bg-dark">
                    <div class="image-wrapper">
                        <img src="/mobile_assets/img/sample/avatar/avatar1.jpg" alt="image" class="imaged rounded">
                    </div>
                    <div class="in">
                        <strong>{{ Session::get('userData')->name }} {{ Session::get('userData')->surname }}</strong>
                    </div>
                    <a href="javascript:;" class="close-sidebar-button" data-dismiss="modal">
                        <ion-icon name="close"></ion-icon>
                    </a>
                </div>
                <!-- * profile box -->

                <ul class="listview flush transparent no-line image-listview mt-2">
                    <li>
                        <a href="/" class="item">
                            <div class="icon-box bg-secondary">
                                <ion-icon name="cube-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Ürünler
                            </div>
                        </a>
                    </li>


                    <li>
                        <a href="/duyurular" class="item">
                            <div class="icon-box bg-secondary">
                                <ion-icon name="pricetag-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Duyurular
                            </div>
                        </a>
                    </li>


                    <li>
                        <div class="item">
                            <div class="icon-box bg-secondary">
                                <ion-icon name="moon-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>Karanlık Mode</div>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input dark-mode-switch"
                                        id="darkmodesidebar">
                                    <label class="custom-control-label" for="darkmodesidebar"></label>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li>
                        <a href="/cikis" class="item">
                            <div class="icon-box bg-secondary">
                                <ion-icon name="log-out-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Çıkış
                            </div>
                        </a>
                    </li>



                </ul>



                <div class="listview-title mt-2 mb-1">
                    <span>Yönetici Menüsü</span>
                </div>

                <ul class="listview flush transparent no-line image-listview">

                    <li>
                        <a href="/kullanicilar" class="item">
                            <div class="icon-box bg-secondary">
                                <ion-icon name="person-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Kullanıcılar
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="/gruplar" class="item">
                            <div class="icon-box bg-secondary">
                                <ion-icon name="people-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Kullanıcı Grupları
                            </div>
                        </a>
                    </li>


                    <li>
                        <a href="/kategoriler" class="item">
                            <div class="icon-box bg-secondary">
                                <ion-icon name="cube-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Ürün Kategorileri
                            </div>
                        </a>
                    </li>
                </ul>


            </div>


        </div>
    </div>
</div>
<!-- * App Sidebar -->