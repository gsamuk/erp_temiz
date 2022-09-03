<div>

  @if ($page == 'malzemeler.liste')
    @livewire('malzemeler.liste', ['ch' => false])
  @elseif($page == 'malzemeler.talep-listesi')
    @livewire('malzemeler.talep-listesi')
  @elseif($page == 'malzemeler.talep-malzeme-onay')
    @livewire('malzemeler.talep-malzeme-onay')
  @elseif($page == 'malzemeler.talep-olustur')
    @livewire('malzemeler.talep-olustur', ['edit_id' => $edit_id])
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
  @elseif($page == 'kantar.file-upload')
    @livewire('kantar.file-upload')
  @elseif($page == 'kantar.cariler')
    @livewire('kantar.cariler')
  @elseif($page == 'kantar.rapor')
    @livewire('kantar.rapor')
  @elseif($page == 'kantar.canli')
    @livewire('kantar.canli')
  @else
    @livewire('main')
  @endif

  <div wire:loading>
    <div class="spinner-border text-secondary" role="status">
      <span class="sr-only">Yükleniyor...</span>
    </div>
  </div>

  @push('scripts')
    <script>
      window.livewire.on('kantar.rapor', message => {
        $(".tarih").datepicker();
        $(".tarih").datepicker("option", "dateFormat", "yy-mm-dd").datepicker("setDate", new Date());
      });
    </script>
  @endpush
</div
