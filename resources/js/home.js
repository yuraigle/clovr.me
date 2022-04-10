import "bootstrap/js/dist/dropdown.js";
import "bootstrap/js/dist/modal.js";

const elProp1 = document.getElementById('prop1');
const elCat1 = document.getElementById('cat1');

document.querySelectorAll('button.prop1').forEach(el => {
    el.addEventListener('click', () => setProp1(el.dataset.prop1));
})

document.querySelectorAll('button.cat1').forEach(el => {
    el.addEventListener('click', () => {
        const s = el.dataset.cat1;
        setCat1(s);

        document.getElementById('garage2').style.display = s === 'share' ? 'none' : 'block';
        if (s === 'share' && elProp1.value === 'garage') {
            setProp1('flat');
        }
    });
})

function setProp1(s) {
    document.querySelectorAll('.sp_prop1').forEach(el1 => el1.classList.add('d-none'));
    document.getElementById('prop1_' + s).classList.remove('d-none');
    elProp1.value = s;
}

function setCat1(s) {
    document.querySelectorAll('button.cat1').forEach(el1 => {
        if (el1.dataset.cat1 === s) {
            el1.classList.remove('btn-light');
            el1.classList.add('btn-dark');
        } else {
            el1.classList.remove('btn-dark');
            el1.classList.add('btn-light');
        }
    });
    elCat1.value = s;
}
