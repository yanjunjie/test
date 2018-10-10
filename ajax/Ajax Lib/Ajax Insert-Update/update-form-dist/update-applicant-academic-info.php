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
    <h5>Academic information</h5>
    <?php // if ($applicant_info->ELIGIBLE_BY_ADDMISSION_DEPT_STATUS != 1) : ?>
    <div class="ibox-tools">
        <span data-action="admin/applicantAcademicInfo" id="update_academic_cancel_btn"
              class="btn btn-success btn-xs pull-right" applicant-data-id="<?php echo $APPLICANT_ID; ?>"
              role="button"><i class="fa fa-mail-reply"></i> Back</span>
    </div>
    <?php // endif; ?>
</div>

<div class="ibox-content">
<form id="applicant_academic_form" class="form-horizontal fContent" method="post">
    <div class="">
        <div class="">
            <div class="form-group">
                <div class="col-md-12">
                    <table id="academic_list" class="table table-bordered">
                        <tr class="info">
                            <th width="20%">Exam Name</th>
                            <th width="5%">Year</th>
                            <th width="20%">Board</th>
                            <th width="22%">Group</th>
                            <th width="27%">Institute</th>
                            <th width="3%">CGPA</th>
                            <th width="3%">Result W/A</th>
                        </tr>
                        <tbody>

                        <?php $j=0; foreach ($academic as $applicant_row) : ?>
                            <?php $j++; ?>
                            <input type="hidden" name="APP_AI_ID[<?php echo $j; ?>]]" id="" value="<?php echo $applicant_row->APP_AI_ID; ?>">
                            <tr>
                                <td>
                                    <select class="form-control" name="EXAM_NAME[<?php echo $j; ?>]" class="EXAM_NAME" id="EXAM_NAME<?php echo $j; ?>">
                                        <option value="">-Select-</option>
                                        <?php foreach ($exam_name as $row): ?>
                                            <option value="<?php echo $row->LKP_ID ?>" <?php echo ($applicant_row->EXAM_DEGREE_ID == $row->LKP_ID) ? 'selected' : set_value('EXAM_NAME[]') ?>><?php echo $row->LKP_NAME ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <input style="width: 50px" type="text" name="PASSING_YEAR[<?php echo $j; ?>]" id="PASSING_YEAR<?php echo $j; ?>"
                                           value="<?php echo $applicant_row->PASSING_YEAR; ?>"
                                           class=" form-control numbersOnly"  placeholder="Year">
                                </td>
                                <td>
                                    <select class="form-control" name="BOARD[<?php echo $j; ?>]" id="BOARD<?php echo $j; ?>">
                                        <option value="">-Select-</option>
                                        <?php foreach ($board_name as $row): ?>
                                            <option value="<?php echo $row->LKP_ID ?>" <?php echo ($applicant_row->BR == $row->LKP_NAME) ? 'selected' : set_value('BOARD[]') ?>><?php echo $row->LKP_NAME ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" name="GROUP[<?php echo $j; ?>]" id="GROUP<?php echo $j; ?>">
                                        <option value="">-Select-</option>
                                        <?php foreach ($group_name as $row): ?>
                                            <option value="<?php echo $row->LKP_ID ?>" <?php echo ($applicant_row->MG == $row->LKP_NAME) ? 'selected' : set_value('GROUP[]') ?>><?php echo $row->LKP_NAME ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="INSTITUTE[<?php echo $j; ?>]"
                                           value="<?php echo $applicant_row->INSTITUTION; ?>" class="form-control"
                                           id="INSTITUTE<?php echo $j; ?>" placeholder="Institute Name">
                                </td>
                                <td>
                                    <input style="width: 50px" type="text" name="GPA[<?php echo $j; ?>]"
                                           value="<?php echo $applicant_row->RESULT_GRADE; ?>" id="GPA<?php echo $j; ?>"
                                           class="form-control numbersOnly" placeholder="CGPA">
                                </td>
                                <td>
                                    <input style="width: 50px" type="text" name="GPAWA[<?php echo $j; ?>]"
                                           value="<?php echo $applicant_row->RESULT_GRADE_WA; ?>" id="GPAWA<?php echo $j; ?>"
                                           class="form-control numbersOnly" placeholder="CGPA">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <br>
            </div>
            <div class="clearfix"></div>
        </div>

        <br>
        <div class="form-group">
            <div class="col-sm-3  pull-right">
                <input type="button" class="btn btn-primary btn-xs fSubmit pull-right"
                       data-action="admin/updateApplicantAcademicInfo/<?php echo $APPLICANT_ID;  ?>"
                       data-param="<?php echo $APPLICANT_ID; ?>"
                       data-su-action="admin/applicantAcademicInfo" value="Update">

            </div>
        </div>
    </div>
</form>
</div>


<script>
    //Applicant academic info validation
    $("#applicant_academic_form").validate({

            rules: {

                'EXAM_NAME[1]': {required:true},
                'PASSING_YEAR[1]': {number:true,required:true},
                'BOARD[1]': {required:true},
                'GROUP[1]': {required:true},
                'GPA[1]': {number:true,required:true},
                'GPAWA[1]': {number:true,required:true},
                'INSTITUTE[1]': {required:true},

                'EXAM_NAME[2]': {required:true},
                'PASSING_YEAR[2]': {number:true,required:true},
                'BOARD[2]': {required:true},
                'GROUP[2]': {required:true},
                'GPA[2]': {number:true,required:true},
                'GPAWA[2]': {number:true,required:true},
                'INSTITUTE[2]': {required:true},

                'EXAM_NAME[3]': {required:true},
                'PASSING_YEAR[3]': {number:true,required:true},
                'BOARD[3]': {required:true},
                'GROUP[3]': {required:true},
                'GPA[3]': {number:true,required:true},
                'GPAWA[3]': {number:true,required:true},
                'INSTITUTE[3]': {required:true}
            },
            messages: {

                'EXAM_NAME[1]': "Required",
                'PASSING_YEAR[1]': "Required",
                'BOARD[1]': "Required",
                'GROUP[1]': "Required",
                'GPA[1]': "Required",
                'GPAWA[1]': "Required",
                'INSTITUTE[1]': "Required",

                'EXAM_NAME[2]': "Required",
                'PASSING_YEAR[2]': "Required",
                'BOARD[2]': "Required",
                'GROUP[2]': "Required",
                'GPA[2]': "Required",
                'GPAWA[2]': "Required",
                'INSTITUTE[2]': "Required",

                'EXAM_NAME[3]': "Required",
                'PASSING_YEAR[3]': "Required",
                'BOARD[3]': "Required",
                'GROUP[3]': "Required",
                'GPA[3]': "Required",
                'GPAWA[3]': "Required",
                'INSTITUTE[3]': "Required"
            }
    });


    // Cancel Button

    $('#update_academic_cancel_btn').click(function () {
        var APPLICANT_ID = $("#APPLICANT_ID").attr('applicant-data-id');
        var action_uri = $(this).attr('data-action');
        $.ajax({
            type: 'post',
            url: "<?php echo site_url()?>/" + action_uri,
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

