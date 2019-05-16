<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'project_name' => $faker->sentence,
        'project_description' => $faker->paragraph,
        'project_notes' => $faker->paragraph(50),
        'user_id' => factory(App\User::class)
    ];
});
