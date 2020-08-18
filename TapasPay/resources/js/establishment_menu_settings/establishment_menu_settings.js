(function () {
    "use strict";
    let Sortable = require("sortablejs").Sortable;

    let $ = require("jquery");

    //
    // Variables
    //
    const globalSortableSettings = {
        handle: ".handle",
        animation: 150,
        // draggable: ".kanban-card",
        dataIdAttr: 'data-id',
        scrollSensitivity: 100,
        forceFallback: true,
        ghostClass: 'dragged-ghost'
    };


    const generalSettings = {
        // "handle": ".handle",
        "animation": 150,
        "draggable": ".draggable-testing",
        "dataIdAttr": 'data-id',
        "scrollSensitivity": 100,
        forceFallback: true,
    }

    const loader = document.getElementById("loader");

    //
    // Methods
    //
    let showLoading = function () {
        loader.style.display = 'block';
    }

    let hideLoading = function () {
        loader.style.display = 'none';
    }


    function setUpModalForm() {
        let formModal = document.getElementById('create-or-edit-modal');
        let submitButtonList = formModal.querySelectorAll('.modal-submit-button');
        submitButtonList.forEach(submitButton => {
            submitButton.onclick = () => {
                let formInModal = formModal.querySelector('.modal-form form');
                let modalSubmitButton = formModal.querySelector("button.btn-submit");

                if (modalSubmitButton) {
                    modalSubmitButton.click();
                } else {
                    formInModal.submit();
                }
            }
        });
    }

    function _setModalMode(buttonText) {
        let createModal = document.getElementById('create-or-edit-modal');
        let submitButton = createModal.querySelector('.modal-submit-button');
        if (submitButton) {
            submitButton.textContent = buttonText;
        }
    }

    function setModalFormCreateMode() {
        _setModalMode("Create");
    }

    function setModalFormEditMode() {
        _setModalMode(" Save");
    }

    function _showModal(args) {

        if (args.constructor !== Object) {
            throw "You need to pass an argument";
        }

        if (!args.modal) {
            throw "You need to pass an modal object";
        }

        if (args.onShow) {
            args.onShow();
        }

        args.title = args.title || '';

        args.modal.querySelector('.modal-title').textContent = args.title;

        $(args.modal).modal();
    }

    function _appendFormToModal(modal, formElement) {
        // We do this to avoid complex validations scripts

        let submitButton = document.createElement("button");
        submitButton.type = "submit";
        submitButton.classList.add("btn-submit")

        submitButton.style.display = 'none';

        formElement.appendChild(submitButton);

        formElement.onsubmit = () => {
            showLoading();
        };
        let modelFormSection = modal.querySelector('.modal-form')
        modelFormSection.innerHTML = "";
        modelFormSection.appendChild(formElement);

    }

    function changeFormMethod(params) {

        if (params.constructor !== Object) {
            throw "Parameter needs to be a object!";
        }

        if (!params.form || !params.method) {
            throw "Form and Method should be passed in the object!";
        }

        let methodInput = document.createElement("input");
        methodInput.type = "hidden";
        methodInput.name = "_method";
        methodInput.value = params.method;

        params.form.appendChild(methodInput);
    }

    function addEventListenerToProductRows() {
        let createModal = document.getElementById('create-or-edit-modal');
        let buttonAddProduct = document.getElementById("btn-add-product");
        buttonAddProduct.onclick = () => _showModal({
                modal: createModal,
                title: 'Create new product',
                onShow: () => {
                    setModalFormCreateMode();
                    let productForm = document.getElementById('product-form').cloneNode(true);
                    productForm.id = "";
                    _appendFormToModal(createModal, productForm);
                }
            }
        );

        // Edit buttons
        let buttonEditProductList = document.querySelectorAll(".btn-edit-product");
        buttonEditProductList.forEach(buttonEditProduct => {
            buttonEditProduct.onclick = event => {

                let editButton = event.currentTarget;
                let productRow = editButton.closest("tr");

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

                            let image_path = productRow.dataset.imgUrl;

                            let productName = productRow.querySelector(".product-name").textContent;
                            let productPrice = productRow.querySelector(".product-price").textContent;

                            let productImgElement = productForm.querySelector(".js_product_image");
                            let productImgInput = productForm.querySelector(".js_product_image_input");

                            updateImageDependInput(productImgInput, productImgElement);

                            productForm.querySelector(".form-product-name").value = productName;
                            productForm.querySelector(".form-product-price").value = productPrice;
                            productImgElement.src = image_path;

                            productForm.action += "/" + productRow.dataset.id;

                            _appendFormToModal(createModal, productForm);
                        }
                    }
                );
            };
        });

        // Remove buttons
        let buttonRemoveProductList = document.querySelectorAll(".btn-remove-product");
        buttonRemoveProductList.forEach(buttonRemoveProduct => {
            buttonRemoveProduct.onclick = (event) => {

                showLoading();
                let editButton = event.currentTarget;
                let productRow = editButton.closest("tr");
                let removeProductRequest = new XMLHttpRequest();
                let csrf_token = document.querySelector('meta[name="csrf-token"]').content;

                removeProductRequest.open('DELETE', '/product/' + productRow.dataset.id, true);

                removeProductRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
                removeProductRequest.setRequestHeader("X-CSRF-TOKEN", csrf_token);

                removeProductRequest.onload = () => {
                    location.reload();
                };

                removeProductRequest.onerror = function () {
                    hideLoading();
                }

                removeProductRequest.send();

            };
        });
    }

    function updateImageDependInput(input_element, image_element) {

        input_element.onchange = input_event => {
            let reader = new FileReader();

            reader.onload = function (reader_event) {
                image_element.src = reader_event.target.result;
            }

            reader.readAsDataURL(input_event.currentTarget.files[0]);
        }

    }

    function setUpProductTableEvents() {

        let productSection = document.getElementById("products");
        let productList = productSection.querySelectorAll("tbody");

        productList.forEach((sortableList) => {

            Sortable.create(sortableList, {
                group: {
                    name: "products",
                    pull: "clone",
                    put: false,
                },
                sort: false,
                onEnd: function (evt, originalEvent) {
                    addEventListenerToProductRows();
                },


                ...globalSortableSettings
            });

        })

        addEventListenerToProductRows();
    }

    function setUpMenuTableEvents() {
        let createModal = document.getElementById('create-or-edit-modal');

        let buttonAddMenu = document.getElementById('btn-add-menu');
        buttonAddMenu.onclick = () => _showModal({
                modal: createModal,
                title: 'Create new menu',
                onShow: () => {
                    setModalFormCreateMode();
                    let menuForm = document.getElementById('menu-form').cloneNode(true);
                    menuForm.id = "";
                    _appendFormToModal(createModal, menuForm);
                }
            }
        );

        // Edit buttons
        let buttonEditMenuList = document.querySelectorAll(".btn-edit-menu");
        buttonEditMenuList.forEach(buttonEditMenu => {
            buttonEditMenu.onclick = event => {

                let editButton = event.currentTarget;
                let menuRow = editButton.closest("tr");

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

                            let menuName = menuRow.querySelector(".menu-name").textContent;
                            let menuPrice = menuRow.querySelector(".menu-price").textContent;

                            menuForm.querySelector(".form-menu-name").value = menuName;
                            menuForm.querySelector(".form-menu-price").value = menuPrice;

                            menuForm.action += "/" + menuRow.dataset.id;

                            _appendFormToModal(createModal, menuForm);
                        }
                    }
                );
            };
        });


        // Remove buttons
        let buttonRemoveMenuList = document.querySelectorAll(".btn-remove-menu");
        buttonRemoveMenuList.forEach(buttonRemoveMenu => {
            buttonRemoveMenu.onclick = event => {

                let editButton = event.currentTarget;
                let menuRow = editButton.closest("tr");

                showLoading();

                let removeProductRequest = new XMLHttpRequest();
                let csrf_token = document.querySelector('meta[name="csrf-token"]').content;

                removeProductRequest.open('DELETE', '/menu/' + menuRow.dataset.id, true);

                removeProductRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
                removeProductRequest.setRequestHeader("X-CSRF-TOKEN", csrf_token);

                removeProductRequest.onload = () => {
                    location.reload();
                };

                removeProductRequest.onerror = function () {
                    hideLoading();
                }

                removeProductRequest.send();

            };
        });

    }

    function setUpCarteMenuTableEvents() {
        let createModal = document.getElementById('create-or-edit-modal');
        document.getElementById("btn-add-carte-menu").onclick = () => _showModal({
                modal: createModal,
                title: 'Create new carte menu',
                onShow: () => {
                    setModalFormCreateMode();
                    let carteMenuForm = document.getElementById('carte-menu-form').cloneNode(true);
                    carteMenuForm.id = "";
                    _appendFormToModal(createModal, carteMenuForm);
                }
            }
        );

        // Edit buttons
        let buttonEditCarteMenuList = document.querySelectorAll('.btn-edit-carte-menu');
        buttonEditCarteMenuList.forEach(buttonEditCarteMenu => {
            buttonEditCarteMenu.onclick = event => {

                let editButton = event.currentTarget;
                let carteMenuRow = editButton.closest("tr");

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

                            let menuName = carteMenuRow.querySelector(".carte-menu-name").textContent;

                            carteMenuForm.querySelector(".form-carte-menu-name").value = menuName;

                            carteMenuForm.action += "/" + carteMenuRow.dataset.id;

                            _appendFormToModal(createModal, carteMenuForm);
                        }
                    }
                );
            }
        });

        // Remove buttons
        let buttonRemoveCarteMenuList = document.querySelectorAll('.btn-remove-carte-menu');
        buttonRemoveCarteMenuList.forEach(buttonRemoveCarteMenu => {
            buttonRemoveCarteMenu.onclick = (event) => {

                let editButton = event.currentTarget;
                let carteMenuRow = editButton.closest("tr");

                showLoading();

                let removeProductRequest = new XMLHttpRequest();
                let csrf_token = document.querySelector('meta[name="csrf-token"]').content;

                removeProductRequest.open('DELETE', '/carte-menu/' + carteMenuRow.dataset.id, true);

                removeProductRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
                removeProductRequest.setRequestHeader("X-CSRF-TOKEN", csrf_token);

                removeProductRequest.onload = () => {
                    location.reload();
                };

                removeProductRequest.onerror = function () {
                    hideLoading();
                }

                removeProductRequest.send();

            }
        });

        // Sortable products

        let menuProductList = document.getElementById("menus").querySelectorAll("tr[data-id='3'].menu-product-list tbody");

        menuProductList.forEach((sortableProductList) => {
            Sortable.create(sortableProductList, {
                group: {
                    put: function (to, from, dragEl, evt) {
                        if (to.el.querySelector('tr[data-id="' + dragEl.dataset.id + '"]')) {
                            return false;
                        }
                        return "products";
                    }
                },
                ...globalSortableSettings
            });
        });
    }


    //
    // Init & Event Listeners
    //
    setUpModalForm();

    setUpProductTableEvents();
    setUpMenuTableEvents();
    setUpCarteMenuTableEvents();
})();
