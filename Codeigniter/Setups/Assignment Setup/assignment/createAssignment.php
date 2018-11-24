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
                            <input required="required" name="ASSIGNMENT_TITLE" id="ASSIGNMENT_TITLE" type="text" placeholder="ASSIGNMENT TITLE" class="form-control">
                            <span class="red"><?php echo form_error('ASSIGNMENT_TITLE'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-group">
                            <label class="col-md-5 control-label">Assignment Description: <span class="red">*</span></label>
                            <div class="col-md-7">
                                <input required="required" name="DESCRIPTION" id="DESCRIPTION" type="text" placeholder="ASSIGNMENT Description" class="form-control">
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
                                     <?php foreach($INS_DEPT as $ky=>$row2) {?>
                                         <option value="<?php echo $row2->DEPT_ID; ?>" <?php echo  set_select("DEPT_ID", "$row2->DEPT_ID"); ?> ><?php echo $row2->DEPT_NAME; ?></option>
                                     <?php } ?>
                                </select>
                            </span>
                            <span class="red"><?php echo form_error('DEPT_ID'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="DESCRIPTION" class="col-md-5 control-label">Session:</label>
                        <div class="col-md-5">
                            <select name="YSESSION_ID" id="YSESSION_ID" data-placeholder="Choose Session" class="chosen-select form-control" tabindex="4">
                                <option value="" selected disabled>-Select-</option>
                                <?php foreach($ADM_YSESSION as $ky=>$row2) {?>
                                    <option value="<?php echo $row2->YSESSION_ID; ?>" <?php echo  set_select("YSESSION_ID", "$row2->YSESSION_ID"); ?> ><?php echo $row2->SESSION_NAME." - ".$row2->DINYEAR; ?></option>
                                <?php } ?>
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
                                    <?php foreach($INS_PROGRAM as $ky=>$row2) {?>
                                        <option value="<?php echo $row2->PROGRAM_ID; ?>" <?php echo  set_select("PROGRAM_ID", "$row2->PROGRAM_ID"); ?> ><?php echo $row2->PROGRAM_NAME; ?></option>
                                    <?php } ?>
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
                                    <?php foreach($ACA_BATCH as $ky=>$row2) {?>
                                        <option value="<?php echo $row2->BATCH_ID; ?>" <?php echo  set_select("BATCH_ID", "$row2->BATCH_ID"); ?> ><?php echo $row2->BATCH_TITLE; ?></option>
                                    <?php } ?>
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
                                <?php foreach($ACA_SECTION as $ky=>$row) {?>
                                    <option value="<?php echo $row->SECTION_ID; ?>" <?php echo  set_select("SECTION_ID", "$row->SECTION_ID"); ?> ><?php echo $row->NAME; ?></option>
                                <?php } ?>
                            </select>
                            <span class="red"><?php echo form_error('SECTION_ID'); ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="DESCRIPTION" class="col-md-5 control-label">Course ID:</label>
                        <div class="col-md-5">
                            <select name="COURSE_ID" id="COURSE_ID" data-placeholder="Choose Course" class="chosen-select form-control" tabindex="4">
                                <option value="" selected disabled>-Select-</option>
                                <?php foreach($ACA_COURSE as $ky=>$row2) {?>
                                    <option value="<?php echo $row2->COURSE_ID; ?>" <?php echo  set_select("COURSE_ID", "$row2->COURSE_ID"); ?> ><?php echo $row2->COURSE_TITLE ?></option>
                                <?php } ?>
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
                                <input required="required" value="<?php echo  set_value("SUBMISSION_DT"); ?>" name="SUBMISSION_DT" id="SUBMISSION_DT" type='text' placeholder="Submission Date" class="form-control" />
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
                        <input type="submit" class="btn btn-primary btn-sm afs" value="Submit">
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</form>

<div class="clearfix"></div>

<div class="" style="margin-top:10px;">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>View All Laboratories</h5>
            <span class="loadingImg"></span>
        </div>
        <div class="ibox-content">
            <div class="table-responsive contentArea" id="assignment_list">
                <?php if (!empty($UMS_ASSIGNMENTS)): ?>
                    <table class="table table-striped table-bordered table-hover gridTable">
                        <thead>
                        <tr>
                            <th>SN</th>
                            <th>Assignment Title</th>
                            <th>Assignment Description</th>
                            <th>Submission Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sn = 1;
                        foreach ($UMS_ASSIGNMENTS as $row):
                            ?>
                            <tr class="gradeX" id="row_<?php echo $row->ASSIGNMENT_ID; ?>">
                                <td><span><?php echo $sn++; ?></span></td>
                                <td><?php echo $row->ASSIGNMENT_TITLE ?></td>
                                <td><?php echo $row->DESCRIPTION ?></td>
                                <td><?php echo date('d/m/Y', strtotime($row->SUBMISSION_DT)); ?></td>
                                <td>
                                    <a class="label label-success" href="<?php echo site_url('assignment/createAssignmentUpdate/' . $row->ASSIGNMENT_ID); ?>" title="Click For Edit">Edit</a>
                                    <a class="label label-danger delete" data-id="<?php echo $row->ASSIGNMENT_ID; ?>" href="<?php echo site_url('lab_setup'); ?>" title="Click For Delete">Delete</a>
                                </td>
                            </tr>
                        <?php
                        endforeach;
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>SN</th>
                            <th>Assignment Name</th>
                            <th>Assignment Description</th>
                            <th>Submission Date</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                    </table>
                <?php else: ?>
                    <h3 class="text-danger text-center ">No data found !!</h3>
                <?php endif; ?>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

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

    //Ajax Form Submission
    $(document).on("click", ".afs", function (e) {
        e.preventDefault();
        e.stopPropagation();
        //Submit Button
        var thisBtn = $(this);
        //Form
        var thisForm = thisBtn.closest("form");
        //Form Data
        var formData = new FormData(thisForm[0]);
        //Form Action
        var dataAction = thisBtn.attr("data-action");
        dataAction = dataAction?dataAction:'';

        //First check 'form action' otherwise check 'data action'
        var formAction = thisForm.attr('action');
        var action = formAction?formAction:(dataAction?dataAction:'');

        $.ajax({
            type: "POST",
            url: action,
            data: formData,
            processData: false,
            contentType: false,
            success:function(data){
                if(data=='yes')
                {
                    alert('Success! Data inserted successfully');
                    $("#assignment_list").load(location.href + " #assignment_list");
                    //$("#find_gen_sdl").trigger("click");
                }
                else if(data=='no')
                {
                    alert('Error! Data not inserted successfully')
                }
                else
                {
                    alert('Error! Try again');
                }
            }
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