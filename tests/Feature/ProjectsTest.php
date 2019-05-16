<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_user_cannot_create_a_project()
    {
        $project = factory('App\Project')->raw();

        $this->post('/projects', $project)->assertRedirect('/login');
    }

    /** @test */
    public function a_guest_user_cannot_view_projects()
    {
        $this->get('/projects')->assertRedirect('/login');
    }

    /** @test */
    public function a_guest_user_cannot_view_a_single_project()
    {
        $project = factory('App\Project')->create();

        $this->get($project->path())->assertRedirect('/login');
    }

    /** @test */
    public function a_guest_user_cannot_view_create_page()
    {
        $this->get('/projects/create')->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_view_create_page()
    {
        $this->withoutExceptionHandling();
        
        // $this->signIn();
        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $attributes = factory('App\Project')->raw(['user_id' => auth()->id()]);
        // $this->post('/projects', $attributes)->assertRedirect('/projects');
        $response = $this->post('/projects', $attributes);
        $this->assertDatabaseHas('projects', $attributes);
        $project = \App\Project::where($attributes)->first();
        $response->assertRedirect($project->path());
        $this->get($project->path())
            ->assertSee($attributes['project_name'])
            ->assertSee(str_limit($attributes['project_description'], 100))
            ->assertSee($attributes['project_notes']);
    }

    /** @test */
    public function a_user_can_update_a_project()
    {
        // $this->withoutExceptionHandling();
        $this->signIn();
        $project = factory('App\Project')->create(['user_id' => auth()->id()]);
        $attributes = [
            'project_notes' => $this->faker->paragraph(40)
        ];
        $this->patch($project->path(), $attributes);
        $this->get($project->path())
            ->assertSee($attributes['project_notes']);
    }

    /** @test */
    public function a_project_has_a_title()
    {
        $this->signIn();

        $attributes = factory('App\Project')->raw(['project_name' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('project_name');
    }

    /** @test */
    public function a_project_has_a_description()
    {
        $this->signIn();

        $attributes = factory('App\Project')->raw(['project_description' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('project_description');
    }

    /** @test */
    public function a_user_can_view_a_project()
    {
        $this->withoutExceptionHandling();

        $user = factory('App\User')->create();

        $this->signIn($user);

        $project = factory('App\Project')->create(['user_id' => $user->id]);

        $this->get($project->path())
            ->assertSee($project->project_name);
            // ->assertSee($project->project_description);
    }

    /** @test */
    public function a_user_cannot_view_other_users_projects()
    {
        $this->signIn();

        $project = factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);
    }
}
