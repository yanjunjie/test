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
            <th width="20%">Student Name</th>
            <th width="7%">ID No</th>
            <th width="15%">Dept</th>
            <th width="20%">Program Name</th>
            <th width="5%">Schedule Date</th>
            <th width="15%">In Time</th>
            <th width="15%">Out Time</th>
            <th width="3%"><label><input type="checkbox" id="chkAll"> Is Attend?</label></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($result as $row): ?>
            <tr class="gradeX" id="row_<?php echo $row['STUDENT_ID']; ?>">
                <td><?php echo $row['FULL_NAME_EN'] ?></td>
                <td><?php echo $row['STUDENT_ID'] ?></td>
                <td><?php echo $row['DEPT_NAME'] ?></td>
                <td><?php echo $row['PROGRAM_NAME'] ?></td>
                <td><?php echo date('d/m/Y', strtotime($row['SDL_DT'])) ?></td>
                <td>
                    <div class='input-group date time_picker'>
                        <input value="<?php echo isset($row['STDNT_IN_TIME'])?date('G:i:s', strtotime($row['STDNT_IN_TIME'])):''; ?>" name="STDNT_IN_TIME[<?php echo $row['STUDENT_ID']; ?>]" type='text' class="form-control" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                </td>
                <td>
                    <div class='input-group date time_picker'>
                        <input value="<?php echo isset($row['STDNT_OUT_TIME'])?date('G:i:s', strtotime($row['STDNT_OUT_TIME'])):''; ?>" name="STDNT_OUT_TIME[<?php echo $row['STUDENT_ID']; ?>]" type='text' class="form-control" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                </td>
                <td><input <?php echo $row['IS_ATTEND']=='Y'?'checked':''; ?> name="STUDENT_ID[]" value="<?php echo $row['STUDENT_ID']; ?>" type="checkbox" class="chkRow"></td>
            </tr>
        <?php
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

    $(function () {
        $('.date_picker').datetimepicker({
            format: 'DD/MM/YYYY'
        });
        $('.time_picker').datetimepicker({
            format: 'LT'
            //format: 'HH:mm:ss'
        });
    });
</script>