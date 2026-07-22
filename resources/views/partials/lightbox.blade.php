<div id="lightboxModal" class="fixed inset-0 bg-black/95 z-[9999] hidden items-center justify-center" onclick="closeLightbox()">
    <button onclick="event.stopPropagation(); prevLightbox()" class="absolute left-3 sm:left-6 top-1/2 -translate-y-1/2 text-white/70 hover:text-white text-4xl w-12 h-12 flex items-center justify-center rounded-full hover:bg-white/10 transition">‹</button>

    <img id="lightboxImage" class="max-h-[88vh] max-w-[92vw] object-contain rounded-lg" onclick="event.stopPropagation()">

    <button onclick="event.stopPropagation(); nextLightbox()" class="absolute right-3 sm:right-6 top-1/2 -translate-y-1/2 text-white/70 hover:text-white text-4xl w-12 h-12 flex items-center justify-center rounded-full hover:bg-white/10 transition">›</button>

    <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white/70 hover:text-white text-3xl w-10 h-10 flex items-center justify-center rounded-full hover:bg-white/10 transition">×</button>
</div>

<script src="{{ asset('js/lightbox.js') }}"></script>
