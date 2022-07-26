<div>

  @if ($talep_detay)
    <div class="card">
      <div class="card-header p-2">
        @php
          $w1 = App\Models\LogoWarehouses::where('warehouse_no', "$talep->warehouse_no")
              ->where('company_no', 1)
              ->first();
          $w2 = App\Models\LogoWarehouses::where('warehouse_no', "$talep->dest_wh_no")
              ->where('company_no', 1)
              ->first();
        @endphp

        @if ($talep->demand_type == 1)
          <h6 class="text-info"> {{ $w1->warehouse_name }} Malzeme Talebi </h6>
        @endif

        @if ($talep->demand_type == 2)
          <h6><span class="text-info"> {{ $w1->warehouse_name }} </span> <i class="ri-share-forward-2-line"></i>
            <span class="text-success">{{ $w2->warehouse_name }}</span> Malzeme Transferi
          </h6>
        @endif

        @if ($talep->project_code)
          <h6> Proje Kodu : {{ $talep->project_code }} </h5>
        @endif


        @if ($talep->special_code)
          <h6 class="text-danger">Özel Kod : {{ $talep->special_code }}</h6>
        @endif
        <!-- <button wire:click="$emit('EditDemand',{{ $talep->id }})">Edit</button> -->
      </div>

      <div class="card-body p-2">
        <div class="row">
          <div class="col-lg-12">
            <table class="table-light table-sm table-striped table align-middle">
              <thead>
                <tr>
                  <th scope="col"
                      style="width:50px;">Foto</th>
                  <th scope="col">Stok Kodu / Malzeme</th>
                  <th scope="col">Talep </th>
                  <th scope="col">Stok</th>
                  <th scope="col" style="width:90px;">Karşıla</th>
                  <th scope="col" style="width:90px;">Satınal</th>
                  <th scope="col" style="width:10px;"></th>
                </tr>
              </thead>
              <tbody>

                @php
                  $bir_islem = true;
                @endphp

                @foreach ($talep_detay as $dt)
                  @php
                    $photo = App\Models\LogoItemsPhoto::where('logo_stockref', $dt->logo_stock_ref)->first();
                    $item_detail = App\Models\LogoItems::where('logicalref', $dt->logo_stock_ref)
                        ->where('wh_no', $talep->warehouse_no)
                        ->first();
                    if ($item_detail == null) {
                        continue;
                    }
                    $disabled = null;
                    
                    // eğer stok 0 ise
                    if ($item_detail->onhand_quantity == 0) {
                        //$disabled = 'disabled'; // alan disable ediliyor
                    }
                    
                    // eğer stok eksi ise
                    if ($item_detail->onhand_quantity < 0) {
                        // $disabled = 'disabled'; // alan disable ediliyor
                    }
                    
                    if ($dt->approved_consump > 0 || $dt->approved_purchase > 0) {
                        $uyari = 'table-light';
                    } else {
                        $uyari = 'table-warning';
                        $bir_islem = false;
                    }
                    
                  @endphp
                  <tr class="{{ $uyari }}">
                    <td class="owner">
                      @if ($photo)
                        <a href="javascript:;"
                           wire:click="foto_goster({{ $dt->logo_stock_ref }})">
                          <img class="border"
                               _src="{{ asset('files/images/items/thumb/' . $photo->foto_path) }}"
                               src="https://mobile.zeberced.net/files/{{ $photo->foto_path }}"
                               style="height: 35px">
                        </a>
                      @else
                        <a href="javascript:;"
                           wire:click="foto_goster({{ $dt->logo_stock_ref }})">
                          <img class="border"
                               style="height: 25px"
                               src="images/default.png">
                        </a>
                      @endif
                    </td>

                    <td><small>{{ $item_detail->stock_code }} > </small>
                      <span class="text-primary">{{ $item_detail->stock_name }}</span>
                      @if ($dt->status == 5)
                        <br><small class="text-danger">Yönetimin Onayına Gönderildi... </small>
                      @endif

                      @if ($dt->status == 6)
                        <br><small class="text-success">Yönetim Onayladı... </small>
                      @endif
                    </td>
                    <td>
                      <b class="text-danger">{{ number_format($dt->quantity, 0, '.', ',') }}</b>
                    </td>

                    <td><b>{{ number_format($item_detail->onhand_quantity, 0, '.', ',') }}</b> </td>
                    @if ($for_manage)
                      <td>
                        <input type="hidden" x-data x-init="@this.set('talep_line.{{ $dt->demand_id }}.{{ $dt->id }}', '{{ $item_detail }}')">
                        <input type="number" {{ $disabled }}
                               min="0"
                               class="form-control m-0 p-1"
                               max="{{ $item_detail->onhand_quantity }}"
                               onkeyup=imposeMinMax(this)
                               wire:loading.attr="disabled"
                               wire:model.lazy="konay.{{ $dt->id }}">
                      </td>

                      <td>
                        <input type="number"
                               min="0"
                               wire:loading.attr="disabled"
                               class="form-control m-0 p-1"
                               wire:model.lazy="sonay.{{ $dt->id }}">
                      </td>
                    @else
                      <td> {{ number_format($dt->approved_consump, 0, '.', ',') }}
                        <br><small>{{ $dt->unit_code }}</small>
                      </td>
                      <td> {{ number_format($dt->approved_purchase, 0, '.', ',') }}
                        <br><small>{{ $dt->unit_code }}</small>
                      </td>
                    @endif
                    <td>

                      <div class="dropdown">
                        <a href="#" role="button" id="drop_{{ $dt->id }}" data-bs-toggle="dropdown"
                           aria-expanded="false" class="m-2">
                          <i class="ri-more-2-fill"></i>
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="drop_{{ $dt->id }}" style="">

                          <li><a class="dropdown-item"
                               wire:click="edit_line({{ $dt->id }},'{{ $item_detail->stock_name }}')"
                               href="#">Talep Miktarını Değiştir</a>
                          </li>
                          @if ($dt->status != 5 && $for_manage)
                            <li><a class="dropdown-item" wire:click="onaya_gonder({{ $dt->id }})"
                                 href="#">Yönetim Onayı İste</a></li>
                          @endif
                          <li><a class="dropdown-item" wire:click="iptal({{ $dt->id }})" href="#">Listeden
                              Çıkar</a>
                          </li>

                        </ul>
                      </div>

                    </td>


                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          @if ($talep->approved == 1 && $talep_owner == true)
            <div class="col-lg-12">
              <div class="alert alert-success"
                   role="alert">
                Bu Malzeme talebi onaylanmıştır, İlgili depodan malzemelerinizi teslim alabilirsiniz.
              </div>
            </div>
          @endif

          @if ($talep->status > 1)
            <!-- Herhangi biri işelm görmüşse -->
            <div class="col-lg-12">
              <div class="alert alert-success"
                   role="alert">
                Bu Malzeme talebi işleme alınmıştır.
                <hr>
                <button wire:click="$emit('IslemDetay', {{ $talep->id }})" class="btn btn-danger btn-lg">Fiş
                  Detayına Git</button>

              </div>
            </div>
          @else
            @if ($for_manage)

              <div class="col-lg-12">
                <div class="row">

                  @php
                    $karsilama = false;
                    $satinalma = false;
                    
                    $data = App\Models\DemandDetail::Where('demand_id', $talep_id)
                        ->where('status', '!=', 9)
                        ->where('status', '!=', 5)
                        ->get();
                    foreach ($data as $itm) {
                        if ($itm->approved_consump > 0) {
                            $karsilama = true;
                        }
                    
                        if ($itm->approved_purchase > 0) {
                            $satinalma = true;
                        }
                    }
                  @endphp

                  <!-- Karşılama Listesi Başlangıç -->
                  @if ($karsilama)
                    <div class="col-lg-12 mt-3">
                      <div class="p-1" style="background-color: rgb(235, 255, 236)">
                        <h5><b>Stoktan Karşılama Listesi </b> </h5>
                        <table class="table-sm table-striped table border align-middle">
                          <thead class="table-success">
                            <tr>
                              <th scope="col">Kodu</th>
                              <th scope="col">Malzeme</th>
                              <th scope="col">Özel Kod</th>
                              <th scope="col">Miktar</th>
                              <th scope="col">Birim Tutar</th>
                              <th scope="col">Toplam</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($data as $itm)
                              @php
                                
                                if ($itm->approved_consump == 0 || $itm->approved_consump == null) {
                                    continue;
                                }
                                
                                if (isset($itm->average_price)) {
                                    $toplam = $itm->average_price * $itm->approved_consump;
                                }
                              @endphp
                              <tr>
                                <td>{{ $itm->stock_code }} </td>
                                <td>
                                  {{ $itm->stock_name }}
                                  @if ($itm->status == 5)
                                    <br><span class="text-info">Yönetimin Onayını Bekliyor</span>
                                  @endif
                                </td>
                                <td>{{ $itm->special_code }} </td>
                                <td>{{ number_format($itm->approved_consump, 0, '', '') }}
                                  <small>{{ $itm->unit_code }}</small>
                                </td>
                                <td> {{ number_format($itm->average_price, 2, ',', '.') }} </td>
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
                  <!-- Karşılama Listesi Son -->


                  @if ($satinalma)
                    <div class="col-lg-12 mt-3">
                      <div class="p-1"
                           style="background-color: rgb(255, 250, 201)">
                        <h5><b>Satın Alma Siparişi Listesi</b> </h5>
                        <table class="table-sm table-striped table border align-middle"
                               style="width: 100%">
                          <thead class="table-warning">
                            <tr>
                              <th scope="col">Kodu</th>
                              <th scope="col">Malzeme</th>
                              <th scope="col">Miktar</th>
                              <th scope="col">Satınalma Firması</th>
                              <th scope="col"></th>
                            </tr>
                          </thead>
                          <tbody>

                            @foreach ($data as $itm)
                              @php
                                if ($itm->approved_purchase == 0 || $itm->approved_purchase == null) {
                                    continue;
                                }
                                $toplam = $itm->average_price * $itm->approved_purchase;
                              @endphp
                              <tr>
                                <td>{{ $itm->stock_code }} </td>
                                <td>{{ $itm->stock_name }}
                                  @if ($itm->status == 5)
                                    <br><span class="text-info">Yönetimin Onayını Bekliyor</span>
                                  @endif
                                </td>
                                <td>{{ number_format($itm->approved_purchase, 0, '', '') }}
                                  <small>{{ $itm->unit_code }}</small>
                                </td>
                                <td><small>{{ $itm->account_name }}</small> </td>
                                <td>
                                  <button onclick="$('._btn').prop('disabled',true)"
                                          @if ($talep->status == 1) disabled @endif
                                          wire:click="firma_sec('{{ $itm->id }}','{{ $itm->logo_stock_ref }}', '{{ $itm->stock_name }}')"
                                          class="_btn btn btn-sm btn-soft-danger m-0">Firma Seç</button>
                                  @if ($itm->account_name)
                                    <button onclick="$('._btn').prop('disabled',true)"
                                            @if ($talep->status == 1) disabled @endif
                                            wire:click="firma_iptal('{{ $itm->id }}')"
                                            class="_btn btn btn-sm btn-soft-warning m-0">İptal</button>
                                  @endif
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>

                      </div>
                    </div>
                  @endif

                  <!-- Satın Alma Listesi Son -->


                  <!-- yönetim Butonları -->
                  <div class="col-lg-12 mt-3">

                    @if ($talep->approved == 0)
                      @if ($bir_islem)
                        <button wire:click="approved" onclick="$('._btn').prop('disabled',true)"
                                class="_btn btn btn-success btn-label">
                          <i class="ri-check-double-line label-icon fs-16 me-2 align-middle"> </i>
                          Listeyi Kaydet
                        </button>
                      @else
                        <div class="alert alert-warning alert-borderless" role="alert">
                          <strong>Dikkat : </strong> İşlem Gerektiren Malzemeler Mevcuttur,
                          eğer bir malzeme sarfı, transferi yada satınalması yapılmayacaksa lütfen o malzemeyi listeden
                          çıkarınız.
                        </div>
                      @endif
                    @else
                      <button wire:click="kaydet()"
                              onclick="$('._btn').prop('disabled',true)"
                              @if ($talep->status == 1) disabled @endif
                              class="_btn btn btn-info btn-label">
                        <i class="ri-check-double-line label-icon fs-16 me-2 align-middle"> </i>
                        Logo Fişi Oluştur
                      </button>

                      <button wire:click="unapproved" onclick="$('._btn').prop('disabled',true)"
                              @if ($talep->status == 1) disabled @endif
                              class="_btn btn btn-light btn-sm">
                        Liste Kaydı İptal</button>
                    @endif

                  </div>
                  <!-- yönetim Butonları son -->


                  <div class="col-lg-12 mt-3">
                    @livewire('malzemeler.response')
                  </div>

            @endif
          @endif
        </div>
      </div>

  @endif

  <div wire:loading>
    <i class="mdi mdi-spin mdi-cog-outline fs-22"></i> Lütfen Bekleyiniz...
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

              @if (!$talep_owner)
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
                      "         Exec dbo.sp_get_last_purchase
                                @company_id ='001',
                                @term_id = '10',
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

<div id="iptalModal" class="modal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"
            id="fullscreeexampleModalLabel">Onay</h5>
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
        <button data-bs-dismiss="modal" wire:click="cikar({{ $iptal_id }})"
                class="btn btn-primary">Onayla</button>
        <button class="btn btn-light" data-bs-dismiss="modal">Kapat</button>
      </div>
    </div>
  </div>
</div>

<div id="editLineModal" class="modal" tabindex="-1" role="dialog"
     aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Miktar Düzenle</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
      </div>
      <div class="modal-body m-0">
        @if ($edit_line_id)
          <div class="mb-3">
            <label for="customer-name"
                   class="col-form-label">Yeni Miktarı Giriniz</label>
            <input wire:model.defer="line_quantity" type="number" class="form-control">
            <br>
            {{ $line_item_name }}
          </div>
        @endif
      </div>

      <div class="modal-footer">
        <button data-bs-dismiss="modal" wire:click="update_line({{ $edit_line_id }})"
                class="btn btn-primary">Onayla</button>
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
