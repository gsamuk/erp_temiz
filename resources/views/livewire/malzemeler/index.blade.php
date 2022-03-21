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
                                    <th class="sort" data-sort="name" scope="col">MALZEME ADI</th>
                                    <th class="sort" data-sort="grp" scope="col">GRUP KODU</th>
                                    <th class="sort" data-sort="grp" scope="col">x</th>
                                    <th class="sort" data-sort="grp" scope="col">x</th>
                                    <th class="sort" data-sort="grp" scope="col">x</th>
                                    <th class="sort" data-sort="grp" scope="col">x</th>
                                </tr>

                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                <tr>
                                    <td class="owner">{{ $item->LOGICALREF }}</td>
                                    <td class="owner">{{ $item->CARDTYPE }}</td>
                                    <td class="owner"><a
                                            wire:click.prevent="addItem({{ $line }}, {{ $item->LOGICALREF }} )"
                                            href="#">{{ $item->CODE }}</a></td>
                                    <td class="owner"><a
                                            wire:click.prevent="addItem({{ $line }}, {{ $item->LOGICALREF }} )"
                                            href="#">{{ $item->NAME }}</a></td>
                                    <td class="owner">{{ $item->STGRPCODE }}</td>
                                    <td class="owner">587</td>
                                    <td class="owner">1547</td>
                                    <td class="owner">1547</td>
                                    <td class="owner">1547</td>

                                </tr>
                                @endforeach
                                <tr>
                                    <td scope="owner px-5" colspan="5">
                                        <select wire:model="tur">
                                            <option value="" selected>Hepsi</option>
                                            <option value="1">(TM) Ticari Mal</option>
                                            <option value="2">(KK) Karma Koli</option>
                                            <option value="3">(DM) Depozitolu Mal</option>
                                            <option value="10">(HM) Hammadde</option>
                                            <option value="11">(YM) Yarı Mamul</option>
                                            <option value="12">(MM) Mamul</option>
                                            <option value="13">(TK) Tüketim Malı</option>
                                            <option value="20">(MS) Malzeme Sınıfı (Genel)</option>
                                            <option value="21">(MT) Malzeme Sınıfı (Tablolu)</option>
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