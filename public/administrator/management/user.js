$("#userForm").submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: "user/save",
        type: "POST",
        data: new FormData(this),
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function () {
            $(".btnSaveUser")
                .html(
                    `Saving ...
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>`
                )
                .attr("disabled", true);
        },
    })
        .done(function (data) {
            $(".btnSaveUser").html("Submit").attr("disabled", false);
            cancelUser.hide();
            document.getElementById("userForm").reset();
            $("input[name='id']").val("");
            userTable();
        })
        .fail(function (jqxHR, textStatus, errorThrown) {
            getToast("error", "Eror", errorThrown);
            $(".btnSaveUser").html("Submit").attr("disabled", false);
        });
});
let cancelUser = $(".cancelUser").hide();
$(".cancelUser").on("click", function () {
    $(this).hide();
    document.getElementById("userForm").reset();
    $(".btnSaveUser").html("Submit");
    $("input[name='id']").val("");
});

const userTable = (level) => {
    let htmlHold = "";
    let i = 1;
    $.ajax({
        url: `user/list`,
        type: "GET",
        dataType: "json",
        beforeSend: function () {
            $("#userTable").html(
                `<tr>
                        <td colspan="5" class="text-center">
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </td>
                    </tr>
                    `
            );
        },
    })
        .done(function (data) {
            if (data.length > 0) {
                data.forEach((val) => {
                    htmlHold += `
                        <tr>
                            <td>
                                ${i++}
                            </td>
                            <td>
                                ${val.name}
                            </td>
                            <td>
                                ${val.username}
                            </td>
                            <td>
                            ${ (val.id==user_id)?
                                `
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn pl-4 pr-4 btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="far fa-edit"></i> Edit 
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                        <a class="dropdown-item edit" id="${val.id}" style="cursor: pointer"> <i class="far fa-edit"></i> Update Profile</a>
                                        <a class="dropdown-item change change_${val.id}" id="${val.id}" style="cursor: pointer"> <i class="fas fa-key"></i> Change Password</a>
                                       
                                    </div>
                                </div>
                                ` :
                                        '-- Restricted --'
                                    }
                            </td>
                        </tr>
                    `;
                });
            } else {
                htmlHold = `
                            <tr>
                                <td colspan="4" class="text-center">No available data</td>
                            </tr>`;
            }
            $("#userTable").html(htmlHold);
        })
        .fail(function (jqxHR, textStatus, errorThrown) {
            getToast("error", "Eror", errorThrown);
        });
};

userTable();

///////////////////////////////////

$(document).on("click", ".edit", function () {
    let id= $(this).attr("id")
    $.ajax({
        url: "user/edit/" + id,
        type: "GET",
        data: { _token: $('input[name="_token"]').val() },
        // beforeSend: function () {
        //     $(".edit_" + id).html(`
        //     <div class="spinner-border spinner-border-sm" role="status">
        //         <span class="sr-only">Loading...</span>
        //     </div>`);
        // },
    })
        .done(function (data) {
            $("#updateProfileModal").modal("show")
            // $(".btnCancel").show();
            // $(".edit_" + id).html(`<i class="far fa-edit"></i>`);
            $(".btnSave").html("Update user");
            $("input[name='update_id']").val(data.id);
            $("input[name='update_name']").val(data.name);
            $("input[name='update_username']").val(data.username);
        })
        .fail(function (jqxHR, textStatus, errorThrown) {
            console.log(jqxHR, textStatus, errorThrown);
            getToast("error", "Eror", errorThrown);
        });
});

$("#updateProfile").submit(function(e){
    e.preventDefault();
    let id=$("input[name='update_id']").val();
    $.ajax({
        url: "user/update/profile/"+id,
        type: "POST",
        data: new FormData(this),
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function () {
            $(".btnUpdateProfile")
                .html(
                    `Saving ...
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>`
                )
                .attr("disabled", true);
        },
    })
        .done(function (data) {
            $('.btnUpdateProfile').html('Save changes').attr("disabled", false)
          
                $("input[name='update_id']").val("");
                getToast("info", "Done", "Successfuly updated your record");
                userTable();
                $("#updateProfileModal").modal("hide")
        })
        .fail(function (jqxHR, textStatus, errorThrown) {
            getToast("error", "Eror", errorThrown);
            $(".btnUpdateProfile").html("Save changes").attr("disabled", false);
        });
})

$(document).on('click','.change',function(){
    $("#chagepasswordModal").modal("show");
})

$("#changePasswordForm").submit(function(e){
    e.preventDefault();
    let change_new_password = $("input[name='change_new_password']").val();
    let change_confirm_password = $("input[name='change_confirm_password']").val();

    if (change_new_password==change_confirm_password) {     
        $.ajax({
            url: "user/change/password",
            type: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function () {
                $(".btnChangePassword")
                    .html(
                        `Saving ...
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>`
                    )
                    .attr("disabled", true);
            },
        })
            .done(function (data) {
                $('.btnChangePassword').html('Change Password').attr("disabled", false)
                if (data.msg) {
                    getToast("warning", "Warning", data.msg);
                } else {
                    document.getElementById("changePasswordForm").reset();
                    getToast("info", "Done", "Successfuly updated your password");
                    userTable();
                    $("#chagepasswordModal").modal("hide")
                }
            })
            .fail(function (jqxHR, textStatus, errorThrown) {
                getToast("error", "Eror", errorThrown);
                $(".btnChangePassword").html("Change Password").attr("disabled", false);
            });
    } else {
        getToast("warning", "Warning", 'Confirm password did not match');
    }
  
})



///////////////////////////////////

$("input[name='confirmPassword']").on("blur", function () {
    password = $("input[name='password']").val();
    confirmPassword = $(this).val();
    if (password != confirmPassword) {
        $("input[name='password']").val("");
        $(this).val("");
    }
});

$(document).on("click", ".deleteUser", function () {
    let id = $(this).attr("id");
    $("#teacherDeleteModal").modal("show")
    $(".deleteYes").val(id)
});

$(".deleteYes").on('click', function () {
    $.ajax({
        url: "user/delete/" + $(this).val(),
        type: "DELETE",
        data: { _token: $('input[name="_token"]').val() },
        beforeSend: function () {
            $(".deleteYes").html(`
            <div class="spinner-border spinner-border-sm" role="status">
                <span class="sr-only">Loading...</span>
            </div>`);
        },
    })
        .done(function (response) {
            $(".deleteYes").html("Delete");
            userTable();
            getToast("success", "Success", "deleted one record");
            $("#teacherDeleteModal").modal("hide")
        })
        .fail(function (jqxHR, textStatus, errorThrown) {
            console.log(jqxHR, textStatus, errorThrown);
            getToast("error", "Eror", errorThrown);
        });
})

$(document).on("click", ".editUser", function () {
    let id = $(this).attr("id");
    $.ajax({
        url: "user/edit/" + id,
        type: "GET",
        data: { _token: $('input[name="_token"]').val() },
        beforeSend: function () {
            $(".edit_" + id).html(`
            <div class="spinner-border spinner-border-sm" role="status">
                <span class="sr-only">Loading...</span>
            </div>`);
        },
    })
        .done(function (data) {
            cancelUser.show();
            $(".edit_" + id).html(`<i class="far fa-edit"></i>`);
            $(".btnSaveUser").html("Update");
            $("input[name='id']").val(data.id);
            $("input[name='name']").val(data.name);
            $("input[name='username']").val(data.username);
        })
        .fail(function (jqxHR, textStatus, errorThrown) {
            console.log(jqxHR, textStatus, errorThrown);
            getToast("error", "Eror", errorThrown);
        });
});
