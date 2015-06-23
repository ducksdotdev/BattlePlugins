<div class="grid-100 ui form">
    <p>
        Created <span title="{{ $paste->created_at }}">{{ $paste->created_at->diffForHumans() }}</span>.
        @if($paste->created_at != $paste->updated_at)
            Last modified <span title="{{ $paste->updated_at }}">{{ $paste->updated_at->diffForHumans() }}</span>.
        @endif
    </p>
    <div class="three fields">
        <div class="field">
            <label>
                <a href="http://bplug.in/{{ $paste->slug }}"><i class="icon external"></i></a>
                Short URL:
            </label>
            <input type="text" onclick="select()" value="http://bplug.in/{{ $paste->slug }}" readonly />
        </div>
        <div class="field">
            <label>
                <a href="/{{ $paste->slug }}/raw"><i class="icon external"></i></a>
                Raw URL:
            </label>
            <input type="text" onclick="select()" value="http://paste.battleplugins.com/{{ $paste->slug }}/raw" readonly />
        </div>
        <div class="field">
            <label>
                <a href="/{{ $paste->slug }}/download"><i class="icon external"></i></a>
                Download Link:
            </label>
            <input type="text" onclick="select()" value="http://paste.battleplugins.com/{{ $paste->slug }}/download" readonly />
        </div>
    </div>
</div>