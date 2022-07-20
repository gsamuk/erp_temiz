<div>
  <div class="row">
    <div class="col-xl-3">
      <div class="card card-h-100">
        <div class="card-body">

          @if (Erp::izin('items_list'))
            <button class="btn btn-warning w-100 mt-2" wire:click="$emit('SetPage', 'malzemeler.liste')"><i
                 class="mdi mdi-format-list-checkbox"></i> Depo Malzeme Listesi</button>
          @endif

          @if (Erp::izin('items_create'))
            <button class="btn btn-success w-100 mt-2" wire:click="$emit('SetPage', 'malzemeler.ekle')"><i
                 class="mdi mdi-plus"></i> Malzeme Kontrol</button>
            <hr>
          @endif

          <button class="btn btn-success w-100 mt-2" wire:click="$emit('SetPage', 'malzemeler.talep-olustur')"><i
               class="mdi mdi-plus"></i> Malzeme Talebi Oluştur</button>

          @if (Erp::izin('items_demand'))
            <button class="btn btn-primary w-100 mt-2" wire:click="$emit('SetPage', 'malzemeler.talep-listesi')"><i
                 class="mdi mdi-format-list-checkbox"></i> Malzeme Talep Listesi</button>
          @endif

          <button class="btn btn-primary w-100 mt-2" wire:click="$emit('SetPage', 'malzemeler.taleplerim')"><i
               class="mdi mdi-format-list-checkbox"></i> Malzeme Taleplerim</button>

          @if (Erp::izin('items_demand_manage'))
            <hr>
            <button class="btn btn-info w-100 mt-2" wire:click="$emit('SetPage', 'malzemeler.talep-malzeme-onay')"><i
                 class="mdi mdi-archive-check"></i> Malzeme Onay</button>
          @endif

        </div>
      </div>

    </div>
  </div>
</div>
