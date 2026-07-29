<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager - Official Dashboard</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome Lokal (Public Folder) -->
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased min-h-screen">

    <!-- FORM HAPUS MASSAL (Tanpa membungkus elemen UI lain agar tidak error 405) -->
    <form action="{{ route('tasks.destroy') }}" method="POST" id="deleteForm">
        @csrf
        @method('DELETE')
    </form>

    <!-- NAVBAR -->
    <nav class="bg-slate-900 text-white shadow-md">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between gap-4">
            <!-- Judul Paling Kiri -->
            <a href="{{ route('tasks.index') }}" class="text-xl font-bold tracking-wide text-slate-100 hover:text-white flex items-center gap-2">
                <i class="fa-solid fa-list-check text-blue-500"></i>
                <span>Task Manager</span>
            </a>

            <!-- Pencarian di Tengah -->
            <form action="{{ route('tasks.index') }}" method="GET" class="flex-1 max-w-md mx-4">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari tugas..." 
                        class="w-full bg-slate-800 text-sm text-slate-200 placeholder-slate-400 border border-slate-700 rounded-lg pl-9 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </form>

            <!-- Aksi Paling Kanan -->
            <div class="flex items-center gap-3">
                <!-- Tombol Mode Hapus -->
                <button type="button" onclick="toggleDeleteMode()" class="bg-slate-800 hover:bg-slate-700 text-slate-200 w-9 h-9 flex items-center justify-center rounded-lg transition border border-slate-700" title="Mode Hapus">
                    <i class="fa-solid fa-trash-can text-sm"></i>
                </button>

                <!-- Tombol Buat Tugas Baru -->
                <a href="{{ route('tasks.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg transition flex items-center font-medium text-sm gap-2" title="Tambah Tugas">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span class="hidden sm:inline">Tambah</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- KONTEN UTAMA -->
    <main class="max-w-6xl mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-slate-900">Daftar Tugas</h1>
            
            <!-- Tombol Hapus Terpilih (Mengeksekusi #deleteForm di atas) -->
            <button type="submit" form="deleteForm" id="deleteSubmitBtn" class="hidden bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition flex items-center gap-2">
                <i class="fa-solid fa-trash"></i>
                <span>Hapus Tugas Terpilih</span>
            </button>
        </div>

        <!-- JIKA TIDAK ADA DATA -->
        @if($tasks->isEmpty())
            <div class="bg-white border border-slate-200 rounded-lg p-8 text-center text-slate-500">
                <i class="fa-solid fa-inbox text-3xl mb-2 text-slate-300"></i>
                <p>Tidak ada tugas yang ditemukan.</p>
            </div>
        @else
            <!-- DAFTAR TUGAS -->
            <div class="grid gap-4">
                @foreach($tasks as $task)
                    <div class="bg-white border border-slate-200 rounded-lg p-4 flex items-center justify-between shadow-sm hover:shadow transition">
                        <div class="flex items-start gap-3">
                            <!-- Checkbox Hapus (Terhubung otomatis ke #deleteForm) -->
                            <input type="checkbox" name="ids[]" value="{{ $task->id }}" form="deleteForm" class="delete-checkbox hidden mt-1 w-4 h-4 text-blue-600 rounded border-slate-300">
                            
                            <div>
                                <h2 class="font-semibold text-lg {{ $task->is_completed ? 'line-through text-slate-400' : 'text-slate-800' }}">
                                    {{ $task->title }}
                                </h2>
                                @if($task->description)
                                    <p class="text-sm text-slate-600 mt-1">{{ $task->description }}</p>
                                @endif
                                @if($task->task_date)
                                    <span class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-500 mt-2 bg-slate-100 px-2.5 py-1 rounded border border-slate-200">
                                        <i class="fa-regular fa-calendar text-slate-400"></i>
                                        {{ \Carbon\Carbon::parse($task->task_date)->format('d M Y') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <!-- Tombol Toggle Status -->
                            <form action="{{ route('tasks.toggle', $task->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-xs font-semibold px-3 py-1.5 rounded-lg border flex items-center gap-1.5 transition {{ $task->is_completed ? 'bg-slate-100 text-slate-600 border-slate-300 hover:bg-slate-200' : 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100' }}">
                                    <i class="fa-solid {{ $task->is_completed ? 'fa-rotate-left' : 'fa-check' }}"></i>
                                    <span>{{ $task->is_completed ? 'Batal' : 'Selesai' }}</span>
                                </button>
                            </form>

                            <!-- Tombol Edit -->
                            <a href="{{ route('tasks.edit', $task->id) }}" class="w-8 h-8 flex items-center justify-center text-slate-500 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition" title="Edit Tugas">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>

    <script>
        function toggleDeleteMode() {
            const checkboxes = document.querySelectorAll('.delete-checkbox');
            const submitBtn = document.getElementById('deleteSubmitBtn');
            checkboxes.forEach(cb => cb.classList.toggle('hidden'));
            submitBtn.classList.toggle('hidden');
        }
    </script>
</body>
</html>
