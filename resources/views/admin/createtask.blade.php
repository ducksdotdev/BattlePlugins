@extends('layouts.admin')
@section('content')
    <div class="grid-100">
        {!! Form::open(['id'=>'createTaskForm','url'=>URL::to(action('AdminController@postCreateTask'), [], env('HTTPS_ENABLED', true)),'class'=>'ui form']) !!}
        <div class="twelve wide field">
            <label>Title</label>
            {!! Form::text('title', '', ['maxlength'=>64]) !!}
        </div>
        <div class="five wide field">
            <label>Assign to User</label>
            <select name="assignee_id" class="ui search dropdown">
                <option value="0">Unassigned</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->displayname }}</option>
                @endforeach
            </select>
        </div>
        <div class="wide field">
            <label>Task Description</label>
            {!! Form::textarea('content') !!}
        </div>
        {!! Form::close() !!}
    </div>
    <div class="grid-100">
        <div class="actions text-right">
            <button id="saveTask" class="ui positive button" form="createTaskForm">
                Save Task
            </button>
        </div>
    </div>
@stop