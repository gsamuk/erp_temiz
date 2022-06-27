<div>
  @if ($success)
    @foreach ($success as $s)
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Başarılı</strong> <b>{{ $s }}</b>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endforeach
  @endif

  @if ($error)
    @foreach ($error as $e)
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Hata!</strong> <b>{{ $e }}</b>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endforeach
  @endif

</div>
