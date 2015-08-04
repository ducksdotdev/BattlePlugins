@extends('layouts.admin')
@section('content')
    <div class="grid-100">
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
        <div class="field">
            {!! Form::label('content', 'Alert Content') !!}
            {!! Form::text('content') !!}
        </div>
        <div class="text-right">
            {!! Form::submit('Save Changes', ['class'=>'ui button primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
    @if(count($alerts))
        <div class="grid-100 grid-parent">
            <div class="grid-100">
                <h3>Existing Alerts</h3>
            </div>
            @foreach($alerts as $alert)
                <div class="grid-100">
                    <div class="ui message">
                        <p>{{ $alert->content }}</p>
                    </div>
                    {!! Form::open(['url'=>URL::to('/tools/alert/admin-delete/'.$alert->id, [], env('HTTPS_ENABLED', true)), 'class'=>'ui fluid form inline']) !!}
                    <button class="ui button icon circular red mini"><i class="icon remove"></i></button>
                    {!! Form::close() !!}
                    <small>
                        Belongs to
                        @if(count($alert->users))
                            @foreach($alert->users as $user)
                                {{ $user->displayname }}
                            @endforeach
                        @else
                            nobody.
                        @endif
                    </small>
                </div>
                <br/>
            @endforeach
        </div>
    @endif
@stop