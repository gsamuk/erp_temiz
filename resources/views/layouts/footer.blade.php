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


<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3">
                @if(Cookie::get('secili_firma_adi'))
                <span class="text-success"> {{ Cookie::get('secili_firma_adi') }} | Firma No : {{
                    Cookie::get('secili_firma') }}</span>
                @endif

            </div>
            <div class="col-sm-9">
                <div class="text-sm-end d-none d-sm-block">
                    Zeberced ERP {{ Route::currentRouteName()}}
                </div>
            </div>
        </div>
    </div>
</footer>