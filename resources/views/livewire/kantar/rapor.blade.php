<div>
  <div class="row">
    <div class="col-12">
      <div class="row">
        <div class="col-xl-3">
          <div class="card card-h-100">
            <div class="card-body">
              <form wire:submit.prevent="rapor_uret">
                <div class="row gy-3">
                  <div class="col-lg-12">
                    <label class="form-label">Rapor Tarih</label>
                    <input type="date" class="form-control" wire:model.defer="tarih">
                  </div>

                  <div class="col-lg-12">
                    <label class="form-label">Kantar</label>
                    <select class="form-select mb-3" wire:model.defer="kantar">
                      <option value="1">Kubwa Kantarları</option>
                      <option value="2">Kaduna Kantarları</option>
                    </select>
                  </div>
                  <div class="col-lg-12">
                    <button class="btn btn-lg btn-info" type="submit">Rapor Üret</button>
                  </div>
                  <div class="col-lg-12">
                    @if ($cari && $cari->count() > 0)
                      Seçili Tarih : <b>{{ $tarih }}</b><br>
                      Toplam <b>{{ $cari->count() }}</b> Adet Cari Hesap Raporlandı
                    @endif
                    @if (session()->has('error'))
                      <div class="alert alert-danger alert-dismissible alert-label-icon rounded-label fade show"
                           role="alert">
                        <i class="ri-alert-fill label-icon"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                      </div>
                    @endif
                  </div>

                </div>
              </form>

            </div>
          </div>

        </div>

        <div class="col-xl-9">
          @if ($cari)
            <div class="row">
              @if ($cari->count() > 0)
                @foreach ($cari as $c)
                  @php
                    $firma = App\Models\KantarData::Where('firma_kod', $c->firma_kod)->first();
                    DB::enableQueryLog();
                    $malz = App\Models\KantarData::Where('firma_kod', $c->firma_kod)
                        ->whereDate('tarti_cikis_zaman', $tarih)
                        ->when($kantar == 1, function ($query) {
                            return $query->where('kantar_id', 2)->Orwhere('kantar_id', 3);
                        })
                        ->when($kantar == 2, function ($query) {
                            return $query->where('kantar_id', 1)->Orwhere('kantar_id', 4);
                        })
                        ->select('malzeme_sku')
                        ->distinct()
                        ->get();
                    // dd(DB::getQueryLog());
                    $gn_toplam = 0;
                  @endphp
                  <div class="col-xl-6">
                    <div class="card">
                      <div class="card-body">
                        <table class="table-sm w-100 table">
                          <tbody>
                            <tr>
                              <td colspan="2">
                                <h6 class="text-info"><b>{{ $firma->firma }}</b></h6>
                              </td>
                            </tr>

                            @foreach ($malz as $m)
                              @php
                                $toplam = App\Models\KantarData::Where('firma_kod', $c->firma_kod)
                                    ->whereDate('tarti_cikis_zaman', $tarih)
                                    ->Where('malzeme_sku', $m->malzeme_sku)
                                    ->when($kantar == 1, function ($query) {
                                        return $query->where('kantar_id', 2)->Orwhere('kantar_id', 3);
                                    })
                                    ->when($kantar == 2, function ($query) {
                                        return $query->where('kantar_id', 1)->Orwhere('kantar_id', 4);
                                    })
                                    ->sum('tarti_net');
                                $gn_toplam = $gn_toplam + $toplam;
                                $mt = App\Models\KantarData::Where('malzeme_sku', $m->malzeme_sku)->first();
                                // malzeme detayı
                              @endphp
                              <tr>
                                <td> {{ $mt->malzeme }} </td>
                                <td> {{ $toplam / 1000 }} </td>
                              </tr>
                            @endforeach
                            <tr>
                              <td><b> Genel Toplam </b></td>
                              <td class="text-danger"><b> {{ $gn_toplam / 1000 }} TON</b> </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                @endforeach
              @else
                <div class="col-xl-12">
                  <div class="alert alert-warning mb-xl-0" role="alert">
                    Belirtilen Tarih için kayıt bulunamadı..
                  </div>
                </div>
              @endif

            </div>
          @else
            <div class="col-xl-12">
              <div class="alert alert-info mb-xl-0" role="alert">
                Lütfen Gerekli Alanları Doldurun...
              </div>
            </div>
          @endif

        </div>
      </div>


      <div style="clear:both"></div>


    </div>
  </div>


</div>
