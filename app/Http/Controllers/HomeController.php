<?php

namespace App\Http\Controllers;

use App\Models\AboutUsContent;
use App\Models\Announcement;
use App\Models\Branch;
use App\Models\Director;
use App\Models\Highlight;
use App\Models\HomeHeaderSlide;
use App\Models\HubungiKamiContent;
use App\Models\KarirContent;
use App\Models\News;
use App\Models\PageHeader;
use App\Models\ProcurementContent;

class HomeController extends Controller
{
    public function index()
    {
        $slides = HomeHeaderSlide::active()->get();
        $aboutUs = AboutUsContent::singleton();
        $highlights = Highlight::ordered();
        $latestNews = News::with('images')
            ->latest('published_at')
            ->take(5)
            ->get();

        $latestAnnouncements = Announcement::active()->latest()->take(5)->get();
        $totalBranches = Branch::count();

        // Direktur Utama diambil otomatis dari data Direksi (bukan input manual)
        $direkturUtama = Director::direksi()->where('position', 'like', '%utama%')->orderBy('sort_order')->first()
            ?? Director::direksi()->orderBy('sort_order')->first();

        // Caption tiap sub-halaman Media & Informasi, dipakai di kartu menu beranda
        $pengumumanHeader = PageHeader::get('pengumuman');
        $galeriHeader = PageHeader::get('galeri');
        $publikasiHeader = PageHeader::get('publikasi');

        // Foto header + caption tiap halaman, dipakai di kartu Pengadaan/Hubungi Kami/Karir
        $procurementContent = ProcurementContent::singleton();
        $hubungiKamiContent = HubungiKamiContent::singleton();
        $karirContent = KarirContent::singleton();

        $quickLinks = [
            [
                'label' => 'Pengadaan',
                'title' => 'Info Pengadaan Barang & Jasa',
                'caption' => $procurementContent->header_caption,
                'image' => $procurementContent->header_image,
                'route' => route('procurement.index'),
            ],
            [
                'label' => 'Hubungi Kami',
                'title' => 'Temukan Cabang Layanan Terdekat',
                'caption' => $hubungiKamiContent->header_caption,
                'image' => $hubungiKamiContent->header_image,
                'route' => route('branches.index'),
            ],
            [
                'label' => 'Karir',
                'title' => 'Bergabung Bersama Kami',
                'caption' => $karirContent->header_caption,
                'image' => $karirContent->header_image,
                'route' => route('karir.index'),
            ],
        ];

        return view('home.index', compact(
            'slides', 'aboutUs', 'highlights', 'latestNews', 'latestAnnouncements', 'totalBranches',
            'direkturUtama', 'pengumumanHeader', 'galeriHeader', 'publikasiHeader', 'quickLinks'
        ));
    }
}