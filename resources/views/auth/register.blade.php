@extends('layouts.app')

@section('title', 'Daftar Akun Baru - PustakaKita')

@section('content')
<div class="max-w-lg mx-auto my-12 px-4">
    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-100 p-8 space-y-6">
        <!-- Header -->
        <div class="text-center space-y-2">
            <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mx-auto text-2xl shadow-inner">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <h2 class="text-2xl font-black text-slate-900">Registrasi Akun Baru</h2>
            <p class="text-xs text-slate-500">Daftar sekarang untuk berbelanja buku dengan transaksi online yang aman &amp; praktis</p>
        </div>

        <!-- Form Register -->
        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Nama Lengkap -->
            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-regular fa-user text-sm"></i>
                    </div>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        placeholder="Contoh: Budi Santoso"
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none">
                </div>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-regular fa-envelope text-sm"></i>
                    </div>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        placeholder="nama@email.com"
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none">
                </div>
            </div>

            <!-- Phone & Address -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">No. WhatsApp / HP</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-phone text-xs"></i>
                        </div>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                            placeholder="08xxxxxxxxxx"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none">
                    </div>
                </div>

                <div>
                    <label for="address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kota / Alamat</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-location-dot text-xs"></i>
                        </div>
                        <input type="text" name="address" id="address" value="{{ old('address') }}"
                            placeholder="Kota pengiriman"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none">
                    </div>
                </div>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kata Sandi (Minimal 6 Karakter)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </div>
                    <input type="password" name="password" id="password" required
                        placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;"
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none">
                </div>
            </div>

            <!-- Password Confirmation -->
            <div>
                <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ulangi Kata Sandi</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-shield-check text-sm"></i>
                    </div>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;"
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none">
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm transition shadow-lg shadow-indigo-100 hover:shadow-indigo-200 flex items-center justify-center gap-2">
                <i class="fa-solid fa-user-check text-xs"></i>
                <span>Daftar Akun Sekarang</span>
            </button>
        </form>

        <!-- Login Link -->
        <div class="text-center pt-2 border-t border-slate-100 text-xs text-slate-500">
            Sudah memiliki akun? 
            <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-800 ml-1">
                Masuk ke akun Anda
            </a>
        </div>
    </div>
</div>
@endsection
