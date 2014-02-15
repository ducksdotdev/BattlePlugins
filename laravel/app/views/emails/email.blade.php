<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <style type="text/css">
        .panel {
            margin-bottom: 20px;
            background-color: #ffffff;
            border: 1px solid transparent;
            border-radius: 4px;
            -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
        }
        .panel-body {
            padding: 15px;
        }
        .panel-heading {
            padding: 10px 15px;
            border-bottom: 1px solid transparent;
            border-top-right-radius: 3px;
            border-top-left-radius: 3px;
        }
        .panel-footer {
            padding: 10px 15px;
            background-color: #f5f5f5;
            border-top: 1px solid #dddddd;
            border-bottom-right-radius: 3px;
            border-bottom-left-radius: 3px;
            text-align: right;
        }
        .panel-primary {
            border-color: #428bca;
        }
        .panel-primary > .panel-heading {
            color: #ffffff;
            background-color: #428bca;
            border-color: #428bca;
        }
        .panel-primary > .panel-heading + .panel-collapse .panel-body {
            border-top-color: #428bca;
        }
        .panel-primary > .panel-footer + .panel-collapse .panel-body {
            border-bottom-color: #428bca;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
<p class="text-center"><img src="http://battleplugins.com/assets/img/logo.png"></p>
<div class="panel panel-primary">
    <div class="panel-body">
        <p>Hello,</p>
        <p>You have asked for your username at <a href="http://battleplugins.com">BattlePlugins</a>. If you did not send this request, please ignore this email and we won't bother you again.</p>
        <p class="text-center">Your login username is <strong>{{ $username }}</strong>. <a href="http://battleplugins.com/login">Click here to login</a>.</p>
    </div>
</div>
</body>
</html>
