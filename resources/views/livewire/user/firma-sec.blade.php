<div>

  <form wire:submit.prevent="store()">
    <div class="row">

      <div class="col-9">
        <select wire:model="firma" name="firma" class="form-select">

          <option value="">-- Seç --</option>
          <option value="1" wire:click="setName('ZEBERCED LTD.')">ZEBERCED LTD.</option>
        </select>
      </div>
      <div class="col-3">
        @if ($btn)
          <button type="submit" class="btn btn-primary">Seç</button>
        @endif
      </div>

    </div>
  </form>
  @if (session()->has('message'))
    <br><span class="text-success">
      {{ session('message') }}
    </span>
  @endif

  @if (session()->has('error'))
    <br><span class="text-danger">
      {{ session('error') }}
    </span>
  @endif

  <div wire:loading>
    <br> <span class="text-primary">
      Bekleyiniz....
    </span>
  </div>
</div>
