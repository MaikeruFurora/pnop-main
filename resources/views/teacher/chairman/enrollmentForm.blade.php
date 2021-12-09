@extends('../layout/app')
@section('moreCss')
<link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
@endsection
@section('content')
<section class="section">
    <div class="section-body">
        <h2 class="section-title">Enrollment Form | Grade {{ auth()->user()->chairman_info->grade_level }} Chairman</h2>
        <div class="col-lg-12 col-md-12 col-sm-12">
          
            <div class="card">
                <div class="card-header">
                    <h4>Enrollement Module (Walk-in)</h4>
                </div>
                <div class="card-body">
                    <form class="" id="enrollForm">@csrf
                        <input type="hidden" name="grade_level" value="{{ auth()->user()->chairman_info->grade_level }}">
                        <div class="form-row">
                           
                            <div class="col-md-4 mb-3">
                                <label>Status.</label>
                                <select name="status" class="form-control" required>
                                    <option value="nothing"></option>
                                    <option value="upperclass">Upper Class</option>
                                    <option value="transferee">New/Transferee</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Curriculum</label>
                                <select name="curriculum" class="form-control" required>
                                    <option value=""></option>
                                    <option value="STEM">STEM - Science Technology Engineering and Mathematics</option>
                                    <option value="BEC">BEC - Basic Education Curriculum</option>
                                    <option value="SPA">SPA - Special Program Art</option>
                                    <option value="SPJ">SPJ - Special Program Journalism</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Learning Reference No.</label>
                                <input type="text" class="form-control" required name="roll_no" maxlength="12"  onkeypress="return numberOnly(event)">
                            </div>
                           
                        </div>
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label>First name</label>
                                <input type="text" class="form-control" required name="student_firstname">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Middle name</label>
                                <input type="text" class="form-control" name="student_middlename">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Last name</label>
                                <input type="text" class="form-control" required name="student_lastname">
                            </div>
                            <div class="col-md-1 mb-3">
                                <label>Exnt. name</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>Date of Birth</label>
                                <input type="date" class="form-control" required name="date_of_birth">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Gender</label>
                                <select name="gender" class="form-control">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Contact No.(eg. +639)</label>
                                <input type="text" class="form-control" name="student_contact" pattern="^[0-9]{12}$"
                                    onkeypress="return numberOnly(event)" maxlength="12" placeholder="(eg. +639)" >
                            </div>
                            <div class="form-group col-md-3">
                                <label>Section</label>
                                <select name="section_id" class="form-control" required>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="last_school">
                            <label>Last school attended</label>
                            <input type="text" class="form-control" name="last_school_attended" required style="text-transform: uppercase">
                        </div>
                        <div class="form-row" id="notUpper">
                            <div class="form-group col-lg-3">
                                <label>Region</label>
                                <select name="region_text" id="region" class="custom-select">
                                    {{-- <option value="region"></option> --}}
                                </select>
                                <input type="hidden" name="region">
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Province</label>
                                <select name="province_text" id="province" class="custom-select">
                                    {{-- <option value="province"></option> --}}
                                </select>
                                <input type="hidden" name="province">
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Town</label>
                                <select name="city_text" id="city" class="custom-select">
                                    {{-- <option value="city"></option> --}}
    
                                    <input type="hidden" name="city">
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Barangay</label>
                                <select name="barangay_text" id="barangay" class="custom-select">
                                    {{-- <option value="barangay"></option> --}}
                                </select>
                                <input type="hidden" name="barangay">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-lg-8">
                                <label>Father's name</label>
                                <input type="text" class="form-control" name="father_name">
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Contact No.(eg. +639)</label>
                                <input type="text" class="form-control" name="father_contact_no" pattern="^[0-9]{12}$"
                                    onkeypress="return numberOnly(event)" maxlength="12" placeholder="(eg. +639)">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-lg-8">
                                <label>Mother's name</label>
                                <input type="text" class="form-control" name="mother_name">
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Contact No.(eg. +639)</label>
                                <input type="text" class="form-control" name="mother_contact_no" pattern="^[0-9]{12}$"
                                    onkeypress="return numberOnly(event)" maxlength="12" placeholder="(eg. +639)">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-lg-8">
                                <label>Guardian's name</label>
                                <input type="text" class="form-control" name="guardian_name">
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Contact No.(eg. +639)</label>
                                <input type="text" class="form-control" name="guardian_contact_no" pattern="^[0-9]{12}$"
                                    onkeypress="return numberOnly(event)" maxlength="12" placeholder="(eg. +639)">
                            </div>
    
                        </div>
                        <button  type="submit" class="btn btn-primary btnSaveEnroll">Submit form</button>
                        </form>
                </div>
            </div>
            
        </div>
    </div><!-- section-body -->
</section>
@endsection

@section('moreJs')
<script src="{{ asset('js/select2/select2.full.min.js') }}"></script>
<script>
    let searchSecionByLevel = (curriculum) => {
    if (curriculum != "") {
        let htmlHold = "";
        $.ajax({
            url: "section/search/by/level/" + curriculum,
            type: "GET",
        })
            .done(function (data) {
                // htmlHold += ` <option></option>`;
                data.forEach((element) => {
                    htmlHold += `<option value="${element.id}">${element.section_name}</option>`;
                });
                $("select[name='section_id']").html(htmlHold);
            })
            .fail(function (jqxHR, textStatus, errorThrown) {
                getToast("error", "Eror", errorThrown);
                $(".btnSaveSection").html("Submit").attr("disabled", false);
            });
    }
};

$("select[name='curriculum']").on("change", function () {
    searchSecionByLevel($(this).val());
});

$("select[name='status']").on('change',function(){
    if ($(this).val()=="upperclass") {
        $('input[name="last_school_attended"]').val('PILI NATIONAL HIGH SCHOOL');
    }else{
        $('input[name="last_school_attended"]').val('');
    }
})

$("input[name='roll_no']").on("blur", function () {
    if ($(this).val() == "") {
        document.getElementById("enrollForm").reset();
        $('select[name="grade_level"]').val(current_glc).attr("readonly", true);
        $("select[name='curriculum']")
            .val($("select[name='curriculum']").val())
            .attr("readonly", true);
        $("input[name='roll_no']").removeClass("is-valid is-invalid");
    } else {
        let status = $("select[name='status']").val();
        $.ajax({
            url: `check/lrn/${$(this).val()}/${$("select[name='curriculum']").val()}/${status}`,
            type: "GET",
        })
            .done(function (data) {
                if (data.warning) {
                    getToast("warning", "Warning", data.warning);
                    $("input[name='roll_no']").addClass("is-invalid");
                    $(".btnSaveEnroll").attr("disabled", true);
                } else {
                    $('select[name="grade_level"]').attr("disabled", false);
                    $("input[name='roll_no']")
                    .removeClass("is-invalid")
                    .addClass("is-valid");
                    $(".btnSaveEnroll").attr("disabled", false);
                    if (data.student) {
                        getToast("success", "Success", "Have Record");
                        console.log(data.student);
                       
                        // $('input[name="last_school_attended"]').val(
                        //     data.student.last_school_attended
                        // );
                        $("input[name='student_firstname']").val(
                            data.student.student_firstname
                        );
                        $("input[name='student_middlename']").val(
                            data.student.student_middlename
                        );
                        $("input[name='student_lastname']").val(
                            data.student.student_lastname
                        );
                        // $("input[name='region']").val(data.student.region);
                        // $("input[name='province']").val(data.student.province);
                        // $("input[name='city']").val(data.student.city);
                        // $("input[name='barangay']").val(data.student.barangay);
                        $("input[name='date_of_birth']").val(
                            data.student.date_of_birth
                        );

                        // $("input[name='address']").val(
                        //     data.student.barangay +
                        //         ", " +
                        //         data.student.city +
                        //         ", " +
                        //         data.student.province
                        // );
                        $("select[name='gender']").val(data.student.gender);
                        $("input[name='student_contact']").val(
                            data.student.student_contact
                        );
                        $("input[name='mother_name']").val(
                            data.student.mother_name
                        );
                        $("input[name='mother_contact_no']").val(
                            data.student.mother_contact_no
                        );
                        $("input[name='father_name']").val(
                            data.student.father_name
                        );
                        $("input[name='father_contact_no']").val(
                            data.student.father_contact_no
                        );
                        $("input[name='guardian_name']").val(
                            data.student.guardian_name
                        );
                        $("input[name='guardian_contact_no']").val(
                            data.student.guardian_contact_no
                        );
                    }
                }
            })
            .fail(function (jqxHR, textStatus, errorThrown) {
                // getToast("error", "Eror", errorThrown);
            });
    }
});


$("#enrollForm").submit(function (e) {
    e.preventDefault();
    if ($("select[name='status']").val() != "nothing") {
        $.ajax({
            url: "save",
            type: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function () {
                $(".btnSaveEnroll")
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
                $("input[name='roll_no']").removeClass("is-valid");
                getToast("success", "Ok", "Successfully added new enrolled");
                $(".btnSaveEnroll").html("Enroll").attr("disabled", false);
                document.getElementById("enrollForm").reset();
              
            })
            .fail(function (jqxHR, textStatus, errorThrown) {
                getToast("error", "Eror", errorThrown);
                $(".btnSaveEnroll").html("Submit form").attr("disabled", false);
            });
    } else {
        getToast(
            "warning",
            "Warning",
            "You must select student Status for verification"
        );
    }
});
</script>
@endsection