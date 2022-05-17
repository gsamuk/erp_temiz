<div>


    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-xxl-6 col-sm-6 mb-1">
                            <div class="search-box">
                                <input type="text" class="form-control search" wire:model="no_search"
                                    placeholder="Talep No">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>

                        <div class="col-xxl-6 col-sm-6">
                            <div class="search-box">
                                <input type="text" class="form-control search" wire:model="user_search"
                                    placeholder="Talep Sahibi">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <ul class="nav nav-tabs nav-tabs-custom nav-success  " role="tablist">
                        <li class="nav-item">
                            <a class="nav-link All py-3 @if($status == 10 ) active @endif " data-bs-toggle="tab"
                                href="#" wire:click="set_status(10)" role="tab" aria-selected="true">
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
                                <i class="ri-checkbox-circle-line me-1 align-bottom"></i> İşleme Alındı
                            </a>
                        </li>

                    </ul>
                    <div class="row">
                        @if (session()->has('error'))
                        <div class="col-4 m-2 ">
                            <div class="alert alert-danger alert-dismissible fade show shadow">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                        @endif

                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle  table-sm table-bordered  table-striped table-nowrap"
                            wire:loading.class="opacity-50">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="width:50px;">No</th>
                                    <th scope="col" style="width:100px;">Talep Yapan</th>
                                    <th scope="col" style="width:100px;">Malzeme </th>
                                    <th scope="col">Durum</th>
                                    <th scope="col">Zamanı</th>
                                    <th scope="col" style="width:65px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $d)
                                @php
                                $cnt = App\Models\DemandDetail::where('demand_id', $d->id)->count();
                                @endphp

                                <tr class="@if($d->id == $talep_detay_id) table-info @endif">
                                    <td class="owner">{{ $d->id }}</td>
                                    <td class="owner"><a wire:click="set_username('{{ $d->user_name }}')"
                                            href="javascript:;">{{
                                            $d->user_name }}</a></td>
                                    <td class="owner"><b>{{ $cnt }} Adet</b></td>

                                    <td class="owner">@if($d->status == 0) <span class="text-info">Bekliyor</span> @else
                                        <span class="text-success">İşleme
                                            Alındı</span> @endif
                                    </td>
                                    <td class="owner">{{
                                        \Carbon\Carbon::createFromTimeStamp(strtotime($d->insert_time))->diffForHumans()
                                        }}
                                    </td>
                                    <td class="owner"><button
                                            wire:click="talep_detay({{ $d->id }}, '{{ $d->user_name }}')"
                                            class="btn btn-sm btn-success btn-block">Detay <i
                                                class="ri-arrow-right-s-line"></i></button></td>

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


        @if($talep_detay_id)
        <div class="col-lg-7">
            @livewire('malzemeler.talep-karsila')
        </div>
        @endif

    </div>

</div>