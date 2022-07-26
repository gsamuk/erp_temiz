<html>
<meta charset="utf-8">

<body>
  <div style="padding: 10px 50px;">
    <table>

      @foreach ($data as $val => $d)
        @php
          if ($val % 2) {
          } else {
              echo '<tr>';
          }
        @endphp
        <td style="border-style: dotted; vertical-align: text-top">
          <div style="width: 85mm; height: 50mm;">
            <table style="padding-left: 10px;">
              <TR>
                <TD colspan=3
                    style="font-size: 13pt; font-weight:bold, vertical-align: text-top; width: 70mm; height: 10mm;">
                  <b>{{ $d['stock_name'] }} </b>
                </TD>
              </TR>
              <TR>
                <TD rowspan=2>


                  @php
                    $qrkod = $d['logicalref'] . '|' . $d['stock_code'] . '|' . $d['stock_name'];
                    echo '<img width="120" height="120" src="data:image/png;base64,' . DNS2D::getBarcodePNG($qrkod, 'QRCODE') . '" alt="barcode"   />';
                  @endphp
                </TD>
                <TD style="width:40mm">S.Kodu : {{ $d['stock_code'] }} </TD>
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
