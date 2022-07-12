<div>
  <div class="card">
    <div class="card-header align-items-center d-flex">
      <h4 class="card-title flex-grow-1 mb-0">Onay Bekleyen Melzemeler</h4>

    </div><!-- end card header -->
    <div class="card-body">
      @if ($data->count() > 0)
        <table class="table-hover table-sm table-striped table-nowrap mb-0 table align-middle">
          <thead>
            <tr>
              <th scope="col">Talep Eden</th>
              <th scope="col">Talep Türü</th>
              <th scope="col">Malzeme</th>
              <th scope="col">İstenen</th>
              <th scope="col">Stok</th>
              <th scope="col" style="width:90px;">Karşıla</th>
              <th scope="col" style="width:90px;">Satınal</th>
              <th scope="col">Birim Fiyatı</th>
              <th scope="col">Toplam</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($data as $dt)
              @php
                
                $user = Erp::user($dt->users_id);
                $item_detail = App\Models\LogoItems::where('logicalref', $dt->logo_stock_ref)
                    ->where('wh_no', $dt->warehouse_no)
                    ->first();
                
                $w1 = App\Models\LogoWarehouses::where('warehouse_no', "$dt->warehouse_no")
                    ->where('company_no', 1)
                    ->first();
                
                $w2 = App\Models\LogoWarehouses::where('warehouse_no', "$dt->dest_wh_no")
                    ->where('company_no', 1)
                    ->first();
                
              @endphp
              <tr>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div class="flex-shrink-0">
                      @if ($user->photo_path)
                        <img class="avatar-xs rounded-circle"
                             src="{{ asset('public/storage/images/users/' . $user->photo_path) }}">
                      @else
                        <img src="assets/images/users/avatar-3.jpg" alt=""
                             class="avatar-xs rounded-circle">
                      @endif
                    </div>
                    <div class="flex-grow-1">
                      {{ $user->name }} {{ $user->surname }}
                    </div>
                  </div>


                </td>
                <td>
                  @if ($dt->demand_type == 1)
                    <small>
                      Depo Sarf <br>{{ $w1->warehouse_name }}</small>
                  @else
                    <small> Depo Transfer <br>
                      {{ $w1->warehouse_name }} > {{ $w2->warehouse_name }}
                    </small>
                  @endif
                </td>
                <td><b>{{ $dt->stock_name }}</b><br>
                  <small class="text-warning">Neden: {{ $dt->description }}</small>
                </td>
                <td>{{ number_format($dt->quantity, 0, ',', '.') }} <br><small>{{ $dt->unit_code }}</small></td>
                <td class="text-danger">{{ number_format($item_detail->onhand_quantity, 0, ',', '.') }}</td>
                <td>
                  <input type="number" class="form-control" id="cons_{{ $dt->dt_id }}"
                         @if ($item_detail->onhand_quantity == 0) disabled @endif
                         min="0"
                         value="{{ number_format($dt->approved_consump, 0, ',', '.') }}"
                         class="form-control"
                         max="{{ $item_detail->onhand_quantity }}"
                         onkeyup=imposeMinMax(this)>
                </td>

                <td>
                  <input type="number" class="form-control" id="purc_{{ $dt->dt_id }}"
                         min="0"
                         value="{{ number_format($dt->approved_purchase, 0, ',', '.') }}"
                         class="form-control">
                </td>

                <td>{{ number_format($dt->average_price, 2, ',', '.') }}</td>
                <td>{{ number_format($dt->approved_consump * $dt->average_price, 2, ',', '.') }}</td>

                <td>
                  <button wire:click="onay(
                    '{{ $dt->dt_id }}', 
                    $('#cons_{{ $dt->dt_id }}').val(),
                    $('#purc_{{ $dt->dt_id }}').val(),
                    )"
                          class="btn btn-sm btn-soft-success">Onayla</button>
                  <button wire:click="islem('{{ $dt->dt_id }}',9)" class="btn btn-sm btn-soft-danger">Red</button>
                </td>
              </tr>
            @endforeach

          </tbody>
        </table>
        <div class="d-flex justify-content-end mt-3">
          {{ $data->links() }}
        </div>
      @else
        <!-- Secondary Alert -->
        <div class="alert alert-warning" role="alert">
          Onay Bekleyen Malzeme Bulunamadı...
        </div>
      @endif
    </div>
  </div>
</div>
