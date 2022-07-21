<div>
  <div id="malzemeModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen p-3">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>
        <div class="modal-body">
          @livewire('malzemeler.liste', ['ch' => true])
        </div>

      </div>
    </div>
  </div>

  <div id="ozelKodModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>
        <div class="modal-body m-0">
          @livewire('logo.ozel-kod')
        </div>

      </div>
    </div>
  </div>


  <div id="projectsModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
       style="display: none;">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>
        <div class="modal-body m-0">
          @livewire('logo.projects')
        </div>
      </div>
    </div>
  </div>



  <div class="row">
    <div
         class="@if ($item_photos) col-xl-7 col-lg-7 col-md-12 col-sm-12 @else col-xl-10 col-lg-10 col-sm-12 @endif">
      <div class="card">
        <div class="card-header">
          <span class="float-end">
            <a href="#" wire:click="$emit('SetPage', 'malzemeler.talep-listesi')"
               class="btn btn-soft-primary waves-effect waves-light"> <i class="ri-stack-line"></i> Talep
              Listesi</a>

            <a href="#" wire:click="$emit('SetPage', 'malzemeler.liste')"
               class="btn btn-soft-primary waves-effect waves-light"> <i class="ri-stack-line"></i> Malzeme
              Listesi</a>
          </span>
          <div class="d-flex align-items-center">
            <h5 class="card-title flex-grow-1 mb-0"> <i class="ri-add-line me-1 align-bottom"></i>
              Malzeme Talebi @if ($edit_id)
                Düzenle
              @else
                Oluştur
              @endif

            </h5>
          </div>
        </div>
        <div class="card-body">
          <form
                @if ($edit_id) wire:submit.prevent="edit()" @else wire:submit.prevent="store()" @endif>
            @csrf
            <div class="row">

              <div class="@if ($item_photos) col-12 @else col-xl-10 col-lg-10 col-sm-12 @endif">
                <table class="table-sm table-nowrap table">
                  <tr>
                    <th class="px-1">
                      <div class="row">
                        <div class="col-lg-4">
                          <label class="form-label">Tarih</label>
                        </div>
                        <div class="col-lg-8">
                          <input type="date" step="any" wire:model="zaman"
                                 class="form-control form-control-sm rounded-0 mb-1">
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-4">
                          <label class="form-label">Proje Kodu</label>
                        </div>
                        <div class="col-lg-7">
                          <input type="hidden" wire:model="project_ref_id">
                          <input type="text" wire:model="project_code" name="proje_kodu" data-bs-toggle="modal"
                                 data-bs-target="#projectsModal" readonly="readonly"
                                 class="form-control form-control-sm rounded-0 mb-1">
                        </div>
                        <div class="col-lg-1">
                          <a href="javascript:void(0);" @click="@this.set('project_code', '')"
                             class="link-info fs-15 position-absolute start-0 top-0"><i class="ri-close-line"></i></a>
                        </div>

                      </div>

                      <div class="row">
                        <div class="col-lg-4">
                          <label class="form-label">Özel Kod</label>
                        </div>
                        <div class="col-lg-7">
                          <input type="text" data-bs-toggle="modal" wire:click="$emit('ozelKodType', 1)"
                                 name="special_code" wire:model="special_code" readonly="readonly"
                                 data-bs-target="#ozelKodModal" class="form-control form-control-sm rounded-0 mb-1">
                        </div>
                        <div class="col-lg-1">
                          <a href="javascript:void(0);" @click="@this.set('special_code', '')"
                             class="link-info fs-15 position-absolute start-0 top-0"><i class="ri-close-line"></i></a>
                        </div>
                      </div>


                      <div class="row">
                        <div class="col-lg-4">
                          <label class="form-label">Açıklama</label>
                        </div>
                        <div class="col-lg-8">
                          <input type="text" name="demand_desc" wire:model="demand_desc"
                                 class="form-control form-control-sm rounded-0 mb-1">
                        </div>
                      </div>

                    </th>
                    <th class="px-1">

                      <div class="row">
                        <div class="col-lg-4">
                          <label class="form-label">Malzeme Talep Tipi</label>
                        </div>
                        <div class="col-lg-8">
                          <div class="input-group input-group-sm">
                            <select wire:model="demand_type">
                              <option value="1">Depodan Malzeme Talebi</option>
                              <option value="2" @if ($auth_warehouses->count() == 0) disabled @endif>Depolar Arası
                                Malzeme Transferi</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="row mt-1">
                        <div class="col-lg-4">
                          <label class="form-label">Kaynak Depo (İstenen)</label>
                        </div>
                        <div class="col-lg-8">
                          <div class="input-group input-group-sm">
                            <select wire:model="warehouse" name="warehouse">
                              @foreach ($warehouses as $d)
                                <option value="{{ $d->warehouse_no }}">
                                  {{ $d->warehouse_name }}
                                </option>
                              @endforeach
                            </select>
                          </div>
                        </div>

                      </div>

                      @if ($demand_type == 2)

                        <div class="row mt-1">
                          <div class="col-lg-4">
                            <label class="form-label">Teslim Depo (İsteyen)</label>
                          </div>
                          <div class="col-lg-8">
                            <div class="input-group input-group-sm">
                              <select wire:model="destwh" name="destwh">

                                @foreach ($auth_warehouses as $d)
                                  @php
                                    $w = App\Models\LogoWarehouses::Where('company_no', '1')
                                        ->Where('warehouse_no', $d->warehouse_no)
                                        ->first();
                                  @endphp
                                  <option value="{{ $d->warehouse_no }}">
                                    {{ $w->warehouse_name }}
                                  </option>
                                @endforeach
                              </select>

                            </div>
                          </div>

                        </div>
                      @endif
                    </th>
                  </tr>
                </table>
              </div>


              <div class="col-lg-12 col-md-12 mt-4">
                <div class="table-responsive">
                  <table class="table-sm table-striped table-nowrap table align-middle">
                    <thead class="table-light">
                      <tr>
                        <th style="width:20px;"></th>
                        <th style="width:70px;">S.Kodu</th>
                        <th style="width:350px;">Malzeme</th>
                        <th style="width:100px;">Miktar</th>
                        <th style="width:100px;">Birim</th>
                        <th>Talep Nedeni</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>

                      @php
                        $s = 1;
                      @endphp
                      @foreach ($inputs as $key => $value)
                        <tr>
                          <td scope="row"> {{ $s }}</td>
                          <td>
                            <div class="input-group input-group-sm">
                              <input type="text" class="form-control border-dashed" readonly="readonly"
                                     name="kod[{{ $value }}]" id="input_kod_{{ $value }}"
                                     wire:click="SetLine({{ $value }},'#malzemeModal')"
                                     wire:model="kod.{{ $value }}">
                            </div>
                          </td>

                          <td>
                            <div class="input-group input-group-sm">
                              <input type="text" class="form-control border-dashed" readonly="readonly"
                                     name="aciklama[{{ $value }}]" id="input_aciklama_{{ $value }}"
                                     wire:click="SetLine({{ $value }},'#malzemeModal')"
                                     wire:model="aciklama.{{ $value }}">
                            </div>
                          </td>

                          <td>
                            <div class="input-group input-group-sm">
                              <input type="number" step="any" class="form-control border-dashed"
                                     id="miktar_{{ $value }}" name="miktar[{{ $value }}]"

                                     wire:model.defer="miktar.{{ $value }}">
                            </div>
                          </td>

                          <td>
                            <div class="input-group input-group-sm">
                              <select name="birim[{{ $value }}]"
                                      wire:model.defer="birim.{{ $value }}">
                                @if (isset($birim_select[$value]))
                                  @foreach ($birim_select[$value] as $b)
                                    <option value="{{ $b['unit_code'] }}">
                                      {{ $b['unit_name'] }}
                                    </option>
                                  @endforeach
                                @endif
                              </select>
                            </div>
                          </td>



                          <td>
                            <div class="input-group input-group-sm">
                              <input type="text" class="form-control border-dashed" id="desc_{{ $value }}"
                                     name="desc[{{ $value }}]" wire:model.lazy="desc.{{ $value }}">
                            </div>
                          </td>

                          <td>
                            <button class="btn btn-sm btn-outline-danger" wire:loading.attr="disabled"
                                    wire:click.prevent="remove({{ $key }}, {{ $value }})"><i
                                 class="mdi mdi-delete"></i>
                            </button>
                          </td>
                        </tr>

                        @php
                          $s = $s + 1;
                        @endphp
                      @endforeach
                      <tr>
                        <th scope="row" colspan="6"></th>
                        <td>
                          <button class="btn btn-sm btn-primary" wire:keydown.enter="add({{ $i }})"
                                  wire:loading.attr="disabled"
                                  wire:click.prevent="add({{ $i }})"><i class="mdi mdi-plus"></i>
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>


              <div class="col-lg-12">
                <div class="row">
                  @if (session()->has('error'))
                    <div class="col-4 m-2">
                      <div class="alert alert-danger alert-dismissible fade show shadow">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                      </div>
                    </div>
                  @endif

                  @if (session()->has('success'))
                    <div class="col-12 m-2">
                      <div class="alert alert-success alert-dismissible fade show shadow">
                        {{ session('success') }}
                      </div>
                    </div>
                  @endif

                  @if (!$inputs)
                    <div class="col-12 m-2">
                      Malzeme İstek Listesi Oluşturun.
                    </div>
                  @endif

                  <div class="col-12 m-2">
                    @if ($edit_id)
                      <button type="submit" class="btn btn-info" disabled
                              @if (!$inputs) disabled @endif>
                        <i class="mdi mdi-content-save"></i> Düzenle</button>
                    @else
                      <button type="submit" class="btn btn-success"
                              @if (!$inputs) disabled @endif>
                        <i class="mdi mdi-content-save"></i> Kaydet</button>
                    @endif
                    <div wire:loading class="p-3">
                      İşleniyor Lütfen Bekleyiniz...
                    </div>
                  </div>
                </div>

              </div>

            </div>
          </form>
        </div>
      </div>

    </div>

    @if ($item_photos)
      <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h5 class="card-title flex-grow-1 mb-0"> <i class="ri-add-line me-1 align-bottom"></i>
                Seçili Malzeme Fotoğrafları</h5>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              @foreach ($item_photos as $p)
                <div class="col-6">
                  <div class="bg-light p-2">
                    <div>
                      <img style="width:100%"
                           src="https://mobile.zeberced.net/files/{{ $p['foto_path'] }}"
                           _src="{{ asset('files/images/items/' . $p['foto_path']) }}">
                    </div>
                    <div>
                      <h6> {{ $p['stock_name'] }}</h6>
                      <small>Stok Kodu: {{ $p['stock_code'] }}</small>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    @endif
  </div>



</div>
