<div>
  <div class="row">
    <div class="col-xs-12 col-md-12 col-sm-12 col-lg-5 col-xl-5 col-xxl-5">
      <div class="card">

        <div class="card-header">
          <div class="row">
            <div class="col-4">
              <div class="search-box">
                <input type="text" class="form-control search" wire:model.debunce.500ms="talep_id"
                       placeholder="Talep No">
                <i class="ri-search-line search-icon"></i>
              </div>
            </div>



            <div class="col-4">
              <a href="#" wire:click="$emit('SetPage', 'malzemeler.talep-olustur')"
                 class="btn btn-soft-primary waves-effect waves-light"> <i class="ri-add-line"></i>
                Yeni Talep</a>
            </div>

          </div>
        </div>

        <div class="card-body p-2">

          <ul class="nav nav-tabs nav-tabs-custom nav-success" role="tablist">
            <li class="nav-item">
              <a class="nav-link All @if ($status == 99) active @endif py-3" data-bs-toggle="tab"
                 href="#" wire:click="set_status(99)" role="tab" aria-selected="true">
                <i class="ri-stack-line me-1 align-bottom"></i> Hepsi
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if ($status == 0) active @endif py-3" data-bs-toggle="tab"
                 href="#" wire:click="set_status(0)" role="tab" aria-selected="false">
                <i class="ri-hand-coin-line me-1 align-bottom"></i> Beklemede
              </a>
            </li>


            <li class="nav-item">
              <a class="nav-link @if ($status == 1) active @endif py-3" data-bs-toggle="tab"
                 href="#" wire:click="set_status(1)" role="tab" aria-selected="false">
                <i class="ri-download-2-line me-1 align-bottom"></i> İşlemde
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link @if ($status == 2) active @endif py-3" data-bs-toggle="tab"
                 href="#" wire:click="set_status(2)" role="tab" aria-selected="false">
                <i class="ri-thumb-up-line me-1 align-bottom"></i> Tamamlandı
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link @if ($status == 9) active @endif py-3" data-bs-toggle="tab"
                 href="#" wire:click="set_status(9)" role="tab" aria-selected="false">
                <i class="ri-thumb-down-line me-1 align-bottom"></i>Red
              </a>
            </li>


          </ul>
          <div class="row">
            @if (session()->has('error'))
              <div class="col-4 m-2">
                <div class="alert alert-danger alert-dismissible fade show shadow">
                  {{ session('error') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              </div>
            @endif

          </div>
          @if ($data->count() > 0)
            <div class="table-responsive">
              <table class="table-sm table-bordered table-striped table-nowrap table align-middle"
                     wire:loading.class="opacity-50">
                <thead class="table-light">
                  <tr>

                    <th scope="col">No</th>
                    <th scope="col">Zaman</th>
                    <th scope="col">Durum</th>
                    <th scope="col">İşlem</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data as $d)
                    @php
                      $cnt = App\Models\DemandDetail::where('demand_id', $d->id)->count();
                      if ($cnt == 0) {
                          continue;
                      }
                      $zaman = date('d-m > H:i', strtotime($d->insert_time));
                    @endphp

                    <tr class="@if ($d->id == $talep_satir_id) table-info @endif">

                      <td class="owner">{{ $d->id }}</td>
                      <td class="owner">{{ $zaman }}</td>

                      <td class="owner">
                        @if ($d->approved == 1)
                          @if ($d->status == 2)
                            <span class="badge rounded-pill badge-outline-primary">
                              Tamamlandı</span>
                          @else
                            <span class="badge rounded-pill badge-outline-success">
                              İşleme Alındı</span>
                          @endif
                        @else
                          @if ($d->status == 9)
                            <span class="badge rounded-pill badge-outline-danger">
                              Reddedildi</span>
                          @else
                            <span class="badge rounded-pill badge-outline-warning">
                              Onay Bekliyor</span>
                          @endif
                        @endif

                      </td>
                      <td class="owner">
                        @if (($d->status == 1 || $d->status == 2) && $d->demand_type == 1)
                          <button wire:click="talep_islem_detay({{ $d->id }}, '{{ $d->user_name }}')"
                                  class="btn btn-sm btn-success btn-block" style="width:150px">Talep İşlem Detayı <i
                               class="ri-arrow-right-s-fill"></i></button>
                        @endif

                        @if ($d->status == 0 && $d->demand_type == 1)
                          <button wire:click="talep_detay({{ $d->id }}, '{{ $d->user_name }}')"
                                  class="btn btn-sm btn-info btn-block" style="width:150px"> Malzeme Talebi <i
                               class="ri-arrow-right-s-fill"></i></button>
                        @endif


                        @if (($d->status == 1 || $d->status == 2) && $d->demand_type == 2)
                          <button wire:click="talep_islem_detay({{ $d->id }}, '{{ $d->user_name }}')"
                                  class="btn btn-sm btn-success btn-block" style="width:150px"> İşlem Detayı
                            <i class="ri-arrow-right-s-fill"></i></button>
                        @endif

                        @if ($d->status == 0 && $d->demand_type == 2)
                          <button wire:click="talep_detay({{ $d->id }}, '{{ $d->user_name }}')"
                                  class="btn btn-sm btn-warning btn-block" style="width:150px"> Transfer Talebi <i
                               class="ri-arrow-right-s-fill"></i></button>
                        @endif

                        @if ($d->status == 9)
                          <button class="btn btn-sm btn-soft- btn-block waves-effect waves-light" disabled>
                            Reddedildi
                          </button>
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
          @else
            <div class="m-3"> Talep Bulunamadı..</div>
          @endif
        </div>



      </div>
    </div>

    <div class="col-xs-12 col-md-12 col-sm-12 col-lg-7 col-xl-7 col-xxl-7">

      @if ($talep_detay_id)
        @livewire('malzemeler.talep-karsila', ['talep_owner' => true])
      @endif

      @if ($talep_islem_id)
        @livewire('malzemeler.talep-islem', ['talep_owner' => true])
      @endif



    </div>

  </div>

</div>
