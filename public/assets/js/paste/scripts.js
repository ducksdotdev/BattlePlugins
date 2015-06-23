/*global $, jQuery, alert*/
$(function () {
    'use strict';

    $('.ui.checkbox').checkbox();

    autosize($('textarea'))

    $("#createPaste").click(function () {
        $("#createPaste").addClass("loading");
        $("#createPasteModal").modal({
            onVisible: function () {
                $("#createPaste").removeClass("loading");
            },
            onApprove: function () {
                return false;
            }
        }).modal('show');
    });
});