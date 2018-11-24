<div class="block-flat">
    <form class="form-horizontal frmContent" id="accessory" method="post">
        <?php
        if ($ac_type == 2) {
            ?>
            <input type="hidden" class="rowID" name="txtaccessoryId" value="<?php echo $accessory->BR_ACCESSORY_ID ?>"/>
        <?php
        }
        ?>
        <span class="frmMsg"></span>

        <div class="form-group">
            <label class="col-lg-2 control-label">Name<span class="text-danger">*</span></label>

            <div class="col-lg-8">
                <input type="text" id="accessoryName" name="accessoryName" class="form-control required"
                       value="<?php echo ($ac_type == 2) ? $accessory->ACCESSORY_NAME : ''; ?>"
                       placeholder="Accessory Name">
                <span class="validation"></span>
                <span class="help-block m-b-none">Example:- Building, White Board.</span>
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group">
            <label class="col-lg-2 control-label"><span>Description</span></label>

            <div class="col-lg-8">
                <textarea class="redactor"
                          name="description"><?php echo ($ac_type == 2) ? $accessory->ACCESSORY_DESC : ''; ?></textarea>
                <span class="validation"></span>
                <span class="help-block m-b-none">Example:- Building description.</span>
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group"><label class="col-lg-2 control-label">Active?</label>

            <div class="col-lg-10">
                <?php
                $ACTIVE_STATUS = ($ac_type == 2) ? $accessory->ACTIVE_STATUS : '';
                $checked = ($ac_type == 2) ? (($accessory->ACTIVE_STATUS == '1') ? TRUE : FALSE) : '';
                ?>
                <label class="control-label">
                    <?php
                    $data = array(
                        'name' => 'status',
                        'id' => 'status',
                        'class' => 'checkBoxStatus',
                        'value' => $ACTIVE_STATUS,
                        'checked' => $checked,
                    );
                    echo form_checkbox($data);
                    ?>
                </label>
                <span class="help-block m-b-none">click on checkbox for active status.</span>
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
                <?php if ($ac_type == 2) { ?>
                    <input type="button" class="btn btn-primary btn-sm formSubmit" data-action="setup/updateAccessories"
                           data-su-action="setup/accessoriesById" value="Update">
                <?php } else { ?>
                    <input type="button" class="btn btn-primary btn-sm formSubmit" data-action="setup/createAccessories"
                           data-su-action="setup/accessoriesList" data-type="list" value="Submit">
                <?php
                }
                ?>
                <input type="reset" class="btn btn-default btn-sm" value="Reset">
                <span class="loadingImg"></span>
            </div>
        </div>

    </form>
</div>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/redactor/redactor.css"/>
<script src="<?php echo base_url(); ?>assets/redactor/redactor.min.js"></script>
<script type="text/javascript">
    $(document).ready(
        function () {
            $('.redactor').redactor();
        }
    );
</script>
<script>
    $(document).on('click', '.checkBoxStatus', function () {
        var status = ($(this).is(':checked')) ? 1 : 0;
        $("#status").val(status);
    });
</script>