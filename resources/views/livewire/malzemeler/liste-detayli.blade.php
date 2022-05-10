<div>
    <div class="row">
        <div class="col-xxl-12">

            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">


                        <div class="col-md-3">
                            <div class="search-box">
                                <input type="text" class="form-control search" wire:model.debounce.900ms="code"
                                    placeholder="Malzeme Kodu Ara">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="search-box">
                                <input type="text" class="form-control search" wire:model.debounce.900ms="search"
                                    placeholder="Malzeme Adı Ara">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <select class="form-select" wire:model.lazy="tur">
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

                                    <th class="sort" data-sort="kod" scope="col">Kod</th>
                                    <th class="sort" data-sort="kod" scope="col">Kod</th>
                                    <th class="sort" data-sort="name" scope="col">Malzeme</th>
                                    <th class="sort" data-sort="name" scope="col">Stok Miktar</th>
                                    <th class="sort" data-sort="name" scope="col">Ortalama Fiyat</th>
                                    <th class="sort" data-sort="name" scope="col">Stok Değeri</th>
                                    <th class="sort" data-sort="name" scope="col">S.Alma Miktarı</th>
                                    <th class="sort" data-sort="name" scope="col">S.Alma Tutarı</th>
                                    <th class="sort" data-sort="name" scope="col">Satış Miktarı</th>
                                    <th class="sort" data-sort="name" scope="col">Satış Tutarı</th>
                                    <th class="sort" data-sort="tur" scope="col">Card Tip</th>
                                    <th class="sort" data-sort="tur" scope="col">Malzeme Tip</th>
                                </tr>

                            </thead>
                            <tbody>

                                @foreach ($items as $item)
                                <tr>
                                    <td class="owner"><button class="btn btn-sm btn-info">Foto</button></td>
                                    <td class="owner">{{ $item->stock_code }}</td>
                                    <td class="owner">{{ $item->stock_name }}</td>
                                    <td class="owner">{{ $item->onhand_quantity }}</td>
                                    <td class="owner">{{ number_format($item->average_price,2) }}</td>
                                    <td class="owner">{{ number_format($item->inventory_amount,2) }}</td>
                                    <td class="owner">{{ $item->purchase_quantity }}</td>
                                    <td class="owner">{{ number_format($item->purchase_amount,2) }}</td>
                                    <td class="owner">{{ number_format($item->sale_quantity,2) }}</td>
                                    <td class="owner">{{ number_format($item->sale_amount,2) }}</td>
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