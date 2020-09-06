<form action="/menu" method="POST" id="menu-form" enctype="multipart/form-data">
    @csrf

    <div class="container">

        <div class="row">
            <div class="col">
                <img class="js_menu_image w-100" onerror="this.src='{{ asset('storage/images/food_default.png') }}'" data-error-image="{{asset('storage/images/food_default.png')}}" />
                <input type="file" name="menu_image" class="js_menu_image_input"/>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label for="form-menu-name">Nombre</label>
                <input required="required" type="text" class="form-control form-menu-name" name="name" aria-describedby="help-menu-name"/>
                <small id="help-menu-name" class="form-text text-muted">Nombre del menu</small>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-12">
                <label for="form-menu-price">Precio</label>
                <input required="required" step="0.01" type="number" name="price" class="form-control form-menu-price" aria-describedby="help-menu-price"/>
                <small id="help-menu-price" class="form-text text-muted">Precio del menu</small>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label for="form-menu-description">Descripción</label>
                <textarea type="text" class="form-control form-menu-description" id="form-menu-description" name="description" aria-describedby="description"></textarea>
                <small id="help-menu-description" class="form-text text-muted">Descripción</small>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label for="form-menu-category">Categoria</label>
                <select type="text" class="form-control form-menu-category" id="form-menu-category" name="category_id" aria-describedby="category">
                        <option value="" class="default" selected="selected" disabled="disabled">- Categorias -</option>
                @foreach(auth()->user()->getSessionCurrentEstablishment()->getCategories() as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <small id="help-menu-category" class="form-text text-muted">Categoria</small>
            </div>
        </div>
    </div>

</form>
