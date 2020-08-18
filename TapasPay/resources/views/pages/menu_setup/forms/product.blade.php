<form action="/product" method="POST" id="product-form" enctype="multipart/form-data">
    @csrf
    <div class="container">

        <div class="row">
            <div class="col">
                <img class="js_product_image w-100" onerror="this.src='{{ asset('storage/images/food_default.png') }}'" />
                <input type="file" name="product_image" class="js_product_image_input"/>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label for="form-product-name">Name</label>
                <input required="required" type="text" class="form-control form-product-name" name="name"
                       aria-describedby="help-product-name"/>
                <small id="help-product-name" class="form-text text-muted">Product name</small>
            </div>
            <div class="form-group col-12">
                <label for="form-product-price">Price</label>
                <input required="required" step="0.01" type="number" name="price"
                       class="form-control form-product-price"
                       aria-describedby="help-product-price"/>
                <small id="help-product-price" class="form-text text-muted">Product price</small>
            </div>
        </div>
    </div>
</form>
