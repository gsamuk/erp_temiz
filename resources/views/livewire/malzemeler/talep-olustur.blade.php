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
                    @livewire('malzemeler.liste', ['ch'=> true])
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

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header ">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1"> <i class="ri-add-line align-bottom me-1"></i>
                            Talep @if($tid > 0) Düzenle @else Oluştur @endif</h5>

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
                                                            wire:model.defer="miktar.{{ $value }}">
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
                                                <th scope="row" colspan="6"></th>
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
                                    <div class="col-12 m-2 ">
                                        <div class="alert alert-success alert-dismissible fade show shadow">
                                            {{ session('success') }}
                                        </div>
                                    </div>
                                    @endif

                                    @if(!$inputs)
                                    <div class="col-12 m-2 ">
                                        Malzeme İstek Listesi Oluşturun.
                                    </div>
                                    @endif

                                    <div class="col-12 m-2 ">
                                        <button type="submit" class="btn btn-success" @if(!$inputs) disabled @endif> <i
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

        @if($item_photos)
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header ">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1"> <i class="ri-add-line align-bottom me-1"></i>
                            Seçili Malzeme Fotoğrafları</h5>

                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($item_photos as $p)
                        <div class="col-4">
                            <div class="bg-light p-2 m-1">
                                <div>
                                    <img src="{{ asset('storage/images/items/thumb/'.$p['foto_path']) }}">
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