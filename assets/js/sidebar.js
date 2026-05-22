const sidebar = document.getElementById("sidebar");
const openBtn = document.getElementById("openSidebar");
const closeBtn = document.getElementById("closeSidebar");
const overlay = document.getElementById("overlay");

// OPEN SIDEBAR
openBtn?.addEventListener("click", () => {
    sidebar.classList.remove("-translate-x-full");
    overlay.classList.remove("hidden");
});

// CLOSE SIDEBAR
function closeSidebar() {
    sidebar.classList.add("-translate-x-full");
    overlay.classList.add("hidden");
}

closeBtn?.addEventListener("click", closeSidebar);
overlay?.addEventListener("click", closeSidebar);