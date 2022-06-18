<div>

  @if ($page == 'malzemeler.liste')
    @livewire('malzemeler.liste', ['ch' => false])
  @elseif($page == 'malzemeler.talep-listesi')
    @livewire('malzemeler.talep-listesi')
  @elseif($page == 'malzemeler.talep-olustur')
    @livewire('malzemeler.talep-olustur')
  @elseif($page == 'malzemeler.fotograf')
    @livewire('malzemeler.fotograf')
  @elseif($page == 'malzemeler.taleplerim')
    @livewire('malzemeler.taleplerim')
  @elseif($page == 'malzemeler.ekle')
    @livewire('malzemeler.ekle')
  @elseif($page == 'satinalma.siparis-olustur')
    @livewire('satinalma.siparis-olustur')
  @elseif($page == 'satinalma.siparis')
    @livewire('satinalma.siparis')
  @elseif($page == 'users.liste')
    @livewire('users.liste')
  @else
    @livewire('main')
  @endif

  <div wire:loading>
    <div class="spinner-border text-secondary" role="status">
      <span class="sr-only">Yükleniyor...</span>
    </div>
  </div>

</div>
