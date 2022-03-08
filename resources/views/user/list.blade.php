@extends('layouts.master')
@section('title') @lang('translation.starter') @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') ERP @endslot
@slot('title') Kullanıcı & Yetki Yönetimi @endslot
@endcomponent

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header border-2">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Kullanıcılar</h5>
                    <div class="flex-shrink-0">
                        <button class="btn btn-danger add-btn" data-bs-toggle="modal" data-bs-target="#showModal"><i
                                class="ri-add-line align-bottom me-1"></i> Kullanıcı Ekle</button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-nowrap align-middle mb-0">
                        <thead class="table-light text-muted">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Ad Soyad</th>
                                <th scope="col">Kulanıcı Adı</th>
                                <th scope="col">Şifre</th>
                                <th scope="col">Logo Kulanıcı</th>
                                <th scope="col">Satın Alma</th>
                                <th scope="col">Satış</th>
                                <th scope="col">Satın Alma Onay</th>
                                <th scope="col">Sartış Onay</th>
                                <th scope="col">Yönetici</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{ $user->id }}</th>
                                <td><b>{{ $user->name }} {{ $user->surname }}</b></td>
                                <td>{{ $user->user_name }}</td>
                                <td>{{ $user->password }}</td>
                                <td>{{ $user->logo_user }}</td>
                                <td>
                                    @if ($user->purchase_view == 1)
                                    <i class="ri-checkbox-circle-line align-middle text-success"></i>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->sale_view == 1)
                                    <i class="ri-checkbox-circle-line align-middle text-success"></i>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->purchase_approve == 1)
                                    <i class="ri-checkbox-circle-line align-middle text-success"></i>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->sale_approve == 1)
                                    <i class="ri-checkbox-circle-line align-middle text-success"></i>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->is_admin == 1)
                                    <i class="ri-checkbox-circle-line align-middle text-success"></i>
                                    @endif
                                </td>
                                <td>

                                    <div class="hstack gap-3 fs-15">
                                        <a href="user/{{ $user->id }}" class="link-primary"><i
                                                class="ri-settings-4-line"></i></a>
                                        <a href="javascript:void(0);" class="link-danger"><i
                                                class="ri-delete-bin-5-line"></i></a>
                                    </div>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>



            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->

</div>
<!-- end row -->

@endsection
@section('script')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

<script>
    $(function() {
    console.log( "ready!" );
});
</script>
@endsection