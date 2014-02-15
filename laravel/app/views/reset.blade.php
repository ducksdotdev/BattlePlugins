@extends('layouts.master')
@section('content')
<div class="content-section-a">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Reset Password</h2>
            </div>
        </div>
    </div>
</div>
<div class="content-section-b">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div id="alert"></div>
                {{ Form::open(array('id'=>'resetPassword')) }}
                <input type="hidden" name="key" id="key" value="{{ $key }}" />
                <div class="form-group">
                    <label for="npassword">New Password:</label>
                    <input type="password" name="npassword" id="npassword" placeholder="Password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="npassword2">New Password Again:</label>
                    <input type="password" name="npassword2" id="npassword2" placeholder="Password" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Change Password</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

@stop
