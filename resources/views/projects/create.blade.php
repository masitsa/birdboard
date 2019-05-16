@extends('layouts/app')

@section('content')

    <form action="/projects" method="POST" class="form-horizontal">

        @csrf

        <div class="form-group row">
            
            <label for="project_name" class="col-sm-1-12 col-form-label">Project Name</label>
            
            <div class="col-sm-1-12">
                
                <input type="text" class="form-control" name="project_name" id="project_name" placeholder="Project Name">

            </div>

        </div>

        <div class="form-group row">
            
            <label for="project_description" class="col-sm-1-12 col-form-label">Project Description</label>
            
            <div class="col-sm-1-12">
                
                <textarea class="form-control" name="project_description" id="project_description" placeholder="Project Description"></textarea>

            </div>

        </div>

        <div class="form-group row">

            <div class="offset-sm-2 col-sm-10">

                <button type="submit" class="btn btn-primary">Create Project</button>

                <a href="/projects">Back</a>

            </div>

        </div>

    </form>

@endsection