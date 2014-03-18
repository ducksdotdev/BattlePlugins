$(function () {
    if ($("#summernote").length > 0) {
        jQuery.getScript("//cdnjs.cloudflare.com/ajax/libs/summernote/0.5.0/summernote.min.js", function () {
            $('head').append('<link type="text/css" rel="stylesheet" href="/assets/css/summernote.min.css">');
            $('#summernote').summernote();
        });
    }

    $("#retrieveWithUsername").submit(function (e) {
        e.preventDefault();
        var formData = $("#retrieveWithUsername :input").serialize();
        $.post("/login/help/username", formData, function (data) {
            var type;
            if (data.result === 'success')
                type = 'success'
            else
                type = 'danger'

            $("#alert").createAlert(type, data.reason);

        }, 'json');
    });

    $("#retrieveWithEmail").submit(function (e) {
        e.preventDefault();
        var formData = $("#retrieveWithEmail :input").serialize();
        $.post("/login/help/email", formData, function (data) {
            var type;
            if (data.result === 'success')
                type = 'success'
            else
                type = 'danger'

            $("#alert").createAlert(type, data.reason);

        }, 'json');

        $("#resetPassword").submit(function (e) {
            e.preventDefault();
            var formData = $("#resetPassword :input").serialize();
            $.post('/login/help/reset', formData, function (data) {
                if (data.result == 'success')
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

    if ($("textarea").length > 0) {
        jQuery.getScript("//cdnjs.cloudflare.com/ajax/libs/autosize.js/1.18.1/jquery.autosize.min.js", function () {
            $("textarea").autosize();
        });
    }

    if ($(".prettyprint").length > 0) {
        $.getScript('//cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.js', function () {
            $('head').append('<link type="text/css" rel="stylesheet" href="/assets/css/prettify.css">');
            prettyPrint();
        });
    }

    $("#login").submit(function (e) {
        e.preventDefault();
        var formData = $("#login :input").serialize();
        $.post("/login", formData, function (data) {
            if (data.result === "success") {
                window.location = '/';
            } else {
                $("#alert").createAlert('danger', data.reason);
            }
        }, 'json');
    });

    $("#generatepassword").click(function () {
        var password = $.password(12, true);
        $("#password").val(password);
        $("#password2").val(password);
    });

    $("#register").submit(function (e) {
        e.preventDefault();
        var formData = $("#register :input").serialize();
        $.post("/register", formData, function (data) {
            if (data.result == "failure") {
                $("#alert").createAlert("danger", data.reason);
                $("#recaptcha_reload").click();
                $("#recaptcha_response_field").val("");
            } else
                window.location = "/login";
        }, "json");
    });

    $("#changeSettings").submit(function (e) {
        e.preventDefault();
        var formData = $("#changeSettings :input").serialize();
        $.post("/user/settings", formData, function (data) {
            if (data.result == 'success')
                window.location.reload();
            else
                $("#alert").createAlert("danger", data.reason);
        }, "json");
    });

    $("#createPaste").submit(function (e) {
        e.preventDefault();
        var formData = $("#createPaste :input").serialize();
        $.post("/paste/create", formData, function (data) {
            if (data.result == 'success')
                window.location = data.reason;
            else
                $("#alert").createAlert("danger", data.reason);
        }, 'json');
    });

    $("#deletePaste").click(function () {
        var id = $("#paste").data('id');
        var _token = $("input[name='_token']").val();
        $.post('/paste/delete', {id: id, _token: _token}, function (data) {
            if (data.result == 'success')
                window.location = '/paste/create'
        }, 'json');
    });

    $("#editPaste").click(function () {
        var id = $("#paste").data('id');
        var _token = $("input[name='_token']").val();
        $.post('/paste/edit/getForm', {id: id, _token: _token}, function (data) {
            $("#box").empty().append(data);
            $("#editPaste").remove();
            jQuery.getScript("//cdnjs.cloudflare.com/ajax/libs/autosize.js/1.18.1/jquery.autosize.min.js", function () {
                $("textarea").autosize();
            });
            $("#editPasteForm").submit(function (e) {
                e.preventDefault();
                var formData = $("#editPasteForm :input").serialize();
                $.post('/paste/edit', formData, function (data) {
                    if (data.result == 'success')
                        window.location.reload();
                    else
                        $("#alert").createAlert("danger", data.reason);
                }, 'json')
            });
            $("#cancel").one('click', function () {
                window.location.reload();
            });
        });
    });

    $("#addPlugin").click(function(e){
        if($("#addPluginForm").length == 0){
            $.get("/ajax/plugins/addPluginForm", function(data){
                $("#plugins").prepend(data);
                $("#pluginSlug").keyup(function(){
                    var slug = $(this).val();
                    if(slug.length > 0 && /^[a-zA-Z0-9- ]*$/.test(str) !== false){
                        $.getJSON("/api/curse/project/"+slug, function(data){
                            if(data.result != "error"){
                                $("#pluginName").empty().append('<a href="http://dev.bukkit.org/bukkit-plugins/'+data.slug+'" target="_blank">'+data.name+'</a>');
                                $("#addPluginPanel").removeClass("panel-danger").addClass("panel-primary");
                                $("#addPluginForm button").prop("disabled", false);
                                $("#inputGroup").removeClass("has-error");
                            }else{
                                $("#addPluginPanel").removeClass("panel-primary").addClass("panel-danger");
                                $("#inputGroup").addClass("has-error");
                                $("#addPluginForm button").prop("disabled", true);
                                $("#pluginName").empty();
                            }
                        });
                    }else{
                        $("#addPluginPanel").removeClass("panel-primary").addClass("panel-danger");
                        $("#inputGroup").addClass("has-error");
                        $("#addPluginForm button").prop("disabled", true);
                        $("#pluginName").empty();
                    }
                });

                $("#addPluginForm").submit(function(e){
                    e.preventDefault();
                    var formData = $("#addPluginForm :input").serialize();
                    $.post("/plugins/manage/add", formData, function(data){
                        if(data.result == "failure"){
                            $("#alert").createAlert('danger', data.reason);
                        }else if(data.result == "success"){
                            window.location.reload();
                        }
                    });
                });
            })
        }
    });

    $("a[href='#deletePlugin']").click(function(){
        var plugin = $(this).data('plugin');
        if(confirm("Are you sure you want to delete this? This cannot be undone.")){
            $.get("/plugins/manage/delete/"+plugin, function(){
                $("#"+plugin).fadeOut(500, function() { $(this).remove(); });
            });
        }
    });

    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=130750536973814";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
});

$.extend({
    password: function (length, special) {
        var iteration = 0;
        var password = "";
        var randomNumber;
        if (special == undefined) {
            var special = false;
        }
        while (iteration < length) {
            randomNumber = (Math.floor((Math.random() * 100)) % 94) + 33;
            if (!special) {
                if ((randomNumber >= 33) && (randomNumber <= 47)) {
                    continue;
                }
                if ((randomNumber >= 58) && (randomNumber <= 64)) {
                    continue;
                }
                if ((randomNumber >= 91) && (randomNumber <= 96)) {
                    continue;
                }
                if ((randomNumber >= 123) && (randomNumber <= 126)) {
                    continue;
                }
            }
            iteration++;
            password += String.fromCharCode(randomNumber);
        }
        return password;
    }
});

$.fn.extend({
    createAlert: function (type, reason) {
        $(this).empty().append("<div class='alert alert-" + type + "'>" + reason + "</div>");
    }
});
/**
 * Progress.js v0.1.0
 * https://github.com/usablica/progress.js
 * MIT licensed
 *
 * Copyright (C) 2013 usabli.ca - Afshin Mehrabani (@afshinmeh)
 */

(function (root, factory) {
    if (typeof exports === 'object') {
        // CommonJS
        factory(exports);
    } else if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['exports'], factory);
    } else {
        // Browser globals
        factory(root);
    }
}(this, function (exports) {
    //Default config/variables
    var VERSION = '0.1.0';

    /**
     * ProgressJs main class
     *
     * @class ProgressJs
     */
    function ProgressJs(obj) {

        if (typeof obj.length != 'undefined') {
            this._targetElement = obj;
        } else {
            this._targetElement = [obj];
        }

        if (typeof window._progressjsId === 'undefined')
            window._progressjsId = 1;

        if (typeof window._progressjsIntervals === 'undefined')
            window._progressjsIntervals = {};

        this._options = {
            //progress bar theme
            theme: 'blue',
            //overlay mode makes an overlay layer in the target element
            overlayMode: false,
            //to consider CSS3 transitions in events
            considerTransition: true
        };
    }

    /**
     * Start progress for specific element(s)
     *
     * @api private
     * @method _createContainer
     */
    function _startProgress() {

        //call onBeforeStart callback
        if (typeof this._onBeforeStartCallback != 'undefined') {
            this._onBeforeStartCallback.call(this);
        }

        //create the container for progress bar
        _createContainer.call(this);

        for (var i = 0, elmsLength = this._targetElement.length; i < elmsLength; i++) {
            _setProgress.call(this, this._targetElement[i]);
        }
    }

    /**
     * Set progress bar for specific element
     *
     * @api private
     * @method _setProgress
     * @param {Object} targetElement
     */
    function _setProgress(targetElement) {

        //if the target element already as `data-progressjs`, ignore the init
        if (targetElement.hasAttribute("data-progressjs"))
            return;

        //get target element position
        var targetElementOffset = _getOffset.call(this, targetElement);

        targetElement.setAttribute("data-progressjs", window._progressjsId);

        var progressElementContainer = document.createElement('div');
        progressElementContainer.className = 'progressjs-progress progressjs-theme-' + this._options.theme;


        //set the position percent elements, it depends on targetElement tag
        if (targetElement.tagName.toLowerCase() === 'body') {
            progressElementContainer.style.position = 'fixed';
        } else {
            progressElementContainer.style.position = 'absolute';
        }

        progressElementContainer.setAttribute("data-progressjs", window._progressjsId);
        var progressElement = document.createElement("div");
        progressElement.className = "progressjs-inner";

        //create an element for current percent of progress bar
        var progressPercentElement = document.createElement('div');
        progressPercentElement.className = "progressjs-percent";
        progressPercentElement.innerHTML = "1%";

        progressElement.appendChild(progressPercentElement);

        if (this._options.overlayMode && targetElement.tagName.toLowerCase() === 'body') {
            //if we have `body` for target element and also overlay mode is enable, we should use a different
            //position for progress bar container element
            progressElementContainer.style.left = 0;
            progressElementContainer.style.right = 0;
            progressElementContainer.style.top = 0;
            progressElementContainer.style.bottom = 0;
        } else {
            //set progress bar container size and offset
            progressElementContainer.style.left = targetElementOffset.left + 'px';
            progressElementContainer.style.top = targetElementOffset.top + 'px';
            progressElementContainer.style.width = targetElementOffset.width + 'px';

            if (this._options.overlayMode) {
                progressElementContainer.style.height = targetElementOffset.height + 'px';
            }
        }

        progressElementContainer.appendChild(progressElement);

        //append the element to container
        var container = document.querySelector('.progressjs-container');
        container.appendChild(progressElementContainer);

        _setPercentFor(targetElement, 1);

        //and increase the progressId
        ++window._progressjsId;
    }

    /**
     * Set percent for all elements
     *
     * @api private
     * @method _setPercent
     * @param {Number} percent
     */
    function _setPercent(percent) {
        for (var i = 0, elmsLength = this._targetElement.length; i < elmsLength; i++) {
            _setPercentFor.call(this, this._targetElement[i], percent);
        }
    }

    /**
     * Set percent for specific element
     *
     * @api private
     * @method _setPercentFor
     * @param {Object} targetElement
     * @param {Number} percent
     */
    function _setPercentFor(targetElement, percent) {
        var self = this;

        //prevent overflow!
        if (percent >= 100)
            percent = 100;

        if (targetElement.hasAttribute("data-progressjs")) {
            //setTimeout for better CSS3 animation applying in some cases
            setTimeout(function () {

                //call the onprogress callback
                if (typeof self._onProgressCallback != 'undefined') {
                    self._onProgressCallback.call(self, targetElement, percent);
                }

                var percentElement = _getPercentElement(targetElement);
                percentElement.style.width = parseInt(percent) + '%';

                var percentElement = percentElement.querySelector(".progressjs-percent");
                var existingPercent = parseInt(percentElement.innerHTML.replace('%', ''));

                //start increase/decrease the percent element with animation
                (function (percentElement, existingPercent, currentPercent) {

                    var increasement = true;
                    if (existingPercent > currentPercent) {
                        increasement = false;
                    }

                    var intervalIn = 10;

                    function changePercentTimer(percentElement, existingPercent, currentPercent) {
                        //calculate the distance between two percents
                        var distance = Math.abs(existingPercent - currentPercent);
                        if (distance < 3) {
                            intervalIn = 30;
                        } else if (distance < 20) {
                            intervalIn = 20;
                        } else {
                            intervanIn = 1;
                        }

                        if ((existingPercent - currentPercent) != 0) {
                            //set the percent
                            percentElement.innerHTML = (increasement ? (++existingPercent) : (--existingPercent)) + '%';
                            setTimeout(function () {
                                changePercentTimer(percentElement, existingPercent, currentPercent);
                            }, intervalIn);
                        }
                    }

                    changePercentTimer(percentElement, existingPercent, currentPercent);

                })(percentElement, existingPercent, parseInt(percent));

            }, 50);
        }
    }

    /**
     * Get the progress bar element
     *
     * @api private
     * @method _getPercentElement
     * @param {Object} targetElement
     */
    function _getPercentElement(targetElement) {
        var progressjsId = parseInt(targetElement.getAttribute('data-progressjs'));
        return document.querySelector('.progressjs-container > .progressjs-progress[data-progressjs="' + progressjsId + '"] > .progressjs-inner');
    }

    /**
     * Auto increase the progress bar every X milliseconds
     *
     * @api private
     * @method _autoIncrease
     * @param {Number} size
     * @param {Number} millisecond
     */
    function _autoIncrease(size, millisecond) {
        var self = this;

        var progressjsId = parseInt(this._targetElement[0].getAttribute('data-progressjs'));

        if (typeof window._progressjsIntervals[progressjsId] != 'undefined') {
            clearInterval(window._progressjsIntervals[progressjsId]);
        }
        window._progressjsIntervals[progressjsId] = setInterval(function () {
            _increasePercent.call(self, size);
        }, millisecond);
    }

    /**
     * Increase the size of progress bar
     *
     * @api private
     * @method _increasePercent
     * @param {Number} size
     */
    function _increasePercent(size) {
        for (var i = 0, elmsLength = this._targetElement.length; i < elmsLength; i++) {
            var currentElement = this._targetElement[i];
            if (currentElement.hasAttribute('data-progressjs')) {
                var percentElement = _getPercentElement(currentElement);
                var existingPercent = parseInt(percentElement.style.width.replace('%', ''));
                if (existingPercent) {
                    _setPercentFor.call(this, currentElement, existingPercent + (size || 1));
                }
            }
        }
    }

    /**
     * Close and remove progress bar
     *
     * @api private
     * @method _end
     */
    function _end() {

        //call onBeforeEnd callback
        if (typeof this._onBeforeEndCallback != 'undefined') {
            if (this._options.considerTransition === true) {
                //we can safety assume that all layers would be the same, so `this._targetElement[0]` is the same as `this._targetElement[1]`
                _getPercentElement(this._targetElement[0]).addEventListener(whichTransitionEvent(), this._onBeforeEndCallback, false);
            } else {
                this._onBeforeEndCallback.call(this);
            }
        }

        var progressjsId = parseInt(this._targetElement[0].getAttribute('data-progressjs'));

        for (var i = 0, elmsLength = this._targetElement.length; i < elmsLength; i++) {
            var currentElement = this._targetElement[i];
            var percentElement = _getPercentElement(currentElement);

            if (!percentElement)
                return;

            var existingPercent = parseInt(percentElement.style.width.replace('%', ''));

            var timeoutSec = 1;
            if (existingPercent < 100) {
                _setPercentFor.call(this, currentElement, 100);
                timeoutSec = 500;
            }

            //I believe I should handle this situation with eventListener and `transitionend` event but I'm not sure
            //about compatibility with IEs. Should be fixed in further versions.
            (function (percentElement, currentElement) {
                setTimeout(function () {
                    percentElement.parentNode.className += " progressjs-end";

                    setTimeout(function () {
                        //remove the percent element from page
                        percentElement.parentNode.parentNode.removeChild(percentElement.parentNode);
                        //and remove the attribute
                        currentElement.removeAttribute("data-progressjs");
                    }, 1000);
                }, timeoutSec);
            })(percentElement, currentElement);
        }

        //clean the setInterval for autoIncrease function
        if (window._progressjsIntervals[progressjsId]) {
            //`delete` keyword has some problems in IE
            try {
                clearInterval(window._progressjsIntervals[progressjsId]);
                window._progressjsIntervals[progressjsId] = null;
                delete window._progressjsIntervals[progressjsId];
            } catch (ex) {
            }
        }
    }

    /**
     * Create the progress bar container
     *
     * @api private
     * @method _createContainer
     */
    function _createContainer() {
        //first check if we have an container already, we don't need to create it again
        if (!document.querySelector(".progressjs-container")) {
            var containerElement = document.createElement("div");
            containerElement.className = "progressjs-container";
            document.body.appendChild(containerElement);
        }
    }

    /**
     * Get an element position on the page
     * Thanks to `meouw`: http://stackoverflow.com/a/442474/375966
     *
     * @api private
     * @method _getOffset
     * @param {Object} element
     * @returns Element's position info
     */
    function _getOffset(element) {
        var elementPosition = {};

        if (element.tagName.toLowerCase() === 'body') {
            //set width
            elementPosition.width = element.clientWidth;
            //set height
            elementPosition.height = element.clientHeight;
        } else {
            //set width
            elementPosition.width = element.offsetWidth;
            //set height
            elementPosition.height = element.offsetHeight;
        }

        //calculate element top and left
        var _x = 0;
        var _y = 0;
        while (element && !isNaN(element.offsetLeft) && !isNaN(element.offsetTop)) {
            _x += element.offsetLeft;
            _y += element.offsetTop;
            element = element.offsetParent;
        }
        //set top
        elementPosition.top = _y;
        //set left
        elementPosition.left = _x;

        return elementPosition;
    }

    /**
     * Overwrites obj1's values with obj2's and adds obj2's if non existent in obj1
     * via: http://stackoverflow.com/questions/171251/how-can-i-merge-properties-of-two-javascript-objects-dynamically
     *
     * @param obj1
     * @param obj2
     * @returns obj3 a new object based on obj1 and obj2
     */
    function _mergeOptions(obj1, obj2) {
        var obj3 = {};
        for (var attrname in obj1) {
            obj3[attrname] = obj1[attrname];
        }
        for (var attrname in obj2) {
            obj3[attrname] = obj2[attrname];
        }
        return obj3;
    }

    var progressJs = function (targetElm) {
        if (typeof (targetElm) === 'object') {
            //Ok, create a new instance
            return new ProgressJs(targetElm);

        } else if (typeof (targetElm) === 'string') {
            //select the target element with query selector
            var targetElement = document.querySelectorAll(targetElm);

            if (targetElement) {
                return new ProgressJs(targetElement);
            } else {
                throw new Error('There is no element with given selector.');
            }
        } else {
            return new ProgressJs(document.body);
        }
    };

    /**
     * Get correct transition callback
     * Thanks @webinista: http://stackoverflow.com/a/9090128/375966
     *
     * @returns transition name
     */
    function whichTransitionEvent() {
        var t;
        var el = document.createElement('fakeelement');
        var transitions = {
            'transition': 'transitionend',
            'OTransition': 'oTransitionEnd',
            'MozTransition': 'transitionend',
            'WebkitTransition': 'webkitTransitionEnd'
        }

        for (t in transitions) {
            if (el.style[t] !== undefined) {
                return transitions[t];
            }
        }
    }

    /**
     * Current ProgressJs version
     *
     * @property version
     * @type String
     */
    progressJs.version = VERSION;

    //Prototype
    progressJs.fn = ProgressJs.prototype = {
        clone: function () {
            return new ProgressJs(this);
        },
        setOption: function (option, value) {
            this._options[option] = value;
            return this;
        },
        setOptions: function (options) {
            this._options = _mergeOptions(this._options, options);
            return this;
        },
        start: function () {
            _startProgress.call(this);
            return this;
        },
        set: function (percent) {
            _setPercent.call(this, percent);
            return this;
        },
        increase: function (size) {
            _increasePercent.call(this, size);
            return this;
        },
        autoIncrease: function (size, millisecond) {
            _autoIncrease.call(this, size, millisecond);
            return this;
        },
        end: function () {
            _end.call(this);
            return this;
        },
        onbeforeend: function (providedCallback) {
            if (typeof (providedCallback) === 'function') {
                this._onBeforeEndCallback = providedCallback;
            } else {
                throw new Error('Provided callback for onbeforeend was not a function');
            }
            return this;
        },
        onbeforestart: function (providedCallback) {
            if (typeof (providedCallback) === 'function') {
                this._onBeforeStartCallback = providedCallback;
            } else {
                throw new Error('Provided callback for onbeforestart was not a function');
            }
            return this;
        },
        onprogress: function (providedCallback) {
            if (typeof (providedCallback) === 'function') {
                this._onProgressCallback = providedCallback;
            } else {
                throw new Error('Provided callback for onprogress was not a function');
            }
            return this;
        }
    };

    exports.progressJs = progressJs;
    return progressJs;
}));
