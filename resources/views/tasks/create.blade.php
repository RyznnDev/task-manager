<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tugas Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">

</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased min-h-screen py-10">

    <div class="max-w-xl mx-auto bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
        <h1 class="text-xl font-bold text-slate-900 border-b border-slate-100 pb-4 mb-6">Tambah Tugas Baru</h1>

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

            <!-- Judul Tugas -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Tugas *</label>
                <input type="text" name="title" required placeholder="Masukkan judul..." 
                    class="w-full text-sm border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-800">
            </div>

            <!-- Kolom Deskripsi Tugas -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kolom Tugas (Deskripsi)</label>
                <textarea name="description" rows="4" placeholder="Detail tugas..." 
                    class="w-full text-sm border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-800"></textarea>
            </div>

            <!-- Tanggal Tugas -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Tugas</label>
                <input type="date" name="task_date" 
                    class="w-full text-sm border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-800">
            </div>

            <!-- Tombol Confirm & Cancel -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('tasks.index') }}" class="px-4 py-2 text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-slate-900 hover:bg-slate-800 rounded-lg transition">
                    Confirm
                </button>
            </div>
        </form>
    </div>

</body>
</html>
