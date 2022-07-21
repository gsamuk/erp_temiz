<div>
  <div class="row">
    @if ($item_ref)
      <div class="col-xxl-12">
        @php
          $son_satinalma = Illuminate\Support\Facades\DB::select(
              "
                        Exec dbo.sp_get_last_purchase
                        @company_id ='001',
                        @term_id = '10',
                        @rowcount = 5,
                        @item_ref = ?
                        ",
              [$item_ref],
          );
        @endphp

        @if ($son_satinalma)
          <h5> Son Satınalma Yapılan Cariler > <small class="text-danger"> {{ $item_name }} </small> </h5>
          <div class="table-responsive">
            <table class="table-sm table-bordered table-striped table-nowrap table">
              <thead class="table-light">
                <tr>
                  <th scope="col" style="width:150px;">Kodu</th>
                  <th scope="col" style="width:50px;"></th>
                  <th scope="col">Cari</th>
                  <th scope="col">Miktar</th>
                  <th scope="col">Birim Fiyat</th>
                  <th scope="col">Toplam</th>
                  <th scope="col">Tarih</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($son_satinalma as $s)
                  <tr>
                    <td>{{ $s->account_code }}</td>
                    <td>
                      <button data-bs-dismiss="modal"
                              wire:click="$emit('getAccount_','{{ $s->account_ref }}')"
                              class="btn btn-success btn-sm"> Seç </button>
                    </td>
                    <td>{{ $s->account_name }}</td>
                    <td>{{ number_format($s->quantity, 0, '.', ',') }}
                      {{ $s->unit_code }}</td>
                    <td>{{ number_format($s->unit_price, 2, '.', ',') }}</td>
                    <td>{{ number_format($s->amount, 2, '.', ',') }}</td>
                    <td>{{ $s->po_date }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif


      </div>
    @endif

    <div class="col-xxl-12">

      <div class="row mb-3">
        <div class="col-md-5">
          <div class="search-box">
            <input type="text" class="form-control search" wire:model.debunce.500ms="search" placeholder="Ünvan Ara">
            <i class="ri-search-line search-icon"></i>
          </div>
        </div>
      </div>
      @if ($accounts->count() > 0)
        <h5>Diğer Cariler @if ($item_name)
            <small class="text-danger"> > {{ $item_name }} </small>
          @endif
        </h5>

        <div class="table-responsive">

          <table class="table-sm table-bordered table-striped table-nowrap table"
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
                  <td class="owner">
                    <button data-bs-dismiss="modal" wire:click="$emit('getAccount', '{{ $account }}')"
                            class="btn btn-primary btn-sm"> Seç </button>
                  </td>
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
      @else
        Bulunamadı

      @endif
    </div>
  </div>
</div>
