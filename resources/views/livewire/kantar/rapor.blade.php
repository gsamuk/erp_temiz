<div>

  @php
    $data = App\Models\KantarData::select('firma', 'malzeme', 'tarti_net')
        ->Where('file_id', $file_id)
        ->get()
        ->toJson(JSON_PRETTY_PRINT);
  @endphp
  <div class="row">
    <div class="col-12">
      <div class="card card-border-warning border">
        <div class="card-body mb-0 p-2">
          <div id="output"></div>
          <button class="btn btn-lg btn-success m-3"
                  onclick='$("#output").pivotUI(
            {!! $data !!}, {
              rows: ["firma"],
              cols: ["malzeme"],
              vals:["tarti_net"],
              aggregatorName: "Integer Sum"
            }  
          );'>Rapor
            Oluştur</button>
        </div>
      </div>
    </div>
  </div>





</div>
