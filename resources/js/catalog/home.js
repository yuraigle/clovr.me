import "@/js/bootstrap";
import "bootstrap/js/src/modal";
import "bootstrap/js/src/dropdown";

const elCover = document.querySelector("section.cover1");
const elDd = document.querySelector('button.dropdown-toggle');
const qs = document.querySelectorAll('[data-search]');

if (elCover) {
    qs.forEach(el => {
        el.addEventListener('click', function () {
            const [k, v] = el.dataset.search.split('-');
            document.querySelector(`[name=${k}]`).value = v;
            if (k === 'prop') {
                elCover.style.backgroundImage = elCover.style.backgroundImage
                    .replace(/cover_[a-z]+\./, `cover_${v}.`);
                elDd.innerHTML = el.innerHTML;
            }
            if (k === 'cat') {
                qs.forEach(el1 => {
                    el1.classList.remove('btn-dark', 'btn-light');
                    el1.classList.add(el1 === el ? 'btn-dark' : 'btn-light');
                });
            }
        })
    })
}
