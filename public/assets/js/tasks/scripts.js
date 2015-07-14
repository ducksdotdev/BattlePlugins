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

    $("#minimizeTasks").click(function () {
        $("#taskList").toggle();
        changeIcon($("#minimizeTasks i"));
    });

    $("#minimizeIssues").click(function () {
        $("#issueList").toggle();
        changeIcon($("#minimizeIssues i"));
    });
});

function changeIcon(item) {
    if (item.hasClass("compress")) {
        item.removeClass('compress');
        item.addClass('expand');
    } else {
        item.removeClass('expand');
        item.addClass('compress');
    }
}