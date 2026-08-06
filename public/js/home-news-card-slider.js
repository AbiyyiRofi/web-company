// Kartu berita di beranda: fade otomatis antar berita terbaru
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('homeNewsCard');
    if (!container) return;

    const slides = Array.from(container.querySelectorAll('.home-news-slide'));
    if (slides.length <= 1) return;

    let current = 0;

    function show(index) {
        slides.forEach((s, i) => {
            const active = i === index;
            s.classList.toggle('opacity-100', active);
            s.classList.toggle('opacity-0', !active);
            s.classList.toggle('z-10', active);
            s.classList.toggle('z-0', !active);
            s.classList.toggle('pointer-events-none', !active);
        });
        current = index;
    }

    setInterval(() => show((current + 1) % slides.length), 4000);
});