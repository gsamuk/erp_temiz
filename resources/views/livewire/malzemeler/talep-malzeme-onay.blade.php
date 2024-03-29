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
            margin-bottom: 20px;
            padding: 5px;
            display: block;
            border: 1px solid rgb(205, 205, 206);
            border-left: 13px solid rgb(190, 192, 193);
          }

          table td {
            display: block;
            text-align: right;
            font-size: 1.2em;

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
      @if ($data->count() > 0)

        <table class="table-sm table-striped table-nowrap table align-middle">
          <thead class="table-light">
            <tr>
              <th scope="col">Talep Eden</th>
              <th scope="col">Onaya Gönderen</th>
              <th scope="col">Talep Türü</th>

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
                
                $w1 = App\Models\LogoWarehouses::where('warehouse_no', "$dt->warehouse_no")
                    ->where('company_no', 1)
                    ->first();
                
                $w2 = App\Models\LogoWarehouses::where('warehouse_no', "$dt->dest_wh_no")
                    ->where('company_no', 1)
                    ->first();
                
                $submit_user = null;
                if ($dt->submit_user_id > 0) {
                    $submit_user = Erp::user($dt->submit_user_id);
                }
                
              @endphp
              <tr>
                <td data-label="Talep Eden">
                  <div class="d-flex align-items-center gap-2">
                    <div class="flex-shrink-0">
                      @if ($dt->photo_path)
                        <img class="avatar-xs rounded-circle"
                             _src="https://mobile.zeberced.net/files/{{ $dt->foto_path }}"
                             src="{{ asset('files/images/users/' . $dt->photo_path) }}">
                      @else
                        <img src="assets/images/users/avatar-3.jpg" alt=""
                             class="avatar-xs rounded-circle">
                      @endif
                    </div>
                    <div class="flex-grow-1">
                      {{ $dt->name }} <br>{{ $dt->surname }}
                    </div>
                  </div>

                </td>


                <td data-label="Onaya Gönderen">
                  <div class="d-flex align-items-center gap-2">
                    <div class="flex-shrink-0">
                      @if ($submit_user->photo_path)
                        <img class="avatar-xs rounded-circle"
                             _src="https://mobile.zeberced.net/files/{{ $submit_user->foto_path }}"
                             src="{{ asset('files/images/users/' . $submit_user->photo_path) }}">
                      @else
                        <img src="assets/images/users/avatar-3.jpg" alt=""
                             class="avatar-xs rounded-circle">
                      @endif
                    </div>
                    <div class="flex-grow-1">
                      {{ $submit_user->name }} <br>{{ $submit_user->surname }}
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


                <td data-label="Malzeme">
                  <b><a href="javascript:;" wire:click="foto_goster({{ $dt->logo_stock_ref }})">
                      {{ $dt->stock_name }} </a></b>
                  @if ($dt->account_name)
                    <br>
                    <button wire:click="firma_sec({{ $dt->dt_id }}, {{ $dt->logo_stock_ref }}, '{{ $dt->stock_name }}')"
                            class="btn btn-sm btn-outline-info">Değiştir</button>
                    <small class="text-info">Firma: {{ $dt->account_name }}</small>
                  @else
                    <br>
                    <button wire:click="firma_sec({{ $dt->dt_id }}, {{ $dt->logo_stock_ref }}, '{{ $dt->stock_name }}')"
                            class="btn btn-sm btn-outline-info">Firma
                      Seç</button>
                  @endif
                </td>

                <td data-label="İstenen">{{ number_format($dt->quantity, 0, ',', '.') }}
                  <br><small>{{ $dt->unit_code }}</small>
                </td>
                <td data-label="Stok" class="text-danger">
                  {{ number_format($item_detail->onhand_quantity, 0, ',', '.') }}
                  <br><small>{{ $dt->unit_code }}</small>
                </td>

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

                  <div class="btn-group">
                    <button type="button"
                            wire:click="onay(
                        '{{ $dt->dt_id }}', 
                        $('#cons_{{ $dt->dt_id }}').val(),
                        $('#purc_{{ $dt->dt_id }}').val(),
                        )"
                            class="btn btn-success">Onay</button>
                    <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item"
                         wire:click="onay(
                          '{{ $dt->dt_id }}', 
                          $('#cons_{{ $dt->dt_id }}').val(),
                          $('#purc_{{ $dt->dt_id }}').val(),
                          )">
                        Onayla</a>
                      <a class="dropdown-item"
                         wire:click="popup_onay('{{ $dt->dt_id }}',
                         $('#cons_{{ $dt->dt_id }}').val(), 
                         $('#purc_{{ $dt->dt_id }}').val(),
                          6)">Not
                        Ekle & Onayla</a>
                    </div>
                  </div>

                  <div class="btn-group">
                    <button type="button" wire:click="islem('{{ $dt->dt_id }}',7)"
                            class="btn btn-danger">Red</button>
                    <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" wire:click="islem('{{ $dt->dt_id }}',7)">Reddet</a>
                      <a class="dropdown-item" wire:click="popup_red('{{ $dt->dt_id }}',7)">Not
                        Ekle
                        & Reddet</a>
                    </div>
                  </div>
                </td>
              </tr>
            @endforeach

          </tbody>
        </table>
        <div class="d-flex justify-content-end mt-3">
          {{ $data->links() }}
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
                             src="https://mobile.zeberced.net/files/{{ $p->foto_path }}"
                             _src="{{ asset('files/images/items/' . $p->foto_path) }}">
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


  <div id="NotModal" class="modal" tabindex="-1" role="dialog"
       aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            @if ($pop_item_val == 6)
              Onay
            @else
              Reddet
            @endif
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>
        <div class="modal-body m-0">
          @if ($pop_item_id)
            <div class="mb-3">
              <label for="customer-name" class="col-form-label">Bilgi Notu Yazabilirsiniz.</label>
              <input wire:model.defer="bilgi_notu" type="text" class="form-control">
            </div>
          @endif
        </div>

        <div class="modal-footer">
          @if ($pop_item_val == 6)
            <button data-bs-dismiss="modal" wire:click="_onay()" class="btn btn-success">Onayla</button>
          @endif

          @if ($pop_item_val == 7)
            <button data-bs-dismiss="modal" wire:click="_red()" class="btn btn-danger">Reddet</button>
          @endif

          <button class="btn btn-light" data-bs-dismiss="modal">Kapat</button>
        </div>
      </div>
    </div>
  </div>

  <div id="FirmaSecModal" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>
        <div class="modal-body m-0">
          @if ($item_ref)
            @livewire('logo.accounts')
          @endif
        </div>
      </div>
    </div>
  </div>

</div>
