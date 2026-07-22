<div id="route-loader" style="position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:1rem;background:#ffffff;transition:opacity .3s ease,visibility .3s ease;">
    <svg width="56" height="56" viewBox="0 0 50 50" style="animation:route-loader-spin 0.9s linear infinite;">
        <circle cx="25" cy="25" r="20" fill="none" stroke="#dbeafe" stroke-width="5"></circle>
        <circle cx="25" cy="25" r="20" fill="none" stroke="#2563eb" stroke-width="5" stroke-linecap="round" stroke-dasharray="90 40"></circle>
    </svg>
    <span style="font-family:ui-sans-serif,system-ui,sans-serif;font-size:.95rem;color:#475569;">Memuat...</span>
</div>

<style>
    @keyframes route-loader-spin { to { transform: rotate(360deg); } }
    #route-loader[data-hidden="true"] { opacity: 0; visibility: hidden; pointer-events: none; }
</style>

<script>
    (function () {
        var loader = document.getElementById('route-loader');
        if (!loader) return;

        function hide() { loader.setAttribute('data-hidden', 'true'); }

        window.addEventListener('load', function () { setTimeout(hide, 150); });
        setTimeout(hide, 3000); // fallback kalau load lambat

        window.addEventListener('pageshow', function (e) {
            if (e.persisted) { loader.removeAttribute('data-hidden'); setTimeout(hide, 200); }
        });

        document.addEventListener('click', function (e) {
            var a = e.target.closest('a[href]');
            if (!a) return;
            var isInternal = a.href && a.href.indexOf(window.location.origin) === 0;
            var isHash = (a.getAttribute('href') || '').startsWith('#');
            var newTab = a.target === '_blank' || e.metaKey || e.ctrlKey || e.shiftKey;
            if (isInternal && !isHash && !newTab) loader.removeAttribute('data-hidden');
        });

        document.addEventListener('submit', function () {
            loader.removeAttribute('data-hidden');
        });
    })();
</script>