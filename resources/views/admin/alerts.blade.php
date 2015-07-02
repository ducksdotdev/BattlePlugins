@extends('admin.layouts.master')
@section('content')
    {!! Form::open(['url'=>URL::to('/tools/alert', [], env('HTTPS_ENABLED', true)), 'class'=>'ui fluid form']) !!}
    @if(count($errors) > 0)
        <div class="ui message red">
            There was an error processing your request!
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @elseif(session()->has('success'))
        <div class="ui message green">
            {{ session()->get('success') }}
        </div>
    @endif
    <div class="grid-100">
        <h2>{{ $title }}</h2>

        <div class="field">
            {!! Form::label('content', 'Alert Content') !!}
            {!! Form::textarea('content') !!}
        </div>
        <div class="field">
            {!! Form::label('color', 'Color') !!}
            @foreach(config('colors') as $color)
                <div class="grid-25">
                    <div class="ui message {{ $color }}">
                        <div class="ui radio checkbox">
                            {!! Form::radio('color', ucfirst($color)) !!}
                            <label>{{ ucfirst($color) }}</label>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="grid-100 text-right">
        {!! Form::submit('Save Changes', ['class'=>'ui button primary']) !!}
    </div>
    {!! Form::close() !!}
@stop