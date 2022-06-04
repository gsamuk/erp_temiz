<div>
    <div class="row">
        <div class="col-xxl-4">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">
                        Malzeme Ekle {{ $malzeme }}</h4>
                </div>

                <div class="card-body">
                    <div class="live-preview">
                        <form action="javascript:void(0);">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">

                                        <label for="malzeme" class="form-label">Malzeme Adı</label>
                                        <input type="text" wire:model.debunce.500ms="malzeme" class="form-control"
                                            placeholder="Malzeme Adı Yazınız" id="malzeme">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        @if($bul)
        <div class="col-xxl-4">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Benzer Stok Kartları</h4>
                </div>
                <div class="card-body">
                    <div class="live-preview">
                        <div class="row">
                            <style>
                                em {
                                    color: Red;
                                }
                            </style>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <ul id="search1-results">
                                        @foreach ($bul['hits'] as $b)
                                        <li>{!! $b['_highlightResult']['stock_name']['value'] !!}
                                            <small class="text-danger">
                                                SKU : {{ $b['stock_code'] }}
                                            </small>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @endif

    </div>



</div>