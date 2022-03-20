<div>
    <div class="row">

        <div class="col-xxl-12">
            <div class="card" id="companyList">
                <div class="card-header">
                    <div class="row g-2">

                        <div class="col-md-3">
                            <div class="search-box">
                                <input type="text" class="form-control search" wire:model="search"
                                    placeholder="Malzeme Ara">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="search-box">
                                <input type="text" class="form-control search" wire:model="code" placeholder="Kod Ara">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>

                        <div class="col-md-3">

                            <select class="form-control" wire:model="tur">
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

                        </div>

                        <div class="col-md-2">
                            {{ $line }}
                        </div>

                    </div>

                </div>
                <div class="card-body">

                    <div>
                        <div class="table-responsive table-card mb-3">
                            <table class="table table-sm  align-middle table-nowrap mb-0" id="itemTable"
                                wire:loading.class="opacity-50">
                                <thead class="table-light">
                                    <tr>

                                        <th class="sort" data-sort="ref" scope="col">REF</th>
                                        <th class="sort" data-sort="tur" scope="col">Tür</th>
                                        <th class="sort" data-sort="kod" scope="col">KOD</th>
                                        <th class="sort" data-sort="name" scope="col">MALZEME ADI</th>
                                        <th class="sort" data-sort="grp" scope="col">GRUP KODU</th>

                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($items as $item)
                                    <tr>
                                        <td class="owner">{{ $item->LOGICALREF }}</td>
                                        <td class="owner">{{ $item->CARDTYPE }}</td>
                                        <td class="owner">{{ $item->CODE }}</td>
                                        <td class="owner">{{ $item->NAME }}</td>
                                        <td class="owner">{{ $item->STGRPCODE }}</td>
                                        <td class="owner">
                                            <button wire:click="addItem({{ $line }}, {{ $item->LOGICALREF }}  )"
                                                class="btn btn-sm btn-soft-secondary fw-medium"><i
                                                    class="ri-add-fill align-bottom"></i> Ekle</button>
                                        </td>
                                        <th class="sort" data-sort="btn" scope="col"></th>
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
            <!--end card-->
        </div>
        <!--end col-->

    </div>
    <!--end row-->

</div>