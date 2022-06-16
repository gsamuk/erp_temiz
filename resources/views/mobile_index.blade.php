@extends('mobile_layouts.master')

@section('content')

<!-- App Capsule -->
<div id="appCapsule">



    <div class="section full mt-1 mb-2">
        <div class="section-title">Menü</div>

        <div class="wide-block p-0">

            <div class="justify-content-center">
                <!-- Iconed Multi Listview -->

                <ul class="listview image-listview">



                    <li class="multi-level">
                        <a href="#" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="duplicate-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>Talep Oluştur</div>
                            </div>
                        </a>
                        <!-- sub menu -->
                        <ul class="listview image-listview">
                            <li>
                                <a href="/mobile/malzeme/talep_olustur" class="item">
                                    <div class="icon-box bg-dark">
                                        <ion-icon name="add-outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div>Malzeme Talebi

                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="item">
                                    <div class="icon-box bg-secondary">
                                        <ion-icon name="add-outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div> Araç Talebi
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="item">
                                    <div class="icon-box bg-danger">
                                        <ion-icon name="add-outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div>İzin Talebi

                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <!-- * sub menu -->
                    </li>





                    <li class="multi-level">
                        <a href="#" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="cube-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>Arıza Bildirim</div>
                            </div>
                        </a>
                        <!-- sub menu -->
                        <ul class="listview image-listview">
                            <li>
                                <a href="#" class="item">
                                    <div class="icon-box bg-dark">
                                        <ion-icon name="add-outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div>Arıza Bildirimi Gönder

                                        </div>
                                    </div>
                                </a>
                            </li>

                        </ul>
                        <!-- * sub menu -->
                    </li>

                    <li class="multi-level">
                        <a href="#" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="cube-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>Depo Sayım</div>
                            </div>
                        </a>
                        <!-- sub menu -->
                        <ul class="listview image-listview">
                            <li>
                                <a href="#" class="item">
                                    <div class="icon-box bg-dark">
                                        <ion-icon name="add-outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div>Sayım Başlat

                                        </div>
                                    </div>
                                </a>
                            </li>

                        </ul>
                        <!-- * sub menu -->
                    </li>
                </ul>
                <!-- * Iconed Multi Listview -->
            </div>


        </div>
    </div>

    @endsection