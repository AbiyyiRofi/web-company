# 🌟 Ringkasan Pembaruan Tampilan & Animasi

Website resmi **PERUMDAM Tirta Darma Ayu** telah diperbarui dengan sentuhan gaya desain modern, tipografi premium, serta animasi interaksi halus. Pembaruan ini dirancang untuk memberikan user experience (UX) tingkat tinggi untuk pengguna publik dan mempermudah keterbacaan data.

---

## 🛠 Detail Perubahan & Peningkatan Visual

### 1. Tipografi & Font Premium
* **Sebelumnya**: Menggunakan font default bawaan browser (Sans-Serif/Inter standar).
* **Sekarang**: Diintegrasikan secara resmi dengan font **Plus Jakarta Sans** dari Google Fonts, yang ditanamkan langsung pada file konfigurasi Tailwind di layout utama (`layouts/app.blade.php`). Memberikan tampilan yang lebih bersih, ramping, dan profesional.

### 2. Animasi Masuk (Scroll-Animation via AOS)
Kami menanamkan perpustakaan animasi **AOS (Animate on Scroll)** pada footer layout utama. Sekarang, setiap elemen pada website akan memijar/bergeser dengan halus saat pengguna menggulir ke bawah:
* **Fade Right & Fade Left**: Digunakan untuk section pembanding (informasi di kiri, kartu stat/list interaktif di kanan).
* **Staggered Fade Up**: Digunakan pada daftar berita, kartu laporan, kartu dokumen, dan daftar cabang pelayanan sehingga elemen muncul berurutan (delay bervariasi) saat tampak di layar.

### 3. Layout Header Baru (Gradient Banner)
Semua sub-halaman publik kini dilengkapi dengan bilah header premium dengan latar belakang gradasi biru gelap (`bg-gradient-to-r from-primary-800 to-primary-900`):
* [Profil Perusahaan](file:///c:/laragon/www/PERUMDAM-TIRTA-DARMA-AYU/resources/views/pages/profil.blade.php)
* [Hubungi Kami / Kontak](file:///c:/laragon/www/PERUMDAM-TIRTA-DARMA-AYU/resources/views/pages/kontak.blade.php)
* [Berita & Pengumuman](file:///c:/laragon/www/PERUMDAM-TIRTA-DARMA-AYU/resources/views/news/index.blade.php)
* [Laporan Kegiatan](file:///c:/laragon/www/PERUMDAM-TIRTA-DARMA-AYU/resources/views/reports/index.blade.php)
* [Dokumen Publik](file:///c:/laragon/www/PERUMDAM-TIRTA-DARMA-AYU/resources/views/documents/index.blade.php)
* [Peta Cabang Layanan](file:///c:/laragon/www/PERUMDAM-TIRTA-DARMA-AYU/resources/views/branches/index.blade.php)

Header ini dipadukan dengan overlay melingkar bergaya glassmorphism halus di atasnya untuk memberikan kedalaman visual yang premium.

### 4. Efek Interaktif (Hover Feedback)
* **Image Zoom**: Gambar cover pada daftar berita terbungkus dalam bingkai `overflow-hidden` dan akan otomatis melakukan sedikit perbesaran (`scale-105 transition-transform duration-500`) saat disorot kursor.
* **Elevated Cards**: Kartu-kartu data pada halaman navigasi cepat, laporan, dokumen, dan kontak akan bergeser ke atas (`-translate-y-1.5`) dan menampilkan bayangan pekat (`shadow-xl hover:border-primary-500`) secara dinamis saat disentuh mouse.
* **Modern Circular Badges**: Icon-icon emoji kini memiliki wadah melingkar khusus berkelir lembut yang berubah warna menjadi solid saat disorot.

### 5. Peta Cabang Layanan Interaktif
* Elemen Peta Leaflet [Peta Cabang Layanan](file:///c:/laragon/www/PERUMDAM-TIRTA-DARMA-AYU/resources/views/branches/index.blade.php) telah dibundel dengan sudut membulat pekat (`rounded-2xl`).
* Sidebar daftar cabang memiliki *custom scrollbar* yang tipis dan modern, senada dengan skema warna biru dan kelabu.
* Balon popup pada peta Leaflet dihias ulang agar tajam dengan font yang serasi.

---

## 📂 Daftar File yang Diperbarui

| No | File | Deskripsi Perubahan |
|---|---|---|
| 1 | [app.blade.php](file:///c:/laragon/www/PERUMDAM-TIRTA-DARMA-AYU/resources/views/layouts/app.blade.php) | Memasang Google Font, script Tailwind configuration baru, font family extension, dan AOS library. |
| 2 | [index.blade.php](file:///c:/laragon/www/PERUMDAM-TIRTA-DARMA-AYU/resources/views/home/index.blade.php) | Restrukturisasi visual hero, statistik, daftar berita, navigasi cepat, efek hover, dan AOS stagger. |
| 3 | [profil.blade.php](file:///c:/laragon/www/PERUMDAM-TIRTA-DARMA-AYU/resources/views/pages/profil.blade.php) | Desain banner, visibilitas visi-misi unggulan, perbaikan timeline sejarah BUMD. |
| 4 | [kontak.blade.php](file:///c:/laragon/www/PERUMDAM-TIRTA-DARMA-AYU/resources/views/pages/kontak.blade.php) | Transisi kartu kontak cabang, tombol peta koordinat baru. |
| 5 | [index.blade.php (News)](file:///c:/laragon/www/PERUMDAM-TIRTA-DARMA-AYU/resources/views/news/index.blade.php) | Filter pencarian, visualisasi list postingan, cover hover effect. |
| 6 | [show.blade.php (News)](file:///c:/laragon/www/PERUMDAM-TIRTA-DARMA-AYU/resources/views/news/show.blade.php) | Margin artikel, typography tulisan utama, and saran artikel terkait. |
| 7 | [index.blade.php (Reports)](file:///c:/laragon/www/PERUMDAM-TIRTA-DARMA-AYU/resources/views/reports/index.blade.php) | Baris list download, file indicators, tombol unduh modern. |
| 8 | [index.blade.php (Documents)](file:///c:/laragon/www/PERUMDAM-TIRTA-DARMA-AYU/resources/views/documents/index.blade.php) | Baris list regulasi publik, kategori badge. |
| 9 | [index.blade.php (Branches)](file:///c:/laragon/www/PERUMDAM-TIRTA-DARMA-AYU/resources/views/branches/index.blade.php) | Layout peta 2/3 halaman, scrollbar dinamis, border marker trigger. |
