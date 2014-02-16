$(function(){

//    new WOW().init();

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
            e.preventDefault();
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

/*! WOW - v0.1.4 - 2014-02-12
 * Copyright (c) 2014 Matthieu Aussaguel; Licensed MIT */
//( function(){var a,b=[].slice,c=function(a,b){return function(){return a.apply(b,arguments)}};a=function(){var c,d,e,f,g,h,i,j,k;for(e=arguments[0],c=2<=arguments.length?b.call(arguments,1):[],g=e||{},i=0,j=c.length;j>i;i++){f=c[i],k=f||{};for(d in k)h=k[d],"object"==typeof g[d]?g[d]=a(g[d],h):g[d]||(g[d]=h)}return g},this.WOW=function(){function b(b){null==b&&(b={}),this.scrollCallback=c(this.scrollCallback,this),this.scrollHandler=c(this.scrollHandler,this),this.start=c(this.start,this),this.config=a(b,this.defaults),this.scrolled=!0}return b.prototype.defaults={boxClass:"wow",animateClass:"animated",offset:0},b.prototype.init=function(){var a;return"interactive"===(a=document.readyState)||"complete"===a?this.start():document.addEventListener("DOMContentLoaded",this.start)},b.prototype.start=function(){var a,b,c,d;if(this.element=window.document.documentElement,this.boxes=this.element.getElementsByClassName(this.config.boxClass),this.boxes.length){for(d=this.boxes,b=0,c=d.length;c>b;b++)a=d[b],this.applyStyle(a,!0);return window.addEventListener("scroll",this.scrollHandler,!1),window.addEventListener("resize",this.scrollHandler,!1),this.interval=setInterval(this.scrollCallback,50)}},b.prototype.stop=function(){return window.removeEventListener("scroll",this.scrollHandler,!1),window.removeEventListener("resize",this.scrollHandler,!1),null!=this.interval?clearInterval(this.interval):void 0},b.prototype.show=function(a){return this.applyStyle(a),a.className=""+a.className+" "+this.config.animateClass},b.prototype.applyStyle=function(a,b){var c,d,e;return d=a.getAttribute("data-wow-duration"),c=a.getAttribute("data-wow-delay"),e=a.getAttribute("data-wow-iteration"),a.setAttribute("style",this.customStyle(b,d,c,e))},b.prototype.customStyle=function(a,b,c,d){var e;return e=a?"visibility: hidden; -webkit-animation-name: none; -moz-animation-name: none; animation-name: none;":"visibility: visible;",b&&(e+="-webkit-animation-duration: "+b+"; -moz-animation-duration: "+b+"; animation-duration: "+b+";"),c&&(e+="-webkit-animation-delay: "+c+"; -moz-animation-delay: "+c+"; animation-delay: "+c+";"),d&&(e+="-webkit-animation-iteration-count: "+d+"; -moz-animation-iteration-count: "+d+"; animation-iteration-count: "+d+";"),e},b.prototype.scrollHandler=function(){return this.scrolled=!0},b.prototype.scrollCallback=function(){var a;return this.scrolled&&(this.scrolled=!1,this.boxes=function(){var b,c,d,e;for(d=this.boxes,e=[],b=0,c=d.length;c>b;b++)a=d[b],a&&(this.isVisible(a)?this.show(a):e.push(a));return e}.call(this),!this.boxes.length)?this.stop():void 0},b.prototype.offsetTop=function(a){var b;for(b=a.offsetTop;a=a.offsetParent;)b+=a.offsetTop;return b},b.prototype.isVisible=function(a){var b,c,d,e,f;return c=a.getAttribute("data-wow-offset")||this.config.offset,f=window.pageYOffset,e=f+this.element.clientHeight-c,d=this.offsetTop(a),b=d+a.clientHeight,e>=d&&b>=f},b}()}).call(this);
