// Dipakai di form admin yang butuh upload banyak gambar secara bertahap.
// Markup yang dibutuhkan (lihat contoh di admin/news/create.blade.php):
//   <div id="imagePreviewGrid" data-uploader="images"></div>
//   <input type="file" id="imagePicker_images" accept="image/*" multiple class="hidden">
//   <input type="file" id="imagesInput_images" name="images[]" multiple class="hidden">
//   <button type="button" data-add-image="images">+ Tambah Gambar</button>

function initMultiImageUploader(key) {
    let selectedFiles = [];
    const picker = document.getElementById('imagePicker_' + key);
    const realInput = document.getElementById('imagesInput_' + key);
    const grid = document.getElementById('imagePreviewGrid_' + key);
    const addBtn = document.querySelector('[data-add-image="' + key + '"]');

    if (!picker || !realInput || !grid || !addBtn) return;

    addBtn.addEventListener('click', () => picker.click());

    picker.addEventListener('change', () => {
        Array.from(picker.files).forEach(f => selectedFiles.push(f));
        picker.value = '';
        renderPreviews();
        syncInput();
    });

    function renderPreviews() {
        grid.innerHTML = '';
        selectedFiles.forEach((file, idx) => {
            const url = URL.createObjectURL(file);
            const div = document.createElement('div');
            div.className = 'relative group';
            div.innerHTML = `
                <img src="${url}" class="w-full h-24 object-cover rounded-lg border">
                <button type="button" data-idx="${idx}" class="removeImgBtn absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 text-sm leading-none shadow hover:bg-red-600 transition">×</button>`;
            grid.appendChild(div);
        });
        grid.querySelectorAll('.removeImgBtn').forEach(btn => {
            btn.addEventListener('click', () => {
                selectedFiles.splice(parseInt(btn.dataset.idx), 1);
                renderPreviews();
                syncInput();
            });
        });
    }

    function syncInput() {
        const dt = new DataTransfer();
        selectedFiles.forEach(f => dt.items.add(f));
        realInput.files = dt.files;
    }
}
