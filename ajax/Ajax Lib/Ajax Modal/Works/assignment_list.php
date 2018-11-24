<?php //$this->load->view("student/common/student_common_js"); ?>

<style>
    .danger td,.danger th{
        background: rgba(210, 92, 105, 0.5);
    }
    .success td,.success th{
        background: rgba(144, 193, 162, 0.5);
    }
</style>

<div class="" style="margin-top:10px;">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Future Assignments</h5>
            <span class="loadingImg"></span>
        </div>
        <div class="ibox-content">
            <div class="table-responsive contentArea" id="cia_refresh_area">
                <?php if (!empty($UMS_ASSIGNMENTS_FUTURE)): ?>
                    <table class="table table-striped table-bordered table-hover gridTable">
                        <thead>
                        <tr>
                            <th>SN</th>
                            <th>Assignment Title</th>
                            <th>Assignment File</th>
                            <th>Course</th>
                            <th>Sumission Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sn = 1;
                        foreach ($UMS_ASSIGNMENTS_FUTURE as $row):
                            ?>
                            <tr class="gradeX " id="row_<?php echo $row->ASSIGNMENT_ID; ?>">
                                <td><span><?php echo $sn++; ?></span></td>
                                <td><?php echo $row->ASSIGNMENT_TITLE ?></td>
                                <td><a target="_blank" href="<?php echo isset($row->ASSIGNMENT_FILE)?base_url('upload/assignments/').$row->ASSIGNMENT_FILE:'' ?>"> <?php echo isset($row->SUBMITTED_AT)?'Download':'Not Available'; ?></a></td>
                                <td><?php echo $row->COURSE_TITLE ?></td>
                                <td><?php echo date('d/m/Y',strtotime($row->SUBMISSION_DT)) ?></td>
                                <td><?php echo isset($row->SUBMITTED_AT)?"Submitted on: ".date('d/m/Y',strtotime($row->SUBMITTED_AT)):'Pending'; ?></td>
                                <td class="text-center">
                                    <a class="btn btn-primary btn-xs submit_assignm"
                                       data-assignm-id="<?php echo $row->ASSIGNMENT_ID; ?>"
                                       type="button"
                                       data-toggle="modal" data-target="#assignm_modal">
                                        View
                                    </a>
                                </td>
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

<div class="" style="margin-top:10px;">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Previous Assignments</h5>
            <span class="loadingImg"></span>
        </div>
        <div class="ibox-content">
            <div class="table-responsive contentArea" id="laboratoryList">
                <?php if (!empty($UMS_ASSIGNMENTS_PREVIOUS)): ?>
                    <table class="table table-striped table-bordered table-hover gridTable">
                        <thead>
                        <tr>
                            <th>SN</th>
                            <th>Assignment Title</th>
                            <th>Description</th>
                            <th>Sumission Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sn = 1;
                        foreach ($UMS_ASSIGNMENTS_PREVIOUS as $row):
                            ?>
                            <tr class="gradeX" id="row_<?php echo $row->ASSIGNMENT_ID; ?>">
                                <td><span><?php echo $sn++; ?></span></td>
                                <td><?php echo $row->ASSIGNMENT_TITLE ?></td>
                                <td><?php echo $row->DESCRIPTION ?></td>
                                <td><?php echo date('d/m/Y',strtotime($row->SUBMISSION_DT)) ?></td>
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

<!--Modal-->
<div class="modal fade" id="assignm_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">Assignment Upload</h4>
            </div>
            <div class="modal-body"></div>

            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--End Modal-->

<script>

    //Ajax Form Submission/Insertion
    $(document).on("click", ".cia_insert", function (e) {
        e.preventDefault();
        e.stopPropagation();
        //Submit Button
        let thisBtn = $(this);
        //Form
        let thisForm = thisBtn.closest("form");
        /*
            Settings:
            1. Action, 2. Form Data, 3. Refresh Area (After Inserting, Updating, and Deleting Data, Refresh a part of the page)
            For Example:
            <input type="hidden" class="cia_settings" data-action="" data-refresh-id="cia_refresh_area">
         */
        let cia_settings = thisForm.find(".cia_settings");
        //Form Action
        let dataAction = cia_settings.attr("data-action");
        let formAction = thisForm.attr('action');
        //First check 'data action' otherwise check 'form action'
        let action = dataAction?dataAction:(formAction?formAction:'');
        if(!action)
        {
            console.log("Please set the data-action or form-action");
            return false;
        }

        //Form Data
        let formData = new FormData(thisForm[0]);
        if(!formData)
        {
            alert("No Form Data Found!");
            return false;
        }

        //Refresh Area
        let dataRefreshId= cia_settings.attr("data-refresh-id");
        refreshArea = dataRefreshId?dataRefreshId:(refreshArea?refreshArea:'');
        if(!refreshArea)
        {
            console.log("Please set the data-refresh-id");
            return false;
        }

        $.ajax({
            type: "POST",
            url: action,
            data: formData,
            processData: false,
            contentType: false,
            success:function(data){
                if($.trim(data)=='yes')
                {
                    alert('Success! Data inserted successfully');
                    $("#"+refreshArea).load(location.href + " #"+refreshArea);
                }
                else if($.trim(data)=='no')
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


    //Assignment Modal
    $(".submit_assignm").on("click", function () {
        var assignm_id = $(this).attr('data-assignm-id');
        $.ajax({
            type: 'post',
            url: '<?php echo base_url(); ?>student/assignment_modal',
            data: {assignm_id: assignm_id},
            success: function (data) {
                $("#assignm_modal .modal-body").html(data);
            }
        });
    });


</script>