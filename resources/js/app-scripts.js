import "bootstrap/js/dist/collapse.js";

window.csrf = function () {
    return document.querySelector('meta[name="csrf-token"]').content;
};

let numToasts = 0;
window.showToast = function (content, color = "danger") {
    document.querySelector(".toast-container").innerHTML += `
    <div class="toast bg-${color} text-white fade show" id="toast_${++numToasts}" role="alert">
        <div class="d-flex">
            <div class="toast-body">${content}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto"
                onclick="document.getElementById('toast_${numToasts}').remove()"></button>
        </div>
    </div>
    `;

    setTimeout(
        () => document.getElementById("toast_" + numToasts).remove(),
        3000
    );
};

window.fetchApi = function (
    url,
    opts,
    _success = () => {
    },
    _finally = () => {
    }
) {
    return fetch(url, opts)
        .then((r) => r.json().then((d) => ({status: r.status, body: d})))
        .then((result) => {
            if (result.status !== 200 && result.body.message) {
                return showToast(result.body.message);
            } else if (result.status !== 200 || result.body.status !== "OK") {
                return showToast("Something went wrong");
            }
            _success(result.body);
        })
        .catch((err) => {
            console.error(err);
            return showToast("Something went wrong");
        })
        .finally(() => _finally());
};
