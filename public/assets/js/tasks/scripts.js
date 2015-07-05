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

    $("#minimizeTasks").click(function(){
        $("#taskList").toggle();

        if($("#minimizeTasks i").hasClass("compress")) {
            $("#minimizeTasks i").removeClass('compress');
            $("#minimizeTasks i").addClass('expand');
        } else {
            $("#minimizeTasks i").removeClass('compress');
            $("#minimizeTasks i").addClass('remove');
        }
    });

    $("#minimizeIssues").click(function(){
        $("#issueList").toggle();

        if($("#minimizeIssues i").hasClass("compress")) {
            $("#minimizeIssues i").removeClass('compress');
            $("#minimizeIssues i").addClass('expand');
        } else {
            $("#minimizeIssues i").removeClass('expand');
            $("#minimizeIssues i").addClass('compress');
        }
    });
});