<!-- resources/views/tasks/index.blade.php -->

@extends('layouts.app')

@section('content')

<!-- Bootstrap Boilerplate... -->

<div class="panel-body">
    <!-- Display Validation Errors -->
    @include('common.errors')

    <!-- New Task Form -->
    {{ Form::model($task, ['action' => ['TaskController@update', 'task' => $task], 'class' => 'form-horizontal']) }}

        <!-- Task Name -->
        <div class="form-group">
            {{ Form::label('name', 'Task', ['class' => 'col-sm-3 control-label']) }}

            <div class="col-sm-6">
                {{ Form::text('name', null, array('class' => 'form-control')) }}
            </div>
        </div>

        <!-- Add Task Button -->
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-plus"></i> Save Task
                </button>
            </div>
        </div>
    {{ Form::close() }}
</div>

@endsection