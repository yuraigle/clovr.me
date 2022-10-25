const elProp1 = document.getElementById("prop1");
const elCat1 = document.getElementById("cat1");
const elCover = document.querySelectorAll("section.cover1")[0];

elCover.style.backgroundImage = "url('/layout/cover_house.1666414703.webp')";
// elCover.style.backgroundImage += ", url('/layout/cover_flat.1666414703.webp')";
// elCover.style.backgroundImage += ", url('/layout/cover_garage.1666414703.webp')";

document.querySelectorAll("button.prop1").forEach((el) => {
    el.addEventListener("click", () => setProp1(el.dataset.prop1));
});

document.querySelectorAll("button.cat1").forEach((el) => {
    el.addEventListener("click", () => {
        const s = el.dataset.cat1;
        setCat1(s);

        document.getElementById("garage2").style.display =
            s === "share" ? "none" : "block";
        if (s === "share" && elProp1.value === "garage") {
            setProp1("flat");
        }
    });
});

function setProp1(s) {
    document
        .querySelectorAll(".sp_prop1")
        .forEach((el1) => el1.classList.add("d-none"));
    document.getElementById("prop1_" + s).classList.remove("d-none");
    elProp1.value = s;
    elCover.style.backgroundImage = `url('/layout/cover_${s}.1666414703.webp')`;
}

function setCat1(s) {
    document.querySelectorAll("button.cat1").forEach((el1) => {
        if (el1.dataset.cat1 === s) {
            el1.classList.remove("btn-light");
            el1.classList.add("btn-dark");
        } else {
            el1.classList.remove("btn-dark");
            el1.classList.add("btn-light");
        }
    });
    elCat1.value = s;
}
