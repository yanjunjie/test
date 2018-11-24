<style type="text/css">
    hr{
        margin-bottom:0px !important ;
        margin-top:11px !important;
    }
    .form-control, .chosen-container, .control-label{
        margin-bottom: 11px;
    }
    .red{
        color: red;
    }
</style>
<form enctype="multipart/form-data" method="post">
    <div class="ibox-content">
        <div class="div-background">
            <div class="row1a">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-5 control-label">Title: <span class="red">*</span></label>
                        <div class="col-md-5">
                            <input name="TITLE" id="TITLE" type="text" placeholder="Title" class="form-control">
                            <span class="red"><?php echo form_error('TITLE'); ?></span>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-5 control-label">Exam Year:<span class="red">*</span></label>
                        <div class="col-md-5">
                            <select name="EXAM_YEAR" id="EXAM_YEAR" data-placeholder="Choose Program" tabindex="4" class="chosen-select form-control ">
                                <option value="">Select Year</option>
                                <?php
                                foreach($yearInfo as $key=>$value)
                                {
                                    ?>
                                    <option value="<?php echo $value;?>">
                                        <?php echo $value; ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="red"><?php echo form_error('EXAM_YEAR'); ?></span>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!--Start Academic Selection-->
            <div class="row1">
                <div class="col-md-6">

                    <div class="form-group">
                        <label class="col-md-5 control-label">Program: <span class="red">*</span></label>
                        <div class="col-md-5">
                            <select name="PROGRAM_ID" id="PROGRAM_ID" data-placeholder="Choose Program" tabindex="4" class=" chosen-select form-control
                                    cia_dependency_by_join_two_tbl"
                                    data-table="INS_PROGRAM"
                                    data-table2="ACA_COURSE"
                                    data-attr="PROGRAM_ID"
                                    data-attr2="DEPT_ID"
                                    data-action="<?php echo base_url('assignment/cia_dependency_by_join_two_tbl')?>"
                                    data-view="admin/assignment/course_dependency"
                                    data-reload-id="COURSE_ID">
                                <option value="">Select Program</option>
                                <?php
                                foreach($program as $row)
                                {
                                    ?>
                                    <option value="<?php echo $row->PROGRAM_ID;?>">
                                        <?php echo $row->PROGRAM_NAME ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="red"><?php echo form_error('PROGRAM_ID'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-5 control-label">Session: <span class="red">*</span></label>
                        <div class="col-md-5">
                            <select name="SESSION_ID" id="SESSION_ID" data-placeholder="Choose Session" tabindex="4" class=" chosen-select form-control">
                                <option value="">Select Session</option>
                                <?php
                                foreach($ins_session as $row)
                                {
                                    ?>
                                    <option value="<?php echo $row->SESSION_ID;?>">
                                        <?php echo $row->SESSION_NAME ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="red"><?php echo form_error('SESSION_ID'); ?></span>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="row3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-5 control-label">Semester: <span class="red">*</span></label>
                        <div class="col-md-5">
                            <select name="SEMESTER_NO" id="SEMESTER_NO" data-placeholder="Choose Semester" class="chosen-select form-control " tabindex="4">
                                <option value="">Select Semester</option>
                                <?php
                                foreach($semesterInfo as $key=>$value)
                                {
                                    ?>
                                    <option value="<?php echo $key;?>">
                                        <?php echo $value; ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="red"><?php echo form_error('SEMESTER_NO'); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!--End Academic Selection-->
            <div class="row4">
                <div class="col-md-12">
                    <hr>
                    <div class="form-group" style="padding-top: 5px;">
                        <span class="pull-left"></span>
                        <button type="button" class="btn btn-success btn-sm find_courses">
                            Find Courses
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="courses_area">

        </div>

        <div class="clearfix"></div>
        <div class="row4">
            <div class="col-md-12">
                <hr>
                <div class="form-group" style="padding-top: 5px;">
                    <span class="modal_msg pull-left"></span>
                    <button style="display: none;" type="submit" class="submit_button btn btn-primary btn-sm formnovalidate cia_insert"
                            data-action="<?php echo base_url('exam/generate_exam_schedule_post')?>"
                            data-refresh-id="cia_reload_area"
                            data-reload="1">
                        Submit
                    </button>
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


    //Find courses
    $(document).on("click", ".find_courses", function (e) {
        e.preventDefault();
        e.stopPropagation();

        var TITLE = $('#TITLE').val();
        if(!TITLE)
        {
            alert('Please enter title');
            return false;
        }

        var EXAM_YEAR = $('#EXAM_YEAR').val();
        if(!EXAM_YEAR)
        {
            alert('Please select exam year');
            return false;
        }

        var PROGRAM_ID = $('#PROGRAM_ID').val();
        if(!PROGRAM_ID)
        {
            alert('Please select program');
            return false;
        }

        var SESSION_ID = $('#SESSION_ID').val();
        if(!SESSION_ID)
        {
            alert('Please select session');
            return false;
        }

        var SEMESTER_NO = $('#SEMESTER_NO').val();
        if(!SEMESTER_NO)
        {
            alert('Please select semester');
            return false;
        }


        let thisForm = $(this).closest('form');

        //Form Data
        let formData = new FormData();
        formData.append('PROGRAM_ID', $("#PROGRAM_ID").val());
        formData.append('SEMESTER_NO', $("#SEMESTER_NO").val());
        formData.append('SESSION_ID', $("#SESSION_ID").val());
        formData.append('EXAM_YEAR', $("#EXAM_YEAR").val());

        $.ajax({
            type: "POST",
            url: '<?php echo base_url()?>exam/generate_exam_schedule',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $('.courses_area').html(data);
                $('.submit_button').show();
            },
            error: function (jqXHR, exception) {
                getJqXhrError(jqXHR, exception);
            }
        });

    });

    //Ajax Form Submission/Insertion
    $(document).on("click", ".cia_insert", function (e) {
        e.preventDefault();
        e.stopPropagation();
        /*
            ### This Ajax Form Submission is made by Bablu Ahmed
            ### For debugging, check erro message in browser console
            *** Dynamic Settings:
                1. i.Form Action, ii. Refresh Area OR iii. Window Reload (If set '1' or 'true' the #ii will not work)
                    i.e,
                    <button type="submit" class="btn btn-primary btn-sm cia_insert"
                        data-action="<--?php echo base_url('student/assignments')?>"
                        data-reload-id="cia_reload_area"
                        data-reload="1">
                        Submit
                    </button>
                2. Add a class called 'cia_insert' to submit button
                3. Remove 'action' attribute from form
            *** Default Settings:
        */
        let actionD = "";
        let windowReloadD = "";
        //End Default Settings

        //Submit Button
        let thisBtn = $(this);
        //Form
        let thisForm = thisBtn.closest("form");
        //Form Action
        let dataAction = thisBtn.attr("data-action");
        //let formAction = thisForm.attr('action');

        //First check 'data-action' otherwise check default action 'actionD'
        let url = dataAction?dataAction:(actionD?actionD:'');
        if(!url)
        {
            console.log("Please set the data-action or default action");
        }

        //Form Data
        let formData = new FormData(thisForm[0]);
        if(!formData)
        {
            console.log("No Form Data Found!");
        }

        //Refresh Area
        reloadArea = thisBtn.attr("data-reload-id");  //i.e, cia_reload_area
        if(!reloadArea)
        {
            console.log("Please set the 'data-reload-id'");
        }

        //After Inserting, Updating, and Deleting Data, Refresh the Data View Area
        let reloadAreaExists = $('#cia_reload_area').length;
        if(!reloadAreaExists)
        {
            console.log("Please set 'cia_reload_area' id on the Data View Area");
        }


        //Window Reload
        windowReload = thisBtn.attr("data-reload"); //Boolean Value, i.e, 0 or 1
        if(windowReload)
        {
            console.log("Window will be reloaded");
        }

        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function(){
                cia_jq_validation(thisForm);
                if(!thisForm.valid())
                {
                    return false;
                }
            },
            success:function(data){
                if($.trim(data)=='yes')
                {
                    alert('Success! Record inserted successfully');
                    if(!windowReload)
                        $("#"+reloadArea).load(location.href + " #"+reloadArea);
                    else
                        location.reload();
                }
                else if($.trim(data)=='no')
                {
                    alert('Error! Record not inserted successfully')
                }
                else
                {
                    alert('Error! Required field is missing. Please try again');
                }
            }
        });
    });


    //Jquery Validation
    function cia_jq_validation(thisForm) {
        $.validator.setDefaults({ ignore: ":hidden:not(select)" }); //for all hidden select elements
        /*
            ### This Form Validation is made by Bablu Ahmed
            ### This is based on Jquery Validation Plugin, https://jqueryvalidation.org
            ### For debugging, check erro message in browser console

            *** Dynamic Settings:
                1. For required only i.e,
                    <input type='text' name='bablu' class='cia_required'>
                2. To upload valid file formats i.e,
                    <input name="myfile" type="file" class="form-control cia_required_file" data-file-type="jpg png jpeg">

            *** Default Settings:
            */
        let fileTypeD = '';
        //End Default Settings

        //Attributes:
        let cia_required_elements = thisForm.find('.cia_required');
        let cia_required_file_elements = thisForm.find('.cia_required_file');

        //Rules:
        let cia_validation_rules = {};
        let cia_validation_msgs = {};

        //Validate only for Required Fields
        cia_required_elements.each(function(index, element) {
            let nameAttr = $(this).attr('name');
            cia_validation_rules[nameAttr]={required: true};
        });

        //Validate Required File Types
        cia_required_file_elements.each(function(index, element) {
            let nameAttr = $(this).attr('name');
            let dataFileType = $(this).attr('data-file-type');
            let fileType = dataFileType?dataFileType:fileTypeD;
            let fileTypeArr = fileType.split(/[\s,|]+/);
            let fileTypeStr = fileTypeArr.join('|');
            //Set Required Formats
            cia_validation_rules[nameAttr]={
                required: true,
                extension: fileTypeStr
            };
            //Set Messages
            cia_validation_msgs[nameAttr]= {
                extension: "Please upload a valid file. Allowed types are "+fileTypeStr
            }
        });

        //Call Validate Function to execute rules and messages
        thisForm.validate({
            rules: cia_validation_rules,
            messages: cia_validation_msgs,
            errorPlacement: function (error, element) {
                //check whether chosen plugin is initialized for the element
                if (element.data().chosen) { //or if (element.next().hasClass('chosen-container')) {
                    element.next().after(error);
                } else {
                    element.after(error);
                }
            }
        });

    }


</script>