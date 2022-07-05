<div>

  <div class="card">
    <div class="card-header align-items-center d-flex">
      <h4 class="card-title flex-grow-1 mb-0"> {{ $user->name }} {{ $user->surname }}
        <small> > Depo İzinleri</small>
      </h4>
    </div>
    <div class="card-body">

      <div class="row">
        <div class="col-lg-5">
          <div class="bg-light m-1 p-2">
            @php
              $firmalar = App\Models\company::all();
            @endphp

            <select class="form-select mb-1 mt-3" wire:model="firma" aria-label="Default select example" disabled>
              @foreach ($firmalar as $d)
                <option value="{{ $d->id }}" selected>{{ $d->logo_firm_name }}</option>
              @endforeach
            </select>

            @php
              $depolar = App\Models\LogoWarehouses::Where('company_no', $firma)->get();
            @endphp

            <select class="form-select" wire:model="depo" aria-label="Default select example">
              @foreach ($depolar as $d)
                <option value="{{ $d->warehouse_no }}">{{ $d->warehouse_name }}</option>
              @endforeach
            </select>
            <button wire:click="depo_izin_ekle()" wire:loading.attr="disabled" class="btn btn-sm btn-success mt-2">İzin
              Ekle</button>
          </div>
        </div>

        <div class="col-lg-7">
          @if ($user_company->count() > 0)
            <table class="table-sm table-nowrap table-striped table">
              <thead>
                <tr>
                  <th scope="col">Firma</th>
                  <th scope="col">Depo</th>
                  <th scope="col">-</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($user_company as $d)
                  @php
                    $depo = App\Models\LogoWarehouses::Where('company_no', $d->company_id)
                        ->Where('warehouse_no', $d->warehouse_no)
                        ->first();
                    $firma = App\Models\company::Where('id', $d->company_id)->first();
                  @endphp
                  <tr>
                    <td>{{ $firma->logo_firm_name }}</td>
                    <td>{{ $depo->warehouse_name }}</td>
                    <td> <button wire:click="depo_izin_cikar({{ $d->id }})"
                              class="btn btn-sm btn-danger">Çıkar</button>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>

            <div class="text-info mt-3">Bu kullanıcının yetkili olduğu depolar.</div>
          @else
            <div class="text-danger mt-3">Bu kullanıcı için Depo izni eklenmedi.</div>
          @endif
        </div>

      </div>

    </div><!-- end card-body -->
  </div><!-- end card -->




  <div class="card">
    <div class="card-header align-items-center d-flex">
      <h4 class="card-title flex-grow-1 mb-0"> {{ $user->name }} {{ $user->surname }}
        <small> > ERP İzinleri</small>
      </h4>
    </div>
    <div class="card-body">
      <table class="table-sm table-nowrap table-striped table">
        <thead>
          <tr>
            <th scope="col"></th>
            <th scope="col">Grup</th>
            <th scope="col">Kod</th>
            <th scope="col">İzin Türü</th>
            <th scope="col">-</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($permissions as $d)
            @php
              $izin = App\Models\UserPermissions::where('user_id', $user_id)
                  ->Where('permission_id', $d->id)
                  ->first();
            @endphp
            <tr>
              <td>
                @if ($izin)
                  <i class="ri-checkbox-circle-line text-success align-middle"></i>
                @else
                  <i class="ri-close-circle-line text-danger align-middle"></i>
                @endif
              </td>

              <td>{{ $d->group_name }}</td>
              <td>{{ $d->name }}</td>
              <td>{{ $d->description }}</td>
              <td>
                @if ($izin)
                  <button wire:click="cikar({{ $d->id }})" class="btn btn-sm btn-danger">Çıkar</button>
                @else
                  <button wire:click="ekle({{ $d->id }})" class="btn btn-sm btn-success">Ekle</button>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div><!-- end card-body -->
  </div><!-- end card -->



</div>
