/**
 * v2-reveal.js
 * Semua elemen dengan class "reveal" otomatis muncul dengan animasi
 * "jatuh dari atas" secara beruntun (staggered), baik pas halaman
 * pertama kali dibuka maupun pas di-scroll ke bagian baru.
 *
 * Cara pakai di blade: cukup tambahkan class="reveal" ke elemen apa pun.
 * Kalau beberapa elemen ada dalam 1 wadah dengan atribut data-reveal-group,
 * mereka otomatis dikasih jeda bertahap (elemen ke-2 nyusul ke-1, dst).
 */
(function () {
    function applyStagger(container) {
        var items = container.querySelectorAll(':scope > .reveal, :scope .reveal:not([data-reveal-nested])');
        var groups = container.hasAttribute('data-reveal-group') ? items : container.querySelectorAll(':scope > .reveal');
        var list = container.querySelectorAll('.reveal');
        list.forEach(function (el, i) {
            if (el.style.getPropertyValue('--reveal-delay')) return;
            var localIndex = 0;
            var siblings = el.parentElement ? Array.prototype.filter.call(el.parentElement.children, function (c) {
                return c.classList && c.classList.contains('reveal');
            }) : [];
            localIndex = siblings.indexOf(el);
            var delay = Math.min(localIndex, 6) * 0.09;
            el.style.setProperty('--reveal-delay', delay + 's');
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-reveal-group]').forEach(applyStagger);
        document.querySelectorAll('.reveal').forEach(function (el, i) {
            if (!el.style.getPropertyValue('--reveal-delay')) {
                var siblings = el.parentElement ? Array.prototype.filter.call(el.parentElement.children, function (c) {
                    return c.classList && c.classList.contains('reveal');
                }) : [];
                var idx = siblings.indexOf(el);
                el.style.setProperty('--reveal-delay', (Math.min(idx, 6) * 0.09) + 's');
            }
        });

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -60px 0px' });

        document.querySelectorAll('.reveal').forEach(function (el) {
            observer.observe(el);
        });
    });
})();