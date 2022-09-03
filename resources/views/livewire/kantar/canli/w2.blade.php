<div wire:poll.20000ms>
  <div class="table-responsive table-card">
    <table class="table-striped table-nowrap table-sm mb-0 table align-middle">
      <thead class="table-light">
        <tr class="text-muted">
          <th scope="col">Kantar</th>
          <th scope="col">Fiş No</th>
          <th scope="col">Plaka</th>
          <th scope="col">Cari</th>
          <th scope="col">Bakiye</th>
          <th scope="col">İlk Tartı</th>
          <th scope="col">Son Tartı</th>
          <th scope="col">1.Tartı</th>
          <th scope="col">2.Tartı</th>
          <th scope="col">Net</th>
          <th scope="col">Malzeme</th>
        </tr>
      </thead>

      <tbody>

        @foreach ($data as $w)
          @php
            $firm = App\Models\LogoAccountsDetails::Where('account_code', $w->FirmCode)->first();
          @endphp
          <tr>
            <td>{{ $w->Scale }}</td>
            <td>{{ $w->TicketNo }}</td>
            <td>{{ $w->Plate }}</td>
            <td class="text-primary"><b>{{ $w->FirmName }}</b></td>
            <td class="text-danger">
              @if ($firm)
                <b>{{ Erp::nmf($firm->balance) }}</b>
              @endif
            </td>
            <td>{{ date('m-d > H:i', strtotime($w->WeighTime1)) }}</td>
            <td>{{ date('m-d > H:i', strtotime($w->WeighTime2)) }}</td>
            <td>{{ Erp::nmf($w->Weight1 / 1000, 2) }} <small>TON</small></td>
            <td>{{ Erp::nmf($w->Weight2 / 1000, 2) }} <small>TON</small></td>
            <td class="text-danger"><b>{{ Erp::nmf($w->Net / 1000, 2) }} <small>TON</small></b></td>
            <td class="text-success">{{ $w->MaterialName }}</td>
          </tr>
        @endforeach
        <tr>
          <td colspan="10">
            <div wire:loading>
              İşleniyor...
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="d-flex justify-content-end mt-3">
      {{ $data->links() }}
    </div>
  </div>
</div>
