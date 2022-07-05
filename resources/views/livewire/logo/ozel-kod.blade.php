<div>
  <div class="row">
    <div class="col-xxl-12">

      <div class="row mb-3">
        <div class="col-md-5">
          <div class="search-box">
            <input type="text" class="form-control search" wire:model="search_code"
                   placeholder="Özel Kod Ara">
            <i class="ri-search-line search-icon"></i>
          </div>
        </div>

        <div class="col-md-5">
          <div class="search-box">
            <input type="text" class="form-control search" wire:model="search_name"
                   placeholder="Özel Kod Adı Ara">
            <i class="ri-search-line search-icon"></i>
          </div>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table-sm table-bordered table-striped table-nowrap table"
               wire:loading.class="opacity-50">
          <thead class="table-light">
            <tr>
              <th scope="col" style="width:250px;">Özel Kod</th>
              <th scope="col" style="width:50px;"></th>
              <th scope="col">Özel Kod Adı</th>
            </tr>
          </thead>
          <tbody>

            @foreach ($data as $d)
              <tr>
                <td class="owner">{{ $d->special_code }}</td>
                <td class="owner">
                  @if ($type == 1)
                    <button wire:click="$emit('getOzelKod', '{{ $d }}')"
                            class="btn btn-primary btn-sm"> Seç </button>
                  @else
                    <button wire:click="$emit('getOzelKodLine', '{{ $d }}')"
                            class="btn btn-info btn-sm"> Seç </button>
                  @endif
                </td>
                <td class="owner">{{ $d->special_name }}</td>

              </tr>
            @endforeach
          </tbody>
        </table>

      </div>
      <div class="d-flex justify-content-end mt-3">
        {{ $data->links() }}
      </div>

    </div>
  </div>
</div>
