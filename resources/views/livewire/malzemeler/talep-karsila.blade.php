<div>

  <div id="MalzemeFotoModal"
       class="modal"
       tabindex="-1"
       role="dialog"
       aria-labelledby="myModalLabel"
       aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"> </button>
        </div>
        <div class="modal-body m-0">
          @if ($item_id)
            <div class="row">
              <div class="col-lg-6">
                <h5 class="text-danger">{{ $item->stock_name }}</h5>
                <small>Stok Kodu : <b>{{ $item->stock_code }}</b> </small><br>
                <small>Stok Tipi : <b>{{ $item->stock_type }}</b> </small><br>
                <small>Stok Kartı : <b>{{ $item->cardtype_name }}</b> </small><br>
                <small>REf : <b>{{ $item_id }}</b> </small><br>
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

  <div id="iptalModal"
       class="modal"
       tabindex="-1"
       role="dialog"
       aria-labelledby="myModalLabel"
       aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"
              id="fullscreeexampleModalLabel">Onay</h5>
          <button type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"> </button>
        </div>
        <div class="modal-body m-0">
          @if ($iptal_id)
            <div class="mb-3">
              <label for="customer-name"
                     class="col-form-label">İptal Sebebi</label>
              <input wire:model.defer="iptal_sebep"
                     type="text"
                     class="form-control">
            </div>
          @endif
        </div>

        <div class="modal-footer">
          <button wire:click="cikar({{ $iptal_id }})"
                  class="btn btn-primary">Onayla</button>
          <button class="btn btn-light"
                  data-bs-dismiss="modal">Kapat</button>
        </div>
      </div>
    </div>
  </div>

  <div id="editLineModal"
       class="modal"
       tabindex="-1"
       role="dialog"
       aria-labelledby="myModalLabel"
       aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Miktar Düzenle</h5>
          <button type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"> </button>
        </div>
        <div class="modal-body m-0">
          @if ($edit_line_id)
            <div class="mb-3">
              <label for="customer-name"
                     class="col-form-label">Yeni Miktarı Giriniz</label>
              <input wire:model.defer="line_quantity"
                     type="number"
                     class="form-control">
              <br>
              {{ $line_item_name }}
            </div>
          @endif
        </div>

        <div class="modal-footer">
          <button wire:click="update_line({{ $edit_line_id }})"
                  class="btn btn-primary">Onayla</button>
          <button class="btn btn-light"
                  data-bs-dismiss="modal">Kapat</button>
        </div>
      </div>
    </div>
  </div>

  @if ($talep_detay)

    <div class="card">
      <div class="card-header">
        @php
          $w1 = App\Models\LogoWarehouses::where('warehouse_no', "$talep->warehouse_no")
              ->where('company_no', 1)
              ->first();
        @endphp
        <h5 class="text-info"> {{ $w1->warehouse_name }} Malzeme Talebi</h5>
        <h4 class="card-title flex-grow-1 mb-0"><small>#{{ $talep->id }}
            @if ($talep->demand_desc)
              | {{ $talep->demand_desc }}
            @endif
          </small>
        </h4>
      </div>

      <div class="card-body">
        <div class="row">
          <div class="col-lg-12">
            <table class="table-light table-sm table-striped table align-middle">
              <thead>
                <tr>
                  <th scope="col"
                      style="width:50px;">Foto</th>
                  <th scope="col">Malzeme</th>
                  <th scope="col">Talep </th>
                  <th scope="col">Stok</th>
                  @if ($for_manage)
                    <th scope="col"
                        style="width:90px;">Karşıla</th>
                    <th scope="col"
                        style="width:90px;">Satınal</th>
                    <th scope="col"
                        style="width:90px;"></th>
                  @endif
                </tr>
              </thead>
              <tbody>
                @foreach ($talep_detay as $dt)
                  @php
                    $photo = App\Models\LogoItemsPhoto::where('logo_stockref', $dt->logo_stock_ref)->first();
                    $item_detail = App\Models\LogoItems::where('logicalref', $dt->logo_stock_ref)
                        ->where('wh_no', $talep->warehouse_no)
                        ->first();
                    
                    $val = 0;
                    $val2 = 0;
                    $disabled = '';
                    
                    // eğer stok talebi karşılıyorsa
                    if ($item_detail->onhand_quantity >= $dt->quantity) {
                        $val = $dt->quantity;
                    }
                    
                    //eğer stok eldeki miktardan azsa
                    if ($item_detail->onhand_quantity < $dt->quantity) {
                        $val = $item_detail->onhand_quantity;
                        $val2 = $dt->quantity - $item_detail->onhand_quantity;
                    }
                    
                    // eğer stok 0 ise
                    if ($item_detail->onhand_quantity == 0) {
                        $val = 0;
                        $val2 = $dt->quantity;
                    
                        $disabled = 'disabled'; // alan disable ediliyor
                    }
                    
                    // eğer stok eksi ise
                    if ($item_detail->onhand_quantity < 0) {
                        $val = 0;
                        $val2 = 0;
                    
                        $disabled = 'disabled'; // alan disable ediliyor
                    }
                    
                    // eğer onaylı karşılama varsa
                    if ($dt->approved_consump > 0 && $dt->approved_consump != null) {
                        $val = $dt->approved_consump;
                    }
                    
                    //eğer onaylı satınalma varsa
                    if ($dt->approved_purchase > 0 && $dt->approved_purchase != null) {
                        $val2 = $dt->approved_purchase;
                    }
                    
                  @endphp
                  <tr>
                    <td class="owner">
                      @if ($photo)
                        <a href="javascript:;"
                           wire:click="foto_goster({{ $dt->logo_stock_ref }})">
                          <img class="border"
                               src="{{ asset('public/storage/images/items/thumb/' . $photo->foto_path) }}"
                               style="height: 65px">
                        </a>
                      @else
                        <a href="javascript:;"
                           wire:click="foto_goster({{ $dt->logo_stock_ref }})">
                          <img class="border"
                               style="height: 50px"
                               src="/public/images/default.png">
                        </a>
                      @endif
                    </td>

                    <td><b>{{ $item_detail->stock_name }}</b>
                      <br>
                      <small>Stok Kodu: {{ $item_detail->stock_code }}</small>
                    </td>
                    <td>
                      <b style="font-size:1.1em"
                         class="text-danger">{{ number_format($dt->quantity, 0, '.', ',') }}</b>
                      <button class="btn btn-sm btn-ghost-info p-0"
                              wire:click="edit_line({{ $dt->id }},'{{ $item_detail->stock_name }}')"><i
                           class="ri-edit-line fs-17 lh-1 m-1 align-middle"></i></button>
                      <br><small>{{ $dt->unit_code }}</small>
                    </td>
                    <td><b
                         style="font-size:1.1em">{{ number_format($item_detail->onhand_quantity, 0, '.', ',') }}</b>
                      <br><small>{{ $dt->unit_code }}</small>
                    </td>
                    @if ($for_manage)
                      <td>
                        <input type="hidden" x-data x-init="@this.set('talep_line.{{ $dt->demand_id }}.{{ $dt->id }}', '{{ $item_detail }}')">

                        <input type="number" {{ $disabled }}
                               @if ($talep->approved == 1) disabled @endif
                               min="0"
                               class="form-control"
                               max="{{ $item_detail->onhand_quantity }}"
                               wire:loading.attr="disabled"
                               wire:model.debunce.500ms="konay.{{ $dt->id }}"
                               x-init="@this.set('konay.{{ $dt->id }}', '{{ number_format($val, 0, '.', ',') }}')">
                      </td>

                      <td>
                        <input type="number"
                               @if ($talep->approved == 1) disabled @endif
                               min="0"
                               wire:model.debunce.500ms="sonay.{{ $dt->id }}"
                               x-init="@this.set('sonay.{{ $dt->id }}', '{{ number_format($val2, 0, '.', ',') }}')"
                               class="form-control"
                               wire:loading.attr="disabled">
                      </td>

                      <td>
                        @if ($talep->approved == 1)
                          <span class="badge badge-label bg-info">
                            <i class="mdi mdi-circle-medium"></i>
                            Onaylı
                          </span>
                        @else
                          <button wire:click="iptal({{ $dt->id }})"
                                  class="btn btn-sm btn-soft-danger"
                                  wire:loading.attr="disabled"
                                  @if ($dt->status > 0) disabled @endif>
                            Çıkar
                          </button>
                        @endif
                      </td>
                    @endif

                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>


          @if ($talep->status == 1)
            <!-- Herhangi biri işelm görmüşse -->
            <div class="col-lg-12">
              <div class="alert alert-success"
                   role="alert">
                Bu Malzeme talebi işleme alınmıştır.
              </div>
            </div>
          @else
            @if ($for_manage)
              <div class="col-lg-12">
                <div class="row">
                  @php
                    $data = App\Models\DemandDetail::Where('demand_id', $talep_id)
                        ->Where('approved_consump', '>', '0')
                        ->get();
                  @endphp

                  @if ($data->count() > 0)
                    <div class="col-lg-12 mt-3">
                      <div class="p-3"
                           style="background-color: rgb(235, 255, 236)">
                        <h5><b>Stoktan Karşılama Listesi</b></h5>
                        <table class="table-sm table-striped table border align-middle">
                          <thead class="table-success">
                            <tr>
                              <th scope="col">Kodu</th>
                              <th scope="col">Malzeme</th>
                              <th scope="col">Miktar</th>
                              <th scope="col">Birim Tutar</th>
                              <th scope="col">Toplam</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($data as $itm)
                              @php
                                $item = App\Models\LogoItems::where('wh_no', "$talep->warehouse_no")
                                    ->where('stock_code', "$itm->stock_code")
                                    ->first();
                                $toplam = $item->average_price * $itm->approved_consump;
                              @endphp
                              <tr>
                                <th scope="row">{{ $itm->stock_code }} </th>
                                <td>{{ $item->stock_name }} </td>
                                <td>{{ number_format($itm->approved_consump, 0, '', '') }}
                                  <small>{{ $itm->unit_code }}</small>
                                </td>

                                <td> {{ number_format($item->average_price, 2, ',', '.') }} </td>
                                <td>
                                  {{ number_format($toplam, 2, ',', '.') }}
                                </td>
                              </tr>
                            @endforeach

                          </tbody>
                        </table>
                      </div>
                    </div>
                  @endif


                  @php
                    $data = App\Models\DemandDetail::Where('demand_id', $talep_id)
                        ->Where('approved_purchase', '>', '0')
                        ->get();
                    
                  @endphp


                  @if ($data->count() > 0)
                    <div class="col-lg-12 mt-3">
                      <div class="p-3"
                           style="background-color: rgb(255, 250, 201)">
                        <h5><b>Satın Alma Listesi</b></h5>
                        <table class="table-sm table-striped table border align-middle"
                               style="width: 100%">
                          <thead class="table-warning">
                            <tr>
                              <th scope="col">Kodu</th>
                              <th scope="col">Malzeme</th>
                              <th scope="col">Miktar</th>
                              <th scope="col">Birim Tutar</th>
                              <th scope="col">Toplam</th>
                              <th scope="col">Firma</th>
                            </tr>
                          </thead>
                          <tbody>

                            @foreach ($data as $itm)
                              @php
                                $item = App\Models\LogoItems::where('wh_no', "$talep->warehouse_no")
                                    ->where('stock_code', "$itm->stock_code")
                                    ->first();
                                $toplam = $item->average_price * $itm->approved_purchase;
                              @endphp
                              <tr>
                                <th scope="row">{{ $itm->stock_code }} </th>
                                <td>{{ $item->stock_name }} </td>
                                <td>{{ number_format($itm->approved_purchase, 0, '', '') }}
                                  <small>{{ $itm->unit_code }}</small>
                                </td>
                                <td> {{ number_format($item->average_price, 2, ',', '.') }} </td>
                                <td>
                                  {{ number_format($toplam, 2, ',', '.') }}
                                </td>

                                <td><button class="btn btn-sm btn-soft-danger">Firma Seç</button></td>
                              </tr>
                            @endforeach

                          </tbody>
                        </table>

                      </div>
                    </div>
                  @endif



                  <div class="col-lg-12 mt-3">

                    @if ($talep->approved == 0)
                      <button wire:click="approved"
                              wire:loading.attr="disabled"
                              class="btn btn-success btn-label">
                        <i class="ri-check-double-line label-icon fs-16 me-2 align-middle"> </i>
                        Listeyi Onayla
                      </button>
                    @else
                      <button wire:click="kaydet"
                              wire:loading.attr="disabled"
                              class="btn btn-info btn-label">
                        <i class="ri-check-double-line label-icon fs-16 me-2 align-middle"> </i>
                        Logo Fişi Oluştur (Sarf)
                      </button>

                      <button wire:click="unapproved"
                              wire:loading.attr="disabled"
                              class="btn btn-soft-danger btn-sm position-absolute end-0 top-50">
                        Onay İptal</button>
                    @endif




            @endif

          @endif
        </div>


      </div>
    </div>


  @endif

  <div wire:loading.flex> İşleniyor...</div>
</div>
