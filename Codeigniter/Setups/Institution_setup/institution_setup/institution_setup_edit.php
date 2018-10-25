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
            <div class="row1">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-5 control-label">Institute Name: <span class="red">*</span></label>

                        <div class="col-md-5">
                            <input type="text" required="required" name="INSTITUTE_NAME" id="INSTITUTE_NAME" value="<?php echo $UM_INSTITUTIONS->INSTITUTE_NAME; ?>" class="form-control" placeholder="Institution Name">
                            <span class="red"><?php echo form_error('INSTITUTE_NAME'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="SHORT_NAME" class="col-md-5 control-label">Institute Short Name:</label>

                        <div class="col-md-5">
                            <input type="text" name="SHORT_NAME" id="SHORT_NAME" value="<?php echo $UM_INSTITUTIONS->SHORT_NAME; ?>" class="form-control" placeholder="Institution Description">
                            <span class="red"><?php echo form_error('SHORT_NAME'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row2">
                <div class="col-md-6">
                    <label>
                        <input name="ACTIVE_STATUS"  type="checkbox"  value="Y" checked="checked"> Active?
                    </label>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="SHORT_NAME" class="col-md-5 control-label">Institute Type:</label>
                        <div class="col-md-5">
                            <select required="required" name="INS_TYPE"  id="INS_TYPE" class="select2 form-control">
                                <option></option>
                                <?php
                                    if($UM_INSTITUTIONS->INS_TYPE == "R" )
                                    {?>
                                        <option selected value="R" >Referral</option>
                                    <?php
                                    }
                                    else
                                    { ?>
                                        <option value="R" >Referral</option>
                                    <?php }

                                    if($UM_INSTITUTIONS->INS_TYPE == "A" )
                                    {?>
                                        <option selected value="A">Admitted</option>
                                    <?php
                                    }
                                    else
                                    { ?>
                                        <option value="A">Admitted</option>
                                    <?php }
                                ?>
                            </select>
                            <span class="red"><?php echo form_error('INS_TYPE'); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <hr>
                <div class="form-group" style="padding-top: 5px;">
                    <span class="modal_msg pull-left"></span>
                    <input type="submit" class="btn btn-primary btn-sm" value="Update">
                </div>
            </div>
        </div>
    </form>
    <div class="clearfix"></div>
</div>

<script>

    //Delete confirmation
    window.onload = function() {
        $('.delete').on('click', function () {
            if (confirm("Are you sure to delete!") == true) {
                return true;
            } else {
                return false;
            }
        });

        $(".select2").select2({
            placeholder: "Select Institute Type",
            allowClear: true
        });
    }
    //End Window Load
</script>