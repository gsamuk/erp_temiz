<div>

    <div class="row ">
        <div class="col-lg-6 col-md-12 col-sm-12 p-1">

            <div class="card ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-5">

                            <input type="text" class="form-control" placeholder="{{__('Stok kodu arayınız ...')}}"
                                x-on:input.debounce.400ms="isTyped = ($event.target.value != '')" autocomplete="off"
                                wire:model.debounce.500ms="code" aria-label="Search input">

                        </div>
                        <div class="col-lg-5">

                            <input type="text" class="form-control" placeholder="{{__('Malzeme adı arayınız ...')}}"
                                x-on:input.debounce.400ms="isTyped = ($event.target.value != '')" autocomplete="off"
                                wire:model.debounce.500ms="search" aria-label="Search input">
                        </div>

                        <div class="col-lg-1">
                            <div wire:loading>
                                <div class="spinner-border text-light" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>

                        </div>
                    </div>


                    @if($data)
                    <table class="table  table-nowrap table-sm mt-2">
                        <thead>
                            <tr>
                                <th scope="col" style="width:80px">S.Kodu</th>
                                <th scope="col">Malzeme</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $d)
                            <tr>
                                <th scope="row"><a href="#" class="fw-semibold">{{ $d->stock_code }}</a>
                                </th>
                                <td>{{$d->stock_name}} </td>
                                <td><button wire:click="get_foto({{$d->logicalref}})"
                                        class="btn btn-sm btn-info">Fotoğraf</button></td>
                            </tr>
                            @empty
                            <tr>
                                <th scope="row"><a href="#" class="fw-semibold">.....</a></th>
                                <td>.....</td>
                                <td></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @else
                    <br>
                    <p><small>Fotoğraf eklemesi yapacağınız malzemeyi arayınız...</small></p>
                    @endif

                </div>
            </div>

        </div>


        <div class="col-lg-6 col-md-6 p-1">
            <div class="card">



                <div class="card-body ">
                    @if($ref > 0)


                    <div class="form-group boxed">
                        <form wire:submit.prevent="save">
                            @csrf

                            <!-- Stacks - Horizontal -->
                            <div class="hstack gap-3 mb-3">
                                <div class="bg-primary  text-light border p-1 px-2">{{ $item->stock_code }}</div>
                                <div class="bg-primary text-light border p-1 px-2">{{ $item->stock_name }}</div>

                            </div>
                            <label for="file" class="btn btn-outline-primary shadowed mr-1 mb-1">Fotoğraf
                                Ekle</label>
                            <input type="file" id="file" style="display:none;" wire:model="photo">
                            <div wire:loading wire:target="photo">
                                <div class="spinner-grow text-dark" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>


                            </div>
                            @if ($photo)
                            <div class="m-2">
                                <img src="{{ $photo->temporaryUrl() }}" class="img-thumbnail" style="width:200px">
                            </div>
                            @endif

                            @error('photo')<span class="badge bg-danger">{{ $message }}</span> @enderror

                            @if (session()->has('success'))
                            <div>
                                <span class="badge bg-success"> {{ session('success') }}</span>
                            </div>
                            @endif

                            @if ($photo)
                            <div class="m-2">
                                <hr>
                                <button wire:loading.attr="disabled" class="btn btn-success shadowed mr-1 mb-1"
                                    type="submit">Kaydet</button>
                            </div>
                            @endif
                        </form>
                    </div>

                    @endif
                </div>
            </div>

            @if($item_photos)
            @foreach ($item_photos as $p)
            <img class="img-thumbnail" style="width:300px" src="{{ asset('storage/images/items/'.$p->foto_path) }}">
            @endforeach
            @endif

        </div>
    </div>

</div>