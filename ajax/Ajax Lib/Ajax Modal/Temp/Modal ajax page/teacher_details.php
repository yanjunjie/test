<style type="text/css">
    /***
User Profile Sidebar by @keenthemes
A component of Metronic Theme - #1 Selling Bootstrap 3 Admin Theme in Themeforest: http://j.mp/metronictheme
Licensed under MIT
***/

    /* Profile container */
    .profile {
        margin: 20px 0;
    }

    /* Profile sidebar */
    .profile-sidebar {
        padding: 20px 0 10px 0;
        background: #fff;
    }

    .profile-userpic img {
        float: none;
        margin: 0 auto;
        width: 50%;
        height: 50%;
        -webkit-border-radius: 50% !important;
        -moz-border-radius: 50% !important;
        border-radius: 50% !important;
    }

    .profile-usertitle {
        text-align: center;
        margin-top: 20px;
    }

    .profile-usertitle-name {
        color: #5a7391;
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 7px;
    }

    .profile-usertitle-job {
        text-transform: uppercase;
        color: #5b9bd1;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .profile-userbuttons {
        text-align: center;
        margin-top: 10px;
    }

    .profile-userbuttons .btn {
        text-transform: uppercase;
        font-size: 11px;
        font-weight: 600;
        padding: 6px 15px;
        margin-right: 5px;
    }

    .profile-userbuttons .btn:last-child {
        margin-right: 0px;
    }

    .profile-usermenu {
        margin-top: 30px;
    }

    .profile-usermenu ul li {
        border-bottom: 1px solid #f0f4f7;
    }

    .profile-usermenu ul li:last-child {
        border-bottom: none;
    }

    .profile-usermenu ul li a {
        color: #93a3b5;
        font-size: 14px;
        font-weight: 400;
    }

    .profile-usermenu ul li a i {
        margin-right: 8px;
        font-size: 14px;
    }

    .profile-usermenu ul li a:hover {
        background-color: #fafcfd;
        color: #5b9bd1;
    }

    .profile-usermenu ul li.active {
        border-bottom: none;
    }

    .profile-usermenu ul li.active a {
        color: #5b9bd1;
        background-color: #f6f9fb;
        border-left: 2px solid #5b9bd1;
        margin-left: -2px;
    }

    /* Profile Content */
    .profile-content {
        padding: 20px;
        background: #fff;
        min-height: 460px;
    }

</style>

<div class="row profile">
    <span type="hidden" id="USER_ID" teacher-data-id="<?php echo $teacher_id; ?>"></span>

    <div class="col-md-3">
        <div class="profile-sidebar">
            <!-- SIDEBAR USERPIC -->
            <div class="profile-userpic">
                <?php $user_session = $this->session->userdata('logged_in');
                $user_session['USER_IMG']; ?>
                <img src="<?php $pp = 'assets/img/default.png';
                if (!empty($tcr_personal_info->USER_IMG))
                    $pp = 'upload/faculty_teacher/' . $tcr_personal_info->USER_IMG;
                echo base_url($pp) ?>" class="img-responsive" alt=""></div>
            <!-- END SIDEBAR USERPIC -->
            <!-- SIDEBAR USER TITLE -->
            <div class="profile-usertitle">
                <div
                    class="profile-usertitle-name"><?php if (!empty($photo->FULL_NAME_EN)) echo $photo->FULL_NAME_EN ?></div>
                <div class="profile-usertitle-job">Lecturer</div>
            </div>
            <!-- END SIDEBAR USER TITLE -->
            <!-- SIDEBAR BUTTONS -->
            <div class="profile-userbuttons">
                <button type="button" class="btn btn-success btn-sm">Email</button>
                <button type="button" class="btn btn-danger btn-sm">Message</button>
            </div>
            <!-- END SIDEBAR BUTTONS -->
            <!-- SIDEBAR MENU -->
            <div class="profile-usermenu">
                <ul class="nav" id="navlist">
                    <li class="active">
                        <a id="personal_information" data-action="teacher/teacherPersonalDetails" href="#"> <i
                                class="fa fa-home"></i>
                            Personal Info
                        </a>
                    </li>
                    <li>
                        <a data-action="teacher/teacherFamillyDetails" href="#"> <i
                                class="fa  fa-users"></i>
                            Familly & Others
                        </a>
                    </li>
                    <li>
                        <a data-action="teacher/teacherAcademicInfo" href="#" target="_blank">
                            <i class="fa fa-graduation-cap"></i>
                            Academic Info
                        </a>
                    </li>
                    <li>
                        <a data-action="teacher/teacherExp" href="#">
                            <i class="fa fa-thumbs-o-up"></i>
                            Experience
                        </a>
                    </li>
                    <li>
                        <a data-action="teacher/teacherMedicalInfo" href="#">
                            <i class="fa fa-user-md"></i>
                            Medical
                        </a>
                    </li>
                    <li>
                        <a data-action="teacher/teacherAwardInfo" href="#">
                            <i class="fa fa-trophy"></i>
                            Awards
                        </a>
                    </li>
                    <li>
                        <a data-action="teacher/teacherAffiliation" href="#">
                            <i class="fa  fa-user"></i>
                            Affiliation
                        </a>
                    </li>
                    <li>
                        <a data-action="teacher/teacherSkill" href="#">
                            <i class="fa fa-certificate"></i>
                            Skill
                        </a>
                    </li>
                    <li>
                        <a data-action="teacher/teacherInterest" href="#">
                            <i class="fa fa-heart-o"></i>
                            Interest
                        </a>
                    </li>
                    <li>
                        <a data-action="teacher/teacherTourTravels" href="#">
                            <i class="fa fa-bus"></i>
                            Tour & Travels
                        </a>
                    </li>
                    <li>
                        <a data-action="teacher/teacherPublication" href="#">
                            <i class="glyphicon glyphicon-book"></i>
                            Publication
                        </a>
                    </li>
                </ul>
            </div>
            <!-- END MENU --> </div>
    </div>
    <div class="col-md-9">
        <div class="profile-content">

            <h4 class="green">Personal Information</h4>

            <div class="ibox-content">
                <div class="table-responsive contentArea">
                    <table class="table table-striped table-bordered table-hover gridTable">

                        <tbody>
                        <tr>
                            <th>Name (English)</th>
                            <td>:</td>
                            <td><?php if (!empty($tcr_personal_info->FULL_NAME)) echo $tcr_personal_info->FULL_NAME ?></td>
                        </tr>
                        <tr>
                            <th>নাম বাংলা</th>
                            <td>:</td>
                            <td><?php if (!empty($tcr_personal_info->FULL_NAME_BN)) echo $tcr_personal_info->FULL_NAME_BN ?></td>
                        </tr>
                        <tr>
                            <th>Date of Birth</th>
                            <td>:</td>
                            <td><?php if (!empty($tcr_personal_info->DOB)) echo date('Y-m-d', strtotime($tcr_personal_info->DOB)) ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Place of Birth</th>
                            <td>:</td>
                            <td><?php if (!empty($tcr_personal_info->PLACE_OF_BIRTH)) echo $tcr_personal_info->PLACE_OF_BIRTH ?></td>
                        </tr>
                        <tr>
                            <th>Marital Status</th>
                            <td>:</td>
                            <td><?php if (!empty($tcr_personal_info->ms)) echo $tcr_personal_info->ms ?></td>
                        </tr>
                        <tr>
                            <th>Spouse Name</th>
                            <td>:</td>
                            <td><?php if (!empty($tcr_personal_info->SPOUSE_NAME)) echo $tcr_personal_info->SPOUSE_NAME ?></td>
                        </tr>
                        <tr>
                            <th>Nationality</th>
                            <td>:</td>
                            <td><?php if (!empty($tcr_personal_info->nt)) echo $tcr_personal_info->nt ?></td>
                        </tr>
                        <tr>
                            <th>National ID</th>
                            <td>:</td>
                            <td><?php if (!empty($tcr_personal_info->NID)) echo $tcr_personal_info->NID ?></td>
                        </tr>
                        <tr>
                            <th>Passport No.</th>
                            <td>:</td>
                            <td><?php if (!empty($tcr_personal_info->PASSPORT_NO)) echo $tcr_personal_info->PASSPORT_NO ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>:</td>
                            <td>
                                <?php
                                if (!empty($teacher_email))
                                    foreach ($teacher_email as $row) {
                                        echo "  $row->CONTACTS <br>";
                                    }
                                ?>
                            </td>

                        </tr>
                        <tr>
                            <th>Mobile</th>
                            <td>:</td>
                            <td>
                                <?php
                                if (!empty($teacher_contact))
                                    foreach ($teacher_contact as $row) {
                                        echo " $row->CONTACTS <br>";
                                    }
                                ?></td>
                        </tr>
                        <tr>
                            <th>Religion</th>
                            <td>:</td>
                            <td><?php if (!empty($tcr_personal_info->rn)) echo $tcr_personal_info->rn ?></td>
                        </tr>
                        <tr>
                            <th>Height</th>
                            <td>:</td>
                            <td><?php if (!empty($tcr_personal_info->HEIGHT_FEET)) echo $tcr_personal_info->HEIGHT_FEET . '  &nbsp; Feet &nbsp; &nbsp; &nbsp;  ' . $tcr_personal_info->HEIGHT_CM . '&nbsp;   CM' ?></td>
                        </tr>
                        <tr>
                            <th>Weight</th>
                            <td>:</td>
                            <td><?php if (!empty($tcr_personal_info->WEIGHT_KG)) echo $tcr_personal_info->WEIGHT_KG . '&nbsp; KG&nbsp; &nbsp; &nbsp; &nbsp; ' . $tcr_personal_info->WEIGHT_LBS . '&nbsp;&nbsp; Pound' ?></td>
                        </tr>
                        <tr>
                            <th>Hobby</th>
                            <td>:</td>
                            <td> <?php if (!empty($tcr_personal_info->HOBBY)) echo $tcr_personal_info->HOBBY ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        //to show the active menu function
        $('#navlist li').click(function (e) {
            e.preventDefault(); //prevent the link from being followed               
            $('#navlist li').removeClass('active');
            $(this).addClass('active');
        });

        $('#navlist li a').click(function () {
            var teacher_id = $("#USER_ID").attr('teacher-data-id');
            var action_uri = $(this).attr('data-action');
            $.ajax({
                type: 'post',
                url: "<?php echo base_url(); ?>/" + action_uri,
                data: {teacher_id: teacher_id},
                beforeSend: function () {
                    $(".profile-content").html("<img src='<?php echo base_url(); ?>assets/img/loader.gif' />");
                },
                success: function (data) {
                    $('.profile-content').html(data);
                }
            });
        });
    });
</script>