<div>
    <div class="row">
        <div class="col-xxl-12">
            <div class="card border">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="search-box">
                                <input type="text" class="form-control search" wire:model="code" placeholder="Kod Ara">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="search-box">
                                <input type="text" class="form-control search" wire:model="search"
                                    placeholder="Malzeme Ara">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>


                    </div>
                </div>

                <div class="card-body">


                    <div class="table-responsive">
                        <table class="table table-sm   table-bordered border-secondary table-nowrap" id="itemTable"
                            wire:loading.class="opacity-50">
                            <thead class="table-light">
                                <tr>
                                    <th class="sort" data-sort="ref" scope="col">REF</th>
                                    <th class="sort" data-sort="tur" scope="col">Tür</th>
                                    <th class="sort" data-sort="kod" scope="col">KOD</th>
                                    <th class="sort" data-sort="name" scope="col"></th>
                                    <th class="sort" data-sort="name" scope="col">MALZEME ADI</th>
                                    <th class="sort" data-sort="name" scope="col">Eldeki Miktar</th>
                                    <th class="sort" data-sort="name" scope="col">Ortalama Fiyat</th>
                                    <th class="sort" data-sort="name" scope="col">Envanter Tutarı</th>
                                    <th class="sort" data-sort="name" scope="col">Satın Alma Miktarı</th>
                                    <th class="sort" data-sort="name" scope="col">Satın Alma Tutarı</th>
                                    <th class="sort" data-sort="name" scope="col">Satış Miktarı</th>
                                    <th class="sort" data-sort="name" scope="col">Satış Tutarı</th>
                                    <th class="sort" data-sort="name" scope="col">Son İşlem</th>

                                </tr>

                            </thead>
                            <tbody>

                                @foreach ($items as $item)
                                <tr>
                                    <td class="owner">{{ $item->logicalref }}</td>
                                    <td class="owner">{{ $item->stock_type }}</td>
                                    <td class="owner"><a
                                            wire:click.prevent="addItem({{ $line }}, {{ $item->logicalref }} )"
                                            href="#">{{ $item->stock_code }}</a></td>
                                    <td class="owner"><a
                                            wire:click.prevent="addItem({{ $line }}, {{ $item->logicalref }} )"
                                            href="#"><button class="btn btn-primary btn-sm"> Seç </button></a></td>

                                    <td class="owner"><a
                                            wire:click.prevent="addItem({{ $line }}, {{ $item->logicalref }} )"
                                            href="#">{{ $item->stock_name }}</a></td>
                                    <td class="owner">{{ $item->onhand_quantity }}</td>
                                    <td class="owner">{{ number_format($item->average_price,2) }}</td>
                                    <td class="owner">{{ number_format($item->inventory_amount,2) }}</td>
                                    <td class="owner">{{ $item->purchase_quantity }}</td>
                                    <td class="owner">{{ number_format($item->purchase_amount,2) }}</td>
                                    <td class="owner">{{ $item->sale_quantity }}</td>
                                    <td class="owner">{{ number_format($item->sale_amount,2) }}</td>
                                    <td class="owner">{{ $item->last_transaction_date }}</td>



                                </tr>
                                @endforeach
                                <tr>
                                    <td scope="owner px-5" colspan="5">
                                        <select wire:model="tur">
                                            <option value="" selected>Hepsi</option>
                                        </select>
                                    </td>
                                </tr>
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