let href = location.href;

function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

if (isNumber(href.slice(-1))) {
    href = location.origin + '/pagination/page/1';
} else if (href.slice(-1) === '/') {
    href = href.slice(0, -1);
}

// Seleciona a página atual na barra de navegação
const navLink = document.querySelector(`.nav-link[href='${href}']`);

if (navLink) {
    navLink.classList.add('active')
}