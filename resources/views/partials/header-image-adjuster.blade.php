@php
    $fieldName = $name ?? 'header_image';
    $idPrefix = 'hdr_adj_' . preg_replace('/[^a-zA-Z0-9_]/', '_', $fieldName);
    $currentImage = isset($content) && $content->{$fieldName} ? asset('storage/' . $content->{$fieldName}) : null;
    $labelTitle = $label ?? 'Gambar Header Halaman';
    $pageName = $pageTitle ?? ($label ?? 'Halaman');
@endphp

<div id="{{ $idPrefix }}_container" class="space-y-3">
    {{-- Label & Status Badge --}}
    <div class="flex items-center justify-between">
        <label class="block text-sm font-semibold text-slate-700">{{ $labelTitle }}</label>
        <span id="{{ $idPrefix }}_status_badge" class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
            <span class="w-1.5 h-1.5 rounded-full {{ $currentImage ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
            <span class="badge-text">{{ $currentImage ? 'Foto Terpasang' : 'Belum Ada Foto' }}</span>
        </span>
    </div>

    {{-- Form Preview Box (Panoramic Header Simulation) --}}
    <div class="relative w-full h-36 sm:h-44 rounded-xl overflow-hidden bg-slate-900 border border-slate-200 shadow-inner group">
        {{-- Preview Image --}}
        <img id="{{ $idPrefix }}_form_preview"
             src="{{ $currentImage ?: 'data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'800\' height=\'300\' fill=\'%230f172a\'><rect width=\'100%25\' height=\'100%25\'/><text x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' fill=\'%2364748b\' font-size=\'16\' font-family=\'sans-serif\'>Belum ada foto header</text></svg>' }}"
             class="w-full h-full object-cover transition-all duration-300 {{ $currentImage ? 'brightness-[0.7]' : 'opacity-60' }}">

        {{-- Overlay Simulation --}}
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent pointer-events-none flex flex-col justify-between p-4">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-medium tracking-wide uppercase px-2 py-0.5 rounded bg-black/40 text-slate-200 backdrop-blur border border-white/10">
                    Simulasi Header Website
                </span>
                <span id="{{ $idPrefix }}_crop_pill" class="text-[11px] text-slate-300 bg-black/40 px-2 py-0.5 rounded backdrop-blur border border-white/10">
                    Rasio Panoramic 16:6
                </span>
            </div>
            <div>
                <p class="text-white font-bold text-base sm:text-lg drop-shadow">{{ $pageName }}</p>
                <p class="text-slate-300 text-xs drop-shadow">Bagian foto ini yang akan terlihat oleh publik</p>
            </div>
        </div>

        {{-- Hover Button --}}
        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center pointer-events-none">
            <button type="button" onclick="{{ $idPrefix }}_openModal()" class="pointer-events-auto px-4 py-2 rounded-lg bg-white/95 hover:bg-white text-slate-800 font-semibold text-xs shadow-lg backdrop-blur flex items-center gap-2 transform group-hover:scale-105 transition-all">
                <svg class="w-4 h-4 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/></svg>
                Sesuaikan Tampilan
            </button>
        </div>
    </div>

    {{-- File Input & Button Bar --}}
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5">
        <div class="flex-1">
            <input type="file"
                   name="{{ $fieldName }}"
                   id="{{ $idPrefix }}_file"
                   accept="image/*"
                   class="w-full text-sm text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 transition file:cursor-pointer cursor-pointer border rounded-lg p-1 bg-slate-50">
        </div>
        <button type="button"
                id="{{ $idPrefix }}_btn_adjust"
                onclick="{{ $idPrefix }}_openModal()"
                class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-primary-600 text-white hover:bg-primary-700 text-xs font-semibold shadow-sm transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/></svg>
            Sesuaikan Tampilan
        </button>
    </div>
    <p class="text-[11px] text-slate-400">Pilih foto (JPG/PNG/WebP), lalu klik <strong>Sesuaikan Tampilan</strong> untuk menggeser foto (atas/tengah/bawah) agar pas secara otomatis tanpa merubah database.</p>

    {{-- ======================================================== --}}
    {{-- MODAL SESUAIKAN TAMPILAN HEADER (CANVAS AUTO-CROP) --}}
    {{-- ======================================================== --}}
    <div id="{{ $idPrefix }}_modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        {{-- Backdrop --}}
        <div class="fixed inset-0 bg-slate-900/75 backdrop-blur-sm transition-opacity" onclick="{{ $idPrefix }}_closeModal()"></div>

        <div class="flex min-h-full items-center justify-center p-3 sm:p-6 text-center">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-3xl border border-slate-200">
                
                {{-- Modal Header --}}
                <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-primary-100 text-primary-600 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-800" id="modal-title">Sesuaikan Bagian Tampilan Header</h3>
                            <p class="text-xs text-slate-500">Geser atau pilih posisi foto agar pas dan langsung dipotong otomatis tanpa perlu crop manual.</p>
                        </div>
                    </div>
                    <button type="button" onclick="{{ $idPrefix }}_closeModal()" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-200 transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- Modal Body --}}
                <div class="p-5 sm:p-6 space-y-5">
                    
                    {{-- Live Frame Preview with Drag Support --}}
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between text-xs text-slate-500">
                            <span class="font-medium text-slate-700">Preview Tampilan di Website (Live Header Frame):</span>
                            <span class="text-primary-600 font-semibold flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zm-7.518-.267A8.25 8.25 0 1120.25 10.5M8.288 14.212A5.25 5.25 0 1117.25 10.5"/></svg>
                                Bisa diklik & digeser langsung
                            </span>
                        </div>

                        <div id="{{ $idPrefix }}_drag_frame"
                             class="relative w-full h-52 sm:h-64 rounded-xl overflow-hidden bg-slate-900 border-2 border-primary-500/50 shadow-lg cursor-grab active:cursor-grabbing select-none">
                            {{-- Interactive Target Image --}}
                            <img id="{{ $idPrefix }}_modal_img"
                                 src="{{ $currentImage ?: '' }}"
                                 class="w-full h-full object-cover select-none pointer-events-none"
                                 style="object-position: 50% 50%;">

                            {{-- Website Header Overlay Simulation --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/25 to-black/30 pointer-events-none flex flex-col justify-between p-5">
                                <div class="flex justify-between items-start">
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-white/20 text-white backdrop-blur border border-white/20">
                                        Frame Header 16:6
                                    </span>
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-medium bg-black/50 text-emerald-300 backdrop-blur border border-emerald-500/30 flex items-center gap-1">
                                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                                        <span id="{{ $idPrefix }}_live_pos_text">50% 50%</span>
                                    </span>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-primary-300 uppercase tracking-wider mb-1">Perumdam Tirta Darma Ayu</p>
                                    <h4 class="text-xl sm:text-2xl font-bold text-white drop-shadow">{{ $pageName }}</h4>
                                    <p class="text-xs text-slate-200 mt-1 drop-shadow line-clamp-1">Simulasi hasil potongan foto yang akan disimpan sebagai header.</p>
                                </div>
                            </div>

                            {{-- Visual drag hint --}}
                            <div class="absolute bottom-2 right-2 pointer-events-none bg-black/60 text-white text-[10px] px-2 py-0.5 rounded backdrop-blur border border-white/10">
                                ✋ Geser foto ke atas / bawah
                            </div>
                        </div>
                    </div>

                    {{-- Quick Position Presets --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Pilihan Cepat Posisi Vertikal:</label>
                        <div class="grid grid-cols-3 sm:grid-cols-5 gap-2">
                            <button type="button" onclick="{{ $idPrefix }}_setPreset(50, 0)"
                                    class="{{ $idPrefix }}_preset_btn px-3 py-2 rounded-lg border text-xs font-semibold hover:border-primary-500 hover:bg-primary-50 transition flex flex-col items-center gap-1 text-slate-700">
                                <span class="text-base">⬆️</span>
                                <span>Fokus Atas</span>
                            </button>
                            <button type="button" onclick="{{ $idPrefix }}_setPreset(50, 25)"
                                    class="{{ $idPrefix }}_preset_btn px-3 py-2 rounded-lg border text-xs font-semibold hover:border-primary-500 hover:bg-primary-50 transition flex flex-col items-center gap-1 text-slate-700">
                                <span class="text-base">↗️</span>
                                <span>Agak Atas</span>
                            </button>
                            <button type="button" onclick="{{ $idPrefix }}_setPreset(50, 50)"
                                    class="{{ $idPrefix }}_preset_btn px-3 py-2 rounded-lg border text-xs font-semibold hover:border-primary-500 hover:bg-primary-50 transition flex flex-col items-center gap-1 text-slate-700">
                                <span class="text-base">⏺️</span>
                                <span>Tengah (Default)</span>
                            </button>
                            <button type="button" onclick="{{ $idPrefix }}_setPreset(50, 75)"
                                    class="{{ $idPrefix }}_preset_btn px-3 py-2 rounded-lg border text-xs font-semibold hover:border-primary-500 hover:bg-primary-50 transition flex flex-col items-center gap-1 text-slate-700">
                                <span class="text-base">↘️</span>
                                <span>Agak Bawah</span>
                            </button>
                            <button type="button" onclick="{{ $idPrefix }}_setPreset(50, 100)"
                                    class="{{ $idPrefix }}_preset_btn px-3 py-2 rounded-lg border text-xs font-semibold hover:border-primary-500 hover:bg-primary-50 transition flex flex-col items-center gap-1 text-slate-700">
                                <span class="text-base">⬇️</span>
                                <span>Fokus Bawah</span>
                            </button>
                        </div>
                    </div>

                    {{-- Precision Sliders --}}
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-4">
                        {{-- Vertical Slider (Y) --}}
                        <div>
                            <div class="flex justify-between items-center text-xs mb-1.5">
                                <span class="font-semibold text-slate-700 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"/></svg>
                                    Posisi Vertikal (Atas ↔ Bawah):
                                </span>
                                <span id="{{ $idPrefix }}_slider_y_val" class="font-bold text-primary-600 bg-white px-2 py-0.5 rounded border border-slate-200">50%</span>
                            </div>
                            <input type="range"
                                   id="{{ $idPrefix }}_slider_y"
                                   min="0" max="100" value="50"
                                   oninput="{{ $idPrefix }}_onSliderChange()"
                                   class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-primary-600">
                            <div class="flex justify-between text-[10px] text-slate-400 mt-1">
                                <span>0% (Tampilkan Bagian Paling Atas)</span>
                                <span>50% (Tengah)</span>
                                <span>100% (Tampilkan Bagian Paling Bawah)</span>
                            </div>
                        </div>

                        {{-- Horizontal Slider (X) --}}
                        <div>
                            <div class="flex justify-between items-center text-xs mb-1.5">
                                <span class="font-semibold text-slate-700 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"/></svg>
                                    Posisi Horizontal (Kiri ↔ Kanan):
                                </span>
                                <span id="{{ $idPrefix }}_slider_x_val" class="font-bold text-slate-600 bg-white px-2 py-0.5 rounded border border-slate-200">50%</span>
                            </div>
                            <input type="range"
                                   id="{{ $idPrefix }}_slider_x"
                                   min="0" max="100" value="50"
                                   oninput="{{ $idPrefix }}_onSliderChange()"
                                   class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-slate-600">
                            <div class="flex justify-between text-[10px] text-slate-400 mt-1">
                                <span>0% (Kiri)</span>
                                <span>50% (Tengah)</span>
                                <span>100% (Kanan)</span>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Modal Footer --}}
                <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-200 flex flex-col-reverse sm:flex-row items-center justify-between gap-2.5">
                    <span class="text-xs text-slate-400">💡 Foto akan dipotong otomatis dan langsung siap disimpan.</span>
                    <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                        <button type="button" onclick="{{ $idPrefix }}_closeModal()" class="w-full sm:w-auto px-4 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-100 text-xs font-semibold transition">
                            Batal
                        </button>
                        <button type="button" onclick="{{ $idPrefix }}_applyCropAndClose()" class="w-full sm:w-auto px-5 py-2 rounded-lg bg-primary-600 text-white hover:bg-primary-700 text-xs font-semibold shadow transition flex items-center justify-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            Terapkan Tampilan Ini
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
(function() {
    const prefix = '{{ $idPrefix }}';
    let posX = 50;
    let posY = 50;
    let isDragging = false;
    let dragStartX = 0;
    let dragStartY = 0;
    let dragStartPosX = 50;
    let dragStartPosY = 50;
    
    // Store original selected File and raw Image object for lossless canvas crop
    let activeImageObj = new Image();
    let originalFileSource = null;
    let originalFileName = 'header_image.jpg';

    // Elements
    const statusBadge = document.getElementById(prefix + '_status_badge');
    const formPreview = document.getElementById(prefix + '_form_preview');
    const fileInput = document.getElementById(prefix + '_file');
    const modal = document.getElementById(prefix + '_modal');
    const modalImg = document.getElementById(prefix + '_modal_img');
    const dragFrame = document.getElementById(prefix + '_drag_frame');
    const livePosText = document.getElementById(prefix + '_live_pos_text');
    const sliderX = document.getElementById(prefix + '_slider_x');
    const sliderY = document.getElementById(prefix + '_slider_y');
    const sliderXVal = document.getElementById(prefix + '_slider_x_val');
    const sliderYVal = document.getElementById(prefix + '_slider_y_val');

    // Load initial image if available
    const initialSrc = '{{ $currentImage }}';
    if (initialSrc) {
        activeImageObj.crossOrigin = "anonymous";
        activeImageObj.src = initialSrc;
    }

    function syncUI() {
        posX = Math.max(0, Math.min(100, Math.round(posX)));
        posY = Math.max(0, Math.min(100, Math.round(posY)));
        const posStr = `${posX}% ${posY}%`;
        modalImg.style.objectPosition = posStr;
        livePosText.textContent = posStr;
        sliderX.value = posX;
        sliderY.value = posY;
        sliderXVal.textContent = `${posX}%`;
        sliderYVal.textContent = `${posY}%`;
    }

    window[prefix + '_openModal'] = function() {
        if (!activeImageObj.src && (!fileInput.files || fileInput.files.length === 0)) {
            fileInput.click();
            return;
        }
        syncUI();
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };

    window[prefix + '_closeModal'] = function() {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    };

    window[prefix + '_setPreset'] = function(x, y) {
        posX = x;
        posY = y;
        syncUI();
    };

    window[prefix + '_onSliderChange'] = function() {
        posX = parseInt(sliderX.value) || 50;
        posY = parseInt(sliderY.value) || 50;
        syncUI();
    };

    // Drag support
    dragFrame.addEventListener('mousedown', function(e) {
        isDragging = true;
        dragStartX = e.clientX;
        dragStartY = e.clientY;
        dragStartPosX = posX;
        dragStartPosY = posY;
        e.preventDefault();
    });

    window.addEventListener('mousemove', function(e) {
        if (!isDragging) return;
        const deltaX = (e.clientX - dragStartX) / dragFrame.offsetWidth * 100;
        const deltaY = (e.clientY - dragStartY) / dragFrame.offsetHeight * 100;
        posX = Math.max(0, Math.min(100, dragStartPosX - deltaX));
        posY = Math.max(0, Math.min(100, dragStartPosY - deltaY));
        syncUI();
    });

    window.addEventListener('mouseup', function() {
        isDragging = false;
    });

    // Touch support
    dragFrame.addEventListener('touchstart', function(e) {
        if (e.touches.length === 1) {
            isDragging = true;
            dragStartX = e.touches[0].clientX;
            dragStartY = e.touches[0].clientY;
            dragStartPosX = posX;
            dragStartPosY = posY;
        }
    }, { passive: true });

    window.addEventListener('touchmove', function(e) {
        if (!isDragging || e.touches.length !== 1) return;
        const deltaX = (e.touches[0].clientX - dragStartX) / dragFrame.offsetWidth * 100;
        const deltaY = (e.touches[0].clientY - dragStartY) / dragFrame.offsetHeight * 100;
        posX = Math.max(0, Math.min(100, dragStartPosX - deltaX));
        posY = Math.max(0, Math.min(100, dragStartPosY - deltaY));
        syncUI();
    }, { passive: true });

    window.addEventListener('touchend', function() {
        isDragging = false;
    });

    // File Input change listener
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files && e.target.files[0];
        if (file) {
            originalFileSource = file;
            originalFileName = file.name;
            const reader = new FileReader();
            reader.onload = function(ev) {
                const imgData = ev.target.result;
                activeImageObj = new Image();
                activeImageObj.onload = function() {
                    formPreview.src = imgData;
                    formPreview.classList.remove('opacity-60');
                    formPreview.classList.add('brightness-[0.7]');
                    modalImg.src = imgData;
                    
                    // Auto-open modal so admin can adjust immediately!
                    setTimeout(() => {
                        window[prefix + '_openModal']();
                    }, 120);
                };
                activeImageObj.src = imgData;
            };
            reader.readAsDataURL(file);
        }
    });

    // CANVAS AUTO-CROP CORE: Crops the image to the exact 16:6 aspect ratio
    // focusing on (posX, posY) without needing any database migration!
    window[prefix + '_applyCropAndClose'] = function() {
        if (!activeImageObj.complete || activeImageObj.naturalWidth === 0) {
            window[prefix + '_closeModal']();
            return;
        }

        const natW = activeImageObj.naturalWidth;
        const natH = activeImageObj.naturalHeight;
        const targetAspect = 16 / 6; // Standard panoramic header ratio (approx 2.6667)
        const srcAspect = natW / natH;

        let cropW, cropH, cropX, cropY;

        if (srcAspect < targetAspect) {
            // Image is taller than the panoramic header (standard photo / portrait / square)
            cropW = natW;
            cropH = Math.round(natW / targetAspect);
            const maxScrollY = Math.max(0, natH - cropH);
            cropY = Math.round(maxScrollY * (posY / 100));
            cropX = 0;
        } else {
            // Image is wider than the panoramic header
            cropH = natH;
            cropW = Math.round(natH * targetAspect);
            const maxScrollX = Math.max(0, natW - cropW);
            cropX = Math.round(maxScrollX * (posX / 100));
            cropY = 0;
        }

        // Output canvas dimensions (preserve high crisp quality up to 1920x720)
        const outW = Math.min(1920, Math.max(1200, cropW));
        const outH = Math.round(outW / targetAspect);

        const canvas = document.createElement('canvas');
        canvas.width = outW;
        canvas.height = outH;
        const ctx = canvas.getContext('2d');

        // Draw cropped area into canvas
        ctx.drawImage(activeImageObj, cropX, cropY, cropW, cropH, 0, 0, outW, outH);

        // Convert canvas to Blob & assign into fileInput using DataTransfer
        canvas.toBlob(function(blob) {
            if (!blob) {
                window[prefix + '_closeModal']();
                return;
            }

            // Create clean File object
            const safeName = originalFileName.replace(/\.[^/.]+$/, "") + "_header.jpg";
            const croppedFile = new File([blob], safeName, { type: 'image/jpeg', lastModified: Date.now() });

            // Assign cropped file directly into input[type=file]
            const dt = new DataTransfer();
            dt.items.add(croppedFile);
            fileInput.files = dt.files;

            // Update form preview to cropped result
            const croppedDataUrl = canvas.toDataURL('image/jpeg', 0.92);
            formPreview.src = croppedDataUrl;
            formPreview.style.objectPosition = 'center center'; // Cropped image is already perfectly framed

            // Update badge
            if (statusBadge) {
                statusBadge.className = 'inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-300';
                statusBadge.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span><span>✅ Tampilan Disesuaikan (Siap Simpan)</span>';
            }

            // Close modal
            window[prefix + '_closeModal']();
        }, 'image/jpeg', 0.92);
    };

    syncUI();
})();
</script>
