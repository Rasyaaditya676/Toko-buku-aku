@extends('layouts.admin')

@section('title', 'Pesan Kontak dari User')
@section('page_title', 'Pesan Masuk dari Pelanggan')
@section('page_description', 'Kelola pesan, pertanyaan, dan masukan yang dikirim melalui formulir Contact to Admin')

@section('content')
<div class="space-y-6">

    <!-- Status Tabs -->
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.messages.index') }}" 
            class="px-4 py-2.5 rounded-2xl text-xs font-bold transition {{ !request('status') || request('status') === 'all' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-100' }}">
            Semua Pesan
        </a>
        <a href="{{ route('admin.messages.index', ['status' => 'unread']) }}" 
            class="px-4 py-2.5 rounded-2xl text-xs font-bold transition {{ request('status') === 'unread' ? 'bg-amber-500 text-white shadow-md shadow-amber-200' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-100' }}">
            Belum Dibaca
        </a>
        <a href="{{ route('admin.messages.index', ['status' => 'replied']) }}" 
            class="px-4 py-2.5 rounded-2xl text-xs font-bold transition {{ request('status') === 'replied' ? 'bg-emerald-600 text-white shadow-md shadow-emerald-200' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-100' }}">
            Sudah Dibalas
        </a>
    </div>

    <!-- Messages Container -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-base font-extrabold text-slate-900">Total Pesan: {{ $messages->total() }} Pesan</h3>
        </div>

        @if($messages->isEmpty())
            <div class="p-16 text-center space-y-3">
                <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center mx-auto text-2xl">
                    <i class="fa-solid fa-inbox"></i>
                </div>
                <h4 class="font-bold text-slate-800 text-sm">Tidak Ada Pesan Masuk</h4>
                <p class="text-xs text-slate-400">Kotak pesan saat ini kosong.</p>
            </div>
        @else
            <div class="divide-y divide-slate-100">
                @foreach($messages as $msg)
                    <div class="p-6 space-y-4 hover:bg-slate-50/50 transition">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <!-- Sender Info -->
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-2xl flex items-center justify-center font-bold text-sm shrink-0 {{ $msg->status === 'unread' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600' }}">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h4 class="font-bold text-slate-900 text-sm">{{ $msg->name }}</h4>
                                        @if($msg->user_id)
                                            <span class="bg-indigo-50 text-indigo-700 text-[10px] font-bold px-2 py-0.2 rounded-full">User Terdaftar</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-slate-400">{{ $msg->email }} &bull; {{ $msg->phone ?? 'Tanpa nomor HP' }}</p>
                                </div>
                            </div>

                            <!-- Status Badge & Date -->
                            <div class="flex items-center gap-3">
                                <span class="text-xs text-slate-400 whitespace-nowrap">{{ $msg->created_at->translatedFormat('d M Y, H:i') }}</span>
                                @if($msg->status === 'unread')
                                    <span class="bg-amber-100 text-amber-800 font-bold px-2.5 py-0.5 rounded-full text-[10px] uppercase">Belum Dibaca</span>
                                @elseif($msg->status === 'replied')
                                    <span class="bg-emerald-100 text-emerald-800 font-bold px-2.5 py-0.5 rounded-full text-[10px] uppercase">Sudah Dibalas</span>
                                @else
                                    <span class="bg-slate-100 text-slate-600 font-bold px-2.5 py-0.5 rounded-full text-[10px] uppercase">Dibaca</span>
                                @endif
                            </div>
                        </div>

                        <!-- Subject & Content -->
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 space-y-1.5 text-xs">
                            <span class="font-extrabold text-slate-800 block text-sm">Topik: {{ $msg->subject }}</span>
                            <p class="text-slate-600 leading-relaxed whitespace-pre-line">{{ $msg->message }}</p>
                        </div>

                        <!-- Previous Reply if any -->
                        @if($msg->reply)
                            <div class="bg-emerald-50/70 p-4 rounded-2xl border border-emerald-100 space-y-1 text-xs">
                                <span class="font-bold text-emerald-800 flex items-center gap-1.5">
                                    <i class="fa-solid fa-reply"></i> Balasan Anda (Admin):
                                </span>
                                <p class="text-emerald-900 leading-relaxed">{{ $msg->reply }}</p>
                            </div>
                        @endif

                        <!-- Actions / Reply Form -->
                        <div class="pt-1 flex flex-wrap items-center justify-between gap-3">
                            <div>
                                @if($msg->status === 'unread')
                                    <form action="{{ route('admin.messages.read', $msg->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center gap-1.5">
                                            <i class="fa-regular fa-envelope-open"></i> Tandai Sudah Dibaca
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <!-- Toggle Reply Box Button -->
                            <button type="button" onclick="document.getElementById('replyBox-{{ $msg->id }}').classList.toggle('hidden')" 
                                class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold px-4 py-2 rounded-xl text-xs transition flex items-center gap-1.5">
                                <i class="fa-solid fa-reply"></i>
                                <span>{{ $msg->reply ? 'Edit Balasan' : 'Balas Pesan Ini' }}</span>
                            </button>
                        </div>

                        <!-- Hidden Reply Box Form -->
                        <div id="replyBox-{{ $msg->id }}" class="hidden pt-3 border-t border-slate-100">
                            <form action="{{ route('admin.messages.reply', $msg->id) }}" method="POST" class="space-y-3">
                                @csrf
                                <label class="block text-xs font-bold text-slate-700">Tuliskan Balasan untuk {{ $msg->name }}:</label>
                                <textarea name="reply" rows="3" required
                                    placeholder="Tuliskan jawaban atau konfirmasi untuk pertanyaan user di sini..."
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:border-indigo-500 outline-none">{{ $msg->reply }}</textarea>
                                <div class="flex justify-end gap-2">
                                    <button type="button" onclick="document.getElementById('replyBox-{{ $msg->id }}').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100">
                                        Tutup
                                    </button>
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2 rounded-xl text-xs transition shadow-md">
                                        Kirim Balasan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="p-6 border-t border-slate-100">
                {{ $messages->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
