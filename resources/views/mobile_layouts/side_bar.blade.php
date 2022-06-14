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
                        <small>Kullanıcı NO : {{ Session::get('userData')->id }}</small>
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
                                <ion-icon name="desktop-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Desktop Versiyon
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="/mobile" class="item">
                            <div class="icon-box bg-secondary">
                                <ion-icon name="home-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Ana Sayfa
                            </div>
                        </a>
                    </li>


                    <li>
                        <a href="/mobile/malzeme/talep_olustur" class="item">
                            <div class="icon-box bg-secondary">
                                <ion-icon name="add-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Talep Oluştur
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="/mobile/malzeme/talepler" class="item">
                            <div class="icon-box bg-secondary">
                                <ion-icon name="cube-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Talepleriniz
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

            </div>


        </div>
    </div>
</div>
<!-- * App Sidebar -->