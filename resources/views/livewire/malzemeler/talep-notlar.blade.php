<div>
  <div class="card">
    <!--end card-body-->
    <div class="card-body p-3">
      <h5 class="card-title mb-4">Talep Notları</h5>

      @foreach ($data as $d)
        @php
          $user = Erp::user($d->users_id);
        @endphp
        <div class="d-flex border-bottom mt-2">
          <div class="flex-shrink-0">
            <img src="assets/images/users/avatar-8.jpg" alt="" class="avatar-xs rounded-circle" />
          </div>
          <div class="flex-grow-1 ms-3">
            <h5 class="fs-13">{{ $user->name }} {{ $user->surname }} <small class="text-muted"> >
                {{ \Carbon\Carbon::createFromTimeStamp(strtotime($d->insert_time))->diffForHumans() }}
                @if (Erp::user_id() == $d->users_id)
                  <a href="javascript:void(0);" wire:click="delete_not({{ $d->id }})"
                     class="link-danger fs-15"><i class="ri-delete-bin-line"></i></a>
                @endif
              </small>
            </h5>
            <p class="text-muted">{{ $d->note }}</p>
          </div>
        </div>
      @endforeach

      <form action="javascript:void(0);" class="mt-3">
        <div class="row g-3">
          <div class="col-lg-12">

            <textarea wire:model="notes" class="form-control bg-light border-light" rows="2" placeholder="Not Giriniz"></textarea>
          </div>
          <div class="col-lg-12 text-end">
            <a href="javascript:void(0);" wire:click="save_note()" class="btn btn-success">Not Ekle</a>
          </div>
        </div>
      </form>
    </div>
    <!-- end card body -->
  </div>
  <!--end card-->
</div>
