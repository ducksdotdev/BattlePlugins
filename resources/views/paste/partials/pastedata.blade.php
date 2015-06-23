Created <span title="{{ $paste->created_at }}">{{ $paste->created_at->diffForHumans() }}</span>.
@if($paste->created_at != $paste->updated_at)
    Last modified <span title="{{ $paste->updated_at }}">{{ $paste->updated_at->diffForHumans() }}</span>.
@endif<br />
<div class="field">
    <label>
        Short URL:
        <a href="http://bplug.in/{{ $paste->slug }}" class="circular small ui icon button"><i class="icon external"></i></a>
    </label>
    <input type="text" onclick="select()" value="http://bplug.in/{{ $paste->slug }}" disabled />
</div>
<div class="field">
    <label>
        Raw URL:
        <a href="/{{ $paste->slug }}/raw" class="circular small ui icon button"><i class="icon external"></i></a>
    </label>
    <input type="text" onclick="select()" value="http://paste.battleplugins.com/{{ $paste->slug }}/raw" disabled />
</div>
<div class="field">
    <label>Download Link:
        <a href="/{{ $paste->slug }}/download" class="circular small ui icon button"><i class="icon external"></i></a>
    </label>
    <input type="text" onclick="select()" value="http://paste.battleplugins.com/{{ $paste->slug }}/download" disabled />
</div>