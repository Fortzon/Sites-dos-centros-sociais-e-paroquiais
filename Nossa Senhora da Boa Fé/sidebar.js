let AbrirMenuBtn = document.querySelector(".Menu");
let FecharMenuBtn = document.querySelector(".bx-x");
let Navbar = document.querySelector(".navbar");

AbrirMenuBtn.addEventListener("click", Abrir);
FecharMenuBtn.addEventListener("click", Fechar);
Navbar.addEventListener("mouseleave", Fechar);
window.addEventListener("resize", Volta);

function Abrir() {
    if(Navbar.style.left == "-100%"){
        Navbar.style.left = "0";
    }
    else {
        Navbar.style.left = "-100%";
    }
}

function Fechar() {
    if (window.screen.width <= 992) {
        Navbar.style.left = "-100%";
    }
}

function Volta() {
    if (window.screen.width > 992) {
        Navbar.style.left = "0";
    }
}
