@extends('layouts.admin')

@section('title', 'List User Terdaftar')
@section('page_title', 'List User yang Sudah Terdaftar')
@section('page_description', 'Kelola dan pantau seluruh pengguna terdaftar pada aplikasi toko buku')

@section('content')
<div class="space-y-6">

    <!-- Search & Filter Controls -->
    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full sm:w-auto flex-grow">
            <!-- Search Bar -->
            <div class="relative flex-grow max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari nama, email, atau nomor HP user..."
                    class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-xs transition outline-none">
            </div>

            <!-- Role Selector -->
            <select name="role" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 text-slate-700 text-xs font-medium rounded-xl px-3 py-2.5 outline-none focus:border-indigo-500">
                <option value="">Semua Peran (Role)</option>
                <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User (Pelanggan)</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin (Pengelola)</option>
            </select>

            <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-bold px-4 py-2.5 rounded-xl text-xs transition">
                Filter
            </button>

            @if(request('search') || request('role'))
                <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-rose-600 hover:text-rose-800 flex items-center gap-1">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            @endif
        </form>

        <div class="text-xs text-slate-400 shrink-0 font-medium">
            Total Terdaftar: <strong class="text-slate-800">{{ $users->total() }} User</strong>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-base font-extrabold text-slate-900">Daftar Pengguna Aplikasi</h3>
        </div>

        @if($users->isEmpty())
            <div class="p-16 text-center space-y-3">
                <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center mx-auto text-2xl">
                    <i class="fa-solid fa-users-slash"></i>
                </div>
                <h4 class="font-bold text-slate-800 text-sm">Tidak Ada Data User</h4>
                <p class="text-xs text-slate-400">Tidak ditemukan user yang cocok dengan kriteria pencarian Anda.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 font-bold uppercase tracking-wider border-b border-slate-100">
                            <th class="py-3 px-6">Informasi User</th>
                            <th class="py-3 px-6">Peran (Role)</th>
                            <th class="py-3 px-6">Kontak / Telepon</th>
                            <th class="py-3 px-6">Alamat Domisili</th>
                            <th class="py-3 px-6 text-center">Total Pesanan</th>
                            <th class="py-3 px-6 text-right">Terdaftar Pada</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach($users as $u)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-xs shrink-0 {{ $u->isAdmin() ? 'bg-indigo-100 text-indigo-700' : 'bg-emerald-100 text-emerald-700' }}">
                                            <i class="fa-solid {{ $u->isAdmin() ? 'fa-user-shield' : 'fa-user' }}"></i>
                                        </div>
                                        <div>
                                            <span class="font-extrabold text-slate-900 block">{{ $u->name }}</span>
                                            <span class="text-slate-400 text-[11px] block">{{ $u->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap">
                                    @if($u->isAdmin())
                                        <span class="inline-flex items-center gap-1 bg-indigo-50 border border-indigo-200 text-indigo-700 font-extrabold px-2.5 py-0.5 rounded-full text-[10px] uppercase tracking-wider">
                                            <i class="fa-solid fa-shield-halved text-[9px]"></i> Admin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 bg-emerald-50 border border-emerald-200 text-emerald-700 font-bold px-2.5 py-0.5 rounded-full text-[10px] uppercase tracking-wider">
                                            <i class="fa-solid fa-user text-[9px]"></i> User
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <span class="font-semibold text-slate-800">{{ $u->phone ?? '-' }}</span>
                                </td>
                                <td class="py-4 px-6 max-w-xs text-slate-600">
                                    <span class="truncate block" title="{{ $u->address }}">
                                        {{ $u->address ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center whitespace-nowrap">
                                    <span class="inline-block bg-slate-100 text-slate-700 font-bold px-2.5 py-1 rounded-full text-[11px]">
                                        {{ $u->orders_count }} pesanan
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right whitespace-nowrap text-slate-500">
                                    {{ $u->created_at->translatedFormat('d M Y, H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-6 border-t border-slate-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
