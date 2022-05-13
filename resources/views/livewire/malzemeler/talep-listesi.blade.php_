<div>
    <div class="card">
        <div class="card-header">


            <div class="row">
                <div class="col-xxl-5 col-sm-6">
                    <div class="search-box">
                        <input type="text" class="form-control search" wire:model="search"
                            placeholder="Fiş No , Belge No Ara...">
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <ul class="nav nav-tabs nav-tabs-custom nav-success  " role="tablist">
                <li class="nav-item">
                    <a class="nav-link All py-3 @if($fichne_status == 'all') active @endif " data-bs-toggle="tab"
                        href="#" wire:click="set_status('all')" role="tab" aria-selected="true">
                        <i class="ri-store-2-fill me-1 align-bottom"></i> Hepsi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3 @if($fichne_status == 'Öneri') active @endif " data-bs-toggle="tab" href="#"
                        wire:click="set_status('Öneri')" role="tab" aria-selected="false">
                        <i class="ri-checkbox-circle-line me-1 align-bottom"></i> Öneri
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link py-3 @if($fichne_status == 'Karşılanıyor') active @endif " data-bs-toggle="tab"
                        href="#" wire:click="set_status('Karşılanıyor')" role="tab" aria-selected="false">
                        <i class="ri-checkbox-circle-line me-1 align-bottom"></i> Karşılanıyor
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link py-3 @if($fichne_status == 'Onaylandı') active @endif " data-bs-toggle="tab"
                        href="#" wire:click="set_status('Onaylandı')" role="tab" aria-selected="false">
                        <i class="ri-checkbox-circle-line me-1 align-bottom"></i> Onaylandı
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link py-3 @if($fichne_status == 'Diğer') active @endif " data-bs-toggle="tab" href="#"
                        wire:click="set_status('Diğer')" role="tab" aria-selected="false">
                        <i class="ri-checkbox-circle-line me-1 align-bottom"></i> Diğer
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
                            <th scope="col" style="width:50px;"></th>
                            <th scope="col">Durum</th>
                            <th scope="col">Fiş No</th>
                            <th scope="col">Belge No</th>
                            <th scope="col">Tarih</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($data as $d)
                        @php
                        $status = "";
                        if($d->fichne_status == "Öneri"){
                        $status = '<span class="badge badge-soft-info">Öneri</span>';
                        }elseif($d->fichne_status == "Onaylandı") {
                        $status = '<span class="badge badge-soft-info">Onaylandı</span>';
                        }elseif($d->fichne_status == "Diğer") {
                        $status = '<span class="badge badge-soft-danger">Diğer</span>';
                        }elseif($d->fichne_status == "Karşılanıyor") {
                        $status = '<span class="badge badge-soft-success">Karşılanıyor</span>';
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
                                            <a class="dropdown-item"
                                                href="{{ route('malzeme.talep_duzenle', ['id'=> $d->logicalref ]) }}">Düzenle</a>
                                            <a class="dropdown-item" href="#" onclick="sil({{$d->logicalref}})">Çıkar
                                                (Sil)</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="owner">
                                <button wire:click="goster({{ $d->fiche_no }})"
                                    class="btn btn-sm btn-info">Göster</button>
                            </td>
                            <td class="owner">{!! $status !!}</td>
                            <td class="owner">{{ $d->fiche_no }}</td>
                            <td class="owner">{{ $d->special_code }}</td>
                            <td class="owner">{{ date('d-m-Y',strtotime($d->fiche_date)) }}</td>
                            <td class="owner">
                                @if($d->fichne_status == "Diğer")
                                <button title="Kayıtlardan Çıkar" class="remove-item-btn"
                                    onclick="sil({{$d->logicalref}})">
                                    <i class="ri-delete-bin-fill align-bottom text-muted"></i>
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <div class="d-flex justify-content-end mt-3">
                {{ $data->links() }}
            </div>

            Not: Malzeme taleplerinin işleme alınabilmesi için yetkili kişi tarafından onaylanması gerekir.
        </div>

    </div>


</div>