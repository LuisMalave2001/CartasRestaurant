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
                <label for="form-product-name">Nombre</label>
                <input required="required" type="text" class="form-control form-product-name" name="name"
                       aria-describedby="help-product-name"/>
                <small id="help-product-name" class="form-text text-muted">Nombre del producto</small>
            </div>
            <div class="form-group col-12">
                <label for="form-product-price">Precio</label>
                <input required="required" step="0.01" type="number" name="price"
                       class="form-control form-product-price"
                       aria-describedby="help-product-price"/>
                <small id="help-product-price" class="form-text text-muted">Precio del producto</small>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label for="form-product-description">Descripción</label>
                <textarea type="text" class="form-control form-product-description" id="form-product-description" name="description" aria-describedby="description"></textarea>
                <small id="help-products-description" class="form-text text-muted">Descripción</small>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label for="form-product-category">Categoria</label>
                <select type="text" class="form-control form-product-category" id="form-product-category" name="category_id" aria-describedby="category">
                    <option value="" class="default" selected="selected" disabled="disabled">- Categorias -</option>
                @foreach(auth()->user()->getSessionCurrentEstablishment()->getCategories() as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <small id="help-product-category" class="form-text text-muted">Categoria</small>
            </div>
        </div>
    </div>
</form>
