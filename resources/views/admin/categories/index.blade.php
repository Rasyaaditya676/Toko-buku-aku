@extends('layouts.admin')

@section('title', 'Kelola Kategori Buku')
@section('page_title', 'Kategori Buku')
@section('page_description', 'Tambah, edit, dan kelola kategori untuk pengelompokan buku')

@section('content')
<div class="space-y-8">

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- Col 1: Form Tambah Kategori Baru (4 cols) -->
        <div class="lg:col-span-4 bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm space-y-5">
            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm">
                    <i class="fa-solid fa-plus"></i>
                </div>
                <h3 class="text-base font-extrabold text-slate-900">Tambah Kategori Baru</h3>
            </div>

            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Nama Kategori -->
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Kategori</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        placeholder="Contoh: Novel Remaja, Teknologi AI"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none">
                </div>

                <!-- Deskripsi Kategori -->
                <div>
                    <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi Singkat (Opsional)</label>
                    <textarea name="description" id="description" rows="3"
                        placeholder="Penjelasan singkat mengenai kategori buku ini..."
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none">{{ old('description') }}</textarea>
                </div>

                <button type="submit" class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs transition shadow-md shadow-indigo-100 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-check"></i>
                    <span>Simpan Kategori Baru</span>
                </button>
            </form>
        </div>

        <!-- Col 2: Tabel Daftar Kategori (8 cols) -->
        <div class="lg:col-span-8 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden space-y-4">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Daftar Kategori Buku ({{ $categories->total() }})</h3>
                    <p class="text-xs text-slate-400">Semua kategori buku yang aktif di katalog PustakaKita</p>
                </div>
            </div>

            @if($categories->isEmpty())
                <div class="p-12 text-center text-xs text-slate-400">
                    Belum ada kategori buku yang dibuat.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 text-slate-400 font-bold uppercase tracking-wider border-b border-slate-100">
                                <th class="py-3 px-6">Nama Kategori</th>
                                <th class="py-3 px-6">Slug URL</th>
                                <th class="py-3 px-6">Deskripsi</th>
                                <th class="py-3 px-6 text-center">Jumlah Buku</th>
                                <th class="py-3 px-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @foreach($categories as $category)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="py-4 px-6 font-extrabold text-slate-900">
                                        {{ $category->name }}
                                    </td>
                                    <td class="py-4 px-6 text-slate-400 font-mono text-[11px]">
                                        {{ $category->slug }}
                                    </td>
                                    <td class="py-4 px-6 text-slate-500 max-w-xs">
                                        {{ Str::limit($category->description ?? '-', 50) }}
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="inline-block bg-indigo-50 text-indigo-700 font-extrabold px-2.5 py-1 rounded-full text-[11px]">
                                            {{ $category->books_count }} buku
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-right whitespace-nowrap space-x-2">
                                        <!-- Edit Modal Button -->
                                        <button type="button" 
                                            onclick="openEditCategoryModal({{ $category->id }}, '{{ addslashes($category->name) }}', '{{ addslashes($category->description ?? '') }}')"
                                            class="inline-flex items-center gap-1 bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold px-3 py-1.5 rounded-lg text-xs transition">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </button>

                                        <!-- Delete Form -->
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori \'{{ $category->name }}\'?')">
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
                    {{ $categories->links() }}
                </div>
            @endif
        </div>

    </div>

</div>

<!-- Modal Edit Kategori -->
<div id="editCategoryModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 space-y-5 shadow-2xl border border-slate-100 animate-scale-up">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <h3 class="text-base font-extrabold text-slate-900">Edit Kategori Buku</h3>
            <button type="button" onclick="closeEditCategoryModal()" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form id="editCategoryForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="edit_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Kategori</label>
                <input type="text" name="name" id="edit_name" required
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none">
            </div>

            <div>
                <label for="edit_description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi Singkat</label>
                <textarea name="description" id="edit_description" rows="3"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-sm transition outline-none"></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" onclick="closeEditCategoryModal()" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-700 text-white transition shadow-md shadow-indigo-100">
                    Perbarui Kategori
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditCategoryModal(id, name, description) {
        document.getElementById('editCategoryForm').action = '/admin/categories/' + id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_description').value = description;
        document.getElementById('editCategoryModal').classList.remove('hidden');
    }

    function closeEditCategoryModal() {
        document.getElementById('editCategoryModal').classList.add('hidden');
    }
</script>
@endsection
