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
                            let description = productRow.dataset.description;
                            let category = productRow.dataset.category;

                            let productName = productRow.querySelector(".product-name").textContent;
                            let productPrice = productRow.querySelector(".product-price").textContent;

                            let productImgElement = productForm.querySelector(".js_product_image");
                            let productImgInput = productForm.querySelector(".js_product_image_input");

                            updateImageDependInput(productImgInput, productImgElement);

                            productImgElement.src = image_path;

                            productForm.action += "/" + productRow.dataset.id;
                            productForm.querySelector(".form-product-name").value = productName;
                            productForm.querySelector(".form-product-price").value = productPrice;
                            productForm.querySelector(".form-product-description").value = description;
                            productForm.querySelector(".form-product-category").value = category;

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
        let productTableBody = productSection.querySelector("tbody");

        Sortable.create(productTableBody, {
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

        addEventListenerToProductRows();
    }

    function setUpMenuTableEvents() {
        //
        // Variable declarations
        //
        let createModal = document.getElementById('create-or-edit-modal');
        let buttonAddMenu = document.getElementById('btn-add-menu');
        let buttonEditMenuList = document.querySelectorAll(".btn-edit-menu");
        let buttonRemoveMenuList = document.querySelectorAll(".btn-remove-menu");
        const menuTable = document.getElementById("menus");
        const menuTableBody = menuTable.querySelector("tbody");
        const menuProductsList = menuTable.querySelectorAll("tr.menu-product-list tbody");
        const btnSaveMenuEl = document.getElementById("btn-save-menu-list");
        const buttonRemoveMenuProductList = document.querySelectorAll(".menu-delete-product");

        //
        // Methods
        //
        const showAddFormMenuEvent = () => {
            _showModal({
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
        }
        const showEditFormMenuEvent = event => {

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

                        const image_path = menuRow.dataset.imgUrl;
                        const description = menuRow.dataset.description;
                        const category = menuRow.dataset.category;

                        let menuName = menuRow.querySelector(".menu-name").textContent;
                        let menuPrice = menuRow.querySelector(".menu-price").textContent;
                        let menuImgElement = menuForm.querySelector(".js_menu_image");
                        let menuImgInput = menuForm.querySelector(".js_menu_image_input");

                        updateImageDependInput(menuImgInput, menuImgElement);

                        menuImgElement.src = image_path ? image_path : menuImgElement.dataset.errorImage;


                        menuForm.querySelector(".form-menu-name").value = menuName;
                        menuForm.querySelector(".form-menu-price").value = menuPrice;
                        menuForm.querySelector(".form-menu-description").value = description;
                        menuForm.querySelector(".form-menu-category").value = category;

                        menuForm.action += "/" + menuRow.dataset.id;

                        _appendFormToModal(createModal, menuForm);
                    }
                }
            );
        };
        const removeFormMenuEvent = event => {

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
        const menuProductListHasChangedEvent = event => {
            btnSaveMenuEl.removeAttribute("disabled");
            btnSaveMenuEl.classList.remove("btn-secondary");
            btnSaveMenuEl.classList.add("btn-primary");
        };

        function getMenuProductsCurrentRelationList() {
            const menuProductRelationList = {};
                menuProductsList.forEach(menuProducts => {

                const productList = [];

                const productTrList = menuProducts.querySelectorAll("tr");
                productTrList.forEach(productTr => {
                    productList.push(parseInt(productTr.dataset.id));
                });

                menuProductRelationList[parseInt(menuProducts.dataset.id)] = productList;
            });
            return menuProductRelationList;
        }

        const saveCurrentProductOrderEvent = event => {
            const menuProductRelationList = getMenuProductsCurrentRelationList();

            let loader = document.getElementById("loader");
            loader.style.display = 'block';

            let csrf_token = document.querySelector('meta[name="csrf-token"]').content;

            const updateRelationRequest = new XMLHttpRequest();
            updateRelationRequest.open('PUT', '/menu/product_relations', true);

            updateRelationRequest.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
            updateRelationRequest.setRequestHeader("X-CSRF-TOKEN", csrf_token);

            updateRelationRequest.onload = () => {
                loader.style.display = 'none';
                btnSaveMenuEl.disabled = "disabled";
                btnSaveMenuEl.classList.add("btn-secondary");
                btnSaveMenuEl.classList.remove("btn-primary");
            }

            updateRelationRequest.send(JSON.stringify(menuProductRelationList));

        };

        const removeItemEvent = event => {
            event.currentTarget.closest("tr").remove();
            btnSaveMenuEl.dispatchEvent(new Event("menu:menuProductListHasChanged"));
        };

        //
        // Init and events listeners
        //
        buttonAddMenu.onclick = showAddFormMenuEvent;
        buttonEditMenuList.forEach(buttonEditMenu => buttonEditMenu.onclick = showEditFormMenuEvent);
        buttonRemoveMenuList.forEach(buttonRemoveMenu => buttonRemoveMenu.onclick = removeFormMenuEvent);
        btnSaveMenuEl.addEventListener("menu:menuProductListHasChanged", menuProductListHasChangedEvent)
        btnSaveMenuEl.onclick = saveCurrentProductOrderEvent;
        buttonRemoveMenuProductList.forEach(buttonRemoveMenuProduct => buttonRemoveMenuProduct.onclick = removeItemEvent);

        // // Sortable products
        Sortable.create(menuTableBody, {
            group: {
                name: "menus",
                pull: "clone",
                put: false,
            },
            sort: false,
            onEnd: function (evt, originalEvent) {
                // addEventListenerToProductRows();
            },

            ...globalSortableSettings
        });

        menuProductsList.forEach((sortableProductList) => {
            Sortable.create(sortableProductList, {
                group: {
                    put: function (to, from, dragEl, evt) {
                        if (to.el.querySelector('tr[data-id="' + dragEl.dataset.id + '"]')) {
                            return false;
                        }
                        return "products";
                    }
                },
                onAdd: event => btnSaveMenuEl.dispatchEvent(new Event("menu:menuProductListHasChanged")),
                ...globalSortableSettings
            });
        });
    }

    function setUpCarteMenuTableEvents() {
        //
        // Variable declarations
        //
        const createModal = document.getElementById('create-or-edit-modal');
        const btnAddCarteMenu = document.getElementById("btn-add-carte-menu")
        const buttonEditCarteMenuList = document.querySelectorAll('.btn-edit-carte-menu');
        const buttonRemoveCarteMenuList = document.querySelectorAll('.btn-remove-carte-menu');

        const buttonRemoveItemList = document.querySelectorAll(".carte-delete-item");

        const carteMenuItemTableBodyList = document.getElementById("carte-menus").querySelectorAll(".carte-menu-items-list tbody");
        const btnSaveCarteMenuEl = document.getElementById("btn-save-carte-menu-list");

        //
        // Methods
        //
        const showAddCarteMenuForm = () => {
            _showModal({
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
        }
        const showEditCarteMenuForm = event => {

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
        const removeCarteMenuEvent = event => {

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

        const carteMenuItemListHasChangedEvent = event => {
            btnSaveCarteMenuEl.removeAttribute("disabled");
            btnSaveCarteMenuEl.classList.remove("btn-secondary");
            btnSaveCarteMenuEl.classList.add("btn-primary");
        };

        function getCarteMenuItemsCurrentRelationList() {
            const carteMenuItemsLists = {};
            carteMenuItemTableBodyList.forEach(carteMenuItemTableBody => {

                const itemList = {};

                const itemsTrList = carteMenuItemTableBody.querySelectorAll("tr");
                itemsTrList.forEach(itemTr => {

                    const itemType = itemTr.dataset.table;
                    if (!itemList[itemType]) {itemList[itemType] = [];}

                    itemList[itemType].push(parseInt(itemTr.dataset.id));
                });

                // Check if is empty
                itemList["menus"] = itemList["menus"] || [];
                itemList["products"] = itemList["products"] || [];

                carteMenuItemsLists[parseInt(carteMenuItemTableBody.dataset.id)] = itemList;
            });
            return carteMenuItemsLists;
        }
        const saveCurrentItemOrderEvent = event => {
            const itemsRelationList = getCarteMenuItemsCurrentRelationList();
            console.log(itemsRelationList);
            let loader = document.getElementById("loader");
            loader.style.display = 'block';

            let csrf_token = document.querySelector('meta[name="csrf-token"]').content;

            const updateRelationRequest = new XMLHttpRequest();
            updateRelationRequest.open('PUT', '/carte_menu/item_relations', true);

            updateRelationRequest.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
            updateRelationRequest.setRequestHeader("X-CSRF-TOKEN", csrf_token);

            updateRelationRequest.onload = () => {
                loader.style.display = 'none';
                btnSaveCarteMenuEl.disabled = "disabled";
                btnSaveCarteMenuEl.classList.add("btn-secondary");
                btnSaveCarteMenuEl.classList.remove("btn-primary");
            }

            updateRelationRequest.send(JSON.stringify(itemsRelationList));

        };

        const removeItemEvent = event => {
            event.currentTarget.closest("tr").remove();
            btnSaveCarteMenuEl.dispatchEvent(new Event("carte_menu:menuItemsHasChanged"));
        };

        //
        // Init and events listeners
        //
        btnAddCarteMenu.onclick = showAddCarteMenuForm;
        buttonEditCarteMenuList.forEach(buttonEditCarteMenu => buttonEditCarteMenu.onclick = showEditCarteMenuForm);
        buttonRemoveCarteMenuList.forEach(buttonRemoveCarteMenu => buttonRemoveCarteMenu.onclick = removeCarteMenuEvent);

        btnSaveCarteMenuEl.addEventListener("carte_menu:menuItemsHasChanged", carteMenuItemListHasChangedEvent);
        btnSaveCarteMenuEl.onclick = saveCurrentItemOrderEvent;

        buttonRemoveItemList.forEach(buttonRemoveItem => buttonRemoveItem.onclick = removeItemEvent);

        carteMenuItemTableBodyList.forEach((carteMenuItems) => {
            Sortable.create(carteMenuItems, {
                // group: "products",
                group: {
                    put: function (to, from, dragEl, evt) {
                        let group = from.options.group.name
                        if (to.el.querySelector(`tr[data-id="${dragEl.dataset.id}"][data-table="${group}"]`)) {
                            return false;
                        }
                        return group;
                    }
                },
                onAdd: event => btnSaveCarteMenuEl.dispatchEvent(new Event("carte_menu:menuItemsHasChanged")),
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
