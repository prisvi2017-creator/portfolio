// panneau pliable
const panel = document.querySelector(".panel");
const infos = document.querySelector(".infos");

infos.addEventListener("click", () => {
    panel.classList.toggle("active");
});
