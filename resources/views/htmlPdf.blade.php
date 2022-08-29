<html>
<meta charset="utf-8">

<body>
  <div style="padding: 5px 30px;">
    <table>
      @foreach ($data as $val => $d)
        @php
          $item = App\Models\LogoItems::find($d->logo_stockref);
          
          if ($val % 2) {
          } else {
              echo '<tr>';
          }
        @endphp
        <td style=" border:2px dashed #d1d1d1; vertical-align: text-top">
          <div style="width: 85mm; height: 52mm; margin-top:5mm">
            <table style="padding-left: 13px;">
              <TR>
                <TD colspan=3
                    style="font-size: 13pt; font-weight:bold, vertical-align: text-top; width: 70mm; height: 10mm;">
                  <b>{{ $item->stock_name }} </b>
                </TD>
              </TR>
              <TR>
                <TD rowspan=2>
                  @php
                    $qrkod = $item->logicalref . '|' . $item->stock_code . '|' . $item->stock_name;
                    echo '<img width="120" height="120" src="data:image/png;base64,' . DNS2D::getBarcodePNG($qrkod, 'QRCODE') . '" alt="barcode"   />';
                  @endphp
                </TD>
                <TD style="width:40mm;">
                  <div style="font-size: 12pt; font-weight:bold">S.K : {{ $item->stock_code }} </div>
                  @if ($item->stock_type)
                    <div style="font-size: 12pt;">S.T : {{ $item->stock_type }}</div>
                  @endif
                </TD>
              <TR>

            </table>
          </div>
        </td>
        @php
          if ($val % 2) {
              echo '</tr>';
          } else {
          }
        @endphp
      @endforeach
    </table>
  </div>
</body>

</html>
