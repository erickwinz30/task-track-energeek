<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DashboardTest extends TestCase
{
  use RefreshDatabase;

  public function test_authenticated_user_can_get_dashboard_summary(): void
  {
    $user = User::factory()->create(['is_admin' => true]);
    $category = Category::create(['name' => 'Bug']);

    $activeProject = Project::create([
      'created_by' => $user->id,
      'name' => 'Project A',
      'description' => 'Desc',
      'status' => 'active',
    ]);

    Project::create([
      'created_by' => $user->id,
      'name' => 'Project B',
      'description' => 'Desc',
      'status' => 'archived',
    ]);

    Task::create([
      'project_id' => $activeProject->id,
      'category_id' => $category->id,
      'created_by' => $user->id,
      'title' => 'Task 1',
      'description' => 'Desc',
      'due_date' => now()->subDays(2)->toDateString(),
    ]);

    Task::create([
      'project_id' => $activeProject->id,
      'category_id' => $category->id,
      'created_by' => $user->id,
      'title' => 'Task 2',
      'description' => 'Desc',
      'due_date' => now()->addDay()->toDateString(),
    ]);

    Sanctum::actingAs($user);

    $response = $this->getJson('/api/dashboard');

    $response->assertStatus(200)
      ->assertJson([
        'success' => true,
      ])
      ->assertJsonPath('data.active_projects_count', 1)
      ->assertJsonPath('data.pending_tasks_count', 2)
      ->assertJsonStructure([
        'data' => [
          'active_projects_count',
          'pending_tasks_count',
          'upcoming_tasks' => [
            '*' => [
              'id',
              'title',
              'subtitle',
              'due_date',
              'due_text',
              'urgency',
            ],
          ],
        ],
      ]);
  }

  public function test_non_admin_user_only_sees_their_own_dashboard_data(): void
  {
    $owner = User::factory()->create(['is_admin' => false]);
    $otherUser = User::factory()->create(['is_admin' => false]);
    $category = Category::create(['name' => 'Feature']);

    $ownerProject = Project::create([
      'created_by' => $owner->id,
      'name' => 'Owner Project',
      'description' => null,
      'status' => 'active',
    ]);

    $otherProject = Project::create([
      'created_by' => $otherUser->id,
      'name' => 'Other Project',
      'description' => null,
      'status' => 'active',
    ]);

    Task::create([
      'project_id' => $ownerProject->id,
      'category_id' => $category->id,
      'created_by' => $owner->id,
      'title' => 'Owner Task',
      'description' => null,
      'due_date' => now()->addDays(3)->toDateString(),
    ]);

    Task::create([
      'project_id' => $otherProject->id,
      'category_id' => $category->id,
      'created_by' => $otherUser->id,
      'title' => 'Other Task',
      'description' => null,
      'due_date' => now()->addDays(3)->toDateString(),
    ]);

    Sanctum::actingAs($owner);

    $response = $this->getJson('/api/dashboard');

    $response->assertStatus(200)
      ->assertJsonPath('data.active_projects_count', 1)
      ->assertJsonPath('data.pending_tasks_count', 1)
      ->assertJsonCount(1, 'data.upcoming_tasks')
      ->assertJsonPath('data.upcoming_tasks.0.title', 'Owner Task');
  }
}
