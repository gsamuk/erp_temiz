<div>


  <div class="row">
    <div class="col-xl-12">
      <div class="row">

        <div class="col-xl-8">
          <div class="card card-border-warning border">
            <div class="card-header">
              <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                  <select wire:model="search_kantar"
                          class="form-select mb-1" aria-label="Default select example">
                    <option value="">-- BÜTÜN KANTARLAR -- </option>
                    @foreach ($kantarlar as $k)
                      <option value="{{ $k->id }}">{{ $k->kantar_adi }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="card-body mb-0 p-2">
              @if ($data->count() > 0)
                <table class="table-bordered table-striped table-sm table">
                  <thead class="table-light">
                    <tr>
                      <th scope="col"></th>
                      <th scope="col">Kantar</th>
                      <th scope="col">Yükleyen</th>
                      <th scope="col">Dosya</th>
                      <th scope="col">Eklenme</th>
                      <th scope="col">Kayıt</th>
                      <th scope="col">İrsaliye</th>
                      <th scope="col"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($data as $d)
                      @php
                        $kantar = App\Models\Kantar::find($d->kantar_id);
                        $cnt = App\Models\KantarData::Where('logo_fiche_ref', '>', 0)
                            ->Where('file_id', $d->id)
                            ->count();
                        $toplam_kayit = App\Models\KantarData::Where('file_id', $d->id)->count();
                        $user = Erp::user($d->user_id);
                      @endphp
                      <tr @if ($line == $d->id) class="table-success" @endif>
                        <th scope="row">{{ $d->id }}</th>
                        <td>{{ $kantar->kantar_adi }}</td>
                        <td>{{ $user->name }} {{ $user->surname }}</td>
                        <td><a target="_blank" href="/files/kantar_raporlari/{{ $d->file_name }}">
                            {{ $d->original_file_name }}</a></td>
                        <td>{{ date('d-m-Y H:i', strtotime($d->insert_time)) }}</td>
                        <td>{{ $toplam_kayit }}</td>
                        <td>{{ $cnt }}</td>
                        <td> <button wire:click="set_file({{ $d->id }})"
                                  class="btn btn-sm btn-primary m-0">İşlem</button>
                          @if ($cnt == 0)
                            <button wire:click="sil({{ $d->id }})"
                                    class="btn btn-sm btn-danger m-0">Sil</button>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                <div class="d-flex justify-content-end m-3">
                  {{ $data->links() }}
                </div>
              @else
                <span class="text-danger m-2"> Seçili Kantarla ilgili dosya bulunamadı... </span>
              @endif

            </div>
          </div>
        </div>

        <div class="col-xl-4">
          <div class="card card-border-warning border">
            <div class="card-body">

              <form wire:submit.prevent="save">
                <label>KANTAR RAPOR DOSYASI YÜKLE</label>
                <select class="form-select mb-3" wire:model="kantar_id">
                  <option value="0">-- KANTAR SEÇ --</option>
                  <option value="1">KUBWA-1</option>
                  <option value="2">KUBWA-2</option>
                  <option value="3">KADUNA-1</option>
                  <option value="4">KADUNA-2</option>
                </select>

                @if ($kantar_id > 0)
                  @if (!$file)
                    <label for="file" class="btn btn-info btn-label rounded-pill">
                      <i class="ri-image-fill label-icon rounded-pill fs-16 me-2 align-middle"></i>
                      Dosya Seç
                    </label>
                    <input id="file" style="display:none;" type="file" wire:model="file">
                  @endif
                @else
                  Dosyayı yüklemek için önce kantar seçin.
                @endif


                @if ($file)
                  <button wire:loading.attr="disabled" class="btn rounded-pill btn-success btn-block"
                          type="submit"> Seçili Dosyayı Yükle</button>
                @endif

              </form>
              <span wire:loading>
                Bekleyiniz...
              </span>
              @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  {{ session('error') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif

              @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {{ session('success') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif

            </div>
          </div>
        </div>



      </div>

    </div>



    <div class="col-xl-12">
      <div class="card card-border-warning border">
        <div class="card-body">
          @if ($setFile)
            @livewire('kantar.islem')
          @else
            İşlem için dosya seçin
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
