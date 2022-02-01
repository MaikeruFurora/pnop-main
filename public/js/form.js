// $('select[name="barangay"]').on("change", function () {
//     let province = $('select[name="province"] option:selected').text();
//     let city = $('select[name="city"] option:selected').text();
//     let barangay = $('select[name="barangay"] option:selected').text();
//     $('input[name="address"]').val(
//         ucwords(barangay.toLowerCase()) +
//             ", " +
//             ucwords(city.toLowerCase()) +
//             ", " +
//             ucwords(province.toLowerCase())
//     );
// });

$('.btnEnroll').prop("disabled",true);
$('input[type="checkbox"]').on('click',function(){
    if($(this).is(":checked")){
        $(this).prop('checked',true)
        $('.btnEnroll').prop("disabled", $(this).is(":checked"));
   }
   $('.btnEnroll').prop("disabled", !$(this).is(":checked"));
})


$("input[name='roll_no']").on("blur", function () {
    if ($(this).val() == "") {
        $(".btnEnroll").show();
        $("#staticBackdrop").modal("hide");
    } else {
        $.ajax({
            url: "form/check/lrn/" + $(this).val(),
            type: "GET",
        })
            .done(function (data) {
                if (data.warning) {
                    $("#staticBackdrop").modal("show");
                    $(".modal-title").text("Warning");
                    $(".txt").text("You are already registered");
                    $(".btnEnroll").hide();
                    document.getElementById("enrollForm").reset();
                } else {
                    $("#staticBackdrop").modal("hide");
                    $(".btnEnroll").show();
                }
            })
            .fail(function (jqxHR, textStatus, errorThrown) {
                getToast("error", "Eror", errorThrown);
            });
    }
});
/**
 *
 *
 *
 */
// $("#forStrand").hide();
// $('select[name="grade_level"]').on("change", function () {
//     if (parseInt($(this).val()) > 10) {
//         $("#forStrand").show();
//         $("#forcurriculum").hide();
//     } else {
//         $("#forStrand").hide();
//         $("#forcurriculum").show();
//     }
// });
/**
 *
 *
 *
 *
 *
 *
 */
$("#forBalik").hide();
$('select[name="grade_level"]').attr("disabled", true);
$('select[name="status"]').on("change", function () {
    if ($(this).val() == "new") {
        $('select[name="grade_level"]').val("").attr("disabled", true);
    } else {
        $('select[name="grade_level"]').attr("disabled", false);
    }
    if ($(this).val() == "balikAral") {
        $("#forBalik").show();
    } else {
        $("#forBalik").hide();
    }
});

$("#enrollForm").submit(function (e) {
    $(".btnEnroll").attr("disabled", true);
    e.preventDefault();
    $.ajax({
        url: "form/save",
        type: "POST",
        data: new FormData(this),
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function (data) {
            $(".btnEnroll")
                .html(` <div class="spinner-border spinner-border-sm" role="status">
            <span class="sr-only">Loading...</span>
          </div>`);
        },
    })
        .done(function (data) {
            if (data.warning) {
                getToast(
                    "warning",
                    "Warning",
                    data.warning + ", please contact the administrator"
                );
                $(".btnEnroll").html("Submit");
                $(".btnEnroll").attr("disabled", false);
            } else {
                window.location.href = "/done/" + data;
            }
            // $("#staticBackdrop").modal("show");
            // $(".modal-title").text("Successful");
            // $(".txt").text("Successfull saved your data");
            // document.getElementById("enrollForm").reset();
        })
        .fail(function (jqxHR, textStatus, errorThrown) {
            $(".btnEnroll").html("Submit");
            $(".btnEnroll").attr("disabled", false);
            getToast("error", "Eror", errorThrown);
        });
});


$("input[name='student_contact']").on('blur',function(){
    let contact_no = $(this).val();
    let surfix=contact_no.substr(0,3);
    if (contact_no.length!=0) {
        if (contact_no.length==12 && surfix == '639') {
            $("input[name='student_contact']").removeClass('is-invalid').addClass('is-valid')
        } else {
            $("input[name='student_contact']").removeClass('is-valid').addClass('is-invalid')
        }
    } else {
        $("input[name='student_contact']").removeClass('is-invalid is-valid')
    }
})

$("input[name='father_contact_no']").on('blur',function(){
    let contact_no = $(this).val();
    let surfix=contact_no.substr(0,3);
    if (contact_no.length!=0) {
        if (contact_no.length==12 && surfix == '639') {
            $("input[name='father_contact_no']").removeClass('is-invalid').addClass('is-valid')
        } else {
            $("input[name='father_contact_no']").removeClass('is-valid').addClass('is-invalid')
        }
    } else {
        $("input[name='father_contact_no']").removeClass('is-invalid is-valid')
    }
})

$("input[name='mother_contact_no']").on('blur',function(){
    let contact_no = $(this).val();
    let surfix=contact_no.substr(0,3);
    if (contact_no.length!=0) {
        if (contact_no.length==12 && surfix == '639') {
            $("input[name='mother_contact_no']").removeClass('is-invalid').addClass('is-valid')
        } else {
            $("input[name='mother_contact_no']").removeClass('is-valid').addClass('is-invalid')
        }
    } else {
        $("input[name='mother_contact_no']").removeClass('is-invalid is-valid')
    }
})

$("input[name='guardian_contact_no']").on('blur',function(){
    let contact_no = $(this).val();
    let surfix=contact_no.substr(0,3);
    if (contact_no.length!=0) {
        if (contact_no.length==12 && surfix == '639') {
            $("input[name='guardian_contact_no']").removeClass('is-invalid').addClass('is-valid')
        } else {
            $("input[name='guardian_contact_no']").removeClass('is-valid').addClass('is-invalid')
        }
    } else {
        $("input[name='guardian_contact_no']").removeClass('is-invalid is-valid')
    }
})

let fileValidation = (fileInput,target) => {
      
    let filePath = fileInput;
  
    // Allowing file type
    let allowedExtensions = /(\.png|\.jpeg|\.jpg)$/i;
      
    if (!allowedExtensions.exec(filePath)) {
        alert('Invalid file type');
        $('input[name="'+target+'"]').val('');
        return false;
    } 
}

$("input[name='req_grade']").on('change',function(){
    fileValidation($(this).val(),'req_grade')
})
$("input[name='req_goodmoral']").on('change',function(){
    fileValidation($(this).val(),'req_goodmoral')
})
$("input[name='req_psa']").on('change',function(){
    fileValidation($(this).val(),'req_psa')
})

