<div id="route-loader" class="transition-all duration-300">
    <svg width="56" height="56" viewBox="0 0 50 50" class="loader-spinner" style="animation:route-loader-spin 0.9s linear infinite;">
        <circle class="circle-bg" cx="25" cy="25" r="20" fill="none" stroke="#dbeafe" stroke-width="5"></circle>
        <circle class="circle-accent" cx="25" cy="25" r="20" fill="none" stroke="#2563eb" stroke-width="5" stroke-linecap="round"
            stroke-dasharray="90 40"></circle>
    </svg>
    <span class="loader-text" style="font-family:ui-sans-serif,system-ui,sans-serif;font-size:.95rem;color:#475569;">Memuat...</span>
</div>

<style>
    #route-loader {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 1rem;
        background: #ffffff;
        transition: opacity .3s ease, visibility .3s ease, background-color .2s ease;
    }

    /* Support Dark Mode untuk Loading Screen */
    html.dark #route-loader {
        background: #090d16 !important;
    }
    html.dark #route-loader .circle-bg {
        stroke: #1e293b !important;
    }
    html.dark #route-loader .circle-accent {
        stroke: #38bdf8 !important;
    }
    html.dark #route-loader .loader-text {
        color: #94a3b8 !important;
    }

    @keyframes route-loader-spin {
        to {
            transform: rotate(360deg);
        }
    }

    #route-loader[data-hidden="true"] {
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
    }
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
            if (isInternal && !isHash && !newTab) {
                loader.removeAttribute('data-hidden');
                // Jaring pengaman: kalau ternyata link ini gak beneran pindah halaman
                // (misal link download file/PDF), paksa loader hilang lagi setelah 4 detik.
                setTimeout(hide, 4000);
            }
        });

        document.addEventListener('submit', function () {
            loader.removeAttribute('data-hidden');
        });
    })();
</script>