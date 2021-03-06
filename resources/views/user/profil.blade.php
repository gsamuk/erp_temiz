@extends('layouts.master')
@section('title') @lang('translation.settings') @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') ERP @endslot
@slot('title') Profil Yönetimi ( {{ $name }} {{ $surname }} ) @endslot
@endcomponent
<div class="row">
    <!--end col-->
    <div class="col-xxl-6">
        @foreach ($errors->all() as $error)
        <p class="text-danger">{{ $error }}</p>
        @endforeach
        <div class="card ">
            <div class="card-header">
                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                            <i class="fas fa-home"></i>
                            Profil Bilgilileri
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                            <i class="far fa-user"></i>
                            Şifre Değiş
                        </a>
                    </li>

                </ul>
            </div>
            <div class="card-body p-4">
                <div class="tab-content">
                    <div class="tab-pane active" id="personalDetails" role="tabpanel">
                        <!--end col-->
                        @if (session()->has('message'))
                        <div class="col-lg-12">
                            <div class="alert alert-success alert-dismissible fade show shadow" role="alert">
                                {{ session()->get('message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                        @endif
                        <form action="{{ route('profil.post') }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $id }}" name="user_id">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">İsim</label>
                                        <input type="text" class="form-control" name="name" value="{{ $name }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="surname" class="form-label">Soyisim</label>
                                        <input type="text" class="form-control" name="surname" value="{{ $surname }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="user_name" class="form-label">Kullanıcı Adı</label>
                                        <input type="text" class="form-control" name="user_name"
                                            value="{{ $user_name }}">
                                        @error('user_name')
                                        <small class="is-invalid text-left alert alert-danger bg-light p-1">
                                            {{ $message }}
                                        </small>
                                        @enderror

                                    </div>
                                </div>

                                <!--end col-->
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" name="email" value="{{ $email }}">
                                        @error('email')
                                        <small class="is-invalid text-left alert alert-danger bg-light p-1">
                                            {{ $message }}
                                        </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="logo_user" class="form-label">LOGO Kulanıcı Adı</label>
                                        <input type="text" class="form-control" name="logo_user"
                                            value="{{ $logo_user }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="logo_password" class="form-label">LOGO Kullanıcı Şifresi</label>
                                        <input type="password" class="form-control" name="logo_password"
                                            value="{{ $logo_password }}">
                                    </div>
                                </div>




                                @if(Erp::izin('is_admin'))
                                <div class="col-lg-12">
                                    <input type="checkbox" name="is_active" data-plugin="switchery" data-color="#1bb99a"
                                        {{ $is_active ? 'checked' : '' }}>
                                    <label class="form-check-label" for="formCheck6">
                                        Kullanıcı Aktif <small>( Pasif duruma getirmek için işareti kaldırıp
                                            güncelleyin)</small>
                                    </label>
                                </div>
                                @endif

                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="submit" class="btn btn-primary">Güncelle</button>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </form>
                    </div>
                    <!--end tab-pane-->
                    <div class="tab-pane" id="changePassword" role="tabpanel">
                        @livewire('user.password-change', ["user_id" => $id] )
                    </div>
                    <!--end tab-pane-->
                </div>
            </div>
        </div>
    </div>



    @if(Erp::izin('is_admin'))
    <div class="col-xxl-6">
        <div class="card ">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Kullanıcı Yetki Tanımları</h4>
            </div>
            <div class="card-body ">
                @livewire('user.izin-yonetimi', ['user_id' => $id ])
            </div>
        </div>
    </div>
    @endif

</div>
<!--end row-->
@endsection
@section('script')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection