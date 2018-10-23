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
                    <label class="col-md-5 control-label">Laboratory Name: <span class="red">*</span></label>

                    <div class="col-md-5">
                        <input type="text" required="required" name="LAB_NAME" id="LAB_NAME" value="<?php echo set_value('LAB_NAME'); ?>" class="form-control" placeholder="Laboratory Name">
                        <span class="red"><?php echo form_error('LAB_NAME'); ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="LAB_DESC" class="col-md-5 control-label">Laboratory Description:</label>

                    <div class="col-md-5">
                        <input type="text" name="LAB_DESC" id="LAB_DESC" value="<?php echo set_value('LAB_DESC'); ?>" class="form-control" placeholder="Laboratory Description">
                        <span class="red"><span class="red"><?php echo form_error('LAB_DESC'); ?></span></span>
                    </div>
                </div>
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
            <div class="table-responsive contentArea" id="laboratoryList">
                <?php if (!empty($UM_LABRATORIES)): ?>
                    <table class="table table-striped table-bordered table-hover gridTable">
                        <thead>
                        <tr>
                            <th>SN</th>
                            <th>Laboratory Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sn = 1;
                        foreach ($UM_LABRATORIES as $row):
                            ?>
                            <tr class="gradeX" id="row_<?php echo $row->LAB_ID; ?>">
                                <td><span><?php echo $sn++; ?></span></td>
                                <td><?php echo $row->LAB_NAME ?></td>
                                <td>
                                    <a class="label label-success" href="<?php echo site_url('lab_setup/lab_setup_edit/' . $row->LAB_ID); ?>" title="Click For Edit">Edit</a>
                                    <a class="label label-danger delete" data-id="<?php echo $row->LAB_ID; ?>" href="<?php echo site_url('lab_setup'); ?>" title="Click For Delete">Delete</a>
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

<script>

    //Delete confirmation
    window.onload = function() {

        $('.delete').on('click',function(e){
            e.preventDefault();
            e.stopPropagation();
            var LAB_ID = $(this).data('id');
            var url = '<?php echo base_url("lab_setup/ajax_delete"); ?>';

            if (confirm('Are you sure to delete?')) {
                $.ajax({
                    type:'post',
                    url:url,
                    data:{table:"UM_LABRATORIES",attr:"LAB_ID",id:LAB_ID},
                    success:function(data){
                        if (data=='yes') {
                            alert("Deleted successfully");
                            $("#laboratoryList").load(location.href + " #laboratoryList");
                        }
                    },
                    error:function(){
                        alert('Error deleting');
                    }
                });
            }
        });

    }

</script>