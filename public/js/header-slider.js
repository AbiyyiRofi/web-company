// Header poster carousel — versi label per-slide (mirip referensi Pertamina),
// warna biru terang biar kebaca, bukan merah.
// Markup dibutuhkan: #headerSlider (.header-slide[data-duration]), #sliderLabels

document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('headerSlider');
    if (!container) return;

    const slides = Array.from(container.querySelectorAll('.header-slide'));
    const labelsWrap = document.getElementById('sliderLabels');
    if (slides.length === 0) return;

    let current = 0;
    let progressInterval = null;
    let elapsed = 0;

    // bikin label + progress bar per slide — lebar SERAGAM (gak ngikutin panjang teks/durasi)
    labelsWrap.innerHTML = slides.map((slide, i) => {
        const title = slide.dataset.title || `Slide ${i + 1}`;
        return `
            <button type="button" data-idx="${i}" class="slider-label-btn text-left group shrink-0 w-28 sm:w-40">
                <span class="slider-title-box flex items-end h-8 sm:h-10 mb-2">
                    <span class="slider-label-text block text-xs sm:text-sm font-medium line-clamp-2 leading-snug transition-colors">${title}</span>
                </span>
                <span class="block h-[3px] w-full bg-white/25 rounded-full overflow-hidden">
                    <span class="h-full block bg-sky-400 rounded-full progress-fill" data-idx="${i}" style="width:0%"></span>
                </span>
            </button>`;
    }).join('');

    const fills = Array.from(labelsWrap.querySelectorAll('.progress-fill'));
    const labelTexts = Array.from(labelsWrap.querySelectorAll('.slider-label-text'));
    const labelBtns = Array.from(labelsWrap.querySelectorAll('.slider-label-btn'));

    labelBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            clearInterval(progressInterval);
            showSlide(parseInt(btn.dataset.idx));
        });
    });

    function updateLabelStyles(activeIndex) {
        labelTexts.forEach((el, i) => {
            el.classList.toggle('text-white', i === activeIndex);
            el.classList.toggle('text-white/60', i !== activeIndex);
        });
    }

    function showSlide(index) {
        slides.forEach((s, i) => s.classList.toggle('hidden', i !== index));
        fills.forEach((f, i) => {
            f.style.transition = 'none';
            f.style.width = i < index ? '100%' : '0%';
        });
        updateLabelStyles(index);

        const video = slides[index].querySelector('video');
        if (video) {
            video.currentTime = 0;
            video.play().catch(() => {});
        }

        elapsed = 0;
        const duration = parseFloat(slides[index].dataset.duration) * 1000;
        clearInterval(progressInterval);

        progressInterval = setInterval(() => {
            elapsed += 100;
            const pct = Math.min((elapsed / duration) * 100, 100);
            fills[index].style.transition = 'width 0.1s linear';
            fills[index].style.width = pct + '%';

            if (elapsed >= duration) {
                clearInterval(progressInterval);
                current = (index + 1) % slides.length;
                showSlide(current);
            }
        }, 100);
    }

    showSlide(0);
});
