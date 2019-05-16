<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'task_name' => $faker->sentence,
        'task_description' => $faker->paragraph,
        'task_status' => 0,
        'project_id' => factory(App\Project::class)
    ];
});
