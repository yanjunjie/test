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
                            <input type="text" required="required" name="INSTITUTE_NAME" id="INSTITUTE_NAME" value="<?php echo set_value('INSTITUTE_NAME'); ?>" class="form-control" placeholder="Institution Name">
                            <span class="red"><?php echo form_error('INSTITUTE_NAME'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="SHORT_NAME" class="col-md-5 control-label">Institute Short Name:</label>

                        <div class="col-md-5">
                            <input type="text" name="SHORT_NAME" id="SHORT_NAME" value="<?php echo set_value('SHORT_NAME'); ?>" class="form-control" placeholder="Institution Description">
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
                                <option value="R" <?php echo  set_select("INS_TYPE", "R"); ?>>Referral</option>
                                <option value="A" <?php echo  set_select("INS_TYPE", "A"); ?>>Admitted</option>
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
            <h5>View All Laboratories</h5>
            <span class="loadingImg"></span>
        </div>
        <div class="ibox-content">
            <div class="table-responsive contentArea" id="instituteList">
                <?php if (!empty($UM_INSTITUTIONS)): ?>
                    <table class="table table-striped table-bordered table-hover gridTable">
                        <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Institution Name</th>
                            <th>Institution Short Name</th>
                            <th>Institution Type</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sn = 1;
                        foreach ($UM_INSTITUTIONS as $row):
                            ?>
                            <tr class="gradeX" id="row_<?php echo $row->INSTITUTE_ID; ?>">
                                <td><span><?php echo $sn++; ?></span></td>
                                <td><?php echo $row->INSTITUTE_NAME ?></td>
                                <td><?php echo $row->SHORT_NAME ?></td>
                                <td><?php echo ($row->INS_TYPE=='R')?'Referral':(($row->INS_TYPE=='A')?'Admitted':'');?></td>
                                <td>
                                    <a class="label label-success" href="<?php echo site_url('setup/institution_setup_edit/' . $row->INSTITUTE_ID); ?>" title="Click For Edit">Edit</a>
                                    <a class="label label-danger delete" data-id="<?php echo $row->INSTITUTE_ID; ?>" href="<?php echo site_url('setup/institution_setup'); ?>" title="Click For Delete">Delete</a>
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
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<script>

    //Delete confirmation
    window.onload = function() {
        $(document).on('click','.delete',function(e){
            e.preventDefault();
            e.stopPropagation();
            var INSTITUTE_ID = $(this).attr('data-id');
            var url = '<?php echo base_url("setup/ajax_delete"); ?>';

            if (confirm('Are you sure to delete?')) {
                $.ajax({
                    type:'post',
                    url:url,
                    data:{table:"UM_INSTITUTIONS",attr:"INSTITUTE_ID",id:INSTITUTE_ID},
                    success:function(data){
                        if (data=='yes') {
                            alert("Deleted successfully");
                            $("#instituteList").load(location.href + " #instituteList");
                            //location.reload();
                        }
                    },
                    error:function(){
                        alert('Error deleting');
                    }
                });
            }
        });

        $(".select2").select2({
            placeholder: "Select Institute Type",
            allowClear: true
        });

    }
    //End Window Load

</script>