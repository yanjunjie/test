<link href="<?php echo base_url(); ?>assets/css/plugins/datapicker/jquery-ui.datepicker.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/keyboard/keyboard.css" rel="stylesheet">

<style>
    .flexy {
        display: block;
        width: 90%;
        border: 1px solid #eee;
        max-height: 200px;
        overflow: auto;
    }

    .avatar-zone {
        width: 140px;
        height: 200px;

    }

    .overlay-layer {
        width: 180px;
        height: 40px;
        position: absolute;
        margin-top: -40px;
        opacity: 0.5;
        background-color: #000000;
        z-index: 0;
        font-size: 15px;
        color: #FFFFFF;
        text-align: center;
        line-height: 40px;

    }

    .avatar-zone-sig {
        width: 140px;
        height: 92px;

    }

    .overlay-layer-sig {
        width: 180px;
        height: 40px;
        position: absolute;
        margin-top: -40px;
        opacity: 0.5;
        background-color: #000000;
        z-index: 0;
        font-size: 15px;
        color: #FFFFFF;
        text-align: center;
        line-height: 40px;
    }

    .upload_btn {
        position: absolute;
        width: 200px;
        height: 40px;
        margin-top: -40px;
        z-index: 10;
        opacity: 0;
    }

    .red {
        color: red
    }

    .pointer2 {
        cursor: pointer;
    }

    .div-background {
        background-color: #D9E0E7;
        padding: 20px;
        border-radius: 10px
    }

    .toggle-div {
        display: none;
        background-color: #FCF8E3;
        padding: 10px;
        border-radius: 10px;
    }

    .toggle-div-course {
        display: none;
        background-color: #FCF8E3;
        padding: 10px;
        border-radius: 10px;
        width: 400px;
    }

    .toggle-div1 {
        background-color: #FCF8E3;
        padding: 10px;
        border-radius: 10px;
    }
</style>
<link href="<?php echo base_url(); ?>assets/css/plugins/jQueryUI/jquery-ui-1.10.4.custom.min.css" rel="stylesheet">

<div class="ibox-title">
    <h5>Family and Others Information</h5>
    <?php // if ($applicant_info->ELIGIBLE_BY_ADDMISSION_DEPT_STATUS != 1) : ?>
    <div class="ibox-tools">

        <span data-action="applicant/applicantFamillyDetails" id="update_family_cancel_btn"
              class="btn btn-success btn-xs pull-right" applicant-data-id="<?php echo $fathersInfo->APPLICANT_ID; ?>"
              role="button"><i class="fa fa-mail-reply"></i> Back</span>
    </div>
    <?php // endif; ?>
</div>

<div class="ibox-content">
    <form id="applicant_academic_form" class="form-horizontal fContent" method="post"
          enctype="multipart/form-data">
        <div class="">
            <div class="div-background">
                <input type="hidden" name="APP_FATHER_ID" value="<?php echo $fathersInfo->APP_PARENT_ID; ?>">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-5 control-label">Father's Name <span class="red">*</span></label>

                        <div class="col-md-5">
                            <input type="text" name="FATHER_NAME" id="FATHER_NAME"
                                   value="<?php echo $fathersInfo->GURDIAN_NAME; ?>" class="form-control"
                                   placeholder="Father's Name">
                        </div>
                        <div class="col-md-2">
                            <i class="fa fa-info-circle pointer2"
                               data-content="Please enter your father's name here" data-placement="right"
                               data-toggle="popover" data-container="body" data-original-title=""
                               title="Help"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-5 control-label">Father's Occupation</label>
                        <div class="col-md-5">
                            <select class="form-control" name="FATHER_OCU" id="FATHER_OCU">
                                <option value="">-Select-</option>
                                <?php foreach ($occupation as $row): ?>
                                    <option value="<?php echo $row->LKP_ID ?>" <?php echo ($fathersInfo->OCCUPATION == $row->LKP_ID) ? 'selected' : set_value('MOTHER_OCU') ?>><?php echo $row->LKP_NAME ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <i class="fa fa-info-circle pointer2"
                               data-content="Please enter your Father Occupation here" data-placement="right"
                               data-toggle="popover" data-container="body" data-original-title=""
                               title="Help"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-5 control-label">Father's Mobile </label>

                        <div class="col-md-5">
                            <input type="text" name="FATHER_PHN" id="FATHER_PHN"
                                   value="<?php echo $fathersInfo->MOBILE_NO; ?>"
                                   class="form-control numbersOnly" placeholder="Father's Phone">
                        </div>
                        <div class="col-md-2">
                            <i class="fa fa-info-circle pointer2"
                               data-content="Please enter your Father's  mobile no here" data-placement="right"
                               data-toggle="popover" data-container="body" data-original-title=""
                               title="Help"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-5 control-label">Father's Email </label>

                        <div class="col-md-5">
                            <input type="text" name="FATHER_EMAIL" id="FATHER_EMAIL"
                                   value="<?php echo $fathersInfo->EMAIL_ADRESS; ?>"
                                   class="form-control checkEmail" placeholder="Father's Email">
                            <span class="red father_email_validation"></span>
                        </div>
                        <div class="col-md-2">
                            <i class="fa fa-info-circle pointer2"
                               data-content="Please enter your father's valid email address here"
                               data-placement="right" data-toggle="popover" data-container="body"
                               data-original-title="" title="Help"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-5 control-label">Name and address of the work </label>

                        <div class="col-md-5">
                                        <textarea id="FATHER_WORK_ADRESS" class="form-control" rows="5"
                                                  name="FATHER_WORK_ADRESS"><?php echo set_value('FATHER_WORK_ADRESS'); ?>

                                            <?php echo $fathersInfo->WORKING_ORG; ?>
                                    </textarea>

                        </div>
                        <div class="col-md-2">
                            <i class="fa fa-info-circle pointer2"
                               data-content="Enter your local guardian address here" data-placement="right"
                               data-toggle="popover" data-container="body" data-original-title=""
                               title="Help"></i>
                        </div>
                    </div>

                </div>


                <input type="hidden" name="APP_MOTHER_ID" value="<?php echo $motherInfo->APP_PARENT_ID; ?>">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-5 control-label">Mother's Name <span class="red">*</span></label>

                        <div class="col-md-5">
                            <input type="text" name="MOTHER_NAME" id="MOTHER_NAME"
                                   value="<?php echo $motherInfo->GURDIAN_NAME; ?>" class="form-control"
                                   placeholder="Mother's Name">
                            <span class="red"><?php echo form_error('MOTHER_NAME'); ?></span>
                        </div>
                        <div class="col-md-2">
                            <i class="fa fa-info-circle pointer2"
                               data-content="Please enter your mother's name here" data-placement="right"
                               data-toggle="popover" data-container="body" data-original-title=""
                               title="Help"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-5 control-label">Mother's Occupation</label>

                        <div class="col-md-5">
                            <select class="form-control" name="MOTHER_OCU" id="MOTHER_OCU">
                                <option value="">-Select-</option>
                                <?php foreach ($occupation as $row): ?>
                                    <option value="<?php echo $row->LKP_ID ?>" <?php echo ($motherInfo->OCCUPATION == $row->LKP_ID) ? 'selected' : set_value('MOTHER_OCU') ?>><?php echo $row->LKP_NAME ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <i class="fa fa-info-circle pointer2"
                               data-content="Please enter your mother's occupation here" data-placement="right"
                               data-toggle="popover" data-container="body" data-original-title=""
                               title="Help"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-5 control-label">Mother's Mobile</label>

                        <div class="col-md-5">
                            <input type="text" name="MOTHER_PHN" id="MOTHER_PHN"
                                   value="<?php echo $motherInfo->MOBILE_NO; ?>"
                                   class="form-control numbersOnly" placeholder="Mother's Phone">
                        </div>

                        <div class="col-md-1">
                            <i class="fa fa-info-circle pointer2"
                               data-content="Please enter your mother's valid mobile no here"
                               data-placement="right" data-toggle="popover" data-container="body"
                               data-original-title="" title="Help"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-5 control-label">Mother's Email </label>

                        <div class="col-md-5">
                            <input type="text" name="MOTHER_EMAIL" id="MOTHER_EMAIL"
                                   value="<?php echo $motherInfo->EMAIL_ADRESS; ?>"
                                   class="form-control checkEmail" placeholder="Mother's Email">
                            <span class="red mother_email_validation"></span>
                        </div>

                        <div class="col-md-1">
                            <i class="fa fa-info-circle pointer2"
                               data-content="Please enter your mother's valid email address here"
                               data-placement="right" data-toggle="popover" data-container="body"
                               data-original-title="" title="Help"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-5 control-label">Name and address of the work </label>

                        <div class="col-md-5">
                                    <textarea id="MOTHER_WORK_ADDRESS" class="form-control" rows="5"
                                              name="MOTHER_WORK_ADDRESS">
                                    <?php echo $motherInfo->WORKING_ORG; ?>
                                </textarea>
                        </div>
                        <div class="col-md-2">
                            <i class="fa fa-info-circle pointer2"
                               data-content="Enter your local guardian address here" data-placement="right"
                               data-toggle="popover" data-container="body" data-original-title=""
                               title="Help"></i>
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Local Emergency Guardian </label>

                    <div class="col-md-3">
                        <input type="radio" name="local_emergency_guardian" class="local_emergency_guardian"
                               value="F" <?php echo ($local_guardian->GUARDIAN_TYPE == 'F') ? "checked" : ""; ?> >&nbsp;
                        Father &nbsp;
                        <input type="radio" name="local_emergency_guardian" class="local_emergency_guardian"
                               value="M" <?php echo ($local_guardian->GUARDIAN_TYPE == 'M') ? "checked" : ""; ?> >&nbsp;
                        Mother &nbsp;
                        <input type="radio" name="local_emergency_guardian" class="local_emergency_guardian"
                               value="O" <?php echo ($local_guardian->GUARDIAN_TYPE == 'O') ? "checked" : ""; ?> >&nbsp;
                        Others
                    </div>
                    <div class="col-md-2">
                        <i class="fa fa-info-circle pointer2" data-content="Select your local guardian here"
                           data-placement="right" data-toggle="popover" data-container="body"
                           data-original-title="" title="Help"></i>
                    </div>
                </div>


                <div id="local_guardian"
                     class="<?php echo ($local_guardian->GUARDIAN_TYPE == 'O') ? "toggle-div1" : "toggle-div"; ?>">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Local Guardian Name</label>

                        <div class="col-md-3">
                            <input type="text" name="LOCAL_GAR_NAME" id="LOCAL_GAR_NAME"
                                   value="<?php echo $local_guardian->GURDIAN_NAME; ?>"
                                   class="form-control" placeholder="Local Guardian Name">
                        </div>
                        <div class="col-md-3">
                            <i class="fa fa-info-circle pointer2" data-content="Enter your Local Guardian Name"
                               data-placement="right" data-toggle="popover" data-container="body"
                               data-original-title="" title="Help"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Local Guardian Relation</label>

                        <div class="col-md-3">
                            <select class="form-control " id="LOCAL_GAR_RELATION" name="LOCAL_GAR_RELATION"
                                    id="LOCAL_GAR_RELATION">
                                <option value="">-Select-</option>
                                <?php foreach ($relation as $row): ?>
                                    <option value="<?php echo $row->LKP_ID ?>" <?php echo ($local_guardian->GUARDIAN_RELATION == $row->LKP_ID) ? 'selected' : set_value('LOCAL_GAR_RELATION') ?>><?php echo $row->LKP_NAME ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <i class="fa fa-info-circle pointer2"
                               data-content="Select your Local Guardian relation" data-placement="right"
                               data-toggle="popover" data-container="body" data-original-title=""
                               title="Help"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Local Guardian Address </label>

                        <div class="col-md-3">
            <textarea class="form-control " id="LOCAL_GAR_ADDRESS"
                      name="LOCAL_GAR_ADDRESS"><?php echo $local_guardian->ADDRESS; ?></textarea>

                        </div>
                        <div class="col-md-3">
                            <i class="fa fa-info-circle pointer2"
                               data-content="Enter your local guardian address here" data-placement="right"
                               data-toggle="popover" data-container="body" data-original-title=""
                               title="Help"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Local Guardian Mobile</label>

                        <div class="col-md-3">
                            <input type="text" name="LOCAL_GAR_PHN" id="LOCAL_GAR_PHN"
                                   value="<?php echo $local_guardian->MOBILE_NO; ?>"
                                   class="form-control  numbersOnly" placeholder="Mobile">
                        </div>

                        <div class="col-md-1">
                            <i class="fa fa-info-circle pointer2"
                               data-content="Please enter your Local Guardian  mobile no here"
                               data-placement="right" data-toggle="popover" data-container="body"
                               data-original-title="" title="Help"></i>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>

            <br>
            <div class="form-group">
                <div class="col-sm-3  pull-right">
                    <input type="button" class="btn btn-primary btn-xs fSubmit pull-right"
                           data-action="applicant/updateApplicantFamilyDetails"
                           data-su-action="applicant/applicantFamillyDetails" value="Update">
                </div>
            </div>
        </div>
    </form>
</div>


<script src="<?php echo base_url(); ?>assets/js/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>assets/keyboard/keyboard.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
<script>

    $("#admission_form").validate({
        rules: {


            NATIONALITY: {required: true},
            RELIGION_ID: {required: true},
            MARITAL_STATUS: {required: true},
            FATHER_NAME: {required: true},
            MOTHER_NAME: {required: true},
            FATHER_EMAIL: {required: true, email: true},
            PLACE_OF_BIRTH: {required: true},
            NATIONAL_ID: {number: true, rangelength: [13, 17]},
            MARITAL_STATUS: {required: true},
        },
        messages: {


            NATIONALITY: "Nationality required",
            RELIGION_ID: "Religion required",
            MARITAL_STATUS: "Marital status required",
            FATHER_NAME: "Father name required",
            MOTHER_NAME: "Mother name required",
            FATHER_EMAIL: "Father valid email required",
            PLACE_OF_BIRTH: "Place of birth field is required",
            NATIONAL_ID: "Only number",
            MARITAL_STATUS: "Marital status required",

        }
    });

    $('#admission_form_submit').on('click', function (e) {
        $("#admission_form").submit();
        $('#admissionModal').modal('hide');
    });

    $('#admission_form_btn').on('click', function () {

        if ($("#admission_form").valid()) {
            //personal information
            $("#P_FULL_NAME_EN").text($("#FULL_NAME_EN").val());
            $("#P_FULL_NAME_BN").text($("#FULL_NAME_BN").val());
            $("#P_PLACE_OF_BIRTH").text($("#PLACE_OF_BIRTH").val());
            var blood_group = $("#BLOOD_GRP option:selected").text() == "-Select-" ? '' : $("#BLOOD_GRP option:selected").text();
            $("#P_BLOOD_GROUP").text(blood_group);
            var marital_status = $("#MARITAL_STATUS option:selected").text() == "-Select-" ? '' : $("#MARITAL_STATUS option:selected").text();
            $("#P_MARITAL_STATUS").text(marital_status);
            var religion = $("#RELIGION_ID option:selected").text() == "-Select-" ? '' : $("#RELIGION_ID option:selected").text();
            $("#P_RELIGION_ID").text(religion);
            $("#P_BIRTH_CERTIFICATE").text($("#BIRTH_CERTIFICATE").val());
            $("#P_NATIONAL_ID").text($("#NATIONAL_ID").val());
            $("#P_HEIGHT_FEET").text($("#HEIGHT_FEET").val());
            $("#P_HEIGHT_CM").text($("#HEIGHT_CM").val());
            $("#P_WEIGHT_KG").text($("#WEIGHT_KG").val());
            $("#P_WEIGHT_LBS").text($("#WEIGHT_LBS").val());


            //parents information
            $("#P_MOTHER_NAME").text($("#MOTHER_NAME").val());
            $("#P_MOTHER_PHN").text($("#MOTHER_PHN").val());
            $("#P_MOTHER_EMAIL").text($("#MOTHER_EMAIL").val());
            $("#P_MOTHER_WORK_ADRESS").text($("#MOTHER_WORK_ADRESS").val());
            var mother_ocu = $("#MOTHER_OCU option:selected").text() == "-Select-" ? '' : $("#MOTHER_OCU option:selected").text();
            $("#P_MOTHER_OCU").text(mother_ocu);

            $("#P_FATHER_NAME").text($("#FATHER_NAME").val());
            $("#P_FATHER_PHN").text($("#FATHER_PHN").val());
            $("#P_FATHER_EMAIL").text($("#FATHER_EMAIL").val());
            $("#P_FATHER_WORK_ADRESS").text($("#FATHER_WORK_ADRESS").val());
            var father_ocu = $("#FATHER_OCU option:selected").text() == "-Select-" ? '' : $("#FATHER_OCU option:selected").text();
            $("#P_FATHER_OCU").text(father_ocu);

            //local guardian
            var local_emergency_guardian = $('input[name=local_emergency_guardian]:checked', '#admission_form').val();
            if (local_emergency_guardian == 'F') {
                $("#local_guardian_div").html("Father");
            } else if (local_emergency_guardian == 'M') {
                $("#local_guardian_div").html("Mother");
            } else {
                $("#P_LOCAL_GAR_NAME").text($("#LOCAL_GAR_NAME").val());
                $("#P_LOCAL_GAR_ADDRESS").text($("#LOCAL_GAR_ADDRESS").val());
                $("#P_LOCAL_GAR_PHN").text($("#LOCAL_GAR_PHN").val());
                $("#P_LOCAL_GAR_RELATION").text($("#LOCAL_GAR_RELATION option:selected").text());
            }

            //present address
            $("#Pr_DIVISION_ID").text($("#DIVISION_ID option:selected").text());
            $("#Pr_DISTRICT_ID").text($("#DISTRICT_ID option:selected").text());
            $("#Pr_POLICE_STATION_ID").text($("#POLICE_STATION_ID option:selected").text());
            $("#Pr_POST_OFFICE_ID").text($("#POST_OFFICE_ID option:selected").text());
            $("#Pr_THANA_ID").text($("#THANA_ID option:selected").text());
            $("#Pr_UNION_ID").text($("#UNION_ID option:selected").text());
            $("#Pr_VILLAGE_WARD").text($("#VILLAGE").val());

            var same_as_present = $('input[name=same_as_present]:checked', '#admission_form').val()

            if (same_as_present == 'NO') {
                //permanent address
                $("#Pr_P_DIVISION_ID").text($("#P_DIVISION_ID option:selected").text());
                $("#Pr_P_DISTRICT_ID").text($("#P_DISTRICT_ID option:selected").text());
                $("#Pr_P_POLICE_STATION_ID").text($("#P_POLICE_STATION_ID option:selected").text());
                $("#Pr_P_POST_OFFICE_ID").text($("#P_POST_OFFICE_ID option:selected").text());
                $("#Pr_P_THANA_ID").text($("#P_THANA_ID option:selected").text());
                $("#Pr_P_UNION_ID").text($("#P_UNION_ID option:selected").text());
                $("#Pr_P_VILLAGE_WARD").text($("#P_VILLAGE").val());
            } else {
                $("#SAME_AS_PRESENT").html("Same as Present address");
            }


            //academic information
            $("#P_EXAM_NAME_S").text($("#EXAM_NAME_S option:selected").text());
            $("#P_PASSING_YEAR_S").text($("#PASSING_YEAR_S").val());
            $("#P_BOARD_S").text($("#BOARD_S option:selected").text());
            $("#P_GROUP_S").text($("#GROUP_S option:selected").text());
            $("#P_GPA_S").text($("#GPA_S").val());
            $("#P_GPAWA_S").text($("#GPAWA_S").val());
            $("#P_INSTITUTE_S").text($("#INSTITUTE_S").val());

            $("#P_EXAM_NAME_H").text($("#EXAM_NAME_H option:selected").text());
            $("#P_PASSING_YEAR_H").text($("#PASSING_YEAR_H").val());
            $("#P_BOARD_H").text($("#BOARD_H option:selected").text());
            $("#P_GROUP_H").text($("#GROUP_H option:selected").text());
            $("#P_GPA_H").text($("#GPA_H").val());
            $("#P_GPAWA_H").text($("#GPAWA_H").val());
            $("#P_INSTITUTE_H").text($("#INSTITUTE_H").val());

            $("#P_EXAM_NAME_G").text($("#EXAM_NAME_G option:selected").text());
            $("#P_PASSING_YEAR_G").text($("#PASSING_YEAR_G").val());
            $("#P_BOARD_G").text($("#BOARD_G option:selected").text());
            $("#P_GROUP_G").text($("#GROUP_G option:selected").text());
            $("#P_GPA_G").text($("#GPA_G").val());
            $("#P_GPAWA_G").text($("#GPAWA_G").val());
            $("#P_INSTITUTE_G").text($("#INSTITUTE_G").val());

            //others information
            $("#P_ANNUAL_INCOME").text($("#ANNUAL_INCOME").val());
            $("#P_SCHOLARSHIP").text($("#SCHOLARSHIP").val());
            $("#P_SCHOLARSHIP_DESC").text($("#SCHOLARSHIP_DESC").val());
            $("#P_EXPELLED").text($("input[name='EXPELLED']:checked").val());
            $("#P_EXPELLED_DESC").text($("#EXPELLED_DESC").val());
            $("#P_ARRESTED").text($("input[name='ARRESTED']:checked").val());
            $("#P_ARRESTED_DESC").text($("#ARRESTED_DESC").val());
            $("#P_CONVICTED").text($("input[name='CONVICTED']:checked").val());
            $("#P_CONVICTED_DESC").text($("#CONVICTED_DESC").val());
            $("#P_APPLY_BEFORE").text($("input[name='APPLY_BEFORE']:checked").val());
            $("#P_APPLY_SEMESTER").text($("#APPLY_SEMESTER").val());
            $("#P_APPLY_YEAR").text($("#APPLY_YEAR").val());
            $("#P_SIBLING_EXIST").text($("input[name='SIBLING_EXIST']:checked").val());
            $("#P_SBLN_ROLL_NO").text($("#SBLN_ROLL_NO").val());

            $('#admissionModal').modal({
                show: true
            });

        } else {

        }
    });

    //This function  is use for student image preview before upload
    function upload_img(input) {
        var fileTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (input.files && input.files[0]) {
            var extension = input.files[0].name.split('.').pop().toLowerCase(),  //file extension from input file
                isSuccess = fileTypes.indexOf(extension) > -1;
            var fsize = $('#propic')[0].files[0].size;
            if (isSuccess) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var image = new Image();
                    image.src = reader.result;

                    image.onload = function () {
                        if (image.height > 300 && image.width > 300) {
                            alert("Dimension prefarable 300 X 300 px ");
                        } else if (fsize > 102400) {
                            alert("Size should not exceed 100 KB ");
                        } else {
                            $('#img_id').attr('src', e.target.result);
                            $('#p_img_id').attr('src', e.target.result);

                        }
                    };
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                alert("This file type does not support");
            }
        }
    }
    //This function  is use for student image preview before upload
    function upload_img_sig(input) {
        var fileTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (input.files && input.files[0]) {
            var extension = input.files[0].name.split('.').pop().toLowerCase(),  //file extension from input file
                isSuccess = fileTypes.indexOf(extension) > -1;
            var fsize = $('#sigpic')[0].files[0].size;
            if (isSuccess) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var image = new Image();
                    image.src = reader.result;

                    image.onload = function () {
                        if (image.height > 80 && image.width > 300) {
                            alert("Dimension prefarable 300 X 80 px ");
                        } else if (fsize > 61440) {
                            alert("Size should not exceed 60 KB ");
                        } else {
                            $('#sig_id').attr('src', e.target.result);
                            $('#p_sig_id').attr('src', e.target.result);
                        }
                    };
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                alert("This file type does not support");
            }
        }
    }

    $(document).on("click", ".same_as_present", function () {
        var same_as_present = $('input[name=same_as_present]:checked').val();

        if (same_as_present == 'YES') {
            $('#permanent_address').find('input, textarea, button, select').attr('disabled', true);
        } else {
            $('#permanent_address').find('input, textarea, button, select').attr('disabled', false);
        }

    });
    $(document).on("change", "#DIVISION_ID", function () {
        $("#THANA_ID").val("");
        $("#POLICE_STATION_ID").val("");
        $("#POST_OFFICE_ID").val("");
        $("#UNION_ID").val("");
        var DIVISION_ID = $(this).val();

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>common/dis_by_div_id',
            data: {DIVISION_ID: DIVISION_ID},
            success: function (data) {
                $("#DISTRICT_ID").html(data)
            }
        });
    });
    $(document).on("change", "#DISTRICT_ID", function () {
        $("#THANA_ID").val("");
        $("#POLICE_STATION_ID").val("");
        $("#POST_OFFICE_ID").val("");
        $("#UNION_ID").val("");
        var DISTRICT_ID = $(this).val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>common/up_thana_by_dis_id',
            data: {DISTRICT_ID: DISTRICT_ID},
            success: function (data) {
                $("#THANA_ID").html(data)
            }
        });

    });
    $(document).on("change", "#THANA_ID", function () {
        var THANA_ID = $(this).val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>common/union_by_thana_id',
            data: {THANA_ID: THANA_ID},
            success: function (data) {
                $("#UNION_ID").html(data)
            }
        });
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>common/police_station_by_thana_id',
            data: {THANA_ID: THANA_ID},
            success: function (data) {
                $("#POLICE_STATION_ID").html(data)
            }
        });
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>common/post_office_by_thana_id',
            data: {THANA_ID: THANA_ID},
            success: function (data) {
                $("#POST_OFFICE_ID").html(data)
            }
        });
    });
    $(document).on("change", "#P_DIVISION_ID", function () {
        $("#P_THANA_ID").val("");
        $("#P_POLICE_STATION_ID").val("");
        $("#P_POST_OFFICE_ID").val("");
        $("#P_UNION_ID").val("");
        var DIVISION_ID = $(this).val();

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>common/dis_by_div_id',
            data: {DIVISION_ID: DIVISION_ID},
            success: function (data) {
                $("#P_DISTRICT_ID").html(data)
            }
        });
    });
    $(document).on("change", "#P_DISTRICT_ID", function () {
        $("#P_THANA_ID").val("");
        $("#P_POLICE_STATION_ID").val("");
        $("#P_POST_OFFICE_ID").val("");
        $("#P_UNION_ID").val("");
        var DISTRICT_ID = $(this).val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>common/up_thana_by_dis_id',
            data: {DISTRICT_ID: DISTRICT_ID},
            success: function (data) {
                $("#P_THANA_ID").html(data)
            }
        });

    });
    $(document).on("change", "#P_THANA_ID", function () {
        var THANA_ID = $(this).val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>common/union_by_thana_id',
            data: {THANA_ID: THANA_ID},
            success: function (data) {
                $("#P_UNION_ID").html(data)
            }
        });
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>common/police_station_by_thana_id',
            data: {THANA_ID: THANA_ID},
            success: function (data) {
                $("#P_POLICE_STATION_ID").html(data)
            }
        });
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>common/post_office_by_thana_id',
            data: {THANA_ID: THANA_ID},
            success: function (data) {
                $("#P_POST_OFFICE_ID").html(data)
            }
        });
    });
    $(document).on("click", ".local_emergency_guardian", function () {
        var is_local = $(this).val();
        if (is_local == 'O') {
            $('#local_guardian').show();
            $('#finance_guardian').show();
        } else {
            $('#local_guardian').hide();
            $('#finance_guardian').hide();
        }
    });
    $(document).on('click', '#siblin', function () {
        if ($('input[name="SIBLING_EXIST"]:checked').val() == "YES") {
            $('.sibId').show();
        } else {
            $('.sibId').hide();
        }
    });
    $(document).on('click', '#scholarship_id', function () {
        if ($('input[name="SCHOLARSHIP"]:checked').val() == "YES") {
            $('.scholarships').show();
        } else {
            $('.scholarships').hide();
        }
    });
    $(document).on('click', '#expelled_id', function () {
        if ($('input[name="EXPELLED"]:checked').val() == "YES") {
            $('.expelled_div').show();
        } else {
            $('.expelled_div').hide();
        }
    });
    $(document).on('click', '#arrested_id', function () {
        if ($('input[name="ARRESTED"]:checked').val() == "YES") {
            $('.arrested_div').show();
        } else {
            $('.arrested_div').hide();
        }
    });
    $(document).on('click', '#convicted_id', function () {
        if ($('input[name="CONVICTED"]:checked').val() == "YES") {
            $('.convicted_div').show();
        } else {
            $('.convicted_div').hide();
        }
    });
    $(document).on('click', '#apply_before_id', function () {
        if ($('input[name="APPLY_BEFORE"]:checked').val() == "YES") {
            $('.apply_before_div').show();
        } else {
            $('.apply_before_div').hide();
        }
    });

    $('#WEIGHT_KG').on('keyup', function () {
        var pound = parseFloat("2.20462");
        var total = ($(this).val() * pound);
        var n = total.toFixed(2);
        $("#WEIGHT_LBS").val(n);

    });
    $('#WEIGHT_LBS').on('keyup', function () {
        var kg = parseFloat("0.453592");
        var total = ($(this).val() * kg);
        var n = total.toFixed(2);
        $("#WEIGHT_KG").val(n)
    });
    $('#HEIGHT_FEET').on('keyup', function () {
        var cm = parseFloat("30.48");
        var total = ($(this).val() * cm);
        var n = total.toFixed(2);
        $("#HEIGHT_CM").val(n);

    });
    $('#HEIGHT_CM').on('keyup', function () {
        var ft = parseFloat("0.0328084");
        var total = ($(this).val() * ft);
        var n = total.toFixed(2);
        $("#HEIGHT_FEET").val(n)
    });
    $(document).on("click", ".local_emergency_guardian", function () {
        var thisVal = $(this).val();
        if (thisVal == 'O') {
            $(".is_required_o").attr("required", "required");
        } else {
            $(".is_required_o").removeAttr("required");
        }
    });
    // get batch by change program
    $(document).on('change', '#PROGRAM_ID', function () {
        var program_id = $(this).val();
        var session_id = $("#SESSION").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('common/batchByProgramId'); ?>',
            data: {program_id: program_id, session_id: session_id},
            success: function (data) {
                $('#BATCH_ID').html(data);
            }
        });
    });


    // Cancel Button

    $('#update_family_cancel_btn').click(function () {
        var APPLICANT_ID = $("#APPLICANT_ID").attr('applicant-data-id');
        var action_uri = $(this).attr('data-action');
        $.ajax({
            type: 'post',
            url: "<?php echo base_url(); ?>/" + action_uri,
            data: {APPLICANT_ID: APPLICANT_ID},
            beforeSend: function () {
                $(".profile-content").html("<img src='<?php echo base_url(); ?>assets/img/loader.gif' />");
            },
            success: function (data) {
                $('.profile-content').html(data);
            }
        });
    });

</script>

