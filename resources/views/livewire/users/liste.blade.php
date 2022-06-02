<div>
    <div class="row">
        <div class="col-xl-4 col-md-6 col-sm-6">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Kullanıcılar</h4>
                    <div class="flex-shrink-0">
                        <button wire:click="createUserForm()" class="btn btn-soft-primary waves-effect waves-light">
                            <i class="ri-add-line fs-17 align-middle  "></i> Kullanıcı Ekle</button>
                    </div>
                </div>

                <div class="card-body">

                    <div class="live-preview">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0 table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Ad Soyad</th>
                                        <th scope="col">Durum</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $d)
                                    <tr class="@if($user_id == $d->id) bg-soft-primary @endif">
                                        <td><a href="#" class="fw-medium">#{{ $d->id }}</a></td>

                                        <td>
                                            <div class="d-flex gap-2 align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="assets/images/users/avatar-3.jpg" alt=""
                                                        class="avatar-xs rounded-circle">
                                                </div>
                                                <div class="flex-grow-1">
                                                    {{ $d->name }} {{ $d->surname }}<br>
                                                    <small> {{ $d->user_name }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($d->is_active == 1)
                                            <span class="text-success"> <i
                                                    class="ri-checkbox-circle-line fs-17 align-middle"></i> Aktif</span>
                                            @else
                                            <span class="text-danger"> <i
                                                    class="ri-close-circle-line align-middle text-danger"></i>
                                                Pasif</span>
                                            @endif

                                        </td>
                                        <td>
                                            @if(isset($confirm_delete) && $confirm_delete == $d->id )
                                            <button wire:click="deleteUser({{ $d->id }})" class="btn btn-danger btn-sm">
                                                <i class="ri-delete-bin-5-line"></i> Evet Sil
                                            </button>
                                            <button wire:click="cancelDelete()" class="btn  btn-light btn-sm">
                                                <i class="ri-close-line"></i> Vazgeç </button>

                                            @else
                                            <button wire:click="updateUserForm({{ $d->id }})"
                                                class="btn btn-info btn-sm">
                                                <i class="ri-edit-2-line"></i> Düzenle </button>
                                            <button wire:click="confirmDelete({{ $d->id }})"
                                                class="btn btn-light btn-sm">
                                                <i class="ri-delete-bin-5-line"></i> Sil </button>
                                            @endif

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>


                            <!-- end table -->
                        </div>
                        <!-- end table responsive -->
                    </div>

                </div><!-- end card-body -->
            </div><!-- end card -->
        </div><!-- end col -->


        @if($user)
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1"> <i class="ri-edit-2-line"></i> {{ $user->name }} {{
                        $user->surname }} <small> > Düzenle</small></h4>
                </div>
                <div class="card-body">
                    @if (session()->has('store_message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('store_message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <form wire:submit.prevent="store()">
                        <div class="row g-3">
                            <div class="col-xxl-6">
                                <label for="name" class="col-form-label">İsim</label>
                                <input type="text" placeholder="Ad Giriniz" wire:model="name" class="form-control"
                                    x-data x-init="@this.set('name', '{{ $user->name }}')" id="name">
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-xxl-6">
                                <label for="surname" class="col-form-label">Soyad</label>
                                <input type="text" placeholder="Soyad Giriniz" class="form-control" wire:model="surname"
                                    x-data x-init="@this.set('surname', '{{ $user->surname }}')" id="surname">
                                @error('surname') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-xxl-6">
                                <label for="user_name" class="col-form-label"><b>Kullanıcı Adı</b></label>
                                <input type="text" placeholder="Kullanıcı Adı Giriniz" wire:model="user_name" x-data
                                    x-init="@this.set('user_name', '{{ $user->user_name }}')" class="form-control"
                                    id="user_name">
                                @error('user_name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-xxl-6">
                                <label for="email" class="col-form-label">Email</label>
                                <div class="form-icon">
                                    <input type="text" placeholder="Email Adresi Giriniz"
                                        class="form-control form-control-icon" wire:model="email" x-data
                                        x-init="@this.set('email', '{{ $user->email }}')" id="email">
                                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                    <i class="ri-mail-unread-line"></i>
                                </div>
                            </div>

                            <div class="col-xxl-12">
                                <label for="password" class="col-form-label"><b>Şifre</b></label>
                                <input type="text" placeholder="Şifre Giriniz" wire:model="password" x-data
                                    x-init="@this.set('password', '{{ $user->password }}')" class="form-control">
                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                                <small class="form-text text-muted">Sisteme Girişte Kullanılır </small>
                            </div>


                            <div class="col-xxl-6">
                                <label for="logo_user" class="col-form-label">Logo Kullanıcı Adı</label>
                                <input type="text" placeholder="Logo kullanıcı adını giriniz"
                                    class="form-control form-control-icon" wire:model="logo_user" x-data
                                    x-init="@this.set('logo_user', '{{ $user->logo_user }}')" id="logo_user">
                            </div>

                            <div class="col-xxl-6">
                                <label for="logo_password" class="col-form-label">Logo Giriş Şifresi</label>
                                <input type="text" placeholder="Logo giriş şifresini giriniz"
                                    class="form-control form-control-icon" wire:model="logo_password" x-data
                                    x-init="@this.set('logo_password', '{{ $user->logo_password }}')"
                                    id="logo_password">
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Kaydet</button>
                            </div>
                        </div>
                    </form>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1"> {{ $user->name }} {{ $user->surname }}
                        <small> > İzinler</small>
                    </h4>
                </div>
                <div class="card-body">
                    @livewire('users.izin-yonetimi')
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
        @endif

        @if($create)
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1"> <i class="ri-add-line fs-17 align-middle  "></i> Kullanıcı
                        Ekle</h4>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="create()">
                        <div class="row g-3">
                            <div class="col-xxl-6">
                                <label for="name" class="col-form-label">İsim</label>
                                <input type="text" placeholder="Ad Giriniz" wire:model="name" class="form-control"
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
                                <input type="text" placeholder="Kullanıcı Adı Giriniz" wire:model="user_name"
                                    class="form-control" id="user_name">
                                @error('user_name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-xxl-6">
                                <label for="email" class="col-form-label">Email</label>
                                <div class="form-icon">
                                    <input type="text" placeholder="Email Adresi Giriniz"
                                        class="form-control form-control-icon" wire:model="email" id="email">
                                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                    <i class="ri-mail-unread-line"></i>
                                </div>
                            </div>

                            <div class="col-xxl-12">
                                <label for="password" class="col-form-label"><b>Şifre</b></label>
                                <input type="text" placeholder="Şifre Giriniz" wire:model="password"
                                    class="form-control">
                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                                <small class="form-text text-muted">Sisteme Girişte Kullanılır </small>
                            </div>


                            <div class="col-xxl-6">
                                <label for="logo_user" class="col-form-label">Logo Kullanıcı Adı</label>
                                <input type="text" placeholder="Logo kullanıcı adını giriniz"
                                    class="form-control form-control-icon" wire:model="logo_user" id="logo_user">
                            </div>

                            <div class="col-xxl-6">
                                <label for="logo_password" class="col-form-label">Logo Giriş Şifresi</label>
                                <input type="text" placeholder="Logo giriş şifresini giriniz"
                                    class="form-control form-control-icon" wire:model="logo_password"
                                    id="logo_password">
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Kullanıcı Ekle</button>
                            </div>
                        </div>
                    </form>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
        @endif
    </div>
</div>