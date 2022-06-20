<div>
  <div id="MalzemeFotoModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

  <div id="iptalModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="fullscreeexampleModalLabel">Onay</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>
        <div class="modal-body m-0">
          @if ($iptal_id)
            <div class="mb-3">
              <label for="customer-name" class="col-form-label">İptal Sebebi</label>
              <input wire:model.defer="iptal_sebep" type="text" class="form-control">
            </div>
          @endif
        </div>

        <div class="modal-footer">
          <button wire:click="cikar({{ $iptal_id }})" class="btn btn-primary">Onayla</button>
          <button class="btn btn-light" data-bs-dismiss="modal">Kapat</button>
        </div>
      </div>
    </div>
  </div>



  @if ($talep_detay)

    <div class="card">
      <div class="card-header">

        @if ($talep->demand_type == 1)
          @php
            $w1 = App\Models\LogoWarehouses::where('warehouse_no', $talep->warehouse_no)->first();
          @endphp
          <h5 class="text-info"> {{ $w1->warehouse_name }} Malzeme Talebi</h5>
        @else
          @php
            $w1 = App\Models\LogoWarehouses::where('warehouse_no', $talep->warehouse_no)->first();
            $w2 = App\Models\LogoWarehouses::where('warehouse_no', $talep->dest_wh_no)->first();
          @endphp
          <h5 class="text-info">{{ $w1->warehouse_name }} <i class="ri-share-forward-2-line"></i>
            {{ $w2->warehouse_name }} Malzeme Transferi</h5>
        @endif
        <h4 class="card-title flex-grow-1 mb-0"><small>#{{ $talep->id }}
            @if ($talep->demand_desc)
              | {{ $talep->demand_desc }}
            @endif
          </small></h4>
      </div>

      <div class="card-body">
        <div class="row">
          <div class="col-lg-12">
            <table class="table-light table-sm table-striped table align-middle">
              <thead>
                <tr>
                  <th scope="col" style="width:50px;">Foto</th>
                  <th scope="col">Malzeme</th>
                  <th scope="col">Talep </th>
                  <th scope="col">Stok</th>
                  @if ($for_manage)
                    <th scope="col" style="width:90px;">Karşıla</th>
                    <th scope="col" style="width:90px;">Satınal</th>
                    <th scope="col" style="width:90px;"></th>
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
                    $disable="";
                    $disable2="";
                    $stok = $dt->quantity;
                    if ($item_detail->onhand_quantity >= $dt->quantity) {
                        $val = $dt->quantity;
                    }
                    
                    if ($item_detail->onhand_quantity < $dt->quantity) {
                        $val = $item_detail->onhand_quantity;
                        $val2 = $dt->quantity - $item_detail->onhand_quantity;
                    }
                    
                    if ($item_detail->onhand_quantity == 0) {
                        $val = 0;
                        $disable="disabled"; // eğer stok yoksa karşılama input alanı disable edilir.
                        $val2 = $dt->quantity;
                    }
                    
                    if ($item_detail->onhand_quantity < 0) {
                        $val = 0;
                        $val2 = 0;
                    }
                    if ($dt->approved_consump > 0 && $dt->approved_consump != null) {
                        $val = $dt->approved_consump;
                    }
                    
                    if ($dt->approved_purchase > 0 && $dt->approved_purchase != null) {
                        $val2 = $dt->approved_purchase;
                    }
                    
                  @endphp
                  <tr>
                    <td class="owner">
                      @if ($photo)
                        <a href="javascript:;" wire:click="foto_goster({{ $dt->logo_stock_ref }})">
                          <img class="border"
                               src="{{ asset('public/storage/images/items/thumb/' . $photo->foto_path) }}"
                               style="height: 65px">
                        </a>
                      @else
                        <a href="javascript:;" wire:click="foto_goster({{ $dt->logo_stock_ref }})">
                          <img class="border" style="height: 50px" src="/public/images/default.png">
                        </a>
                      @endif
                    </td>

                    <td><b>{{ $item_detail->stock_name }}</b>
                      <br>
                      <small>Stok Kodu: {{ $item_detail->stock_code }}</small><br>
                      <small class="text-danger">Talep Nedeni : {{ $dt->description }}</small>

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

                        <input type="number" min="0" class="form-control"
                               max="{{ $item_detail->onhand_quantity }}" onkeyup=imposeMinMax(this)
                               wire:loading.attr="disabled" @if ($dt->status > 0 || $talep->approved == 1) disabled @endif
                               {{ $disable }}
                               wire:model.debunce.1500ms="karsila.{{ $dt->demand_id }}.{{ $dt->id }}" x-data
                               x-init="@this.set('karsila.{{ $dt->demand_id }}.{{ $dt->id }}', '{{ number_format($val, 0, '.', ',') }}')">
                      </td>

                      <td>
                        <input type="number" min="0" @if ($dt->status > 0 || $talep->approved == 1) disabled @endif
                               wire:model.debunce.1500ms="satinal.{{ $dt->demand_id }}.{{ $dt->id }}"
                               x-init="@this.set('satinal.{{ $dt->demand_id }}.{{ $dt->id }}', '{{ number_format($val2, 0, '.', ',') }}')" class="form-control" wire:loading.attr="disabled">
                      </td>

                      <td>
                        @if ($talep->approved == 1)
                          <span class="badge badge-label bg-success">
                            <i class="mdi mdi-circle-medium"></i>
                            Onaylandı
                          </span>
                        @else
                          <button wire:click="iptal({{ $dt->id }})" class="btn btn-sm btn-soft-danger"
                                  wire:loading.attr="disabled" @if ($dt->status > 0) disabled @endif>
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
              <div class="alert alert-success" role="alert">
                Bu Malzeme talebi işleme alınmıştır.
              </div>
            </div>
          @else
            @if ($for_manage)
              <div class="col-lg-12">
                <div class="row">

                  @if (isset($karsila))
                    @if (isset($karsila[$talep_id]))
                      <div class="col-lg-6">
                        <div class="p-3" style="background-color: rgb(235, 255, 236)">
                          <h5><b>Stoktan Karşılama Listesi</b></h5>

                          <table class="table-sm table-striped table border align-middle" style="width: 100%">
                            <thead class="table-success">
                              <tr>
                                <th scope="col">Kodu</th>
                                <th scope="col">Malzeme</th>
                                <th scope="col">Miktar</th>
                              </tr>
                            </thead>
                            <tbody>
                              @php
                                $k_have = false; // stoktan karşılama malzemesi yok default
                              @endphp

                              @foreach ($karsila[$talep_id] as $item_id => $miktar)
                                @php
                                  // eğer malzeme talebine bir işlem yapılmadıysa
                                  if ($karsila[$talep_id][$item_id] == 0 && $satinal[$talep_id][$item_id] == 0) {
                                      $uyari = true;
                                  }
                                @endphp

                                @if ($miktar > 0)
                                  @php
                                    $k_have = true; // stoktan karşılama malzemesi var
                                    $itm = json_decode($talep_line[$talep_id][$item_id]);
                                  @endphp
                                  <tr>
                                    <th scope="row">{{ $itm->stock_code }}
                                    </th>
                                    <td>{{ $itm->stock_name }} </td>
                                    <td>{{ $miktar }} </td>
                                  </tr>
                                @endif
                              @endforeach

                              @if (!$k_have)
                                <tr>
                                  <td colspan="3" class="p-3">
                                    <center>Stoktan Karşılama Listesi Boş</center>
                                  </td>
                                </tr>
                              @endif

                            </tbody>
                          </table>
                        </div>
                      </div>
                    @endif
                  @endif


                  @if (isset($satinal))
                    @if (isset($satinal[$talep_id]))
                      <div class="col-lg-6">
                        <div class="p-3" style="background-color: rgb(255, 250, 201)">
                          <h5><b>Satın Alma Listesi</b></h5>
                          <table class="table-sm table-striped table border align-middle" style="width: 100%">
                            <thead class="table-warning">
                              <tr>
                                <th scope="col">Kodu</th>
                                <th scope="col">Malzeme</th>
                                <th scope="col">Miktar</th>
                              </tr>
                            </thead>
                            <tbody>
                              @php
                                $s_have = false; // satın alma malzemesi yok default
                              @endphp

                              @foreach ($satinal[$talep_id] as $item_id => $miktar)
                                @if ($miktar > 0)
                                  @php
                                    $s_have = true; // satın alma malzemesi var
                                    
                                    $itm = json_decode($talep_line[$talep_id][$item_id]);
                                  @endphp
                                  <tr>
                                    <th scope="row">{{ $itm->stock_code }}
                                    </th>
                                    <td>{{ $itm->stock_name }} </td>
                                    <td>{{ $miktar }}</td>
                                  </tr>
                                @endif
                              @endforeach
                              @if (!$s_have)
                                <td colspan="3" class="p-3">
                                  <center>Satınalma Listesi Boş</center>
                                </td>
                              @endif
                            </tbody>
                          </table>

                        </div>
                      </div>
                    @endif
                  @endif


                  <div class="col-lg-12 mt-3">
                    Yetkili personel stoktan karşılama yada satınalma veri giriş alanlarını
                    değiştirerek kayıt işlemi yapmalıdır.
                  </div>

                  @if ($uyari)
                    <div class="col-lg-12 mt-3">
                      <div class="alert alert-danger mb-xl-0" role="alert">
                        <strong> Dikkat </strong> Bazı malzemelerde işlem yapılmamıştır.
                      </div>
                    </div>
                  @endif

                  @if ($error)
                    <div class="col-lg-12 mt-3">
                      <div class="alert alert-danger" role="alert">
                        {{ $error }}
                      </div>
                    </div>
                  @endif

                  @if (session()->has('success'))
                    <div class="col-lg-12 mt-3">
                      <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                      </div>
                    </div>
                  @endif

                  <div class="col-lg-12 mt-3">
                    @if (isset($s_have) && isset($k_have))
                      @if ($s_have || $k_have)

                        @if ($talep->approved == 0)
                          <button wire:click="approved();" class="btn btn-success btn-lg btn-label"
                                  wire:loading.attr="disabled">
                            <i class="ri-check-double-line label-icon fs-16 me-2 align-middle"> </i>
                            Listeyi Onayla
                          </button>
                        @else
                          @if ($talep->demand_type == 1)
                            <button wire:click="kaydet();" class="btn btn-info btn-lg btn-label"
                                    wire:loading.attr="disabled"> <i
                                 class="ri-check-double-line label-icon fs-16 me-2 align-middle"></i>
                              Logo Fişi
                              Oluştur (Sarf)
                            </button>
                          @else
                            <button wire:click="kaydet_transfer();" class="btn btn-info btn-lg btn-label"
                                    wire:loading.attr="disabled"> <i
                                 class="ri-check-double-line label-icon fs-16 me-2 align-middle"></i>
                              Logo Fişi
                              Oluştur (Transfer)
                            </button>
                          @endif

                          <button wire:click="unapproved();" class="btn btn-soft-danger btn-lg btn-label"
                                  wire:loading.attr="disabled"> <i
                               class="ri-check-double-line label-icon fs-16 me-2 align-middle"></i>
                            Onay İptal</button>
                        @endif
                      @else
                        <button class="btn btn-danger btn-lg" disabled> Kaydet</button><br>
                        <small class="text-danger">Kaydedilecek veri yok, lütfen stoktan
                          karşılama yada satınalma veri giriş alanlarını kullanın
                        </small>
                      @endif

                    @endif

                    <div wire:loading>
                      <i class="mdi mdi-spin mdi-cog-outline fs-22"></i> Lütfen Bekleyiniz...
                    </div>

                  </div>
                </div>
              </div>
            @endif




          @endif
        </div>
      </div>
    </div>
  @endif




</div>
