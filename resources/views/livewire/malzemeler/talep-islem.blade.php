<div>

    @if($item_id)
    <div id="MalzemeFotoModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body m-0">
                    <div class="row">
                        <div class="col-lg-4">
                            <h5 class="text-danger">{{ $item->stock_name }}</h5>
                            <small>Stok Kodu : <b>{{ $item->stock_code }}</b> </small><br>
                            <small>Stok Tipi : <b>{{ $item->stock_type }}</b> </small><br>
                            <small>Stok Kartı : <b>{{ $item->cardtype_name }}</b> </small><br>
                            <small>Stok Miktarı : <b>@if($item->onhand_quantity > 0) {{ $item->onhand_quantity }} @else
                                    0 @endif </b> </small>
                            <hr>
                            <h5>Son Satınalma Tutarları</h5>
                            <small>1.500 X Adet ABC Ltd. 25.10.2021</small><br>
                            <small>1.400 X Adet</small><br>
                            <small>1.500 X Adet</small><br>
                            <small>1.600 X Adet</small><br>
                        </div>

                        @if($item_photos)
                        <div class="col-lg-8">
                            <div class="row ">
                                @foreach ($item_photos as $p)
                                <div class=" col-xxl-6 col-xl-6 col-sm-12">
                                    <img class=" img-fluid mx-auto border p-1 m-2"
                                        src="{{ asset('public/storage/images/items/'.$p->foto_path) }}">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (session()->has('success'))
    <span class="text-info">
        {{ session('success') }}
    </span>
    @endif

    @if (session()->has('error'))
    <span class="text-danger">
        {{ session('error') }}
    </span>
    @endif

    @if($talep_detay)

    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0 flex-grow-1">TALEP DETAYI <small>#{{ $talep->id }}</small></h4>
            <small>Açıklama : {{ $talep->demand_desc }}</small>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-light align-middle table-sm table-striped ">
                        <thead>
                            <tr>
                                <th scope="col" style="width:50px;">Foto</th>
                                <th scope="col">Malzeme</th>
                                <th scope="col">Talep </th>
                                <th scope="col">Stok</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($talep_detay as $dt)
                            @php
                            $photo = App\Models\LogoItemsPhoto::where('logo_stockref', $dt->logo_stock_ref)->first();
                            $item_detail = App\Models\LogoItems::find($dt->logo_stock_ref);
                            @endphp
                            <tr>
                                <td class="owner">
                                    @if($photo)
                                    <a href="javascript:;" wire:click="foto_goster({{ $dt->logo_stock_ref }})">
                                        <img class="border"
                                            src="{{ asset('public/storage/images/items/thumb/'.$photo->foto_path) }}"
                                            style="height: 65px">
                                    </a>
                                    @else
                                    <a href="javascript:;" wire:click="foto_goster({{ $dt->logo_stock_ref }})">
                                        <img class="border" style="height: 50px" src="/public/images/default.png">
                                    </a>
                                    @endif
                                </td>

                                <td><b>{{ $item_detail->stock_name }}</b>
                                    <br>
                                    <small>Stok Kodu: {{ $item_detail->stock_code }}</small>
                                    <br> <small class="text-danger">Talep Nedeni: {{ $dt->description }}</small>

                                </td>
                                <td class="text-dark"><b style="font-size:1.2em">{{
                                        number_format($dt->quantity,0,'.',',')
                                        }}</b>
                                    <br><small>{{ $dt->unit_code
                                        }}</small>
                                </td>
                                <td><b style="font-size:1.2em">{{
                                        number_format($item_detail->onhand_quantity,0,'.',',')
                                        }}</b>
                                    <br><small>{{ $dt->unit_code
                                        }}</small>
                                </td>


                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($talep_sarf_detay)
                <div class="col-lg-12">

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="p-3" style="background-color: rgb(242, 247, 242)">
                                <h5><b>Sarf Fişi Detayı</b></h5>
                                <table class="table border align-middle table-sm table-striped">
                                    <tbody>
                                        <tr>
                                            <th>Fiş No</th>
                                            <td>: {{ $talep_sarf_fisi->loagicalref }}</td>
                                        </tr>

                                        <tr>
                                            <th>Döküman No</th>
                                            <td>: {{ $talep_sarf_fisi->doc_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Depo</th>
                                            <td>: {{ $talep_sarf_fisi->warehouse }}</td>
                                        </tr>
                                        <tr>
                                            <th>Özel Kod</th>
                                            <td>: {{ $talep_sarf_fisi->special_code }}</td>
                                        </tr>
                                        <tr>
                                            <th>Fiş Zamanı</th>
                                            <td>: {{ $talep_sarf_fisi->consump_date }}</td>
                                        </tr>


                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="col-lg-8">
                            <div class="p-3" style="background-color: rgb(235, 255, 236)">
                                <h5><b>Sarf Fişi Malzemeleri</b></h5>
                                <table class="table border align-middle table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Stok No</th>
                                            <th scope="col">Malzeme</th>
                                            <th scope="col">Miktar</th>
                                            <th scope="col">Birim Tutar</th>
                                            <th scope="col">Toplam Tutar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($talep_sarf_detay as $d)
                                        <tr>
                                            <td>{{ $d->stock_code }}</td>
                                            <th>{{ $d->stock_name }}</th>
                                            <th>{{ number_format($d->amount,0,'.',',') }} {{ $d->unit_code }}</th>
                                            <td>{{ number_format($d->unit_price,2,'.',',') }} </td>
                                            <td>{{ number_format($d->total_price,2,'.',',') }} </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>

                                <button class="btn btn-sm btn-primary">Fişi Yazdır</button>
                            </div>

                        </div>


                    </div>
                    @endif

                </div>
            </div>
            @endif
        </div>

        <script>

        </script>