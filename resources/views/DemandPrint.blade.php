<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <style>
    * {
      font-family: DejaVu Sans !important;
    }
  </style>
</head>

<body>
  <!-- CSS Code: Place this code in the document's head (between the 'head' tags) -->
  <style>
    table.GeneratedTable {
      width: 100%;
      background-color: #ffffff;
      border-collapse: collapse;
      border-width: 1px;
      border-color: #c0c0c0;
      border-style: solid;
      color: #000000;
      font-size: 13px;

    }

    table.GeneratedTable td,
    table.GeneratedTable th {
      border-width: 1px;
      border-color: #c0c0c0;
      border-style: solid;
      padding: 2px;
    }

    table.GeneratedTable thead {
      background-color: #f3f3f3;
    }



    table.head_table {
      color: #000000;
      margin-bottom: 10px;
      font-size: 12px;
    }

    table.head_table td,
    table.head_table th {
      margin: :1px;
      padding: 1px;
    }
  </style>
  <div style=" text-align:right; font-size:11px; ">
    No : {{ $talep->id }} | Tarih : {{ date('d - m - Y') }}
  </div>
  @if ($talep->demand_type == 1)
    <h4 style="text-align: center;">MALZEME TESLİM BELGESİ</h4>
  @endif
  @if ($talep->demand_type == 2)
    <h4 style="text-align: center;">DEPOLAR ARASI MALZEME TRANSFER BELGESİ</h4>
  @endif
  <div>
    <table class="head_table">
      <tr>
        <td>Depo</td>
        <td>: <b>{{ $depo->warehouse_name }}</b>
          @if ($talep->demand_type == 2)
            <b>> {{ $depo_hedef->warehouse_name }} Malzeme Transferi </b>
          @endif
        </td>

      </tr>
      <tr>
        <td>Talep Sahibi</td>
        <td><b>: Kademe / Ahmet Ceylan</b></td>
      </tr>
      <tr>
        <td>Talep Zamanı</td>
        <td>: <b>10-05-2022 14:50</b></td>

      </tr>
    </table>
  </div>


  <table class="GeneratedTable">
    <thead>
      <tr>
        <th style="width: 20px"></th>
        <th style="width: 50px">Kod</th>
        <th>Malzeme Adı</th>
        <th>Teslim</th>
      </tr>
    </thead>
    <tbody>

      @foreach ($detay as $i => $d)
        @php
          $loc = App\Models\Location::Where('item_ref', $d->logo_stock_ref)->first();
          $i = $i + 1;
        @endphp
        <tr>
          <td>{{ $i }}</td>
          <td>{{ $d->stock_code }}</td>

          <td style="padding-left: 5px;"><b>{{ $d->stock_name }}</b>
            @if ($d->description)
              <br> <small> Talep Nedeni :{{ $d->description }}</small>
            @endif

            @if ($loc)
              <br>
              <small>
                Lokasyon : #{{ $loc->aisle }}-{{ $loc->shelf }}-{{ $loc->bay }}-{{ $loc->bin }}</small>
            @endif
          </td>
          <td style="text-align: center; "><b>{{ Erp::nmf($d->approved_consump) }}</b><br>
            <small>{{ $d->unit_code }}</small>
          </td>
        </tr>
      @endforeach

    </tbody>
  </table>

  <div style="float: left; margin:30px; margin-left:20px; font-size:12px;">
    <b>TESLİM EDEN</b><br>
    {{ $depo->warehouse_name }} Sorumlusu
  </div>
  <div style="float: right; margin:30px; margin-right:50px; font-size:12px;">
    <b>TESLİM ALAN</b>
  </div>

</body>

</html>
