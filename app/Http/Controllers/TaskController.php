<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    //-menampilkan halaman awal dan fitur pencarian
    public function index(Request $request) {
      $query = Task::query();
      
      if($request->has('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
      }
      
      $tasks = $query->orderBy('title', 'asc')->get();
      return view('tasks.index', compact('tasks'));
    }
    //-menyimpan tugas baru
    public function create() {
      return view('tasks.create');
    }
    public function store(Request $request) {
      $request->validate([
        'title' => 'required|max:255',
      ]);
      Task::create($request->all());
      
      return redirect()->route('tasks.index');
    }
    public function edit(Task $task) {
      return view('tasks.edit', compact('task'));
    }
    public function update(Request $request, Task $task) {
      $request->validate([
          'title' => 'required|max:255',
        ]);
      $task->update($request->all());
      
      return redirect()->route('tasks.index');
    }
    //-menghapus tugas terpilih
    public function destroy(Request $request) {
      if($request->has('ids')) {
        Task::whereIn('id', $request->ids)->delete();
      }
      
      return redirect()->route('tasks.index');
    }
    //-mengubah status
    public function toggleComplete(Task $task) {
      $task->update(['completed' => !$task->completed]);
      return redirect()->route('tasks.index');
    }
}
