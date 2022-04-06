<div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h5 class="card-title   flex-grow-1"> <i class="ri-store-2-fill align-bottom me-1"></i> Satınalma
                    Siparişleri Listesi</h5>
                <div class="flex-shrink-0">
                    <a href="/satinalma/siparis_olustur" class="btn btn-info add-btn"><i
                            class="ri-add-line align-bottom me-1"></i> Yeni Sipariş
                        Oluştur</a>

                </div>
            </div>

            <div class="row">
                <div class="col-xxl-5 col-sm-6">
                    <div class="search-box">
                        <input type="text" class="form-control search" wire:model="search"
                            placeholder="Hesap, Fiş No , Belge No Ara...">
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <ul class="nav nav-tabs nav-tabs-custom nav-success  " role="tablist">
                <li class="nav-item">
                    <a class="nav-link All py-3 @if($po_status == 0) active @endif " data-bs-toggle="tab" href="#"
                        wire:click="setPo_status(0)" role="tab" aria-selected="true">
                        <i class="ri-store-2-fill me-1 align-bottom"></i> Hepsi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3 @if($po_status == 1) active @endif " data-bs-toggle="tab" href="#"
                        wire:click="setPo_status(1)" role="tab" aria-selected="false">
                        <i class="ri-checkbox-circle-line me-1 align-bottom"></i> Öneri
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link py-3 @if($po_status == 4) active @endif " data-bs-toggle="tab" href="#"
                        wire:click="setPo_status(4)" role="tab" aria-selected="false">
                        <i class="ri-checkbox-circle-line me-1 align-bottom"></i> Sevk Edilebilir
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link py-3 @if($po_status == 2) active @endif " data-bs-toggle="tab" href="#"
                        wire:click="setPo_status(2)" role="tab" aria-selected="false">
                        <i class="ri-checkbox-circle-line me-1 align-bottom"></i> Sevk Edilemez
                    </a>
                </li>
            </ul>
            <div class="row">
                @if (session()->has('error'))
                <div class="col-4 m-2 ">
                    <div class="alert alert-danger alert-dismissible fade show shadow">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                @endif
                <div class="col-12 m-2 ">
                    <div wire:loading>
                        İşleniyor Lütfen Bekleyiniz...
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-bordered  table-striped table-nowrap"
                    wire:loading.class="opacity-50">
                    <thead class="table-danger">
                        <tr>
                            <th scope="col align-center" style="width:50px;"> </th>
                            <th scope="col">Durum</th>
                            <th scope="col">Fiş No</th>
                            <th scope="col">Belge No</th>
                            <th scope="col">Hesap</th>
                            <th scope="col">Toplam</th>
                            <th scope="col">Tarih</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($data as $d)
                        @php
                        if($d->po_status == 1){
                        $status = '<span class="badge badge-soft-info">Öneri</span>';
                        }elseif($d->po_status == 2) {
                        $status = '<span class="badge badge-soft-danger">Sevk Edilemez</span>';
                        }elseif($d->po_status == 4) {
                        $status = '<span class="badge badge-soft-success">Sevk Edilebilir</span>';
                        }
                        @endphp
                        <tr>
                            <td class="owner">
                                <div class="flex-shrink-0">
                                    <div class="dropdown card-header-dropdown">
                                        <a class="text-dark dropdown-btn" href="#" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <span class="fs-18"><i class="mdi mdi-dots-vertical"></i></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#"
                                                onclick="detay({{$d->logicalref}})">Gör</a>
                                            <a class="dropdown-item"
                                                href="{{ route('satinalma.siparis_duzenle', ['id'=> $d->logicalref ]) }}">Düzenle</a>
                                            <a class="dropdown-item" href="#" onclick="onay({{$d->logicalref}})">Onay
                                                Durumu Değiştir</a>
                                            <a class="dropdown-item" href="#" onclick="sil({{$d->logicalref}})">Çıkar
                                                (Sil)</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="owner">{!! $status !!}</td>
                            <td class="owner">{{ $d->po_ficheno }}</td>
                            <td class="owner">{{ $d->document_no }}</td>
                            <td class="owner text-dark  "><b>{{ $d->account_name }}</b></td>
                            <td class="owner text-secondary"><b>{{ number_format($d->total_amount,2,',','.') }}</b></td>
                            <td class="owner">{{ date('d-m-Y',strtotime($d->po_date)) }}</td>
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