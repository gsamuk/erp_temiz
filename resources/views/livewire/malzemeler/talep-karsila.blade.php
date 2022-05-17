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
            <h4 class="card-title mb-0 flex-grow-1">TALEP DETAYI <small>#{{ $talep_id }}</small></h4>


        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-lg-7">
                    <table class="table table-info align-middle table-sm table-striped ">
                        <thead>
                            <tr>

                                <th scope="col" style="width:50px;">Foto</th>
                                <th scope="col">Malzeme</th>
                                <th scope="col">Talep </th>
                                <th scope="col">Stok</th>
                                <th scope="col" style="width:90px;">Karşılanan</th>
                                <th scope="col" style="width:90px;">Satınalma</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($talep_detay as $dt)
                            @php
                            $photo = App\Models\LogoItemsPhoto::where('logo_stockref', $dt->logo_stock_ref)->first();
                            $item_detail = App\Models\LogoItems::find($dt->logo_stock_ref);
                            $val = 0;
                            $val2 = 0;

                            if($item_detail->onhand_quantity >= $dt->quantity){
                            $val = $dt->quantity;
                            }

                            if($item_detail->onhand_quantity < $dt->quantity){
                                $val = $item_detail->onhand_quantity;
                                $val2 = $dt->quantity - $item_detail->onhand_quantity;
                                }

                                if($item_detail->onhand_quantity == 0){
                                $val = 0;
                                $val2 = $dt->quantity;
                                }

                                @endphp
                                <tr>

                                    <td class="owner">
                                        @if($photo)
                                        <a href="javascript:;" wire:click="foto_goster({{ $dt->logo_stock_ref }})">
                                            <img class="border"
                                                src="{{ asset('storage/images/items/thumb/'.$photo->foto_path) }}"
                                                style="height: 65px">
                                        </a>
                                        @else
                                        <img class="border" style="height: 50px" src="/images/default.png">
                                        @endif
                                    </td>

                                    <td><b>{{ $item_detail->stock_name }}</b>
                                        <br> <small>Stok Kodu: {{ $item_detail->stock_code
                                            }}</small>
                                        <br> <small class="text-danger">Talep Nedeni: {{ $dt->description
                                            }}</small>
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

                                    <td>
                                        <input type="hidden" x-data
                                            x-init="@this.set('talep_line.{{ $dt->demand_id }}.{{ $dt->id }}', '{{ $item_detail }}')">

                                        <input type="number" wire:model="karsila.{{ $dt->demand_id }}.{{ $dt->id }}"
                                            x-data
                                            x-init="@this.set('karsila.{{ $dt->demand_id }}.{{ $dt->id }}', '{{ number_format($val,0,'.',',') }}')"
                                            class="form-control">
                                    </td>

                                    <td><input type="number" wire:model="satinal.{{ $dt->demand_id }}.{{ $dt->id }}"
                                            x-init="@this.set('satinal.{{ $dt->demand_id }}.{{ $dt->id }}', '{{ number_format($val2,0,'.',',') }}')"
                                            class="form-control">
                                    </td>




                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="col-lg-5">
                    <div class="row">


                        <div class="col-lg-12">
                            <div class="p-3" style="background-color: rgb(235, 255, 236)">
                                @if(isset($karsila))
                                @if(isset($karsila[$talep_id]))
                                <h5><b>Stoktan Karşılama Listesi</b></h5>
                                <table class="table border align-middle table-sm table-striped">
                                    <thead class="table-success">
                                        <tr>
                                            <th scope="col">Kodu</th>
                                            <th scope="col">Malzeme</th>
                                            <th scope="col">Miktar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($karsila[$talep_id] as $item_id => $miktar)
                                        @if($miktar > 0)
                                        @php
                                        $itm = json_decode($talep_line[$talep_id][$item_id]);
                                        @endphp
                                        <tr>
                                            <th scope="row">{{ $itm->stock_code }} </th>
                                            <td>{{ $itm->stock_name }} </td>
                                            <td>{{ $miktar }} </td>
                                        </tr>
                                        @endif
                                        @endforeach

                                        @endif
                                    </tbody>
                                </table>
                                @endif
                            </div>
                        </div>




                        <div class="col-lg-12 mt-3">
                            <div class="p-3" style="background-color: rgb(255, 250, 201)">
                                @if(isset($satinal))
                                @if(isset($satinal[$talep_id]))
                                <h5><b>Satın Alma Listesi</b></h5>
                                <table class="table border align-middle table-sm table-striped ">
                                    <thead class="table-warning">
                                        <tr>
                                            <th scope="col">Kodu</th>
                                            <th scope="col">Malzeme</th>
                                            <th scope="col">Miktar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($satinal[$talep_id] as $item_id => $miktar)
                                        @if($miktar > 0)
                                        @php
                                        $itm = json_decode($talep_line[$talep_id][$item_id]);
                                        @endphp
                                        <tr>
                                            <th scope="row">{{ $itm->stock_code }} </th>
                                            <td>{{ $itm->stock_name }} </td>
                                            <td>{{ $miktar }}</td>
                                        </tr>
                                        @endif
                                        @endforeach

                                        @endif
                                    </tbody>
                                </table>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-12 mt-3">
                            <button class="btn btn-success btn-lg">Kaydet</button>
                        </div>
                    </div>



                </div>


            </div>
        </div>
        @endif
    </div>