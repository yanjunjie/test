<style type="text/css">
    hr{
        margin-bottom:0px !important ;
        margin-top:10px !important;
    }
    .form-control, .chosen-container, .control-label{
        margin-bottom: 10px;
    }
    .red{
        color: red;
    }
</style>

<form action="" enctype="multipart/form-data" method="post">
    <div class="ibox-content">
        <div class="div-background">
            <div class="row1a">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-5 control-label">Assignment Title: <span class="red">*</span></label>
                        <div class="col-md-7">
                            <input value="<?php echo $UMS_ASSIGNMENTS_BY_ID->ASSIGNMENT_TITLE; ?>" required="required" name="ASSIGNMENT_TITLE" id="ASSIGNMENT_TITLE" type="text" placeholder="ASSIGNMENT TITLE" class="form-control">
                            <span class="red"><?php echo form_error('ASSIGNMENT_TITLE'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-group">
                            <label class="col-md-5 control-label">Assignment Description: <span class="red">*</span></label>
                            <div class="col-md-7">
                                <input value="<?php echo $UMS_ASSIGNMENTS_BY_ID->DESCRIPTION; ?>" required="required" name="DESCRIPTION" id="DESCRIPTION" type="text" placeholder="ASSIGNMENT Description" class="form-control">
                                <span class="red"><?php echo form_error('DESCRIPTION'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row1">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-5 control-label">Department:<span class="red">*</span></label>
                        <div class="col-md-5">
                            <span id="DEPT_ID_DEPEN">
                                 <select name="DEPT_ID" id="DEPT_ID" data-placeholder="Choose Department" class="chosen-select form-control" tabindex="4">
                                    <option value="" selected disabled>-Select-</option>
                                     <?php foreach ($INS_DEPT as $row2) {

                                         if( $row2->DEPT_ID == $UMS_ASSIGNMENTS_BY_ID->DEPT_ID ) //Saved value == $row[$i]
                                         {?>
                                             <option selected value="<?php echo $row2->DEPT_ID ?>" ><?php echo $row2->DEPT_NAME ?></option>
                                             <?php
                                         }
                                         ?>

                                        <option value="<?php echo $row2->DEPT_ID ?>"><?php echo $row2->DEPT_NAME ?></option>
                                         <?php
                                     }
                                     ?>
                                </select>
                            </span>
                            <span class="red"><?php echo form_error('DEPT_ID'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-5 control-label">Session:</label>
                        <div class="col-md-5">
                            <select name="YSESSION_ID" id="YSESSION_ID" data-placeholder="Choose Session" class="chosen-select form-control" tabindex="4">
                                <option value="" selected disabled>-Select-</option>
                                <?php foreach ($ADM_YSESSION as $row2) {
                                    if( $row2->YSESSION_ID == $UMS_ASSIGNMENTS_BY_ID->SESSION_ID ) //$row[$i] == Saved value
                                    {?>
                                        <option selected value="<?php echo $row2->YSESSION_ID ?>" ><?php echo $row2->SESSION_NAME ?></option>
                                        <?php
                                    }
                                    ?>
                                    <option value="<?php echo $row2->YSESSION_ID ?>"><?php echo $row2->SESSION_NAME ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="red"><?php echo form_error('YSESSION_ID'); ?></span>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="row2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-5 control-label">Program: <span class="red">*</span></label>

                        <div class="col-md-5">
                            <span id="PROGRAM_ID_DEPEN">
                                <select name="PROGRAM_ID" id="PROGRAM_ID" data-placeholder="Choose Program" class="chosen-select form-control" tabindex="4">
                                    <option value="" selected disabled>-Select-</option>
                                    <?php foreach ($INS_PROGRAM as $row2) {
                                        if( $row2->PROGRAM_ID == $UMS_ASSIGNMENTS_BY_ID->PROGRAM_ID ) //$row[$i] == Saved value
                                        {?>
                                            <option selected value="<?php echo $row2->PROGRAM_ID ?>" ><?php echo $row2->PROGRAM_NAME ?></option>
                                            <?php
                                        }
                                        ?>
                                        <option value="<?php echo $row2->PROGRAM_ID ?>"><?php echo $row2->PROGRAM_NAME ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </span>
                            <span class="red"><?php echo form_error('PROGRAM_ID'); ?></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-5 control-label">Batch:</label>

                        <div class="col-md-5">
                            <span id="BATCH_ID_DEPEN">
                                <select name="BATCH_ID" id="BATCH_ID" data-placeholder="Choose Batch" class="chosen-select form-control" tabindex="4">
                                    <option value="" selected disabled>-Select-</option>
                                    <?php foreach ($ACA_BATCH as $row2) {
                                        if( $row2->BATCH_ID == $UMS_ASSIGNMENTS_BY_ID->BATCH_ID ) //$row[$i] == Saved value
                                        {?>
                                            <option selected value="<?php echo $row2->BATCH_ID ?>" ><?php echo $row2->BATCH_TITLE ?></option>
                                            <?php
                                        }
                                        ?>
                                        <option value="<?php echo $row2->BATCH_ID ?>"><?php echo $row2->BATCH_TITLE ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </span>
                            <span class="red"><?php echo form_error('BATCH_ID'); ?></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-5 control-label">Section:<span class="red">*</span></label>
                        <div class="col-md-5">
                            <select name="SECTION_ID" id="SECTION_ID" data-placeholder="Choose Section" class="chosen-select form-control" tabindex="4">
                                <option value="" selected disabled>-Select-</option>
                                <?php foreach ($ACA_SECTION as $row2) {
                                    if( $row2->SECTION_ID == $UMS_ASSIGNMENTS_BY_ID->SECTION_ID ) //$row[$i] == Saved value
                                    {?>
                                        <option selected value="<?php echo $row2->SECTION_ID ?>" ><?php echo $row2->NAME ?></option>
                                        <?php
                                    }
                                    ?>
                                    <option value="<?php echo $row2->SECTION_ID ?>"><?php echo $row2->NAME ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="red"><?php echo form_error('SECTION_ID'); ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-5 control-label">Course ID:</label>
                        <div class="col-md-5">
                            <select name="COURSE_ID" id="COURSE_ID" data-placeholder="Choose Course" class="chosen-select form-control" tabindex="4">
                                <option value="" selected disabled>-Select-</option>
                                <?php foreach ($ACA_COURSE as $row2) {
                                    if( $row2->COURSE_ID == $UMS_ASSIGNMENTS_BY_ID->COURSE_ID ) //$row[$i] == Saved value
                                    {?>
                                        <option selected value="<?php echo $row2->COURSE_ID ?>" ><?php echo $row2->COURSE_TITLE ?></option>
                                        <?php
                                    }
                                    ?>
                                    <option value="<?php echo $row2->COURSE_ID ?>"><?php echo $row2->COURSE_TITLE ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="red"><?php echo form_error('COURSE_ID'); ?></span>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row5" style="margin-top: 10px;">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>
                            <input name="ACTIVE_STATUS" type="checkbox"  value="Y" checked="checked"> Active?
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-5 control-label">Submission Date:<span class="red">*</span></label>
                        <div class="col-md-5">
                            <div class='input-group date date_picker'>
                                <input required="required" value="<?php echo date('d/m/Y', strtotime($UMS_ASSIGNMENTS_BY_ID->SUBMISSION_DT)); ?>" name="SUBMISSION_DT" id="SUBMISSION_DT" type='text' placeholder="Submission Date" class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                            <span class="red"><?php echo form_error('SUBMISSION_DT'); ?></span>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="row6">
                <div class="col-md-12">
                    <hr>
                    <div class="form-group" style="padding-top: 5px;">
                        <span class="modal_msg pull-left"></span>
                        <input type="submit" class="btn btn-primary btn-sm" value="Update">
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</form>

<div class="clearfix"></div>


<script>
    $(function () {
        $('.date_picker').datetimepicker({
            format: 'DD/MM/YYYY'
        });
        $('.time_picker').datetimepicker({
            format: 'LT'
            //format: 'HH:mm:ss'
        });

    });

    //Ajax Delete by ID
    window.onload = function() {
        $(document).on('click','.delete',function(e){
            e.preventDefault();
            e.stopPropagation();
            var id = $(this).attr('data-id');
            var url = '<?php echo base_url("assignment/ajax_delete"); ?>';

            if (confirm('Are you sure to delete?')) {
                $.ajax({
                    type:'post',
                    url:url,
                    data:{table:"UMS_ASSIGNMENTS",attr:"ASSIGNMENT_ID",id:id},
                    success:function(data){
                        if (data=='yes') {
                            alert("Deleted successfully");
                            $("#assignment_list").load(location.href + " #assignment_list");
                            //location.reload();
                        }
                    },
                    error:function(){
                        alert('Error deleting');
                    }
                });
            }
        });
        //End Delete
    }
    //End Window Load

</script>