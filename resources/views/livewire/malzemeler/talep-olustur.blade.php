<div>
    <style>
        label {
            color: rgb(65, 62, 62);
            font-size: 0.9em;

        }
    </style>

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

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header ">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1"> <i class="ri-add-line align-bottom me-1"></i>
                            Talep Oluştur</h5>

                    </div>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="store()">
                        @csrf
                        <div class="row">




                            <div class="col-lg-12 col-md-12">

                                <div class="table-responsive">
                                    <table class="table table-sm table-striped align-middle table-nowrap">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width:20px;"></th>
                                                <th style="width:70px;">Kodu</th>
                                                <th style="width:300px;">Malzeme</th>
                                                <th style="width:100px;">Miktar</th>
                                                <th style="width:100px;">Birim</th>
                                                <th style="width:200px;">Talep Nedeni</th>
                                                <th style="width:150px;">Karşılama Türü</th>
                                                <th style="width:100px;">Stoktan Karşıla</th>
                                                <th> </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @php
                                            $s =1;
                                            @endphp
                                            @foreach ($inputs as $key => $value)
                                            <tr>
                                                <th scope="row"> {{$s}} </th>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <input type="text" class="form-control border-dashed"
                                                            readonly="readonly" name="kod[{{ $value }}]"
                                                            id="input_kod_{{ $value }}"
                                                            wire:click="$emit('setLine',{{ $value }})"
                                                            wire:model="kod.{{ $value }}" data-bs-toggle="modal"
                                                            data-bs-target="#malzemeModal">
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <input type="text" class="form-control border-dashed"
                                                            readonly="readonly" name="aciklama[{{ $value }}]"
                                                            id="input_aciklama_{{ $value }}"
                                                            wire:click="$emit('setLine',{{ $value }})"
                                                            wire:model="aciklama.{{ $value }}" data-bs-toggle="modal"
                                                            data-bs-target="#malzemeModal">
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
                                                    <div class="input-group input-group-sm ">
                                                        <input type="text" class="form-control border-dashed"
                                                            id="desc_{{ $value }}" name="desc[{{ $value }}]"
                                                            wire:model.lazy="desc.{{ $value }}">
                                                    </div>
                                                </td>


                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <select name="meet_type[{{ $value }}]"
                                                            wire:model.defer="meet_type.{{ $value }}">
                                                            <option value="2"> Ambar Transfer</option>
                                                            <option value="0"> Satınalma</option>
                                                            <option value="1"> Üretim Emri</option>

                                                        </select>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <select name="meet_stock[{{ $value }}]"
                                                            wire:model.defer="meet_stock.{{ $value }}">
                                                            <option value="0"> Evet</option>
                                                            <option value="1"> Hayır</option>
                                                        </select>
                                                    </div>
                                                </td>



                                                <td>
                                                    <button class="btn btn-sm btn-outline-danger"
                                                        wire:loading.attr="disabled"
                                                        wire:click.prevent="remove({{$key}}, {{$value}})"><i
                                                            class="mdi mdi-delete"></i></button>
                                                </td>
                                            </tr>

                                            @php
                                            $s = $s + 1;
                                            @endphp
                                            @endforeach
                                            <tr>
                                                <th scope="row" colspan="8"></th>
                                                <td>

                                                    <button class="btn btn-sm btn-primary" wire:loading.attr="disabled"
                                                        wire:click.prevent="add({{$i}})"><i
                                                            class="mdi mdi-plus"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div class="col-lg-12">
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
                                                class="mdi mdi-content-save"></i>Kaydet</button>

                                        <div wire:loading>
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




    </div>






</div>