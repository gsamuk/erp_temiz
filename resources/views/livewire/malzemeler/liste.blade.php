<div>
  <div class="row">
    <div class="@if ($item_id) col-xl-7 col-lg-7 col-md-12 col-sm-12 @else col-xl-12 @endif">
      <div class="card ff-secondary">
        <div class="card-header p-2">
          <div class="d-flex align-items-center">
            <h5 class="card-title flex-grow-1 mb-0"> <i class="ri-add-line me-1 align-bottom"></i>
              Malzemeler</h5>
            <div class="flex-shrink-0">
              <button wire:click="detay_goster({{ !$details }})"
                      class="btn btn-soft-primary waves-effect waves-light"><i
                   class="ri-stack-fill me-1 align-bottom"></i> Detaylı Liste
              </button>
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
            @if (!$ch)
              <div class="col-md-3">
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

            <div class="col-md-2">
              <div class="search-box">
                <input type="text" class="form-control search m-1" wire:model.debounce.500ms="code"
                       placeholder="Malzeme Kodu Ara">
                <i class="ri-search-line search-icon"></i>
              </div>
            </div>

            <div class="col-md-3">
              <div class="search-box">
                <input type="text" class="form-control search m-1" wire:model.debounce.500ms="search"
                       placeholder="Malzeme Adı Ara">
                <i class="ri-search-line search-icon"></i>
              </div>
            </div>

            @if (!$item_id)
              <div class="col-md-2">
                <select class="form-select m-1" wire:model="tur">
                  <option value="">-- Cart Tipi Seç --</option>
                  @foreach ($item_type as $i)
                    <option value="{{ $i->cardtype_name }}">{{ $i->cardtype_name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-2">
                <select class="form-select m-1" wire:model.lazy="stur">
                  <option value="">-- Malzeme Tipi Seç --</option>
                  @foreach ($stock_type as $i)
                    @if ($i->stock_type)
                      <option value="{{ $i->stock_type }}">{{ $i->stock_type }}</option>
                    @endif
                  @endforeach
                </select>
              </div>
            @endif
          </div>

          <div class="table-responsive">
            <table class="table-sm table-striped table-nowrap table align-middle" id="itemTable"
                   wire:loading.class="opacity-50">
              <thead class="table-light">
                <tr>
                  <th class="sort" data-sort="kod" scope="col" style="width:55px;"></th>
                  <th class="sort" data-sort="kod" scope="col" style="width:55px;">Kod</th>

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
                    <th class="sort" data-sort="tur" scope="col">Kart Tipi</th>
                    <th class="sort" data-sort="tur" scope="col">Tür</th>
                  @endif
                  <th class="sort" data-sort="tur" scope="col">Detay</th>
                </tr>

              </thead>
              <tbody>

                @foreach ($items as $item)
                  @php
                    $photo = App\Models\LogoItemsPhoto::where('logo_stockref', $item->logicalref)->first();
                    $line = '';
                    if (isset($item_id) && $item_id == $item->logicalref) {
                        $line = 'bg-soft-primary';
                    }
                  @endphp
                  <tr class="{{ $line }}">
                    <td class="owner">
                      @if ($photo)
                        <a href="#" wire:click="foto({{ $item->logicalref }})">
                          <img src="{{ asset('files/images/items/thumb/' . $photo->foto_path) }}"
                               style="width: 50px">
                        </a>
                      @else
                        <a href="#" wire:click="foto({{ $item->logicalref }})">
                          <img style="width: 50px" src="{{ asset('images/default.png') }}">
                        </a>
                      @endif
                    </td>

                    <td class="owner"> {{ $item->stock_code }} </td>

                    @if ($ch)
                      <td class="owner">
                        <button wire:click.prevent="$emit('getItem', {{ $item }})"
                                class="btn btn-outline-danger btn-sm"> Ekle </button>
                      </td>
                    @endif
                    <td>
                      <a href="#" wire:click="foto({{ $item->logicalref }})">
                        <b> {{ $item->stock_name }}</b>
                      </a>
                    </td>
                    <td class="owner"> {{ $item->wh_name }} </td>

                    @if (!$item_id)
                      @if ($details)
                        <td class="owner">{{ $item->onhand_quantity }}</td>
                        <td class="owner">{{ number_format($item->average_price, 2) }}</td>
                        <td class="owner">{{ $item->purchase_quantity }}</td>
                        <td class="owner">{{ number_format($item->purchase_amount, 2) }}</td>
                      @endif

                      <td class="owner">{{ $item->cardtype_name }}</td>
                      <td class="owner">{{ $item->stock_type }}</td>
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

        </div>
      </div>
    </div>

    @if ($item_id)
      <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
        <div class="card">
          <div class="card-body">

            <div class="row">
              <div class="col-12">
                <div class="d-flex justify-content-end">
                  <button wire:click="remove_foto()"
                          class="btn btn-soft-primary waves-effect waves-light btn-sm">Kapat</button>
                </div>
              </div>

              <div class="col-lg-12">
                <h5 class="text-danger">{{ $item->stock_name }}</h5>
                <small>Stok Kodu : <b>{{ $item->stock_code }}</b> </small><br>
                <small>Stok Tipi : <b>{{ $item->stock_type }}</b> </small><br>
                <small>Stok Kartı : <b>{{ $item->cardtype_name }}</b> </small><br>
                <small>Stok Miktarı : <b>
                    @if ($item->onhand_quantity > 0)
                      {{ $item->onhand_quantity }}
                    @else
                      0
                    @endif
                  </b>
                </small>
                <hr>
                @php
                  $son_satinalma = Illuminate\Support\Facades\DB::select(
                      "
                            Exec dbo.sp_get_last_purchase
                            @company_id ='001',
                            @term_id = '09',
                            @rowcount = 5,
                            @item_ref = ?
                            ",
                      [$item_id],
                  );
                @endphp

                @if ($son_satinalma)
                  <h5>Son Satınalma Tutarları</h5>
                  <table class="table-sm table-nowrap table-striped table-bordered table">
                    <thead>
                      <tr>
                        <th scope="col">Cari</th>
                        <th scope="col">Miktar</th>
                        <th scope="col">Birim Fiyat</th>
                        <th scope="col">Toplam</th>
                        <th scope="col">Tarih</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($son_satinalma as $s)
                        <tr>

                          <td>{{ $s->account_name }}</td>
                          <td>{{ number_format($s->quantity, 0, '.', ',') }} {{ $s->unit_code }}</td>
                          <td>{{ number_format($s->unit_price, 2, '.', ',') }}</td>
                          <td>{{ number_format($s->amount, 2, '.', ',') }}</td>
                          <td>{{ $s->po_date }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                @endif

              </div>

              @if ($item_photos)
                <div class="col-lg-12">
                  <div class="row">
                    @foreach ($item_photos as $p)
                      <div class="col-xxl-6 col-xl-6 col-sm-12">
                        <img class="img-fluid m-2 mx-auto border p-1"
                             src="{{ asset('files/images/items/' . $p->foto_path) }}">
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
