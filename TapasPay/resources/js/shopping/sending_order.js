(function () {
    "use strict";

    //
    // Variables
    //
    const btnSubmitOrder = document.querySelector(".js-btn-submit-order");

    //
    // Methods
    //
    const submitOrder = function (event) {
        "use strict";

        // let establishment_select = event.currentTarget;

        let loader = document.getElementById("loader");
        loader.style.display = 'block';


        const inputTableHashId = document.querySelector('input[name="tableHashId"]')

        let csrf_token = document.querySelector('meta[name="csrf-token"]').content;

        let sendOrder = new XMLHttpRequest();
        sendOrder.open('POST', '/orders/' + inputTableHashId.value, true);

        sendOrder.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        sendOrder.setRequestHeader("X-CSRF-TOKEN", csrf_token);
        //
        // let parameters = [];
        //
        // parameters.push({"hola[]": "hola"});
        // parameters.push({"hola[]": "hola2"});
        // parameters.push({"hola[]": "hola3"});
        // parameters.push({"hola[]": "hola4"});

        sendOrder.onload = (event) => {
            location.reload();
        };


        sendOrder.onerror = function (event) {
            loader.style.display = 'none';
            alert("error, see console!");
            console.error(event);
        }

        // const urlParameters = parameters.map(param => Object.keys(param)[0] + "=" + param[Object.keys(param)[0]]).join('&');
        // sendOrder.send(urlParameters);
        sendOrder.send();
    };

    //
    // Init & Event Listeners
    //

    if (btnSubmitOrder) {
        btnSubmitOrder.onclick = submitOrder;
    }

    return !!btnSubmitOrder;

})();
