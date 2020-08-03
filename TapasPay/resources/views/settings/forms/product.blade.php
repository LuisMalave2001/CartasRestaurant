<form action="/product" method="POST" id="product-form">
    @csrf
    <div class="form-group">
        <label for="form-product-name">Name</label>
        <input required="required" type="text" class="form-control form-product-name" name="name" aria-describedby="help-product-name"/>
        <small id="help-product-name" class="form-text text-muted">Product name</small>
    </div>
    <div class="form-group">
        <label for="form-product-price">Price</label>
        <input required="required" step="0.01" type="number" name="price" class="form-control form-product-price" aria-describedby="help-product-price"/>
        <small id="help-product-price" class="form-text text-muted">Product price</small>
    </div>
</form>
