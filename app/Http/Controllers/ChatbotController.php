<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Branch;
use App\Models\News;
use App\Models\Director;
use App\Models\AboutUsContent;
use App\Models\Announcement;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'array',
        ]);

        $userMessage = $request->input('message');
        $history = $request->input('history', []);

        $systemPrompt = <<<PROMPT
Kamu adalah Asisten Virtual Resmi PERUMDAM TIRTA DARMA AYU Kabupaten Indramayu (nama perusahaan sudah resmi berubah dari "PDAM" menjadi "PERUMDAM Tirta Darma Ayu" — JANGAN PERNAH sebut "PDAM" saja, selalu sebut "PERUMDAM Tirta Darma Ayu" atau boleh disingkat "Perumdam TDA").

=== INFORMASI WEBSITE (statis, tidak perlu tool) ===
- Halaman "Karir": ada tombol yang kalau diklik menampilkan info lowongan kerja, penerimaan pegawai baru, open recruitment, dan info pengembangan karir di Perumdam TDA.
- Halaman "Pengadaan": ada tombol yang kalau diklik menampilkan info pengadaan/lelang barang & jasa Perumdam TDA. CATATAN: user WAJIB mendaftar sebagai member terlebih dahulu sebelum bisa mengakses info pengadaan tersebut.
- Tombol "Cek Tagihan" di website: membawa user ke halaman/link cek tagihan yang juga bisa langsung dipakai untuk bayar tagihan di situ juga. Link ini terhubung dengan sistem yang sama dengan aplikasi Banyu Digital.

=== APLIKASI BANYU DIGITAL (statis, tidak perlu tool) ===
Banyu Digital adalah aplikasi resmi PERUMDAM Tirta Darma Ayu Kabupaten Indramayu, tersedia gratis di Google Play Store. Fungsinya:
1. Pengaduan online pelanggan (misal: air mati, air keruh, pipa bocor, dll).
2. Pembayaran tagihan air.
3. Cek tagihan.
4. Monitoring/pemantauan penggunaan air pelanggan.

ATURAN ARAH JAWABAN untuk topik pengaduan/pembayaran/cek tagihan:
- Jika user bertanya CARA melakukan pengaduan online, ATAU cara membayar tagihan → arahkan untuk mengunduh aplikasi **Banyu Digital** di Play Store, karena fitur itu paling lengkap tersedia di sana.
- Jika user HANYA ingin cek tagihan saja → beri 2 opsi: (a) klik tombol "Cek Tagihan" di website, atau (b) gunakan aplikasi Banyu Digital.
- Jika ada keluhan teknis air (mati/keruh/bocor) → arahkan ke fitur Pengaduan Online, baik lewat web (jika relevan) maupun aplikasi Banyu Digital.

=== BAHASA ===
Kamu WAJIB paham Bahasa Indonesia dan juga Bahasa Indramayu (dialek Jawa yang dipakai masyarakat Kabupaten Indramayu), yang punya 2 tingkatan:
- **Ngoko**: bahasa sehari-hari, agak kasar/santai, umum dipakai anak muda.
- **Krama**: bahasa halus/sopan, biasanya dipakai orang tua, sudah jarang dipakai tapi tetap harus dipahami.
User mungkin mencampur Bahasa Indonesia dengan Bahasa Indramayu (ngoko/krama) dalam satu kalimat. Kamu harus tetap memahami maksudnya dan merespons secara natural — boleh sesekali membalas dengan sentuhan Bahasa Indramayu yang sopan agar terasa akrab dengan warga Indramayu, TAPI untuk data faktual (nama direktur, alamat, tanggal, dll) tetap sampaikan dalam Bahasa Indonesia yang jelas supaya tidak ambigu.

=== TUGAS UTAMA (butuh tool/database) ===
- Profil, sejarah, visi-misi Perumdam TDA → panggil tool get_company_profile. Contoh pemicu: "sejarah PDAM/Perumdam gimana", "ceritain awal mula perusahaan", "visi misi apa".
- Jajaran direksi/pemilik modal → panggil tool get_directors. Contoh pemicu: "siapa direktur", "siapa pemilik modal".
- Lokasi & jam kantor cabang → panggil tool get_branches. Contoh pemicu: "kantor cabang dimana", "alamat kantor", "jam operasional".
- Berita/kegiatan terbaru → panggil tool get_latest_news. Contoh pemicu: "berita terbaru", "kegiatan apa aja", "ada info terkini gak".
- Pengumuman resmi → panggil tool get_announcements. Contoh pemicu: "ada pengumuman gak", "info resmi terbaru".

ATURAN KETAT (WAJIB DIPATUHI):
1. Jawab ramah dan profesional. Boleh pakai emoji secukupnya.
2. SELALU panggil tool yang relevan dulu untuk data faktual, sebelum menjawab. JANGAN pernah mengarang nama orang, alamat, telepon, atau tanggal.
3. Kalau ada tool yang cocok dengan pertanyaan, WAJIB dipanggil — jangan menjawab dari asumsi sendiri.
4. Kalau tool sudah dipanggil tapi datanya kosong, katakan jujur data belum tersedia — JANGAN mengarang.
5. JANGAN PERNAH menjawab pertanyaan di luar topik Perumdam Tirta Darma Ayu (politik, resep masakan, coding, hiburan, tokoh publik lain, dll). Tolak dengan sopan dan arahkan kembali ke layanan Perumdam TDA.
6. Jangan pernah mengaku sebagai OpenAI/ChatGPT/Groq/model AI tertentu. Kamu adalah Asisten Virtual Perumdam Tirta Darma Ayu.
7. Jawaban singkat, padat, jelas. Hindari paragraf terlalu panjang.
PROMPT;

        $messages = array_merge(
            [['role' => 'system', 'content' => $systemPrompt]],
            $history,
            [['role' => 'user', 'content' => $userMessage]]
        );

        $tools = [
            [
                'type' => 'function',
                'function' => [
                    'name' => 'get_branches',
                    'description' => 'Mendapatkan daftar semua kantor cabang Perumdam Tirta Darma Ayu beserta alamat, telepon, dan jam operasional.',
                    'parameters' => ['type' => 'object', 'properties' => new \stdClass()],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'get_latest_news',
                    'description' => 'Mendapatkan berita atau kegiatan terbaru dari Perumdam Tirta Darma Ayu.',
                    'parameters' => ['type' => 'object', 'properties' => new \stdClass()],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'get_announcements',
                    'description' => 'Mendapatkan pengumuman resmi terbaru dari Perumdam Tirta Darma Ayu.',
                    'parameters' => ['type' => 'object', 'properties' => new \stdClass()],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'get_directors',
                    'description' => 'Mendapatkan daftar direksi dan pemilik modal Perumdam Tirta Darma Ayu, termasuk nama dan jabatan.',
                    'parameters' => ['type' => 'object', 'properties' => new \stdClass()],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'get_company_profile',
                    'description' => 'Mendapatkan profil perusahaan: sejarah, visi, dan misi Perumdam Tirta Darma Ayu.',
                    'parameters' => ['type' => 'object', 'properties' => new \stdClass()],
                ],
            ],
        ];

        try {
            $reply = $this->askGroq($messages, $tools);
            return response()->json(['reply' => $reply]);
        } catch (\Exception $e) {
            Log::error('Chatbot error: ' . $e->getMessage());
            return response()->json([
                'reply' => 'Maaf, saya sedang mengalami gangguan sistem sementara. Coba beberapa saat lagi, ya! 🙏'
            ], 500);
        }
    }

    private function askGroq(array $messages, array $tools, int $depth = 0)
    {
        if ($depth > 3) {
            return 'Maaf, terjadi kendala saat memproses permintaan Anda. Silakan coba pertanyaan lain.';
        }

        $response = Http::withToken(env('GROQ_API_KEY'))
            ->timeout(45)
            ->retry(2, 500, throw: false)
            ->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.3-70b-versatile',
                'messages' => $messages,
                'tools' => $tools,
                'tool_choice' => 'auto',
                'temperature' => 0.3,
            ]);

        if ($response->failed()) {
            Log::error('Groq API error: ' . $response->status() . ' - ' . $response->body());
            throw new \Exception('Groq API request failed: ' . $response->status());
        }

        $data = $response->json();
        $choice = $data['choices'][0]['message'] ?? null;

        if (!$choice) {
            throw new \Exception('Format respons Groq tidak sesuai');
        }

        if (!empty($choice['tool_calls'])) {
            $messages[] = $choice;

            foreach ($choice['tool_calls'] as $toolCall) {
                $functionName = $toolCall['function']['name'];
                $functionResult = $this->runTool($functionName);

                $messages[] = [
                    'role' => 'tool',
                    'tool_call_id' => $toolCall['id'],
                    'content' => $functionResult,
                ];
            }

            return $this->askGroq($messages, $tools, $depth + 1);
        }

        return $choice['content'] ?? 'Maaf, saya belum bisa memproses pertanyaan itu.';
    }

    private function runTool(string $functionName): string
    {
        return match ($functionName) {
            'get_branches' => $this->getBranchesData(),
            'get_latest_news' => $this->getLatestNewsData(),
            'get_announcements' => $this->getAnnouncementsData(),
            'get_directors' => $this->getDirectorsData(),
            'get_company_profile' => $this->getCompanyProfileData(),
            default => 'Data tidak ditemukan.',
        };
    }

    private function getBranchesData(): string
    {
        $branches = Branch::orderByDesc('is_head_office')->get();
        if ($branches->isEmpty()) return 'Data cabang belum tersedia.';

        $text = "Daftar Cabang Perumdam Tirta Darma Ayu:\n";
        foreach ($branches as $b) {
            $type = $b->is_head_office ? '[KANTOR PUSAT]' : '[KANTOR CABANG]';
            $text .= "- {$type} {$b->name}. Alamat: {$b->address}. Telp: {$b->phone}. Jam: {$b->operational_hours}\n";
        }
        return $text;
    }

    private function getLatestNewsData(): string
    {
        $news = News::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->take(5)
            ->get();

        if ($news->isEmpty()) return 'Saat ini tidak ada berita terbaru.';

        $text = "5 Berita Terbaru:\n";
        foreach ($news as $n) {
            $excerpt = str($n->content)->stripTags()->limit(150);
            $text .= "- Judul: '{$n->title}'. Ringkasan: {$excerpt}. Tanggal: {$n->published_at->format('d M Y')}\n";
        }
        return $text;
    }

    private function getAnnouncementsData(): string
    {
        $announcements = Announcement::active()->latest()->take(5)->get();
        if ($announcements->isEmpty()) return 'Saat ini tidak ada pengumuman resmi terbaru.';

        $text = "5 Pengumuman Resmi Terbaru:\n";
        foreach ($announcements as $a) {
            $desc = str($a->description)->stripTags()->limit(150);
            $text .= "- Judul: '{$a->title}'. Isi: {$desc}. Tanggal: {$a->created_at->format('d M Y')}\n";
        }
        return $text;
    }

    private function getDirectorsData(): string
    {
        $direksi = Director::direksi()->orderBy('sort_order')->get();
        $pemilikModal = Director::pemilikModal()->orderBy('sort_order')->get();

        $text = "Jajaran Direksi Perumdam Tirta Darma Ayu:\n";
        if ($direksi->isEmpty()) {
            $text .= "- Data direksi belum tersedia.\n";
        } else {
            foreach ($direksi as $d) {
                $text .= "- {$d->name}, menjabat sebagai {$d->position}.\n";
            }
        }

        if ($pemilikModal->isNotEmpty()) {
            $text .= "\nPemilik Modal:\n";
            foreach ($pemilikModal as $p) {
                $text .= "- {$p->name}, {$p->position}.\n";
            }
        }

        return $text;
    }

    private function getCompanyProfileData(): string
    {
        $about = AboutUsContent::singleton();

        $sejarah = $about->sejarah_text ? str($about->sejarah_text)->stripTags() : 'Belum tersedia.';
        $visi = $about->visi_text ? str($about->visi_text)->stripTags() : 'Belum tersedia.';
        $misi = $about->misi_text ? str($about->misi_text)->stripTags() : 'Belum tersedia.';

        return "Sejarah:\n{$sejarah}\n\nVisi:\n{$visi}\n\nMisi:\n{$misi}";
    }
}