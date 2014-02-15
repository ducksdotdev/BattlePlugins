@extends('layouts.master')
@section('content')
<div class="content-section-a">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Manage User Groups and Settings</h2>
            </div>
        </div>
    </div>
</div>
<div class="content-section-b">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>User Settings</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="changeSettingAlert"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                {{ Form::open(array('id'=>'getSetting')) }}
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" />
                </div>
                <div class="form-group">
                    <label for="setting">Setting:</label>
                    <input type="text" class="form-control" id="setting" name="setting" placeholder="Setting" />
                </div>
                <button class="btn btn-info" type="submit">Get</button>
                {{ Form::close() }}
            </div>
            <div class="col-lg-6">
                {{ Form::open(array('id'=>'setSetting')) }}
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" />
                </div>
                <div class="form-group">
                    <label for="setting">Setting:</label>
                    <input type="text" class="form-control" id="setting" name="setting" placeholder="Setting" />
                </div>
                <div class="form-group">
                    <label for="value">Value:</label>
                    <input type="text" class="form-control" id="value" name="value" placeholder="Value" />
                </div>
                <button class="btn btn-primary" type="submit">Set</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
<div class="content-section-a">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>User Groups</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="changeGroupsAlert"></div>
                {{ Form::open(array('id'=>'changeGroups')) }}
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" autocomplete="off" />
                </div>
                <div id="groups"></div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop
