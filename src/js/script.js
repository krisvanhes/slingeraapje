function redirectWithDelay(delay) {
    var timer = setTimeout(function () {
        window.location = '/'
    }, delay);
}

function redirectAdmin() {
    window.location = '/admin';
}