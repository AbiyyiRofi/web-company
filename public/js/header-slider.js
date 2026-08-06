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

    // Responsive structure: prev button + single active label container for mobile + full grid for desktop
    labelsWrap.innerHTML = `
        <div class="flex items-center justify-center gap-2 sm:gap-6 w-full max-w-xl sm:max-w-6xl mx-auto">
            <!-- Prev Arrow -->
            <button type="button" id="sliderPrevBtn" class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-black/40 hover:bg-black/70 backdrop-blur-md text-white flex items-center justify-center shrink-0 border border-white/20 transition active:scale-95">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </button>

            <!-- Slide Labels Container -->
            <div id="sliderLabelsInner" class="flex-1 flex justify-center gap-3 sm:gap-6 overflow-hidden">
                ${slides.map((slide, i) => {
        const title = slide.dataset.title || `Slide ${i + 1}`;
        return `
                        <button type="button" data-idx="${i}" class="slider-label-btn text-left group shrink-0 w-full sm:w-40 transition-all duration-300">
                            <span class="slider-title-box flex items-center justify-center sm:justify-start h-8 sm:h-10 mb-1.5 sm:mb-2 text-center sm:text-left">
                                <span class="slider-label-text block text-xs sm:text-sm font-semibold line-clamp-1 sm:line-clamp-2 leading-snug transition-colors text-white"></span>
                            </span>
                            <span class="block h-[3px] w-full bg-white/25 rounded-full overflow-hidden">
                                <span class="h-full block bg-sky-400 rounded-full progress-fill" data-idx="${i}" style="width:0%"></span>
                            </span>
                        </button>`;
    }).join('')}
            </div>

            <!-- Next Arrow -->
            <button type="button" id="sliderNextBtn" class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-black/40 hover:bg-black/70 backdrop-blur-md text-white flex items-center justify-center shrink-0 border border-white/20 transition active:scale-95">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
    `;

    const fills = Array.from(labelsWrap.querySelectorAll('.progress-fill'));
    const labelBtns = Array.from(labelsWrap.querySelectorAll('.slider-label-btn'));
    const prevBtn = document.getElementById('sliderPrevBtn');
    const nextBtn = document.getElementById('sliderNextBtn');

    labelBtns.forEach((btn, i) => {
        const title = slides[i].dataset.title || `Slide ${i + 1}`;
        btn.querySelector('.slider-label-text').textContent = title;
        btn.addEventListener('click', () => {
            clearInterval(progressInterval);
            showSlide(i);
        });
    });

    if (prevBtn) {
        prevBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            clearInterval(progressInterval);
            const prevIdx = (current - 1 + slides.length) % slides.length;
            showSlide(prevIdx);
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            clearInterval(progressInterval);
            const nextIdx = (current + 1) % slides.length;
            showSlide(nextIdx);
        });
    }

    function updateResponsiveLabels(activeIndex) {
        const isMobile = window.innerWidth < 640;

        prevBtn?.classList.toggle('hidden', !isMobile);
        nextBtn?.classList.toggle('hidden', !isMobile);

        labelBtns.forEach((btn, i) => {
            const txt = btn.querySelector('.slider-label-text');
            if (isMobile) {
                // On mobile, show only active item full width
                btn.classList.toggle('hidden', i !== activeIndex);
                btn.classList.toggle('block', i === activeIndex);
                txt.classList.add('text-white');
            } else {
                // On desktop/tablet, show all side-by-side
                btn.classList.remove('hidden');
                btn.classList.add('block');
                txt.classList.toggle('text-white', i === activeIndex);
                txt.classList.toggle('text-white/60', i !== activeIndex);
            }
        });
    }

    window.addEventListener('resize', () => updateResponsiveLabels(current));

    function showSlide(index) {
        current = index;
        slides.forEach((s, i) => s.classList.toggle('hidden', i !== index));
        fills.forEach((f, i) => {
            f.style.transition = 'none';
            f.style.width = i < index ? '100%' : '0%';
        });
        updateResponsiveLabels(index);

        const video = slides[index].querySelector('video');
        if (video) {
            video.currentTime = 0;
            video.play().catch(() => { });
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
                const nextIdx = (index + 1) % slides.length;
                showSlide(nextIdx);
            }
        }, 100);
    }

    showSlide(0);
});
