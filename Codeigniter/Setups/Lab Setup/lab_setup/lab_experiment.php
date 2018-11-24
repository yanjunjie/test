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
                        <input required="required" type="text" name="EXP_NAME" id="EXP_NAME" value="<?php echo set_value('EXP_NAME'); ?>" class="form-control" placeholder="Experiment Name">
                        <span class="red"><?php echo form_error('EXP_NAME'); ?></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="DESCRIPTION" class="col-md-5 control-label">Experiment Description:</label>

                    <div class="col-md-5">
                        <input type="text" name="DESCRIPTION" id="DESCRIPTION" value="<?php echo set_value('DESCRIPTION'); ?>" class="form-control" placeholder="Experiment Description">
                        <span class="red"></span>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label id="LAB_ID" class="col-md-5 control-label">Laboratories:<span class="red">*</span></label>
                    <div class="col-md-5">
                        <select required="required" name="LAB_ID[]" id="LAB_ID" data-placeholder="Choose Laboratories" class="chosen-select form-control" multiple tabindex="4">
                            <?php foreach($UM_LABRATORIES as $ky=>$row) {?>
                                <option value="<?php echo $row->LAB_ID; ?>" <?php echo  set_select("LAB_ID[]", "$row->LAB_ID"); ?> ><?php echo $row->LAB_NAME; ?></option>
                            <?php } ?>
                        </select>
                        <span class="red"><?php echo form_error('LAB_ID[]'); ?></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="EMP_NO" class="col-md-5 control-label">Supervisors:<span class="red">*</span></label>
                    <div class="col-md-5">
                        <select required="required" name="EMP_NO[]" id="EMP_NO" data-placeholder="Choose Supervisors" class="chosen-select form-control" multiple tabindex="4">
                            <?php foreach($HR_EMPLOYEE as $ky=>$row2) {?>
                                <option value="<?php echo $row2->EMP_NO; ?>" <?php echo  set_select("EMP_NO[]", "$row2->EMP_NO"); ?> ><?php echo $row2->EMP_NAME; ?></option>
                            <?php } ?>
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
                <input type="submit" class="btn btn-primary btn-sm" value="Submit">
            </div>
        </div>
	</div>
    </form>

    <div class="clearfix"></div>
</div>

<div class="" style="margin-top:10px;">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>View All Experiment</h5>
            <span class="loadingImg"></span>
        </div>
        <div class="ibox-content">
            <div class="table-responsive contentArea" id="experiment_list">
                <?php if (!empty($UM_LAB_EXPERIMENT)): ?>
                    <table class="table table-striped table-bordered table-hover gridTable">
                        <thead>
                        <tr>
                            <th>SN</th>
                            <th>Experiment Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sn = 1;
                        foreach ($UM_LAB_EXPERIMENT as $row):
                            ?>
                            <tr class="gradeX" id="row_<?php echo $row->EXP_ID; ?>">
                                <td><span><?php echo $sn++; ?></span></td>
                                <td><?php echo $row->EXP_NAME ?></td>
                                <td>
                                    <a class="label label-success" href="<?php echo site_url('lab_setup/lab_experiment_edit/' . $row->EXP_ID); ?>" title="Click For Edit">Edit</a>
                                    <a class="label label-danger delete" href="<?php echo site_url('lab_setup/lab_experiment_delete/' . $row->EXP_ID); ?>" title="Click For Delete">Delete</a>
                                </td>
                            </tr>
                        <?php
                        endforeach;
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>SN</th>
                            <th>Experiment Name</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                    </table>
                <?php else: ?>
                    <h3 class="text-danger text-center ">No data found !!</h3>
                <?php endif; ?>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
