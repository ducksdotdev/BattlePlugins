<div id="userGroups">
    @foreach($groups as $group)
    <div class="checkbox">
        <label>
            <input type="checkbox" id="group-{{ $group }}" name="group-{{ $group }}" @if(in_array($group, $has)) checked @endif> {{ $groupNames[$group] }}
        </label>
    </div>
    @endforeach
    <button type="submit" class="btn btn-primary">Save</button>
</div>
