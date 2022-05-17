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
                            <small>Stok Kodu : <b>{{ $item->stock_code }}</b> </small>
                        </div>

                        <div class="col-lg-8">
                            <div class="row ">
                                @foreach ($item_photos as $p)
                                <div class=" col-xxl-6 col-xl-6 col-sm-12">
                                    <img class=" img-fluid mx-auto border p-1 m-2"
                                        src="{{ asset('storage/images/items/'.$p->foto_path) }}">
                                </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($talep_detay)

    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0 flex-grow-1">TALEP DETAYI</h4>
            <span>Talep No : {{ $talep_id }} </span>

        </div>

        <div class="card-body">
            <table class="table table-success align-middle   table-sm table-striped">
                <thead>
                    <tr>
                        <th scope="col" style="width:60px;">Foto</th>
                        <th scope="col">Malzeme</th>
                        <th scope="col">Talep Miktarı</th>
                        <th scope="col">Mevcut Stok</th>
                        <th scope="col" style="width:120px;">Karşılanan</th>
                        <th scope="col" style="width:120px;">Satınalma</th>
                        <th scope="col"></th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($talep_detay as $dt)
                    @php
                    $photo = App\Models\LogoItemsPhoto::where('logo_stockref', $dt->logo_stock_ref)->first();
                    $item_detail = App\Models\LogoItems::find($dt->logo_stock_ref);
                    $val = 0;
                    $val2 = 0;

                    if($dt->quantity <= $item_detail->onhand_quantity){
                        $val = number_format($dt->quantity,0,'.',',');
                        }

                        @endphp
                        <tr>
                            <td class="owner">
                                @if($photo)
                                <a href="javascript:;" wire:click="foto_goster({{ $dt->logo_stock_ref }})">
                                    <img class="border"
                                        src="{{ asset('storage/images/items/thumb/'.$photo->foto_path) }}"
                                        style="width: 60px">
                                </a>
                                @else
                                <img class="border" style="width: 60px" src="/images/default.png">
                                @endif
                            </td>

                            <td><b>{{ $item_detail->stock_name }}</b>
                                <br> <small>Stok Kodu: {{ $item_detail->stock_code
                                    }}</small>
                                <br> <small class="text-danger">Talep Nedeni: {{ $dt->description
                                    }}</small>
                            </td>
                            <td class="text-dark"><b style="font-size:1.5em">{{
                                    number_format($dt->quantity,0,'.',',')
                                    }}</b>
                                <br><small>{{ $dt->unit_code
                                    }}</small>
                            </td>
                            <td><b style="font-size:1.5em">{{ number_format($item_detail->onhand_quantity,0,'.',',')
                                    }}</b></td>

                            <td><input type="number" value="{{ $val }}" class="form-control">
                            </td>

                            <td><input type="number" value="{{ $val2 }}" class="form-control">
                            </td>

                            <td><button class="btn btn-success"> Ekle</button></td>


                        </tr>
                        @endforeach
                </tbody>
            </table>


        </div>
    </div>
    @endif
</div>