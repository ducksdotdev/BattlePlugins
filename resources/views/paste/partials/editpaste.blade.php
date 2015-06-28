<div class="grid-container">
    {!! Form::open(['id'=>'editPasteForm','url'=>URL::to('/edit', [], env('HTTPS_ENABLED', true)), 'class'=>'ui form']) !!}
    {!! Form::hidden('id', $paste->id) !!}
    <div class="grid-100">
        {!! Form::textarea('content', $content, ['maxlength'=>env("PASTE_MAX_LEN", 500000), 'class'=>'monospace']) !!}
    </div>
    <div class="grid-100 text-right">
        <button class="ui positive button">
            Edit Paste
        </button>
    </div>
    {!! Form::close() !!}
</div>