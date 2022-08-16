<div>
  <div class="card card-border-warning border">
    <div class="card-header">
      <h4>Firma Bakiye Durum</h4>
      <div class="row">
        <div class="col-3">
          <input type="text" class="form-control search" wire:model.debunce.500ms="kod"
                 placeholder="Firma Kodu Ara">
        </div>

        <div class="col-3">
          <input type="text" class="form-control search" style="text-transform: uppercase"
                 wire:model.debunce.500ms="search"
                 placeholder="Firma Ara">
        </div>


      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive table-card">
        @if ($data->count() > 0)
          <table class="table-nowrap table-sm table-striped mb-0 table">
            <thead class="table-light">
              <tr>
                <th scope="col">Kodu </th>
                <th scope="col">Ünvanı</th>
                <th scope="col">Bakiye</th>
                <th scope="col">Bakiye ($)</th>
                <th scope="col">Son Satış</th>
                <th scope="col">Son Ödeme</th>
              </tr>
            </thead>
            <tbody>

              @foreach ($data as $key => $d)
                <tr>
                  <td>{{ $d->account_code }}</td>
                  <td><b>{{ $d->account_name }}</b></td>
                  <td @if ($d->balance < 0) class="text-danger" @endif> <b>{{ Erp::nmf($d->balance) }}</b>
                  </td>
                  <td><b>{{ Erp::nmf($d->balance_usd) }}</b></td>
                  <td>{{ Erp::tarih($d->last_sales_date) }}</td>
                  <td>{{ Erp::tarih($d->last_payment_date) }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <div class="d-flex justify-content-end m-3">
            {{ $data->links() }}
          </div>
        @else
          <div class="m-2 p-2">Aranan: <b>"{{ $search }} {{ $kod }}"</b> Hesap yada Hesap Kodu
            Bulunamadı... </div>
        @endif

      </div>
    </div>
  </div>
</div>
