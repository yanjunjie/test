<?php $user_session = $this->session->userdata('logged_in'); ?>
<div class="row border-bottom">
    <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>

            <div role="search" class="navbar-form-custom" action="search_results.html">
                <div style="padding: 12px">
                    <h4 style="margin:0px !important;padding: 0px !important;"><b><?php echo $pageContentTitle; ?></b></h4>
                    <?php if (!empty($breadcrumbs)): ?>
                        <ul class="breadcrumb">

                            <?php
                            foreach ($breadcrumbs as $key => $value):
                                if ($value != '#'):
                                    ?>
                                <li><a href="<?php echo site_url("$value"); ?>"><?php echo $key; ?></a></li>
                            <?php else: ?>
                                <li class="active"><?php echo $key; ?></li>
                                <?php
                                endif;
                                endforeach;
                                ?>
                            </ul>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
            <ul class="nav navbar-top-links navbar-right" style="margin-top: 15px">
                <li >
                    <!--<strong><?php /*echo $this->session->userdata('logged_in')['my_db'];*/?></strong>--> <span class="m-r-sm text-muted welcome-message"><strong>Welcome,</strong> <?php //$emp_details=$this->utilities->findByAttribute('hr_emp',array('EMP_ID'=>$user_session["EMP_ID"])); echo isset($emp_details->FULL_ENAME)?$emp_details->FULL_ENAME:''; ?></span>
                </li>


                <li>
                    <div class="dropdown">
                      <button  class=" dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                          <?php $user_img = ($user_session['USER_IMG'] != '') ? 'upload/employee/photo/' . $user_session['USER_IMG'] : 'assets/img/default.png' ?>
                        <img alt="image" style="width:20px;" class="img-circle"
                             src="<?php echo base_url($user_img); ?>" /> 
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                         
                        <li><a class="pull-left applicant_details"    type="button"
                    data-user-id="<?php //echo $user_session["EMP_ID"] ?>" data-toggle="modal"
                    data-target="#applicant_modal"><i class="fa fa-user"></i> Profile</a></li>
                        <?php  $session_info = $this->session->userdata('logged_in');
                            $USER_TYPE = $session_info["USER_TYPE"];
                            $IS_ADMIN = $session_info["IS_ADMIN"];
                            if($IS_ADMIN) {
                                ?>
                                <li><a title="Change Database" class="openModal"data-action="admin/resetDatabase"><i class="fa fa-database"></i>  Change Database </a></li>
                                <?php
                            }
                        ?>
                        <li><a title="Change Password" class="openModal"
                               data-action="admin/resetPasswordInsert"><i class="fa fa-key"></i> Change Password
                            </a></li>
                        <li role="separator" class="divider"></li>
                        <li>
                        <a href="<?php echo site_url('auth/logout'); ?>">
                        <i class="fa fa-sign-out"></i> Log out
                        </a>
                </li>
                    </ul>
                </div>

            </li>

        </ul>

    </nav>
</div>

<div class="modal inmodal fade" id="applicant_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">Employee Details</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(".applicant_details").on("click", function () {
        var EMP_ID = $(this).attr('data-user-id');

        $.ajax({
            type: 'post',
            url: '<?php echo site_url()?>/employee/empModal',
            data: {EMP_ID: EMP_ID},
            success: function (data) {
                $("#applicant_modal .modal-body").html(data);
            }
        });
    });
</script>
