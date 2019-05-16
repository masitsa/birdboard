<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_has_a_path()
    {
        $project = factory('App\Project')->create();

        $this->assertEquals('/projects/'.$project->id, $project->path());
    }

    /** @test */
    public function it_belongs_to_an_owner()
    {
        $project = factory('App\Project')->create();

        $this->assertInstanceOf('App\User', $project->user);
    }

    /** @test */
    public function it_can_add_a_task()
    {
        $project = factory('App\Project')->create();

        $attributes = factory('App\Task')->raw(['project_id' => $project->id]);

        $task = $project->addTask($attributes);

        $this->assertCount(1, $project->tasks);

        $this->assertTrue( $project->tasks->contains( $task ) );
    }

    /** @test */
    public function its_description_has_100_characters()
    {
        $project = factory('App\Project')->create();

        $this->assertEquals(str_limit($project->project_description, 100), $project->limit_description());
    }
}
