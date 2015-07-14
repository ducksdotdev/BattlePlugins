/*global $, jQuery, alert*/
$(function () {
    'use strict';

    $('.ui.checkbox').checkbox();
    $('.ui.dropdown').dropdown({
        transition: 'drop'
    });

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