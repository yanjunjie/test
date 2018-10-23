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
                    <label class="col-md-5 control-label">Laboritory Name: <span class="red">*</span></label>

                    <div class="col-md-5">
                        <input type="text" name="LAB_NAME" id="LAB_NAME" value="<?php echo $UM_LABRATORIES[0]->LAB_NAME; ?>" class="form-control" placeholder="Laboritory Name">
                        <span class="red"><?php echo form_error('EXP_NAME'); ?></span>
                    </div>
                </div>

            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="LAB_DESC" class="col-md-5 control-label">Laboritory Description:</label>

                    <div class="col-md-5">
                        <input type="text" name="LAB_DESC" id="LAB_DESC" value="<?php  echo $UM_LABRATORIES[0]->LAB_DESC; ?>" class="form-control" placeholder="Laboritory Description">
                        <span class="red"></span>
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