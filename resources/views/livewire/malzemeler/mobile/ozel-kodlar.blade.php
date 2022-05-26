<div>


    <div class="section full p-0 m-0">
        <div class="form-group boxed p-1">
            <div class="input-wrapper">
                <input type="text" class="form-control" wire:model="search_code" placeholder="Kod Ara">
                <i class="clear-input">
                    <ion-icon name="close-circle"></ion-icon>
                </i>
            </div>
        </div>

        <div class="wide-block p-1">

            <div class="table-responsive">
                <table class="table table-striped table-sm align-center">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Özel Kod</th>
                            <th scope="col">Ad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $d)
                        <tr>
                            <td> <button type="button" wire:click="$emit('GetKod', '{{ $d->special_code }}')"
                                    class="btn  btn-sm btn-primary ">
                                    Seç
                                </button></td>
                            <td>{{ $d->special_code }}</td>
                            <td>{{ $d->special_name }}</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>


        </div>
    </div>
    <div class="m-1"> Lütfen Kod arama bölümünü kullanınız</div>
</div>