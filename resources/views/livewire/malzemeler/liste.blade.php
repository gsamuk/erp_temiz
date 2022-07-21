<div>
  <div class="row">
    <div class="@if ($item_id) col-xl-6 col-lg-6 col-md-12 col-sm-12 @else col-xl-12 @endif">
      <div class="card ff-secondary">
        <div class="card-header p-2">
          <div class="d-flex align-items-center">
            <h5 class="card-title flex-grow-1 mb-0"> <i class="ri-add-line me-1 align-bottom"></i>
              Malzemeler</h5>
            <div class="flex-shrink-0">
              @if (!$ch)
                <a href="#" wire:click="$emit('SetPage', 'malzemeler.fotograf')"
                   class="btn btn-soft-primary waves-effect waves-light"><i
                     class="ri-image-fill me-1 align-bottom"></i>
                  Fotoğraf
                  Yönetimi
                </a>
              @endif
            </div>
          </div>
        </div>

        <div class="card-body p-2">
          <div class="row mb-1">

            <div class="col-md-4">
              <div class="search-box" x-data x-init="$refs.search.focus()">
                <input type="text" class="form-control search m-1" wire:model.debounce.500ms="search" x-ref="search"
                       placeholder="Malzeme Adı Ara" style="text-transform: uppercase">
                <i class="ri-search-line search-icon"></i>
              </div>
            </div>

            <div class="col-md-4">
              <div class="search-box">
                <input type="text" class="form-control search m-1" wire:model.debounce.500ms="code"
                       placeholder="Malzeme Kodu Ara">
                <i class="ri-search-line search-icon"></i>
              </div>
            </div>

            @if (!$ch)
              <div class="col-md-4">
                <select class="form-select m-1" wire:model="wh_id" name="wh_id">
                  <option value="">-- Bütün Depolar --</option>
                  @foreach ($warehouses as $d)
                    <option value="{{ $d->warehouse_no }}">
                      {{ $d->warehouse_name }}
                    </option>
                  @endforeach
                </select>
              </div>
            @endif


          </div>
          @if ($items->count() > 0)
            <div class="table-responsive">
              <table class="table-sm table-striped table-nowrap table align-middle" id="itemTable"
                     wire:loading.class="opacity-50">
                <thead class="table-light">
                  <tr>

                    <th class="sort" data-sort="kod" scope="col" style="width:55px;">SK</th>

                    @if ($ch)
                      <th class="sort" data-sort="name" scope="col" style="width:55px;"></th>
                    @endif

                    <th class="sort" data-sort="name" scope="col">Malzeme</th>
                    <th class="sort" data-sort="name" scope="col">Depo</th>
                    @if (!$item_id)
                      @if ($details)
                        <th class="sort" data-sort="name" scope="col">Stok</th>
                        <th class="sort" data-sort="name" scope="col">Ort. Fiyat</th>
                        <th class="sort" data-sort="name" scope="col">S.Alma Miktarı</th>
                        <th class="sort" data-sort="name" scope="col">S.Alma Tutarı</th>
                      @endif

                    @endif
                    <th class="sort" data-sort="tur" scope="col">Detay</th>
                  </tr>

                </thead>
                <tbody>

                  @foreach ($items as $item)
                    @php
                      
                      $line = '';
                      if (isset($item_id) && $item_id == $item->logicalref) {
                          $line = 'bg-soft-primary';
                      }
                    @endphp
                    <tr class="{{ $line }}">


                      <td class="owner"> {{ $item->stock_code }} </td>

                      @if ($ch)
                        <td class="owner">
                          <button wire:click.prevent="$emit('getItem', {{ $item }})"
                                  class="btn btn-success btn-sm"> Ekle </button>
                        </td>
                      @endif

                      <td>
                        <b> {{ $item->stock_name }}</b>
                      </td>

                      <td class="owner"> {{ $item->wh_name }} </td>

                      @if (!$item_id)
                        @if ($details)
                          <td class="owner text-danger"><b>{{ Erp::nmf($item->onhand_quantity) }}</b></td>
                          <td class="owner text-info">{{ Erp::nmf($item->average_price, 2) }}</td>
                          <td class="owner">{{ Erp::nmf($item->purchase_quantity) }}</td>
                          <td class="owner">{{ Erp::nmf($item->purchase_amount, 2) }}</td>
                        @endif
                      @endif

                      <td class="owner">
                        <a href="#" class="btn btn-soft-primary waves-effect waves-light btn-sm"
                           wire:click="foto({{ $item->logicalref }})">
                          Detay </a>
                      </td>
                    </tr>
                  @endforeach

                </tbody>
              </table>

            </div>
            <div class="d-flex justify-content-end mt-3">
              {{ $items->links() }}
            </div>
          @else
            Malzeme Kaydı Bulunamadı..
          @endif
        </div>
      </div>
    </div>

    @if ($item_id)
      <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
        <div class="card bg-light">
          <div class="card-body">

            <div class="row">
              <div class="col-12">
                <div class="d-flex justify-content-end">
                  <button wire:click="remove_foto()"
                          class="btn btn-soft-danger waves-effect waves-light btn-sm">Kapat</button>
                </div>
              </div>

              <div class="col-lg-12">
                @php
                  $item = \App\Models\LogoItems::find($item_id);
                  $item_photos = \App\Models\LogoItemsPhoto::Where('logo_stockref', $item_id)->get();
                @endphp

                <h5 class="text-danger">{{ $item->stock_name }}</h5>
                <small>Stok Kodu : <b>{{ $item->stock_code }}</b> </small><br>
                <small>Stok Tipi : <b>{{ $item->stock_type }}</b> </small><br>
                <small>Stok Kartı : <b>{{ $item->cardtype_name }}</b> </small><br>
                <small>Ref : <b>{{ $item_id }}</b> </small><br>
                <hr>
                @livewire('malzemeler.son-satinalmalar', [
                    'itemref' => $item_id,
                ])
              </div>

              @if ($item_photos)
                <div class="col-lg-12">
                  <div class="row">
                    @foreach ($item_photos as $p)
                      <div class="col-xxl-6 col-xl-6 col-sm-12">
                        <img class="img-fluid m-2 mx-auto border p-1"
                             src="https://mobile.zeberced.net/files/{{ $p->foto_path }}"
                             _src="{{ asset('files/images/items/' . $p->foto_path) }}">
                      </div>
                    @endforeach
                  </div>
                </div>
              @endif

            </div>

          </div>
        </div>
    @endif
  </div>
</div>
