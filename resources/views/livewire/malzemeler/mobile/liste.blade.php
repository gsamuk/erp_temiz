<div>
    <!-- App Capsule -->
    <div id="appCapsule">
        @if($malzeme)
        <!-- Modal Basic -->
        <div wire:ignore.self class="modal fade modalbox" id="MyModal" data-backdrop="static" tabindex="-1"
            role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-secondary text-light">
                        <h5 class="modal-title text-light"> Malzeme Detayı </h5>
                        <a href="javascript:;" data-dismiss="modal" class="btn btn-outline-light btn-sm">Kapat</a>
                    </div>

                    <div class="modal-body p-0">
                        <ul class="nav nav-tabs style1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tab_talep" role="tab">
                                    <ion-icon name="list" wire:ignore></ion-icon>
                                    Talep
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab_bilgi" role="tab">
                                    <ion-icon name="information-circle" wire:ignore></ion-icon>
                                    Bilgi
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#add_photo" role="tab">
                                    <ion-icon name="camera-sharp" wire:ignore></ion-icon>
                                    Fotoğraf
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#add_photo" role="tab">
                                    <ion-icon name="layers-sharp" wire:ignore></ion-icon>
                                    Stok
                                </a>
                            </li>


                        </ul>

                        <div class="tab-content p-0">
                            <div class="tab-pane fade show active p-2" id="tab_talep" role="tabpanel">

                                <b class="text-danger" style="font-weight: bolder;">{{ $malzeme->stock_name
                                    }}</b><br>
                                <small>Stok Kodu : {{ $malzeme->stock_code}}</small>
                                <form wire:submit.prevent="ekle()">
                                    <div class="row">
                                        <div class="col-6 mt-2">
                                            <div class="form-group m-0">
                                                <div class="input-wrapper">
                                                    <input type="number" wire:model="talep_miktar" class="form-control"
                                                        placeholder="Talep Miktarı Giriniz.">
                                                    <div class="input-info">Miktar</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6 mt-2">
                                            <div class="form-group">
                                                <div class="input-wrapper">

                                                    <select wire:model="malzeme_birim" class="form-control">
                                                        @if($malzeme_units)
                                                        @foreach($malzeme_units as $c)
                                                        <option value="{{$c->unit_code}}"> {{$c->unit_code}}
                                                        </option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                    <div class="input-info">Birim</div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-12">
                                            <div class="form-group m-0">
                                                <div class="input-wrapper">
                                                    <input type="text" wire:model="talep_neden" class="form-control">
                                                    <div class="input-info">Talep Nedeni</div>
                                                </div>
                                            </div>

                                            <div class="mt-2">
                                                <button type="submit" class="btn btn-primary">
                                                    <ion-icon name="add-circle" wire:ignore></ion-icon> Ekle
                                                </button>
                                                <br><br>
                                                <small>Dikkat: Talep Listesinizi oluşturduktan sonra göndermeniz
                                                    gereklidir.</small>
                                            </div>
                                        </div>
                                    </div>

                                </form>

                                @if($malzeme_photos)
                                <hr>
                                @foreach ($malzeme_photos as $p)
                                <img src="{{asset('public/storage/images/items/thumb/'.$p->foto_path)}}" alt="image"
                                    class="imaged border m-1" style="width:160px">
                                @endforeach
                                @endif

                            </div>

                            <div class="tab-pane fade p-2" id="tab_bilgi" role="tabpanel">
                                <b class="text-danger" style="font-weight: bolder;">{{ $malzeme->stock_name }}</b><br>
                                <small>Stok Kodu : {{ $malzeme->stock_code}}</small>
                                @if($malzeme_photos)
                                <hr>
                                @foreach ($malzeme_photos as $p)
                                <img src="{{asset('public/storage/images/items/thumb/'.$p->foto_path)}}" alt="image"
                                    class="imaged border m-1" style="width:160px">
                                @endforeach
                                @endif
                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- * Modal Basic -->
        @endif



        <!-- Modal Basic -->
        <div wire:ignore.self class="modal fade modalbox" id="TalepListModal" data-backdrop="static" tabindex="-1"
            role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-secondary text-light">
                        <h5 class="modal-title text-light"> Malzeme Talep Listeniz </h5>
                        <a href="javascript:;" data-dismiss="modal" class="btn btn-outline-light btn-sm">Kapat</a>
                    </div>

                    <div class="modal-body p-0 ">

                        <div class="section full mt-2 mb-2">
                            <div class="wide-block pb-1 pt-2">



                                <div class="form-group boxed">
                                    <div class="input-wrapper">

                                        <input type="email" wire:model="special_code" class="form-control input-sm"
                                            placeholder="Özel Kod Seç" data-toggle="modal" data-target="#KodRight">
                                        <i class="clear-input">
                                            <ion-icon name="close-circle"></ion-icon>
                                        </i>
                                    </div>
                                </div>

                                <div class="form-group boxed">
                                    @if($talep_listesi->count() > 0)


                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped  ">
                                            <thead>
                                                <tr>
                                                    <th scope="col" style="width:240px;">Malzeme</th>
                                                    <th scope="col">Miktar</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach($talep_listesi as $d)
                                                @php
                                                $item = App\Models\LogoItems::where('logicalref',
                                                $d->logo_stock_ref)->first();
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <span class="text-danger"><b>{{ $item->stock_name
                                                                }}</b></span>
                                                        <br>
                                                        <small> S.K : {{ $item->stock_code}} | Talep Nedeni : {{
                                                            $d->description}}</small>
                                                    </td>
                                                    <td>{{ number_format($d->quantity,0,',','.') }} <small>
                                                            {{$d->unit_code}}
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <button wire:click="sil({{ $d->id }})"
                                                            class="btn btn-sm btn-link "> X
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <hr>
                                        <div class="p-1">
                                            <button wire:click="talep_ekle();" class="btn btn-success">Talebi
                                                Gönder</button>
                                            <div><small>Malzeme Talep Listenizi göndermeden önce ekleme çıkarma
                                                    yapabilirsiniz.</small></div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="alert alert-info m-2" role="alert">
                                        Talep Listeniz Boş.
                                    </div>
                                    @endif

                                </div>



                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
        <!-- * Modal Basic -->



        <!-- Panel Right -->
        <div class="modal fade panelbox panelbox-right" id="PanelRight" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-secondary text-light">
                        <h4 class="modal-title text-light">Malzeme Filtrele</h4>
                        <a href="javascript:;" data-dismiss="modal" class="btn btn-outline-light btn-sm">Kapat</a>
                    </div>
                    <div class="modal-body">
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="city4">Malzeme Tipi</label>
                                <select wire:model="slc_item_type" class="form-control custom-select  mt-1"
                                    onChange="$('.modal').modal('hide');">
                                    <option value=""> Hepsini Göster</option>
                                    @foreach($item_type as $d)
                                    @if($d)
                                    <option value="{{ $d->cardtype_name }}">{{ $d->cardtype_name }}</option>
                                    @endif
                                    @endforeach

                                </select>
                            </div>
                        </div>


                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="city4">Kart Tipi</label>
                                <select wire:model="slc_stock_type" class="form-control custom-select  mt-1"
                                    onChange="$('.modal').modal('hide');">
                                    <option value=""> Hepsini Göster</option>
                                    @foreach($stock_type as $d)
                                    @if(!empty($d))
                                    <option value="{{ $d->stock_type }}">{{ $d->stock_type }}</option>
                                    @endif
                                    @endforeach

                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- * Panel Right -->

        <!-- Panel Right -->
        <div class="modal fade panelbox panelbox-right" id="KodRight" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-secondary text-light">
                        <h4 class="modal-title text-light">Özel Kod Seç</h4>
                        <a href="javascript:;" data-dismiss="modal" class="btn btn-outline-light btn-sm">Kapat</a>
                    </div>
                    <div class="modal-body p-0 ">
                        @livewire('malzemeler.mobile.ozel-kodlar')
                    </div>
                </div>
            </div>
        </div>
        <!-- * Panel Right -->


        <div class="extraHeader">
            <form class="search-form">
                <div class="form-group searchbox">
                    <div>
                        <input type="text" class="form-control" placeholder="Malzeme Ara..."
                            wire:model.debunce.1000ms="search">
                        <i class="input-icon">
                            <ion-icon name="search-outline" wire:ignore>
                            </ion-icon>
                        </i>
                    </div>

                    <div>
                        <input type="text" class="form-control ml-1" placeholder="Stok Kodu Ara..."
                            wire:model.debunce.1000ms="search_stock_code">
                        <i class="input-icon">
                            <ion-icon name="search-outline" wire:ignore>
                            </ion-icon>
                        </i>
                    </div>

                </div>
            </form>
        </div>

        <div class="listview-title" style="margin-top:60px">

            <b style="font-size:1.3em">Malzemeler</b>
            <div style="justify-content: flex-end;">
                @if($talep_listesi->count() > 0)
                <span class="badge badge-warning" style="margin-right:-10px; position: relative;">{{
                    $talep_listesi->count() }}</span>
                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#TalepListModal">
                    <ion-icon name="list" wire:ignore></ion-icon>
                    Talepler
                </a>
                @endif
                <a href="#" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#PanelRight">
                    <ion-icon name="filter" wire:ignore></ion-icon>
                </a>
            </div>
        </div>

        @if($slc_stock_type || $slc_item_type || $search || $search_stock_code )
        <div class="wide-block pt-1 pb-1">
            <div class="chip chip-outline">
                <span class="chip-label">Filtre</span>
            </div>

            @if($search)
            <div class="chip chip-primary ">
                <span class="chip-label">Arama : {{ $search }}</span>
            </div>
            @endif

            @if($search_stock_code)
            <div class="chip chip-primary ">
                <span class="chip-label">SKU : {{ $search_stock_code }}</span>
            </div>
            @endif

            @if($slc_stock_type)
            <div class="chip chip-primary ">
                <span class="chip-label">{{ $slc_stock_type }}</span>
            </div>
            @endif

            @if($slc_item_type)
            <div class="chip chip-primary ">
                <span class="chip-label">{{ $slc_item_type }}</span>
            </div>
            @endif
        </div>
        @endif


        <ul class="listview image-listview media mt-1  ">
            @foreach ($malzemeler as $m)
            @php
            $photo = App\Models\LogoItemsPhoto::where('logo_stockref', $m->logicalref)->first();
            @endphp

            <li style="background-color: aliceblue">
                <a href="javascript:;" class="item p-0" wire:click="getMalzeme({{$m->stock_code}})">
                    <div class="m-1">
                        @if($photo)
                        <img src="{{ asset('public/storage/images/items/thumb/'.$photo->foto_path) }}"
                            class="border imaged w48">
                        @else
                        <img src="/mobile_assets/img/sample/photo/2.jpg" class="border imaged w48">
                        @endif
                    </div>
                    <div class="in">
                        <div>
                            <b style="font-size:0.9em;">{{ $m->stock_name }}</b>
                            <div class="text-muted">SKU : <b>{{ $m->stock_code }}</b> </div>
                        </div>
                    </div>
                </a>
            </li>
            @endforeach
        </ul>



        <div class="d-flex  ml-1 mb-2 mt-2">
            @if($malzemeler->hasMorePages())
            <button class="btn btn-text-primary shadowed mr-1 mb-1" wire:click.prevent="loadMore">
                <ion-icon name="menu" wire:ignore></ion-icon> Devamını
                Yükle
            </button>
            @if($nfc_btn)
            <button id="scanButton" @if($nfc_active) disabled @endif class="btn btn-success">
                @if($nfc_active)
                <ion-icon name="scan" wire:ignore></ion-icon> NFC SCAN Aktif @else <ion-icon name="scan" wire:ignore>
                </ion-icon> NFC SCAN @endif
            </button>
            @endif
            @endif

            <div wire:loading.table>
                <div class="spinner-grow text-primary" role="status">
                </div>
            </div>
        </div>



        <div id="toast-11" class="toast-box toast-center bg-warning ">
            <div class="in">
                <img src="/mobile_assets/img/nfc_touch.png" style="width: 150px;">
                <div class="text">
                    Lütfen Malzeme Etiketine Dokundurun
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-text-light close-button">Kapat</button>
        </div>



    </div>
    <script>
        scanButton.addEventListener("click", async () => {
            toastbox('toast-11');  
        try {
            const ndef = new NDEFReader();
            await ndef.scan();           
            
            @this.nfc_active = true;
            ndef.onreading = event => {
            const message = event.message;
            for (const record of message.records) {              
                switch (record.recordType) {
                case "text":
                    
                    const decoder = new TextDecoder(record.encoding);
                    SKU = decoder.decode(record.data);
                    @this.getMalzeme(SKU);                  
                    break;              

                default:                    
                }
             }
            };

            } catch (error) {
                alert("Argh! " + error);
             }
        });    

        document.addEventListener('livewire:load', function () {            
            if (!("NDEFReader" in window)){
                @this.nfc_btn = false;
            }
         });       
         
         

    </script>

</div>