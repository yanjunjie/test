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
            <div class="row1">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-5 control-label">Faculty: <span class="red">*</span></label>
                        <div class="col-md-5">
                            <select name="FACULTY_ID" id="FACULTY_ID" data-placeholder="Choose Faculty" class="chosen-select form-control" tabindex="4">
                                <option value="" selected disabled>-Select-</option>
                                <?php foreach($INS_FACULTY as $ky=>$row2) {?>
                                    <option value="<?php echo $row2->FACULTY_ID; ?>" <?php echo  set_select("FACULTY_ID", "$row2->FACULTY_ID"); ?> ><?php echo $row2->FACULTY_NAME; ?></option>
                                <?php } ?>
                            </select>
                            <span class="red"><?php echo form_error('FACULTY_ID'); ?></span>
                        </div>
                    </div>

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
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label id="LAB_ID" class="col-md-5 control-label">Degree:<span class="red">*</span></label>
                        <div class="col-md-5">
                            <span id="DEGREE_ID_DEPEN">
                                <select name="DEGREE_ID" id="DEGREE_ID" data-placeholder="Choose Degree" class="chosen-select form-control" tabindex="4">
                                <option value="" selected disabled>-Select-</option>
                                    <?php foreach($INS_DEGREE as $ky=>$row) {?>
                                        <option value="<?php echo $row->DEGREE_ID; ?>" <?php echo  set_select("DEGREE_ID", "$row->DEGREE_ID"); ?> ><?php echo $row->DEGREE_NAME; ?></option>
                                    <?php } ?>
                            </select>
                            </span>
                            <span class="red"><?php echo form_error('DEGREE_ID'); ?></span>
                        </div>
                    </div>

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
                        <label class="col-md-5 control-label">Room No:<span class="red">*</span></label>
                        <div class="col-md-5">
                            <select name="ROOM_NO" id="ROOM_NO" data-placeholder="Choose Room" class="chosen-select form-control" tabindex="4">
                                <option value="" selected disabled>-Select-</option>
                                <?php foreach($SA_ROOM as $ky=>$row2) {?>
                                    <option value="<?php echo $row2->ROOM_ID; ?>" <?php echo set_select("ROOM_NO","$row2->ROOM_NO"); ?> ><?php echo $row2->ROOM_NAME; ?></option>
                                <?php } ?>
                            </select>
                            <span class="red"><?php echo form_error('ROOM_NO'); ?></span>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="row4" style="margin-top: 10px;">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-5 control-label">Experiment:<span class="red">*</span></label>
                        <div class="col-md-5">
                            <select name="EXP_ID" id="EXP_ID" data-placeholder="Choose Experiment" class="chosen-select form-control" tabindex="4">
                                <option value="" selected disabled>-Select-</option>
                                <?php foreach($UM_LAB_EXPERIMENT as $ky=>$row2) {?>
                                    <option value="<?php echo $row2->EXP_ID; ?>" <?php echo  set_select("EXP_ID", "$row2->EXP_ID"); ?> ><?php echo $row2->EXP_NAME; ?></option>
                                <?php } ?>
                            </select>
                            <span class="red"><?php echo form_error('EXP_ID'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-5 control-label">Schedule Date:<span class="red">*</span></label>
                        <div class="col-md-5">
                            <div class='input-group date date_picker'>
                                <input required="required" value="<?php echo  set_value("SDL_DT"); ?>" name="SDL_DT" id="SDL_DT" type='text' class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                            <span class="red"><?php echo form_error('SDL_DT'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row5" style="margin-top: 10px;">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>
                            <input name="ACTIVE_STATUS" type="checkbox"  value="Y" checked="checked"> Active?
                        </label>
                    </div>
                </div>
            </div>
            <div class="row6">
                <div class="col-md-12">
                    <hr>
                    <div class="form-group" style="padding-top: 5px;">
                        <span class="modal_msg pull-left"></span>
                        <!--                        <input type="submit" class="btn btn-primary btn-sm" value="Submit">-->
                        <button id="find_gen_sdl" type="button" class="btn btn-primary btn-sm">Find Students</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="" style="margin-top:10px;">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>View All Student</h5>
                <span class="loadingImg"></span>
            </div>
            <div class="ibox-content">
                <div class="table-responsive contentArea" id="student_list">

                </div>
                <div class="row1" id="submit_gen_sdl_sec" style="display: none">
                    <div class="col-md-12">
                        <hr>
                        <div class="form-group" style="padding: 5px;">
                            <span class="modal_msg pull-left"></span>
                            <input id="submit_gen_sdl" type="submit" class="btn btn-primary btn-sm" value="Submit">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</form>


<script type="text/javascript">
    $(function () {
        $('.date_picker').datetimepicker({
            format: 'DD/MM/YYYY'
        });
        $('.time_picker').datetimepicker({
            format: 'LT'
            //format: 'HH:mm:ss'
        });

    });

    //Program Dependency List //One to Many
    $(document).on("change", "#FACULTY_ID", function () {
        var FACULTY_ID = $(this).val();
        $.ajax({

            type: "POST",
            url: "<?=base_url();?>lab_schedule/ajax_find_view",
            data:  {table:'INS_PROGRAM',attr:'FACULTY_ID', attr_val:FACULTY_ID, url_data:'', view:'admin/lab_schedule/program_dependency'},
            success:function(data){
                if(data != "no"){
                    $('#PROGRAM_ID_DEPEN').html(data);
                }
                else
                {
                    console.log('No data found');
                }
            }
        });
    });

    //Degree Dependency List  //Many to One
    $(document).on("change", "#PROGRAM_ID", function () {
        var PROGRAM_ID = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?=base_url();?>lab_schedule/ajax_find_view_by_detail_id",
            data:  {master_table:'INS_DEGREE', detail_table:'INS_PROGRAM', attr_master:'DEGREE_ID',  attr_detail:'DEGREE_ID', attr_detail_val:PROGRAM_ID, view:'admin/lab_schedule/degree_dependency'},
            success:function(data){
                if(data != "no" && data != "err")
                {
                    $('#DEGREE_ID_DEPEN').html(data);
                }
                else if(data == "err")
                {
                    $('#DEGREE_ID_DEPEN').html('<b class="text-danger text-center ">No data found!</b>');
                }
                else
                {
                    console.log('No data found');
                }
            }
        });
    });

    //Department Dependency List  //Many to One
    $(document).on("change", "#PROGRAM_ID", function () {
        var PROGRAM_ID = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?=base_url();?>lab_schedule/ajax_find_view_by_detail_id",
            data:  {master_table:'INS_DEPT', detail_table:'INS_PROGRAM', attr_master:'DEPT_ID',  attr_detail:'DEPT_ID', attr_detail_val:PROGRAM_ID, view:'admin/lab_schedule/dept_dependency'},
            success:function(data){
                if(data != "no" && data != "err")
                {
                    $('#DEPT_ID_DEPEN').html(data);
                }
                else if(data == "err")
                {
                    $('#DEPT_ID_DEPEN').html('<b class="text-danger text-center ">No data found!</b>');
                }
                else
                {
                    console.log('No data found');
                }
            }
        });
    });

    //Batch Dependency List  //One to Many and Many to One
    $(document).on("change", "#PROGRAM_ID", function () {
        var PROGRAM_ID = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?=base_url();?>lab_schedule/ajax_find_view_by_map",
            data:  {master_table1:'INS_PROGRAM', attr_master1_val:PROGRAM_ID, master_table2:'ACA_BATCH', attr_master2:'BATCH_ID', detail_table:'ACA_BATCH_PROG', attr_detail:'PROGRAM_ID', view:'admin/lab_schedule/batch_dependency'},
            success:function(data){
                if(data != "no" && data != "err")
                {
                    $('#BATCH_ID_DEPEN').html(data);
                }
                else if(data == "err")
                {
                    $('#BATCH_ID_DEPEN').html('<b class="text-danger text-center ">No data found!</b>');
                }
                else
                {
                    console.log('No data found');
                }
            }
        });
    });

    //Student Dependency List
    $(document).on("click","#find_gen_sdl", function () {

        var YSESSION_ID = $('#YSESSION_ID').val();
        if(!YSESSION_ID)
        {
            alert('Please select Session');
            return false;
        }
        var DEGREE_ID = $('#DEGREE_ID').val();
        if(!DEGREE_ID)
        {
            alert('Please select Degree');
            return false;
        }
        var FACULTY_ID = $('#FACULTY_ID').val();
        if(!FACULTY_ID)
        {
            alert('Please select Faculty');
            return false;
        }
        var DEPT_ID = $('#DEPT_ID').val();
        if(!DEPT_ID)
        {
            alert('Please select Depertment');
            return false;
        }
        var PROGRAM_ID = $('#PROGRAM_ID').val();
        if(!PROGRAM_ID)
        {
            alert('Please select Program');
            return false;
        }
        var BATCH_ID = $('#BATCH_ID').val();
        if(!BATCH_ID)
        {
            alert('Please select Batch');
            return false;
        }
        var SECTION_ID = $('#SECTION_ID').val();
        if(!SECTION_ID)
        {
            alert('Please select Section');
            return false;
        }
        var SDL_DT = $('#SDL_DT').val();
        if(!SDL_DT)
        {
            alert('Please select Schedule Date');
            return false;
        }
        var EXP_ID = $('#EXP_ID').val();

        if(!EXP_ID)
        {
            alert('Please select Experiment');
            return false;
        }

        var url_data = {EXP_ID:EXP_ID,YSESSION_ID:YSESSION_ID, DEGREE_ID:DEGREE_ID, FACULTY_ID:FACULTY_ID, DEPT_ID:DEPT_ID, PROGRAM_ID:PROGRAM_ID, BATCH_ID:BATCH_ID, SECTION_ID:SECTION_ID, SDL_DT:SDL_DT};

        $.ajax({

            type: "POST",
            url: "<?=base_url();?>lab_schedule/ajax_lab_atten_view",
            data: url_data,
            success:function(data){
                if(data != "no" && data !="not_found")
                {
                    $('#student_list').html(data);
                    $('#submit_gen_sdl_sec').show();
                }
                else
                {
                    $('#student_list').html('<h3 class="text-danger text-center ">No data found !!</h3>');
                    $('#submit_gen_sdl_sec').hide();
                }
            }
        });

    });

    //Ajax Submit form
    $(document).on("click", "#submit_gen_sdl", function (e) {
        e.preventDefault();
        e.stopPropagation();
        $.ajax({
            type: "POST",
            url: "<?=base_url();?>lab_schedule/lab_attendees",
            data: $('form').serializeArray(),
            success:function(data){
                if(data=='yes')
                {
                    alert('Success! Data inserted successfully');
                    //$("#student_list").load(location.href + " #student_list");
                    $("#find_gen_sdl").trigger("click");
                }
                else if(data=='err')
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


</script>
