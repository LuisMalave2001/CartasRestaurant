(function (){
    "use strict";

    //
    // Variables
    //

    let currentEstablishmentEl = document.getElementById("current_establishment_id");
    const loadingOnClickElementList = document.querySelectorAll(".loading-on-click");

    //
    // Methods
    //
    let handlerChangeEstablishment = function (event) {
        "use strict";

        let establishment_select = event.currentTarget;

        let loader = document.getElementById("loader");
        loader.style.display = 'block';

        let csrf_token = document.querySelector('meta[name="csrf-token"]').content;

        let change_establishment = new XMLHttpRequest();
        change_establishment.open('PUT', '/establishment/' + establishment_select.value, true);

        change_establishment.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        change_establishment.setRequestHeader("X-CSRF-TOKEN", csrf_token);

        change_establishment.onload = (event) => {
            location.reload();
            let a = 0;
        };


        change_establishment.onerror = function (event) {
            loader.style.display = 'none';
        }

        change_establishment.send();
    };

    //
    // Init & Event Listeners
    //
    loadingOnClickElementList.forEach(loadingOnClickElement => {
        const showLoader = () => {
            document.getElementById("loader").style.display = 'block';
        };

        loadingOnClickElement.addEventListener("click", showLoader);
    });

    if (currentEstablishmentEl) {
        currentEstablishmentEl.onchange = handlerChangeEstablishment;
    }

})();
