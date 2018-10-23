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
