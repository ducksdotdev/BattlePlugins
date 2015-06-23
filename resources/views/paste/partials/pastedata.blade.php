<div class="grid-100 ui form">
    <div class="three fields">
        <div class="field">
            <label>
                Short URL:
            </label>
            <div class="ui action input">
                <input type="text" onclick="select()" value="http://bplug.in/{{ $paste->slug }}" readonly />
                <a class="ui right icon button" href="http://bplug.in/{{ $paste->slug }}">
                    <i class="external icon"></i>
                </a>
            </div>
        </div>
        <div class="field">
            <label>
                Raw URL:
            </label>
            <div class="ui action input">
                <input type="text" onclick="select()" value="http://paste.battleplugins.com/{{ $paste->slug }}/raw" readonly />
                <a class="ui right icon button" href="/{{ $paste->slug }}/raw">
                    <i class="external icon"></i>
                </a>
            </div>
        </div>
        <div class="field">
            <label>
                Download Link:
            </label>
            <div class="ui action input">
                <input type="text" onclick="select()" value="http://paste.battleplugins.com/{{ $paste->slug }}/download" readonly />
                <a class="ui right icon button" href="/{{ $paste->slug }}/download">
                    <i class="external icon"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="text-center">
        <small>Click on a URL to highlight it for copying.</small>
    </div>
</div>