<div>
    <style>
        label {
            color: rgb(65, 62, 62);
            font-size: 0.9em;

        }
    </style>
    <div class="row">
        <div class="col-lg-12">
            <form wire:submit.prevent="store({{ $sid }})">
                @csrf
                <div class="card">
                    <div class="card-header ">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title mb-0 flex-grow-1"> <i class="ri-add-line align-bottom me-1"></i>
                                Sipariş Oluştur {{ $sid }}</h5>
                            <div class="flex-shrink-0">
                                <a href="#" wire:click="$emit('SetPage', 'satinalma.siparis')"
                                    class="btn btn-success add-btn"><i class="ri-store-2-fill align-bottom me-1"></i>
                                    Sipariş Listesi
                                </a>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-sm table-nowrap" style="width: 60%; min-width:800px">
                                        <tr>
                                            <th class="px-2">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label class="form-label">Tarih</label>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input type="date" name="zaman" step="any" wire:model="zaman"
                                                            class="form-control form-control-sm mb-1 rounded-0">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label class="form-label">Belge No</label>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="belge_no" wire:model="belge_no"
                                                            class="form-control form-control-sm mb-1 rounded-0">
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label class="form-label">Proje Kodu</label>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input type="hidden" wire:model="project_ref_id">
                                                        <input type="text" wire:model="project_code" name="proje_kodu"
                                                            data-bs-toggle="modal" data-bs-target="#projectsModal"
                                                            class="form-control form-control-sm mb-1 rounded-0"
                                                            readonly="readonly">

                                                        @error('project_code')
                                                        <span class="error"> {{ $message}}</span>
                                                        @enderror
                                                    </div>

                                                </div>
                                            </th>
                                            <th class="px-1 ">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label class="form-label">Kodu</label>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input type="hidden" wire:model="account_ref_id">
                                                        <input type="text" data-bs-toggle="modal" name="musteri_kodu"
                                                            wire:model="account_code" data-bs-target="#accountsModal"
                                                            class="form-control form-control-sm mb-1 rounded-0"
                                                            readonly="readonly">
                                                    </div>



                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label class="form-label">Unvanı</label>
                                                    </div>
                                                    <div class="col-lg-8">
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
                                            <th class="px-1">

                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label class="form-label">İş Yeri</label>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <div class="input-group input-group-sm  mb-1 rounded-0">
                                                            <select class="form-select">
                                                                <option value="0" name="is_yeri" selected>000,
                                                                    Merkez</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label class="form-label">Bölüm</label>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <div class="input-group input-group-sm  mb-1 rounded-0">
                                                            <select class="form-select">
                                                                <option value="0" name="bolum" selected>000, Merkez
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label class="form-label">Fabrika</label>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <div class="input-group input-group-sm  mb-1 rounded-0">
                                                            <select class="form-select">
                                                                <option value="0" name="fabrika" selected>000,
                                                                    Merkez</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label class="form-label">Ambar</label>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <div class="input-group input-group-sm ">
                                                            <select wire:model="warehouse" name="ambar"
                                                                class="form-select">
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
                            </div>

                            <div class="col-lg-12 col-md-12">


                                <div class="table-responsive">
                                    <table class="table table-sm table-striped align-middle table-nowrap"
                                        style="width: 60%; min-width:1200px ">

                                        <thead class="table-light">
                                            <tr>
                                                <th style="width:30px;"></th>
                                                <th style="width:85px;">Türü</th>
                                                <th style="width:70px;">Kodu</th>
                                                <th style="width:200px;">Açıklaması</th>
                                                <th style="width:100px;">Miktar</th>
                                                <th style="width:70px;">Birim</th>
                                                <th style="width:100px;">Birim Fiyat</th>
                                                <th style="width:80px;">Kdv %</th>
                                                <th style="width:80px;">Kdv</th>
                                                <th style="width:100px;">Tutar</th>
                                                <th style="width:120px;">Net Tutar</th>
                                                <th>-</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            @php
                                            $s =1;
                                            @endphp
                                            @foreach ($inputs as $key => $value)
                                            <tr>
                                                <th scope="row"> {{ $s}} </th>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <select wire:model="tip.{{ $value }}" name="tip[{{ $value }}]">
                                                            <option selected>Malzeme</option>
                                                        </select>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <input type="text" class="form-control border-dashed"
                                                            readonly="readonly" name="kod[{{ $value }}]"
                                                            id="input_kod_{{ $value }}"
                                                            wire:click="SetLine({{ $value }},'#malzemeModal')"
                                                            wire:model="kod.{{ $value }}">
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <input type="text" class="form-control border-dashed"
                                                            readonly="readonly" name="aciklama[{{ $value }}]"
                                                            id="input_aciklama_{{ $value }}"
                                                            wire:click="SetLine({{ $value }},'#malzemeModal')"
                                                            wire:model="aciklama.{{ $value }}">
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="input-group input-group-sm ">
                                                        <input type="number" step="any"
                                                            class="form-control border-dashed" id="miktar_{{ $value }}"
                                                            name="miktar[{{ $value }}]"
                                                            wire:model.lazy="miktar.{{ $value }}">
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <select name="birim[{{ $value }}]"
                                                            wire:model.defer="birim.{{ $value }}">
                                                            @if(isset($birim_select[$value]))
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
                                                            class="form-control border-dashed " pattern="[0-9.]*"
                                                            name="birim_fiyat"
                                                            wire:model.lazy="birim_fiyat.{{ $value }}">
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" step="any" id="kdv_{{ $value }}"
                                                            class="form-control border-dashed " name="kdv"
                                                            wire:model.lazy="kdv.{{ $value }}">
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <select name="kdv_inc[{{ $value }}]" disabled
                                                            wire:model="kdv_inc.{{ $value }}">
                                                            <option value="0"> Hariç</option>
                                                            <option value="1"> Dahil</option>
                                                        </select>
                                                    </div>
                                                </td>



                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <input type="text" id="tutar_{{ $value }}"
                                                            class="form-control border-dashed "
                                                            wire:model.lazy="tutar.{{ $value }}" name="tutar"
                                                            readonly="readonly">
                                                    </div>
                                                </td>


                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <input type="text" id="net_tutar_{{ $value }}"
                                                            class="form-control border-dashed "
                                                            wire:model.lazy="net_tutar.{{ $value }}" name="net_tutar"
                                                            readonly="readonly">
                                                    </div>
                                                </td>

                                                <td>
                                                    <button class="btn btn-sm btn-outline-danger"
                                                        wire:loading.attr="disabled"
                                                        wire:click.prevent="remove({{$key}}, {{ $value }})"><i
                                                            class="mdi mdi-delete"></i></button>
                                                </td>



                                            </tr>

                                            @php
                                            $s = $s + 1;
                                            @endphp
                                            @endforeach
                                            <tr>
                                                <th scope="row" colspan="11"></th>
                                                <td>

                                                    <button class="btn btn-sm btn-primary" wire:loading.attr="disabled"
                                                        wire:click.prevent="add({{$i}})"><i
                                                            class="mdi mdi-plus"></i></button>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th scope="row" colspan="7"></th>
                                                <td colspan="4">
                                                    <div class="row">
                                                        <div class="col-lg-5  ">

                                                            <div class="p-1">Toplam</div>
                                                        </div>
                                                        <div class="col-lg-6 border bg-white">
                                                            <div class="p-1" id="div_toplam">
                                                                {{ number_format($toplam,2,',','.') }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-5  ">
                                                            <div class="p-1">Toplam Kdv</div>
                                                        </div>
                                                        <div class="col-lg-6 border bg-white">
                                                            <div class="p-1" id="div_kdv">
                                                                {{ number_format($toplam_kdv,2,',','.') }}
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-lg-5  ">
                                                            <div class="p-1">Net Toplam</div>
                                                        </div>
                                                        <div class="col-lg-6 border bg-white">
                                                            <div class="p-1" id="div_net_toplam">
                                                                {{ number_format($net_toplam,2,',','.') }}
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
                                    <button type="submit" class="btn btn-success ">
                                        <i class="mdi mdi-content-save"></i>Kaydet</button>
                                    <div wire:loading>
                                        İşleniyor Lütfen Bekleyiniz...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div id="malzemeModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog  modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body m-0">
                    @livewire('malzemeler.liste')
                </div>

            </div>
        </div>
    </div>


    <div id="accountsModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog  modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body m-0">
                    @livewire('logo.accounts')
                </div>

            </div>
        </div>
    </div>


    <div id="projectsModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog  modal-xl">
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


</div>