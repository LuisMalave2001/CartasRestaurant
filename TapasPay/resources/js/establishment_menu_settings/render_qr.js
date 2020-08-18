(function (){
    "use strict";

    const QRious = require("qrious");

    let qrBlockList = document.querySelectorAll(".js-qr-block");

    qrBlockList.forEach(qrBlock => {
        let url = qrBlock.querySelector(".js-qr-url").href;
        let qrCanvas = qrBlock.querySelector(".js-qr-image");
        let qr = new QRious({
            element: qrCanvas,
            value: url,
            size: 300,
        });


    })

})();
