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
                  </b> </small>
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

  <div id="setStatusModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
       aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Durum</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>
        <div class="modal-body m-0">
          @if ($stock_code)
            <div class="mb-3">
              <label for="customer-name" class="col-form-label">Durum Giriniz</label>
              <input wire:model.defer="status_text" type="text" class="form-control">
              <br>
              <small>Örnek : 10 gün içinde Türkiye'den gelecek </small>
            </div>
          @endif
        </div>

        <div class="modal-footer">
          <button wire:click="update_status({{ $stock_code }})" class="btn btn-primary">Onayla</button>
          <button class="btn btn-light" data-bs-dismiss="modal">Kapat</button>
        </div>
      </div>
    </div>
  </div>


  @if ($talep_detay)
    <div class="card">
      <div class="card-header">
        <h4 class="card-title flex-grow-1 mb-0">TALEP DETAYI <small>#{{ $talep->id }}</small></h4>
        <small>Açıklama : {{ $talep->demand_desc }}</small>
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

                  <th scope="col">Karşılanan</th>
                  <th scope="col">Satınalma</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($talep_detay as $dt)
                  @php
                    $photo = App\Models\LogoItemsPhoto::where('logo_stockref', $dt->logo_stock_ref)->first();
                    $item_detail = App\Models\LogoItems::find($dt->logo_stock_ref);
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
                      <small>Stok Kodu: {{ $item_detail->stock_code }}</small>
                      <br> <small class="text-danger">Talep Nedeni: {{ $dt->description }}</small>

                    </td>
                    <td class="text-dark"><b
                         style="font-size:1.2em">{{ number_format($dt->quantity, 0, '.', ',') }}</b>
                      <br><small>{{ $dt->unit_code }}</small>
                    </td>

                    <td><b>{{ number_format($dt->approved_consump, 0, '.', ',') }}
                        <br><small>{{ $dt->unit_code }}</small></b>
                    <td><b>{{ number_format($dt->approved_purchase, 0, '.', ',') }}
                        <br><small>{{ $dt->unit_code }}</small>
                      </b>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          @php
            $demand_fiche = Illuminate\Support\Facades\DB::select(
                "Exec dbo.sp_get_consump_fiche
                @company_id ='001',
                @term_id = '09',
                @detail = 1,
                @fiche_no = '',
                @demand_id = ?",
                [$talep_id],
            );
          @endphp

          @if ($demand_fiche)
            <div class="col-lg-12 mb-2">
              <h6><b>Depodan Karşılanan Malzeme Listesi (Sarf Fişleri)</b></h6>
              <div style="background-color:#f2faf2;" class="p-2">
                <table class="table-sm table-striped table border align-middle">
                  <thead>
                    <tr>
                      <th scope="col">Fiş No</th>
                      <th scope="col">Belge No</th>
                      <th scope="col">Stok No</th>
                      <th scope="col">Malzeme</th>
                      <th scope="col">Miktar</th>
                      <th scope="col">Birim Fiyat</th>
                      <th scope="col">Toplam</th>
                      <th scope="col">Özel Kod</th>
                      <th scope="col"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($demand_fiche as $d)
                      <tr>
                        <td>{{ $d->fiche_no }}</td>
                        <td>{{ $d->doc_number }}</td>
                        <td>{{ $d->stock_code }}</td>
                        <td>{{ $d->stock_name }}</td>
                        <td>{{ number_format($d->amount, 0, '.', ',') }} <small>{{ $d->unit_code }}</small>
                        </td>
                        <td>{{ number_format($d->unit_price, 2, '.', ',') }}</td>
                        <td>{{ number_format($d->total_price, 2, '.', ',') }}</td>

                        <td><small>{{ $d->special_code }}</small></td>
                        <td>
                          <a href="javascript:void(0);"><i class="ri-printer-line fs-17 lh-1 align-middle"></i></a>

                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          @endif



          @if ($talep->logo_po_ref)
            @php
              $satinalma = App\Models\LogoPurchaseOrdersDetail::Where('po_ficheref', $talep->logo_po_ref)->get();
            @endphp

            @if ($satinalma->count() > 0)
              <div class="col-lg-12 mt-2">
                <h6><b>Satınalma Malzeme Listesi</b></h6>
                <div style="background-color:#faf2f2;" class="p-2">
                  <table class="table-sm table-striped table border align-middle">
                    <thead>
                      <tr>
                        <th scope="col">Fiş No</th>
                        <th scope="col">Belge No</th>
                        <th scope="col">Stok No</th>
                        <th scope="col">Malzeme</th>
                        <th scope="col">Miktar</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($satinalma as $d)
                        <tr>
                          <td>{{ $d->po_ficheno }}</td>
                          <td>{{ $d->document_no }}</td>
                          <td>{{ $d->stock_code }}</td>
                          <td>{{ $d->stock_name }}</td>
                          <td>{{ number_format($d->quantity, 0, '.', ',') }} <small>{{ $d->unit_code }}
                            </small>
                          </td>
                        </tr>
                      @endforeach

                    </tbody>
                  </table>
                  <small>Dikkat: Satınalma fişi öneri niteliğinde oluşmuştur, fişin düzenlemesi gereklidir.</small>
                </div>
              </div>
            @endif
          @endif




          @php
            $incompletedDemand = App\Models\IncompletedDemand::Where('demand_id', $talep_id)->get();
            $sarf_btn = false;
          @endphp

          @if ($incompletedDemand->count() > 0)

            <div class="col-lg-12 mt-2">
              <h6><b>Karşılanmayı Bekleyen Malzeme Listesi</b></h6>
              <div class="p-1">
                <table class="table-sm table-striped table border align-middle">
                  <thead>
                    <tr>
                      <th scope="col"></th>
                      <th scope="col">Stok No</th>
                      <th scope="col">Malzeme</th>
                      <th scope="col">Talep</th>
                      <th scope="col">Karşılanan</th>
                      <th scope="col">Stok Bekleyen </th>
                      <th scope="col">Stok </th>
                      <th scope="col">Durum </th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($incompletedDemand as $d)
                      @if ($d->diff > 0)
                        @php
                          $item = App\Models\LogoItems::where('stock_code', $d->stock_code)->first();
                        @endphp
                        <tr class="@if ($item->onhand_quantity >= $d->diff) bg-soft-success @endif">
                          <td>
                            @if ($item->onhand_quantity >= $d->diff)
                              @php
                                $sarf_btn = true;
                              @endphp
                              <input type="checkbox" wire:model="sarf.{{ $d->stock_code }}" name="sarf_checkbox"
                                     value="{{ $d->diff }}" class="form-check-input">
                            @else
                            @endif

                          </td>

                          <td>{{ $d->stock_code }}</td>
                          <td>{{ $item->stock_name }}
                            @if ($d->status_desc)
                              <br> <small class="text-danger"> <i class="ri-error-warning-line"></i>
                                {{ $d->status_desc }}</small>
                            @endif
                          </td>
                          <td>{{ number_format($d->quantity, 0, '.', ',') }} <small>{{ $d->unit_code }}
                            </small></td>
                          <td>{{ number_format($d->consump, 0, '.', ',') }}</td>
                          <td>{{ number_format($d->diff, 0, '.', ',') }}</td>
                          <td>{{ number_format($item->onhand_quantity, 0, '.', ',') }}</td>
                          <td><button class="btn btn-sm"
                                    wire:click="status_pop({{ $d->stock_code }},'{{ $d->status_desc }}')">...</button>
                          </td>
                        </tr>
                      @endif
                    @endforeach

                  </tbody>
                </table>

                @if ($sarf_btn)
                  <button class="btn btn-primary m-1" wire:click="sarf_olustur" wire:loading.attr="disabled">Seçili
                    Olanları Teslim Et</button>
                  <div wire:loading>
                    <i class="mdi mdi-spin mdi-cog-outline fs-22"></i> Lütfen Bekleyiniz...
                  </div>

                  @if (session()->has('success'))
                    <div class="alert alert-success" role="alert">
                      {{ session('success') }}
                    </div>
                  @endif

                  @if (session()->has('error'))
                    <div class="alert alert-danger" role="alert">
                      {{ session('error') }}
                    </div>
                  @endif

                  <br>
                  <span class="text-dark m-1">Satınalma işlemi gerçekleşip malzeme stoklara yansıdığında sarf
                    oluşturabilirsiniz.</span>
                @endif

              </div>
            </div>
          @endif




        </div>
      </div>
    </div>
  @endif

  <div wire:loading>
    <i class="mdi mdi-spin mdi-cog-outline fs-22"></i> Lütfen Bekleyiniz...
  </div>
</div>
