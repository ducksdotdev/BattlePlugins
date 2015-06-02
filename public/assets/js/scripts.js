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
                $('#blogContent').summernote();
                $("#createBlog").removeClass("loading");
            },
            onApprove: function () {
                var title = $("input[name='title']").val();
                var content = $("#blogContent").code();
                $.post('/blog', {title: title, content: content}).done(function(){
                    window.location.reload();
                });
            }
        }).modal('show');
    });
});