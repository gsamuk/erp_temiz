<div>

    <div class="row ">
        <div class="col-lg-5 col-md-12 col-sm-12 p-1">

            <div class="card ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-5">
                            <input type="text" class="form-control m-1" placeholder="{{__('Stok kodu arayınız ...')}}"
                                x-on:input.debounce.400ms="isTyped = ($event.target.value != '')" autocomplete="off"
                                wire:model.debounce.500ms="code" aria-label="Search input">

                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control m-1" placeholder="{{__('Malzeme adı arayınız ...')}}"
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
                    <table class="table align-middle  table-nowrap table-sm mt-2">
                        <thead>
                            <tr>
                                <th scope="col" style="width:80px"></th>
                                <th scope="col" style="width:80px">S.Kodu</th>
                                <th scope="col">Malzeme</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $d)
                            <tr>
                                <td>

                                    <button wire:click="get_foto({{$d->logicalref}})"
                                        class="btn btn-outline-success btn-sm   waves-effect waves-light"><i
                                            class="mdi mdi-image"></i> Yükle </button>

                                </td>
                                <th scope="row"><a href="#" class="fw-semibold">{{ $d->stock_code }}</a>
                                </th>
                                <td>{{$d->stock_name}} </td>

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

        @if($ref > 0)
        <div class="col-lg-7 col-md-6 p-1">
            <div class="card ribbon-box border shadow-none mb-lg-0">

                <div class="card-body ">
                    <div class="ribbon ribbon-success ribbon-shape">{{ $item->stock_name }}</div>
                    <h5 class="fs-14 text-end"><small class="text-muted"> Stok Kodu : </small>{{ $item->stock_code }}
                    </h5>
                    <div class="ribbon-content mt-4 text-muted">
                        <div class="form-group boxed">
                            <form wire:submit.prevent="save">
                                @csrf


                                <label for="file" class="btn btn-info btn-label rounded-pill"><i
                                        class="ri-image-fill label-icon align-middle rounded-pill fs-16 me-2"></i>
                                    Fotoğraf Yükle</label>
                                <input type="file" id="file" style="display:none;" wire:model="photo">
                                <div wire:loading wire:target="photo">
                                    <div class="spinner-grow text-dark" role="status">
                                        <span class="sr-only">Yükleniyor...</span>
                                    </div>
                                </div>
                                @if ($photo)
                                <div class="m-2">
                                    <img src="{{ $photo->temporaryUrl() }}" class="img-thumbnail" style="width:200px">
                                </div>
                                @endif

                                @error('photo')<span class="badge bg-danger">{{ $message }}</span> @enderror
                                @if (session()->has('success'))


                                <div class="alert alert-secondary alert-dismissible alert-label-icon rounded-label fade show"
                                    role="alert">
                                    <i class="ri-check-double-line label-icon"></i>
                                    {{ session('success') }} , bu ürüne yeni fotoğraf yüklemek için "fotoğraf ekle"
                                    butonuna tıklayın.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
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
                    </div>
                </div>
            </div>

            @if($item_photos)
            <div class="card border card-border-light">
                <div class="card-body">
                    <div class="row">
                        @foreach ($item_photos as $p)
                        <div class="col-lg-3">
                            <div class="bg-light p-2 m-1">
                                <div>
                                    <img class="img-thumbnail"
                                        src="{{ asset('public/storage/images/items/thumb/'.$p->foto_path) }}">
                                </div>
                                <div>
                                    <button wire:click="delete_photo({{ $p->id }}, '{{ $p->foto_path }}')"
                                        class="btn btn-soft-danger btn-sm waves-effect waves-light mt-2 ">
                                        Sil</button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>

</div>