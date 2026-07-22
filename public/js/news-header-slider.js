// Slider header Media & Informasi - isinya SELURUH berita Perumdam TDA News,
// auto-geser + bisa manual pake tombol prev/next.
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('newsHeaderSlider');
    if (!container) return;

    const slides = Array.from(container.querySelectorAll('.news-header-slide'));
    if (slides.length === 0) return;

    let current = 0;
    let autoTimer = null;

    function show(index) {
        slides.forEach((s, i) => s.classList.toggle('hidden', i !== index));
        current = index;
    }

    function next() { show((current + 1) % slides.length); }
    function prev() { show((current - 1 + slides.length) % slides.length); }

    function resetAuto() {
        clearInterval(autoTimer);
        if (slides.length > 1) autoTimer = setInterval(next, 5000);
    }

    document.getElementById('newsHeaderNext')?.addEventListener('click', () => { next(); resetAuto(); });
    document.getElementById('newsHeaderPrev')?.addEventListener('click', () => { prev(); resetAuto(); });

    show(0);
    resetAuto();
});
