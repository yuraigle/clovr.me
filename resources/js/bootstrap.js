import axios from 'axios';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.showToast = function (content, color = "danger") {
    const id = 'toast_' + new Date().getTime() + '_' + Math.floor(Math.random() * 100);
    document.querySelector(".toast-container").innerHTML += `
    <div class="toast bg-${color} text-white fade show" id="${id}" role="alert">
        <div class="d-flex">
            <div class="toast-body">${content}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto"
                onclick="document.getElementById('${id}').remove()"></button>
        </div>
    </div>
    `;

    setTimeout(() => {
        const el = document.getElementById(id);
        if (el) el.remove();
    }, 3000);
};

window.showToast2 = function ({msg, bg}) {
    showToast(msg, bg);
};

window.showError = function (err) {
    const msg = err.response.data.message ? err.response.data.message : err;
    showToast(msg, 'danger');
}

for (let el of document.querySelectorAll('[data-bg], img[data-src]')) {
    if (el.hasAttribute('data-bg')) {
        el.style.backgroundImage = "url('" + el.getAttribute('data-bg') + "')";
    } else if (el.hasAttribute('data-src')) {
        el.setAttribute("src", el.getAttribute('data-src'));
    }
}
