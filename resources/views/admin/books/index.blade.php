@extends('layouts.admin')

@section('title', 'Kelola Data Buku')
@section('page_title', 'Katalog Data Buku')
@section('page_description', 'Kelola seluruh inventaris buku, harga, stok, dan kategori')

@section('content')
<div class="space-y-6">

    <!-- Controls Row: Search, Category Filter, and Add Button -->
    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        
        <!-- Search & Filter Form -->
        <form action="{{ route('admin.books.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full md:w-auto flex-grow">
            <!-- Search Input -->
            <div class="relative flex-grow max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari judul, pengarang, penerbit..."
                    class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-xs transition outline-none">
            </div>

            <!-- Category Selector -->
            <select name="category_id" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 text-slate-700 text-xs font-medium rounded-xl px-3 py-2.5 outline-none focus:border-indigo-500">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-bold px-4 py-2.5 rounded-xl text-xs transition">
                Cari
            </button>

            @if(request('search') || request('category_id'))
                <a href="{{ route('admin.books.index') }}" class="text-xs font-bold text-rose-600 hover:text-rose-800 flex items-center gap-1">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            @endif
        </form>

        <!-- Add Book Button -->
        <div class="shrink-0 w-full md:w-auto">
            <a href="{{ route('admin.books.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-3 rounded-2xl text-xs transition shadow-lg shadow-indigo-100">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Buku Baru</span>
            </a>
        </div>
    </div>

    <!-- Books Table Container -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-base font-extrabold text-slate-900">Total Koleksi: {{ $books->total() }} Judul Buku</h3>
        </div>

        @if($books->isEmpty())
            <div class="p-16 text-center space-y-4">
                <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center mx-auto text-2xl">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <h4 class="font-bold text-slate-800 text-sm">Tidak Ada Data Buku</h4>
                <p class="text-xs text-slate-400 max-w-sm mx-auto">
                    Katalog masih kosong atau tidak ada buku yang cocok dengan filter pencarian.
                </p>
                <a href="{{ route('admin.books.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-md">
                    <i class="fa-solid fa-plus"></i> Tambah Buku Pertama
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 font-bold uppercase tracking-wider border-b border-slate-100">
                            <th class="py-3 px-6">Buku</th>
                            <th class="py-3 px-6">Kategori</th>
                            <th class="py-3 px-6">Penulis & Penerbit</th>
                            <th class="py-3 px-6">Harga</th>
                            <th class="py-3 px-6 text-center">Stok</th>
                            <th class="py-3 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach($books as $book)
                            <tr class="hover:bg-slate-50/60 transition group">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3.5">
                                        <div class="w-12 h-16 rounded-xl overflow-hidden bg-slate-100 shrink-0 border border-slate-100 shadow-sm">
                                            <img src="{{ $book->image_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                                        </div>
                                        <div class="min-w-0 max-w-xs space-y-0.5">
                                            <h4 class="font-extrabold text-slate-900 text-sm truncate group-hover:text-indigo-600 transition">
                                                {{ $book->title }}
                                            </h4>
                                            <span class="text-[10px] text-slate-400 font-mono block">ISBN: {{ $book->isbn ?? '-' }}</span>
                                            @if($book->is_featured)
                                                <span class="inline-block bg-amber-50 text-amber-700 border border-amber-200 text-[9px] font-black px-1.5 py-0.2 rounded uppercase">
                                                    Featured
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <span class="inline-block bg-indigo-50 text-indigo-700 font-bold px-2.5 py-1 rounded-full text-[11px]">
                                        {{ $book->category->name ?? 'Tanpa Kategori' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="font-semibold text-slate-800 block">{{ $book->author }}</span>
                                    <span class="text-[10px] text-slate-400 block">{{ $book->publisher ?? '-' }}</span>
                                </td>
                                <td class="py-4 px-6 font-extrabold text-indigo-600 whitespace-nowrap text-sm">
                                    {{ $book->formatted_price }}
                                </td>
                                <td class="py-4 px-6 text-center whitespace-nowrap">
                                    @if($book->stock > 5)
                                        <span class="bg-emerald-50 text-emerald-700 font-bold px-2.5 py-1 rounded-full text-[11px]">
                                            {{ $book->stock }} eks
                                        </span>
                                    @elseif($book->stock > 0)
                                        <span class="bg-amber-50 text-amber-700 font-bold px-2.5 py-1 rounded-full text-[11px]">
                                            Sisa {{ $book->stock }}
                                        </span>
                                    @else
                                        <span class="bg-rose-50 text-rose-700 font-bold px-2.5 py-1 rounded-full text-[11px]">
                                            Habis
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right whitespace-nowrap space-x-2">
                                    <!-- Edit Link -->
                                    <a href="{{ route('admin.books.edit', $book->id) }}" class="inline-flex items-center gap-1 bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold px-3 py-1.5 rounded-lg text-xs transition">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>

                                    <!-- Delete Form -->
                                    <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku \'{{ $book->title }}\'?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold px-3 py-1.5 rounded-lg text-xs transition">
                                            <i class="fa-regular fa-trash-can"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-6 border-t border-slate-100">
                {{ $books->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
