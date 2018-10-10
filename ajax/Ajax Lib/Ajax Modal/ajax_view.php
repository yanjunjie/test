<div>
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
