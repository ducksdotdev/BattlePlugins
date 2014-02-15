@extends('layouts.master')
@section('content')
<div class="content-section-a">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Change/Update Settings</h2>
            </div>
        </div>
    </div>
</div>
<div class="content-section-b">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div id="alert"></div>
                {{ Form::open(array('id'=>'changeSettings','role'=>'form')) }}
                <div class="form-group">
                    <label for="npassword">Password: <small>(Leave blank to keep old password)</small></label>
                    <input type="password" name="npassword" id="npassword" placeholder="Password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="npassword2">Password Again: <small>(Leave blank to keep old password)</small></label>
                    <input type="password" name="npassword2" id="npassword2" placeholder="Password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ $email }}" />
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" id="newsletter" name="newsletter" @if($newsletter) checked @endif> Signup for our newsletter?
                    </label>
                </div>
                <hr />
                <div class="form-group">
                    <label for="password">Password: <small>(For confirmation)</small></label>
                    <input type="password" name="password" id="password" placeholder="Password" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Change Settings</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop
