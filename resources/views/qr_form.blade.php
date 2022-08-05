<form action="/qr" method="POST">

  <div class="mb-3">
    {{ csrf_field() }}
    <label for="VertimeassageInput" class="form-label">Stok Kodları</label>
    <textarea class="form-control" name="kods" id="kods" rows="10" placeholder="Stok Kodlarını Alt Alta Yazın"></textarea>
  </div>
  <div class="text-end">
    <button type="submit" class="btn btn-primary">PDF Oluştur</button>
  </div>
</form>
