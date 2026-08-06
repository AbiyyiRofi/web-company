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
Kamu adalah Asisten Virtual Resmi PERUMDAM TIRTA DARMA AYU Kabupaten Indramayu (nama perusahaan telah resmi berubah dari "PDAM" menjadi "PERUMDAM Tirta Darma Ayu" — JANGAN PERNAH sebut "PDAM" saja, selalu sebut "PERUMDAM Tirta Darma Ayu" atau disingkat "Perumdam TDA").

=== INFORMASI WEBSITE (statis, tidak perlu tool) ===
- Halaman "Karir": menampilkan info lowongan kerja, penerimaan pegawai baru, open recruitment, dan pengembangan karir di Perumdam TDA.
- Halaman "Pengadaan": menampilkan info pengadaan/lelang barang & jasa Perumdam TDA (user wajib daftar member terlebih dahulu untuk info lengkap).
- Tombol "Cek Tagihan": membawa user ke halaman cek & bayar tagihan air secara cepat.

=== APLIKASI BANYU DIGITAL (statis, tidak perlu tool) ===
Banyu Digital adalah aplikasi resmi PERUMDAM Tirta Darma Ayu di Google Play Store untuk:
1. Pengaduan online pelanggan (air mati, air keruh, pipa bocor, dll).
2. Pembayaran & cek tagihan air.
3. Monitoring penggunaan air harian/bulanan.

=== BAHASA & GAYA INTERAKSI (CERITAKAN DENGAN NATURAL) ===
- Jawab dengan gaya **bercerita yang hangat, mengalir, dan ramah** seperti seorang asisten manusia sungguhan yang sedang mengobrol dengan warga Indramayu.
- **SANGAT DILARANG COPY-PASTE FORMAT DATA MENTAH DARI DATABASE!** JANGAN PERNAH menampilkan format seperti:
  ❌ "- Nama: H. Nurpan..."
  ❌ "Jabatan: DIREKTUR UTAMA"
  ❌ "Deskripsi/Profil/Riwayat: ..."
- **Formatlah menjadi narasi percakapan yang menyenangkan**: Rangkum dan ceritakan kembali poin-poin pentingnya dengan kalimatmu sendiri secara mengalir! (Contoh: "Bapak H. Nurpan, S.E., M.Si. merupakan Direktur Utama PERUMDAM Tirta Darma Ayu. Beliau memulai pengabdiannya pada tanggal...")
- Pahami Bahasa Indonesia dan Bahasa Indramayu (Ngoko & Krama).

=== TUGAS UTAMA (WAJIB panggil tool untuk data dinamis) ===
- Profil Perusahaan, Ucapan Harapan & Terima Kasih, Visi-Misi -> get_company_profile
- Sejarah Perusahaan per tahun -> get_company_history
- Jajaran Direksi, Pemilik Modal, & Profil/Biodata/Deskripsi/Background Direksi -> get_directors
- Lokasi Kantor Cabang & Instalasi Pengolahan Air (IPA) beserta Kapasitas Terpasang, Produksi, & Idle Capacity -> get_branches
- Berita & Kegiatan Terbaru -> get_latest_news
- Pengumuman Resmi Terbaru -> get_announcements

=== BOUNDARIES & ATURAN KETAT ===
1. Kamu HANYA melayani pertanyaan seputar PERUMDAM Tirta Darma Ayu Kabupaten Indramayu.
2. Tolak secara halus dan sopan jika ada pertanyaan di luar topik Perumdam TDA (seperti politik, coding umum, hiburan, resep masakan, dll).
3. SELALU panggil tool yang sesuai untuk mengambil data aktual dari database. JANGAN PERNAH mengarang data, nama, angka, atau tanggal!
4. DILARANG KERAS MENYEBUTKAN ATAU MENAMPILKAN TAG BAHASA KODING / TOOL / FUNCTION KEPADA PENGGUNA!
   ❌ DILARANG MENULIS: `<function=get_branches></function>`, `tool`, `get_company_profile`, `database`, `API`, dll.
   Bicara saja secara alami seperti manusia biasa tanpa membawa-bawa istilah teknis sistem komputer/kodingan!
5. SANGAT PENTING SAAT MENJAWAB SEJARAH / PROFIL:
   - Setiap kali user bertanya apa pun yang berkaitan dengan sejarah/perjalanan/awal mula perusahaan, kamu WAJIB memanggil tool get_company_history TERLEBIH DAHULU sebelum menjawab apa pun. TIDAK ADA PENGECUALIAN.
   - Setelah tool merespons, WAJIB sebutkan minimal 3 tahun/peristiwa konkret dari hasil tool tersebut dalam jawabanmu (contoh: "Semuanya dimulai tahun 1932 saat..., lalu tahun 1978...").
   - DILARANG KERAS menjawab dengan kalimat penutup generik seperti "Itulah sejarah singkat..." atau "...menjadi perusahaan yang modern dan profesional seperti sekarang" TANPA menyebutkan tahun & peristiwa konkret terlebih dahulu.
   - Jika hasil tool get_company_history berbunyi "Data sejarah belum tersedia di database", kamu WAJIB menyampaikan PERSIS itu ke user secara jujur.
6. Olah data dari database menjadi jawaban yang komunikatif, menarik, dan ramah. Jangan pernah copy-paste format data mentah database.
7. Jika data dari tool tidak ditemukan / belum diinput admin, sampaikan secara jujur dengan kalimat santun bahwa informasi tersebut belum tersedia.
8. Jangan pernah mengaku sebagai ChatGPT/OpenAI/Groq/LLM lain. Kamu adalah Asisten Virtual Perumdam TDA.
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
                    'description' => 'Mendapatkan daftar kantor cabang dan Instalasi Pengolahan Air (IPA) Perumdam Tirta Darma Ayu, termasuk alamat, telepon, jam kerja, serta detail kapasitas terpasang, kapasitas produksi, dan idle capacity.',
                    'parameters' => ['type' => 'object', 'properties' => new \stdClass()],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'get_latest_news',
                    'description' => 'Mendapatkan berita atau kegiatan terbaru Perumdam Tirta Darma Ayu.',
                    'parameters' => ['type' => 'object', 'properties' => new \stdClass()],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'get_announcements',
                    'description' => 'Mendapatkan pengumuman resmi terbaru Perumdam Tirta Darma Ayu.',
                    'parameters' => ['type' => 'object', 'properties' => new \stdClass()],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'get_directors',
                    'description' => 'Mendapatkan daftar Dewan Direksi dan Kuasa Pemilik Modal Perumdam Tirta Darma Ayu, termasuk nama, jabatan, serta riwayat/deskripsi/biodata/latar belakang masing-masing.',
                    'parameters' => ['type' => 'object', 'properties' => new \stdClass()],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'get_company_profile',
                    'description' => 'Mendapatkan profil umum perusahaan: Sekilas PDAM, Ucapan Harapan & Terima Kasih (sambutan Dirut), Visi, dan Misi Perumdam Tirta Darma Ayu.',
                    'parameters' => ['type' => 'object', 'properties' => new \stdClass()],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'get_company_history',
                    'description' => 'Mendapatkan perjalanan sejarah lengkap Perumdam Tirta Darma Ayu yang disusun per tahun/periode oleh admin (mulai tahun 1932 sampai sekarang).',
                    'parameters' => ['type' => 'object', 'properties' => new \stdClass()],
                ],
            ],
        ];

        try {
            $reply = $this->askGroq($messages, $tools);
            return response()->json(['reply' => $reply]);
        } catch (\Exception $e) {
            Log::error('Chatbot error: ' . $e->getMessage());
            
            // Mengembalikan status 200 dengan pesan ramah agar tidak memicu error HTTP 500 di browser
            return response()->json([
                'reply' => 'Mohon maaf, saat ini server asisten sedang mengalami kendala jaringan atau lalu lintas yang tinggi. Silakan coba kirim ulang pertanyaan Anda dalam beberapa detik ya! 🙏'
            ], 200);
        }
    }

    private function askGroq(array $messages, array $tools, int $depth = 0)
    {
        if ($depth > 3) {
            return 'Maaf, terjadi kendala saat memproses permintaan Anda. Silakan coba pertanyaan lain.';
        }

        $response = Http::withToken(config('services.groq.api_key'))
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

        $content = $choice['content'] ?? 'Maaf, saya belum bisa memproses pertanyaan itu.';
        // Hapus tag <function=...></function> dari teks respons jika terikut dari LLM
        $content = preg_replace('/<function=[^>]*>.*?<\/function>/s', '', $content);
        $content = preg_replace('/<function=[^>]*>/s', '', $content);
        return trim($content);
    }

    private function runTool(string $functionName): string
    {
        return match ($functionName) {
            'get_branches' => $this->getBranchesData(),
            'get_latest_news' => $this->getLatestNewsData(),
            'get_announcements' => $this->getAnnouncementsData(),
            'get_directors' => $this->getDirectorsData(),
            'get_company_profile' => $this->getCompanyProfileData(),
            'get_company_history' => $this->getCompanyHistoryData(),
            default => 'Data tidak ditemukan.',
        };
    }

    private function getBranchesData(): string
    {
        $branches = Branch::orderByDesc('is_head_office')->orderBy('type')->get();
        if ($branches->isEmpty())
            return 'Data cabang / IPA belum tersedia.';

        $text = "Daftar Kantor Cabang dan Instalasi Pengolahan Air (IPA) Perumdam Tirta Darma Ayu:\n";
        foreach ($branches as $b) {
            $typeTag = $b->is_head_office ? '[KANTOR PUSAT]' : ($b->type === 'ipa' ? '[IPA]' : '[KANTOR CABANG]');
            $text .= "- {$typeTag} {$b->name}\n";
            $text .= "  Alamat: " . ($b->address ?: '-') . "\n";
            $text .= "  No. Telepon: " . ($b->phone ?: '-') . " | WA: " . ($b->whatsapp ?: '-') . "\n";
            $text .= "  Jam Operasional: " . ($b->operational_hours ?: '-') . "\n";
            if ($b->type === 'ipa' || $b->kapasitas_terpasang_text || $b->kapasitas_produksi || $b->idle_capacity) {
                $text .= "  Spesifikasi Kapasitas IPA:\n";
                if ($b->kapasitas_terpasang_text)
                    $text .= "    * Kapasitas Terpasang: {$b->kapasitas_terpasang_text}\n";
                if ($b->kapasitas_produksi)
                    $text .= "    * Kapasitas Produksi: {$b->kapasitas_produksi} L/detik\n";
                if ($b->idle_capacity)
                    $text .= "    * Idle Capacity: {$b->idle_capacity} L/detik\n";
            }
            $text .= "\n";
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

        if ($news->isEmpty())
            return 'Saat ini tidak ada berita terbaru.';

        $text = "5 Berita Terbaru:\n";
        foreach ($news as $n) {
            $excerpt = str($n->content)->stripTags()->limit(200);
            $text .= "- Judul: '{$n->title}'. Ringkasan: {$excerpt}. Tanggal: {$n->published_at->format('d M Y')}\n";
        }
        return $text;
    }

    private function getAnnouncementsData(): string
    {
        $announcements = Announcement::active()->latest()->take(5)->get();
        if ($announcements->isEmpty())
            return 'Saat ini tidak ada pengumuman resmi terbaru.';

        $text = "5 Pengumuman Resmi Terbaru:\n";
        foreach ($announcements as $a) {
            $desc = str($a->description)->stripTags()->limit(200);
            $text .= "- Judul: '{$a->title}'. Isi: {$desc}. Tanggal: {$a->created_at->format('d M Y')}\n";
        }
        return $text;
    }

    private function getDirectorsData(): string
    {
        $direksi = Director::direksi()->orderBy('sort_order')->get();
        $pemilikModal = Director::pemilikModal()->orderBy('sort_order')->get();

        $text = "Jajaran Direksi & Pejabat Perumdam Tirta Darma Ayu:\n";
        if ($direksi->isEmpty()) {
            $text .= "- Data direksi belum tersedia.\n";
        } else {
            foreach ($direksi as $d) {
                $text .= "- Nama: {$d->name}\n  Jabatan: {$d->position}\n";
                if ($d->description) {
                    $descClean = str($d->description)->stripTags();
                    $text .= "  Deskripsi/Profil/Riwayat: {$descClean}\n";
                }
            }
        }

        if ($pemilikModal->isNotEmpty()) {
            $text .= "\nKuasa Pemilik Modal:\n";
            foreach ($pemilikModal as $p) {
                $text .= "- Nama: {$p->name}\n  Jabatan: {$p->position}\n";
                if ($p->description) {
                    $descClean = str($p->description)->stripTags();
                    $text .= "  Deskripsi/Profil/Riwayat: {$descClean}\n";
                }
            }
        }

        return $text;
    }

    private function getCompanyProfileData(): string
    {
        $about = AboutUsContent::singleton();

        $sekilas = $about->sekilas_text ? str($about->sekilas_text)->stripTags() : 'Belum tersedia.';
        $harapan = $about->harapan_text ? str($about->harapan_text)->stripTags() : 'Belum tersedia.';
        $visi = $about->visi_text ? str($about->visi_text)->stripTags() : 'Belum tersedia.';
        $misi = $about->misi_text ? str($about->misi_text)->stripTags() : 'Belum tersedia.';

        return "Sekilas PDAM/Perumdam:\n{$sekilas}\n\nUcapan Harapan & Terima Kasih (Sambutan Direktur Utama):\n{$harapan}\n\nVisi Perusahaan:\n{$visi}\n\nMisi Perusahaan:\n{$misi}";
    }

    private function getCompanyHistoryData(): string
    {
        $histories = \App\Models\HistoryItem::orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();

        if ($histories->isEmpty()) {
            return 'Data sejarah belum tersedia di database.';
        }

        $text = "Lini Masa Sejarah Perumdam Tirta Darma Ayu:\n";
        foreach ($histories as $h) {
            $title = $h->title ? " ({$h->title})" : "";
            $text .= "- Tahun {$h->year}{$title}:\n  {$h->content}\n\n";
        }

        return $text;
    }
}