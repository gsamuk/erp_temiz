<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header border-2">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Kullanıcılar</h5>
                        <!-- Varying Modal Content -->
                        <div class="hstack gap-2 flex-wrap">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addUser" data-bs-whatever="@mdo">Kullanıcı Ekle</button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-nowrap align-middle mb-0">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Ad Soyad</th>
                                    <th scope="col">Kulanıcı Adı</th>
                                    <th scope="col">Şifre</th>
                                    <th scope="col">Logo Kulanıcı</th>
                                    <th scope="col">Logo Şifre</th>
                                    <th scope="col">Yönetici</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->id }}</th>
                                    <td><a href="{{ route('user',$user->id) }}"><b>{{ $user->name }} {{ $user->surname
                                                }}</b></a> </td>
                                    <td>{{ $user->user_name }}</td>
                                    <td>{{ $user->password }}</td>
                                    <td>{{ $user->logo_user }}</td>
                                    <td>{{ $user->logo_password }}</td>
                                    <td>
                                        @if ($user->is_admin == 1)
                                        <i class="ri-checkbox-circle-line align-middle text-success"></i>
                                        @else
                                        <i class="ri-close-circle-fill  align-middle text-danger"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="hstack gap-3 fs-15">
                                            <a href="{{ route('user',$user->id) }}" class="link-primary"><i
                                                    class="ri-settings-4-line"></i></a>

                                            @if( Session::get('userData')->id != $user->id)

                                            @if($confirming===$user->id)
                                            <button wire:click="remove({{ $user->id }})"
                                                class="btn btn-soft-dark btn-sm ">Emin
                                                misin?</button>
                                            @else
                                            <button wire:click="confirmDelete({{ $user->id }})"
                                                class="btn btn-soft-danger btn-sm ">Sil</button>
                                            @endif


                                            @else
                                            <small>You</small>
                                            @endif

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

    <!-- Varying modal content -->
    <div wire:ignore.self class="modal fade" id="addUser" tabindex="-1" aria-labelledby="addUser" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-soft-info p-3">
                    <h5 class="modal-title" id="exampleModalLabel">Yeni Kullanıcı Ekle </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="store()">
                        <div class="row g-3">
                            <div class="col-xxl-6">
                                <label for="name" class="col-form-label">İsim</label>
                                <input type="text" placeholder="Ad Giriniz" class="form-control" wire:model.defer="name"
                                    id="name">
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>

                            <div class="col-xxl-6">
                                <label for="surname" class="col-form-label">Soyad</label>
                                <input type="text" placeholder="Soyad Giriniz" class="form-control" wire:model="surname"
                                    id="surname">
                                @error('surname') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-xxl-6">
                                <label for="user_name" class="col-form-label"><b>Kullanıcı Adı</b></label>
                                <input type="text" placeholder="Kullanıcı Adı Giriniz" class="form-control"
                                    wire:model="user_name" id="user_name">
                                @error('user_name') <span class="text-danger">{{ $message }}<br></span> @enderror
                                <small class="form-text text-muted">Sisteme Girişte Kullanılır </small>
                            </div>

                            <div class="col-xxl-6">
                                <label for="email" class="col-form-label">Email {{ $email }}</label>
                                <div class="form-icon">
                                    <input type="text" placeholder="Email Adresi Giriniz"
                                        class="form-control form-control-icon" wire:model="email" id="email">
                                    <i class="ri-mail-unread-line"></i>
                                </div>
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-xxl-12">
                                <label for="password" class="col-form-label"><b>Şifre</b></label>
                                <input type="password" placeholder="Şifre Giriniz" class="form-control"
                                    wire:model.defer="password" id="password">
                                @error('password') <span class="text-danger">{{ $message }} <br></span> @enderror
                                <small class="form-text text-muted">Sisteme Girişte Kullanılır </small>
                            </div>


                            <div class="col-xxl-6">
                                <label for="logo_user" class="col-form-label">Logo Kullanıcı Adı</label>
                                <input type="text" placeholder="Logo kullanıcı adını giriniz"
                                    class="form-control form-control-icon" wire:model.defer="logo_user" id="logo_user">
                                @error('logo_user') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-xxl-6">
                                <label for="logo_password" class="col-form-label">Logo Giriş Şifresi</label>
                                <input type="text" placeholder="Logo giriş şifresini giriniz"
                                    class="form-control form-control-icon" wire:model.defer="logo_password"
                                    id="logo_password">
                                @error('logo_password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Kapat</button>
                                <button type="submit" class="btn btn-primary">Kaydet</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</div>