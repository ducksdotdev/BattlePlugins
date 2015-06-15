<!-- Create Task Modal -->
<div id="createTaskModal" class="ui modal">
    <div class="header">
        Create Task
    </div>
    <div class="content">
        <div class="description">
            {!! Form::open(['id'=>'createTaskForm','url'=>URL::to('/tasks/create', [], true),'class'=>'ui form']) !!}
            <div class="twelve wide field">
                <label>Title</label>
                {!! Form::text('title', '', ['maxlength'=>64]) !!}
            </div>
            <div class="five wide field">
                <label>Assign to User</label>
                <select name="assigned_to" class="ui search dropdown">
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
            <div class="fields">
                <div class="field">
                    <div class="ui toggle checkbox">
                        {!! Form::checkbox('public') !!}
                        <label>Allow <b>anyone</b> to see this task?</label>
                    </div>
                </div>
                <div class="field">
                    <small>(If checked, unregistered users will be able to view this task)</small>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="actions text-center">
        <div class="ui buttons">
            <button class="ui button">
                Cancel
            </button>
            <div class="or"></div>
            <button id="saveTask" class="ui positive button" form="createTaskForm">
                Save Task
            </button>
        </div>
    </div>
</div>
<!-- End Add Modal -->