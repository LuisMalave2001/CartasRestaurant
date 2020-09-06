(function () {
    "use strict";
    const $ = require("jquery");
    const createInputWithButtons = require("../utils/incremental_number_widget").createInputWithButtons;

    //
    // Variables
    //
    const $modalOrder = $("#js-order-modal");
    const $modalItemUnitsGroup = $modalOrder.find(".js_modal_order_item_units_group");
    const modalInputUnits = document.getElementById("js_modal_order_item_units");
    const btnOrderList = document.querySelectorAll(".js-btn-modal-order");

    //
    // Methods
    //
    const toggleOrderModal = event => {
        const btnOrderEl = event.currentTarget;
        const shoppingElement = document.getElementById(btnOrderEl.dataset.htmlId);

        const price = shoppingElement.dataset.price;
        const name = shoppingElement.dataset.name;
        const imageUrl = shoppingElement.dataset.imageUrl || shoppingElement.dataset.defaultImageUrl;
        const resModel = shoppingElement.dataset.resModel;
        const resId = shoppingElement.dataset.resId;

        $modalOrder.find(".js-order-modal-image-content").attr("src", imageUrl);
        $modalOrder.find("#js_order_modal-name").val(name);

        $modalOrder.find("#js_order_modal-total_price").val(price);
        $modalOrder.find("#js_order_modal-unit_price").val(price);

        $modalOrder.find("#js_order_modal-res_id").val(resId);
        $modalOrder.find("#js_order_modal-res_modal").val(resModel);

        $modalItemUnitsGroup.find("input").val(1);
        $modalOrder.modal();
    };

    //
    // Init and event handlers
    //
    createInputWithButtons($modalItemUnitsGroup[0], {
        "min": 1,
        oninput: event => {
            const newValue = event.newValue;

            const $priceInput = $modalOrder.find("#js_order_modal-total_price");
            const $unitPriceInput = $modalOrder.find("#js_order_modal-unit_price");

            const originalPrice = parseFloat($unitPriceInput.val()) || 1;

            const newPrice = originalPrice * newValue;
            $priceInput.val(newPrice.toFixed(2));
        },
    })
    btnOrderList.forEach(btnOrderEl => btnOrderEl.onclick = toggleOrderModal);

    return !!$modalOrder.length & !!btnOrderList;

})();
