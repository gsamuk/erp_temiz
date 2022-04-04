<div>


    <div class="card">
        <div class="card-header">

            <h5 class="text-info">{{ $title }}</h5>
            <div class="search-box">
                <input type="text" class="form-control form-control-sm search" wire:model="search"
                    placeholder="Hesap Ara">
                <i class="ri-search-line search-icon"></i>
            </div>

        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered  table-striped table-nowrap"
                    wire:loading.class="opacity-50">
                    <thead class="table-info">
                        <tr>
                            <th scope="col">Fiş No</th>
                            <th scope="col">Belge No</th>
                            <th scope="col">Hesap</th>
                            <th scope="col">Toplam</th>
                            <th scope="col">Tarih</th>
                            <th scope="col"> </th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($data as $d)
                        <tr>
                            <td class="owner">{{ $d->po_ficheno }}</td>
                            <td class="owner">{{ $d->document_no }}</td>
                            <td class="owner text-dark  "><b>{{ $d->account_name }}</b></td>
                            <td class="owner text-secondary"><b>{{ number_format($d->total_amount,2,',','.') }}</b></td>
                            <td class="owner">{{ date('d-m-Y',strtotime($d->po_date)) }}</td>
                            <td class="owner">
                                ---
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <div class="d-flex justify-content-end mt-3">
                {{ $data->links() }}
            </div>
        </div>
    </div>


</div>