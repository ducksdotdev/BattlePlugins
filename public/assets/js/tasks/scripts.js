/*global $, jQuery, alert*/
$(function () {
    'use strict';

    $(".ui.checkbox").checkbox();

    $("#createTask").click(function () {
        $("#createTask").addClass("loading");
        $("#createTaskModal").modal({
            onVisible: function () {
                $("#createTask").removeClass("loading");
            },
            onApprove: function () {
                return false;
            }
        }).modal('show');
    });

    $("#loginDropDownButton").click(function () {
        $("#login").sidebar({
            onVisible: function () {
                $("#email").focus();
            }
        }).sidebar('toggle');
    });

    $('.ui.checkbox').checkbox();

    $(".delete-task").click(function () {
        $(this).parent().parent().addClass("deleted");
        $(this).addClass("loading");
    });

    $("#loginButton").click(function () {
        $(this).addClass("loading");
    });

    $("#refresh").click(function () {
        $(".refresh").addClass('loading');
    });

    $(".editable").dblclick(function () {
        $(this).attr('contenteditable', true);
    });
});