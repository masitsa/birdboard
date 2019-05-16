<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Task;

class ProjectTasksController extends Controller
{
    public function store(Project $project)
    {
        $this->authorize('update', $project);

        $attributes = request()->validate([
            'task_name' => 'required',
            'task_description' => 'required'
        ]);

        $project->addTask( $attributes );

        return redirect( $project->path() );
    }

    public function update(Project $project, Task $task)
    {
        $this->authorize('update', $task->project);

        $attributes = request()->validate([
            'task_name' => 'required'
        ]);

        $attributes['task_status'] = request()->has('task_status') ?: 0;

        $res = $task->update($attributes);
        
        return redirect($project->path());
    }
}
