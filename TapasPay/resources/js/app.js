require("bootstrap");

require("./layout/header");

if (document.querySelector(".js-menu-setup-page")){
    require("./establishment_menu_settings/establishment_menu_settings");
}

if (document.querySelector(".js-shopping-list")){
    require("./shopping/images_modal");
}

if (document.querySelector(".js-qr-block")){
    require("./establishment_menu_settings/render_qr");
}

require("./show_list");
