@extends('layouts.master')
@section('content')
<div class="content-section-a">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2>BattlePaste</h2>
                <p>BattlePlugins' personal pastebin. Create pastes for all different types of programming languages and share the links with anyone.</p>
            </div>
            @if(count($pastes) > 0)
            <div class="col-lg-5 col-lg-offset-1">
                <h2>Your Pastes <small>({{ count($pastes) }})</small></h2>
                <div class="list-group">
                    @foreach($pastes as $paste)
                    <a href="/paste/{{ $paste->id }}" class="list-group-item">
                        <span class="badge">{{ $paste->id }}</span>
                        <strong>{{{ $paste->title }}}</strong> {{ $prettyTime[$paste->id] }}
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<div class="content-section-b">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>Create</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="alert"></div>
                {{ Form::open(array('id'=>'createPaste')) }}
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="title" class="form-control" id="title" name="title" placeholder="Title" />
                </div>
                <div class="form-group">
                    <label for="content">Content:</label>
                    <textarea name="content" id="content" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="delete">Deletion Date: <small>(Leave blank to never delete)</small></label>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="input-group datetimepicker">
                                <input type="text" class="form-control" id="delete" name="delete" placeholder="Deletion Date" />
                                <span class="input-group-addon"><i class="fa fa-calendar pointer"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <small>Click the calendar to open the date-time select widget.</small>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="lang">Language:</label>
                    <div class="row">
                        <div class="col-lg-4">
                            <select id="lang" name="lang" class="form-control">
                                <option value="">Auto Detect</option>
                                <option value="plain">Plain Text</option>
                                <option value="apollo">Apollo</option>
                                <option value="basic">Basic</option>
                                <option value="css">CSS</option>
                                <option value="dart">Dart</option>
                                <option value="erlang">Erlang</option>
                                <option value="go">Go</option>
                                <option value="html">HTML</option>
                                <option value="java">Java</option>
                                <option value="js">Javascript</option>
                                <option value="lisp">Lisp</option>
                                <option value="lua">Lua</option>
                                <option value="matlab">MatLab</option>
                                <option value="mumps">Mumps</option>
                                <option value="pascal">Pascal</option>
                                <option value="php">PHP</option>
                                <option value="proto">Proto</option>
                                <option value="scala">Scala</option>
                                <option value="sql">SQL</option>
                                <option value="tex">Tex</option>
                                <option value="vb">Visual Basic</option>
                                <option value="vhdl">WikiCreole</option>
                                <option value="yaml">YAML</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" id="private" name="private"> Click here to make this paste private <small>(Only you will be able to view it)</small>
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop
