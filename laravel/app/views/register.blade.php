@extends('layouts.master')
@section('content')
<div class="content-section-a">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>Register</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">Registration is currently open. Fill out the form below and click "Register"</div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>Benefits of Registering</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        Wonder what the benefits are of registering?
                        <ul>
                            <li>BattlePlugins Web API</li>
                            <li>BattlePaste</li>
                            <li>Special tools</li>
                            <li>Higher priority support</li>
                            <li>Ability to sign up to our newsletter</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content-section-b">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div id="alert"></div>
                {{ Form::open(array('id'=>'register','role'=>'form')) }}
                <div class="form-group">
                    <label for="username">Username (Minecraft name, this cannot be changed):</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" />
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" placeholder="Password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password2">Password Again:</label>
                    <input type="password" name="password2" id="password2" placeholder="Password" class="form-control">
                </div>
                <div clas
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" />
                </div>
                <div class="form-group">
                    <label for="recaptcha_response_field">Prove that you're human:</label>
                    {{ Form::captcha(array('theme' => 'white')) }}
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" id="newsletter" name="newsletter" checked> Signup for our newsletter?
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" id="tos" name="tos"> Click to agree to our <a href="/tos" target="_blank">Terms of Service</a> and <a href="/privacy" target="_blank">Privacy Policy</a>.
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop
