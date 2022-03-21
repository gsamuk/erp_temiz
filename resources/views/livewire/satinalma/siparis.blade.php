<div>
    <style>
        label {
            font-size: 10px;
            color: #424141;
        }

        table th {
            font-size: 10px;
        }
    </style>
    <form>
        @csrf
        <div class="row">


            <div class="col-xxl-10">
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
                                    <div class="col-12 ">
                                        <table class="table table-sm ">
                                            <tr>
                                                <th class="px-2">
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <label class="form-label">Fiş No</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <input type="text"
                                                                class="form-control form-control-sm mb-1 rounded-0">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <label class="form-label">Tarih</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <input type="text"
                                                                class="form-control form-control-sm mb-1 rounded-0">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <label class="form-label">Belge No</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <input type="text"
                                                                class="form-control form-control-sm mb-1 rounded-0">
                                                        </div>
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <label class="form-label">Proje Kodu</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <input type="text"
                                                                class="form-control form-control-sm mb-1 rounded-0">
                                                        </div>
                                                    </div>
                                                </th>
                                                <th class="px-2">
                                                    <div class="row">
                                                        <div class="col-lg-2">
                                                            <label class="form-label">Kodu</label>
                                                        </div>
                                                        <div class="col-lg-10">
                                                            <input type="text"
                                                                class="form-control form-control-sm mb-1 rounded-0">
                                                        </div>

                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-2">
                                                            <label class="form-label">Unvanı</label>
                                                        </div>
                                                        <div class="col-lg-10">
                                                            <input type="text"
                                                                class="form-control form-control-sm mb-1 rounded-0">
                                                        </div>
                                                    </div>

                                                </th>
                                                <th class="px-2">

                                                    <div class="row">
                                                        <div class="col-lg-2">
                                                            <label class="form-label">İş Yeri</label>
                                                        </div>
                                                        <div class="col-lg-10">
                                                            <input type="text"
                                                                class="form-control form-control-sm mb-1 rounded-0">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-2">
                                                            <label class="form-label">Bölüm</label>
                                                        </div>
                                                        <div class="col-lg-10">
                                                            <input type="text"
                                                                class="form-control form-control-sm mb-1 rounded-0">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-2">
                                                            <label class="form-label">Fabrika</label>
                                                        </div>
                                                        <div class="col-lg-10">
                                                            <input type="text"
                                                                class="form-control form-control-sm mb-1 rounded-0">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-2">
                                                            <label class="form-label">Ambar</label>
                                                        </div>
                                                        <div class="col-lg-10">
                                                            <input type="text"
                                                                class="form-control form-control-sm mb-1 rounded-0">
                                                        </div>
                                                    </div>


                                                </th>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="col-12 bg-light">
                                        <table class="table table-sm">

                                            <thead>
                                                <tr>
                                                    <th scope="col"></th>
                                                    <th scope="col">Türü</th>
                                                    <th scope="col">Kodu</th>
                                                    <th scope="col">Açıklaması</th>
                                                    <th scope="col">Miktar</th>
                                                    <th scope="col">Birim</th>
                                                    <th scope="col">Birim Fiyat</th>
                                                    <th scope="col"></th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>
                                                        <div class="input-group input-group-sm ">
                                                            <select class="form-select rounded-0" wire:model="tip.0">
                                                                <option selected>Malzeme</option>
                                                                <option value="1">Diğer</option>
                                                            </select>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <input type="text" class="form-control rounded-0"
                                                                wire:model="kod.0"
                                                                wire:click.prevent="$emit('setLine',0)"
                                                                data-bs-toggle="modal" data-bs-target="#malzemeModal">
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <input type="text" class="form-control rounded-0"
                                                                wire:model="aciklama.0" data-bs-toggle="modal"
                                                                data-bs-target="#malzemeModal">
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <input type="number" class="form-control rounded-0"
                                                                wire:model="miktar.0">
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <select class="form-select rounded-0" wire:model="birim.0">
                                                                <option selected>Adet</option>
                                                                <option value="1">Kutu</option>
                                                            </select>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <input type="number" class="form-control rounded-0"
                                                                wire:model="birim_fiyat.0">
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary"
                                                            wire:click.prevent="add({{$i}})"><i
                                                                class="mdi mdi-plus"></i></button>
                                                    </td>
                                                </tr>
                                                @foreach ($inputs as $key => $value)
                                                <tr>
                                                    <th scope="row"> {{ $value}} </th>
                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <select class="form-select" wire:model="tip.{{ $value }}">
                                                                <option selected>Malzeme</option>
                                                                <option value="1">Diğer</option>
                                                            </select>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <input type="text" class="form-control border-dashed"
                                                                wire:click="$emitTo('malzemeler.index','setLine',{{ $value }})"
                                                                wire:model="kod.{{ $value }}" data-bs-toggle="modal"
                                                                data-bs-target="#malzemeModal">
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <input type="text" class="form-control border-dashed"
                                                                wire:click="$emitTo('malzemeler.index','setLine',{{ $value }})"
                                                                wire:model="aciklama.{{ $value }}"
                                                                data-bs-toggle="modal" data-bs-target="#malzemeModal">
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <input type="number" class="form-control border-dashed "
                                                                wire:model="miktar.{{ $value }}">
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <select class="form-select" wire:model="birim.{{ $value }}">
                                                                <option selected>Adet</option>
                                                                <option value="1">Kutu</option>
                                                            </select>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <input type="number" class="form-control border-dashed "
                                                                wire:model="birim_fiyat.{{ $value }}">
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <button class="btn btn-sm btn-outline-danger"
                                                            wire:click.prevent="remove({{$key}})"><i
                                                                class="mdi mdi-delete"></i></button>
                                                    </td>

                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary "
                                                            wire:click.prevent="add({{$i}})"><i
                                                                class="mdi mdi-plus"></i></button>
                                                    </td>

                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <th scope="row" colspan="5"></th>
                                                    <td colspan="4">
                                                        <div class="row">
                                                            <div class="col-lg-5  ">
                                                                <div class="p-1">Toplam Masraf</div>
                                                            </div>
                                                            <div class="col-lg-7 border bg-white">
                                                                <div class="p-1">
                                                                    2858.5
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-5  ">
                                                                <div class="p-1">Toplam İndirim</div>
                                                            </div>
                                                            <div class="col-lg-7 border bg-white">
                                                                <div class="p-1">
                                                                    2858.5
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="row">
                                                            <div class="col-lg-5  ">
                                                                <div class="p-1">Toplam</div>
                                                            </div>
                                                            <div class="col-lg-7 border bg-white">
                                                                <div class="p-1">
                                                                    2858.5
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 m-2 ">
                                            <button class="btn btn-success "> <i
                                                    class="mdi mdi-content-save"></i>Save</button>
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
    <div id="malzemeModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                @livewire('malzemeler.index')
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>