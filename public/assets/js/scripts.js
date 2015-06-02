/*global $, jQuery, alert*/
$(function () {
    'use strict';

    $('.ui.checkbox').checkbox();

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