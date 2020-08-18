<form action="/carte-menu" method="POST" id="carte-menu-form">
    @csrf
    <div class="form-group">
        <label for="form-carte-menu-name">Name</label>
        <input required="required" type="text" class="form-control form-carte-menu-name" name="name" aria-describedby="help-carte-menu-name"/>
        <small id="help-carte-menu-name" class="form-text text-muted">Á la carte menu name</small>
    </div>
</form>
