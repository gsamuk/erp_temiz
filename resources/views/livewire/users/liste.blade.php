<div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 col-xl-5 col-lg-5">
      <div class="card">
        <div class="card-header align-items-center d-flex">
          <h4 class="card-title flex-grow-1 mb-0">Kullanıcılar</h4>
          <div class="flex-shrink-0">
            <button wire:click="createUserForm()" class="btn btn-soft-primary waves-effect waves-light">
              <i class="ri-add-line fs-17 align-middle"></i> Kullanıcı Ekle</button>
          </div>
        </div>

        <div class="card-body">

          <div class="live-preview">
            <div class="table-responsive">
              <table class="table-nowrap table-sm mb-0 table align-middle">
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
                    <tr class="@if ($user_id == $d->id) bg-soft-info @endif">
                      <td><a href="#" class="fw-medium">#{{ $d->id }}</a></td>

                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <div class="flex-shrink-0">
                            @if ($d->photo_path)
                              <img class="avatar-xs rounded-circle"
                                   src="{{ asset('files/images/users/' . $d->photo_path) }}">
                            @else
                              <img src="assets/images/users/avatar-3.jpg" alt=""
                                   class="avatar-xs rounded-circle">
                            @endif
                          </div>
                          <div class="flex-grow-1">
                            {{ $d->name }} {{ $d->surname }}<br>
                            <small> {{ $d->user_code }}</small>
                          </div>
                        </div>
                      </td>
                      <td>
                        @if ($d->is_active == 1)
                          <span class="text-success"> <i
                               class="ri-checkbox-circle-line fs-17 align-middle"></i> Aktif</span>
                        @else
                          <span class="text-danger"> <i
                               class="ri-close-circle-line text-danger align-middle"></i>
                            Pasif</span>
                        @endif

                      </td>
                      <td>
                        @if (isset($confirm_delete) && $confirm_delete == $d->id)
                          <button wire:click="deleteUser({{ $d->id }})" class="btn btn-danger btn-sm">
                            <i class="ri-delete-bin-5-line"></i> Evet Sil
                          </button>
                          <button wire:click="cancelDelete()" class="btn btn-light btn-sm">
                            <i class="ri-close-line"></i> Vazgeç </button>
                        @else
                          <button wire:click="updateUserForm({{ $d->id }})"
                                  class="btn btn-soft-primary btn-sm">
                            <i class="ri-edit-2-line"></i> Düzenle </button>

                          <button wire:click="permUserForm({{ $d->id }})"
                                  class="btn btn-soft-primary btn-sm">
                            <i class="ri-settings-3-line"></i> Yetkiler </button>

                          <button wire:click="confirmDelete({{ $d->id }})"
                                  class="btn btn-soft-danger btn-sm">
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


    @if ($update_page)
      <div class="col-xl-4">
        <div class="card">
          <div class="card-header align-items-center d-flex">
            <h4 class="card-title flex-grow-1 mb-0"> <i class="ri-edit-2-line"></i> {{ $user->name }}
              {{ $user->surname }} <small> > Düzenle</small></h4>
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
                  @error('name')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>

                <div class="col-xxl-6">
                  <label for="surname" class="col-form-label">Soyad</label>
                  <input type="text" placeholder="Soyad Giriniz" class="form-control" wire:model="surname"
                         x-data x-init="@this.set('surname', '{{ $user->surname }}')" id="surname">
                  @error('surname')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>

                <div class="col-xxl-6">
                  <label for="user_name" class="col-form-label"><b>Kullanıcı Adı</b></label>
                  <input type="text" placeholder="Kullanıcı Adı Giriniz" wire:model="user_name" x-data
                         x-init="@this.set('user_name', '{{ $user->user_name }}')" class="form-control"
                         id="user_name">
                  @error('user_name')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>

                <div class="col-xxl-6">
                  <label for="email" class="col-form-label">Email</label>
                  <div class="form-icon">
                    <input type="text" placeholder="Email Adresi Giriniz"
                           class="form-control form-control-icon" wire:model="email" x-data
                           x-init="@this.set('email', '{{ $user->email }}')" id="email">
                    @error('email')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <i class="ri-mail-unread-line"></i>
                  </div>
                </div>

                <div class="col-xxl-12">
                  <label for="user_code" class="col-form-label">Çalıştığı Birim</label>
                  <select wire:model="user_code" x-data
                          x-init="@this.set('user_code', '{{ $user->user_code }}')" id="user_code" class="form-select form-select-sm"
                          aria-label=".form-select-sm">
                    <option selected>-- Seçiniz --</option>
                    <option>Kubwa / Kademe</option>
                    <option>Kubwa / Tesis</option>
                    <option>Kubwa / Oto Elektrik</option>
                    <option>Kubwa / Yağ Bakım</option>
                    <option>Kubwa / Kaynakhane</option>
                    <option>Kubwa / Elektrik</option>
                    <option>Kubwa / Merkez Depo</option>
                    <option>Jiwa / OSB</option>
                    <option>Katanpe / Beton</option>
                    <option>Katanpe / İnşaat</option>
                    <option>Katanpe / Depo</option>
                    <option>Kaduna / Depo</option>
                    <option>Kaduna</option>
                    <option>Kontagora</option>
                    <option>Üst Yönetim</option>
                    <option>Merkez Muhasebe</option>
                    <option>Bilişim</option>
                  </select>
                </div>

                <div class="col-xxl-12">
                  <label for="password" class="col-form-label"><b>Şifre</b></label>
                  <input type="text" placeholder="Şifre Giriniz" wire:model="password" x-data
                         x-init="@this.set('password', '{{ $user->password }}')" class="form-control">
                  @error('password')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
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

                <div class="col-xxl-6">
                  <!-- Base Radios -->
                  <div class="form-check mb-2">
                    <input class="form-check-input" wire:model="is_active" value="1" type="radio"
                           name="is_active"
                           id="passive">
                    <label class="form-check-label" for="passive">
                      Aktif (Erişimi Var)
                    </label>
                  </div>

                  <div class="form-check">
                    <input class="form-check-input" wire:model="is_active" value="0" type="radio"
                           name="is_active"
                           id="active"
                           checked>
                    <label class="form-check-label" for="active">
                      Pasif (Erişimi Yok)
                    </label>
                  </div>
                </div>

                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
              </div>
            </form>
          </div><!-- end card-body -->
        </div><!-- end card -->
      </div>
      <div class="col-xl-3">
        <div class="card">
          <div class="card-body">

            @if ($user->photo_path)
              <img class="img-thumbnail rounded-circle avatar-xl" alt="200x200"
                   src="{{ asset('files/images/users/' . $user->photo_path) }}">
              <button wire:click="remove_photo()" class="btn btn-sm btn-light">Kaldır</button>
              <hr class="bg-danger border-top border-danger border-2">
            @endif

            <form wire:submit.prevent="foto_save">
              @csrf
              <label for="file" class="btn btn-info btn-label rounded-pill">
                <i class="ri-image-fill label-icon rounded-pill fs-16 me-2 align-middle"></i>
                Fotoğraf Yükle / Değiştir</label>
              <input type="file" id="file" style="display:none;" wire:model="photo">
              <div wire:loading wire:target="photo">
                <div class="spinner-grow text-dark" role="status">
                  <span class="sr-only">Yükleniyor...</span>
                </div>
              </div>
              @if ($photo)
                <div class="m-2">
                  <img src="{{ $photo->temporaryUrl() }}" class="img-thumbnail" style="width:200px">
                </div>
              @endif

              @error('photo')
                <span class="badge bg-danger">{{ $message }}</span>
              @enderror

              @if (session()->has('success'))
                <div class="alert alert-secondary alert-dismissible alert-label-icon rounded-label fade show"
                     role="alert">
                  <i class="ri-check-double-line label-icon"></i>
                  {{ session('success') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert"
                          aria-label="Close"></button>
                </div>
              @endif


              @if ($photo)
                <div class="m-2">
                  <br>
                  <button wire:loading.attr="disabled" class="btn btn-success shadowed mr-1 mb-1"
                          type="submit">Kaydet</button>
                </div>
              @endif

            </form>
          </div>
        </div>
      </div>

    @endif

    @if ($create_page)
      <div class="col-xl-7">
        <div class="card">
          <div class="card-header align-items-center d-flex">
            <h4 class="card-title flex-grow-1 mb-0"> <i class="ri-add-line fs-17 align-middle"></i> Kullanıcı
              Ekle</h4>
          </div>
          <div class="card-body">
            <form wire:submit.prevent="create()">
              <div class="row g-3">
                <div class="col-xxl-6">
                  <label for="name" class="col-form-label">İsim</label>
                  <input type="text" placeholder="Ad Giriniz" wire:model="name" class="form-control"
                         id="name">
                  @error('name')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>

                <div class="col-xxl-6">
                  <label for="surname" class="col-form-label">Soyad</label>
                  <input type="text" placeholder="Soyad Giriniz" class="form-control" wire:model="surname"
                         id="surname">
                  @error('surname')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>

                <div class="col-xxl-6">
                  <label for="user_name" class="col-form-label"><b>Kullanıcı Adı</b></label>
                  <input type="text" placeholder="Kullanıcı Adı Giriniz" wire:model="user_name"
                         class="form-control" id="user_name">
                  @error('user_name')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>

                <div class="col-xxl-6">
                  <label for="email" class="col-form-label">Email</label>
                  <div class="form-icon">
                    <input type="text" placeholder="Email Adresi Giriniz"
                           class="form-control form-control-icon" wire:model="email" id="email">
                    @error('email')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <i class="ri-mail-unread-line"></i>
                  </div>
                </div>

                <div class="col-xxl-12">
                  <label for="password" class="col-form-label"><b>Şifre</b></label>
                  <input type="text" placeholder="Şifre Giriniz" wire:model="password"
                         class="form-control">
                  @error('password')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
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

    @if ($perms_page)
      <div class="col-xl-7">
        @livewire('users.izin-yonetimi', ['user' => $user])
      </div>
    @endif

  </div>
</div>
