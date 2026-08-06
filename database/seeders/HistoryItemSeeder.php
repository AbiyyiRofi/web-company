<?php

namespace Database\Seeders;

use App\Models\HistoryItem;
use Illuminate\Database\Seeder;

class HistoryItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'year' => '1932',
                'title' => 'Sistem Penyediaan Air Minum (SPAM)',
                'content' => "Sistem Penyediaan Air Minum (SPAM) di Kabupaten Indramayu ada sejak Tahun 1932, dibangun Instalasi Pengolahan Air Minum (IPA) oleh Pemerintah Belanda dengan Kapasitas 20 liter/detik, dengan sumber air baku dari saluran irigasi Sindupraja. Pemakai air masih terbatas dari kalangan tertentu dan penjajah Belanda.",
                'sort_order' => 1,
            ],
            [
                'year' => '1945',
                'title' => 'Penyerahan Pengelolaan Air Minum',
                'content' => "Tahun 1945, Pengelolaan Air Minum diserahkan dari Pemerintah Belanda kepada pemerintah Indonesia dan dikelola oleh Dinas Air Minum (DAM) Kabupaten Daerah Tingkat II Indramayu.",
                'sort_order' => 2,
            ],
            [
                'year' => '1978',
                'title' => 'Pembangunan IPA Kapasitas 70 L/Detik',
                'content' => "Tahun 1978, dibangun Instalasi Pengolahan Air (IPA) Kapasitas 70 liter/detik yang dikelola oleh Badan Pengelola Air Minum (BPAM) Kabupaten Indramayu.",
                'sort_order' => 3,
            ],
            [
                'year' => '1981',
                'title' => 'Penyatuan Pengelolaan Air Minum',
                'content' => "Tahun 1981, Untuk menghindari dualisme pengelolaan air minum di Kabupaten Indramayu diterbitkan SK Bupati Kepala Daerah Tingkat II Indramayu Nomor: 45/HK-002.010/SK/1981 Tanggal 1 April 1981 tentang Penyatuan Pengelolaan Air Minum Indramayu dalam Badan Pengelola Air Minum (BPAM).",
                'sort_order' => 4,
            ],
            [
                'year' => '1985',
                'title' => 'Pendirian Perusahaan Daerah Air Minum (PDAM)',
                'content' => "Tahun 1985, Berdasarkan Peraturan Daerah Kabupaten Indramayu Nomor 08 Tahun 1985 tentang Pendirian Perusahaan Daerah Air Minum Kabupaten Indramayu dan Surat Keputusan Bersama Menteri Pekerjaan Umum dan Menteri Dalam Negeri Republik Indonesia Nomor:552/KPTS/1988, tanggal 17 November 1988 dilakukan penyerahan lanjutan Pengelolaan Badan Pengelola Air Minum (BPAM) Kabupaten Indramayu dan sarana prasarananya Kepada Gubernur Kepala Daerah Tingkat 1 Jawa Barat, yang kemudian diserahkan kepada Bupati Kepala Daerah Tingkat II Indramayu, untuk dikembangkan statusnya menjadi Perusahaan Daerah Air Minum (PDAM).",
                'sort_order' => 5,
            ],
            [
                'year' => '2008',
                'title' => 'Penetapan Nama PDAM Tirta Darma Ayu',
                'content' => "Tahun 2008, berdasarkan Peraturan Daerah Kabupaten Indramayu Nomor 15 Tahun 2008, ditetapkan nama PDAM yaitu Perusahaan Daerah Air Minum Tirta Darma Ayu Kabupaten Indramayu.",
                'sort_order' => 6,
            ],
            [
                'year' => '2019',
                'title' => 'Penyesuaian Menjadi PERUMDAM Tirta Darma Ayu',
                'content' => "Tahun 2019, sesuai perkembangan berdasarkan Peraturan Pemerintah RI Nomor 54 Tahun 2017 tentang Badan Usaha Milik Daerah, perlu penyesuaian bentuk Badan Usaha/Perusahaan. Maka berdasarkan peraturan Daerah Kabupaten Indramayu Nomor 7 Tahun 2019 tanggal 23 Desember 2019, status badan usaha PDAM disesuaikan menjadi Perusahaan Umum Daerah Air Minum Tirta Darma Ayu Kabupaten Indramayu.",
                'sort_order' => 7,
            ],
        ];

        foreach ($items as $item) {
            HistoryItem::updateOrCreate(['year' => $item['year']], $item);
        }
    }
}
