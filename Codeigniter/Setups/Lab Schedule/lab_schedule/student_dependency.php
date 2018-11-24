<style>
    .match_row{}
    .match_row td{
        background: rgba(255, 0, 0, 0.17);
    }
</style>

    <?php if(!empty($result)): ?>
        <table class="table table-striped table-bordered table-hover gridTable" style="width: auto;">
            <thead>
            <tr>
                <th><input type="checkbox" id="chkAll"></th>
                <th>Student Name</th>
                <th>Registration No</th>
                <th>ID No</th>
                <th>Mobile No</th>
                <th>Degree</th>
                <th>Dept</th>
                <th>Program Name</th>
                <th>Batch Name</th>
                <th>Faculty Name</th>
            </tr>
            </thead>
            <tbody>
            <?php
                    foreach ($result as $row):
                    if ($row['IS_EXIST'] > 0):
                    ?>
                        <tr class="gradeX match_row" id="row_<?php echo $row['STUDENT_ID']; ?>">
                            <td><input name="STUDENT_ID_EXIST[]" value="<?php echo $row['STUDENT_ID']; ?>" type="checkbox" class="chkRow"></td>
                            <td><?php echo $row['FULL_NAME_EN'] ?></td>
                            <td><?php echo $row['REGISTRATION_NO'] ?></td>
                            <td><?php echo $row['STUDENT_ID'] ?></td>
                            <td><?php echo $row['MOBILE_NO'] ?></td>
                            <td><?php echo $row['DEGREE_NAME'] ?></td>
                            <td><?php echo $row['DEPT_NAME'] ?></td>
                            <td><?php echo $row['PROGRAM_NAME'] ?></td>
                            <td><?php echo $row['BATCH_TITLE'] ?></td>
                            <td><?php echo $row['FACULTY_NAME'] ?></td>
                        </tr>
                    <?php else: ?>
                        <tr class="gradeX" id="row_<?php echo $row['STUDENT_ID']; ?>">
                            <td><input name="STUDENT_ID[]" value="<?php echo $row['STUDENT_ID']; ?>" type="checkbox" class="chkRow"></td>
                            <td><?php echo $row['FULL_NAME_EN'] ?></td>
                            <td><?php echo $row['REGISTRATION_NO'] ?></td>
                            <td><?php echo $row['STUDENT_ID'] ?></td>
                            <td><?php echo $row['MOBILE_NO'] ?></td>
                            <td><?php echo $row['DEGREE_NAME'] ?></td>
                            <td><?php echo $row['DEPT_NAME'] ?></td>
                            <td><?php echo $row['PROGRAM_NAME'] ?></td>
                            <td><?php echo $row['BATCH_TITLE'] ?></td>
                            <td><?php echo $row['FACULTY_NAME'] ?></td>
                        </tr>
                    <?php
                    endif;
                    endforeach;
                    ?>
            </tbody>
        </table>
    <?php else: ?>
        <h3 class="text-danger text-center ">No data found !!</h3>
    <?php endif; ?>


    <script type="text/javascript">
        $(function () {
            $("#chkAll").click(function () {
                //Determine the reference CheckBox in Header row.
                var chkAll = this;

                //Fetch all row CheckBoxes in the Table.
                var chkRows = $(".gridTable").find(".chkRow");

                //checked status of Header row CheckBox.
                chkRows.each(function () {
                    $(this)[0].checked = chkAll.checked;
                });
            });

            $(".chkRow").click(function () {
                //Determine the reference CheckBox in Header row.
                var chkAll = $("#chkAll");

                //By default set to Checked.
                chkAll.attr("checked", "checked");

                //Fetch all row CheckBoxes in the Table.
                var chkRows = $(".gridTable").find(".chkRow");

                //is unchecked then Uncheck the Header CheckBox.
                chkRows.each(function () {
                    if (!$(this).is(":checked")) {
                        chkAll.removeAttr("checked", "checked");
                        return;
                    }
                });
            });
        });
    </script>
