<style type="text/css">
    hr{
        margin-bottom:0px !important ;
        margin-top:10px !important;
    }
    .form-control, .chosen-container, .control-label{
        margin-bottom: 10px;
    }
    .red{
        color: red;
    }
</style>
<div class="ibox-content">
    <form action="" enctype="multipart/form-data" method="post">

        <div class="div-background">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-5 control-label">Experiment Name: <span class="red">*</span></label>

                    <div class="col-md-5">
                        <input type="text" name="EXP_NAME" id="EXP_NAME" value="<?php echo $UM_LAB_EXPERIMENT[0]->EXP_NAME; ?>" class="form-control" placeholder="Experiment Name">
                        <span class="red"><?php echo form_error('EXP_NAME'); ?></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="DESCRIPTION" class="col-md-5 control-label">Experiment Description:</label>

                    <div class="col-md-5">
                        <input type="text" name="DESCRIPTION" id="DESCRIPTION" value="<?php  echo $UM_LAB_EXPERIMENT[0]->DESCRIPTION; ?>" class="form-control" placeholder="Experiment Description">
                        <span class="red"></span>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-5 control-label">Laboratories:<span class="red">*</span></label>
                    <div class="col-md-5">
                        <select name="LAB_ID[]" id="LAB_ID" data-placeholder="Choose Laboratories" class="chosen-select form-control" multiple tabindex="4">

                            <?php foreach ($UM_LABRATORIES as $row) {

                                foreach ($UM_LABRATORIES_S as $sub_row)
                                {
                                    if( $row->LAB_ID == $sub_row->LAB_ID ) //Saved value == $row[$i]
                                    {?>

                                    <option selected value="<?php echo $sub_row->LAB_ID ?>" ><?php echo $sub_row->LAB_NAME ?></option>

                                <?php } }?>

                                <option value="<?php echo $row->LAB_ID ?>"><?php echo $row->LAB_NAME ?></option>
                                <?php
                            }
                            ?>

                        </select>
                        <span class="red"><?php echo form_error('LAB_ID[]'); ?></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="EMP_NO" class="col-md-5 control-label">Supervisors:<span class="red">*</span></label>
                    <div class="col-md-5">
                        <select name="EMP_NO[]" id="EMP_NO" data-placeholder="Choose Supervisors" class="chosen-select form-control" multiple tabindex="4">

                            <?php foreach ($HR_EMPLOYEE as $row2) {

                                foreach ($HR_EMPLOYEE_S as $sub_row2){
                                    if( $row2->EMP_NO == $sub_row2->EMP_NO ) //Saved value == $row[$i]
                                    {?>
                                        <option selected value="<?php echo $sub_row2->EMP_NO ?>" ><?php echo $sub_row2->EMP_NAME ?></option>
                                    <?php
                                    }
                                }
                                ?>

                                <option value="<?php echo $row2->EMP_NO ?>"><?php echo $row2->EMP_NAME ?></option>
                                <?php
                            }
                            ?>

                        </select>
                        <span class="red"><?php echo form_error('EMP_NO[]'); ?></span>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="col-md-12">
                <label>
                    <input name="ACTIVE_STATUS"  type="checkbox"  value="Y" checked="checked"> Active?
                </label>
            </div>

            <div class="col-md-12">
                <hr>
                <div class="form-group" style="padding-top: 5px;">
                    <span class="modal_msg pull-left"></span>
                    <input type="submit" class="btn btn-primary btn-sm" value="Update">
                </div>
            </div>

    </form>

    <div class="clearfix"></div>
</div>

<script>
    //Datatable Refresh
    //$('.dataTables').DataTable().ajax.reload();

    //Delete confirmation
    window.onload = function() {
        $('.delete').on('click', function () {
            if (confirm("Are you sure to delete!") == true) {
                return true;
            } else {
                return false;
            }
        });
    }
</script>