<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    // Fetch all tasks
    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }

    // Fetch a single task by ID
    public function show($id)
    {
        $task = Task::find($id);
        if ($task) {
            return response()->json($task);
        }
        return response()->json(['message' => 'Task not found'], 404);
    }

    // Create a new task
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:To Do,In Progress,Done',
            'assigned_users' => 'nullable|array'
        ]);
        $data = $request->all();
        $data['assigned_users'] = json_encode($request->assigned_users);
        $task = Task::create($data);
        return response()->json($task, 201);
    }

    // Update a task
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->update($request->all());
        return response()->json($task);
    }

    // Delete a task
    public function destroy($id)
    {
        $task = Task::find($id);
        if ($task) {
            $task->delete();
            return response()->json(['message' => 'Task deleted successfully']);
        }
        return response()->json(['message' => 'Task not found'], 404);
    }
}

