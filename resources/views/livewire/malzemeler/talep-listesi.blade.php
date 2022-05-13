<div>
    @if($item_id)
    <div id="MalzemeFotoModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body m-0">
                    <div class="row">
                        <div class="col-lg-4">
                            <h5 class="text-danger">{{ $item->stock_name }}</h5>
                            <small>Stok Kodu : <b>{{ $item->stock_code }}</b> </small>
                        </div>

                        <div class="col-lg-8">
                            <div class="row ">
                                @foreach ($item_photos as $p)
                                <div class=" col-xxl-6 col-xl-6 col-sm-12">
                                    <img class=" img-fluid mx-auto border p-1 m-2"
                                        src="{{ asset('storage/images/items/'.$p->foto_path) }}">
                                </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

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
                    <a class="nav-link All py-3 @if($status == 10 ) active @endif " data-bs-toggle="tab" href="#"
                        wire:click="set_status(10)" role="tab" aria-selected="true">
                        <i class="ri-store-2-fill me-1 align-bottom"></i> Hepsi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3 @if($status == 0) active @endif " data-bs-toggle="tab" href="#"
                        wire:click="set_status(0)" role="tab" aria-selected="false">
                        <i class="ri-checkbox-circle-line me-1 align-bottom"></i> Beklemede
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link py-3 @if($status == 1) active @endif " data-bs-toggle="tab" href="#"
                        wire:click="set_status(1)" role="tab" aria-selected="false">
                        <i class="ri-checkbox-circle-line me-1 align-bottom"></i> Depodan Karşılanıyor
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link py-3 @if($status == 2) active @endif " data-bs-toggle="tab" href="#"
                        wire:click="set_status(2)" role="tab" aria-selected="false">
                        <i class="ri-checkbox-circle-line me-1 align-bottom"></i> Satın Alınıyor
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

            </div>

            <div class="table-responsive">
                <table class="table align-middle  table-sm table-bordered  table-striped table-nowrap"
                    wire:loading.class="opacity-50">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" style="width:40px;"> </th>
                            <th scope="col" style="width:50px;">Fiş No</th>

                            <th scope="col">S.Kodu</th>
                            <th scope="col">Malzeme</th>
                            <th scope="col">Miktar</th>
                            <th scope="col">Talep Nedeni</th>
                            <th scope="col">Zaman</th>
                            <th scope="col">Talep Yapan</th>
                            <th scope="col">Durum</th>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($data as $d)
                        @php
                        $status = "";
                        if($d->status == 0){
                        $status = '<span class="badge badge-soft-info">Beklemee</span>';
                        }elseif($d->status == 1) {
                        $status = '<span class="badge badge-soft-info">Depodan Karşılanıyor</span>';
                        }elseif($d->status == 2) {
                        $status = '<span class="badge badge-soft-danger">Satın Alınıyor</span>';
                        }
                        $photo = App\Models\LogoItemsPhoto::where('logo_stockref', $d->logo_stockref)->first();

                        @endphp
                        <tr>
                            <td class="owner align-center">

                                @if($photo)
                                <a href="javascript:;" wire:click="goster({{ $d->logo_stockref }})">
                                    <img class="p-1 border"
                                        src="{{ asset('storage/images/items/thumb/'.$photo->foto_path) }}"
                                        style="width: 40px">
                                </a>

                                @else
                                <img class="img-thumbnail" style="width: 40px" src="/images/default.png">
                                @endif

                            </td>
                            <td class="owner">{{ $d->demand_no }}</td>


                            <td class="owner"><b>xx</b></td>
                            <td class="owner"><b>{{ $d->stock_name }}</b></td>
                            <td class="owner">{{ number_format($d->quantity,0,'',''); }} {{ $d->unit_code }}</td>
                            <td class="owner">{{ $d->description }}</td>
                            <td class="owner">{{
                                \Carbon\Carbon::createFromTimeStamp(strtotime($d->insert_time))->diffForHumans() }}
                            </td>
                            <td class="owner">{{ $d->name }}</td>
                            <td class="owner">{!! $status !!}</td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div wire:loading>
                    İşleniyor Lütfen Bekleyiniz...
                </div>
            </div>
            <div class="d-flex justify-content-end mt-3">
                {{ $data->links() }}
            </div>

            Not: Malzeme taleplerinin işleme alınabilmesi için yetkili kişi tarafından onaylanması gerekir.
        </div>

    </div>


</div>