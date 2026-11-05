<?php

use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\AboutUsController as AdminAboutUsController;
use App\Http\Controllers\Admin\BranchController as AdminBranchController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DirectorController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\HeaderSlideController;
use App\Http\Controllers\Admin\HighlightController;
use App\Http\Controllers\Admin\KarirController as AdminKarirController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\PageHeaderController;
use App\Http\Controllers\Admin\PengaduanOnlineController as AdminPengaduanOnlineController;
use App\Http\Controllers\Admin\ProcurementController as AdminProcurementController;
use App\Http\Controllers\Admin\PublicationController as AdminPublicationController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KarirController;
use App\Http\Controllers\MediaInformasiController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PengaduanOnlineController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\ChatbotController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/tentang-kami', [AboutUsController::class, 'index'])->name('about-us.index');

Route::get('/media-informasi', [MediaInformasiController::class, 'index'])->name('media-informasi.index');
Route::get('/media-informasi/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/media-informasi/news/{slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/media-informasi/pengumuman', [AnnouncementController::class, 'index'])->name('announcements.index');
Route::get('/media-informasi/galeri', [GalleryController::class, 'index'])->name('galleries.index');
Route::get('/media-informasi/galeri/{gallery}', [GalleryController::class, 'show'])->name('galleries.show');
Route::get('/media-informasi/publikasi', [PublicationController::class, 'index'])->name('publications.index');
Route::get('/media-informasi/publikasi/{document}/download', [PublicationController::class, 'download'])->name('publications.download');

Route::get('/pengadaan', [ProcurementController::class, 'index'])->name('procurement.index');
Route::get('/pengadaan/dokumen/{document}/download', [ProcurementController::class, 'download'])->name('procurement.download');

Route::get('/hubungi-kami', [BranchController::class, 'index'])->name('branches.index');
Route::get('/hubungi-kami/data', [BranchController::class, 'json'])->name('branches.json');
Route::get('/tentang-kami/sejarah-data', [AboutUsController::class, 'historyJson'])->name('history.json');

Route::get('/karir', [KarirController::class, 'index'])->name('karir.index');
Route::get('/pengaduan-online', [PengaduanOnlineController::class, 'index'])->name('pengaduan-online.index');

Route::post('/chatbot', [ChatbotController::class, 'chat'])->name('chatbot.chat');

/*
|--------------------------------------------------------------------------
| AREA INTERNAL — /portal-internal
|--------------------------------------------------------------------------
*/
Route::prefix('portal-internal')->name('admin.')->group(function () {

    require __DIR__ . '/auth-internal.php';

    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('settings', [SettingsController::class, 'edit'])->name('settings.edit');
        Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');

        Route::get('highlights', [HighlightController::class, 'index'])->name('highlights.index');
        Route::post('highlights', [HighlightController::class, 'store'])->name('highlights.store');
        Route::put('highlights/{highlight}', [HighlightController::class, 'update'])->name('highlights.update');
        Route::delete('highlights/{highlight}', [HighlightController::class, 'destroy'])->name('highlights.destroy');

        // Tentang Kami
        Route::get('about-us', [AdminAboutUsController::class, 'edit'])->name('about-us.edit');
        Route::post('about-us', [AdminAboutUsController::class, 'update'])->name('about-us.update');
        Route::resource('history', \App\Http\Controllers\Admin\HistoryController::class)->except(['create', 'show', 'edit']);
        Route::resource('leadership-history', \App\Http\Controllers\Admin\LeadershipHistoryController::class)->except(['create', 'show', 'edit']);
        Route::get('directors', [DirectorController::class, 'index'])->name('directors.index');
        Route::post('directors', [DirectorController::class, 'store'])->name('directors.store');
        Route::post('directors/{director}', [DirectorController::class, 'update'])->name('directors.update');
        Route::delete('directors/{director}', [DirectorController::class, 'destroy'])->name('directors.destroy');

        // Media & Informasi (header sekarang otomatis dari News, gak ada input admin lagi)
        Route::resource('news', AdminNewsController::class)->except(['show']);

        Route::get('announcements', [AdminAnnouncementController::class, 'index'])->name('announcements.index');
        Route::get('announcements/create', [AdminAnnouncementController::class, 'create'])->name('announcements.create');
        Route::post('announcements', [AdminAnnouncementController::class, 'store'])->name('announcements.store');
        Route::get('announcements/{announcement}/edit', [AdminAnnouncementController::class, 'edit'])->name('announcements.edit');
        Route::put('announcements/{announcement}', [AdminAnnouncementController::class, 'update'])->name('announcements.update');
        Route::delete('announcements/{announcement}', [AdminAnnouncementController::class, 'destroy'])->name('announcements.destroy');
        Route::get('announcements/history', [AdminAnnouncementController::class, 'history'])->name('announcements.history');

        Route::get('galleries', [AdminGalleryController::class, 'index'])->name('galleries.index');
        Route::post('galleries', [AdminGalleryController::class, 'store'])->name('galleries.store');
        Route::get('galleries/{gallery}', [AdminGalleryController::class, 'show'])->name('galleries.show');
        Route::put('galleries/{gallery}', [AdminGalleryController::class, 'updateTitle'])->name('galleries.update');
        Route::post('galleries/{gallery}/photos', [AdminGalleryController::class, 'addPhotos'])->name('galleries.photos.add');
        Route::delete('galleries/{gallery}', [AdminGalleryController::class, 'destroy'])->name('galleries.destroy');
        Route::delete('gallery-photos/{photo}', [AdminGalleryController::class, 'destroyPhoto'])->name('galleries.photos.destroy');

        Route::get('publications', [AdminPublicationController::class, 'index'])->name('publications.index');
        Route::post('publications', [AdminPublicationController::class, 'store'])->name('publications.store');
        Route::get('publications/{publication}/edit', [AdminPublicationController::class, 'edit'])->name('publications.edit');
        Route::put('publications/{publication}', [AdminPublicationController::class, 'update'])->name('publications.update');
        Route::delete('publications/{publication}', [AdminPublicationController::class, 'destroy'])->name('publications.destroy');

        // Header generik buat sub-fitur (Galeri, Pengumuman, Publikasi)
        Route::get('page-header/{key}', [PageHeaderController::class, 'edit'])->name('page-headers.edit');
        Route::post('page-header/{key}', [PageHeaderController::class, 'update'])->name('page-headers.update');

        // Pengadaan (multi post)
        Route::get('procurement', [AdminProcurementController::class, 'index'])->name('procurement.index');
        Route::post('procurement/header', [AdminProcurementController::class, 'updateHeader'])->name('procurement.header.update');
        Route::get('procurement/create', [AdminProcurementController::class, 'create'])->name('procurement.create');
        Route::post('procurement', [AdminProcurementController::class, 'store'])->name('procurement.store');
        Route::get('procurement/{procurement}/edit', [AdminProcurementController::class, 'edit'])->name('procurement.edit');
        Route::put('procurement/{procurement}', [AdminProcurementController::class, 'update'])->name('procurement.update');
        Route::delete('procurement/{procurement}', [AdminProcurementController::class, 'destroy'])->name('procurement.destroy');
        Route::get('procurement/history', [AdminProcurementController::class, 'history'])->name('procurement.history');

        // Hubungi Kami / Cabang
        Route::get('branches', [AdminBranchController::class, 'index'])->name('branches.index');
        Route::get('branches/create', [AdminBranchController::class, 'create'])->name('branches.create');
        Route::post('branches', [AdminBranchController::class, 'store'])->name('branches.store');
        Route::get('branches/{branch}/edit', [AdminBranchController::class, 'edit'])->name('branches.edit');
        Route::put('branches/{branch}', [AdminBranchController::class, 'update'])->name('branches.update');
        Route::delete('branches/{branch}', [AdminBranchController::class, 'destroy'])->name('branches.destroy');
        Route::post('branches-header', [AdminBranchController::class, 'updateHeader'])->name('branches.header.update');

        Route::get('karir', [AdminKarirController::class, 'edit'])->name('karir.edit');
        Route::post('karir', [AdminKarirController::class, 'update'])->name('karir.update');
        Route::post('karir/posters', [AdminKarirController::class, 'storePoster'])->name('karir.posters.store');
        Route::delete('karir/posters/{poster}', [AdminKarirController::class, 'destroyPoster'])->name('karir.posters.destroy');
        Route::get('karir/history', [AdminKarirController::class, 'history'])->name('karir.history');

        Route::get('pengaduan-online', [AdminPengaduanOnlineController::class, 'edit'])->name('pengaduan-online.edit');
        Route::post('pengaduan-online', [AdminPengaduanOnlineController::class, 'update'])->name('pengaduan-online.update');

        Route::get('header-slides', [HeaderSlideController::class, 'index'])->name('header-slides.index');
        Route::get('header-slides/create', [HeaderSlideController::class, 'create'])->name('header-slides.create');
        Route::post('header-slides', [HeaderSlideController::class, 'store'])->name('header-slides.store');
        Route::delete('header-slides/{slide}', [HeaderSlideController::class, 'destroy'])->name('header-slides.destroy');
        Route::post('header-slides/{slide}/toggle', [HeaderSlideController::class, 'toggle'])->name('header-slides.toggle');

        /*
        |--------------------------------------------------------------------------
        | FITUR EKSKLUSIF SUPER ADMIN
        |--------------------------------------------------------------------------
        */
        Route::middleware(['role:superadmin'])->group(function () {
            // Log Activity (Audit Trail)
            Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
            Route::get('activity-logs/fetch', [ActivityLogController::class, 'fetchLogs'])->name('activity-logs.fetch');

            // Kelola Admin / Users Management
            Route::resource('users', UserManagementController::class)->except(['show']);
            Route::post('users/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('users.toggle-status');
        });
    });
});
