const table_teacher = $("#teacherTable").DataTable({
    // lengthChange: false,
    pageLenth: 6,
    processing: true,
    language: {
        processing: `
                <div class="spinner-border spinner-border-sm" role="status">
                <span class="sr-only">Loading...</span>
              </div>`,
    },

    ajax: `teacher/list`,
    columns: [
        { data: "roll_no" },
        {
            data: null,
            render: function (data) {
                return (
                    data.teacher_lastname +
                    ", " +
                    data.teacher_firstname +
                    " " +
                    data.teacher_middlename
                );
            },
        },
        { data: "teacher_gender" },
        { data: "username" },
        // { data: "orig_password" },
        {
            data: null,
            render: function (data) {
                let fullname =  data.teacher_lastname+", "+data.teacher_firstname+" "+data.teacher_middlename
                return `
                <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-sm btn-warning tdelete btnDelete_${data.id} pl-3 pr-3 " id="${data.id}"
                    ${ AssignId.filter(val=>(val==data.id))!='' ? "disabled" : ""}
                    >
                    <i class="fas fa-user-times"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-info tedit btnEdit_${data.id} pl-3 pr-3" id="${data.id}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-primary treset btnReset_${data.id} pl-3 pr-3" 
                    value="${fullname}"
                    id="${data.id}">
                         <i class="fas fa-key"></i>
                    </button>
                    </div>
                    `;
            },
        },
    ],
});

$(document).on('click', '.treset', function (e) {
    e.preventDefault();
    $(".yesReset").show().text('Yes, reset password');
    let fullname = $(this).val();
    let id = $(this).attr("id");
    $(".showName").text(fullname)
    $(".textshow").text("Are you sure you want to reset password?")
    $("#resetModal").modal("show")
    $(".yesReset").val(id);
})

$(".yesReset").on('click', function (e) {
    e.preventDefault();
    $.ajax({
        url: `/admin/my/reset/password/${$(this).val()}/teacher`,
        type: "GET",
        beforeSend: function () {
            $(".yesReset").html(`Restting... 
            <div class="spinner-border spinner-border-sm" role="status">
                <span class="sr-only">Loading...</span>
            </div>`);
        },
    })
        .done(function (response) {
            $(".yesReset").hide();
            getToast("success", "Success", "Successfully reset password");
            $(".textshow").html(`New password: <b>${response}</b>`)
        })
        .fail(function (jqxHR, textStatus, errorThrown) {
            $(".yesReset").show().text('Yes, reset password');
            console.log(jqxHR, textStatus, errorThrown);
            getToast("error", "Eror", errorThrown);
        });
})

$("#teacherForm").submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: "teacher/store",
        type: "POST",
        data: new FormData(this),
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function () {
            $("#btnSave").html(`Saving 
                <div class="spinner-border spinner-border-sm" role="status">
                    <span class="sr-only">Loading...</span>
                </div>`);
        },
    })
        .done(function (response) {
            $("input[name='id']").val('');
            $("#btnSave").html("Save");
            getToast("success", "Success", "Successfully added new teacher");
            $("#teacherForm")[0].reset();
            table_teacher.ajax.reload();
        })
        .fail(function (jqxHR, textStatus, errorThrown) {
            console.log(jqxHR, textStatus, errorThrown);
            getToast("error", "Eror", errorThrown);
        });
});

$(document).on("click", ".tdelete", function () {
    let id = $(this).attr("id");
    $("#teacherDeleteModal").modal("show")
    $(".deleteYes").val(id)
});

$(".deleteYes").on('click', function () {
    $.ajax({
        url: "teacher/delete/" + $(this).val(),
        type: "DELETE",
        data: { _token: $('input[name="_token"]').val() },
        beforeSend: function () {
            $(".deleteYes")
                .html(
                    `
                <div class="spinner-border spinner-border-sm" role="status">
                    <span class="sr-only">Loading...</span>
                </div>`
                )
                .attr("disabled", true);
        },
    })
        .done(function (response) {
            $(".deleteYes")
                .html(`Yes`)
                .attr("disabled", false);
            getToast("success", "Success", "deleted one record");
            $("#teacherForm")[0].reset();
            table_teacher.ajax.reload();
            $("#teacherDeleteModal").modal("hide")
        })
        .fail(function (jqxHR, textStatus, errorThrown) {
            console.log(jqxHR, textStatus, errorThrown);
            $(".deleteYes")
                .html(`Yes`)
                .attr("disabled", false);
            getToast("error", "Eror", errorThrown);
        });
})

$(document).on("click", ".tedit", function () {
    let id = $(this).attr("id");
    $.ajax({
        url: "teacher/edit/" + id,
        type: "GET",
        data: { _token: $('input[name="_token"]').val() },
        beforeSend: function () {
            $(".btnEdit_" + id).html(`
                <div class="spinner-border spinner-border-sm" role="status">
                    <span class="sr-only">Loading...</span>
                </div>`);
        },
    })
        .done(function (data) {
            $(".modal-title").text("Update Teacher");
            $(".btnEdit_" + id).html(`<i class="fas fa-edit"></i>`);
            $("#staticBackdrop").modal("show");
            $("input[name='roll_no']").val(data.roll_no);
            $("input[name='firstname']").val(data.teacher_firstname);
            $("input[name='middlename']").val(data.teacher_middlename);
            $("input[name='lastname']").val(data.teacher_lastname);
            $("select[name='gender']").val(data.teacher_gender);
            $("input[name='id']").val(data.id);
        })
        .fail(function (jqxHR, textStatus, errorThrown) {
            $(".btnEdit_" + id).html(`<i class="fas fa-edit"></i>`);
            console.log(jqxHR, textStatus, errorThrown);
        });
});
$("#btnMidalTeacher").on("click", function () {
    $(".modal-title").text("New Teacher");
    $("#teacherForm")[0].reset();
    $("#staticBackdrop").modal("show");
});


$("#btnModalExport").on('click', function () {
    $("#importModal").modal("show")
})

$("#importForm").submit(function (e) {
    e.preventDefault()
  
    $.ajax({
        url: "teacher/import",
        type: "POST",
        data: new FormData(this),
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function () {
            $(".btnImportNow").html(
                `Importing...  <div class="spinner-border spinner-border-sm" role="status">
                <span class="sr-only">Loading...</span>
            </div>
                    `
            );
        },
    }).done(function (data) {
        $('input[name="file"]').val("")
        $(".btnImportNow").html('Import')
        table_teacher.ajax.reload();
    }).fail(function (jqxHR, textStatus, errorThrown) {
         $(".btnImportNow").html('Import')
        console.log(jqxHR, textStatus, errorThrown);
    });
})