<div id="alert"></div>
{{ Form::open(array('id'=>'editPasteForm')) }}
<div class="row">
    <div class="col-lg-12">
        <div id="alert"></div>
        {{ Form::open(array('id'=>'createPaste')) }}
        <input type="hidden" name="id" id="id" value="{{ $paste->id }}" />
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="title" class="form-control" id="title" name="title" placeholder="Title" value="{{ $paste->title }}" />
        </div>
        <div class="form-group">
            <label for="content">Content:</label>
            <textarea name="content" id="content" class="form-control">{{ $paste->content }}</textarea>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" id="private" name="private" @if($paste->private)checked@endif> Click here to make this paste private <small>(Only you will be able to view it)</small>
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button> <button class="btn btn-warning" id="cancel">Cancel</button>

        {{ Form::close() }}
    </div>
</div>
{{ Form::close() }}
