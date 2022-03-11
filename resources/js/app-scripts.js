import "../css/app-styles.css";

document
    .getElementsByClassName("navbar-toggler")[0]
    .addEventListener("click", function () {
        document.getElementById("navbar1").classList.toggle("show");
    });
