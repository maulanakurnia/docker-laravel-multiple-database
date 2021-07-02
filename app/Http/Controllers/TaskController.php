<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Paginate the authenticated user's tasks.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tasks = Auth::user()
            ->tasks()
            ->orderBy('is_complete')
            ->orderByDesc('created_at')
            ->paginate(5);

        return view('pages.home', [
            'tasks' => $tasks,
            'update'=> false
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'title' => 'required|string|max:255',
        ]);
        Auth::user()->tasks()->create([
            'title' => $data['title'],
            'is_complete' => false,
        ]);
        session()->flash('status', 'Task Created!');

        return redirect('/tasks');
    }

    public function update(Task $task)
    {
        if(Auth::user()->id == $task->user_id){
            if($task->is_complete == false) {
                Task::where('id', $task->id)->update(['is_complete' => true]);
                session()->flash('status', 'Task Completed!');
            }else {
                Task::where('id', $task->id)->update(['is_complete' => false]);
                session()->flash('status', 'Task uncompleted!');
            }
        } else {
            abort(403);
        }

        return redirect('/tasks');
    }

    public function updateTask(Request $request)
    {
        Task::where('id', $request->id)->update(['title' => $request->title]);
        session()->flash('status', 'Task Completed!');

        return redirect('/tasks');
    }

    public function edit(Task $task)
    {
        $tasks = Auth::user()
            ->tasks()
            ->orderBy('is_complete')
            ->orderByDesc('created_at')
            ->paginate(5);

        return view('pages.home', [
            'tasks' => $tasks,
            'task'  => $task,
            'update'=> true
        ]);
    }

    public function destroy(Task $task)
    {
        Task::where('id',$task->id)->delete();
        session()->flash('status', 'Task has been removed');

        return redirect('/tasks');
    }
}