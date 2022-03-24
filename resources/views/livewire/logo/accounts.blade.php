<div>
    <div class="row">
        <div class="col-xxl-12">
            <div class="card border">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="search-box">
                                <input type="text" class="form-control search" wire:model="search"
                                    placeholder="Ünvan Ara">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered border-secondary table-nowrap"
                            wire:loading.class="opacity-50">
                            <thead class="table-light">
                                <tr>

                                    <th scope="col" style="width:150px;">Kodu</th>
                                    <th scope="col" style="width:50px;"></th>
                                    <th scope="col">Ünvanı</th>
                                    <th scope="col">Tip</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($accounts as $account)
                                <tr>
                                    <td class="owner">{{ $account->account_code }}</td>
                                    <td class="owner"><a
                                            wire:click.prevent="addAccount('{{ $account->account_code }}', '{{ $account->account_name }}')"
                                            href="#"><button class="btn btn-primary btn-sm"> Seç </button></a></td>
                                    <td class="owner">{{ $account->account_name }}</td>
                                    <td class="owner">{{ $account->account_type }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        {{ $accounts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>