const elCover = document.querySelector("section.cover1");
const elDd = document.querySelector('button.dropdown-toggle');
const qs =document.querySelectorAll('[data-search]');

if (elCover) {
    elCover.style.backgroundImage = "url('/layout/cover_house.1666414708.webp')";

    qs.forEach(el => {
        el.addEventListener('click', function() {
            const [k, v] = el.dataset.search.split('-');
            document.querySelector(`[name=${k}]`).value = v;
            if (k === 'prop') {
                elCover.style.backgroundImage = `url('/layout/cover_${v}.1666414708.webp')`;
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
