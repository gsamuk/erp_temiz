<div>

    @if($page == 'malzemeler.liste')
    @livewire('malzemeler.liste', ['ch' => false])

    @elseif($page == 'malzemeler.talep-listesi')
    @livewire('malzemeler.talep-listesi')

    @elseif($page == 'malzemeler.talep-olustur')
    @livewire('malzemeler.talep-olustur')

    @elseif($page == 'malzemeler.fotograf')
    @livewire('malzemeler.fotograf')

    @elseif($page == 'malzemeler.taleplerim')
    @livewire('malzemeler.taleplerim')

    @elseif($page == 'satinalma.siparis-olustur')
    @livewire('satinalma.siparis-olustur')

    @elseif($page == 'satinalma.siparis')
    @livewire('satinalma.siparis')





    @else
    DashBoard
    @endif

    <div wire:loading>
        Processing Payment...
    </div>
    {{ $page }}
</div>