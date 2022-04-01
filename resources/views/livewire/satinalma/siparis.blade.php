<div>
    <style>
        label {
            font-size: 10px;

        }

        table th {
            font-size: 10px;
        }
    </style>
    <form wire:submit.prevent="store()">
        @csrf
        <div class="row">
            <div class="col-xxl-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-border-top nav-border-top-primary mb-3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#nav-border-top-fis" role="tab"
                                    aria-selected="true">
                                    Fiş
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#nav-border-top-detay" role="tab"
                                    aria-selected="false">
                                    Detaylar
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content text-muted">
                            <div class="tab-pane active" id="nav-border-top-fis" role="tabpanel">
                                <div class="row ">
                                    <div class="col-lg-12 col-md-12">
                                        <table class="table rwd-table table-sm ">
                                            <tr>
                                                <th class="px-1">

                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <label class="form-label">Tarih</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <input type="datetime-local" name="zaman" step="any"
                                                                wire:model="zaman"
                                                                class="form-control form-control-sm mb-1 rounded-0">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <label class="form-label">Belge No</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <input type="text" name="belge_no" wire:model="belge_no"
                                                                class="form-control form-control-sm mb-1 rounded-0">
                                                        </div>
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <label class="form-label">Proje Kodu</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <input type="text" wire:model="project_code"
                                                                name="proje_kodu" data-bs-toggle="modal"
                                                                data-bs-target="#projectsModal"
                                                                class="form-control form-control-sm mb-1 rounded-0"
                                                                readonly="readonly">
                                                            @error('project_code') <span class="error">{{ $message
                                                                }}</span> @enderror
                                                        </div>

                                                    </div>
                                                </th>
                                                <th class="px-3">
                                                    <div class="row">
                                                        <div class="col-lg-2">
                                                            <label class="form-label">Kodu</label>
                                                        </div>
                                                        <div class="col-lg-10">
                                                            <input type="hidden" wire:model="account_ref_id">
                                                            <input type="text" data-bs-toggle="modal"
                                                                name="musteri_kodu" wire:model="account_code"
                                                                data-bs-target="#accountsModal"
                                                                class="form-control form-control-sm mb-1 rounded-0"
                                                                readonly="readonly">
                                                        </div>


                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-2">
                                                            <label class="form-label">Unvanı</label>
                                                        </div>
                                                        <div class="col-lg-10">
                                                            <input type="text" wire:model="account_name"
                                                                name="musteri_unvan" data-bs-toggle="modal"
                                                                data-bs-target="#accountsModal"
                                                                class="form-control form-control-sm mb-1 rounded-0"
                                                                readonly="readonly">

                                                            @error('account_ref_id') <span class="error text-danger">{{
                                                                $message
                                                                }}</span> @enderror
                                                        </div>

                                                    </div>

                                                </th>
                                                <th class="px-3">

                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <label class="form-label">İş Yeri</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <div class="input-group input-group-sm  mb-1 rounded-0">
                                                                <select>
                                                                    <option value="0" name="is_yeri" selected>000,
                                                                        Merkez</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <label class="form-label">Bölüm</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <div class="input-group input-group-sm  mb-1 rounded-0">
                                                                <select>
                                                                    <option value="0" name="bolum" selected>000, Merkez
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <label class="form-label">Fabrika</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <div class="input-group input-group-sm  mb-1 rounded-0">
                                                                <select>
                                                                    <option value="0" name="fabrika" selected>000,
                                                                        Merkez</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <label class="form-label">Ambar</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <div class="input-group input-group-sm ">
                                                                <select wire:model="warehouse" name="ambar">
                                                                    @foreach ($warehouses as $d)
                                                                    <option value="{{ $d->warehouse_no }}">{{
                                                                        $d->warehouse_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </th>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="col-lg-12 col-md-12  ">


                                        <div class="table-responsive">
                                            <table class="table table-sm table-striped align-middle table-nowrap"
                                                style="width: 100%; min-width:1200px;">

                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width:30px;"></th>
                                                        <th style="width:85px;">Türü</th>
                                                        <th style="width:70px;">Kodu</th>
                                                        <th style="width:250px;">Açıklaması</th>
                                                        <th style="width:100px;">Miktar</th>
                                                        <th style="width:70px;">Birim</th>
                                                        <th style="width:100px;">Birim Fiyat</th>
                                                        <th style="width:80px;">Kdv</th>
                                                        <th style="width:100px;">Tutar</th>
                                                        <th style="width:100px;">Net Tutar</th>
                                                        <th>-</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>
                                                            <div class="input-group input-group-sm ">
                                                                <select wire:model="tip.0">
                                                                    <option selected>Malzeme</option>
                                                                    <option value="1">Diğer</option>
                                                                </select>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" class="form-control rounded-0"
                                                                    name="tip[0]" wire:model="kod.0"
                                                                    data-bs-toggle="modal" readonly="readonly"
                                                                    wire:click="$emitTo('malzemeler.index','setLine',0)"
                                                                    data-bs-target="#malzemeModal">
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" class="form-control rounded-0"
                                                                    wire:model="aciklama.0" data-bs-toggle="modal"
                                                                    name="aciklama[0]" readonly="readonly"
                                                                    wire:click="$emitTo('malzemeler.index','setLine',0)"
                                                                    data-bs-target="#malzemeModal">
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="input-group input-group-sm">
                                                                <input type="number" step="any"
                                                                    class="form-control rounded-0" name="miktar[0]"
                                                                    wire:click="active_line(0)"
                                                                    wire:model.lazy="miktar.0">
                                                            </div>
                                                        </td>

                                                        <td>

                                                            <div class="input-group input-group-sm">
                                                                <select wire:click="active_line(0)" name="birim[0]"
                                                                    wire:model.defer="birim.0">
                                                                    @if(isset($birim_select[0]))
                                                                    <option value=""> -- Seç --</option>
                                                                    @foreach($birim_select[0] as $b)
                                                                    <option value="{{ $b['unit_code'] }}">{{
                                                                        $b['unit_name'] }}
                                                                    </option>
                                                                    @endforeach
                                                                    @endif

                                                                </select>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="input-group input-group-sm">
                                                                <input type="number" step="any"
                                                                    class="form-control rounded-0" name="birim_fiyat[0]"
                                                                    wire:click="active_line(0)"
                                                                    wire:model.lazy="birim_fiyat.0">
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="input-group input-group-sm">
                                                                <input type="number" step="any"
                                                                    class="form-control rounded-0" name="kdv[0]"
                                                                    wire:click="active_line(0)" wire:model.lazy="kdv.0">
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="input-group input-group-sm">
                                                                <input type="number" class="form-control rounded-0"
                                                                    name="tutar[0]" disabled wire:model.lazy="tutar.0">
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="input-group input-group-sm">
                                                                <input type="number" class="form-control rounded-0"
                                                                    name="net_tutar[0]" disabled
                                                                    wire:model.lazy="net_tutar.0">
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <button class="btn btn-sm btn-primary"
                                                                wire:loading.attr="disabled"
                                                                wire:click.prevent="add({{$i}})"><i
                                                                    class="mdi mdi-plus"></i></button>
                                                        </td>

                                                    </tr>
                                                    @php
                                                    $s =2;
                                                    @endphp
                                                    @foreach ($inputs as $key => $value)
                                                    <tr>
                                                        <th scope="row"> {{ $s}} </th>
                                                        <td>
                                                            <div class="input-group input-group-sm">
                                                                <select wire:model="tip.{{ $value }}"
                                                                    name="tip[{{ $value }}]">
                                                                    <option selected>Malzeme</option>
                                                                    <option value="1">Diğer</option>
                                                                </select>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" class="form-control border-dashed"
                                                                    readonly="readonly" name="kod[{{ $value }}]"
                                                                    id="input_kod_{{ $value }}"
                                                                    wire:click="$emitTo('malzemeler.index','setLine',{{ $value }})"
                                                                    wire:model="kod.{{ $value }}" data-bs-toggle="modal"
                                                                    data-bs-target="#malzemeModal">
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" class="form-control border-dashed"
                                                                    readonly="readonly" name="aciklama[{{ $value }}]"
                                                                    id="input_aciklama_{{ $value }}"
                                                                    wire:click="$emitTo('malzemeler.index','setLine',{{ $value }})"
                                                                    wire:model="aciklama.{{ $value }}"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#malzemeModal">
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="input-group input-group-sm ">
                                                                <input type="number" step="any"
                                                                    class="form-control border-dashed "
                                                                    name="miktar[{{ $value }}]"
                                                                    wire:click="active_line({{ $value }})"
                                                                    wire:model.lazy="miktar.{{ $value }}">
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="input-group input-group-sm">
                                                                <select wire:click="active_line({{ $value }})"
                                                                    name="birim[{{ $value }}]"
                                                                    wire:model.defer="birim.{{ $value }}">
                                                                    @if(isset($birim_select[$value]))
                                                                    <option value=""> -- Seç --</option>
                                                                    @foreach($birim_select[$value] as $b)
                                                                    <option value="{{ $b['unit_code'] }}">{{
                                                                        $b['unit_name'] }}
                                                                    </option>
                                                                    @endforeach
                                                                    @endif

                                                                </select>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="input-group input-group-sm">
                                                                <input type="number" step="any"
                                                                    class="form-control border-dashed "
                                                                    name="birim_fiyat[{{ $value }}]"
                                                                    wire:click="active_line({{ $value }})"
                                                                    wire:model.lazy="birim_fiyat.{{ $value }}">
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="input-group input-group-sm">
                                                                <input type="number" step="any"
                                                                    class="form-control border-dashed "
                                                                    name="kdv[{{ $value }}]"
                                                                    wire:click="active_line({{ $value }})"
                                                                    wire:model.lazy="kdv.{{ $value }}">
                                                            </div>
                                                        </td>


                                                        <td>
                                                            <div class="input-group input-group-sm">
                                                                <input type="number" class="form-control border-dashed "
                                                                    name="tutar[{{ $value }}]" disabled
                                                                    wire:model="tutar.{{ $value }}">
                                                            </div>
                                                        </td>


                                                        <td>
                                                            <div class="input-group input-group-sm">
                                                                <input type="number" class="form-control border-dashed "
                                                                    name="net_tutar[{{ $value }}]" disabled
                                                                    wire:model="net_tutar.{{ $value }}">
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <button class="btn btn-sm btn-outline-danger"
                                                                wire:loading.attr="disabled"
                                                                wire:click.prevent="remove({{$key}})"><i
                                                                    class="mdi mdi-delete"></i></button>
                                                        </td>



                                                    </tr>
                                                    @php
                                                    $s = $s + 1;
                                                    @endphp
                                                    @endforeach
                                                    <tr>
                                                        <th scope="row" colspan="6"></th>
                                                        <td colspan="4">
                                                            <div class="row">
                                                                <div class="col-lg-5  ">

                                                                    <div class="p-1">Toplam Masraf</div>
                                                                </div>
                                                                <div class="col-lg-7 border bg-white">
                                                                    <div class="p-1">

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-lg-5  ">
                                                                    <div class="p-1">Toplam İndirim</div>
                                                                </div>
                                                                <div class="col-lg-7 border bg-white">
                                                                    <div class="p-1">

                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="row">
                                                                <div class="col-lg-5  ">
                                                                    <div class="p-1">Toplam</div>
                                                                </div>
                                                                <div class="col-lg-7 border bg-white">
                                                                    <div class="p-1">

                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @if (session()->has('error'))
                                        <div class="col-4 m-2 ">
                                            <div class="alert alert-danger alert-dismissible fade show shadow">
                                                {{ session('error') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        </div>
                                        @endif

                                        @if (session()->has('success'))
                                        <div class="col-4 m-2 ">
                                            <div class="alert alert-success alert-dismissible fade show shadow">
                                                {{ session('success') }}
                                            </div>
                                        </div>
                                        @endif


                                        <div class="col-12 m-2 ">
                                            <button type="submit" class="btn btn-success "> <i
                                                    class="mdi mdi-content-save"></i>Save</button>

                                            <div wire:loading>
                                                İşleniyor Lütfen Bekleyiniz...
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="nav-border-top-detay" role="tabpanel">
                                detay
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>


</div>

<div>
    <div id="malzemeModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                <div class="modal-body m-0">
                    @livewire('malzemeler.index')
                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i
                            class="ri-close-line me-1 align-middle"></i> Kapat</a>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>



<div>
    <div id="accountsModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                <div class="modal-body m-0">
                    @livewire('logo.accounts')
                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i
                            class="ri-close-line me-1 align-middle"></i> Kapat</a>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>


<div>
    <div id="projectsModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                <div class="modal-body m-0">
                    @livewire('logo.projects')
                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i
                            class="ri-close-line me-1 align-middle"></i> Kapat</a>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>