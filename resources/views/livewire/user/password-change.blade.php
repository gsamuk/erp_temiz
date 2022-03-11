<div>
    @if (session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show shadow">
        {{ session('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <form wire:submit.prevent="store()">
        @csrf
        <input type="hidden" value="{{ $user_id }}" name="user_id">
        <div class="row g-2">
            <!--end col-->
            <div class="col-lg-4">
                <div>
                    <label for="newpasswordInput" class="form-label">Şifre * </label>
                    <input type="password" class="form-control" name="password" wire:model.defer="password">
                </div>
            </div>
            <!--end col-->
            <div class="col-lg-4">
                <div>
                    <label for="confirmpasswordInput" class="form-label">Şifre Tekrar *</label>
                    <input type="password" class="form-control" name="password_confirm"
                        wire:model.defer="password_confirm">
                </div>
            </div>
            <!--end col-->

            <!--end col-->
            <div class="col-lg-12">
                <div class="text-start">
                    <button type="submit" class="btn btn-success">Değiştir</button>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </form>
</div>