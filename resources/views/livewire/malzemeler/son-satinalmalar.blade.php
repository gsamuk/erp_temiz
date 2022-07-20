<div>
  @php
    
    $son_satinalma = Illuminate\Support\Facades\DB::select(
        "
              Exec dbo.sp_get_last_purchase
              @company_id ='001',
              @term_id = '10',
              @rowcount = 5,
              @item_ref = ?
              ",
        [$itemref],
    );
    
  @endphp

  @if ($son_satinalma)
    <h5>Son Satınalma Tutarları.</h5>
    <table class="table-sm table-nowrap table-striped table-bordered table">
      <thead>
        <tr>
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
            <td>{{ $s->account_name }}</td>
            <td>{{ number_format($s->quantity, 0, '.', ',') }} {{ $s->unit_code }}</td>
            <td>{{ number_format($s->unit_price, 2, '.', ',') }}</td>
            <td>{{ number_format($s->amount, 2, '.', ',') }}</td>
            <td>{{ $s->po_date }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
</div>
