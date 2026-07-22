{{-- Chatbot Widget - PERUMDAM Tirta Darma Ayu --}}
<div id="chatbotRoot">
    {{-- Bubble tombol pemicu --}}
    <button id="chatbotToggleBtn" type="button"
        class="fixed bottom-5 right-5 z-[100] w-14 h-14 rounded-full bg-primary-600 hover:bg-primary-700 text-white shadow-xl flex items-center justify-center transition-transform hover:scale-105">
        <svg id="chatbotIconOpen" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8-1.17 0-2.29-.196-3.32-.554L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
        </svg>
        <svg id="chatbotIconClose" class="w-6 h-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>

    {{-- Jendela chat --}}
    <div id="chatbotWindow" class="hidden fixed bottom-24 right-5 z-[100] w-[92vw] max-w-sm h-[70vh] max-h-[560px] bg-white rounded-2xl shadow-2xl border border-slate-200 flex flex-col overflow-hidden">
        {{-- Header --}}
        <div class="bg-primary-600 text-white px-4 py-3 flex items-center gap-3 shrink-0">
            <div class="w-9 h-9 rounded-full bg-white/15 flex items-center justify-center text-lg">💧</div>
            <div class="flex-1 min-w-0">
                <div class="font-semibold text-sm leading-tight">Asisten PERUMDAM Tirta Darma Ayu</div>
                <div class="text-[11px] text-primary-100 leading-tight">Online • Siap membantu</div>
            </div>
            <button type="button" id="chatbotClearBtn" title="Hapus riwayat chat"
                class="w-8 h-8 shrink-0 rounded-lg hover:bg-white/15 flex items-center justify-center transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16"/>
                </svg>
            </button>
        </div>

        {{-- Area pesan --}}
        <div id="chatbotMessages" class="flex-1 overflow-y-auto px-3 py-4 space-y-3 bg-slate-50 text-sm"></div>

        {{-- Indikator "sedang mengetik" --}}
        <div id="chatbotTyping" class="hidden px-4 pb-2 text-xs text-slate-400 italic">Asisten sedang mengetik...</div>

        {{-- Form input --}}
        <form id="chatbotForm" class="border-t border-slate-200 p-2.5 flex items-end gap-2 shrink-0 bg-white">
            <textarea id="chatbotInput" rows="1" maxlength="1000" placeholder="Tulis pertanyaan seputar Perumdam TDA..."
                class="flex-1 resize-none rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400 max-h-24"></textarea>
            <button type="submit" id="chatbotSendBtn"
                class="w-10 h-10 shrink-0 rounded-xl bg-primary-600 hover:bg-primary-700 disabled:opacity-50 disabled:cursor-not-allowed text-white flex items-center justify-center transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19V5M5 12l7-7 7 7"/>
                </svg>
            </button>
        </form>
    </div>
</div>

<script>
(function () {
    const toggleBtn   = document.getElementById('chatbotToggleBtn');
    const iconOpen    = document.getElementById('chatbotIconOpen');
    const iconClose   = document.getElementById('chatbotIconClose');
    const windowEl    = document.getElementById('chatbotWindow');
    const messagesEl  = document.getElementById('chatbotMessages');
    const typingEl    = document.getElementById('chatbotTyping');
    const formEl      = document.getElementById('chatbotForm');
    const inputEl     = document.getElementById('chatbotInput');
    const sendBtn     = document.getElementById('chatbotSendBtn');
    const clearBtn    = document.getElementById('chatbotClearBtn');

    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content;
    const CHAT_URL = "{{ route('chatbot.chat') }}";

    const STORAGE_KEY = 'pdam_chatbot_history';
    const EXPIRY_HOURS = 24;

    // PENTING: dua variabel ini WAJIB ada, jangan sampai hilang lagi
    let history = loadHistory();
    let isSending = false;

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

    function clearHistory() {
        localStorage.removeItem(STORAGE_KEY);
        history = [];
        messagesEl.innerHTML = '';
        addMessage('assistant', 'Riwayat percakapan sudah dihapus. Ada yang bisa saya bantu? 😊');
    }

    // Buka/tutup jendela chat
    toggleBtn.addEventListener('click', function () {
        const isHidden = windowEl.classList.contains('hidden');
        windowEl.classList.toggle('hidden');
        iconOpen.classList.toggle('hidden', isHidden);
        iconClose.classList.toggle('hidden', !isHidden);

        if (isHidden && messagesEl.children.length === 0) {
            if (history.length > 0) {
                history.forEach(msg => addMessage(msg.role, msg.content));
            } else {
                addMessage('assistant', 'Halo! 👋 Saya Asisten Virtual PERUMDAM Tirta Darma Ayu. Ada yang bisa saya bantu? Anda bisa tanya seputar sejarah perusahaan, direksi, lokasi cabang, atau berita terbaru.');
            }
        }
        if (isHidden) inputEl.focus();
    });

    // Tombol hapus riwayat
    clearBtn.addEventListener('click', function () {
        if (confirm('Hapus semua riwayat percakapan ini?')) {
            clearHistory();
        }
    });

    // Auto-resize textarea
    inputEl.addEventListener('input', function () {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 96) + 'px';
    });

    // Enter untuk kirim, Shift+Enter untuk baris baru
    inputEl.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            formEl.requestSubmit();
        }
    });

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
            const reply = data.reply || 'Maaf, terjadi kesalahan. Silakan coba lagi.';

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

    function addMessage(role, text) {
        const wrapper = document.createElement('div');
        wrapper.className = role === 'user' ? 'flex justify-end' : 'flex justify-start';

        const bubble = document.createElement('div');
        bubble.className = role === 'user'
            ? 'max-w-[80%] bg-primary-600 text-white rounded-2xl rounded-br-sm px-3.5 py-2 whitespace-pre-wrap break-words'
            : 'max-w-[80%] bg-white border border-slate-200 text-slate-700 rounded-2xl rounded-bl-sm px-3.5 py-2 whitespace-pre-wrap break-words shadow-sm';
        bubble.textContent = text;

        wrapper.appendChild(bubble);
        messagesEl.appendChild(wrapper);
        messagesEl.scrollTop = messagesEl.scrollHeight;
    }
})();
</script>