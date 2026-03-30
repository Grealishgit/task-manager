<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    // POST /api/tasks
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = Task::create([
            'title'    => $request->title,
            'due_date' => $request->due_date,
            'priority' => $request->priority,
            'status'   => 'pending',
        ]);

        return response()->json([
            'message' => 'Task created successfully.',
            'data'    => $task,
        ], 201);
    }

    // GET /api/tasks
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'status' => ['sometimes', Rule::in(['pending', 'in_progress', 'done'])],
        ]);

        $query = Task::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tasks = $query
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
            ->orderBy('due_date', 'asc')
            ->get();

        if ($tasks->isEmpty()) {
            return response()->json([
                'message' => 'No tasks found.',
                'data'    => [],
            ]);
        }

        return response()->json([
            'message' => 'Tasks retrieved successfully.',
            'data'    => $tasks,
        ]);
    }

    // PATCH /api/tasks/{id}/status
    public function updateStatus(Request $request, int $id): JsonResponse
    {
        $task = Task::findOrFail($id);

        $nextStatus = $task->nextStatus();

        if ($nextStatus === null) {
            return response()->json([
                'message' => 'Task is already marked as done. No further status changes allowed.',
            ], 422);
        }

        $task->update(['status' => $nextStatus]);

        return response()->json([
            'message' => "Task status updated to '{$nextStatus}'.",
            'data'    => $task->fresh(),
        ]);
    }

    // DELETE /api/tasks/{id}
    public function destroy(int $id): JsonResponse
    {
        $task = Task::findOrFail($id);

        if ($task->status !== 'done') {
            return response()->json([
                'message' => 'Only tasks with status "done" can be deleted.',
            ], 403);
        }

        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully.',
        ]);
    }

    // GET /api/tasks/report?date=YYYY-MM-DD
    public function report(Request $request): JsonResponse
    {
        $request->validate([
            'date' => ['required', 'date', 'date_format:Y-m-d'],
        ]);

        $date  = $request->date;
        $tasks = Task::whereDate('due_date', $date)->get();

        $summary = [];
        foreach (['high', 'medium', 'low'] as $priority) {
            foreach (['pending', 'in_progress', 'done'] as $status) {
                $summary[$priority][$status] = 0;
            }
        }

        foreach ($tasks as $task) {
            $summary[$task->priority][$task->status]++;
        }

        return response()->json([
            'date'    => $date,
            'summary' => $summary,
        ]);
    }
}
