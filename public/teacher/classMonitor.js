let myClassTable = $("#myClassTable").DataTable({
    // lengthChange: false,
    pageLenth: 6,
    processing: true,
    language: {
        processing: `
                <div class="spinner-border spinner-border-sm" role="status">
                <span class="sr-only">Loading...</span>
              </div>`,
    },

    ajax: "monitor/list",
    columns: [
        { data: "roll_no" },
        { data: "fullname" },
        { data: "gender" },
        { data: "student_contact" },
        {
            data: null,
            render: function (data) {
                return data.enroll_status == "Dropped"
                    ? `<span class="badge badge-danger">${data.enroll_status}</span>`
                    : `<span class="badge badge-success">${data.enroll_status}</span>`;
            },
        },
        {
            data: null,
            render: function (data) {
                if (data.enroll_status != "Dropped") {
                    return `<button type="button" class="btn btn-sm btn-warning dropped btnDropped_${data.id}  pt-0 pb-0 pl-2 pr-2" id="${data.id}" data-student="${data.enroll_status}">
                    <i class="fas fa-user-times"></i> Drop
                    </button>
                    `;
                } else {
                    return `<button type="button" class="btn btn-sm btn-info dropped btnDropped_${data.id}  pt-0 pb-0 pl-2 pr-2" id="${data.id}" data-student="${data.enroll_status}">
                    <i class="fas fa-user-times"></i> Undrop
                    </button>
                    `;
                }
            },
        },
    ],
});

$(document).on("click", ".dropped", function () {
    let id = $(this).attr("id");
    $("#dropModal").modal("show")
    $(".confirmYes").val(id);
    let msg =($(this).attr('data-student') == 'Enrolled') ? 'You are about to Drop this student, Are you sure?' : 'You are about to Undrop this student, Are you sure?'
    $('.confirmText').html(msg)
});

$(".confirmYes").on('click', function () {
    $.ajax({
        url: "monitor/dropped/" + $(this).val(),
        type: "POST",
        data: { _token: $('input[name="_token"]').val() },
        beforeSend: function () {
            $(".confirmYes").html(`
                <div class="spinner-border spinner-border-sm" role="status">
                    <span class="sr-only">Loading...</span>
                </div>`);
        },
    })
        .done(function (response) {
            $(".confirmYes").html("Yes");
            $("#dropModal").modal("hide")
            getToast("info", "Done", "Change one record");
            myClassTable.ajax.reload();
        })
        .fail(function (jqxHR, textStatus, errorThrown) {
            console.log(jqxHR, textStatus, errorThrown);
            getToast("error", "Eror", errorThrown);
        });
})
