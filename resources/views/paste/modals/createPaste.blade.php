<!-- Create Paste Modal -->
<div id="createPasteModal" class="ui modal">
    <div class="header">
        Create Paste
    </div>
    <div class="content">
        <div class="description">
            {!! Form::open(['id'=>'createPasteForm','url'=>URL::to('/create', [], env('HTTPS_ENABLED', true)),
            'class'=>'ui form']) !!}
            <div class="twelve wide field">
                <label>Title</label>
                {!! Form::text('title', '', ['maxlength'=>64]) !!}
            </div>
            <div class="wide field">
                <label>Paste Content <small>Max length {{ env("PASTE_MAX_LEN", 500000) }} characters.</small></label>
                {!! Form::textarea('content', '', ['maxlength'=>env("PASTE_MAX_LEN", 500000), 'class'=>'monospace']) !!}
            </div>
            <div class="field">
                <div class="ui toggle checkbox">
                    {!! Form::checkbox('public') !!}
                    <label>Allow <b>anyone</b> to see this paste?</label>
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
            <button id="savePaste" class="ui positive button" form="createPasteForm">
                Save Paste
            </button>
        </div>
    </div>
</div>
<!-- End Modal -->