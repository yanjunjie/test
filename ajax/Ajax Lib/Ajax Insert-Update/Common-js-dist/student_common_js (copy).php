<script>

    $(document).ready(function () {

        // Update Applicant Information using Ajax

        $(document).on("click", ".fSubmit", function () {

            var this_btn = $(this);
            var this_form= $(this).closest("form").attr('id');

            if($("#"+this_form).valid() == true) {

                swal({
                    title: "Are you sure?",
                    text: "Want to update your information?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#F8AC59",
                    confirmButtonText: "Yes, update it!",
                    closeOnConfirm: true
                }, function () {

                    //var frmContent = $(".fContent").serialize();
                    var formData = new FormData($('.fContent')[0]);
                    var action_uri = this_btn.attr("data-action");
                    var type = this_btn.attr("data-type");
                    var success_action_uri = this_btn.attr("data-su-action");
                    var action_param = this_btn.attr("data-param");
                    var ac_type = this_btn.attr("");

                    //confirm(action_uri);
                    var param = "";
                    if (type != "list") {
                        param = $(".rowID").val();
                    }
                    var sn = $("#loader_" + param).siblings("span").text();
                    $.ajax({
                        type: "post",
                        data: formData,
                        url: "<?php echo site_url(); ?>/" + action_uri,
                        processData: false,
                        contentType: false,
                        beforeSend: function () {
                            $(".loadingImg").html("<img src='<?php echo base_url(); ?>assets/img/loader.gif' />");
                        },
                        success: function (data) {

                            $(".loadingImg").html("");
                            var pro_pic = "<?php echo base_url(); ?>upload/applicant/photo/" + data;

                            if (data != '') {
                                //$("#applicant_profile_pic").attr('src', pro_pic);
                                //$("#applicant_profile_picture").attr('src', pro_pic);

                            }

                            $.ajax({
                                type: "post",
                                data: {param: param},
                                url: "<?php echo site_url(); ?>/" + success_action_uri + '/' + action_param,
                                beforeSend: function () {
                                    $(".profile-content").html("<img src='<?php echo base_url(); ?>assets/img/loader.gif' />");
                                },
                                success: function (data) {

                                    // Toaster Alert
                                    setTimeout(function () {
                                        toastr.options = {
                                            closeButton: true,
                                            progressBar: true,
                                            showMethod: 'slideDown',
                                            timeOut: 4000
                                        };

                                        toastr.warning('Successfully Updated', 'Done');
                                    });

                                    $('.profile-content').html(data);
                                }
                            });
                        }
                    });

                });

            }


        });

    });


</script>
