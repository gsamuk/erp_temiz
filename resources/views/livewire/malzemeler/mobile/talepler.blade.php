<div>

    <div id="appCapsule">
        <div class="section full mt-2">
            <div class="section-title">
                <b>Malzeme Talepleriniz</b>
                <small>Son 10 Talep</small>
            </div>
            @if($talepler->count() > 0)
            @foreach($talepler as $d)

            @php
            $data = App\Models\DemandDetail::where('demand_id', $d->id)->get();
            @endphp

            <div class="accordion" id="talep_{{ $d->id }}">

                <div class="item">
                    <div class="accordion-header">
                        <div class="btn collapsed" type="button" data-toggle="collapse"
                            data-target="#talep_ac{{ $d->id }}">
                            Talep No : <b>{{ $d->id }}</b>
                            <hr>
                            <small>
                                {{\Carbon\Carbon::createFromTimeStamp(strtotime($d->insert_time))->diffForHumans()}}</small>
                        </div>
                    </div>
                    <div id="talep_ac{{ $d->id }}" class="accordion-body collapse" data-parent="#talep_{{ $d->id }}">
                        <div class="accordion-content  p-1">

                            <table class="table table-sm table-striped  table-dark bg-secondary">
                                <thead>
                                    <tr>
                                        <th scope="col">Stok No / Malzeme</th>
                                        <th scope="col">Miktar</th>
                                        <th scope="col">Durum</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $dt)
                                    @php
                                    $item_detail = App\Models\LogoItems::find($dt->logo_stock_ref);
                                    @endphp
                                    <tr>
                                        <td><small>{{ $item_detail->stock_code }} | {{ $item_detail->stock_name
                                                }} </small> </td>
                                        <td><small>{{ number_format($dt->quantity,0,',','.') }} {{ $dt->unit_code
                                                }}</small></td>
                                        <td>{{ $dt->status }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
                @endforeach
                @endif
            </div>


        </div>

    </div>