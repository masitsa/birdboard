<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['project_name', 'project_description', 'user_id', 'project_notes'];

    public function path()
    {
        return "/projects/{$this->id}";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function addTask($task)
    {
        return $this->tasks()->create($task);
    }

    public function limit_description()
    {
        return str_limit($this->project_description, 100);
    }
}
