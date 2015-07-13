/*global $, jQuery, alert*/
$(function () {
    'use strict';

    $('.ui.checkbox').checkbox();
    $('textarea.monospace').autosize();

    $('textarea.monospace').on('keypress', function (e) {
        if (e.keyCode == 9) {
            this.value += "    ";
            if (e.preventDefault)
                e.preventDefault();

            return false;
        }
    });
});