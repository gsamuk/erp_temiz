<div>
  <div class="row">


    @foreach ($firmalar as $f)
      @php
        $satis = App\Models\KantarData::Where('firma_kod', $f->firma_kod)->get();
        $dip_toplam = 0;
        $dip_toplam_ton = 0;
      @endphp
      <div class="col-lg-4">
        <div class="card">
          <div class="card-header align-items-center d-flex">
            <h4 class="card-title flex-grow-1 text-danger mb-0">{{ $f->firma }}</h4>
          </div>
          <div class="card-body p-1">
            <table class="table-striped table-sm table">
              <thead>
                <tr>
                  <th scope="col">Fiş No</th>
                  <th scope="col">Malzeme</th>
                  <th scope="col">Net</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($satis as $s)
                  @php
                    $toplam = ($s->birim_fiyat + $s->nakliye_birim_fiyat) * ($s->tarti_net / 1000);
                    $dip_toplam = $dip_toplam + $toplam;
                    $dip_toplam_ton = $dip_toplam_ton + $s->tarti_net / 1000;
                  @endphp
                  <tr>
                    <td>{{ $s->fis_no }}</td>
                    <td>{{ $s->malzeme }}</td>
                    <td> <b>{{ number_format($s->tarti_net / 1000, 2, '.', ',') }}</b> <small>TON</small></td>
                  </tr>
                @endforeach
                <tr>
                  <td></td>
                  <td></td>
                  <td class="text-danger"><b>{{ $dip_toplam_ton }} TON</b></td>
                </tr>
              </tbody>
            </table>

          </div>
        </div>
      </div>
    @endforeach


  </div>
</div>
