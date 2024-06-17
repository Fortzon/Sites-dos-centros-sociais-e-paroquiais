const Label = document.querySelectorAll("label");
const Input = document.querySelector("input");

Input.addEventListener("focusin", Subir)
Input.addEventListener("focusout", Descer)

function Subir() {
    Label[0].style.top = "24px"
}

function Descer() {
    if (Input.value == "")
    {
        Label[0].style.top = "47px";
    }
    else
    {
        Label[0].style.top = "24px"
    }
}
