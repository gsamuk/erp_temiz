<div>
    <div class="row">
        <div class="col-xl-5">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Kullanıcılar</h4>
                    <div class="flex-shrink-0">
                        <button class="btn btn-soft-primary waves-effect waves-light"> <i
                                class="ri-add-line fs-17 align-middle  "></i> Kullanıcı
                            Ekle</button>
                    </div>
                </div><!-- end card header -->

                <div class="card-body">

                    <div class="live-preview">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0 table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">ID</th>

                                        <th scope="col">Kullanıcı Adı</th>
                                        <th scope="col">Logo Kullanıcı Adı</th>
                                        <th scope="col">Ad Soyad</th>
                                        <th scope="col">Durum</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $d)
                                    <tr class="@if($user_id == $d->id) bg-soft-primary @endif">
                                        <td><a href="#" class="fw-medium">#{{ $d->id }}</a></td>

                                        <td>{{ $d->user_name }}</td>
                                        <td>{{ $d->logo_user }}</td>
                                        <td>
                                            <div class="d-flex gap-2 align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="assets/images/users/avatar-3.jpg" alt=""
                                                        class="avatar-xs rounded-circle">
                                                </div>
                                                <div class="flex-grow-1">
                                                    {{ $d->name }} {{ $d->surname }}
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
                                            <button wire:click="getUser({{ $d->id }})" class="btn btn-info btn-sm">
                                                <i class="ri-edit-2-line"></i> Düzenle </button>



                                            <button wire:click="getUser({{ $d->id }})" class="btn btn-danger btn-sm">
                                                <i class="ri-delete-bin-5-line"></i> </button>
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
        <div class="col-xl-7">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1"> {{ $user->name }} {{ $user->surname }}</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    {{ $user->name }}
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div><!-- end col -->
        @endif

    </div>
</div>