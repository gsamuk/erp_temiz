<div>
    <div class="row">
        <div class="col-lg-5 col-md-12 col-sm-12">
            <div class="card">

                <div class="card-header">
                    <div class="row">
                        <div class="col-4">
                            <div class="search-box">
                                <input type="text" class="form-control search" wire:model="no_search"
                                    placeholder="Talep No">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>

                        <div class="col-4">
                            <a href="#" wire:click="$emit('SetPage', 'malzemeler.talep-olustur')"
                                class="btn btn-soft-primary waves-effect waves-light">
                                <i class="ri-add-line "></i> Yeni Talep</a>
                        </div>

                    </div>
                </div>

                <div class="card-body">

                    <ul class="nav nav-tabs nav-tabs-custom nav-success  " role="tablist">
                        <li class="nav-item">
                            <a class="nav-link All py-3 @if($status == 99 ) active @endif " data-bs-toggle="tab"
                                href="#" wire:click="set_status(99)" role="tab" aria-selected="true">
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

                        <li class="nav-item">
                            <a class="nav-link py-3 @if($status == 9) active @endif " data-bs-toggle="tab" href="#"
                                wire:click="set_status(9)" role="tab" aria-selected="false">
                                <i class="ri-checkbox-circle-line me-1 align-bottom"></i>Red
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
                    @if($data->count() > 0)
                    <div class="table-responsive">
                        <table class="table align-middle  table-sm table-bordered  table-striped table-nowrap"
                            wire:loading.class="opacity-50">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="width:50px;">No</th>

                                    <th scope="col" style="width:100px;">Malzeme </th>
                                    <th scope="col">Zamanı</th>
                                    <th scope="col" style="width:65px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $d)
                                @php
                                $cnt = App\Models\DemandDetail::where('demand_id', $d->id)->count();
                                if($cnt == 0){
                                continue;
                                }
                                @endphp
                                <tr class="@if($d->id == $talep_satir_id) table-info @endif">
                                    <td class="owner">{{ $d->id }}</td>
                                    <td class="owner"><b>{{ $cnt }} Kalem</b></td>

                                    <td class="owner">{{
                                        \Carbon\Carbon::createFromTimeStamp(strtotime($d->insert_time))->diffForHumans()
                                        }}
                                    </td>
                                    <td class="owner">
                                        @if($d->status == 1)
                                        <button wire:click="talep_islem_detay({{ $d->id }}, '{{ $d->user_name }}')"
                                            class="btn btn-sm btn-success btn-block">İşlem Detayı <i
                                                class="ri-arrow-right-s-line"></i></button>
                                        @endif

                                        @if($d->status == 0)
                                        <button wire:click="talep_detay({{ $d->id }}, '{{ $d->user_name }}')"
                                            class="btn btn-sm btn-info btn-block">Detay <i
                                                class="ri-arrow-right-s-line"></i></button>
                                        @endif


                                    </td>

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
                    @else
                    <div class="m-3"> Talep Bulunamadı..</div>
                    @endif
                </div>



            </div>
        </div>




        @if($talep_detay_id)
        <div class="col-lg-7 col-md-12 col-sm-12">
            @livewire('malzemeler.talep-karsila', ['for_manage' => false])
        </div>
        @endif


        @if($talep_islem_id)
        <div class="col-lg-7 col-md-12 col-sm-12">
            @livewire('malzemeler.talep-islem')
        </div>
        @endif



    </div>

</div>