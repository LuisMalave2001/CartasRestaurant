(function(){
    "use strict";

    let $ = require("jquery");

    let imagesToTriggerModalList = document.querySelectorAll(".js-modal-image-trigger");

    let $imageModal = $("#js-image-modal");

    for (let imagesToTriggerModal of imagesToTriggerModalList) {
        imagesToTriggerModal.addEventListener("click", () => {
            $imageModal.find(".js-modal-image-content").attr("src", imagesToTriggerModal.src);
            $imageModal.modal();
        });
    }

    return !imagesToTriggerModalList || !$imageModal;

})();
