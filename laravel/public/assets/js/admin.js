$(function () {
    $("#changeGroups #username").keyup(function () {
        var name = $("#changeGroups :input").serialize();
        $.post('/admin/manageUsers/groups/get', name, function (data) {
            if (data.result == 'failure')
                $("#groups").createAlert("warning", "User " + $("#changeGroups #username").val() + " not found.");
            else
                $("#groups").empty().append(data);
        });
    });

    $("#changeGroups").submit(function (e) {
        e.preventDefault();
        if ($("#userGroups").length > 0) {
            var formData = $("#changeGroups :input").serialize();
            $.post('/admin/manageUsers/groups/change', formData, function (data) {
                if (data.result == 'success')
                    $("#changeGroupsAlert").createAlert("success", "User groups changed");
                else
                    $("#changeGroupsAlert").createAlert("danger", data.reason);
            }, 'json');
        }
    });

    $("#getSetting").submit(function (e) {
        e.preventDefault();
        var formData = $("#getSetting :input").serialize();
        $.post('/admin/manageUsers/settings/get', formData, function (data) {
            if (data.result == 'success') {
                $("#setSetting #username").val($("#getSetting #username").val());
                $("#setSetting #setting").val($("#getSetting #setting").val());
                $("#setSetting #value").val(data.setting);
                $("#changeSettingAlert").createAlert("success", "User and setting have been found.");
            } else
                $("#changeSettingAlert").createAlert("danger", data.reason);

        }, 'json');
    });

    $("#setSetting").submit(function (e) {
        e.preventDefault();
        var formData = $("#setSetting :input").serialize();
        $.post('/admin/manageUsers/settings/set', formData, function (data) {
            if (data.result == 'success') {
                window.location.reload();
            } else
                $("#changeSettingAlert").createAlert("danger", data.reason);

        }, 'json');
    });

    $("#editUser").submit(function (e) {
        e.preventDefault();
        var formData = $("#editUser :input").serialize();
        $.post("/admin/manageUsers/edit", formData, function (data) {
            if (data.result == "failure") {
                $("#alert").createAlert("danger", data.reason);
            } else
                window.location.reload();
        }, "json");
    });

    $("#submitArticle").click(function () {
        var title = $("#title").val();
        var content = $('#summernote').code();
        var _token = $("input[name='_token']").val();
        $.post('/admin/blog', {title: title, content: content, _token: _token}, function (data) {
            if (data.result == 'success')
                window.location = data.reason;
            else
                $("#alert").createAlert("danger", data.reason);
        }, 'json');
    });

    $("#editArticle").click(function () {
        var title = $("#title").val();
        var content = $('#summernote').code();
        var _token = $("input[name='_token']").val();
        var id = $("#blog").data('id');
        $.post('/admin/blog/edit', {title: title, content: content, _token: _token, id: id}, function (data) {
            if (data.result == 'success')
                window.location.reload();
            else
                $("#alert").createAlert("danger", data.reason);
        }, 'json');
    });

    $("#deleteArticle").click(function () {
        var _token = $("input[name='_token']").val();
        var id = $("#blog").data('id');
        $.post('/admin/blog/delete', {_token: _token, id: id}, function () {
            window.location.reload();
        });
    });
});
