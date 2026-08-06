/**
 * v2-transitions.js
 * Transisi halaman: fade-out halus sebelum pindah, fade-in halus pas halaman baru muncul,
 * plus splash loader singkat. Link download/file TIDAK ikut transisi (biar gak macet
 * kayak masalah loading-screen versi lama).
 */
(function () {
    var loader = document.getElementById('v2-loader');
    var body = document.body;

    function hideLoader() { if (loader) loader.setAttribute('data-hidden', 'true'); }

    window.addEventListener('load', function () { setTimeout(hideLoader, 200); });
    setTimeout(hideLoader, 3500);

    body.classList.add('page-enter');
    setTimeout(function () { body.classList.remove('page-enter'); }, 600);

    window.addEventListener('pageshow', function (e) {
        if (e.persisted) {
            if (loader) loader.removeAttribute('data-hidden');
            body.classList.remove('page-exit');
            setTimeout(hideLoader, 250);
        }
    });

    var FILE_EXT = /\.(pdf|docx?|xlsx?|pptx?|zip|rar|jpg|jpeg|png|gif|webp|mp4|mp3)($|\?)/i;

    document.addEventListener('click', function (e) {
        var a = e.target.closest('a[href]');
        if (!a) return;

        var href = a.getAttribute('href') || '';
        var isHash = href.startsWith('#');
        var isInternal = a.href && a.href.indexOf(window.location.origin) === 0;
        var newTab = a.target === '_blank' || e.metaKey || e.ctrlKey || e.shiftKey;
        var isFile = FILE_EXT.test(href) || a.hasAttribute('download');
        var isMailOrTel = href.startsWith('mailto:') || href.startsWith('tel:');

        if (!isInternal || isHash || newTab || isFile || isMailOrTel) return;

        e.preventDefault();
        if (loader) loader.removeAttribute('data-hidden');
        body.classList.add('page-exit');
        setTimeout(function () { window.location.href = a.href; }, 260);
        // jaring pengaman kalau ternyata navigasi gak terjadi
        setTimeout(hideLoader, 4000);
    });

    document.addEventListener('submit', function () {
        if (loader) loader.removeAttribute('data-hidden');
    });
})();