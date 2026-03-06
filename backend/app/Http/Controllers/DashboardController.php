<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function index(Request $request): JsonResponse
  {
    $user = $request->user();

    $projectQuery = Project::query();
    $taskQuery = Task::query();

    // Non-admin users only see their own dashboard data.
    if (!$user->is_admin) {
      $projectQuery->where('created_by', $user->id);
      $taskQuery->where('created_by', $user->id);
    }

    $activeProjectsCount = (clone $projectQuery)
      ->where('status', 'active')
      ->count();

    $pendingTasksCount = (clone $taskQuery)->count();

    $upcomingTasks = (clone $taskQuery)
      ->with(['project:id,name'])
      ->orderBy('due_date', 'asc')
      ->limit(5)
      ->get();

    $today = now()->startOfDay();

    $tasks = $upcomingTasks->map(function (Task $task) use ($today) {
      $dueDate = $task->due_date->copy()->startOfDay();
      $dayDiff = $today->diffInDays($dueDate, false);

      if ($dayDiff < 0) {
        $dueText = sprintf('%d hari lalu', abs($dayDiff));
        $urgency = 'danger';
      } elseif ($dayDiff === 0) {
        $dueText = 'Hari ini';
        $urgency = 'warning';
      } elseif ($dayDiff === 1) {
        $dueText = 'Besok';
        $urgency = 'warning';
      } elseif ($dayDiff <= 3) {
        $dueText = sprintf('%d hari lagi', $dayDiff);
        $urgency = 'warning';
      } else {
        Carbon::setLocale('id');
        $dueText = $dueDate->translatedFormat('d M Y');
        $urgency = 'normal';
      }

      return [
        'id' => $task->id,
        'title' => $task->title,
        'subtitle' => $task->project?->name ?? '-',
        'due_date' => $task->due_date->toDateString(),
        'due_text' => $dueText,
        'urgency' => $urgency,
      ];
    })->values();

    return response()->json([
      'success' => true,
      'message' => 'Data dashboard berhasil diambil.',
      'data' => [
        'active_projects_count' => $activeProjectsCount,
        'pending_tasks_count' => $pendingTasksCount,
        'upcoming_tasks' => $tasks,
      ],
    ], 200);
  }
}
