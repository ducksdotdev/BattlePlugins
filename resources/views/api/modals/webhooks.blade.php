<!-- Webhooks Modal -->
<div id="manageWebhooksModal" class="ui modal small">
    <div class="header">
        Manage Webhooks
    </div>
    <div class="content">
        <div class="description">
            {!! Form::open(['id'=>'manageWebhooksForm','url'=>URL::to('/webhooks', [], env('HTTPS_ENABLED', true)),
            'class'=>'ui form']) !!}
            <div class="thirteen wide field">
                <label>URL <small>Leave blank to delete webhook.</small></label>
                {!! Form::text('url', '', ['id'=>'urlInput']) !!}
            </div>
            <div class="eight wide field">
                <label>Event</label>
                <select id="eventSelect" name="event" class="ui dropdown">
                    <option value="-1" disabled selected>Select Event..</option>
                    @foreach($webhooks as $hook => $value)
                        <option value="{{ $value }}">{{ $hook }}</option>
                    @endforeach
                </select>
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
            <button id="saveWebhook" class="ui positive button" form="manageWebhooksForm">
                Save
            </button>
        </div>
    </div>
</div>
<!-- End Modal -->
@section('extraScripts')
    <script type="text/javascript">
        $("#manageWebhooks").click(function () {
            $("#manageWebhooks").addClass("loading");
            $("#manageWebhooksModal").modal({
                onVisible: function () {
                    $("#manageWebhooks").removeClass("loading");
                }
            }).modal('show');
        });

        var myHooks = [];
        @foreach($myHooks as $hook)
        myHooks['{{ $hook->event }}'] = '{{$hook->url}}';
        @endforeach

        $("#eventSelect").change(function(){
                    var val = $("option:selected", this).val();
                    $("#urlInput").val(myHooks[val]);
                });
    </script>
@stop