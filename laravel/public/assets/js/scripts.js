$(function(){
    if($("#summernote").length > 0){
        jQuery.getScript("//cdnjs.cloudflare.com/ajax/libs/summernote/0.5.0/summernote.min.js", function(){
            $('head').append('<link type="text/css" rel="stylesheet" href="/assets/css/summernote.min.css">');
            $('#summernote').summernote();
        });
    }

    $("#retrieveWithUsername").submit(function(e){
        e.preventDefault();
        var formData = $("#retrieveWithUsername :input").serialize();
        $.post("/login/help/username", formData, function(data){
            var type;
            if(data.result === 'success')
                type = 'success'
            else
                type = 'danger'

            $("#alert").createAlert(type,  data.reason);

        }, 'json');
    });

    $("#retrieveWithEmail").submit(function(e){
        e.preventDefault();
        var formData = $("#retrieveWithEmail :input").serialize();
        $.post("/login/help/email", formData, function(data){
            var type;
            if(data.result === 'success')
                type = 'success'
            else
                type = 'danger'

            $("#alert").createAlert(type,  data.reason);

        }, 'json');

        $("#resetPassword").submit(function(e){
            e.preventDefault;
            var formData = $("#resetPassword :input").serialize();
            $.post('/login/help/reset', formData, function(data){
                if(data.result == 'success')
                    window.location = '/login';
                else
                    $("#alert").createAlert("danger", data.reason);
            });
        });
    });

    $(".datetimepicker").datetimepicker({
        useStrict: true
    });

    $('head').append('<link type="text/css" rel="stylesheet" href="/assets/css/datetimepicker.css">');

    if($("textarea").length > 0){
        jQuery.getScript("//cdnjs.cloudflare.com/ajax/libs/autosize.js/1.18.1/jquery.autosize.min.js", function(){
            $("textarea").autosize();
        });
    }

    if($(".prettyprint").length > 0){
        $.getScript('//cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.js', function(){
            $('head').append('<link type="text/css" rel="stylesheet" href="/assets/css/prettify.css">');
            prettyPrint();
        });
    }

    $("#login").submit(function(e){
        e.preventDefault();
        var formData = $("#login :input").serialize();
        $.post("/login", formData, function(data){
            if(data.result === "success"){
                window.location = '/';
            }else{
                $("#alert").createAlert('danger', data.reason);
            }
        }, 'json');
    });

    $("#generatepassword").click(function(){
        var password = $.password(12, true);
        $("#password").val(password);
        $("#password2").val(password);
    });

    $("#register").submit(function(e){
        e.preventDefault();
        var formData = $("#register :input").serialize();
        $.post("/register", formData, function(data){
            if(data.result == "failure"){
                $("#alert").createAlert("danger", data.reason);
                $("#recaptcha_reload").click();
                $("#recaptcha_response_field").val("");
            }else
                window.location = "/login";
        }, "json");
    });

    $("#changeSettings").submit(function(e){
        e.preventDefault();
        var formData = $("#changeSettings :input").serialize();
        $.post("/user/settings", formData, function(data){
            if(data.result == 'success')
                window.location.reload();
            else
                $("#alert").createAlert("danger", data.reason);
        }, "json");
    });

    $("#createPaste").submit(function(e){
        e.preventDefault();
        var formData = $("#createPaste :input").serialize();
        $.post("/paste/create", formData, function(data){
            if(data.result == 'success')
                window.location = data.reason;
            else
                $("#alert").createAlert("danger", data.reason);
        }, 'json');
    });

    $("#deletePaste").click(function(){
        var id = $("#paste").data('id');
        var _token = $("input[name='_token']").val();
        $.post('/paste/delete', {id:id,_token:_token}, function(data){
            if(data.result == 'success')
                window.location = '/paste/create'
        }, 'json');
    });

    $("#editPaste").click(function(){
        var id = $("#paste").data('id');
        var _token = $("input[name='_token']").val();
        $.post('/paste/edit/getForm', {id:id,_token:_token}, function(data){
            $("#box").empty().append(data);
            $("#editPaste").remove();
            jQuery.getScript("//cdnjs.cloudflare.com/ajax/libs/autosize.js/1.18.1/jquery.autosize.min.js", function(){
                $("textarea").autosize();
            });
            $("#editPasteForm").submit(function(e){
                e.preventDefault();
                var formData = $("#editPasteForm :input").serialize();
                $.post('/paste/edit', formData, function(data){
                    if(data.result == 'success')
                        window.location.reload();
                    else
                        $("#alert").createAlert("danger", data.reason);
                }, 'json')
            });
            $("#cancel").one('click', function(){
                window.location.reload();
            });
        });
    });

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=130750536973814";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
});

$.extend({
    password: function (length, special) {
        var iteration = 0;
        var password = "";
        var randomNumber;
        if(special == undefined){
            var special = false;
        }
        while(iteration < length){
            randomNumber = (Math.floor((Math.random() * 100)) % 94) + 33;
            if(!special){
                if ((randomNumber >=33) && (randomNumber <=47)) { continue; }
                if ((randomNumber >=58) && (randomNumber <=64)) { continue; }
                if ((randomNumber >=91) && (randomNumber <=96)) { continue; }
                if ((randomNumber >=123) && (randomNumber <=126)) { continue; }
            }
            iteration++;
            password += String.fromCharCode(randomNumber);
        }
        return password;
    }
});

$.fn.extend({
    createAlert: function(type,reason){
        $(this).empty().append("<div class='alert alert-"+type+"'>"+reason+"</div>");
    }
});
