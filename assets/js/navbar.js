

const menuBtn = document.getElementById("menuBtn");
const mobileMenu = document.getElementById("mobileMenu");
const closeMenu = document.getElementById("closeMenu");

function openMenu() {
    mobileMenu.classList.remove("opacity-0", "pointer-events-none", "scale-95");
    mobileMenu.classList.add("opacity-100", "scale-100");
}

function closeMenuFunc() {
    mobileMenu.classList.add("opacity-0", "pointer-events-none", "scale-95");
    mobileMenu.classList.remove("opacity-100", "scale-100");
}

menuBtn.addEventListener("click", openMenu);
closeMenu.addEventListener("click", closeMenuFunc);

document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeMenuFunc();
});