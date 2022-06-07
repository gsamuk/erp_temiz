<div>
    <div class="row">
        <div class="@if($item_id) col-xl-7 col-lg-7 col-md-12 col-sm-12 @else col-xl-12 @endif ">
            <div class="card ff-secondary">
                <div class="card-header p-2">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1"> <i class="ri-add-line align-bottom me-1"></i>
                            Malzemeler</h5>
                        <div class="flex-shrink-0">
                            <button wire:click="detay_goster({{ !$details }})"
                                class="btn btn-soft-primary waves-effect waves-light"><i
                                    class="ri-stack-fill  align-bottom me-1"></i> Detaylı Liste
                            </button>
                            @if(!$ch)
                            <a href="#" wire:click="$emit('SetPage', 'malzemeler.fotograf')"
                                class="btn btn-soft-primary waves-effect waves-light"><i
                                    class="ri-image-fill align-bottom me-1"></i>
                                Fotoğraf
                                Yönetimi
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body p-2">
                    <div class="row mb-1">
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
                        @if(!$item_id)
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
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm  align-middle  table-striped table-nowrap" id="itemTable"
                            wire:loading.class="opacity-50">
                            <thead class="table-light">
                                <tr>
                                    <th class="sort" data-sort="kod" scope="col" style="width:55px;"></th>
                                    <th class="sort" data-sort="kod" scope="col" style="width:55px;">Kod</th>

                                    @if($ch)
                                    <th class="sort" data-sort="name" scope="col" style="width:55px;"></th>
                                    @endif
                                    <th class="sort" data-sort="name" scope="col">Malzeme</th>
                                    @if(!$item_id)
                                    @if($details)
                                    <th class="sort" data-sort="name" scope="col">Stok</th>
                                    <th class="sort" data-sort="name" scope="col">Ort. Fiyat</th>
                                    <th class="sort" data-sort="name" scope="col">S.Alma Miktarı</th>
                                    <th class="sort" data-sort="name" scope="col">S.Alma Tutarı</th>
                                    @endif
                                    <th class="sort" data-sort="tur" scope="col">Kart Tipi</th>
                                    <th class="sort" data-sort="tur" scope="col">Tür</th>
                                    @endif
                                    <th class="sort" data-sort="tur" scope="col">Detay</th>
                                </tr>

                            </thead>
                            <tbody>

                                @foreach ($items as $item)
                                @php
                                $photo = App\Models\LogoItemsPhoto::where('logo_stockref', $item->logicalref)->first();
                                $line ="";
                                if(isset($item_id) && $item_id == $item->logicalref){
                                $line = "bg-soft-primary";
                                }
                                @endphp
                                <tr class="{{ $line }}">
                                    <td class="owner">
                                        @if($photo)
                                        <a href="#" wire:click="foto({{ $item->logicalref }})">
                                            <img src="{{ asset('public/storage/images/items/thumb/'.$photo->foto_path) }}"
                                                style="width: 50px">
                                        </a>
                                        @else
                                        <a href="#" wire:click="foto({{ $item->logicalref }})">
                                            <img style="width: 50px" src="{{ asset('/public/images/default.png')}}">
                                        </a>
                                        @endif
                                    </td>

                                    <td class="owner"> {{ $item->stock_code }} </td>

                                    @if($ch)
                                    <td class="owner">
                                        <button wire:click.prevent="$emit('getItem', {{ $item }})"
                                            class="btn btn-outline-danger btn-sm"> Ekle </button>
                                    </td>
                                    @endif
                                    <td>
                                        <a href="#" wire:click="foto({{ $item->logicalref }})">
                                            <b> {{ $item->stock_name }}</b>
                                        </a>
                                    </td>

                                    @if(!$item_id)
                                    @if($details)
                                    <td class="owner">{{ $item->onhand_quantity }}</td>
                                    <td class="owner">{{ number_format($item->average_price,2) }}</td>
                                    <td class="owner">{{ $item->purchase_quantity }}</td>
                                    <td class="owner">{{ number_format($item->purchase_amount,2) }}</td>
                                    @endif

                                    <td class="owner">{{ $item->cardtype_name }}</td>
                                    <td class="owner">{{ $item->stock_type }}</td>
                                    @endif

                                    <td class="owner">
                                        <a href="#" class="btn btn-soft-primary waves-effect waves-light btn-sm"
                                            wire:click="foto({{ $item->logicalref }})">
                                            Detay </a>
                                    </td>
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

        @if($item_id)
        <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">

            <div class="row bg-soft-warning p-2  ff-secondary">
                <div class="col-12">
                    <div class="d-flex justify-content-end">
                        <button wire:click="remove_foto()"
                            class="btn btn-soft-primary waves-effect waves-light btn-sm">Kapat</button>
                    </div>
                </div>

                <div class="col-lg-5">
                    <h5 class="text-danger">{{ $item->stock_name }}</h5>
                    <small>Stok Kodu : <b>{{ $item->stock_code }}</b> </small><br>
                    <small>Stok Tipi : <b>{{ $item->stock_type }}</b> </small><br>
                    <small>Stok Kartı : <b>{{ $item->cardtype_name }}</b> </small><br>
                    <small>Stok Miktarı : <b>@if($item->onhand_quantity > 0) {{ $item->onhand_quantity }} @else 0 @endif
                        </b>
                    </small>
                    <hr>
                    <h5>Son Satınalma Tutarları</h5>
                    <small>1.500 X Adet ABC Ltd. 25.10.2021</small><br>
                    <small>1.400 X Adet</small><br>
                    <small>1.500 X Adet</small><br>
                    <small>1.600 X Adet</small><br>
                </div>

                @if($item_photos)
                <div class="col-lg-7">
                    <div class="row ">
                        @foreach ($item_photos as $p)
                        <div class="col-xxl-6 col-xl-6 col-sm-12">
                            <img class=" img-fluid mx-auto border p-1 m-2"
                                src="{{ asset('public/storage/images/items/'.$p->foto_path) }}">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        </div>
        @endif
    </div>
</div>