<div>
    <!-- Active Tables -->
    <table class="table table-sm table-nowrap mb-0">
        <thead>
            <tr>

                <th scope="col">İzin Grubu</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col">İzin Türü</th>
                <th scope="col">-</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($permissions as $d)
            @php
            $izin = App\Models\UserPermissions::where('user_id', $user_id)->Where('permission_id', $d->id)->first();
            @endphp
            <tr>

                <td>{{ $d->group_name }}</td>
                <td>{{ $d->name }}</td>
                <td>@if($izin) <i class="ri-checkbox-circle-line align-middle text-success"></i> @else <i
                        class="ri-close-circle-line align-middle text-danger"></i> @endif</td>
                <td>{{ $d->description }}</td>
                <td>
                    @if($izin)
                    <button wire:click="cikar({{ $d->id }})" class="btn btn-sm btn-danger">Çıkar</button>
                    @else
                    <button wire:click="ekle({{ $d->id }})" class="btn btn-sm btn-success">Ekle</button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>