<div id="short-pastedata" class="grid-100 ui form hidden">
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
                Short Raw URL:
            </label>
            <div class="ui action input">
                <input type="text" onclick="select()" value="http://bplug.in/{{ Domain::shorten(url($paste->slug .'/raw')) }}" readonly />
                <a class="ui right icon button" href="http://bplug.in/{{ Domain::shorten(url($paste->slug .'/raw')) }}">
                    <i class="external icon"></i>
                </a>
            </div>
        </div>
        <div class="field">
            <label>
                Short Download Link:
            </label>
            <div class="ui action input">
                <input type="text" onclick="select()" value="http://bplug.in/{{ Domain::shorten(url($paste->slug .'/download')) }}" readonly />
                <a class="ui right icon button" href="http://bplug.in/{{ Domain::shorten(url($paste->slug .'/download')) }}">
                    <i class="external icon"></i>
                </a>
            </div>
        </div>
    </div>
</div>