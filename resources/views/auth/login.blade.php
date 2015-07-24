<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    @include('mobilecolor')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BattleAdmin :: BattlePlugins Administration Panel</title>
    <link rel="icon" href="/assets/img/bp.png"/>

    <!--        Styles -->
    <link rel="stylesheet" href="/assets/css/semantic.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.0/components/icon.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.0/components/menu.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/unsemantic/0/unsemantic-grid-responsive.css">
    <link rel="stylesheet" href="/assets/css/styles.css" type="text/css"/>
    <!--        End Styles -->
    <!--        Scripts -->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.2/semantic.min.js"></script>
    <!--       End Scripts -->
</head>
<body>
<div class="grid-container">
    <div class="grid-65 grid-parent grid-center">
        <div class="task-header">
            <div class="grid-container">
                <div class="grid-100">
                    <h2>battleplugins</h2>
                </div>
            </div>
        </div>
        <div class="ui divided list">
            <div class="item">
                @if(count($errors) > 0)
                    <div id="loginError" class="ui message error">
                        There was an error logging you in!
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        @if($throttles)
                            <p>You have {{ 5 - $attempts }} attempts remaining!</p>
                        @endif
                    </div>
                @endif
                {!! Form::open(['url'=>URL::to('/auth/login', [], env('HTTPS_ENABLED', true)),'class'=>'ui form']) !!}
                <div class="two fields">
                    <div class="field">
                        <label>Email</label>
                        {!! Form::text('email', '', ['id'=>'email','placeholder'=>'Email']) !!}
                    </div>
                    <div class="field">
                        <label>Password</label>
                        {!! Form::password('password', ['placeholder'=>'Password']) !!}
                    </div>
                </div>
                <div class="ui toggle checkbox">
                    <label>Remember Me?</label>
                    {!! Form::checkbox('remember') !!}
                </div>
                <span class="pull-right">
                    @if(ServerSetting::get('registration'))
                        <a href="#">Register</a> |
                    @endif
                    <a href="/password/email">Forgot Password</a>
                    <button id="loginButton" class="ui button green">Login</button>
                </span>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@include('footer')
<script type="text/javascript">
    $('.ui.checkbox').checkbox();
</script>
</body>
</html>