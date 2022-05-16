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

    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-xxl-6 col-sm-6 mb-1">
                            <div class="search-box">
                                <input type="text" class="form-control search" wire:model="no_search"
                                    placeholder="Talep No">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>

                        <div class="col-xxl-6 col-sm-6">
                            <div class="search-box">
                                <input type="text" class="form-control search" wire:model="user_search"
                                    placeholder="Talep Sahibi">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <ul class="nav nav-tabs nav-tabs-custom nav-success  " role="tablist">
                        <li class="nav-item">
                            <a class="nav-link All py-3 @if($status == 10 ) active @endif " data-bs-toggle="tab"
                                href="#" wire:click="set_status(10)" role="tab" aria-selected="true">
                                <i class="ri-store-2-fill me-1 align-bottom"></i> Hepsi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-3 @if($status == 0) active @endif " data-bs-toggle="tab" href="#"
                                wire:click="set_status(0)" role="tab" aria-selected="false">
                                <i class="ri-checkbox-circle-line me-1 align-bottom"></i> Beklemede
                            </a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link py-3 @if($status == 1) active @endif " data-bs-toggle="tab" href="#"
                                wire:click="set_status(1)" role="tab" aria-selected="false">
                                <i class="ri-checkbox-circle-line me-1 align-bottom"></i> İşleme Alındı
                            </a>
                        </li>

                    </ul>
                    <div class="row">
                        @if (session()->has('error'))
                        <div class="col-4 m-2 ">
                            <div class="alert alert-danger alert-dismissible fade show shadow">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                        @endif

                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle  table-sm table-bordered  table-striped table-nowrap"
                            wire:loading.class="opacity-50">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="width:50px;">No</th>
                                    <th scope="col" style="width:100px;">Talep Yapan</th>
                                    <th scope="col" style="width:100px;">Malzeme </th>
                                    <th scope="col">Durum</th>
                                    <th scope="col">Zamanı</th>
                                    <th scope="col" style="width:65px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $d)
                                @php
                                $cnt = App\Models\DemandDetail::where('demand_id', $d->id)->count();
                                @endphp

                                <tr class="@if($d->id == $talep_detay_id) table-danger @endif">
                                    <td class="owner">{{ $d->id }}</td>
                                    <td class="owner"><a wire:click="set_username('{{ $d->user_name }}')"
                                            href="javascript:;">{{
                                            $d->user_name }}</a></td>
                                    <td class="owner"><b>{{ $cnt }} Adet</b></td>

                                    <td class="owner">@if($d->status == 0) <span class="text-info">Bekliyor</span> @else
                                        <span class="text-success">İşleme
                                            Alındı</span> @endif
                                    </td>
                                    <td class="owner">{{
                                        \Carbon\Carbon::createFromTimeStamp(strtotime($d->insert_time))->diffForHumans()
                                        }}
                                    </td>
                                    <td class="owner"><button
                                            wire:click="talep_detay({{ $d->id }}, '{{ $d->user_name }}')"
                                            class="btn btn-sm btn-success btn-block">Detay <i
                                                class="ri-arrow-right-s-line"></i></button></td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div wire:loading>
                            İşleniyor Lütfen Bekleyiniz...
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        {{ $data->links() }}
                    </div>

                    Not: Malzeme taleplerinin işleme alınabilmesi için yetkili kişi tarafından onaylanması gerekir.
                </div>



            </div>
        </div>

        <div class="col-lg-7">
            @if($talep_detay)

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0 flex-grow-1">Talep Detayı</h4>
                    <small>{{ $talep_username }}</small>
                </div>

                <div class="card-body">


                    <!-- Striped Rows -->
                    @if($talep_detay)
                    <table class="table table-success align-middle   table-sm table-striped">
                        <thead>
                            <tr>
                                <th scope="col" style="width:50px;">Foto</th>
                                <th scope="col">Malzeme</th>
                                <th scope="col">Talep Miktarı</th>
                                <th scope="col">Stok Durum</th>
                                <th scope="col">İstek Nedeni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($talep_detay as $dt)
                            @php
                            $photo = App\Models\LogoItemsPhoto::where('logo_stockref', $dt->logicalref)->first();
                            @endphp
                            <tr>
                                <td class="owner">
                                    @if($photo)
                                    <img class="border"
                                        src="{{ asset('storage/images/items/thumb/'.$photo->foto_path) }}"
                                        style="width: 50px">
                                    @else
                                    <img class="border" style="width: 50px" src="/images/default.png">
                                    @endif
                                </td>

                                <td><b>{{ $dt->stock_name }}</b> <br> <small>Stok Kodu: {{ $dt->stock_code
                                        }}</small></td>
                                <td class="text-dark"><b style="font-size:1.5em">{{
                                        number_format($dt->quantity,0,'.',',')
                                        }}</b>
                                    <br><small>{{ $dt->unit_code
                                        }}</small>
                                </td>
                                <td><b style="font-size:1.5em">{{ number_format($dt->onhand_quantity,0,'.',',')
                                        }}</b></td>

                                <td>{{ $dt->description }}</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    @endif


                </div>
            </div>


            @endif
        </div>


        @if($talep_detay_id)
        <div class="col-lg-12">
            @livewire('malzemeler.talep-karsila')
        </div>
        @endif

    </div>

</div>