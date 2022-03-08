<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3">

                @if(Session::get('LogoLogin'))
                <span class="text-success"> <i class="mdi mdi-check"></i> Logo Bağlantısı Yapıldı</span>
                @else

                <span class="text-danger"> <i class="mdi mdi-connection"></i> Logo Bağlantısı
                    Yapılamadı</span>
                @endif

            </div>
            <div class="col-sm-9">
                <div class="text-sm-end d-none d-sm-block">
                    Zeberced ERP
                </div>
            </div>
        </div>
    </div>
</footer>