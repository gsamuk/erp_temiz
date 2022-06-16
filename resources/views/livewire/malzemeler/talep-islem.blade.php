<div>


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

                                <th scope="col">Karşılanan</th>
                                <th scope="col">Satınalma</th>
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

                                    <img class="border"
                                        src="{{ asset('public/storage/images/items/thumb/'.$photo->foto_path) }}"
                                        style="height: 65px">

                                    @else

                                    <img class="border" style="height: 50px" src="/public/images/default.png">

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

                                <td><b>{{ number_format($dt->approved_consump,0,'.',',') }} <br><small>{{ $dt->unit_code
                                            }}</small></b>
                                <td><b>{{ number_format($dt->approved_purchase,0,'.',',') }} <br><small>{{
                                            $dt->unit_code
                                            }}</small> </b>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($demand_fiche)
                <div class="col-lg-12 mb-2">
                    <h6><b>Depodan Karşılanan Malzeme Listesi (Sarf Fişleri)</b></h6>
                    <div style="background-color: rgb(230, 250, 213)" class="p-1">
                        <table class="table border align-middle table-sm table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Belge No</th>
                                    <th scope="col">Stok No</th>
                                    <th scope="col">Malzeme</th>
                                    <th scope="col">Miktar</th>
                                    <th scope="col">Proje Kodu</th>
                                    <th scope="col">Özel Kod</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($demand_fiche as $d)

                                <tr>
                                    <td>{{ $d->doc_number }}</td>
                                    <td>{{ $d->stock_code }}</td>
                                    <td>{{ $d->stock_name }}</td>
                                    <td>{{ number_format($d->amount,0,'.',',') }} <small>{{ $d->unit_code }}</small>
                                    </td>
                                    <td>{{ $d->project_code }}</td>
                                    <td>{{ $d->special_code }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif



                @php
                $incompletedDemand = App\Models\IncompletedDemand::Where('demand_id', $talep_id)->get();
                @endphp


                @if($incompletedDemand)

                <div class="col-lg-12 mt-2">
                    <h6><b>Karşılanmayı Bekleyen Malzeme Listesi</b></h6>
                    <div style="background-color: rgb(250, 231, 213)" class="p-1">
                        <table class="table border align-middle table-sm table-striped">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Stok No</th>
                                    <th scope="col">Malzeme</th>
                                    <th scope="col">Talep Edilen</th>
                                    <th scope="col">Karşılanan</th>
                                    <th scope="col">Fark </th>
                                    <th scope="col">Stok </th>

                                </tr>
                            </thead>
                            <tbody>
                                <form>
                                    @foreach($incompletedDemand as $d)
                                    @php
                                    $sarf_btn = false;
                                    $item = App\Models\LogoItems::where('stock_code',$d->stock_code)->first();
                                    @endphp
                                    <tr class="@if($item->onhand_quantity >= $d->diff) bg-soft-success @endif">
                                        <td>
                                            @if($item->onhand_quantity >= $d->diff)
                                            @php
                                            $sarf_btn = true;
                                            @endphp
                                            <input type="checkbox" wire:model.defer="sarf.{{ $d->stock_code }}"
                                                name="sarf_checkbox" value="{{ $d->quantity }}"
                                                class="form-check-input">
                                            @else

                                            @endif
                                        </td>

                                        <td>{{ $d->stock_code }}</td>
                                        <th>{{ $item->stock_name }}</th>
                                        <th>{{ number_format($d->quantity,0,'.',',') }} <small>{{ $d->unit_code }}
                                            </small></th>
                                        <th>{{ number_format($d->consump,0,'.',',') }}</th>
                                        <th>{{ number_format($d->diff,0,'.',',') }}</th>
                                        <th>{{ number_format($item->onhand_quantity,0,'.',',') }}</th>
                                    </tr>
                                    @endforeach
                                </form>
                            </tbody>
                        </table>

                        @if($sarf_btn)
                        <button class="btn btn-primary m-1" wire:click="sarf_olustur">Seçili Olanları Teslim
                            Et</button><br>
                        <span class="text-dark m-1">Satınalma işlemi gerçekleşip malzeme stoklara yansıdığında sarf
                            oluşturabilirsiniz.</span>
                        @endif

                    </div>
                </div>
                @endif



            </div>
        </div>
    </div>
    @endif
</div>