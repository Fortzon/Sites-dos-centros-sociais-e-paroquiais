const Label = document.querySelectorAll("label");
const Input = document.querySelectorAll("input");

Input[0].addEventListener("focusin", Subir)
Input[0].addEventListener("focusout", Descer)

function Subir() {
    Label[0].style.top = "24px"
}

function Descer() {
    Label[0].style.top = "47px"
}
