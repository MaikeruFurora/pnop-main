let backsubjectTable = $("#backsubjectTable").DataTable({
    pageLenth: 6,
    processing: true,
    language: {
        processing: `
            <div class="spinner-border spinner-border-sm" role="status">
            <span class="sr-only">Loading...</span>
          </div>`,
    },
    ajax: `backrecord/list`,
    columns: [
        { data: "roll_no" },
        { data: "fullname" },
        {
            data: null,
            render: function (data) {
                return `
                    <button class="btn btn-info btn-sm btnView btnView_${data.student_id}" id="${data.student_id}">
                    <i class="fa fa-eye"></i> View Record
                    </button>
                `;
            },
        },
    ],
});

let loadTableNow = (id) => {
    let viewHTML = "";
    $.ajax({
        url: `backrecord/view/${id}`,
        type: "GET",
        dataType: "json",
        beforeSend: function () {
            $(".btnView_" + id)
                .html(
                    `loading...
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>`
                )
                .attr("disabled", true);
        },
    })
        .done(function (data) {
            $(".modal-title").text(data[0].fullname);
            $("#staticBackdrop").modal("show");
            data.forEach((val) => {
                viewHTML += `
                    <tr>
                    <td>${val.descriptive_title}</td>
                    <td>Grade ${val.grade_level}</td>
                    <td>${val.prev_avg}</td>
                    <td>
                        <input type="text"
                        ${val.remarks == "Passed" ? "readonly" : ""}
                        class="form-control form-control-sm text-center inputAvg"
                        value="${
                            val.avg_now == null ? "" : val.avg_now
                        }" id="avg_now_${val.id}"
                        pattern="^[0-9]{2}$" onkeypress="return numberOnly(event)"
                        maxlength="2"
                    >
                    </td>
                    <td>${
                        val.remarks == "Passed"
                            ? `<span class="text-success"><b>${val.remarks}</b></span>`
                            : val.remarks
                    }</td>
                    <td>
                       ${
                           val.remarks == "Passed"
                               ? `---- Clear ----`
                               : ` <button class="btn btn-sm btn-info btnUpdate" id="${val.id}" data-student="${val.student_id}">
                            <i class="fa fa-pen-nib"></i> Update
                        </button>`
                       }
                    </td>
                    </tr>
                `;
            });
            $("#viewTable").html(viewHTML);
            $(".btnView_" + id)
                .html(` <i class="fa fa-eye"></i> View Record`)
                .attr("disabled", false);
        })
        .fail(function (jqxHR, textStatus, errorThrown) {
            console.log(jqxHR, textStatus, errorThrown);
            getToast("error", "Eror", errorThrown);
        });
};
$(document).on("click", ".btnView", function () {
    loadTableNow($(this).attr("id"));
});

$(document).on("blur", ".inputAvg", function () {
    if ($(this).val() < 75) {
        $(this).val("");
    }
});

$(document).on("click", ".btnUpdate", function () {
    let id = $(this).attr("id");
    let student_id = $(this).attr("data-student");
    let avg_now = $("#avg_now_" + id).val();
    $.ajax({
        url: `backrecord/update/${id}`,
        type: "PATCH",
        data: {
            id,
            _token: $('input[name="_token"]').val(),
            avg_now,
        },
    })
        .done(function (data) {
            console.log(data);
            loadTableNow(student_id);
        })
        .fail(function (jqxHR, textStatus, errorThrown) {
            console.log(jqxHR, textStatus, errorThrown);
            getToast("error", "Eror", errorThrown);
        });
});
