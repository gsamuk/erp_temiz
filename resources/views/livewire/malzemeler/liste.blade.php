<div>
    <div class="row">
        <div class="col-xxl-12">

            <div class="row mb-3">


                <div class="col-md-4">
                    <div class="search-box">
                        <input type="text" class="form-control search" wire:model="code" placeholder="Malzeme Kodu Ara">
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="search-box">
                        <input type="text" class="form-control search" wire:model="search"
                            placeholder="Malzeme Adı Ara">
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div>

                <div class="col-md-4">
                    <select class="form-select" wire:model="tur">
                        @foreach ($item_type as $i)
                        <option value="{{ $i->cardtype_name }}">{{ $i->cardtype_name }}</option>
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
                            @if($ch)
                            <th class="sort" data-sort="name" scope="col"></th>
                            @endif
                            <th class="sort" data-sort="name" scope="col">Malzeme</th>
                            <th class="sort" data-sort="name" scope="col">Stok</th>
                            <th class="sort" data-sort="name" scope="col">Ort. Fiyat</th>
                            <th class="sort" data-sort="name" scope="col">S.Alma Miktarı</th>
                            <th class="sort" data-sort="name" scope="col">S.Alma Tutarı</th>
                            <th class="sort" data-sort="tur" scope="col">Kart Tipi</th>
                            <th class="sort" data-sort="tur" scope="col">Tür</th>
                        </tr>

                    </thead>
                    <tbody>

                        @foreach ($items as $item)
                        <tr>

                            <td class="owner"><a wire:click.prevent="addItem({{ $line }}, {{ $item->logicalref }} )"
                                    href="#">{{ $item->stock_code }}</a></td>
                            @if($ch)
                            <td class="owner"><a wire:click.prevent="addItem({{ $line }}, {{ $item->logicalref }} )"
                                    href="#"><button class="btn btn-primary btn-sm"> Seç </button></a></td>
                            @endif
                            <td class="owner"><a wire:click.prevent="addItem({{ $line }}, {{ $item->logicalref }} )"
                                    href="#">{{ $item->stock_name }}</a></td>
                            <td class="owner">{{ $item->onhand_quantity }}</td>
                            <td class="owner">{{ number_format($item->average_price,2) }}</td>

                            <td class="owner">{{ $item->purchase_quantity }}</td>
                            <td class="owner">{{ number_format($item->purchase_amount,2) }}</td>
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