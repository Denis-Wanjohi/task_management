<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $priorityOrder = ['urgent', 'high', 'medium', 'low'];
        $fieldSql = "FIELD(priority, '" . implode("','", $priorityOrder) . "')";

        $tasks = Task::orderByRaw($fieldSql)->get();
        return view("tasks", ["tasks" => $tasks]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("CreateTask");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'task' => 'required|string',
            'priority' => 'required|string',
            'deliverables' => 'string|nullable',
        ]);
        Task::create($validation);
        return redirect()->route('task.tasks');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::where("id", $id)->first();
        if ($task == null) {
            request()->session()->flash('error', 'Task not found!');
            return redirect()->route("task.tasks");
        }

        return view("EditTask", ["task" => $task]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validation = $request->validate([
            'task' => 'required|string',
            'priority' => 'required|string',
            'deliverables' => 'nullable|string',
        ]);

        $task = Task::where("id", $id)->first();
        if ($task == null) {
            request()->session()->flash('error', 'Task not found!');
            return redirect()->route("task.tasks");
        }

        $task->task = $validation['task'];
        $task->priority = $validation['priority'];
        $task->deliverables = $task->deliverables != null? $task->deliverables .",".$validation['deliverables']: $validation['deliverables'] ;

        $task->save();
        request()->session()->flash('success', 'Task edited successfully!');
        return redirect()->route("task.tasks");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::where("id", $id)->first();
        if ($task == null) {
            return redirect()->route("task.tasks");
        }

        $task->delete();
        request()->session()->flash('success', 'Task successfully deleted!');
        return redirect()->route("task.tasks");
    }

    /**
     * Edit a deliverable
     */
    public function updateDeliverable(Request $request, string $id)
    {

        $validated = $request->validate([
            'deliverable' => 'required|string',
            'index' => 'required|string'
        ]);

        $task = Task::where("id", $id)->first();
        if ($task == null) {
            return redirect()->route('/edit/' . $id);
        }

        $delv = explode(",", $task->deliverables);

        $delv[$validated['index']] = $validated['deliverable'];
        $task->deliverables = implode(",", $delv);
        $task->save();

        return redirect()->route('task.edit', ['id' => $id]);
    }

    /**
     * Delete a deliverable
     */
    public function destroyDeliverable(Request $request, string $id)
    {
        $validated = $request->validate([
            'index' => 'required'
        ]);

        $task = Task::where("id", $id)->first();
        if ($task == null) {
            return redirect()->route('/edit/' . $id);
        }

        $delvs = explode(",", $task->deliverables);
        $new_delv = array();
        foreach ($delvs as $delv) {
            if ($delv == $delvs[$validated['index']]) {
                continue;
            }
            array_push($new_delv, $delv);
        }

        $task->deliverables = count($new_delv) >= 1 ? implode(",", $new_delv): null;
        $task->save();

        return redirect()->route('task.edit', ['id' => $id]);
    }
}
