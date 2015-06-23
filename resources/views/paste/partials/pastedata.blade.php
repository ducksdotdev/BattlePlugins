Created <span title="{{ $paste->created_at }}">{{ $paste->created_at->diffForHumans() }}</span>.
@if($paste->created_at != $paste->updated_at)
    Last modified <span title="{{ $paste->updated_at }}">{{ $paste->updated_at->diffForHumans() }}</span>.
@endif<br />
Short URL: <a href="http://bplug.in/{{ $paste->slug }}">https://bplug.in/{{ $paste->slug }}</a>
<button data-url="http://bplug.in/{{ $paste->slug }}" class="copyable circular small ui icon button"><i class="icon copy"></i></button><br/>
Raw URL: <a href="/{{ $paste->slug }}/raw">https://paste.battleplugins.com/{{ $paste->slug }}/raw</a>
<button data-url="https://paste.battleplugins.com/{{ $paste->slug }}/raw" class="copyable circular small ui icon button"><i class="icon copy"></i></button><br/>
Download Link: <a href="/{{ $paste->slug }}/download">https://paste.battleplugins.com/{{ $paste->slug }}/download</a>
<button data-url="https://paste.battleplugins.com/{{ $paste->slug }}/download" class="copyable circular small ui icon button"><i class="icon copy"></i></button>