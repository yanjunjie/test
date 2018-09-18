<?php if (1) { ?>

<table class="table table-bordered gridTable"  table-title="Attendance List" table-msg="All Attendance list">
    <thead>
        <tr>
            <th>SN</th>
            <th>Biometric ID</th>
            <th>Log Date</th>
            <th>In time</th>
            <th>Out time</th>
            <th>Machine ID</th>
            <th>Reason</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($attendanceList)): ?>
            <?php $sn = 1; ?>
            <?php foreach ($attendanceList as $row) { ?>
            <tr class="gradeX" id="row_<?php echo $row->ATTENDANCE_ID; ?>">
                <td>
                    <span><?php echo $sn++; ?></span><span class="hidden"
                    id="loader_<?php echo $row->ATTENDANCE_ID; ?>"></span></td>
                    <td><?php echo $row->BIOMETRIC_ID; ?></td>
                    <td><?php echo date('d-m-Y', strtotime($row->LOG_DATE)); ?></td>
                    <td><?php echo $row->IN_TIME; ?></td>
                    <td><?php echo $row->OUT_TIME; ?></td>
                    <td><?php echo $row->MACHINE_ID; ?></td>
                    <td><?php echo $row->REASON; ?></td>
                    <td>
                        <?php if (1) { ?>
                        <a class="label label-default openModal" id="<?php echo $row->ATTENDANCE_ID; ?>"
                            title="Update Attendance Information" data-action="employee/attendanceFormUpdate"
                           data-type="edit"><i class="fa fa-pencil"></i></a>
                           <?php
                       }
                       if (1) {
                        ?>
                        <a class="label label-danger deleteItem" id="<?php echo $row->ATTENDANCE_ID; ?>"
                           title="Click For Delete" data-type="delete" data-field="ATTENDANCE_ID" data-tbl="hr_attendance"><i
                           class="fa fa-times"></i></a>
                           <?php
                       }

                       if (1) {
                        ?>
                       <?php
                   }
                   ?>
               </td>
           </tr>
           <?php } ?>
       <?php endif; ?>
   </tbody>

</table>
<?php
} else {
    echo "<div class='alert alert-danger'>You Don't Have Permission To View This Page</div>";
}
?>