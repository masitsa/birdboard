<div class="card" style="height: 200px;">
    <h3 class="font-normal text-xl mb-3 py-4 -ml-5 border-l-4 border-blue-light pl-4">
        <a href="{{ $project->path() }}" class="text-black no-underline">
            {{ $project->project_name }}
        </a>
    </h3>
    <div class="text-grey">
        {{ str_limit($project->project_description, 100) }}
    </div>
</div>