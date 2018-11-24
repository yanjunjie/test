<style>
    .ScrollStyle
    {
        max-height: 300px;
        overflow-y: scroll;
    }
</style>

<div class="table-responsive contentArea">
    <?php if(!empty($registered_student)) : ?>
        <div class="ScrollStyle">
            <table class="table table-striped table-bordered table-hover gridTable">
                <thead>
                <tr>
                    <th><input class="ch" type="checkbox" id="checkAll"></th>
                    <th class="col-md-4">Registration No</th>
                    <th class="col-md-4">Name</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($registered_student)): $sn = 1; ?>
                    <?php foreach ($registered_student as $row) { ?>
                        <tr class="gradeX" id=" ">

                            <td><input value="<?php echo $row->STUDENT_ID ?>" type="checkbox"
                                       name="STUDENT_ID[]" class="STUDENT_ID ch"></td>
                            <td><?php echo $row->REGISTRATION_NO ?></td>
                            <td><?php echo $row->FULL_NAME_EN ?></td>
                            <td class="text-center">
                                 
                                <a class="label label-info openBigModal" id="1" data-action='finance/fresherStudentPayment/<?php echo  $row->STUDENT_ID.'/'.$row->SESSION_ID.'/'.$row->PROGRAM_ID;?>' data-type="edit" title="Fresher Student Bill details"><i class="fa fa-eye"></i> 
                            </a>
                                 
                            </td>
                        </tr>
                    <?php } ?>
                <?php endif; ?>

                </tbody>


            </table>
        </div>
        <div class="form-group">
            <input type="button" class="btn btn-danger btn-sm fSubmit " id="academic_bill_generate_btn"
                   data-param="" value="Generate Bill"
                   data-action="finance/saveAcademicBill"
                   data-su-action="finance/academicBillingListOfStudent" data-view-div="acd_bill_view">
        </div>

    <?php else: ?>
        <div class="alert alert-danger"><p class="text-center">No Student Found </p></div>
    <?php endif; ?>

</div>

<script>

    $("#checkAll").click(function () {
        $('.STUDENT_ID').prop('checked', this.checked);
    });

</script>


