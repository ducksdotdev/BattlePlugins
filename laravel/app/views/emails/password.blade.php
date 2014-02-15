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
        <p>Hello {{ $username }},</p>
        <p>A password reset was requested for your account at <a href="http://battleplugins.com/">BattlePlugins</a>. If this was not you who sent the request, please ignore this email and we won't bother you again. If you did request this email, please click the following link to reset your password:</p>
        <p class="text-center"><a href="http://battleplugins.com/login/help/reset?key={{ $key }}">http://battleplugins.com/login/help/reset?key={{ $key }}</a></p>
    </div>
</div>
</body>
</html>
