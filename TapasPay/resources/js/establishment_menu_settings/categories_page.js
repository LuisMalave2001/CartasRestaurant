(function (){
    const $ = require('jquery');
    const buttonRemoveCategoryList = document.querySelectorAll(".btn-remove-category");
    const buttonEditCategoryList = document.querySelectorAll(".btn-edit-category");
    const categoryModal = document.getElementById("js-category-modal");

    const onDeleteCategory = event => {
        const removeButton = event.currentTarget;
        const categoryId = removeButton.dataset.id;

        document.getElementById("loader").style.display = 'block';

        let removeCategoryRequest = new XMLHttpRequest();
        let csrf_token = document.querySelector('meta[name="csrf-token"]').content;

        removeCategoryRequest.open('DELETE', '/category/' + categoryId, true);

        removeCategoryRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        removeCategoryRequest.setRequestHeader("X-CSRF-TOKEN", csrf_token);

        removeCategoryRequest.onload = serverEvent => {
            console.log(removeCategoryRequest);
            location.reload();
        };

        removeCategoryRequest.onerror = function () {
            document.getElementById("loader").style.display = 'none';;
        }

        removeCategoryRequest.send();
    };
    const triggerEditModal = event => {
        const btnEditCategory = event.currentTarget;
        const category = document.getElementById(btnEditCategory.dataset.target);

        const categoryIdInput = document.createElement("INPUT");
        categoryIdInput.name = 'category_id';
        categoryIdInput.type = 'hidden';
        categoryIdInput.value = category.dataset.id;

        categoryModal.querySelector('input[name="_method"]').value = 'PUT';
        categoryModal.querySelector('form').appendChild(categoryIdInput);
        categoryModal.querySelector('input[name="name"]').value = category.dataset.name;
        if (category.dataset.isGlobal && parseInt(category.dataset.isGlobal)){
            categoryModal.querySelector('input[name="is_global"]').checked = 'checked';
        }

        $(categoryModal).modal();

    }
    buttonEditCategoryList.forEach(buttonEditCategory => buttonEditCategory.onclick = triggerEditModal);
    buttonRemoveCategoryList.forEach(buttonRemoveProduct => buttonRemoveProduct.onclick = onDeleteCategory);
})();
