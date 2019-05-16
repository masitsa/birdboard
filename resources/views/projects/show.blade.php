@extends('layouts/app')
@section('content')
	<header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-grey text-sm font-normal">
                <a href="/projects" class="text-grey text-sm font-normal no-underline">My Projects</a> / {{ $project->project_name }}
            </p>

            <a href="/projects/create" class="button">Add Project</a>
        </div>
	</header>
    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-lg text-grey font-normal mb-3">Tasks</h2>
                    <!-- Tasks -->
                    <div class="card mb-3">
                        <form action="{{ $project->path() }}/tasks" method="post">
                            @csrf
                            <input type="text" name="task_name" placeholder="Task Name">
                            <textarea name="task_description" placeholder="Task Description"></textarea>
                            <button type="submit" class="button">Add Task</button>
                        </form>
                    </div>
                    
                    @forelse( $project->tasks as $task )
                        <div class="card mb-3">
                            <h3 class="font-normal text-xl mb-3 py-4 -ml-5 border-l-4 border-blue-light pl-4">
                                <form action="{{ $task->path() }}" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <div class="flex">
                                        <input type="text" name="task_name" value="{{ $task->task_name }}" class="w-full {{ $task->task_status == 1 ? 'text-grey' : '' }}">
                                        <input type="checkbox" name="task_status" value="{{ $task->task_status == 1 ? '0' : '1' }}" onChange="this.form.submit()" {{ $task->task_status == 1 ? "checked" : "" }}>
                                    </div>
                                </form>
                            </h3>
                            <div class="text-grey">
                                {{ str_limit($task->task_description, 100) }}
                            </div>
                        </div>
                    @empty
                        <div class="card mb-3">
                            No tasks yet
                        </div>
                    @endforelse
                </div>
                <div>
                    <h2 class="text-lg text-grey font-normal mb-3">General Notes</h2>
                    <!-- General Notes -->
                    <form action="{{ $project->path() }}" method="post">
                        @csrf
                        @method('PATCH')
                        <textarea class="card w-full mb-4" style="min-height: 200px;">{{ $project->project_notes }}</textarea>
                        <button class="button">
                            Update
                        </button>
                    </form>
                </div>
            </div>
            <div class="lg:w-1/4 px-3">
                @include('projects.card')
            </div>
        </div>
    </main>
@endsection