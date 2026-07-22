<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            ['name' => 'Kantor Pusat', 'address' => 'Jl. Letjend. Suprapto No.25/E, Kepandean, Indramayu', 'phone' => '(0234) 271311', 'lat' => -6.3269, 'lng' => 108.3200, 'head' => true],
            ['name' => 'Cabang Pelayanan Indramayu Kota', 'address' => 'Jl. Tanjungpura No.197, Kepandean, Indramayu', 'phone' => '(0234) 271576', 'lat' => -6.3275, 'lng' => 108.3215, 'head' => false],
            ['name' => 'Cabang Pelayanan Sindang', 'address' => 'Jl. Singalodra, Sindang, Indramayu', 'phone' => '(0234) 277654', 'lat' => -6.3399, 'lng' => 108.3097, 'head' => false],
            ['name' => 'Cabang Pelayanan Lohbener', 'address' => 'Jl. Simpang Tiga Celeng, Lohbener, Indramayu', 'phone' => '(0234) 276930', 'lat' => -6.3717, 'lng' => 108.2833, 'head' => false],
            ['name' => 'Cabang Pelayanan Karangampel', 'address' => 'Jl. Raya Juntinyuat, Karangampel, Indramayu', 'phone' => '087717926643', 'lat' => -6.3893, 'lng' => 108.3897, 'head' => false],
            ['name' => 'Cabang Pelayanan Kedokan Bunder', 'address' => 'Jl. Raya Kedokan Bunder, Kertasemaya, Indramayu', 'phone' => '(0234) 8112425471', 'lat' => -6.4459, 'lng' => 108.2965, 'head' => false],
            ['name' => 'Cabang Pelayanan Jatibarang', 'address' => 'Jl. Letnan Joni No.69, Jatibarang, Indramayu', 'phone' => '(0234) 351491', 'lat' => -6.4536, 'lng' => 108.2593, 'head' => false],
            ['name' => 'Cabang Pelayanan Kandanghaur', 'address' => 'Jl. Raya Karangsinom, Gabuswetan, Kandanghaur, Indramayu', 'phone' => '(0234) 505423', 'lat' => -6.3616, 'lng' => 108.0942, 'head' => false],
            ['name' => 'Cabang Pelayanan Patrol', 'address' => 'Jl. Raya Limpas, Patrol, Indramayu', 'phone' => '(0234) 610338', 'lat' => -6.3167, 'lng' => 108.0167, 'head' => false],
            ['name' => 'Cabang Pelayanan Bangodua', 'address' => 'Jl. Raya Sukaperna, Bangodua, Indramayu', 'phone' => '(0234) 356400', 'lat' => -6.4936, 'lng' => 108.2661, 'head' => false],
            ['name' => 'Cabang Pelayanan Losarang', 'address' => 'Jl. Raya Puntang, Losarang, Indramayu', 'phone' => '(0234) 505394', 'lat' => -6.3333, 'lng' => 108.0500, 'head' => false],
            ['name' => 'Cabang Pelayanan Gabuswetan (Saradan)', 'address' => 'Jl. Raya PU Saradan, Gabuswetan, Indramayu', 'phone' => '(0234) 505816', 'lat' => -6.4667, 'lng' => 108.1333, 'head' => false],
            ['name' => 'Cabang Pelayanan Balongan', 'address' => 'Jl. Raya Sukaurip, Balongan, Indramayu', 'phone' => '(0234) 429515', 'lat' => -6.3667, 'lng' => 108.3833, 'head' => false],
            ['name' => 'Cabang Pelayanan Jatisawit', 'address' => 'Jl. Raya Jatisawit, Jatisawit, Indramayu', 'phone' => '(0234) 352673', 'lat' => -6.4300, 'lng' => 108.2400, 'head' => false],
            ['name' => 'Cabang Pelayanan Arahan', 'address' => 'Jl. Raya Arahan - Linggajati, Arahan, Indramayu', 'phone' => null, 'lat' => -6.3167, 'lng' => 108.2667, 'head' => false],
        ];

        foreach ($branches as $b) {
            Branch::create([
                'name' => $b['name'],
                'address' => $b['address'],
                'phone' => $b['phone'],
                'whatsapp' => null,
                'latitude' => $b['lat'],
                'longitude' => $b['lng'],
                'operational_hours' => 'Senin–Jumat, 07.30–16.00 WIB',
                'is_head_office' => $b['head'],
            ]);
        }
    }
}
