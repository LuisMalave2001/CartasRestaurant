function createInputWithButtons(inputWithButton, opts) {
    const btnSubtract = inputWithButton.querySelector(".js_btn_number_subtract");

    if (!opts.oninput) {
        opts.oninput = function () {};
    }

    if (typeof(opts.oninput) !== "function") {
        throw "oninput needs to be a function!";
    }

    btnSubtract.addEventListener("click", event => {
        const inputNumber = document.getElementById(btnSubtract.dataset.inputId);

        const previousValue = parseInt(inputNumber.value) || 0;
        const value = previousValue - 1;

        if (opts.min === undefined || (value >= opts.min)) {
            inputNumber.value = value;
        }

        opts.oninput({
            previousValue: previousValue,
            newValue: value,
            inputElement: inputNumber,
        });
    });

    const btnAdd = inputWithButton.querySelector(".js_btn_number_add");
    btnAdd.addEventListener("click", event => {
        const inputNumber = document.getElementById(btnSubtract.dataset.inputId);
        const previousValue = parseInt(inputNumber.value) || 0;
        const value = previousValue + 1;
        if (opts.max === undefined || (value >= opts.max)) {
            inputNumber.value = value;
        }

        opts.oninput({
            previousValue: previousValue,
            newValue: value,
            inputElement: inputNumber,
        });
    });

}

export { createInputWithButtons };
