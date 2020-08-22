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
                <label for="form-menu-name">Name</label>
                <input required="required" type="text" class="form-control form-menu-name" name="name" aria-describedby="help-menu-name"/>
                <small id="help-menu-name" class="form-text text-muted">Menu name</small>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-12">
                <label for="form-menu-price">Price</label>
                <input required="required" step="0.01" type="number" name="price" class="form-control form-menu-price" aria-describedby="help-menu-price"/>
                <small id="help-menu-price" class="form-text text-muted">Menu price</small>
            </div>
        </div>
    </div>

</form>
