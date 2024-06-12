const Label = document.querySelectorAll("label");
const Input = document.querySelectorAll("input");

Input[0].addEventListener("focusin", Subir)
Input[0].addEventListener("focusout", Descer)
Input[1].addEventListener("focusin", Subir2)
Input[1].addEventListener("focusout", Descer2)

function Subir() {
    Label[0].style.top = "24px"
}

function Subir2() {
    Label[1].style.top = "64px"
}

function Descer() {
    Label[0].style.top = "47px"
}

function Descer2() {
    Label[1].style.top = "87px"
}