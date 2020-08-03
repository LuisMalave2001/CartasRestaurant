<form action="/menu" method="POST" id="menu-form">
    @csrf
    <div class="form-group">
        <label for="form-menu-name">Name</label>
        <input required="required" type="text" class="form-control form-menu-name" name="name" aria-describedby="help-menu-name"/>
        <small id="help-menu-name" class="form-text text-muted">Menu name</small>
    </div>
    <div class="form-group">
        <label for="form-menu-price">Price</label>
        <input required="required" step="0.01" type="number" name="price" class="form-control form-menu-price" aria-describedby="help-menu-price"/>
        <small id="help-menu-price" class="form-text text-muted">Menu price</small>
    </div>
</form>
