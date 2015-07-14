/*global $, jQuery, alert*/
$(function () {
    'use strict';

    $('.ui.checkbox').checkbox();

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

    $("#editBlog").click(function () {
        $("#editBlog").addClass("loading");
        $("#editBlogModal").modal({
            onVisible: function () {
                $("#editBlog").removeClass("loading");
            },
            onApprove: function () {
                return false;
            }
        }).modal('show');
    });
});