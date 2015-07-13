/*global $, jQuery, alert*/
$(function () {
    'use strict';

    $('.ui.checkbox').checkbox();
    $('textarea.monospace').autosize();

    $('textarea.monospace').on('keydown', function (e) {
        if (e.which == 9) {
            this.value += "    ";
            e.preventDefault();
            return false;
        }
    });
});