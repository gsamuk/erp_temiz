<div>

  {{-- Nothing in the world is as soft and yielding as water. --}}
  @if ($file_id)
    <div class="row">
      <div class="col-xl-4">
        <table class="table-bordered table-sm table-striped table">
          <tbody>
            <tr>
              <td>Kantar</td>
              <td>
                @php
                  $kantar = App\Models\Kantar::find($file_data->kantar_id);
                @endphp
                <b>{{ $kantar->kantar_adi }}</b>
              </td>
            </tr>
            <tr>
              <td>Dosya</td>
              <td><b>{{ $file_data->file_name }}</b> <br>
                <small>Eklenme Zamanı : {{ date('d/m/Y H:i:s', strtotime($file_data->insert_time)) }} </small>
              </td>
            </tr>


          </tbody>
        </table>
      </div>
      <div class="col-xl-4">



        @if ($file_data->kontrol == null)
          <button wire:click="kontrol();" class="btn btn-info btn-lg">Veri Kontrolü Yap</button>
        @endif

        @if ($file_data->kontrol == 2)
          <div class="alert alert-danger mt-2">
            Bu Dosyada veri kontrolü başarız oldu...
          </div>
        @endif


        @if ($file_data->kontrol == 1 && $file_data->islem == 0)
          <button wire:click="save();" class="btn btn-success btn-lg">Kaydet</button>
        @endif

        @if (session()->has('error'))
          <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
            {!! session('error') !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif



      </div>

      <div class="col-xl-4">
        <span wire:loading>
          Bekleyiniz... <br>
        </span>
      </div>


      <div class="col-xl-12">
        <hr class="m-1">
        <div class="card">
          <div class="card-header pb-0">

            <div class="row">

              <div class="col-2">
                <input type="text" class="form-control search" wire:model.debunce.500ms="fisno"
                       placeholder="Fiş No Ara">
              </div>

              <div class="col-3">
                <input type="text" class="form-control search" wire:model.debunce.500ms="plaka"
                       placeholder="Plaka Ara">
              </div>

              <div class="col-3">
                <input type="text" class="form-control search" wire:model.debunce.500ms="firma"
                       placeholder="Firma Ara">
              </div>
              <div class="col-2">
                <select class="form-select mb-3" wire:model="tip">
                  <option selected value="">Nakliye Hepsi</option>
                  <option value="1">Nakliyesiz</option>
                  <option value="2">Nakliyeli</option>
                </select>
              </div>
              <div class="col-2">
                <select class="form-select mb-3" wire:model="irs">
                  <option selected value="">İrsaliye Hepsi</option>
                  <option value="1">İrsaliye Oluştu</option>
                  <option value="2">İrsaliye Oluşturulmadı</option>
                </select>
              </div>

            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive table-card">
              @if ($data->count() > 0)
                <table class="table-nowrap table-sm table-striped mb-0 table">
                  <thead class="table-light">
                    <tr>
                      <th scope="col">Fiş No </th>
                      <th scope="col">Plaka</th>
                      <th scope="col">Firma</th>
                      <th scope="col">Malzeme</th>
                      <th scope="col">Tartı Net</th>
                      <th scope="col" style="width:130px;">Fiyat</th>
                      <th scope="col" style="width:110px;">Nakliye</th>
                      <th scope="col" style="width:110px;">Toplam</th>
                      <th scope="col">Ambar</th>
                      <th scope="col">Tarih</th>
                      <th scope="col"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($data as $key => $d)
                      @php
                        $ambar = App\Models\LogoWarehouses::where('warehouse_no', $d->ambar_no)
                            ->where('company_no', 1)
                            ->first();
                        $toplam = ($d->birim_fiyat + $d->nakliye_birim_fiyat) * ($d->tarti_net / 1000);
                      @endphp

                      <tr @if ($d->list_type == 2) class ="table-warning" @endif>

                        <td>{{ $d->fis_no }}</td>
                        <td>{{ $d->plaka }}</td>
                        <td> <b title="{{ $d->firma_kod }}" class="text-info">{{ $d->firma }}</b> </td>
                        <td><span title="{{ $d->malzeme_sku }}">{{ $d->malzeme }}</span> </td>
                        <td><b>{{ number_format($d->tarti_net / 1000, 2, '.', ',') }}</b> <small>TON</small> </td>
                        <td>
                          {{ Erp::nmf($d->birim_fiyat) }}
                          @if ($d->logo_fiche_ref == 0 || $d->logo_fiche_ref == null)
                            <a href="javascript:void(0);" onclick="$('#f_{{ $d->id }}').toggle();"
                               class="link-success fs-15"><i class="ri-edit-2-line"></i></a>
                            <input type="number" min="0" id="f_{{ $d->id }}" style="display:none"
                                   wire:model.lazy="fiyat.{{ $d->id }}"
                                   class="form-control">
                          @endif
                        </td>

                        <td>
                          @if ($d->list_type == 2)
                            {{ Erp::nmf($d->nakliye_birim_fiyat) }}

                            @if ($d->logo_fiche_ref == 0 || $d->logo_fiche_ref == null)
                              <a href="javascript:void(0);" onclick="$('#nf_{{ $d->id }}').toggle();"
                                 class="link-success fs-15"><i class="ri-edit-2-line"></i></a>
                              <input type="number" min="0" id="nf_{{ $d->id }}" style="display:none"
                                     wire:model.lazy="nakliye.{{ $d->id }}"
                                     class="form-control">
                            @endif
                          @else
                            -
                          @endif
                        </td>
                        <td><b>{{ Erp::nmf($toplam) }}</b> </td>
                        <td>{{ $ambar->warehouse_name }}</td>
                        <td>{{ date('d/m H:i', strtotime($d->tarti_cikis_zaman)) }}</td>
                        <td>
                          @if ($d->list_type == 0)
                            <small>
                              <span class="text-danger">{!! $d->durum !!}</span>
                            </small>
                          @else
                            @if ($d->logo_fiche_ref)
                              {{ $d->logo_fiche_ref }}
                            @else
                              <button type="button" onclick="$(this).attr('disabled', true);"
                                      wire:click="irsaliye({{ $d->id }})"
                                      class="btn btn-sm btn-info">İrsaliye Oluştur</button>
                            @endif
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                <div class="d-flex justify-content-end m-3">
                  {{ $data->links() }}
                </div>
              @endif

            </div>
          </div>
        </div>
      </div>

    </div>
  @else
    Detay için listeden işleme tıklayın.
  @endif
</div>
