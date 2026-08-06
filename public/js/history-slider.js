// History Timeline Slider - Pertamina Style
// Handles auto-play, progress indicator per year, year button switching, and responsive layout for mobile, tablet, desktop

document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('historySlider');
    if (!container) return;

    const slides = Array.from(container.querySelectorAll('.history-slide'));
    const labelsWrap = document.getElementById('historyLabels');
    if (slides.length === 0 || !labelsWrap) return;

    let current = 0;
    let progressInterval = null;
    let elapsed = 0;
    const defaultDuration = 7000; // 7 seconds per slide

    // Build Responsive Labels HTML
    labelsWrap.innerHTML = `
        <div class="flex items-center justify-center gap-2 sm:gap-4 md:gap-6 w-full max-w-6xl mx-auto px-2">
            <!-- Prev Arrow -->
            <button type="button" id="historyPrevBtn" class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-black/50 hover:bg-black/80 backdrop-blur-md text-white flex items-center justify-center shrink-0 border border-white/20 transition active:scale-95 shadow-lg">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </button>

            <!-- Year Buttons Container -->
            <div id="historyButtonsTrack" class="flex-1 flex items-center justify-start sm:justify-center gap-2 sm:gap-3 md:gap-4 overflow-x-auto no-scrollbar scroll-smooth py-2">
                ${slides.map((slide, i) => {
                    const year = slide.dataset.year || `Tahun ${i + 1}`;
                    return `
                        <button type="button" data-idx="${i}" class="history-year-btn group shrink-0 transition-all duration-300 py-1 px-2 sm:px-3 rounded-lg hover:bg-white/10 text-left">
                            <span class="history-year-text block text-xs sm:text-sm font-bold tracking-wide transition-colors text-white/60 group-hover:text-white whitespace-nowrap">
                                ${year}
                            </span>
                            <span class="block h-[3px] w-full bg-white/20 rounded-full overflow-hidden mt-1 sm:mt-1.5">
                                <span class="h-full block bg-sky-400 rounded-full history-progress-fill" data-idx="${i}" style="width:0%"></span>
                            </span>
                        </button>`;
                }).join('')}
            </div>

            <!-- Next Arrow -->
            <button type="button" id="historyNextBtn" class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-black/50 hover:bg-black/80 backdrop-blur-md text-white flex items-center justify-center shrink-0 border border-white/20 transition active:scale-95 shadow-lg">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
    `;

    const fills = Array.from(labelsWrap.querySelectorAll('.history-progress-fill'));
    const yearBtns = Array.from(labelsWrap.querySelectorAll('.history-year-btn'));
    const prevBtn = document.getElementById('historyPrevBtn');
    const nextBtn = document.getElementById('historyNextBtn');
    const buttonsTrack = document.getElementById('historyButtonsTrack');

    yearBtns.forEach((btn, i) => {
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

    function updateResponsiveView(activeIndex) {
        const isMobile = window.innerWidth < 640;

        yearBtns.forEach((btn, i) => {
            const txt = btn.querySelector('.history-year-text');
            if (isMobile) {
                // Mobile: toggle active item highlight & scroll active item into view
                if (i === activeIndex) {
                    btn.classList.remove('hidden');
                    btn.classList.add('block');
                    txt.classList.remove('text-white/60');
                    txt.classList.add('text-white', 'scale-105', 'font-black');
                    btn.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                } else {
                    txt.classList.remove('text-white', 'scale-105', 'font-black');
                    txt.classList.add('text-white/60');
                }
            } else {
                // Desktop / Tablet: show all side-by-side
                btn.classList.remove('hidden');
                btn.classList.add('block');
                if (i === activeIndex) {
                    txt.classList.remove('text-white/60');
                    txt.classList.add('text-white', 'font-black');
                } else {
                    txt.classList.remove('text-white', 'font-black');
                    txt.classList.add('text-white/60');
                }
            }
        });
    }

    window.addEventListener('resize', () => updateResponsiveView(current));

    function showSlide(index) {
        current = index;

        slides.forEach((s, i) => {
            if (i === index) {
                s.classList.remove('hidden', 'opacity-0');
                s.classList.add('block', 'opacity-100');
            } else {
                s.classList.add('hidden', 'opacity-0');
                s.classList.remove('block', 'opacity-100');
            }
        });

        fills.forEach((f, i) => {
            f.style.transition = 'none';
            f.style.width = i < index ? '100%' : '0%';
        });

        updateResponsiveView(index);

        elapsed = 0;
        const duration = parseFloat(slides[index].dataset.duration || defaultDuration);
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

    // Initialize first slide (awal menampilkan tahun paling pertama terlebih dahulu)
    showSlide(0);
});
