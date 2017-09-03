 <style>
    table th{text-align:center;}
    .modal-content {border: none !important;}
    /* .modal-header {border-bottom: none !important; } */
    .panel-default {border-color: transparent !important;}
 </style>
 <div class="row" style="margin-top:40px;">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="text-muted bootstrap-admin-box-title">Manage Renter</div>
            </div>
            <div class="bootstrap-admin-panel-content">
                <table class="text-center table table-striped table-bordered" style="table-layout:fixed; width:100%; word-wrap:break-word">
                    <thead>
                        <tr>
                            <th style="width:5%">SL.</th>
                            <th>Name</th>
                            <th>NID</th>
                            <th>Phone No.</th>
                            <th>Photo</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0; foreach ($renter_all as $key1=>$row1): $i++ ?>
                        <tr>
                            <?php echo '<td style="width:5%">'.$i.'</td>'; ?>
                            <?php echo '<td>'.$row1->renter_fullname.'</td>'; ?>
                            <?php echo '<td>'.$row1->renter_nid.'</td>'; ?>
                            <?php echo '<td>'.$row1->renter_phone.'</td>'; ?>
                            <?php echo '<td><img src="'.base_url('uploads/').$row1->renter_photo.'" width="70" alt="Renter Photo"></td>'; ?>
                            <td class="actions">
                                <button id="renter_edit" data-id="<?php echo $row1->renter_id; ?>" class="btn btn-sm btn-primary renter_edit">
                                    <i class="glyphicon glyphicon-pencil"></i>
                                    Edit
                                </button>
                                <button id="renter_delete" data-id="<?php echo $row1->renter_id; ?>" class="btn btn-sm btn-danger renter_delete">
                                    <i class="glyphicon glyphicon-trash"></i>
                                    Delete
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Update dialog -->
<div class="row">
    <button style="visibility: hidden;" type="button" id="renter_update_dialog_btn" class="btn btn-default btn-create" data-toggle="modal" data-target="#renter_update_dialog">Update Renter</button>
    <?php $this->load->view('dialogs/renter_update_dialog'); ?>
</div>

<script>

    window.onload = function(){
        //delete
        $('.renter_delete').on('click',function(){
            var deleted_row = $(this).parent().parent();
            var id = $(this).data('id');
            var url = '<?php echo base_url("renter/delete"); ?>';

            if (confirm('Are you sure to delete?')) {
                $.ajax({
                    type:'post',
                    url:url,
                    cache: false,
                    data:{renter_id:id},
                    success:function(data){
                        if (data=='yes') {
                            deleted_row.fadeOut().remove();
                            alert("Deleted successfully"); 
                        }
                    },
                    error:function(){
                        alert('Error deleting');
                    }
                });
            }
        });

        //Update Form
        $('.renter_edit').on('click',function(){

            var id = $(this).data('id');
            var url = '<?php echo base_url("super_admin/renter_update_form"); ?>';

            $.ajax({
                type:'post',
                url:url,
                data:{renter_id:id},
                success:function(data){
                    if (data) {
                        $('#renter_update_dialog_btn').trigger('click');
                        $('#renter_update_data').html(data);
                        $('.datetimepicker').datetimepicker({
                            format: 'DD/MM/YYYY'
                        });
                    }
                },
                error:function(){
                    alert('Error updating');
                }
            });
        });

        //Update
        /*$(document).on('submit', '#renterUpdateForm', function(event){
            event.preventDefault();
            event.stopPropagation();
            var renterUpdateSubmitData = new FormData(this);
            //var renterUpdateSubmitData = $('#renterUpdateForm').serialize();
            console.log(renterUpdateSubmitData);
            var url = '<php echo base_url("renter/update"); ?>';

            $.ajax({
                type:'POST',
                url: url,
                data:renterUpdateSubmitData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(data){
                    //$("#renterUpdateForm")[0].reset();
                    if (data=='yes') {
                        alert("Success! Updated successfully");
                        $('.modal').modal('hide');
                        window.location = "<php echo base_url('renter/renter_action'); ?>";
                    }
                },
                error: function(data){
                    console.log("Error: "+data);
                    if (data=='no') {
                        alert("Failure! Not Updated successfully");
                        $('.modal').modal('hide');
                        window.location = "<php echo base_url('renter/renter_action'); ?>";
                    }
                }
            });

        });
        
        $(document).on("change","#renter_photo",function() {
            $("#renterUpdateForm").submit();
        });*/
        //End Update


        //update image preview
        function renter_update_image(input) {
            if (input.files && input.files[0]) {
            var reader = new FileReader();
                reader.onload = function (e) {
                    $('#renter_photo_preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $(document).on("change","#renter_photo",function(){
            renter_update_image(this);
            console.log('File selected');
        });
        //End update image preview

        //Add Member dynamically to form field add
        var count = 1;
        $(document).on("click","#addMember", function(){
            //alert('hi');
            count = count + 1;
            var html_code = "<tr id='row"+count+"'>";
            html_code +="<td>"+count+"</td>";
            html_code +='<td><input type="text" name="family_member_name[]" required="required"></td>';
            html_code +='<td><input type="text" name="family_member_age[]" required="required"></td>';
            html_code +='<td><input type="text" name="family_member_job[]" required="required"></td>';
            html_code +='<td><input type="text" name="family_member_phone[]" required="required"></td>';
            html_code +='<td><button type="button" data-row="row'+count+'" class="btn btn-danger btn-xs remove"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>';
            html_code +='</tr>';
            $('#member-add-table').append(html_code);
        });


    } //End document ready


</script>