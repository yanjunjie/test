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
    <h5>Institute Information</h5>
    <div class="ibox-tools">
        <span data-action="student/instituteInfo" id="update_institute_cancel_btn" title="Back to previous"
              class="btn btn-success btn-xs pull-right" student-data-id="<?php  echo $student_id; ?>"
              role="button"><i class="fa fa-mail-reply"></i> Back</span>
    </div>
</div>

<div class="ibox-content">
<form id="student_institute_form" class="form-horizontal fContent"  method="post" enctype="multipart/form-data">
    <!--<span type="hidden" name="s_id" value="<?php /*echo $student_id; */?>"></span>-->
    <div class="">
        <div class="div-background">
            <div class="col-md-12">

                <div class="form-group">
                    <label for="ADM_SESSION_ID" class="col-md-5 control-label">Admission Session :</label>
                    <div class="col-md-5">

                        <select id="ADM_SESSION_ID" name="ADM_SESSION_ID" class="form-control">
                            <option value="">-Select-</option>
                            <?php foreach ($session as $row): ?>
                                <option value="<?php  echo $row->YSESSION_ID ?>" <?php echo ($students_info->ADM_SESSION_ID == $row->YSESSION_ID) ? 'selected' : set_value('BLOOD_GRP') ?>><?php echo $row->SESSION_NAME ?></option>
                            <?php  endforeach; ?>
                        </select>

                    </div>
                    <div class="col-md-2">
                        <i class="fa fa-info-circle pointer2" data-content="Select your academic session"
                           data-placement="right" data-toggle="popover" data-container="body"
                           data-original-title="" title="Select your academic session"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="INS_SESSION_ID" class="col-md-5 control-label">Institute Session :</label>
                    <div class="col-md-5">

                        <select id="INS_SESSION_ID" name="INS_SESSION_ID" class="form-control">
                            <option value="">-Select-</option>
                            <?php foreach ($ins_session as $row): ?>
                                <option value="<?php  echo $row->YSESSION_ID ?>" <?php  echo ($students_info->SESSION_ID == $row->YSESSION_ID) ? 'selected' : set_value('BLOOD_GRP') ?>><?php echo $row->SESSION_NAME ?></option>
                            <?php  endforeach; ?>
                        </select>

                    </div>
                    <div class="col-md-2">
                        <i class="fa fa-info-circle pointer2" data-content="Select your institute session"
                           data-placement="right" data-toggle="popover" data-container="body"
                           data-original-title="" title="Select your institute session"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="PROGRAM_ID" class="col-md-5 control-label">Program :</label>
                    <div class="col-md-5">

                        <select id="PROGRAM_ID" name="PROGRAM_ID" class="form-control">
                            <option value="">-Select-</option>
                            <?php foreach ($program as $row): ?>
                                <option value="<?php  echo $row->PROGRAM_ID ?>" <?php echo ($students_info->PROGRAM_ID == $row->PROGRAM_ID) ? 'selected' : set_value('BLOOD_GRP') ?>><?php echo $row->PROGRAM_NAME ?></option>
                            <?php  endforeach; ?>
                        </select>

                    </div>
                    <div class="col-md-2">
                        <i class="fa fa-info-circle pointer2" data-content="Select your program"
                           data-placement="right" data-toggle="popover" data-container="body"
                           data-original-title="" title="Select your program"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="BATCH_ID" class="col-md-5 control-label">Batch :</label>
                    <div class="col-md-5">

                        <select id="BATCH_ID" name="BATCH_ID" class="form-control">
                            <option value="">-Select-</option>
                            <?php foreach ($batch as $row): ?>
                                <option value="<?php  echo $row->BATCH_ID ?>" <?php echo ($students_info->BATCH_ID == $row->BATCH_ID) ? 'selected' : set_value('BLOOD_GRP') ?>><?php echo $row->BATCH_TITLE ?></option>
                            <?php  endforeach; ?>
                        </select>

                    </div>
                    <div class="col-md-2">
                        <i class="fa fa-info-circle pointer2" data-content="Select your batch"
                           data-placement="right" data-toggle="popover" data-container="body"
                           data-original-title="" title="Select your batch"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="SECTION_ID" class="col-md-5 control-label">Section :</label>
                    <div class="col-md-5">

                        <select id="SECTION_ID" name="SECTION_ID" class="form-control">
                            <option value="">-Select-</option>
                            <?php foreach ($section as $row): ?>
                                <option value="<?php echo $row->SECTION_ID ?>" <?php echo ($students_info->SECTION_ID == $row->SECTION_ID) ? 'selected' : set_value('BLOOD_GRP') ?>><?php echo $row->NAME ?></option>
                            <?php endforeach; ?>
                        </select>

                    </div>
                    <div class="col-md-2">
                        <i class="fa fa-info-circle pointer2" data-content="Select your batch"
                           data-placement="right" data-toggle="popover" data-container="body"
                           data-original-title="" title="Select your batch"></i>
                    </div>
                </div>

            </div>

            <div class="clearfix"></div>
        </div>

        <br>
        <div class="form-group">
            <div class="col-md-4  pull-right">
                <input type="button" class="btn btn-primary btn-sm fSubmit pull-right" data-action="student/updateInstituteInfo"
                       data-su-action="student/instituteInfo" data-param="<?php  echo $student_id; ?>" value="Update">
            </div>
        </div>
    </div>
</form>
</div>

<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>

<script>

    $("#student_institute_form").validate({
        rules: {
            ADM_SESSION_ID: {required: true},
            INS_SESSION_ID: {required: true},
            PROGRAM_ID: {required: true},
            BATCH_ID: {required: true},
            SECTION_ID: {required: true}
        },
        messages: {
            ADM_SESSION_ID: "Required field",
            INS_SESSION_ID: "Required field",
            PROGRAM_ID: "Required field",
            BATCH_ID: "Required field",
            SECTION_ID: "Required field"
        }
    });

    // Cancel Button

    $('#update_institute_cancel_btn').click(function () {
        var STUDENT_ID = $(this).attr('student-data-id');
        var action_uri = $(this).attr('data-action');

        $.ajax({
            type: 'post',
            url: "<?php echo site_url(); ?>" + "/" + action_uri + '/' + STUDENT_ID,
            data: {STUDENT_ID: STUDENT_ID},
            beforeSend: function () {
                $(".profile-content").html("<img src='<?php echo base_url(); ?>assets/img/loader.gif' />");
            },
            success: function (data) {
                $('.profile-content').html(data);
            }
        });
    });


</script>


