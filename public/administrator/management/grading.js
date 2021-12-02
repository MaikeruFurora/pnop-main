let searchBySection = (grade_level) => {
    let sectionHTML = "";
    $.ajax({
        url: `grading/search/section/${grade_level}`,
        type: "GET",
        dataType: "json",
    })
        .done(function (data) {
          
            if (data.warning) {
                getToast("warning", "Warning", data.warning);
            } else {
                  sectionHTML += `<label>Section</label>
                        <select class="form-control" name="section_id">`;
                        sectionHTML += `<option>Choose Section</option>`;
                data.forEach((element) => {
                    sectionHTML += `<option value="${element.id}">${element.section_name} - ${element.class_type}</option>`;
                });
                sectionHTML += `</select>`;
                $("#show_section").html(sectionHTML);
            }
        })
        .fail(function (jqxHR, textStatus, errorThrown) {
            console.log(jqxHR, textStatus, errorThrown);
            getToast("error", "Eror", errorThrown);
        });
};

let searhBySubject = (section) => {
    let subjectHTML = "";
    $.ajax({
        url: `grading/search/subject/${section}`,
        type: "GET",
        dataType: "json",
    })
        .done(function (data) {
            subjectHTML += ` <label>Subject</label>
                 <select class="form-control" name="subject_id">`;
            subjectHTML += `<option>Choose Subject</option>`;
            data.forEach((element) => {
                subjectHTML += `<option value="${element.id}">${
                    "[ " +
                    element.subject_for +
                    " ] " +
                    element.subject_code +
                    " - " +
                    element.descriptive_title
                }</option>`;
            });
            subjectHTML += ` </select>`;
            $("#show_subject").html(subjectHTML);
        })
        .fail(function (jqxHR, textStatus, errorThrown) {
            console.log(jqxHR, textStatus, errorThrown);
            getToast("error", "Eror", errorThrown);
        });
};


let myGradePerGrading=(val)=>{
    if (val==null || val==0) {
        return '';
    } else {
        if (val>=70 && val<=100) {
            return val;
        } else {
           return '';
        }
    }
}

let loadstudent = (section, subject) => {
    console.log(section, subject);
    let htmlGradeHold = '';
    $.ajax({
        url: `grading/load/all/student/${section}/${subject}`,
        type: "GET",
        dataType: "json",
        beforeSend: function () {
            $("#loadstudent").html(
                `<tr>
                        <td colspan="6" class="text-center">
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </td>
                    </tr>
                    `
            );
        },
    }).done(function (data) {
        $(".show_subject").text(data[0].descriptive_title)
        console.log(data);
        data.forEach((val) => {
            htmlGradeHold += `
                    <tr style="background-color:${
                        val.avg < 75 && val.avg != null ? "#ffe6e6" : ""
                    }">
                    <td>
                        ${val.fullname}
                    </td>
                    <td>
                        <input type="text"
                        pattern="^[0-9]{3}$"
                        onkeypress="return numberOnly(event)"
                        maxlength="3"
                        name="inGrade"
                        class="noborder text-center"
                        value="${myGradePerGrading(val.first) }"
                        data-column="1st"
                        data-grade_id="${val.gid}"
                        data-subject_id="${val.subject_id}"
                        data-student_id="${ val.sid }"
                        id="1st_${ val.sid}"
                        >
                        </td>
                    <td>
                        <input type="text"
                        pattern="^[0-9]{3}$"
                        onkeypress="return numberOnly(event)" 
                        maxlength="3"
                        name="inGrade"
                        class="noborder text-center"
                        value="${ myGradePerGrading(val.second) }"
                        data-column="2nd"
                        data-grade_id="${val.gid}"
                        data-subject_id="${ val.subject_id }"
                        data-student_id="${ val.sid }"
                        id="2nd_${ val.sid}"
                        >
                    </td>
                    <td>
                        <input type="text"
                        pattern="^[0-9]{3}$" 
                        onkeypress="return numberOnly(event)"
                        maxlength="3"
                        name="inGrade"
                        class="noborder text-center"
                        value="${ myGradePerGrading(val.third) }"
                        data-column="3rd"
                        data-grade_id="${val.gid}"
                        data-subject_id="${ val.subject_id }"
                        data-student_id="${ val.sid }"
                        id="3rd_${ val.sid}"
                        >
                    </td>
                    <td>
                        <input type="text"
                        pattern="^[0-9]{3}$" 
                        onkeypress="return numberOnly(event)"
                        maxlength="3"
                        name="inGrade"
                        class="noborder text-center"
                        value="${ myGradePerGrading(val.fourth) }"
                        data-column="4th"
                        data-grade_id="${val.gid}"
                        data-subject_id="${ val.subject_id }"
                        data-student_id="${ val.sid }"
                        id="4th_${ val.sid}"
                        >
                    </td>
                    <td>
                        <input type="text"
                        pattern="^[0-9]{3}$" 
                        onkeypress="return numberOnly(event)"
                        maxlength="3"
                        name="inGrade"
                        class="noborder text-center"
                        value="${ myGradePerGrading(val.avg) }"
                        data-column="avg"
                        data-grade_id="${val.gid}"
                        data-subject_id="${ val.subject_id }"
                        data-student_id="${ val.sid }"
                        > 
                   </td>
                </tr>
            `;

            $("#loadstudent").html(htmlGradeHold)
        });
    })
    .fail(function (jqxHR, textStatus, errorThrown) {
        console.log(jqxHR, textStatus, errorThrown);
        getToast("error", "Eror", errorThrown);
    });
   
}

$(document).on('blur','input[name="inGrade"]',function(){
    if ($(this).val() < 70 || $(this).val() > 99) {
        $(this).val("");
    } else {
        let subject_id = $(this).attr("data-subject_id");
        let student_id = $(this).attr("data-student_id");
        let grade_id = $(this).attr("data-grade_id");
        let columnIn = $(this).attr("data-column");
        let value = $(this).val();
        let avg =
        $("#4th_" + student_id).val() != ""
            ? Math.round(
                  (parseInt($("#1st_" + student_id).val()) +
                      parseInt($("#2nd_" + student_id).val()) +
                      parseInt($("#3rd_" + student_id).val()) +
                      parseInt($("#4th_" + student_id).val())) /
                      4
              )
            : "";
       
        $.ajax({
            url:`grading/student/now`,
            type:'POST',
            data: {
                avg,
                subject_id,
                student_id,
                grade_id,
                columnIn,
                value,
                _token:$('input[name="_token"]').val()
            },
        }).done(function (data) {
            getToast("success", "Saved", "");
            if ($("#4th_" + student_id).val() != "") {
                loadstudent($('select[name="section_id"]').val(),$('select[name="subject_id"]').val())   
            }
        }).fail(function(a,b,c){
            alert(c)
        });

    }
})

$('select[name="grade_level"]').on('change', function () {
    if ($(this).val()!="") {
        searchBySection($(this).val())   
    } 
})

$(document).on('change','select[name="section_id"]', function () {
    if ($(this).val()!="") {
        searhBySubject($(this).val())   
    }
})

$(document).on('change','select[name="subject_id"]', function () {
    if ($(this).val()!="") {
        loadstudent($('select[name="section_id"]').val(),$(this).val())   
    }
})


