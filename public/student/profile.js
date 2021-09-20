$("#studentForm").submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: "student/save",
        type: "POST",
        data: new FormData(this),
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function () {
            $(".btnSave")
                .html(
                    `Saving ...
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>`
                )
                .attr("disabled", true);
            getToast("info", "Save", "Successfully saved!");
        },
    })
        .done(function (data) {
            $(".btnSave").html("Save").attr("disabled", false);
            document.getElementById("studentForm").reset();
        })
        .fail(function (jqxHR, textStatus, errorThrown) {
            getToast("error", "Eror", errorThrown);
            $(".btnSave").html("Save").attr("disabled", false);
        });
});
