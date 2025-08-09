document.querySelector("#hamburger").addEventListener("click", (e) => {
    e.currentTarget.classList.toggle("menu-is-open");
    document.getElementById("header-logo").classList.toggle("menu-is-open");
    document.getElementById("header-form").classList.toggle("menu-is-open");
});
