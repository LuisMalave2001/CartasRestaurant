require("bootstrap");

require("./layout/header");

if (document.querySelector(".js-menu-setup-page")){
    require("./establishment_menu_settings/establishment_menu_settings");
}

if (document.querySelector(".js-shopping-list")){
    require("./shopping/order_button");
    require("./shopping/images_modal");
    require("./shopping/sending_order");
}

if ( document.querySelectorAll(".js_button_remove_order_line")){
    require("./shopping/shopping_cart_control");
}

if (document.querySelector(".js-shopping-list")){
}

if (document.querySelector(".js-qr-block")){
    require("./establishment_menu_settings/render_qr");
}

if (document.querySelector('.js_category_page')) {
    require("./establishment_menu_settings/categories_page");
}
