<div>
  <div class="card">
    <div class="card-header align-items-center d-flex">
      <h4 class="card-title flex-grow-1 mb-0">Onay Bekleyen Melzemeler</h4>

    </div><!-- end card header -->
    <div class="card-body">
      <style>
        @media screen and (max-width: 600px) {

          table {
            border: none;
          }

          table thead {
            display: none;
          }

          table tr {
            margin-bottom: 10px;
            padding: 5px;
            display: block;
            border: 1px solid rgb(221, 219, 219);
          }

          table td {
            display: block;
            text-align: right;

            font-size: 1.1em;
            border-bottom: 1px dashed rgb(178, 174, 174);
          }

          table td:last-child {
            border-bottom: 0;
          }

          table td:before {
            content: attr(data-label);
            float: left;
            font-weight: bold;
            font-size: 12px;
          }
        }
      </style>

      @if ($data->count() > 0)
        <div class="row mb-2">
          <div class="col-md-4">
            <div class="search-box">
              <input type="text" class="form-control search m-1" wire:model.debounce.500ms="owner"
                     placeholder="Talep Sahibi Ara">
              <i class="ri-search-line search-icon"></i>
            </div>
          </div>

          <div class="col-md-4">
            <div class="search-box">
              <input type="text" class="form-control search m-1" wire:model.debounce.500ms="search"
                     placeholder="Malzeme Adı Ara">
              <i class="ri-search-line search-icon"></i>
            </div>
          </div>
          <div class="col-md-4">
            <div wire:loading>
              <i class="mdi mdi-spin mdi-cog-outline fs-22"></i> Lütfen Bekleyiniz...
            </div>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table-sm table-striped table-nowrap table align-middle">
            <thead class="table-light">
              <tr>
                <th scope="col">Talep Eden</th>
                <th scope="col">Talep Türü</th>
                <th scope="col"></th>
                <th scope="col">Malzeme</th>
                <th scope="col">İstenen</th>
                <th scope="col">Stok</th>

                <th scope="col" style="width:90px;">Karşıla</th>
                <th scope="col" style="width:90px;">Satınal</th>
                <th scope="col">Birim Fiyatı</th>
                <th scope="col">Toplam</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $dt)
                @php
                  
                  $item_detail = App\Models\LogoItems::where('logicalref', $dt->logo_stock_ref)
                      ->where('wh_no', $dt->warehouse_no)
                      ->first();
                  
                  $photo = App\Models\LogoItemsPhoto::where('logo_stockref', $dt->logo_stock_ref)->first();
                  
                  $w1 = App\Models\LogoWarehouses::where('warehouse_no', "$dt->warehouse_no")
                      ->where('company_no', 1)
                      ->first();
                  
                  $w2 = App\Models\LogoWarehouses::where('warehouse_no', "$dt->dest_wh_no")
                      ->where('company_no', 1)
                      ->first();
                  
                @endphp
                <tr>
                  <td data-label="Talep Eden">
                    <div class="d-flex align-items-center gap-2">
                      <div class="flex-shrink-0">
                        @if ($dt->photo_path)
                          <img class="avatar-xs rounded-circle"
                               src="{{ asset('public/storage/images/users/' . $dt->photo_path) }}">
                        @else
                          <img src="assets/images/users/avatar-3.jpg" alt=""
                               class="avatar-xs rounded-circle">
                        @endif
                      </div>
                      <div class="flex-grow-1">
                        {{ $dt->name }} {{ $dt->surname }}
                      </div>
                    </div>

                  </td>
                  <td data-label="Talep Türü">
                    @if ($dt->demand_type == 1)
                      <small>
                        Depo Sarf <br>{{ $w1->warehouse_name }}</small>
                    @else
                      <small> Depo Transfer <br>
                        {{ $w1->warehouse_name }} > {{ $w2->warehouse_name }}
                      </small>
                    @endif
                  </td>
                  <td data-label="Foto">
                    @if ($photo)
                      <a href="javascript:;"
                         wire:click="foto_goster({{ $dt->logo_stock_ref }})">
                        <img class="border"
                             src="{{ asset('public/storage/images/items/thumb/' . $photo->foto_path) }}"
                             style="height: 35px">
                      </a>
                    @endif
                  </td>

                  <td data-label="Malzeme">
                    <b><a href="javascript:;" wire:click="foto_goster({{ $dt->logo_stock_ref }})">
                        {{ $dt->stock_name }} </a></b><br>
                    <small class="text-warning">Neden: {{ $dt->description }}</small>
                  </td>

                  <td data-label="İstenen">{{ number_format($dt->quantity, 0, ',', '.') }}
                    <br><small>{{ $dt->unit_code }}</small>
                  </td>
                  <td data-label="Stok" class="text-danger">
                    {{ number_format($item_detail->onhand_quantity, 0, ',', '.') }}</td>

                  <td data-label="Karşıla">
                    <input type="number" class="form-control" id="cons_{{ $dt->dt_id }}"
                           @if ($item_detail->onhand_quantity == 0 || $dt->dt_status == 6) disabled @endif
                           min="0"
                           value="{{ number_format($dt->approved_consump, 0, ',', '.') }}"
                           class="form-control"
                           max="{{ $item_detail->onhand_quantity }}"
                           onkeyup=imposeMinMax(this)>
                  </td>

                  <td data-label="Satınal">
                    <input type="number" class="form-control" id="purc_{{ $dt->dt_id }}"
                           @if ($dt->dt_status == 6) disabled @endif
                           min="0"
                           value="{{ number_format($dt->approved_purchase, 0, ',', '.') }}"
                           class="form-control">
                  </td>

                  <td data-label="Birim Fiyatı">{{ number_format($dt->average_price, 2, ',', '.') }}</td>
                  <td data-label="Toplam">
                    {{ number_format($dt->approved_consump * $dt->average_price, 2, ',', '.') }}</td>

                  <td data-label="Onay / Red">

                    <button wire:click="onay(
                      '{{ $dt->dt_id }}', 
                      $('#cons_{{ $dt->dt_id }}').val(),
                      $('#purc_{{ $dt->dt_id }}').val(),
                      )"
                            class="btn btn-sm btn-soft-success">Onayla</button>
                    <button wire:click="islem('{{ $dt->dt_id }}',9)" class="btn btn-sm btn-soft-danger">Red</button>
                  </td>
                </tr>
              @endforeach

            </tbody>
          </table>
          <div class="d-flex justify-content-end mt-3">
            {{ $data->links() }}
          </div>
        </div>
      @else
        <!-- Secondary Alert -->
        <div class="alert alert-warning" role="alert">
          Onay Bekleyen Malzeme Bulunamadı...
        </div>
      @endif



    </div>
  </div>

  <div id="MalzemeFotoModal" class="modal" tabindex="-1" role="dialog"
       aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>
        <div class="modal-body m-0">
          @if ($item_id)
            <div class="row">
              <div class="col-lg-6">
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
                             @rowcount = 10,
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
                          <td>{{ number_format($s->quantity, 0, '.', ',') }}
                            {{ $s->unit_code }}</td>
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
                <div class="col-lg-6">
                  <div class="row">
                    @foreach ($item_photos as $p)
                      <div class="col-xxl-6 col-xl-6 col-sm-12">
                        <img class="img-fluid m-2 mx-auto border p-1"
                             src="{{ asset('public/storage/images/items/' . $p->foto_path) }}">
                      </div>
                    @endforeach
                  </div>
                </div>
              @endif

            </div>
          @endif
        </div>
      </div>
    </div>
  </div>


  <div id="TalepDetayModal" class="modal" tabindex="-1" role="dialog"
       aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>
        <div class="modal-body m-0">
          Detay
        </div>
      </div>
    </div>
  </div>

</div>
