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
    
    $("#createBlog").click(function () {
        $("#createBlog").addClass("loading");
        $("#createBlogModal").modal({
            onVisible: function () {
                $("#createBlog").removeClass("loading");
            },
            onApprove: function () {
                return false;
            }
        }).modal('show');
    });
});