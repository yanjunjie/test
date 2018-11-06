    
<form action="" method="post" enctype="multipart/form-data">
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
                        <input value="<?php echo (isset($row['STDNT_IN_TIME']) && ($row['IS_ATTEND']=='Y'))?date('G:i:s', strtotime($row['STDNT_IN_TIME'])):''; ?>" name="STDNT_IN_TIME[<?php echo $row['STUDENT_ID']; ?>]" type='text' class="form-control" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                </td>
                <td>
                    <div class='input-group date time_picker'>
                        <input value="<?php echo (isset($row['STDNT_OUT_TIME']) && ($row['IS_ATTEND']=='Y'))?date('G:i:s', strtotime($row['STDNT_OUT_TIME'])):''; ?>" name="STDNT_OUT_TIME[<?php echo $row['STUDENT_ID']; ?>]" type='text' class="form-control" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                </td>
                <td>
                    <input <?php echo $row['IS_ATTEND']=='Y'?'checked':''; ?> name="STUDENT_ID[]" value="<?php echo $row['STUDENT_ID']; ?>" type="checkbox" class="chkRow">
                    <input type="hidden" name="CHECKED_STUDENT_ID[]" value="<?php echo $row['IS_ATTEND']=='Y'?$row['STUDENT_ID']:''; ?>" >
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

<button type="submit">Submit</button>
</form>