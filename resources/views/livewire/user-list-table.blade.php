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
                        <table class="table table-striped table-nowrap align-middle mb-0">
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
                <div class="modal-body">
                    <form wire:submit.prevent="store()">
                        <div class="mb-3">
                            <label for="name" class="col-form-label">Ad:</label>
                            <input type="text" class="form-control" wire:model.defer="name" id="name">
                        </div>

                        <div class="mb-3">
                            <label for="surname" class="col-form-label">Soyad:</label>
                            <input type="text" class="form-control" wire:model.defer="surname" id="surname">
                        </div>

                        <div class="mb-3">
                            <label for="user_name" class="col-form-label">Kullanıcı Adı:</label>
                            <input type="text" class="form-control" wire:model.defer="user_name" id="user_name">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="col-form-label">Email:</label>
                            <input type="text" class="form-control" wire:model.defer="email" id="email">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="col-form-label">Şifre:</label>
                            <input type="password" class="form-control" wire:model.defer="password" id="password">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Send message</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</div>