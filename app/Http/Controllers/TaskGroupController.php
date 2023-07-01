<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskGroup;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TaskGroupController extends Controller
{
    public function index()
    {

        $groups = TaskGroup::all();
        $tasks = Task::all();
        return view('add-group', compact('groups', 'tasks'));
    }

    public function getGroup($id)
    {
        $group = TaskGroup::find($id);

        return view('edit-group', compact('group'));
    }


    public function store(Request $request)
    {
        TaskGroup::create([
           'name' => $request->group_name,
            'description' => $request->group_desc,
        ]);
        return back();
    }

    public function edit(Request $request): RedirectResponse
    {
        $group = TaskGroup::find($request->id);

        $group->name = $request->name;
        $group->description = $request->description;

        $group->save();

        return back();
    }

    public function destroy(Request $request)
    {
        $group = TaskGroup::find($request->id);

        $group->delete();
        return back();
    }
}
