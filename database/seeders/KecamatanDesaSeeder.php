<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use Illuminate\Database\Seeder;

class KecamatanDesaSeeder extends Seeder
{
    public function run(): void
    {
        // 31 kecamatan resmi Kabupaten Indramayu (sumber: Wikipedia/Kemendagri)
        $kecamatanNames = [
            'Anjatan', 'Arahan', 'Balongan', 'Bangodua', 'Bongas', 'Cantigi',
            'Cikedung', 'Gabuswetan', 'Gantar', 'Haurgeulis', 'Indramayu',
            'Jatibarang', 'Juntinyuat', 'Kandanghaur', 'Karangampel',
            'Kedokan Bunder', 'Kertasemaya', 'Krangkeng', 'Kroya', 'Lelea',
            'Lohbener', 'Losarang', 'Pasekan', 'Patrol', 'Sindang', 'Sliyeg',
            'Sukagumiwang', 'Sukra', 'Terisi', 'Tukdana', 'Widasari',
        ];

        // Desa per kecamatan — BARU TERISI untuk yang datanya sudah tervalidasi
        // dari sumber resmi. Sisanya sengaja dikosongkan (0 desa) supaya tidak
        // ada data ngasal; lengkapi lewat menu "Kelola Wilayah" di dashboard
        // Super Admin (portal-internal/wilayah).
        $desaData = [
            'Lohbener' => ['Bojongslawi', 'Kiajaran Kulon', 'Kiajaran Wetan', 'Langut', 'Lanjan', 'Larangan', 'Legok', 'Lohbener', 'Pamayahan', 'Rambatan Kulon', 'Sindangkerta', 'Waru'],
            'Sindang' => ['Babadan', 'Dermayu', 'Kenanga', 'Panyindangan Kulon', 'Panyindangan Wetan', 'Penganjang', 'Rambatan Wetan', 'Sindang', 'Terusan', 'Wanantara'],
            'Losarang' => ['Cemara Kulon', 'Jangga', 'Jumbleng', 'Krimun', 'Losarang', 'Muntur', 'Pangkalan', 'Pegagan', 'Puntang', 'Rajaiyang', 'Ranjeng', 'Santing'],
            'Lelea' => ['Tugu', 'Telagasari', 'Tempel', 'Cempeh', 'Lelea', 'Tamansari', 'Langgensari', 'Tunggulpayung', 'Tempel Kulon', 'Nunuk', 'Pangauban'],
        ];

        foreach ($kecamatanNames as $name) {
            $kecamatan = Kecamatan::create(['name' => $name]);

            if (isset($desaData[$name])) {
                foreach ($desaData[$name] as $desaName) {
                    $kecamatan->desas()->create(['name' => $desaName]);
                }
            }
        }
    }
}
