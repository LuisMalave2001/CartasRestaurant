var globalSortableSettings = {
    handle: ".handle",
    animation: 150,
    // draggable: ".kanban-card",
    dataIdAttr: 'data-id',
    scrollSensitivity: 100,
    forceFallback: true,
    ghostClass: 'dragged-ghost'
};

$(document).ready(function(){
    "use strinct";



    setUpModalForm();

    let generalSettings = {
        // "handle": ".handle",
        "animation": 150,
        "draggable": ".draggable-testing",
        "dataIdAttr": 'data-id',
        "scrollSensitivity": 100,
        forceFallback: true,
    }

    $("table tbody").each((index, draggable) => {
        let sortable = Sortable.create(draggable, {
            "group": {
                "name": "cartas",
                "pull": false,
            },
            ...generalSettings
        });
    });

    setUpProductTableEvents();
    setUpMenuTableEvents();
    setUpCarteMenuTableEvents();
});

function setUpModalForm(){
    let $formModal = $('#create-or-edit-modal');
    let $sumbitButton = $formModal.find('.modal-submit-button');
    $sumbitButton.on('click', (event) => {
        $form = $formModal.find('.modal-form form');
        if ($form.find("button.btn-submit").length > 0) {
            $form.find("button.btn-submit").click();
        } else {
            $form.submit();
        }
    });
}

function _setModalMode(buttonText){
    let $createModal = $('#create-or-edit-modal');
    let $sumbitButton = $createModal.find('.modal-submit-button');
    $sumbitButton.text(buttonText);
}

function setModalFormCreateMode() {
    _setModalMode("Create");
}

function setModalFormEditMode() {
    _setModalMode("Save");
}

function _showModal(args) {

    if (args.constructor != Object){
        throw "You need to pass an argument";
    }

    if (!args.modal) {
        throw "You need to pass an modal object";
    }

    if (args.onShow) {
        args.onShow();
    }

    args.title = args.title || '';
    $(args.modal).find('.modal-title').text(args.title);

    $(args.modal).modal();
}

function _appendFormToModal(modal, formElement){
    // We do this to avoid complex validations scripts

    let submitButton = document.createElement("button");
    submitButton.type = "submit";
    submitButton.classList.add("btn-submit")
    $(submitButton).hide();

    formElement.appendChild(submitButton);

    $(formElement).on("submit", (event) => {
        $('#loader').show();
    });

    $(modal).find('.modal-form').html(formElement);
}

function changeFormMethod(params) {

    if (params.constructor != Object){
        throw "Parameter needs to be a object!";
    }

    if (!params.form || !params.method){
        throw "Form and Method should be passed in the object!";
    }

    let methodInput = document.createElement("input");
    methodInput.type = "hidden";
    methodInput.name = "_method";
    methodInput.value = params.method;

    params.form.appendChild(methodInput);
}

function setUpProductTableEvents(){

    $('#products tbody').sortable({
        group: {
            name: "products",
            pull: "clone",
            put: false,
        },
        sort: false,
        onMove: function (/**Event*/evt, /**Event*/originalEvent) {
            // Example: https://jsbin.com/nawahef/edit?js,output
            evt.dragged; // dragged HTMLElement
            evt.draggedRect; // DOMRect {left, top, right, bottom}
            evt.related; // HTMLElement on which have guided
            evt.relatedRect; // DOMRect
            evt.willInsertAfter; // Boolean that is true if Sortable will insert drag element after target by default
            originalEvent.clientY; // mouse position
            $(evt.dragged).find("td:gt(1)").remove();
            $ghostEl = $(evt.dragged);
            $ghostEl.find("td:gt(1)").remove();

            $ghostEl.removeClass().addClass("d-flex");
            $ghostEl.find('td.handle').removeClass().addClass("col-1");
            $ghostEl.find('td.product-name').removeClass().addClass("col-11");

            // return false; — for cancel
            // return -1; — insert before target
            // return 1; — insert after target
        },
        onClone: function (/**Event*/evt) {
            var origEl = evt.item;
            var cloneEl = evt.clone;
            // $(cloneEl).find("td:gt(1)").remove();
            // console.log(origEl, cloneEl);
        },
        ...globalSortableSettings});

    let createModal = document.getElementById('create-or-edit-modal');
    $('#btn-add-product').on('click', (event) => _showModal({
            modal: createModal,
            title: 'Create new product',
            onShow: () => {
                setModalFormCreateMode();
                let productForm = document.getElementById('product-form').cloneNode(true);
                productForm.id = "";
                _appendFormToModal(createModal, productForm);
            }
        }
    ));

    // Edit buttons
    $('.btn-edit-product').on("click", (event) => {

        let $editButton = $(event.currentTarget);
        var $productRow = $editButton.parents("tr:eq(0)")

        _showModal({
            modal: createModal,
            title: 'Edit product',
            onShow: () => {
                setModalFormEditMode();
                let productForm = document.getElementById('product-form').cloneNode(true);
                productForm.id = "";
                changeFormMethod({
                    form: productForm,
                    method: "PUT"
                });

                let productName = $productRow.find(".product-name").text();
                let productPrice = $productRow.find(".product-price").text();

                productForm.querySelector(".form-product-name").value = productName;
                productForm.querySelector(".form-product-price").value = productPrice;

                productForm.action += "/" + $productRow.data("id");

                _appendFormToModal(createModal, productForm);
            }}
        );
    });

    // Remove buttons
    $('.btn-remove-product').on("click", (event) => {
        let $editButton = $(event.currentTarget);
        var $productRow = $editButton.parents("tr:eq(0)")

        $('#loader').show();
        $.ajax({
            url: '/product/' + $productRow.data("id"),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'DELETE',
            success: function(data){
                location.reload();
            },
            error: () => {$('#loader').hide();}
        });

    });
}

function setUpMenuTableEvents(){
    let createModal = document.getElementById('create-or-edit-modal');
    $('#btn-add-menu').on('click', (event) => _showModal({
            modal: createModal,
            title: 'Create new menu',
            onShow: () => {
                setModalFormCreateMode();
                let menuForm = document.getElementById('menu-form').cloneNode(true);
                menuForm.id = "";
                _appendFormToModal(createModal, menuForm);
            }
        }
    ));

    // Edit buttons
    $('.btn-edit-menu').on("click", (event) => {

        let $editButton = $(event.currentTarget);
        var $menuRow = $editButton.parents("tr:eq(0)")

        _showModal({
            modal: createModal,
            title: 'Edit menu',
            onShow: () => {
                setModalFormEditMode();
                let menuForm = document.getElementById('menu-form').cloneNode(true);
                menuForm.id = "";
                changeFormMethod({
                    form: menuForm,
                    method: "PUT"
                });

                let menuName = $menuRow.find(".menu-name").text();
                let menuPrice = $menuRow.find(".menu-price").text();

                menuForm.querySelector(".form-menu-name").value = menuName;
                menuForm.querySelector(".form-menu-price").value = menuPrice;

                menuForm.action += "/" + $menuRow.data("id");

                _appendFormToModal(createModal, menuForm);
            }}
        );
    });

    // Remove buttons
    $('.btn-remove-menu').on("click", (event) => {
        let $editButton = $(event.currentTarget);
        var $menuRow = $editButton.parents("tr:eq(0)")

        $('#loader').show();

        $.ajax({
            url: '/menu/' + $menuRow.data("id"),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'DELETE',
            success: function(data){
                location.reload();
            },
            error: () =>{
                $('#loader').hide();
            }
        });

    });
}

function setUpCarteMenuTableEvents(){
    let createModal = document.getElementById('create-or-edit-modal');
    $('#btn-add-carte-menu').on('click', (event) => _showModal({
            modal: createModal,
            title: 'Create new carte menu',
            onShow: () => {
                setModalFormCreateMode();
                let carteMenuForm = document.getElementById('carte-menu-form').cloneNode(true);
                carteMenuForm.id = "";
                _appendFormToModal(createModal, carteMenuForm);
            }
        }
    ));

    // Edit buttons
    $('.btn-edit-carte-menu').on("click", (event) => {

        let $editButton = $(event.currentTarget);
        var $carteMenuRow = $editButton.parents("tr:eq(0)")

        _showModal({
            modal: createModal,
            title: 'Edit carte menu',
            onShow: () => {
                setModalFormEditMode();
                let carteMenuForm = document.getElementById('carte-menu-form').cloneNode(true);
                carteMenuForm.id = "";
                changeFormMethod({
                    form: carteMenuForm,
                    method: "PUT"
                });

                let menuName = $carteMenuRow.find(".carte-menu-name").text();

                carteMenuForm.querySelector(".form-carte-menu-name").value = menuName;

                carteMenuForm.action += "/" + $carteMenuRow.data("id");

                _appendFormToModal(createModal, carteMenuForm);
            }}
        );
    });

    // Remove buttons
    $('.btn-remove-carte-menu').on("click", (event) => {
        let $editButton = $(event.currentTarget);
        var $carteMenuRow = $editButton.parents("tr:eq(0)")

        $('#loader').show();

        $.ajax({
            url: '/carte-menu/' + $carteMenuRow.data("id"),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'DELETE',
            success: function(data){
                location.reload();
            },
            error: () =>{
                $('#loader').hide();
            }
        });

    });

    // Sortable products
    $('#menus tr[data-id=3].menu-product-list tbody').sortable({
        group: {
            put: function(to, from, dragEl, evt) {
                if (to.el.querySelector('tr[data-id="' + dragEl.dataset.id + '"]')){
                    return false;
                }
                return "products";
            }
        },
        onAdd: function (event) {
            $(event.item).find("td:gt(1)").remove();
            console.log("hola");
        },
        ...globalSortableSettings
    });
}
