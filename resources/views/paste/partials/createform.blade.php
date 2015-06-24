{!! Form::open(['id'=>'createPasteForm','url'=>URL::to('/create', [], env('HTTPS_ENABLED', true)), 'class'=>'ui form']) !!}
<div class="field">
    <label for="title">Title
        <small>(Optional. End your title with the file type to use
            that language's syntax highlighter. IE: ending a file with .css will use css
            highlighting)
        </small>
    </label>
    {!! Form::text('title', '', ['maxlength'=>64]) !!}
</div>
<div class="wide field">
    <label for="content">
        Paste Content
        <small>Max length {{ env("PASTE_MAX_LEN", 500000) }} characters.</small>
    </label>
    {!! Form::textarea('content', '', ['maxlength'=>env("PASTE_MAX_LEN", 500000), 'class'=>'monospace']) !!}
</div>
<div class="field">
    <div class="ui toggle checkbox">
        {!! Form::checkbox('public') !!}
        <label>Allow <b>anyone</b> to see this paste?</label>
    </div>
</div>
<div class="ui buttons pull-right">
    <button class="ui positive button">
        Save Paste
    </button>
</div>
{!! Form::close() !!}