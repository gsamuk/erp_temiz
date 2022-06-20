<div>

  <form wire:submit.prevent="store()">
    <div class="row">

      <div class="col-9">
        <select wire:model="firma" name="firma" class="form-select">

          <option value="">-- Seç --</option>
          <option value="1" wire:click="setName('ZEBERCED LTD.')">ZEBERCED LTD.</option>
          <option value="2" wire:click="setName('ZEBERCED CONS.LTD.(KATANPE)')">ZEBERCED CONS.LTD.(KATANPE)
          </option>
          <option value="3" wire:click="setName('ZEBERCED CONS.LTD.(OSB)')">ZEBERCED CONS.LTD.(OSB)</option>
          <option value="4" wire:click="setName('ZEBERCED LIMITED')">ZEBERCED LIMITED</option>
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
