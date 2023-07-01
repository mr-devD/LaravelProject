<?php

namespace App\Http\Controllers;

use App\Models\TaskAttachment;
use App\Models\TaskExecutant;
use App\Models\TaskGroup;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{

    public function index()
    {
        $groups = TaskGroup::all();
        $executants = User::all()->where('type_id', 'LIKE', 3);
        return view('add-tasks', compact('groups', 'executants'));
    }

    public function getTask(Request $request){
        $task = Task::find($request->id);
        $taskexecutant = TaskExecutant::where('task_id', $request->id)
            ->where('executant_id', Auth::user()->id)
            ->first();

        return view('task',  compact('task', 'taskexecutant'));
    }

    public function getTaskk(Request $request)
    {
        $groups = TaskGroup::all();
        $task = Task::find($request->id);

        return view('task-edit', compact('task', 'groups'));
    }

    public function getTasks()
    {
        $userType = auth()->user()->type_id;

        if ($userType === 3) {
            $tasks = auth()->user()->tasks;
        } else {
            $tasks = Task::all();
        }

        return view('tasks', compact('tasks'));
    }


    public function store(Request $request)
    {
        $task = \App\Models\Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'manager_id' => $request->user()->id,
            'deadline' => $request->deadline,
            'priority' => $request->priority,
            'group_id' => $request->group_id
        ]);

        $task_id = $task->id;
        $executants = $request->executants;
        foreach ($executants as $executant) {
            TaskExecutant::create([
                'task_id' => $task_id,
                'executant_id' => $executant,
            ]);
        }

        $files = $request->file('attachments');
        if ($files == null){
            return back();
        }
        foreach ($files as $file){
            $filename = $file->getClientOriginalName();
            $path = $file->storeAs('public/attachments', $filename);
            TaskAttachment::create([
                'task_id' => $task_id,
                'name' => $filename,
                'path' => str_replace('public/', 'storage/', $path)
            ]);
        }

        return back();
    }

    public function destroy(Request $request)
    {
        $task = Task::find($request->task_id);
        $task->delete();

        $tasks = Task::all();

        return view('tasks', compact('tasks'));
    }

    public function complete(Request $request)
    {
        $task = Task::find($request->task_id);
        $task->completed = 1;
        $task->save();

        return back();
    }

    public function cancel(Request $request)
    {
        $task = Task::find($request->task_id);
        $task->canceled = 1;
        $task->save();

        return back();
    }

    public function edit(Request $request)
    {

        $task = Task::find($request->task_id);
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'deadline' => 'required',
            'priority' => ['required', 'numeric', 'max:10', 'min:1']
        ]);

        $task->title = $request->title;
        $task->description = $request->description;
        $task->deadline = $request->deadline;
        $task->priority = $request->priority;
        $task->group_id = $request->group;

        $task->save();

        return back();
    }

    public function executantComplete(Request $request): RedirectResponse
    {
        $task = TaskExecutant::where('task_id', $request->task_id)
            ->where('executant_id', Auth::user()->id)
            ->first();

        if ($task) {
            $task->completed = 1;
            $task->save();
        }
        return back();
    }



}
