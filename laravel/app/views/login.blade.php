@extends('layouts.master')
@section('content')
<div class="content-section-a">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Please Login</h2>
                <p>Not registered yet? <a href="/register">Sign up here</a>.</p>
                <p>Forgot your username or password? <a href="/login/help">Retrieve them here</a>.</p>
            </div>
        </div>
    </div>
</div>
<div class="content-section-b">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div id="alert"></div>
                {{ Form::open(array('id'=>'login','role'=>'form')) }}
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" />
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" id="rememberme" name="rememberme"> Remember?
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop
