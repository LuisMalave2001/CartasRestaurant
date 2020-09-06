(function () {
    "use strict";

    //
    // Variables
    //
    const createInputWithButtons = require("../utils/incremental_number_widget").createInputWithButtons;
    const buttonRemoveOrderLineList = document.querySelectorAll(".js_button_remove_order_line");
    const noteTextareaList = document.querySelectorAll(".js_order_note");
    const itemUnitsInputGroupsList = document.querySelectorAll(".js_order_units_group");

    //
    // Methods
    //
    const removeOrderLineEvent = event => {
        const btnRemoveOrder = event.currentTarget;
        // console.log(btnRemoveOrder.dataset.id);

        const inputTableHashId = document.querySelector('input[name="tableHashId"]')
        const orderLineRowElement = document.getElementById(btnRemoveOrder.dataset.target);
        const orderLineIndex = orderLineRowElement.dataset.id;

        let csrf_token = document.querySelector('meta[name="csrf-token"]').content;

        let updateItemUnitsRequest = new XMLHttpRequest();
        updateItemUnitsRequest.open('DELETE', `/table_orders/${inputTableHashId.value}/line/${orderLineIndex}`, true);

        updateItemUnitsRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        updateItemUnitsRequest.setRequestHeader("X-CSRF-TOKEN", csrf_token);

        updateItemUnitsRequest.onload = event => {
            document.getElementById("loader").style.display = "none";
            orderLineRowElement.remove();
            console.log(event.currentTarget.responseText);
        }

        updateItemUnitsRequest.onerror = function (event) {
            alert("error, see console!");
            console.error(event);
        }

        updateItemUnitsRequest.send();

    };

    function fitTextareaWithContent(textareaNote) {
        textareaNote.style.height = "";
        textareaNote.style.height = textareaNote.scrollHeight + 3 + "px"
    }

    const updateOrderNoteInServer = event => {
        "use strict";
        const textareaNote = event.currentTarget;
        fitTextareaWithContent(textareaNote);

        const inputTableHashId = document.querySelector('input[name="tableHashId"]')
        const orderLineIndex = document.getElementById(textareaNote.dataset.target).dataset.id;

        let csrf_token = document.querySelector('meta[name="csrf-token"]').content;

        let updateNoteRequest = new XMLHttpRequest();
        updateNoteRequest.open('PUT', `/table_orders/${inputTableHashId.value}/line/${orderLineIndex}`, true);

        updateNoteRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        updateNoteRequest.setRequestHeader("X-CSRF-TOKEN", csrf_token);

        let parameters = [];

        parameters.push({"note": textareaNote.value});

        updateNoteRequest.onload = event => {
            console.log("Hola");
        }

        updateNoteRequest.onerror = function (event) {
            alert("error, see console!");
            console.error(event);
        }

        const urlParameters = parameters.map(param => Object.keys(param)[0] + "=" + param[Object.keys(param)[0]]).join('&');
        updateNoteRequest.send(urlParameters);
        // updateNoteRequest.send();
    }
    //
    // Init & Events listeners
    //
    buttonRemoveOrderLineList.forEach(buttonRemoveOrderLine => buttonRemoveOrderLine.onclick = removeOrderLineEvent);
    noteTextareaList.forEach(noteTextarea => noteTextarea.oninput = updateOrderNoteInServer);

    itemUnitsInputGroupsList.forEach( modalItemUnitsGroup => {
        createInputWithButtons(modalItemUnitsGroup, {
            "min": 1,
            oninput: event => {
                const newValue = event.newValue;

                const unitPriceEl = document.getElementById(event.inputElement.dataset.toggleUnitPrice);
                const itemUnitsEl = document.getElementById(event.inputElement.dataset.toggleItemUnits);
                const totalPriceEl = document.getElementById(event.inputElement.dataset.toggleTotalPrice);

                itemUnitsEl.textContent = newValue;
                totalPriceEl.textContent = (parseFloat(unitPriceEl.textContent) * parseFloat(newValue)).toFixed(2);

                const inputTableHashId = document.querySelector('input[name="tableHashId"]')
                const orderLineIndex = document.getElementById(event.inputElement.dataset.target).dataset.id;

                let csrf_token = document.querySelector('meta[name="csrf-token"]').content;

                let updateItemUnitsRequest = new XMLHttpRequest();
                updateItemUnitsRequest.open('PUT', `/table_orders/${inputTableHashId.value}/line/${orderLineIndex}`, true);

                updateItemUnitsRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
                updateItemUnitsRequest.setRequestHeader("X-CSRF-TOKEN", csrf_token);

                let parameters = [];

                parameters.push({"item_units": event.inputElement.value});

                updateItemUnitsRequest.onload = event => {
                    console.log(event.currentTarget.responseText);
                }

                updateItemUnitsRequest.onerror = function (event) {
                    alert("error, see console!");
                    console.error(event);
                }

                const urlParameters = parameters.map(param => Object.keys(param)[0] + "=" + param[Object.keys(param)[0]]).join('&');
                updateItemUnitsRequest.send(urlParameters);
            },
        })
    })

})();
