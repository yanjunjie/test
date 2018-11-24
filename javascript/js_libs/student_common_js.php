<script type="text/javascript">

    $(document).ready(function () {

        // Update Student Information using Ajax
        $(document).on("click", ".fSubmit", function () {
            var this_btn = $(this);
    var this_form= $(this).closest("form").attr('id');
    if($("#"+this_form).valid() == true) {
            //return false;
            swal({
                title: "Are you sure?",
                text: "Want to update your information?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#F8AC59",
                confirmButtonText: "Yes, update it!",
                closeOnConfirm: true
            }, function () {

                var formData = new FormData($('#'+this_form)[0]);
                var action_uri = this_btn.attr("data-action");               
                var success_action_uri = this_btn.attr("data-su-action");
                var action_param = this_btn.attr("data-param");                
                var data_view_div = this_btn.attr("data-view-div");
                
                $.ajax({
                    type: "post",
                    data: formData,
                    url: "<?php echo site_url(); ?>/" + action_uri + '/' + action_param,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $(".loadingImg").html("<img src='<?php echo base_url(); ?>assets/img/loader.gif' />");
                    },

                    success: function (data) {
                        $(".loadingImg").html("");
                        $(".frmMsg").html(data);
//                        $(".frmMsg").html('<?php //echo $this->session->flashdata('msg'); ?>//').show();
                        /*//show form data
                        for (var [key, value] of formData.entries()) { 
                            console.log(key, value);
                        }  */ 
                        $.ajax({
                            type: "post",
                            data: formData,
                            url: "<?php echo site_url(); ?>/" + success_action_uri + '/' + action_param,
                            processData: false,
                            contentType: false,
                            beforeSend: function () {
                                $(".loadingImg").html("");
//                                $(".loadingImg").html("<img src='<?php //echo base_url(); ?>//assets/img/loader.gif' />");
},
success: function (data) {
    $('#'+data_view_div).html(data);
    setTimeout(function () {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 4000
        };

        toastr.warning('Successfully Updated', 'Done');
    }); 
}
});
                    }
                });

            });
        }
            });

    });


</script>