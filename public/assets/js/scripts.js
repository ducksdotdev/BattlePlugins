/*global $, jQuery, alert*/
$(function () {
    'use strict';

    $("#loginDropDownButton").click(function () {
        $("#login").sidebar({
            onVisible: function () {
                $("#email").focus();
            }
        }).sidebar('toggle');
    });

    $("#loginButton").click(function () {
        $(this).addClass("loading");
    });
});