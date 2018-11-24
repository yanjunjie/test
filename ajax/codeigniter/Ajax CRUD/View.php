<style type="text/css">
    hr {
        margin-bottom: 0px !important;
        margin-top: 10px !important;
    }

    .alert {
        border: 1px solid transparent !important;
        border-radius: 4px !important;
        margin-bottom: 4px !important;
        padding: 6px !important;
    }
</style>
<div class="wrapper wrapper-content">

    <?php $this->load->view("student/common/student_common_js"); ?>

    <div class="panel" style="background:transparent">
        <div class="row1">
            <div class="col-md-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-primary">Excellent</span>
                        <button class="btn btn-primary btn-outline btn-xs pull-right">View Applicants</button>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">386</h1>
                        <div class="stat-percent font-bold text-primary" style="color:#00B294">100% <i class="fa fa-bolt"></i></div>
                        <small>Total Applicants</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-info">Very Good</span>
                        <button class="btn btn-primary btn-outline btn-xs pull-right">View Applicants</button>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">600</h1>
                        <div class="stat-percent font-bold text-info">Greater than 80% <i class="fa fa-level-up"></i></div>
                        <small>Total Applicants</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-warning">Good</span>
                        <button class="btn btn-primary btn-outline btn-xs pull-right">View Applicants</button>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">200</h1>
                        <div class="stat-percent font-bold text-warning">Greater than 70% <i class="fa fa-level-up"></i></div>
                        <small>Total Applicants</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-danger">Average</span>
                        <button class="btn btn-primary btn-outline btn-xs pull-right">View Applicants</button>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">800</h1>
                        <div class="stat-percent font-bold text-danger">Less than 60% <i class="fa fa-level-down"></i></div>
                        <small>Total Applicants</small>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <form id="existing_to_student_form" method="post">
        <div class="ibox float-e-margins">
            <?php if (!empty($existing_student)): ?>
                <div class="ibox-title">
                    <h5>Participant List</h5>
                </div>


<div id="show"></div>

<div class="ibox-content">
    <div class="table-responsive contentArea" id="studentList">
        <table class="table table-striped table-bordered table-hover gridTable">
            <thead>
                <tr>
                    <th>SL</th>
                     
                    <th>NAME</th>
                    <th>MOBILE</th>
                    <th>Email</th>
                     
                    <th class="text-center">ACTION</th>

                </tr>
            </thead>
            <tbody id="approveApplicant" class="searchApplicant">
                <?php
                $sn = 1;
                foreach ($existing_student as $row):
                    ?>
                <tr class="gradeX" id="row_<?php echo $row->STUDENT_ID; ?>">

                    <td><?php echo  $sn++  ?></td>
                    
                     <td>
                        <a class="pull-left student_details" type="button"
                        data-user-id="<?php echo $row->STUDENT_ID ?>" data-toggle="modal"
                        data-target="#applicant_modal">
                        <?php echo $row->FULL_NAME_EN ?>
                    </a>
                </td>

                <td><?php echo $row->MOBILE_NO ?></td>
                <td><?php echo $row->EMAIL_ADRESS ?></td>

                

                <td class="text-center">
                    <a class="label label-default student_details" type="button"
                    data-user-id="<?php echo $row->STUDENT_ID ?>" data-toggle="modal"
                    data-target="#applicant_modal">
                    <i class="fa fa-pencil"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>

</table>
</div>
</form>
</div>
<?php else: ?>
    <div class="alert alert-danger"><p class="text-center">No Student Found </p></div>
<?php endif; ?>
</div>
</form>
</div>
<div class="modal inmodal fade" id="applicant_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">Student Details</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal inmodal appModal">
    <div class="modal-dialog">
        <div class="modal-content animated">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span
                    class="sr-only">Close</span></button>
                <h4 class="modal-title"></h4>
                <small class="font-bold"></small>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-white" type="button">Close</button>
            </div>
        </div>
    </div>
</div>

    <script type="text/javascript">
        $(document).ready(function(){
             
            $("#existing_to_student_form").validate({
                rules: {

                    ADA_SESSION_ID: {required: true},
                    INS_SESSION_ID: {required: true},
                    PROGRAM_ID: {required: true},
                    BATCH_ID: {required: true},
                    SECTION_ID: {required: true},
                    "STUDENT_ID[]": {required: true},

                },
                messages: {
                    ADA_SESSION_ID: "Required",
                    INS_SESSION_ID: "Required",
                    PROGRAM_ID: "Required",
                    BATCH_ID: "Required",
                    SECTION_ID: "Required",
                    "STUDENT_ID[]": "Required one",

                }

            });

            $(".student_details").on("click", function () {
                var STUDENT_ID = $(this).attr('data-user-id');

                $.ajax({
                    type: 'post',
                    url: '<?php echo site_url()?>/student/studentModal',
                    data: {STUDENT_ID: STUDENT_ID},
                    success: function (data) {
                        $("#applicant_modal .modal-body").html(data);
                    }
                });
            });

            $(document).on("click", ".editStudent", function () {
                var student_id = $(this).attr("student-id");

                $.ajax({
                    type: "POST",
                    data: {student_id: student_id},
                    url: "<?php echo site_url() ?>/student/studentDetails",
                    beforeSend: function () {
                    //$(".appModal .modal-title").html("Add Remarks");
                    // $(".appModal .modal-body").html("<img src='<?php echo base_url(); ?>assets/img/loader.gif' />");
                    },
                    success: function (data) {

                    }
                });
            });

            $(document).on("change", "#PROGRAM_ID", function () {

                $("#BATCH_ID").val("");
                var program_id = $(this).val();
                //alert(program_id);
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url() ?>/common/programWiseBatch',
                    data: {program_id: program_id},
                    success: function (data) {
                        $("#BATCH_ID").html(data)
                    }
                });
            });


            $("#checkAll").click(function () {
                $('.STUDENT_ID').prop('checked', this.checked);
            });
        });

    </script>

