// Lightbox global — dipanggil dari mana aja: openLightbox([urls], startIndex)
let __lbImages = [];
let __lbIndex = 0;

function openLightbox(images, index = 0) {
    __lbImages = images;
    __lbIndex = index;
    const modal = document.getElementById('lightboxModal');
    const img = document.getElementById('lightboxImage');
    if (!modal || !img) return;
    img.src = __lbImages[__lbIndex];
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    const modal = document.getElementById('lightboxModal');
    if (!modal) return;
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
}

function prevLightbox() {
    __lbIndex = (__lbIndex - 1 + __lbImages.length) % __lbImages.length;
    document.getElementById('lightboxImage').src = __lbImages[__lbIndex];
}

function nextLightbox() {
    __lbIndex = (__lbIndex + 1) % __lbImages.length;
    document.getElementById('lightboxImage').src = __lbImages[__lbIndex];
}

document.addEventListener('keydown', function (e) {
    const modal = document.getElementById('lightboxModal');
    if (!modal || modal.classList.contains('hidden')) return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowLeft') prevLightbox();
    if (e.key === 'ArrowRight') nextLightbox();
});

// Auto-rotate preview gambar di card (sebelum diklik) — dipakai di semua listing
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.auto-rotate-images').forEach(function (container) {
        let images = [];
        try { images = JSON.parse(container.dataset.images || '[]'); } catch (e) { return; }
        if (images.length <= 1) return;

        const imgEl = container.querySelector('.rotate-img');
        if (!imgEl) return;

        let idx = 0;
        setInterval(function () {
            idx = (idx + 1) % images.length;
            imgEl.style.opacity = 0;
            setTimeout(function () {
                imgEl.src = images[idx];
                imgEl.style.opacity = 1;
            }, 200);
        }, 2500);
    });
});
