@extends('mobile_layouts.master')

@section('content')

<!-- App Capsule -->
<div id="appCapsule">



    <div class="section full mt-1 mb-2">
        <div class="section-title">Menü</div>

        <div class="wide-block p-0">

            <div class="justify-content-center">
                <table class="table table-bordered">
                    <tbody>
                        <tr>

                            <td class="text-center">
                                <a href="/mobile/malzeme/talep_olustur">
                                    <span class="iconedbox iconedbox-lg text-primary">
                                        <ion-icon name="add-circle"></ion-icon>
                                    </span>
                                    <h4> <strong>Talep Ekle</strong></h4>
                                </a>
                            </td>

                            <td class="text-center">
                                <a href="/mobile/malzeme/talepler">
                                    <span class="iconedbox iconedbox-lg text-primary">
                                        <ion-icon name="dice"></ion-icon>
                                    </span>
                                    <h4> Talep Listeniz</h4>
                                </a>
                            </td>


                            <td class="text-center">
                                <a href="#">
                                    <span class="iconedbox iconedbox-lg text-primary">
                                        <ion-icon name="notifications"></ion-icon>
                                    </span>
                                    <h4> Duyurular</h4>
                                </a>
                            </td>

                        </tr>



                    </tbody>
                </table>
            </div>


        </div>
    </div>

    @endsection