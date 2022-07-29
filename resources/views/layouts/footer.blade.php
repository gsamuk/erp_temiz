<div id="firma_secModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
     style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalgridLabel">Çalışma Firması Seç</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @livewire('user.firma-sec')
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<footer class="footer p-1" style="height: 30px;">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-3">
        @if (Session::get('secili_firma_adi'))
          <span class="text-success">
            {{ Session::get('secili_firma_adi') }} |
            Firma No : {{ Session::get('secili_firma') }}
          </span>
        @endif

      </div>
      <div class="col-sm-9">
        <div class="text-sm-end d-none d-sm-block">
          Zeberced Online ERP v.2.0.1
        </div>
      </div>
    </div>
  </div>
</footer>
