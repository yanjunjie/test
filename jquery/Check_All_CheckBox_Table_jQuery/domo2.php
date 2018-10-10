<?php if(empty($applicant)){ echo "Sorry no applicant found !";}else{ ?>

<form class="fContent" id="applicant_to_student_form" method="post">
    <input type="hidden" name="ADM_SES" value="<?php echo $adm_ses; ?>">
    <div class="wrapper wrapper-content">
        <div class="col-md-6">
            <div class="form-group">
                <select class="select2Dropdown form-control required" name="BATCH_ID" id="BATCH_ID" data-tags="true" data-placeholder="Select Batch" data-allow-clear="true">
                    <option value="">--- Select Batch ---</option>
                    <?php foreach ($batch as $row) { ?>
                    <option
                    value="<?php echo $row->BATCH_ID; ?>"><?php echo $row->BATCH_TITLE; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <select class="select2Dropdown form-control required" name="SECTION_ID" id="SECTION_ID" data-tags="true" data-placeholder="Select Section" data-allow-clear="true">
                    <option value="">--- Select Section ---</option>
                    <?php foreach ($section as $row) { ?>
                    <option
                    value="<?php echo $row->SECTION_ID; ?>"><?php echo $row->NAME; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <input type="button" class="btn btn-warning btn-sm fSubmit" id="applicant_to_student_btn" value="Proceed" data-action="admin/applicant_to_student"
                data-su-action="admin/loadAdmissionStudentList">
            </div>
        </div>
        <br>

        <div class="table-responsive contentArea" id="applicantList">
            <table class="table table-striped table-bordered table-hover gridTable">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="checkAll"></th>
                        <th>Roll</th>
                        <th>Name</th>
                        <th>Session</th>
                        <th>Department</th>
                        <th>Program</th>
                        <th>Mobile No.</th>
                    </tr>
                </thead>
                <tbody id="approveApplicant" class="searchApplicant">
                    <?php
                    $sn = 1;
                    foreach ($applicant as $row):
                        ?>
                    <tr class="gradeX" id="row_<?php echo $row->APPLICANT_ID; ?>" >

                        <td><input value="<?php echo $row->APPLICANT_ID  ?>" type="checkbox" name="APPLICANT_ID[]" class="APPLICANT_ID"></td>
                        <td ><?php echo $row->ADM_ROLL_NO ?></td>
                        <td >
                            <a class="pull-left applicant_details"    type="button"
                            data-user-id="<?php echo $row->APPLICANT_ID ?>" data-toggle="modal"
                            data-target="#applicant_modal">
                            <?php echo $row->FULL_NAME_EN ?>
                        </a>
                    </td>
                    <td><?php echo $this->utilities->admissionSessionById($row->ADM_SESSION_ID)->SESSION_NAME ?></td>
                    <td>
                        <?php echo $row->DEPT_NAME ?>
                    </td>
                    <td><?php echo $row->PROGRAM_NAME ?></td>
                    <td><?php echo $row->MOBILE_NO ?></td>
                </tr>
            <?php  endforeach;  ?>
        </tbody>
    </table>
</div>
</div>

</form>

<script>
    $("#checkAll").click(function () {
        $('.APPLICANT_ID').prop('checked', this.checked);
    });

    $("#checkAll").click(function () {
        $('.APPLICANT_ID').prop('checked', this.checked);
    });    

    $("#applicant_to_student_form").validate({
            rules: {

           BATCH_ID: {required:true}, 
           SECTION_ID: {required:true}, 
          "APPLICANT_ID[]": { required: true, minlength: 1 } 
       },
       messages: {  
           BATCH_ID: "Required",
           SECTION_ID: "Required",
           "APPLICANT_ID[]": "Required",
       },
   });

    $(document).ready(function () {
        $(".gridTable").dataTable();
    });

</script>
<?php } ?>
