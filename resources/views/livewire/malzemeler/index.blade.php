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
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-3">
                            <table class="table table-sm  align-middle table-nowrap mb-0" id="itemTable"
                                wire:loading.class="opacity-50">
                                <thead class="table-light">
                                    <tr>

                                        <th class="sort" data-sort="CODE" scope="col">KART_TIPI</th>
                                        <th class="sort" data-sort="CODE" scope="col">MALZEME_KODU</th>
                                        <th class="sort" data-sort="name" scope="col">MALZEME_ADI</th>
                                        <th class="sort" data-sort="name" scope="col">BIRIM_SETI_KODU</th>
                                        <th class="sort" data-sort="name" scope="col">GRUP_KODU</th>

                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($items as $item)
                                    <tr>
                                        <td class="owner">{{ $item->KART_TIPI }}</td>
                                        <td class="owner">{{ $item->MALZEME_KODU }}</td>
                                        <td class="owner">{{ $item->MALZEME_ADI }}</td>
                                        <td class="owner">{{ $item->BIRIM_SETI_KODU }}</td>
                                        <td class="owner">{{ $item->GRUP_KODU }}</td>

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