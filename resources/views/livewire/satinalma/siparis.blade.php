<div>
    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header">

                    <h5>Satın Alma Siparişleri</h5>
                    <div class="search-box">
                        <input type="text" class="form-control form-control-sm search" wire:model="search"
                            placeholder="Cari Ara">
                        <i class="ri-search-line search-icon"></i>
                    </div>

                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm  table-bordered  table-striped table-nowrap"
                            wire:loading.class="opacity-50">
                            <thead class="table-light">
                                <tr>


                                    <th scope="col">Fiş No</th>
                                    <th scope="col">Belge No</th>
                                    <th scope="col">Cari</th>
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
                                    <td class="owner">{{ $d->account_name }}</td>
                                    <td class="owner">{{ number_format($d->total_amount,2,',','.') }}</td>
                                    <td class="owner">{{ date('d-m-Y',strtotime($d->po_date)) }}</td>
                                    <td class="owner">
                                        <ul class="list-inline hstack gap-2 mb-0">
                                            <li class="list-inline-item" data-bs-toggle="tooltip"
                                                data-bs-trigger="hover" data-bs-placement="top" title=""
                                                data-bs-original-title="View">
                                                <a href="apps-ecommerce-order-details.html"
                                                    class="text-primary d-inline-block">
                                                    <i class="ri-eye-fill fs-16"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                data-bs-trigger="hover" data-bs-placement="top" title=""
                                                data-bs-original-title="Edit">
                                                <a href="#showModal" data-bs-toggle="modal"
                                                    class="text-primary d-inline-block edit-item-btn">
                                                    <i class=" ri-pencil-fill fs-16"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item remove" data-bs-toggle="tooltip"
                                                data-bs-trigger="hover" data-bs-placement="top" title=""
                                                data-bs-original-title="Remove">
                                                <a data-bs-toggle="modal" data-bs-target="#deleteOrder"
                                                    class="text-danger d-inline-block remove-item-btn">
                                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                                </a>
                                            </li>
                                        </ul>
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
    </div>
</div>