<div>



    <div wire:ignore.self id="fotoModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog  modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body m-0">

                    fotos

                </div>

            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header ">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1"> <i class="ri-add-line align-bottom me-1"></i>
                            Malzemeler</h5>
                        <div class="flex-shrink-0">
                            <a href="/malzemeler/fotograf" class="btn btn-success add-btn"><i
                                    class="ri-store-2-fill align-bottom me-1"></i> Fotoğraf Yönetimi
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <div class="search-box">
                                <input type="text" class="form-control search" wire:model.debounce.500ms="code"
                                    placeholder="Malzeme Kodu Ara">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="search-box">
                                <input type="text" class="form-control search" wire:model.debounce.500ms="search"
                                    placeholder="Malzeme Adı Ara">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <select class="form-select" wire:model="tur">
                                <option value="">-- Cart Tipi Seç --</option>
                                @foreach ($item_type as $i)
                                <option value="{{ $i->cardtype_name }}">{{ $i->cardtype_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select class="form-select" wire:model.lazy="stur">
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
                        <table class="table table-sm   table-bordered  table-striped table-nowrap" id="itemTable"
                            wire:loading.class="opacity-50">
                            <thead class="table-light">
                                <tr>
                                    <th class="sort" data-sort="kod" scope="col"></th>
                                    <th class="sort" data-sort="kod" scope="col">Kod</th>

                                    @if($ch)
                                    <th class="sort" data-sort="name" scope="col"></th>
                                    @endif

                                    <th class="sort" data-sort="name" scope="col">Malzeme</th>
                                    <th class="sort" data-sort="name" scope="col">Stok</th>

                                    @if($details)
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
                                <tr>
                                    <td class="owner"><button wire:click="foto({{ $item->logicalref }})"
                                            class="btn btn-sm btn-info">Foto</button></td>

                                    <td class="owner"><a
                                            wire:click.prevent="addItem({{ $line }}, {{ $item->logicalref }} )"
                                            href="#">{{ $item->stock_code }}</a></td>
                                    @if($ch)
                                    <td class="owner"><a
                                            wire:click.prevent="addItem({{ $line }}, {{ $item->logicalref }} )"
                                            href="#"><button class="btn btn-success btn-sm"> Ekle </button></a></td>
                                    @endif
                                    <td class="owner"><a
                                            wire:click.prevent="addItem({{ $line }}, {{ $item->logicalref }} )"
                                            href="#">{{ $item->stock_name }}</a></td>
                                    <td class="owner">{{ $item->onhand_quantity }}</td>

                                    @if($details)
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
    </div>
</div>