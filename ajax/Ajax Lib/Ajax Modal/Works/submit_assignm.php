
<div class="" style="margin-top:10px;">
    <div class="ibox float-e-margins">
        <!--<div class="ibox-title">
            <h5>Future Assignments</h5>
            <span class="loadingImg"></span>
        </div>-->

        <form action="" enctype="multipart/form-data" method="post">
            <div class="div-background">
                <div class="row1a">
                   <!-- <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-5 control-label">Select Assignment:<span class="red">*</span></label>
                            <div class="col-md-5">
                                <select name="ASSIGNMENT_ID" id="ASSIGNMENT_ID" data-placeholder="Choose Department" class="chosen-select form-control" tabindex="4">
                                    <option value="" selected disabled>-Select-</option>
                                    <?php /*foreach ($UMS_ASSIGNMENTS as $row2)
                                    {
                                        echo '<option value="'.$row2->ASSIGNMENT_ID.'">'.$row2->ASSIGNMENT_TITLE.'</option>';
                                    }
                                    */?>
                                </select>
                                <span class="red"><?php /*echo form_error('ASSIGNMENT_ID'); */?></span>
                            </div>
                        </div>
                    </div>-->
                    <input type="hidden" name="ASSIGNMENT_ID" id="ASSIGNMENT_ID" value="<?php echo $assignm_id;?>">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-5 control-label">Assignment File: <span class="red">*</span></label>
                            <div class="col-md-7">
                                <input name="ASSIGNMENT_FILE" id="ASSIGNMENT_FILE" type="file" class="form-control">
                                <span class="red"><?php echo form_error('ASSIGNMENT_FILE'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row6">
                    <div class="col-md-12">
                        <hr>
                        <div class="form-group" style="padding-top: 5px;">
                            <span class="modal_msg pull-left"></span>
                            <input type="submit" class="btn btn-primary btn-sm cia_insert" value="Submit">
                            <input type="hidden" class="cia_settings" data-action="<?php echo base_url('student/assignments')?>" data-refresh-id="cia_refresh_area">
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </form>
        <div class="clearfix"></div>
    </div>
</div>
<div class="clearfix"></div>

<div class="" style="margin-top:10px;">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Course Details</h5>
            <span class="loadingImg"></span>
        </div>
        <div class="ibox-content">
            <div class="table-responsive contentArea" id="cia_refresh_area">
                <?php if (!empty($UMS_ASSIGNMENTS_DETAILS)): ?>
                    <table class="table table-striped table-bordered table-hover gridTable">
                        <thead>
                        <tr>
                            <th>SN</th>
                            <th>Course Name</th>
                            <th>Department Name</th>
                            <th>Program Name</th>
                            <th>Batch</th>
                            <th>Session</th>
                            <th>Section</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sn = 1;
                        foreach ($UMS_ASSIGNMENTS_DETAILS as $row):
                            ?>
                            <tr class="gradeX " id="row_<?php echo $row->ASSIGNMENT_ID; ?>">
                                <td><span><?php echo $sn++; ?></span></td>
                                <td><?php echo $row->COURSE_TITLE ?></td>
                                <td><?php echo $row->DEPT_NAME ?></td>
                                <td><?php echo $row->PROGRAM_NAME ?></td>
                                <td><?php echo $row->BATCH_TITLE ?></td>
                                <td><?php echo $row->SESSION_NAME.' - '. $row->DINYEAR; ?></td>
                                <td><?php echo $row->SECTION_NAME ?></td>
                            </tr>
                        <?php
                        endforeach;
                        ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <h3 class="text-danger text-center ">No data found !!</h3>
                <?php endif; ?>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        //to show the active menu function
        $('#navlist li').click(function (e) {
            e.preventDefault(); //prevent the link from being followed
            $('#navlist li').removeClass('active');
            $(this).addClass('active');
        });

        $('#navlist li a').click(function () {
            var teacher_id = $("#USER_ID").attr('teacher-data-id');
            var action_uri = $(this).attr('data-action');
            $.ajax({
                type: 'post',
                url: "<?php echo base_url(); ?>/" + action_uri,
                data: {teacher_id: teacher_id},
                beforeSend: function () {
                    $(".profile-content").html("<img src='<?php echo base_url(); ?>assets/img/loader.gif' />");
                },
                success: function (data) {
                    $('.profile-content').html(data);
                }
            });
        });
    });


    //

</script>