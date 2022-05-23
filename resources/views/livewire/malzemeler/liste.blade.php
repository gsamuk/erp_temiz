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
                                        src="{{ asset('storage/images/items/'.$p->foto_path) }}">
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

    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1"> <i class="ri-add-line align-bottom me-1"></i>
                    Malzemeler</h5>
                <div class="flex-shrink-0">
                    <button wire:click="detay_goster({{ !$details }})" class="btn btn-info add-btn"><i
                            class="ri-stack-fill  align-bottom me-1"></i> Detaylı Liste
                    </button>

                    <a href="/malzemeler/fotograf" class="btn btn-success add-btn"><i
                            class="ri-image-fill align-bottom me-1"></i> Fotoğraf Yönetimi
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-2">
                    <div class="search-box">
                        <input type="text" class="form-control search m-1" wire:model.debounce.500ms="code"
                            placeholder="Malzeme Kodu Ara">
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="search-box">
                        <input type="text" class="form-control search m-1" wire:model.debounce.500ms="search"
                            placeholder="Malzeme Adı Ara">
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div>

                <div class="col-md-3">
                    <select class="form-select m-1" wire:model="tur">
                        <option value="">-- Cart Tipi Seç --</option>
                        @foreach ($item_type as $i)
                        <option value="{{ $i->cardtype_name }}">{{ $i->cardtype_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <select class="form-select m-1" wire:model.lazy="stur">
                        <option value="">-- Malzeme Tipi Seç --</option>
                        @foreach ($stock_type as $i)
                        @if($i->stock_type)
                        <option value="{{ $i->stock_type }}">{{ $i->stock_type }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>


            </div>



            <div class="table-responsive">
                <table class="table table-sm  align-middle  table-bordered  table-striped table-nowrap" id="itemTable"
                    wire:loading.class="opacity-50">
                    <thead class="table-light">
                        <tr>

                            <th class="sort" data-sort="kod" scope="col" style="width:55px;"></th>
                            <th class="sort" data-sort="kod" scope="col" style="width:55px;">Kod</th>

                            @if($ch)
                            <th class="sort" data-sort="name" scope="col" style="width:55px;"></th>
                            @endif
                            <th class="sort" data-sort="name" scope="col">Malzeme</th>
                            @if($details)
                            <th class="sort" data-sort="name" scope="col">Stok</th>
                            <th class="sort" data-sort="name" scope="col">Ort. Fiyat</th>
                            <th class="sort" data-sort="name" scope="col">S.Alma Miktarı</th>
                            <th class="sort" data-sort="name" scope="col">S.Alma Tutarı</th>
                            @endif

                            <th class="sort" data-sort="tur" scope="col">Kart Tipi</th>
                            <th class="sort" data-sort="tur" scope="col">Tür</th>
                        </tr>

                    </thead>
                    <tbody>

                        @foreach ($items as $item)
                        @php
                        $photo = App\Models\LogoItemsPhoto::where('logo_stockref', $item->logicalref)->first();
                        @endphp
                        <tr>
                            <td class="owner">
                                @if($photo)
                                <a href="#" wire:click="foto({{ $item->logicalref }})">
                                    <img src="{{ asset('storage/images/items/thumb/'.$photo->foto_path) }}"
                                        style="height: 50px">
                                </a>

                                @else
                                <img class="img-thumbnail" style="height: 50px" src="/images/default.png">
                                @endif
                            </td>

                            <td class="owner"><a wire:click.prevent="addItem({{ $line }}, {{ $item->logicalref }} )"
                                    href="#">{{ $item->stock_code }}</a></td>

                            @if($ch)
                            <td class="owner"><a wire:click.prevent="addItem({{ $line }}, {{ $item->logicalref }} )"
                                    href="#"><button class="btn btn-success btn-sm"> Ekle </button></a></td>
                            @endif
                            <td class="owner">
                                <a wire:click.prevent="addItem({{ $line }}, {{ $item->logicalref }} )" href="#"><b>{{
                                        $item->stock_name }}</b></a>
                                @if($foto_ref && $foto_ref ==$item->logicalref )
                                <br>
                                @foreach ($item_photos as $p)
                                <img src="{{ asset('storage/images/items/thumb/'.$p->foto_path) }}">
                                @endforeach

                                @endif
                            </td>


                            @if($details)
                            <td class="owner">{{ $item->onhand_quantity }}</td>
                            <td class="owner">{{ number_format($item->average_price,2) }}</td>
                            <td class="owner">{{ $item->purchase_quantity }}</td>
                            <td class="owner">{{ number_format($item->purchase_amount,2) }}</td>
                            @endif

                            <td class="owner">{{ $item->cardtype_name }}</td>
                            <td class="owner">{{ $item->stock_type }}</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>
            <div class="d-flex justify-content-end mt-3">
                {{ $items->links() }}
            </div>

        </div>
    </div>


</div>