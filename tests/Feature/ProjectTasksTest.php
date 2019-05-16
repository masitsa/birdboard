<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Project;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_project_can_have_tasks()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $project = factory(Project::class)->create(['user_id' => auth()->id()]);
        $attributes = factory('App\Task')->raw(['project_id' => $project->id]);
        $this->post( $project->path() . '/tasks', $attributes );
        $this->get( $project->path() )
            ->assertSee( $attributes['task_name'] );
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $project = factory('App\Project')->create(['user_id' => auth()->id()]);
        $attributes = factory('App\Task')->raw(['project_id' => $project->id]);
        $task = $project->addTask($attributes);
        $attributesUpdate = ['task_name' => $this->faker->sentence . 'Lorem ipsum 556 7', 'task_status' => 1];
        $this->patch($task->path(), $attributesUpdate);
        $this->get($project->path())
            ->assertSee($attributesUpdate['task_name']);
    }

    /** @test */
    public function a_task_requires_a_name()
    {
        $this->signIn();
        $project = factory('App\Project')->create(['user_id' => auth()->id()]);
        $attributes = factory('App\Task')->raw( ['task_name' => '', 'project_id' => $project->id ] );
        $this->post( $project->path() .'/tasks' , $attributes )->assertSessionHasErrors('task_name');
    }

    /** @test */
    public function a_task_requires_a_description()
    {
        $this->signIn();
        $project = factory('App\Project')->create(['user_id' => auth()->id()]);
        $attributes = factory('App\Task')->raw(['task_description' => '', 'project_id' => $project->id]);
        $this->post($project->path() .'/tasks', $attributes)->assertSessionHasErrors('task_description');
    }

    /** @test */
    public function only_the_owner_of_the_project_may_add_tasks()
    {
        $this->signIn();
        $project = factory('App\Project')->create();
        $attributes = factory('App\Task')->raw();
        $this->post($project->path() . '/tasks', $attributes)
            ->assertStatus(403);
        $this->assertDatabaseMissing('tasks', ['task_name' => $attributes['task_name']]);
    }

    /** @test */
    public function only_the_owner_of_a_project_may_update_a_task()
    {
        $this->signIn();
        $project = factory('App\Project')->create();
        $attributes = factory('App\Task')->raw();
        $task = $project->addTask($attributes);
        $attributes['task_status'] = 1;

        $this->patch($task->path(), $attributes)
            ->assertStatus(403);
        
        $this->assertDatabaseMissing('tasks', ['task_status' => $attributes['task_status']]);
    }
}
