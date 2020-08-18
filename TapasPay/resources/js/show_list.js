document.addEventListener("DOMContentLoaded", function () {

    let inputWithButtonList = document.getElementsByClassName("js_input_with_buttons");
    for (let inputWithButton of inputWithButtonList) {
        createInputWithButtons(inputWithButton);
    }


});

function createInputWithButtons(inputWithButton) {
    let btnSubtract = inputWithButton.querySelector(".js_btn_number_subtract");

    btnSubtract.onclick = event => {
        let inputNumber = document.getElementById(btnSubtract.dataset.inputId);
        inputNumber.value = (parseInt(inputNumber.value) || 0) - 1;
    }

    let btnAdd = inputWithButton.querySelector(".js_btn_number_add");
    btnAdd.onclick = event => {
        let inputNumber = document.getElementById(btnSubtract.dataset.inputId);
        inputNumber.value = (parseInt(inputNumber.value) || 0) + 1;
    }
}
