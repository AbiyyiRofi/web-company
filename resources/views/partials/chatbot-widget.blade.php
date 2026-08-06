{{-- Chatbot Widget - PERUMDAM Tirta Darma Ayu --}}
<div id="chatbotRoot">
    {{-- Bubble tombol pemicu --}}
    <button id="chatbotToggleBtn" type="button"
        class="fixed bottom-5 right-5 z-[100] w-16 h-16 rounded-full shadow-2xl flex items-center justify-center transition-transform hover:scale-110 active:scale-95 bg-primary-600 border-2 border-white/80 group">

        <span class="absolute inset-0 rounded-full bg-primary-500 opacity-75 animate-ping pointer-events-none"></span>
        <span class="absolute -inset-1 rounded-full bg-primary-400/40 blur-sm animate-pulse pointer-events-none"></span>

        <div id="chatbotIconOpen" class="w-full h-full relative z-10 flex items-center justify-center p-1.5">
            <lottie-player src="{{ asset('lottie/AI_bot.json') }}" background="transparent" speed="1" loop autoplay
                style="width:100%;height:100%"></lottie-player>
        </div>
        <svg id="chatbotIconClose" class="w-7 h-7 text-white hidden relative z-10" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    {{-- Jendela chat --}}
    <div id="chatbotWindow"
        class="hidden fixed bottom-24 right-5 z-[100] w-[92vw] max-w-sm h-[70vh] max-h-[560px] bg-white rounded-2xl shadow-2xl border border-slate-200 flex flex-col overflow-hidden">
        {{-- Header --}}
        <div class="bg-primary-600 text-white px-4 py-3 flex items-center gap-3 shrink-0">
            <div class="w-9 h-9 rounded-full bg-white/15 flex items-center justify-center overflow-hidden">
                <lottie-player src="{{ asset('lottie/AI_bot.json') }}" background="transparent" speed="1" loop autoplay
                    style="width:80%;height:80%"></lottie-player>
            </div>
            <div class="flex-1 min-w-0">
                <div class="font-semibold text-sm leading-tight">Asisten PERUMDAM Tirta Darma Ayu</div>
                <div class="text-[11px] text-primary-100 leading-tight">Online • Siap membantu</div>
            </div>
            <button type="button" id="chatbotClearBtn" title="Hapus riwayat chat"
                class="w-8 h-8 shrink-0 rounded-lg hover:bg-white/15 flex items-center justify-center transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16" />
                </svg>
            </button>
        </div>

        {{-- Area pesan --}}
        <div id="chatbotMessages" class="flex-1 overflow-y-auto px-3 py-4 space-y-3 bg-slate-50 text-sm"></div>

        {{-- Indikator "sedang mengetik" --}}
        <div id="chatbotTyping" class="hidden px-4 pb-2 text-xs text-slate-400 italic">Asisten sedang mengetik...</div>

        {{-- Template Quick Suggestions --}}
        <div class="px-3 py-2 bg-slate-100/70 border-t border-slate-200 shrink-0">
            <div class="text-[11px] font-semibold text-slate-500 mb-1.5 flex items-center gap-1">
                <span>💡 Pertanyaan Cepat:</span>
            </div>
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 no-scrollbar text-xs">
                <button type="button" data-action="cekTagihan" class="quick-chip shrink-0 px-2.5 py-1 rounded-full bg-white border border-slate-200 text-slate-700 hover:bg-primary-50 hover:text-primary-600 hover:border-primary-300 transition shadow-sm font-medium">
                    Cek Tagihan Air
                </button>
                <button type="button" data-action="pengaduan" class="quick-chip shrink-0 px-2.5 py-1 rounded-full bg-white border border-slate-200 text-slate-700 hover:bg-primary-50 hover:text-primary-600 hover:border-primary-300 transition shadow-sm font-medium">
                    Cara Pengaduan Online
                </button>
                <button type="button" data-action="cabang" class="quick-chip shrink-0 px-2.5 py-1 rounded-full bg-white border border-slate-200 text-slate-700 hover:bg-primary-50 hover:text-primary-600 hover:border-primary-300 transition shadow-sm font-medium">
                    Lokasi Kantor Cabang
                </button>
                <button type="button" data-action="sejarah" class="quick-chip shrink-0 px-2.5 py-1 rounded-full bg-white border border-slate-200 text-slate-700 hover:bg-primary-50 hover:text-primary-600 hover:border-primary-300 transition shadow-sm font-medium">
                    Sejarah Perusahaan
                </button>
            </div>
        </div>

        {{-- Form input --}}
        <form id="chatbotForm" class="border-t border-slate-200 p-2.5 flex items-end gap-2 shrink-0 bg-white">
            <textarea id="chatbotInput" rows="1" maxlength="1000" placeholder="Tulis pertanyaan seputar Perumdam TDA..."
                class="flex-1 resize-none rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400 max-h-24"></textarea>
            <button type="submit" id="chatbotSendBtn"
                class="w-10 h-10 shrink-0 rounded-xl bg-primary-600 hover:bg-primary-700 disabled:opacity-50 disabled:cursor-not-allowed text-white flex items-center justify-center transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19V5M5 12l7-7 7 7" />
                </svg>
            </button>
        </form>
    </div>
</div>

<script>
    (function () {
        const toggleBtn = document.getElementById('chatbotToggleBtn');
        const iconOpen = document.getElementById('chatbotIconOpen');
        const iconClose = document.getElementById('chatbotIconClose');
        const windowEl = document.getElementById('chatbotWindow');
        const messagesEl = document.getElementById('chatbotMessages');
        const typingEl = document.getElementById('chatbotTyping');
        const formEl = document.getElementById('chatbotForm');
        const inputEl = document.getElementById('chatbotInput');
        const sendBtn = document.getElementById('chatbotSendBtn');
        const clearBtn = document.getElementById('chatbotClearBtn');

        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content;
        const CHAT_URL = "{{ route('chatbot.chat') }}";
        const BRANCHES_JSON_URL = "{{ route('branches.json') }}";
        const HISTORY_JSON_URL = "{{ route('history.json') }}";
        const CEK_TAGIHAN_URL = "https://pelayananperumdamtda.com/mitra/bayar";
        const BANYU_DIGITAL_URL = "https://play.google.com/store/apps/details?id=com.pelayananperumdamtda.app&pcampaignid=web_share";

        const STORAGE_KEY = 'pdam_chatbot_history';
        const EXPIRY_HOURS = 24;

        let history = loadHistory();
        let isSending = false;
        let cachedBranches = null;
        let cachedHistoryItems = null;

        function loadHistory() {
            try {
                const raw = localStorage.getItem(STORAGE_KEY);
                if (!raw) return [];
                const parsed = JSON.parse(raw);
                const ageHours = (Date.now() - parsed.savedAt) / (1000 * 60 * 60);
                if (ageHours > EXPIRY_HOURS) {
                    localStorage.removeItem(STORAGE_KEY);
                    return [];
                }
                return parsed.messages || [];
            } catch (e) {
                return [];
            }
        }

        function saveHistory() {
            try {
                localStorage.setItem(STORAGE_KEY, JSON.stringify({
                    savedAt: Date.now(),
                    messages: history,
                }));
            } catch (e) { /* diamkan kalau storage penuh/diblokir */ }
        }

        toggleBtn.addEventListener('click', function () {
            const isHidden = windowEl.classList.contains('hidden');
            windowEl.classList.toggle('hidden');
            iconOpen.classList.toggle('hidden', isHidden);
            iconClose.classList.toggle('hidden', !isHidden);

            if (isHidden && messagesEl.children.length === 0) {
                if (history.length > 0) {
                    history.forEach(msg => addMessage(msg.role, msg.content));
                } else {
                    showWelcomeMessage();
                }
            }
            if (isHidden) inputEl.focus();
        });

        clearBtn.addEventListener('click', function () {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Hapus Riwayat Percakapan?',
                    text: 'Seluruh riwayat obrolan dengan Asisten Virtual akan dibersihkan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#f1f5f9',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-2xl shadow-2xl',
                        confirmButton: 'px-5 py-2.5 rounded-xl text-white font-semibold shadow-lg bg-red-600 hover:bg-red-700 transition',
                        cancelButton: 'px-5 py-2.5 rounded-xl text-slate-600 font-semibold bg-slate-100 hover:bg-slate-200 transition'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        history = [];
                        saveHistory();
                        messagesEl.innerHTML = '';
                        showWelcomeMessage();
                    }
                });
            } else {
                if (confirm('Hapus semua riwayat percakapan ini?')) {
                    history = [];
                    saveHistory();
                    messagesEl.innerHTML = '';
                    showWelcomeMessage();
                }
            }
        });

        inputEl.addEventListener('input', function () {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 96) + 'px';
        });

        inputEl.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                formEl.requestSubmit();
            }
        });

        // Quick Suggestions — sekarang punya "jalur pintas" masing-masing, gak semuanya lewat AI
        document.querySelectorAll('.quick-chip').forEach(btn => {
            btn.addEventListener('click', function () {
                const action = this.dataset.action;
                if (action === 'cekTagihan') return showCekTagihanInfo();
                if (action === 'pengaduan') return startLaporFlow();
                if (action === 'cabang') return showCabangList();
                if (action === 'sejarah') return startSejarahFlow();

                inputEl.value = this.textContent.trim();
                formEl.requestSubmit();
            });
        });

        // Kata kunci yang di-deteksi SEBELUM dikirim ke AI, biar 3 topik ini selalu konsisten
        // jawabannya walau usernya ngetik manual (bukan klik tombol quick-chip)
        function detectShortcut(text) {
            const lower = text.toLowerCase();
            if (/(cek tagihan|bayar tagihan|tagihan air)/.test(lower)) return 'cekTagihan';
            if (/(pengaduan|lapor|komplain|keluhan)/.test(lower)) return 'pengaduan';
            if (/(sejarah|berdiri|awal mula|histori)/.test(lower)) return 'sejarah';
            return null;
        }

        formEl.addEventListener('submit', async function (e) {
            e.preventDefault();
            e.stopPropagation();
            const text = inputEl.value.trim();
            if (!text || isSending) return;

            addMessage('user', text);
            history.push({ role: 'user', content: text });
            saveHistory();

            inputEl.value = '';
            inputEl.style.height = 'auto';

            const shortcut = detectShortcut(text);
            if (shortcut === 'cekTagihan') return showCekTagihanInfo(true);
            if (shortcut === 'pengaduan') return startLaporFlow(true);
            if (shortcut === 'sejarah') return startSejarahFlow(true);

            setSending(true);

            try {
                const res = await fetch(CHAT_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                    },
                    body: JSON.stringify({
                        message: text,
                        history: history.slice(0, -1),
                    }),
                });

                if (!res.ok) throw new Error('HTTP ' + res.status);

                const data = await res.json();
                let reply = data.reply || 'Maaf, terjadi kesalahan. Silakan coba lagi.';
                reply = reply.replace(/<function=[^>]*>.*?<\/function>/gs, '').replace(/<function=[^>]*>/gs, '').trim();

                addMessage('assistant', reply);
                history.push({ role: 'assistant', content: reply });
                if (history.length > 10) history = history.slice(-10);
                saveHistory();

            } catch (err) {
                addMessage('assistant', 'Maaf, koneksi ke server bermasalah. Silakan coba beberapa saat lagi. 🙏');
                console.error('Chatbot error:', err);
            } finally {
                setSending(false);
            }
        });

        function setSending(state) {
            isSending = state;
            sendBtn.disabled = state;
            typingEl.classList.toggle('hidden', !state);
            if (state) messagesEl.scrollTop = messagesEl.scrollHeight;
        }

        function addMessage(role, text, buttons) {
            const wrapper = document.createElement('div');
            wrapper.className = role === 'user' ? 'flex justify-end' : 'flex justify-start';

            const col = document.createElement('div');
            col.className = 'max-w-[85%] flex flex-col gap-2';

            const bubble = document.createElement('div');
            bubble.className = role === 'user'
                ? 'bg-primary-600 text-white rounded-2xl rounded-br-sm px-3.5 py-2 whitespace-pre-wrap break-words self-end'
                : 'bg-white border border-slate-200 text-slate-700 rounded-2xl rounded-bl-sm px-3.5 py-2 whitespace-pre-wrap break-words shadow-sm';
            bubble.textContent = text;
            col.appendChild(bubble);

            if (buttons && buttons.length) {
                const btnWrap = document.createElement('div');
                btnWrap.className = 'flex flex-col gap-1.5';

                buttons.forEach(function (btnData) {
                    const isLink = !!btnData.href;
                    const el = document.createElement(isLink ? 'a' : 'button');
                    if (isLink) {
                        el.href = btnData.href;
                        el.target = '_blank';
                        el.rel = 'noopener';
                    } else {
                        el.type = 'button';
                    }
                    el.textContent = btnData.label;
                    el.className = 'text-left text-sm font-medium px-3.5 py-2 rounded-xl border border-primary-200 bg-primary-50 text-primary-700 hover:bg-primary-100 hover:border-primary-300 transition';

                    el.addEventListener('click', function () {
                        Array.from(btnWrap.children).forEach(x => {
                            if (x.tagName === 'BUTTON') x.disabled = true;
                        });
                        btnWrap.classList.add('opacity-50', 'pointer-events-none');
                        if (btnData.onClick) btnData.onClick();
                    });

                    btnWrap.appendChild(el);
                });

                col.appendChild(btnWrap);
            }

            wrapper.appendChild(col);
            messagesEl.appendChild(wrapper);
            messagesEl.scrollTop = messagesEl.scrollHeight;
        }

        function showWelcomeMessage() {
            addMessage('assistant', 'Halo! 👋 Saya Asisten Virtual PERUMDAM Tirta Darma Ayu. Mau aku bantu apa hari ini?', [
                { label: '🛠️ Lapor Masalah / Pengaduan', onClick: startLaporFlow },
                { label: '💬 Tanya-tanya Info Seputar Perumdam TDA', onClick: startTanyaFlow },
            ]);
        }

        // ===== JALUR PINTAS: Cek Tagihan (gak lewat AI, jawaban selalu tetap) =====
        function showCekTagihanInfo(skipUserBubble) {
            if (!skipUserBubble) addMessage('user', '💳 Cek Tagihan Air');
            addMessage(
                'assistant',
                'Untuk cek & bayar tagihan air, paling gampang lewat tombol "Cek Tagihan" di website ini, atau lewat aplikasi Banyu Digital di HP kamu 📱',
                [
                    { label: '💳 Cek Tagihan Sekarang', href: CEK_TAGIHAN_URL },
                    { label: '📲 Unduh Banyu Digital', href: BANYU_DIGITAL_URL },
                ]
            );
        }

        // ===== JALUR PINTAS: Lapor Masalah / Pengaduan =====
        async function getCabangList() {
            if (!cachedBranches) {
                const res = await fetch(BRANCHES_JSON_URL);
                cachedBranches = await res.json();
            }
            return cachedBranches.filter(b => b.type === 'cabang');
        }

        async function startLaporFlow(skipUserBubble) {
            if (!skipUserBubble) addMessage('user', '🛠️ Lapor Masalah / Pengaduan');
            setSending(true);

            try {
                const cabang = await getCabangList();
                setSending(false);

                if (cabang.length === 0) {
                    addMessage('assistant', 'Untuk pengaduan online, kamu bisa langsung unduh aplikasi Banyu Digital di Play Store ya! 📱', [
                        { label: '📲 Unduh Banyu Digital', href: BANYU_DIGITAL_URL }
                    ]);
                    return;
                }

                const branchButtons = cabang.map(function (b) {
                    return { label: b.name, onClick: function () { selectBranch(b); } };
                });

                addMessage(
                    'assistant',
                    'Untuk pengaduan online, kamu bisa langsung unduh aplikasi Banyu Digital di Play Store ya! 📱\n\nKalau kamu mau tersambung ke petugas cabang terdekat, aku bisa bantu — kasih tau lokasi cabang/unit mana yang paling dekat sama kamu:',
                    branchButtons
                );
            } catch (err) {
                setSending(false);
                addMessage('assistant', 'Maaf, aku gagal ambil data cabang. Coba lagi ya, atau cek langsung halaman Hubungi Kami. 🙏');
                console.error('Gagal fetch branches:', err);
            }
        }

        function selectBranch(branch) {
            addMessage('user', branch.name);

            if (branch.whatsapp_link) {
                addMessage('assistant', 'Kamu bisa langsung hubungi ' + branch.name + ' lewat WhatsApp berikut ya:', [
                    { label: '💬 Hubungi Sekarang', href: branch.whatsapp_link }
                ]);
            } else {
                addMessage('assistant', 'Maaf, nomor WhatsApp untuk ' + branch.name + ' belum tersedia di sistem kami. Kamu bisa cek halaman Hubungi Kami di website untuk info kontak lainnya ya. 🙏');
            }
        }

        // ===== JALUR PINTAS: Lokasi Kantor Cabang (list langsung, tanpa embel-embel Banyu Digital) =====
        async function showCabangList() {
            addMessage('user', '📍 Lokasi Kantor Cabang');
            setSending(true);

            try {
                const cabang = await getCabangList();
                setSending(false);

                if (cabang.length === 0) {
                    addMessage('assistant', 'Data cabang belum tersedia saat ini. Coba cek halaman Hubungi Kami di website ya. 🙏');
                    return;
                }

                const branchButtons = cabang.map(function (b) {
                    return { label: b.name, onClick: function () { selectBranch(b); } };
                });

                addMessage('assistant', 'Berikut daftar kantor cabang & unit Perumdam TDA, pilih salah satu buat lihat kontaknya:', branchButtons);
            } catch (err) {
                setSending(false);
                addMessage('assistant', 'Maaf, aku gagal ambil data cabang. Coba lagi ya. 🙏');
            }
        }

        // ===== JALUR PINTAS: Sejarah (pilih tahun dulu, baru cerita spesifik tahun itu) =====
        async function startSejarahFlow(skipUserBubble) {
            if (!skipUserBubble) addMessage('user', '📜 Sejarah Perusahaan');
            setSending(true);

            try {
                if (!cachedHistoryItems) {
                    const res = await fetch(HISTORY_JSON_URL);
                    cachedHistoryItems = await res.json();
                }
                setSending(false);

                if (!cachedHistoryItems.length) {
                    addMessage('assistant', 'Maaf, data sejarah perusahaan belum tersedia di sistem kami saat ini. 🙏');
                    return;
                }

                const yearButtons = cachedHistoryItems.map(function (h) {
                    const label = h.title ? (h.year + ' — ' + h.title) : ('Tahun ' + h.year);
                    return { label: label, onClick: function () { showHistoryYear(h); } };
                });

                addMessage('assistant', 'Mau tahu sejarah Perumdam Tirta Darma Ayu di tahun berapa nih? Pilih salah satu ya 👇', yearButtons);
            } catch (err) {
                setSending(false);
                addMessage('assistant', 'Maaf, aku gagal ambil data sejarah. Coba lagi ya. 🙏');
            }
        }

        function showHistoryYear(item) {
            const label = item.title ? (item.year + ' — ' + item.title) : ('Tahun ' + item.year);
            addMessage('user', label);
            addMessage('assistant', item.content, [
                { label: '📜 Lihat tahun lainnya', onClick: startSejarahFlow }
            ]);
        }

        // ===== JALUR AI: Tanya-tanya bebas =====
        function startTanyaFlow() {
            addMessage('user', '💬 Tanya-tanya Info Seputar Perumdam TDA');
            addMessage('assistant', 'Mau nanya-nanya seputar apa nih? Mari aku bantu 😊 (kamu bisa tanya soal direksi, profil perusahaan, atau berita terbaru — untuk sejarah, cek tagihan, atau pengaduan, ada tombol khusus di atas ya!)');
            inputEl.focus();
        }
    })();
</script>