<div>
  <span wire:loading>
    Bekleyiniz...
  </span>
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
              <td><b>{{ $file_data->file_name }}</b></td>
            </tr>
            <tr>
              <td>Orjinal Dosya Adı</td>
              <td><b>{{ $file_data->original_file_name }}</b></td>
            </tr>


            <tr>
              <td>Kayıt Sayısı</td>
              <td><b>{{ $linecount }}</b></td>
            </tr>
            <tr>
              <td>Eklenme Zamanı</td>
              <td><b>{{ date('d/m/Y H:i:s', strtotime($file_data->insert_time)) }}</b></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-xl-8">

        @if ($file_data->kontrol == null)
          <button wire:click="kontrol();" class="btn btn-info">Veri Kontrolü Yap</button>
        @endif

        @if ($file_data->kontrol == 2)
          <div class="alert alert-danger mt-2">
            Bu Dosyada veri kontrolü başarız oldu...
          </div>
        @endif


        @if ($file_data->kontrol == 1)
          <button wire:click="save();" class="btn btn-success">Kaydet</button>
        @endif

        @if (session()->has('error'))
          <div class="alert alert-danger mt-2">
            {!! session('error') !!}
          </div>
        @endif

        @if (session()->has('success'))
          <div class="alert alert-danger mt-2">
            {!! session('success') !!}
          </div>
        @endif


      </div>
    </div>
  @endif
</div>
