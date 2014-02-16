@extends('layouts.master')
@section('content')
<div class="content-section-a">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Retrieve Account Information</h2>
                <p>We only offer two ways of retrieving your account information. You can either enter your username or your email and we will send instructions to your email.</p>
                <p>If you've forgot both your username and your email you must register with a new account. We are sorry for any inconviences this may cause.</p>
            </div>
        </div>
    </div>
</div>
<div class="content-section-b">
    <div class="container">
        <div class="row">
            <div id="alert"></div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <h3>Retrieve Password</h3>
                {{ Form::open(array('id'=>'retrieveWithUsername')) }}
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" />
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                {{ Form::close() }}
            </div>
            <div class="col-lg-6">
                <h3>Retrieve Username</h3>
                {{ Form::open(array('id'=>'retrieveWithEmail')) }}
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" />
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop
