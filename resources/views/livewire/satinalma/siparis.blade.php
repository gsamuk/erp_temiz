<div class="row">
    <div class="col-lg-8">
        <div class="card my-3">
            <div class="card-body">
                <form>
                    @csrf
                    <div class="row">


                        <div class="col-12">
                            <!-- Small Tables -->
                            <table class="table table-sm  ">

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
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <select class="form-select" wire:model="tip.0">
                                                    <option selected>Malzeme</option>
                                                    <option value="1">Diğer</option>
                                                </select>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control" wire:model="kod.0">
                                            </div>
                                        </td>

                                        <td>
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control" wire:model="aciklama.0">
                                            </div>
                                        </td>

                                        <td>
                                            <div class="input-group input-group-sm">
                                                <input type="number" class="form-control" wire:model="miktar.0">
                                            </div>
                                        </td>

                                        <td>
                                            <div class="input-group input-group-sm">
                                                <select class="form-select" wire:model="birim.0">
                                                    <option selected>Adet</option>
                                                    <option value="1">Kutu</option>
                                                </select>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="input-group input-group-sm">
                                                <input type="number" class="form-control" wire:model="birim_fiyat.0">
                                            </div>
                                        </td>



                                        <td>
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
                                                    wire:model="kod.{{ $value }}">
                                            </div>
                                        </td>

                                        <td>
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control border-dashed"
                                                    wire:model="aciklama.{{ $value }}"
                                                    wire:click.prevent="$emit('showModal', {{ $i }})">
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
                                            <button class="btn btn-sm btn-light"
                                                wire:click.prevent="remove({{$key}})"><i
                                                    class="mdi mdi-delete"></i></button>

                                        </td>



                                    </tr>
                                    @endforeach





                                </tbody>
                            </table>
                        </div>



                    </div>
                    <div class="row ms-0 mt-2">
                        <div class="col-12 ps-0">
                            <button class="btn btn-primary mb-3 position-absolute top-0 end-0"
                                wire:click.prevent="add({{$i}})"><i class="mdi mdi-plus"></i></button>

                            <button class="btn btn-success mb-3 "> <i class="mdi mdi-content-save"></i>
                                Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>