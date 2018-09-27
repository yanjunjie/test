<link href="<?php echo base_url(); ?>assets/css/plugins/datapicker/jquery-ui.datepicker.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/keyboard/keyboard.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url()?>/assets/css/plugins/jQueryUI/jquery-ui.css">

<style>
    .flexy {
        display: block;
        width: 90%;
        border: 1px solid #eee;
        max-height: 200px;
        overflow: auto;
    }

    .avatar-zone {
        width: 140px;
        height: 200px;

    }

    .avatar-zone img{
        cursor: pointer;
    }

    .overlay-layer {
        width: 150px;
        height: 30px;
        position: absolute;
        margin-top: -47px;
        opacity: 0.5;
        background-color: #000000;
        z-index: 0;
        font-size: 15px;
        color: #FFFFFF;
        text-align: center;
        line-height: 30px;
    }
    .avatar-zone-sig {
        width: 140px;
        height: 92px;

    }
    .avatar-zone-sig img{
        cursor: pointer;
    }
    .overlay-layer-sig {
        width: 150px;
        height: 30px;
        position: absolute;
        margin-top: -44px;
        opacity: 0.5;
        background-color: #000000;
        z-index: 0;
        font-size: 15px;
        color: #FFFFFF;
        text-align: center;
        line-height: 30px;
    }

    .upload_btn {
        position: absolute;
        width: 200px;
        height: 40px;
        margin-top: -40px;
        z-index: 10;
        opacity: 0;
    }

    .red {
        color: red
    }

    .pointer2 {
        cursor: pointer;
    }

    .div-background {
        background-color: #D9E0E7;
        padding: 20px;
        border-radius: 10px
    }

    .toggle-div {
        display: none;
        background-color: #FCF8E3;
        padding: 10px;
        border-radius: 10px;
    }

    .toggle-div-course {
        display: none;
        background-color: #FCF8E3;
        padding: 10px;
        border-radius: 10px;
        width: 400px;
    }

    .toggle-div1 {
        background-color: #d9e0e7;
        padding: 10px;
        border-radius: 10px;
    }
</style>
<link href="<?php echo base_url(); ?>assets/css/plugins/jQueryUI/jquery-ui-1.10.4.custom.min.css" rel="stylesheet">
<div id="admission_form_div">
    <div class="ibox float-e-margins">

        <div class="ibox-title">
            <h5>Applicant Form</h5>

            <div class="ibox-tools">

            </div>
        </div>
        <form id="admission_form" class="form-horizontal" action="" method="post"  enctype="multipart/form-data">
            <?php
            $userdata = $this->session->userdata('applicant_logged_in');
            ?>
            <div class="">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>NOTE : </strong> All <span class="red">*</span> field are required.
                        </div>
                        <div class="col-md-6 ">
                            <?php if(validation_errors() != false): ?>
                                <div class="alert alert-danger alert-dismissable fade in">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <?php echo validation_errors();?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="div-background">
                        <h4 style="color:green">Personal Information</h4>
                        <div class="rowr">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-5 control-label " for="DEGREE_ID" >Course <span class="text-danger">*</span></label>
                                    <div class="col-md-5">
                                        <select name="DEGREE_ID" id="DEGREE_ID" data-placeholder="Choose a Course..." class="chosen-select form-control" tabindex="2">
                                            <option selected="selected" disabled="disabled" value="">Select a Course</option>
                                            <?php foreach ($degree as $row) { ?>
                                                <option value="<?php echo $row->COURSE_ID ?>"><?php echo $row->COURSE_NAME ?></option>
                                            <?php }?>
                                        </select>

                                    </div>
                                    <br clear="all"/>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-5 control-label">Full Name <span class="text-danger">*</span></label>
                                    <div class="col-md-5 ">

                                        <input type="text" name="FULL_NAME"
                                               value="<?php echo set_value('FULL_NAME', $userdata['FULL_NAME']); ?>"
                                               class="form-control" id="FULL_NAME" placeholder="Full Name"/>

                                        <div class="text-danger">
                                            <?php echo form_error('FULL_NAME'); ?>
                                        </div>

                                    </div>
                                    <div class="col-md-2">
                                        <i class="fa fa-info-circle pointer2" data-content="* (As per Certificate of SSC/ Equivalent Examination)"
                                           data-placement="right" data-toggle="popover" data-container="body"
                                           data-original-title="" title="Help"></i>
                                    </div>
                                    <br clear="all"/>
                                </div>
                                <div class="form-group">
                                    <label  for="FULL_NAME_BN" class="col-md-5 control-label">নাম ( বাংলা ) <span class="red">*</span></label>

                                    <div class="col-md-5">
                                        <input type="text" name="FULL_NAME_BN" id="FULL_NAME_BN"
                                               value="<?php echo set_value('FULL_NAME_BN') ?>"
                                               class="form-control keyboardInput" placeholder="বাংলা নাম" >
                                        <span class="red"><?php echo form_error('FULL_NAME_BN'); ?></span>
                                    </div>
                                    <div class="col-md-2">
                                        <i class="fa fa-info-circle pointer2" data-content="বাংলায় আপনার নাম লিখুন"
                                           data-placement="right" data-toggle="popover" data-container="body"
                                           data-original-title="" title="Help"></i>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label" for="GENDEN">Gender<span class="text-danger">*</span></label>
                                    <div class="col-md-5 ">
                                        <input type="radio" name="GENDER" class="gender required" value="M" data-value="Male" checked="checked"/> Male
                                        &nbsp;&nbsp;
                                        <input type="radio" name="GENDER" class="gender required" value="F" data-value="Female"/> Female
                                        &nbsp;&nbsp;
                                        <input type="radio" name="GENDER" class="gender required" value="O" data-value="Others"/> Others
                                    </div>
                                    <br clear="all"/>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Mobile No <span class="text-danger">*</span></label>
                                    <!--            <div class="row">-->
                                    <!--                <div class="col-md-1" style="width:6.333333% !important ; padding-right:2px !important;">-->
                                    <!--                    <input type="text" class="form-control text-right" style="padding:3px !important;" placeholder="+88" readonly="readonly" />-->
                                    <!--                </div>-->
                                    <div class="col-md-5">
                                        <input type="text" name="MOBILE_NO" id="MOBILE_NO" value="<?php echo set_value('MOBILE_NO'); ?>" maxlength="11" class="form-control numericOnly" placeholder="01XXXXXXXXX"/>
                                        <div class="text-danger">
                                            <?php echo form_error('MOBILE_NO'); ?>
                                        </div>
                                    </div>
                                    <!--         </div>-->
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label" >Email<span class="text-danger">*</span></label>
                                    <div class="col-md-5">
                                        <input type="text" name="EMAIL" id="EMAIL" value="<?php echo set_value('EMAIL'); ?>" id=""  class="form-control" placeholder="user@mydomain.com"/>
                                        <div class="text-danger">
                                            <?php echo form_error('EMAIL'); ?>
                                        </div>
                                    </div>
                                    <br clear="all"/>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label" >Date of  Birth<span class="text-danger">*</span></label>
                                    <div class="col-md-5 ">
                                        <input type="text" name="DATE_OF_BIRTH" id="DATE_OF_BIRTH" value="<?php echo set_value('DATE_OF_BIRTH'); ?>" class="form-control datepicker"  placeholder="dd-mm-yyyy">
                                        <div class="text-danger">
                                            <?php echo form_error('DATE_OF_BIRTH'); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="BLOOD_GRP" class="col-md-5 control-label">Blood Group </label>
                                    <div class="col-md-5">
                                        <select name="BLOOD_GRP" id="BLOOD_GRP" data-placeholder="Choose a Blood Group..." class="chosen-select form-control" tabindex="2">
                                            <option selected="selected" disabled="disabled" value="">Selec Blood Group</option>
                                            <option value="A+">A+</option>
                                            <option value="A-">A-</option>
                                            <option value="B+">B+</option>
                                            <option value="B-">B-</option>
                                            <option value="AB+">AB+</option>
                                            <option value="AB-">AB-</option>
                                            <option value="O+">O+</option>
                                            <option value="O-">O-</option>
                                        </select>
                                        <span class="red"><?php echo form_error('BLOOD_GRP'); ?></span>
                                    </div>
                                    <div class="col-md-2">
                                        <i class="fa fa-info-circle pointer2" data-content="Your blood group"
                                           data-placement="right" data-toggle="popover" data-container="body"
                                           data-original-title="" title="Help"></i>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-5 control-label">Marital Status <span class="red">*</span></label>

                                    <div class="col-md-5">
                                        <select name="MARITAL_STATUS" id="MARITAL_STATUS" data-placeholder="Choose One..." class="chosen-select form-control" tabindex="2">
                                            <option selected="selected" disabled="disabled" value="">Select Marital Status</option>
                                            <option value="Married">Married</option>
                                            <option value="Single">Single</option>
                                            <option value="Divorced">Divorced</option>
                                            <option value="Widowed">Widowed</option>
                                        </select>
                                        <span class="red"><?php echo form_error('MARITAL_STATUS'); ?></span>
                                    </div>
                                    <div class="col-md-2">
                                        <i class="fa fa-info-circle pointer2"
                                           data-content="Your merital status" data-placement="right"
                                           data-toggle="popover" data-container="body" data-original-title=""
                                           title="Help"></i>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-5 control-label">Nationality <span class="red">*</span></label>

                                    <div class="col-md-5">
                                        <input type="text" name="NATIONALITY" id="NATIONALITY" value="Bangladeshi"></span>
                                    </div>
                                    <div class="col-md-2">
                                        <i class="fa fa-info-circle pointer2" data-content="Select your nationality"
                                           data-placement="right" data-toggle="popover" data-container="body"
                                           data-original-title="" title="Help"></i>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-5 control-label">Religion <span class="red">*</span></label>
                                    <div class="col-md-5">
                                        <select name="RELIGION_ID" id="RELIGION_ID" data-placeholder="Choose a religion..." class="chosen-select form-control" tabindex="2">
                                            <option selected="selected" disabled="disabled" value="">Select Religion</option>
                                            <?php foreach ($religion as $row) { ?>
                                                <option value="<?php echo $row->RELIGION_NO ?>"><?php echo $row->RELIGION_NAME ?></option>
                                            <?php }?>
                                        </select>

                                        <span class="red"><?php echo form_error('RELIGION_ID'); ?></span>
                                    </div>
                                    <div class="col-md-2">
                                        <i class="fa fa-info-circle pointer2" data-content="Select your religion"
                                           data-placement="right" data-toggle="popover" data-container="body"
                                           data-original-title="" title="Help"></i>
                                    </div>
                                </div>
                                <div class="form-group">

                                    <label class="col-md-5 control-label">Quota<span class="red">*</span></label>
                                    <div class="col-md-5">
                                        <select name="QUOTA_ID" id="QUOTA_ID" data-placeholder="Select Quota..." class="form-control chosen-select" tabindex="2">
                                            <option selected="selected" disabled="disabled" value="">Select Quota</option>
                                            <?php foreach ($NM_QUOTA as $row) { ?>

                                                <?php
                                                if( $applicantData[0]->QUOTA_ID == $row->QUOTA_ID ) //Saved value == $row[$i]
                                                { ?>
                                                    <option selected="selected" value="<?php echo $row->QUOTA_ID ?>"><?php echo $row->QUOTA_NAME ?></option>
                                                <?php } ?>

                                                <option value="<?php echo $row->QUOTA_ID ?>"><?php echo $row->QUOTA_NAME ?></option>
                                            <?php }?>
                                        </select>

                                        <span class="red"><?php echo form_error('QUOTA_ID'); ?></span>
                                    </div>
                                    <div class="col-md-2">
                                        <i class="fa fa-info-circle pointer2" data-content="Select your religion"
                                           data-placement="right" data-toggle="popover" data-container="body"
                                           data-original-title="" title="Help"></i>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label class="control-label col-md-5">Your Photo  <span class="red">*</span></label>

                                    <div class="col-md-5">
                                        <div class="avatar-zone">
                                            <img id="img_id" src="<?php echo base_url('upload/default/default_pic.png'); ?>"
                                                 alt="select photo" style="width: 150px;"/>
                                        </div>
                                        <div style="cursor: pointer;" class="overlay-layer">Choose File</div>
                                        <input type='file' style="cursor: pointer; display: none" name="photo" id="propic" onchange="upload_img(this);" class="upload_btn">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-5">Your Signature<span class="red">*</span></label>

                                    <div class="col-md-5">
                                        <div class="avatar-zone-sig">
                                            <img id="sig_id" src="<?php echo base_url('upload/default/default_sign.png'); ?>"
                                                 alt="select photo"  style="width: 150px; height: 45px;"/>
                                        </div>
                                        <div class="overlay-layer-sig">Choose File</div>
                                        <input type='file' style="cursor: pointer;" name="signature" id="sigpic" onchange="upload_img_sig(this);" class="upload_btn">
                                    </div>
                                    <!--<div class="col-md-2">
                                        <i class="fa fa-info-circle pointer2" data-content="Select your signature image"
                                           data-placement="right" data-toggle="popover" data-container="body"
                                           data-original-title="" title="Help"></i>
                                    </div>-->
                                </div>

                                <div class="form-group">
                                    <label id="signature_date" class="control-label col-md-5">Signature  Date<span class="red">*</span></label>

                                    <div class="col-md-5">
                                        <input type="text" name="signature_date"  value="<?php echo set_value('signature_date'); ?>" class="form-control datepicker"  placeholder="dd-mm-yyyy">
                                        <div class="text-danger">
                                            <?php echo form_error('signature_date'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <i class="fa fa-info-circle pointer2" data-content="Write your signature date"
                                           data-placement="right" data-toggle="popover" data-container="body"
                                           data-original-title="" title="Help"></i>
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <br>
                        <hr>
                        <h4 style="color:green">Family and Others Information</h4>
                        <div class="rowr">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Father's Name <span class="red">*</span></label>

                                    <div class="col-md-5">
                                        <input type="text" value="<?php echo set_value('FATHER_NAME'); ?>" name="FATHER_NAME" id="FATHER_NAME" class="form-control" placeholder="Father's Name" >
                                        <span class="red"><?php echo form_error('FATHER_NAME'); ?></span>
                                    </div>
                                    <div class="col-md-2">
                                        <i class="fa fa-info-circle pointer2"
                                           data-content="Please enter your father's name here" data-placement="right"
                                           data-toggle="popover" data-container="body" data-original-title=""
                                           title="Help"></i>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-md-5 control-label">Father's Occupation</label>

                                    <div class="col-md-5">
                                        <select name="FATHER_OCU" id="FATHER_OCU" data-placeholder="Choose an occupation..." class="chosen-select form-control" tabindex="2">
                                            <option selected="selected" disabled="disabled" value="">Select an occupation</option>
                                            <?php foreach ($occupation as $row) { ?>
                                                <option value="<?php echo $row->OCCUPATION_ID ?>"><?php echo $row->OCCUPATION_NAME_ENG ?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <i class="fa fa-info-circle pointer2"
                                           data-content="Please enter your father occupation here" data-placement="right"
                                           data-toggle="popover" data-container="body" data-original-title=""
                                           title="Help"></i>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Father's Mobile </label>

                                    <div class="col-md-5">
                                        <input type="text" value="<?php echo set_value('FATHER_PHN'); ?>" name="FATHER_PHN" id="FATHER_PHN" class="form-control numbersOnly" placeholder="Ex: 017XXXXXXXX">
                                    </div>
                                    <div class="col-md-2">
                                        <i class="fa fa-info-circle pointer2"
                                           data-content="Please enter your father's  mobile no here" data-placement="right"
                                           data-toggle="popover" data-container="body" data-original-title=""
                                           title="Help"></i>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-5 control-label" >Father's Email </label>

                                    <div class="col-md-5">
                                        <input type="text" value="<?php echo set_value('FATHER_EMAIL'); ?>" name="FATHER_EMAIL" id="FATHER_EMAIL" class="form-control checkEmail" placeholder="Father's Email">
                                        <span class="red father_email_validation"></span>
                                    </div>
                                    <div class="col-md-2">
                                        <i class="fa fa-info-circle pointer2"
                                           data-content="Please enter your father's valid email address here"
                                           data-placement="right" data-toggle="popover" data-container="body"
                                           data-original-title="" title="Help"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Mother's Name <span class="red">*</span></label>

                                    <div class="col-md-5">
                                        <input type="text" value="<?php echo set_value('MOTHER_NAME'); ?>" name="MOTHER_NAME" id="MOTHER_NAME" class="form-control" placeholder="Mother's Name" >
                                        <span class="red"><?php echo form_error('MOTHER_NAME'); ?></span>
                                    </div>
                                    <div class="col-md-2">
                                        <i class="fa fa-info-circle pointer2" data-content="Please enter your mother's name here" data-placement="right" data-toggle="popover" data-container="body" data-original-title="" title="Help"></i>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-5 control-label">Mother's Occupation</label>
                                    <div class="col-md-5">
                                        <select name="MOTHER_OCU" id="MOTHER_OCU" data-placeholder="Choose an occupation..." class="chosen-select form-control" tabindex="2">
                                            <option selected="selected" disabled="disabled" value="">Select an occupation</option>
                                            <?php foreach ($occupation as $row) { ?>
                                                <option value="<?php echo $row->OCCUPATION_ID ?>"><?php echo $row->OCCUPATION_NAME_ENG ?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <i class="fa fa-info-circle pointer2"
                                           data-content="Please enter your mother's occupation here" data-placement="right"
                                           data-toggle="popover" data-container="body" data-original-title=""
                                           title="Help"></i>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Mother's Mobile</label>

                                    <div class="col-md-5">
                                        <input type="text" value="<?php echo set_value('MOTHER_PHN'); ?>" name="MOTHER_PHN" id="MOTHER_PHN" class="form-control numbersOnly" placeholder="Ex: 017XXXXXXXX">
                                    </div>

                                    <div class="col-md-1">
                                        <i class="fa fa-info-circle pointer2"
                                           data-content="Please enter your mother's valid mobile no here"
                                           data-placement="right" data-toggle="popover" data-container="body"
                                           data-original-title="" title="Help"></i>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-5 control-label">Mother's Email </label>

                                    <div class="col-md-5">
                                        <input type="text" value="<?php echo set_value('MOTHER_EMAIL'); ?>" name="MOTHER_EMAIL" id="MOTHER_EMAIL" class="form-control checkEmail" placeholder="Mother's Email">
                                        <span class="red mother_email_validation"></span>
                                    </div>

                                    <div class="col-md-1">
                                        <i class="fa fa-info-circle pointer2"
                                           data-content="Please enter your mother's valid email address here"
                                           data-placement="right" data-toggle="popover" data-container="body"
                                           data-original-title="" title="Help"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div id="present_address" class="toggle-div1">
                            <div  class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Present Address <span class="red">*</span></label>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">District</label>

                                    <div class="col-md-5">
                                        <input type="text" name="DISTRICT_ID" id="DISTRICT_ID" value="<?php echo set_value('DISTRICT_ID'); ?>" class="form-control" placeholder="District"/>
                                        <!--<select name="DISTRICT_ID" id="DISTRICT_ID" class="form-control" >
                                            <option value="">-Select-</option>
                                        </select>-->
                                    </div>
                                    <div class="col-md-2">
                                        <i class="fa fa-info-circle pointer2" data-content="Select district name"
                                           data-placement="right" data-toggle="popover" data-container="body"
                                           data-original-title="" title="Help"></i>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Upazila/Thana</label>

                                    <div class="col-md-5">
                                        <input type="text" name="THANA_ID" id="THANA_ID" value="<?php echo set_value('THANA_ID'); ?>" class="form-control" placeholder="Upazila/Thana"/>
                                        <!--<select name="THANA_ID" id="THANA_ID" class="form-control" >
                                            <option value="">-Select-</option>
                                        </select>-->
                                    </div>
                                    <div class="col-md-2">
                                        <i class="fa fa-info-circle pointer2" data-content="Select upazila or thana name"
                                           data-placement="right" data-toggle="popover" data-container="body"
                                           data-original-title="" title="Help"></i>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Post office</label>

                                    <div class="col-md-5">
                                        <input type="text" name="POST_OFFICE_ID" id="POST_OFFICE_ID" value="<?php echo set_value('POST_OFFICE_ID'); ?>" class="form-control" placeholder="Post office"/>
                                        <!--<select name="POST_OFFICE_ID" id="POST_OFFICE_ID" class="form-control">
                                            <option value="">-Select-</option>
                                        </select>-->
                                    </div>
                                    <div class="col-md-2">
                                        <i class="fa fa-info-circle pointer2" data-content="Select post office"
                                           data-placement="right" data-toggle="popover" data-container="body"
                                           data-original-title="" title="Help"></i>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Vill/House no/Road no</label>

                                    <div class="col-md-5">
                                        <input type="text" name="VILLAGE" id="VILLAGE" value="<?php echo set_value('VILLAGE'); ?>" class="form-control" />
                                    </div>
                                    <div class="col-md-2">
                                        <i class="fa fa-info-circle pointer2"
                                           data-content="Enter your village,house or road no here" data-placement="right"
                                           data-toggle="popover" data-container="body" data-original-title=""
                                           title="Help"></i>
                                    </div>
                                </div>
                            </div>
                            <div  class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Permanent Address : <span class="red">*</span></label>
                                    <div class="col-md-8">
                                        Same as present address?
                                        <input type="radio" name="same_as_present" class="same_as_present"
                                               value="YES" >&nbsp; Yes &nbsp;
                                        <input type="radio" name="same_as_present" class="same_as_present"
                                               value="NO" checked>&nbsp; No &nbsp;

                                    </div>
                                </div>
                                <div id="permanent_address">
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">District</label>

                                        <div class="col-md-5">
                                            <input type="text" name="P_DISTRICT_ID" id="P_DISTRICT_ID" value="<?php echo set_value('P_DISTRICT_ID'); ?>" class="form-control" placeholder="District"/>
                                            <!--<select name="P_DISTRICT_ID" id="P_DISTRICT_ID" class="form-control permanent_address_class">
                                                <option value="">-Select-</option>
                                            </select>-->
                                        </div>
                                        <div class="col-md-2">
                                            <i class="fa fa-info-circle pointer2" data-content="Select district name"
                                               data-placement="right" data-toggle="popover" data-container="body"
                                               data-original-title="" title="Help"></i>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Upazila/Thana</label>

                                        <div class="col-md-5">
                                            <input type="text" name="P_THANA_ID" id="P_THANA_ID" value="<?php echo set_value('P_THANA_ID'); ?>" class="form-control" placeholder="Upazila/Thana"/>
                                            <!--<select name="P_THANA_ID" id="P_THANA_ID" class="form-control permanent_address_class">
                                                <option value="">-Select-</option>
                                            </select>-->
                                        </div>
                                        <div class="col-md-2">
                                            <i class="fa fa-info-circle pointer2" data-content="Select upazila or thana name"
                                               data-placement="right" data-toggle="popover" data-container="body"
                                               data-original-title="" title="Help"></i>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Post office</label>

                                        <div class="col-md-5">
                                            <input type="text" name="P_POST_OFFICE_ID" id="P_POST_OFFICE_ID" value="<?php echo set_value('P_POST_OFFICE_ID'); ?>" class="form-control" placeholder="Post office"/>
                                            <!--<select name="P_POST_OFFICE_ID" id="P_POST_OFFICE_ID" class="form-control permanent_address_class">
                                                <option value="">-Select-</option>
                                            </select>-->
                                        </div>
                                        <div class="col-md-2">
                                            <i class="fa fa-info-circle pointer2" data-content="Select post office"
                                               data-placement="right" data-toggle="popover" data-container="body"
                                               data-original-title="" title="Help"></i>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Vill/House no/Road no</label>

                                        <div class="col-md-5">
                                            <input type="text" name="P_VILLAGE" id="P_VILLAGE" value="<?php echo set_value('P_VILLAGE'); ?>" class="form-control "/>
                                        </div>
                                        <div class="col-md-2">
                                            <i class="fa fa-info-circle pointer2"
                                               data-content="Enter your village,house or road no here" data-placement="right"
                                               data-toggle="popover" data-container="body" data-original-title=""
                                               title="Help"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <br>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Local Emergency Guardian </label>

                            <div class="col-md-3">
                                <input type="radio" name="local_emergency_guardian" class="local_emergency_guardian"
                                       value="F" checked>&nbsp; Father &nbsp;
                                <input type="radio" name="local_emergency_guardian" class="local_emergency_guardian"
                                       value="M">&nbsp; Mother &nbsp;
                                <input type="radio" name="local_emergency_guardian" class="local_emergency_guardian"
                                       value="O">&nbsp; Others
                            </div>
                            <div class="col-md-2">
                                <i class="fa fa-info-circle pointer2" data-content="Select your local guardian here"
                                   data-placement="right" data-toggle="popover" data-container="body"
                                   data-original-title="" title="Help"></i>
                            </div>
                        </div>
                        <div id="local_guardian" class="toggle-div">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Local Guardian Name</label>
                                <div class="col-md-3">
                                    <input type="text" name="LOCAL_GAR_NAME" id="LOCAL_GAR_NAME" value="<?php echo set_value('LOCAL_GAR_NAME'); ?>"
                                           class="form-control" placeholder="Local Guardian Name">
                                </div>
                                <div class="col-md-3">
                                    <i class="fa fa-info-circle pointer2" data-content="Enter your Local Guardian Name"
                                       data-placement="right" data-toggle="popover" data-container="body"
                                       data-original-title="" title="Help"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Local Guardian Relation</label>

                                <div class="col-md-3">
                                    <input type="text" name="LOCAL_GAR_RELATION" id="LOCAL_GAR_RELATION" value="<?php echo set_value('LOCAL_GAR_RELATION'); ?>" class="form-control" placeholder="i.e, Brother"/>
                                    <!--<select class="form-control " id="LOCAL_GAR_RELATION" name="LOCAL_GAR_RELATION"
            id="LOCAL_GAR_RELATION">
            <option value="">-Select-</option>
            <?php /*foreach ($relation as $row) { */?>
            <option
            value="<?php /*echo $row->LKP_ID */?>"><?php /*echo $row->LKP_NAME */?></option>
            <?php /*} */?>
        </select>-->
                                </div>
                                <div class="col-md-3">
                                    <i class="fa fa-info-circle pointer2"
                                       data-content="Select your Local Guardian relation" data-placement="right"
                                       data-toggle="popover" data-container="body" data-original-title=""
                                       title="Help"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Local Guardian Mobile</label>
                                <div class="col-md-3">
                                    <input type="text" name="LOCAL_GAR_PHN" id="LOCAL_GAR_PHN" value="<?php echo set_value('LOCAL_GAR_PHN'); ?>"
                                           class="form-control  numbersOnly" placeholder="Mobile">
                                </div>

                                <div class="col-md-1">
                                    <i class="fa fa-info-circle pointer2"
                                       data-content="Please enter your Local Guardian  mobile no here"
                                       data-placement="right" data-toggle="popover" data-container="body"
                                       data-original-title="" title="Help"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Local Guardian Occupation</label>
                                <div class="col-md-3">
                                    <select name="LG_OCCU_ID" id="LG_OCCU_ID" data-placeholder="Choose an occupation..." class="form-control chosen-select" tabindex="2">
                                        <option selected="selected" disabled="disabled" value="">Select an occupation</option>
                                        <?php foreach ($occupation as $row) { ?>
                                            <option value="<?php echo $row->OCCUPATION_ID ?>"><?php echo $row->OCCUPATION_NAME_ENG ?></option>
                                        <?php }?>
                                    </select>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="col-md-1">
                                    <i class="fa fa-info-circle pointer2"
                                       data-content="Please Enter Local Guardian Occupation"
                                       data-placement="right" data-toggle="popover" data-container="body"
                                       data-original-title="" title="Help"></i>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="clearfix"></div>

                    <br>
                    <hr>
                    <h4 style="color:green">Admission Test Info</h4>
                    <div class="div-background">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-5 control-label">Registration No: <span class="red">*</span></label>

                                <div class="col-md-5">
                                    <input onkeyup="validate_regi_no();" type="text" name="REGISTRATION_SL" id="REGISTRATION_SL" value="<?php echo set_value('REGISTRATION_SL'); ?>" class="form-control" placeholder="Registration No." >
                                    <span class="red"><?php echo form_error('REGISTRATION_SL'); ?></span>
                                </div>
                                <div class="col-md-2">
                                    <i class="fa fa-info-circle pointer2"
                                       data-content="Please enter your Registration no. here" data-placement="right"
                                       data-toggle="popover" data-container="body" data-original-title=""
                                       title="Help"></i>
                                </div>
                            </div>

                            <div class="form-group">
                                <label  for="COLLEGE_CODE" class="col-md-5 control-label">College Code:<span class="red">*</span></label>

                                <div class="col-md-5">
                                    <input type="text" name="COLLEGE_CODE" id="COLLEGE_CODE"
                                           value="<?php echo set_value('COLLEGE_CODE'); ?>"
                                           class="form-control" placeholder="College Code" >
                                    <span class="red"><?php echo form_error('COLLEGE_CODE'); ?></span>
                                </div>
                                <div class="col-md-2">
                                    <i class="fa fa-info-circle pointer2" data-content="Please enter college code here"
                                       data-placement="right" data-toggle="popover" data-container="body"
                                       data-original-title="" title="Help"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  for="COLLEGE_CODE" class="col-md-5 control-label">College Code:<span class="red">*</span></label>

                                <div class="col-md-5">
                                    <input type="text" name="COLLEGE_CODE" id="COLLEGE_CODE"
                                           value="<?php echo set_value('COLLEGE_CODE'); ?>"
                                           class="form-control" placeholder="College Code" >
                                    <span class="red"><?php echo form_error('COLLEGE_CODE'); ?></span>
                                </div>
                                <div class="col-md-2">
                                    <i class="fa fa-info-circle pointer2" data-content="Please enter college code here"
                                       data-placement="right" data-toggle="popover" data-container="body"
                                       data-original-title="" title="Help"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-5 control-label">Roll No:<span class="red">*</span></label>

                                <div class="col-md-5">
                                    <input type="text" name="ADM_TEST_ROLL" id="ADM_TEST_ROLL" value="<?php echo set_value('ADM_TEST_ROLL'); ?>"
                                           class="form-control" placeholder="Roll No" >
                                    <span class="red"><?php echo form_error('ADM_TEST_ROLL'); ?></span>
                                </div>
                                <div class="col-md-2">
                                    <i class="fa fa-info-circle pointer2"
                                       data-content="Please enter your roll no. of admission test" data-placement="right"
                                       data-toggle="popover" data-container="body" data-original-title=""
                                       title="Help"></i>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="MERIT_POSITION" class="col-md-5 control-label">Merit Position:<span class="red">*</span></label>
                                <div class="col-md-5">
                                    <input type="text" name="MERIT_POSITION" id="MERIT_POSITION"
                                           value="<?php echo set_value('MERIT_POSITION'); ?>"
                                           class="form-control" placeholder="Merit Position" >
                                    <span class="red"><?php echo form_error('MERIT_POSITION'); ?></span>
                                </div>
                                <div class="col-md-2">
                                    <i class="fa fa-info-circle pointer2" data-content="Merit Position"
                                       data-placement="right" data-toggle="popover" data-container="body"
                                       data-original-title="" title="Help"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="TEST_SCORE" class="col-md-5 control-label">Test Score:<span class="red">*</span></label>

                                <div class="col-md-5">
                                    <input type="text" name="TEST_SCORE" id="TEST_SCORE"
                                           value="<?php echo set_value('TEST_SCORE'); ?>"
                                           class="form-control" placeholder="Test Score" >
                                    <span class="red"><?php echo form_error('TEST_SCORE'); ?></span>
                                </div>
                                <div class="col-md-2">
                                    <i class="fa fa-info-circle pointer2" data-content="Test Score"
                                       data-placement="right" data-toggle="popover" data-container="body"
                                       data-original-title="" title="Help"></i>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>


                    <br><hr>
                    <h4 style="color: green">Academic Information</h4>

                    <div class="div-background">
                        <div class="form-group">
                            <div class="col-md-12">
                                <table id="academic_list" class="table table-bordered dataTable">
                                    <thead>
                                    <tr>
                                        <th width="2%">SL No.</th>
                                        <th width="15%">Exam Name</th>
                                        <th width="8%">Year</th>
                                        <th width="15%">Board</th>
                                        <th width="15%">Group</th>
                                        <th width="5%">GPA</th>
                                        <th width="25%">Institute Name</th>
                                        <th width="15%" colspan="2">Docs Upload</th>
                                    </tr>
                                    </thead>
                                    <tbody id="edu_qua_tbl_bdy">
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            <select name="EXAM_NAME[]" id="EXAM_NAME" data-placeholder="Choose One..." class="chosen-select form-control" tabindex="2">
                                                <option selected="selected" disabled="disabled" value="">Select Exam Name</option>
                                                <?php foreach($NM_EXAM as $ky=>$row) {?>
                                                    <option value="<?php echo $row->EXAM_ID; ?>"><?php echo $row->EXAM_NAME; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td><input class="form-control" type="text" name="PASSING_YEAR[]" required="required"></td>
                                        <td>
                                            <select name="BOARD[]" id="BOARD" data-placeholder="Choose One..." class="chosen-select form-control" tabindex="2">
                                                <option selected="selected" disabled="disabled" value="">Select Board</option>
                                                <?php foreach($NM_BOARD as $ky=>$row) {?>
                                                    <option value="<?php echo $row->BOARD_ID; ?>"><?php echo $row->BOARD_NAME; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="GROUP[]" id="GROUP" data-placeholder="Choose One..." class="chosen-select form-control" tabindex="2">
                                                <option selected="selected" disabled="disabled" value="">Select Group</option>
                                                <?php foreach($NM_EXAMGROUP as $ky=>$row) {?>
                                                    <option value="<?php echo $row->EXAMGROUP_ID; ?>"><?php echo $row->EXAMGROUP_NAME; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td><input class="form-control" type="text" name="GPA[]" required="required"></td>
                                        <td><input class="form-control" type="text" name="INSTITUTE[]" required="required"></td>
                                        <td><input class="form-control" type="text" name="INSTITUTE[]" required="required"></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <button type="button" id="add_edu_qua" class="btn btn-primary pull-right"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <br><br>

                    <div class="form-group">
                        <div class="col-sm-3  pull-right">

                            <a href="#" class="btn btn-info" id="admission_form_btn">Next</a>
                            <!-- <input type="submit" class="btn btn-white" value="submit"> -->
                            <input type="reset" class="btn btn-white" value="Reset">
                        </div>
                    </div>
                    <!-- Modal -->
                    <div id="admissionModal" class="modal fade" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">×</button>
                                    <h3>My Profile</h3>
                                </div>
                                <div class="modal-body">
                                    <?php $this->load->view('applicant/admission_preview'); ?>
                                </div>
                                <div class="modal-footer">
                                    <a href="#" class="btn" data-dismiss="modal">Back</a>
                                    <input type="submit" class="btn btn-primary" id="admission_form_submit" value="Submit">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- test -->

                </div>

            </div>
        </form>
    </div>


    <!-- The file upload form used as target for the file upload widget -->
    <form id="fileupload" action="<?php echo base_url(); ?>upload/applicant/doc_upload/" method="POST" enctype="multipart/form-data">
        <!-- Redirect browsers with JavaScript disabled to the origin page -->
        <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="col-lg-7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Add files...</span>
                    <input type="file" name="files[]" multiple>
                </span>
                <!-- The global file processing state -->
                <span class="fileupload-process"></span>
            </div>
            <!-- The global progress state -->
            <div class="col-lg-5 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
                <!-- The extended global progress state -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
    </form>

    <!--Start Jquery file upload url-->
    <script>
        $(document).ready(function () {
            $('#fileupload').fileupload({
                // Uncomment the following to send cross-domain cookies:
                //xhrFields: {withCredentials: true},
                url: '<?php echo base_url(); ?>upload/applicant/doc_upload/server/php/'
            });
        });
    </script>
    <!--End Jquery file upload url-->


    <!-- The blueimp Gallery widget -->
    <!--<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
        <div class="slides"></div>
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
    </div>-->

</div>

<!--<script src="<?php //echo base_url();                                                                                                                                         ?>assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>-->

<script src="<?php echo base_url(); ?>assets/js/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>assets/keyboard/keyboard.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
<script>
    $.validator.addMethod("isNIDValid", function(value) {
        var NidValid = false;
        var UserNID = value;
        if (UserNID.length == 0 || UserNID.length == 13 || UserNID.length == 17)
        {
            NidValid = true;
        }
        return NidValid;
    }, 'National ID Not Valid');
    $.validator.addMethod("isMoblieValid", function(value) {
        var MobileValid = false;
        var UserMobile = value;
        if (UserMobile.length == 0 || UserMobile.length == 11)
        {
            MobileValid = true;
        }
        return MobileValid;
    }, 'Mobile number not valid');

    $.validator.addMethod('filesize', function (value, element, param) {

        return this.optional(element) || (element.files[0].size <= param)
    }, 'File size must be less than {0}');


    $("#admission_form").validate({
        rules: {
            FULL_NAME: {required:true},
            EMAIL: {required:true,email: true},
            MOBILE_NO: {required:true},
            DATE_OF_BIRTH: {required:true},
            FULL_NAME_BN: {required:true},
            NATIONALITY: {required:true},
            RELIGION_ID: {required:true},
            MARITAL_STATUS: {required:true},
            FATHER_NAME: {required:true},
            MOTHER_NAME: {required:true},
            FATHER_EMAIL: {email: true},
            MOTHER_EMAIL: {email: true},
            PLACE_OF_BIRTH: {required:true},
            NATIONAL_ID: {number:true, isNIDValid:true},
            BIRTH_CERTIFICATE: {number:true},
            HEIGHT_FEET: {number:true},
            WEIGHT_KG: {number:true},
            FATHER_PHN: {number:true,isMoblieValid:true},
            MOTHER_PHN: {number:true,isMoblieValid:true},
            LOCAL_GAR_PHN: {number:true,isMoblieValid:true},
            MARITAL_STATUS: {required:true},
            LOCAL_GAR_DISTRICT_ID: {required:true},
            LOCAL_GAR_THANA_ID: {required:true},
            LOCAL_GAR_POST_OFFICE_ID: {required:true},
            LOCAL_GAR_VILLAGE: {required:true},
            REGISTRATION_SL: {required:true},
            COLLEGE_CODE: {required:true},
            ADM_TEST_ROLL: {required:true},
            MERIT_POSITION: {required:true},
            ANNUAL_INCOME: {number:true,required:true},
            DIVISION_ID: {required:true},
            DISTRICT_ID: {required:true},
            THANA_ID: {required:true},
            POLICE_STATION_ID: {required:true},
            UNION_ID: {required:true},
            VILLAGE: {required:true},
            P_DIVISION_ID: {required:true},
            P_DISTRICT_ID: {required:true},
            P_THANA_ID: {required:true},
            P_POLICE_STATION_ID: {required:true},
            P_UNION_ID: {required:true},
            P_VILLAGE: {required:true},
            SCHOLARSHIP_DESC: {required:true},
            EXPELLED_DESC: {required:true},
            ARRESTED_DESC: {required:true},
            CONVICTED_DESC: {required:true},
            APPLY_SEMESTER: {required:true},
            APPLY_YEAR: {number:true,required:true},
            SBLN_ROLL_NO: {number:true,required:true},


            /*'EXAM_NAME[1]': {required:true},
            'PASSING_YEAR[1]': {number:true,required:true,maxlength: 4,minlength: 4},
            'BOARD[1]': {required:true},
            'GROUP[1]': {required:true},
            'GPA[1]': {number:true,required:true},
            'GPAWA[1]': {number:true,required:true},
            'INSTITUTE[1]': {required:true}*/

        },
        messages: {
            FULL_NAME_BN: "Bangla name required",
            NATIONALITY: "Nationality required",
            RELIGION_ID: "Religion required",
            MARITAL_STATUS: "Marital status required",
            FATHER_NAME: "Father name required",
            MOTHER_NAME: "Mother name required",
            PLACE_OF_BIRTH: "Place of birth field is required",
            NATIONAL_ID: "Required valid national ID",
            BIRTH_CERTIFICATE: "Required valid birth certificate no",
            MARITAL_STATUS: "Marital status required",
            HEIGHT_FEET: "Number only",
            WEIGHT_KG: "Number only",
        }
    });

    /*    $("#admission_form").validate({debug: true});
    $("#admission_form").valid();*/

    $('#admission_form_submit').on('click', function (e) {
        $("#admission_form").submit();
        $('#admissionModal').modal('hide');
    });

    $('#admission_form_btn').on('click',function(){

        var QUOTA_ID = $('#QUOTA_ID').val();
        if(!QUOTA_ID){
            alert('Please select Quota');
            return false;
        }

        var DEGREE_ID = $('#DEGREE_ID').val();
        if(!DEGREE_ID){
            alert('Please select Course Name');
            return false;
        }

        if($("#admission_form").valid()) {
            //personal information

            $("#P_FULL_NAME").text($("#FULL_NAME").val());
            $("#P_MOBILE_NO").text($("#MOBILE_NO").val());
            $("#P_EMAIL").text($("#EMAIL").val());

            //fix
            var DATE_OF_BIRTH = $("#DATE_OF_BIRTH").val();
            $("#P_DATE_OF_BIRTH").text(DATE_OF_BIRTH);

            $("#P_FULL_NAME_BN").text($("#FULL_NAME_BN").val());
            $("#P_PLACE_OF_BIRTH").text($("#PLACE_OF_BIRTH").val());
            //$("#P_GENDER").text($('input[name=GENDER]:checked').val());
            $("#P_GENDER").text($("input[name=GENDER]:checked").attr("data-value"));

            //fix
            var blood_group = $("#BLOOD_GRP").val();
            $("#P_BLOOD_GROUP").text(blood_group);

            var program_id = $("#PROGRAM_ID").val() == "-Select-" ? '' : $("#PROGRAM_ID").val();
            $("#P_PROGRAM_ID").text(program_id);

            //fix
            var marital_status = $("#MARITAL_STATUS").val();
            $("#P_MARITAL_STATUS").text(marital_status);

            //fix
            var religion = $("#RELIGION_ID").val();
            $("#P_RELIGION_ID").text(religion);

            $("#P_BIRTH_CERTIFICATE").text($("#BIRTH_CERTIFICATE").val());

            //fix
            var NATIONALITY = $("#NATIONALITY").val();
            $("#P_NATIONALITY").text(NATIONALITY);

            $("#P_HEIGHT_FEET").text($("#HEIGHT_FEET").val());
            $("#P_HEIGHT_CM").text($("#HEIGHT_CM").val());
            $("#P_WEIGHT_KG").text($("#WEIGHT_KG").val());
            $("#P_WEIGHT_LBS").text($("#WEIGHT_LBS").val());


            //parents information
            $("#P_MOTHER_NAME").text($("#MOTHER_NAME").val());
            $("#P_MOTHER_PHN").text($("#MOTHER_PHN").val());
            $("#P_MOTHER_EMAIL").text($("#MOTHER_EMAIL").val());
            //fix
            var MOTHER_WORK_ADDRESS = $("#MOTHER_WORK_ADDRESS").val();
            $("#P_MOTHER_WORK_ADDRESS").text(MOTHER_WORK_ADDRESS);

            //fix
            var mother_ocu = $("#MOTHER_OCU").val();
            $("#P_MOTHER_OCU").text(mother_ocu);

            $("#P_FATHER_NAME").text($("#FATHER_NAME").val());
            $("#P_FATHER_PHN").text($("#FATHER_PHN").val());
            $("#P_FATHER_EMAIL").text($("#FATHER_EMAIL").val());

            //fix
            var FATHER_WORK_ADRESS = $("#FATHER_WORK_ADRESS").val();
            $("#P_FATHER_WORK_ADRESS").text(FATHER_WORK_ADRESS);

            //fix
            var father_ocu = $("#FATHER_OCU").val();
            $("#P_FATHER_OCU").text(father_ocu);

            var REGISTRATION_SL = $("#REGISTRATION_SL").val();
            $("#P_REGISTRATION_SL").text(REGISTRATION_SL);
            var COLLEGE_CODE = $("#COLLEGE_CODE").val();
            $("#P_COLLEGE_CODE").text(COLLEGE_CODE);
            var ADM_TEST_ROLL = $("#ADM_TEST_ROLL").val();
            $("#P_ADM_TEST_ROLL").text(ADM_TEST_ROLL);
            var MERIT_POSITION = $("#MERIT_POSITION").val();
            $("#P_MERIT_POSITION").text(MERIT_POSITION);

            //local guardian
            var local_emergency_guardian=$('input[name=local_emergency_guardian]:checked', '#admission_form').val();

            //fix
            var DEGREE_ID = $("#DEGREE_ID option:selected").text() == "Select a Course" ? '' : $("#DEGREE_ID option:selected").text();
            $("#P_DEGREE_ID").text(DEGREE_ID);

            if(local_emergency_guardian == 'F'){
                $("#local_guardian_div").show();
                $("#local_guardian_val").html("Father");
                $("#others_gurdian_info").hide();
            }

            if(local_emergency_guardian == 'M'){
                $("#local_guardian_div").show();
                $("#local_guardian_val").html(" Mother");
                $("#others_gurdian_info").hide();
            }

            if(local_emergency_guardian == 'O'){
                $("#others_gurdian_info").show();
                $("#local_guardian_div").hide();


                $("#P_LOCAL_GAR_NAME").text($("#LOCAL_GAR_NAME").val());
                $("#P_LG_OCCU_ID").text($("#LG_OCCU_ID").val());
                //$("#P_LOCAL_GAR_ADDRESS").text($("#LOCAL_GAR_ADDRESS").val());
                $("#P_LOCAL_GAR_PHN").text($("#LOCAL_GAR_PHN").val());
                $("#P_LOCAL_GAR_RELATION").text($("#LOCAL_GAR_RELATION").val());

                $("#P_LOCAL_GAR_DISTRICT_ID").text($("#LOCAL_GAR_DISTRICT_ID").val());
                $("#P_LOCAL_GAR_THANA_ID").text($("#LOCAL_GAR_THANA_ID").val());
                $("#P_LOCAL_GAR_POST_OFFICE_ID").text($("#LOCAL_GAR_POST_OFFICE_ID").val());
                $("#P_LOCAL_GAR_VILLAGE").text($("#LOCAL_GAR_VILLAGE").val());
            }

            //present address
            $("#Pr_DIVISION_ID").text($("#DIVISION_ID").val());
            $("#Pr_DISTRICT_ID").text($("#DISTRICT_ID").val());
            $("#Pr_POLICE_STATION_ID").text($("#POLICE_STATION_ID").val());
            $("#Pr_POST_OFFICE_ID").text($("#POST_OFFICE_ID").val());
            $("#Pr_THANA_ID").text($("#THANA_ID").val());
            $("#Pr_UNION_ID").text($("#UNION_ID").val());
            $("#Pr_VILLAGE_WARD").text($("#VILLAGE").val());

            var same_as_present=$('input[name=same_as_present]:checked', '#admission_form').val()

            if(same_as_present =='NO'){
                //permanent address
                $("#Pr_P_DIVISION_ID").text($("#P_DIVISION_ID").val());
                $("#Pr_P_DISTRICT_ID").text($("#P_DISTRICT_ID").val());
                $("#Pr_P_POLICE_STATION_ID").text($("#P_POLICE_STATION_ID").val());
                $("#Pr_P_POST_OFFICE_ID").text($("#P_POST_OFFICE_ID").val());
                $("#Pr_P_THANA_ID").text($("#P_THANA_ID").val());
                $("#Pr_P_UNION_ID").text($("#P_UNION_ID").val());
                $("#Pr_P_VILLAGE_WARD").text($("#P_VILLAGE").val());
            }else{
                $("#Pr_P_DIVISION_ID").text($("#DIVISION_ID").val());
                $("#Pr_P_DISTRICT_ID").text($("#DISTRICT_ID").val());
                $("#Pr_P_POLICE_STATION_ID").text($("#POLICE_STATION_ID").val());
                $("#Pr_P_POST_OFFICE_ID").text($("#POST_OFFICE_ID").val());
                $("#Pr_P_THANA_ID").text($("#THANA_ID").val());
                $("#Pr_P_UNION_ID").text($("#UNION_ID").val());
                $("#Pr_P_VILLAGE_WARD").text($("#VILLAGE").val());
            }


            //academic information
            $("#P_EXAM_NAME_S").text($("#EXAM_NAME_S").val());
            $("#P_PASSING_YEAR_S").text($("#PASSING_YEAR_S").val());
            $("#P_BOARD_S").text($("#BOARD_S").val());
            $("#P_GROUP_S").text($("#GROUP_S").val());
            $("#P_GPA_S").text($("#GPA_S").val());
            $("#P_GPAWA_S").text($("#GPAWA_S").val());
            $("#P_INSTITUTE_S").text($("#INSTITUTE_S").val());

            $("#P_EXAM_NAME_H").text($("#EXAM_NAME_H").val());
            $("#P_PASSING_YEAR_H").text($("#PASSING_YEAR_H").val());
            $("#P_BOARD_H").text($("#BOARD_H").val());
            $("#P_GROUP_H").text($("#GROUP_H").val());
            $("#P_GPA_H").text($("#GPA_H").val());
            $("#P_GPAWA_H").text($("#GPAWA_H").val());
            $("#P_INSTITUTE_H").text($("#INSTITUTE_H").val());

            $("#P_EXAM_NAME_G").text($("#EXAM_NAME_G").val());
            $("#P_PASSING_YEAR_G").text($("#PASSING_YEAR_G").val());
            $("#P_BOARD_G").text($("#BOARD_G").val());
            $("#P_GROUP_G").text($("#GROUP_G").val());
            $("#P_GPA_G").text($("#GPA_G").val());
            $("#P_GPAWA_G").text($("#GPAWA_G").val());
            $("#P_INSTITUTE_G").text($("#INSTITUTE_G").val());

            //others information
            $("#P_ANNUAL_INCOME").text($("#ANNUAL_INCOME").val());
            $("#P_SCHOLARSHIP").text($("input[name='SCHOLARSHIP']:checked").val());
            $("#P_SCHOLARSHIP_DESC").text($("#SCHOLARSHIP_DESC").val());
            $("#P_EXPELLED").text($("input[name='EXPELLED']:checked").val());
            $("#P_EXPELLED_DESC").text($("#EXPELLED_DESC").val());
            $("#P_ARRESTED").text($("input[name='ARRESTED']:checked").val());
            $("#P_ARRESTED_DESC").text($("#ARRESTED_DESC").val());
            $("#P_CONVICTED").text($("input[name='CONVICTED']:checked").val());
            $("#P_CONVICTED_DESC").text($("#CONVICTED_DESC").val());
            $("#P_APPLY_BEFORE").text($("input[name='APPLY_BEFORE']:checked").val());
            $("#P_APPLY_SEMESTER").text($("#APPLY_SEMESTER").val());
            $("#P_APPLY_YEAR").text($("#APPLY_YEAR").val());
            $("#P_SIBLING_EXIST").text($("input[name='SIBLING_EXIST']:checked").val());
            $("#P_SBLN_ROLL_NO").text($("#SBLN_ROLL_NO").val());

            //Education Qualification preview
            var edu_qua_tr = [];
            $("#edu_qua_tbl_bdy tr").each(function (index, element){
                var edu_qua_td = [];
                $(this).find('td').each(function (index, element){

                    if($(this).find('select,input'))
                    {
                        if($(this).find('select :selected').text())
                        {
                            edu_qua_td.push('<td>' + $(this).find('select option:selected').text() + '</td>');
                        }
                        else if($(this).find('input').val())
                        {
                            edu_qua_td.push('<td>' + $(this).find('input').val() + '</td>');
                        }

                    }


                });

                edu_qua_td = edu_qua_td.join(' ');
                edu_qua_tr.push('<tr>'+ edu_qua_td +'</tr>');

            });

            var edu_qua_trs = edu_qua_tr.join(' ');
            $('#edu_qua_prev').html(edu_qua_trs);
            //End education Qualification preview


            $('#admissionModal').modal({
                show: true
            });

        }else{

        }
    });

    //End Validate

    //This function  is use for student image preview before upload
    function upload_img(input) {
        var fileTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (input.files && input.files[0]) {
            var extension = input.files[0].name.split('.').pop().toLowerCase(),  //file extension from input file
                isSuccess = fileTypes.indexOf(extension) > -1;
            //var fsize = $('#propic')[0].files[0].size;

            var sizeInKB = (input.files[0].size)/1024; //Normally files are in bytes but for KB divide by 1024
            var sizeLimit= 30;

            if (sizeInKB >= sizeLimit) {
                alert("Max file size 30KB");
                isSuccess = false;
                $('#img_id').attr('src', '');
                $('#p_img_id').attr('src', '');
                $('#propic').val('');
                return false;
            }


            if (isSuccess) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var image = new Image();
                    image.src = reader.result;

                    image.onload = function () {

                        $('#img_id').attr('src', e.target.result);
                        $('#p_img_id').attr('src', e.target.result);


                    };
                }
                reader.readAsDataURL(input.files[0]);
            }else{
                alert("This file type does not support");
            }
        }
    }

    //This function  is use for student image preview before upload
    function upload_img_sig(input) {
        var fileTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (input.files && input.files[0]) {
            var extension = input.files[0].name.split('.').pop().toLowerCase(),  //file extension from input file
                isSuccess = fileTypes.indexOf(extension) > -1;
            //var fsize = $('#sigpic')[0].files[0].size;

            var sizeInKB = (input.files[0].size)/1024; //Normally files are in bytes but for KB divide by 1024
            var sizeLimit= 10;

            if (sizeInKB >= sizeLimit) {
                alert("Max file size 10KB");
                isSuccess = false;
                $('#sig_id').attr('src', '');
                $('#p_sig_id').attr('src', '');
                $('#sigpic').val('');
                return false;
            }

            if (isSuccess) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var image = new Image();
                    image.src = reader.result;

                    image.onload = function () {

                        $('#sig_id').attr('src', e.target.result);
                        $('#p_sig_id').attr('src', e.target.result);

                    };
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                alert("This file type does not support");
            }
        }
    }

    $(document).on("click", ".same_as_present", function () {
        var same_as_present = $('input[name=same_as_present]:checked').val();

        if(same_as_present == 'YES'){
            $('#permanent_address').find('input, textarea, button, select').attr('disabled',true);
            $('#permanent_address').find('select').val('');
            $('#permanent_address').find('input').val('');
        }else{
            $('#permanent_address').find('input, textarea, button, select').attr('disabled',false);
        }

    });

    $(document).on("click", ".local_emergency_guardian", function () {
        var is_local = $(this).val();
        if (is_local == 'O') {
            $('#local_guardian').show();
            $('#finance_guardian').show();
        } else {
            $('#local_guardian').hide();
            $('#finance_guardian').hide();
        }
    });
    $(document).on('click', '#siblin', function () {
        if ($('input[name="SIBLING_EXIST"]:checked').val() == "YES") {
            $('.sibId').show();
        } else {
            $('.sibId').hide();
        }
    });
    $(document).on('click', '#scholarship_id', function () {
        if ($('input[name="SCHOLARSHIP"]:checked').val() == "YES") {
            $('.scholarships').show();
        } else {
            $('.scholarships').hide();
        }
    });
    $(document).on('click', '#expelled_id', function () {
        if ($('input[name="EXPELLED"]:checked').val() == "YES") {
            $('.expelled_div').show();
        } else {
            $('.expelled_div').hide();
        }
    });
    $(document).on('click', '#arrested_id', function () {
        if ($('input[name="ARRESTED"]:checked').val() == "YES") {
            $('.arrested_div').show();
        } else {
            $('.arrested_div').hide();
        }
    });
    $(document).on('click', '#convicted_id', function () {
        if ($('input[name="CONVICTED"]:checked').val() == "YES") {
            $('.convicted_div').show();
        } else {
            $('.convicted_div').hide();
        }
    });
    $(document).on('click', '#apply_before_id', function () {
        if ($('input[name="APPLY_BEFORE"]:checked').val() == "YES") {
            $('.apply_before_div').show();
        } else {
            $('.apply_before_div').hide();
        }
    });

    $('#WEIGHT_KG').on('blur', function () {
        var pound = parseFloat("2.20462");
        var total = ($(this).val() * pound);
        var n = total.toFixed(2);
        $("#WEIGHT_LBS").val(n);

    });
    $('#WEIGHT_LBS').on('blur', function () {
        var kg = parseFloat("0.453592");
        var total = ($(this).val() * kg);
        var n = total.toFixed(2);
        $("#WEIGHT_KG").val(n)
    });
    $('#HEIGHT_FEET').on('blur', function () {
        var cm = parseFloat("30.48");
        var total = ($(this).val() * cm);
        var n = total.toFixed(2);
        $("#HEIGHT_CM").val(n);

    });
    $('#HEIGHT_CM').on('blur', function () {
        var ft = parseFloat("0.0328084");
        var total = ($(this).val() * ft);
        var n = total.toFixed(2);
        $("#HEIGHT_FEET").val(n)
    });
    $( function() {
        $( ".datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd-mm-yy' ,
            yearRange: '1980:2000'
        });
    });


    //Avater upload
    $(".overlay-layer, #img_id").click(function() {
        $("#propic").click();
    });

    //Signature Upload
    $("#sig_id").click(function() {
        $("#sigpic").click();
    });


    //New row add for education qualification
    var count = 1;
    $('#add_edu_qua').click(function(){
        count = count + 1;

        let sl = 1;
        sl = $('#edu_qua_tbl_bdy tr').length;

        var html_code = "<tr id='row"+count+"'>";
        html_code +="<td>"+ ++sl +"</td>";
        //html_code +='<td><input class="form-control" type="text" name="EXAM_NAME[row'+count+']" required="required"></td>';
        html_code +="<td>" +
            "<select name='EXAM_NAME[row"+count+"]' data-placeholder='Choose One...' class='chosen-select form-control' tabindex='2'>"+
            "<option selected='selected' disabled='disabled' value=''>Select Exam Name</option>"+
            "<?php foreach($NM_EXAM as $ky=>$row) {
                echo '<option value=\"'.$row->EXAM_ID. '\">' . $row->EXAM_NAME . '</option>';
            } ?>"+
            "</select>"+
            "</td>";
        html_code +='<td><input class="form-control" type="text" name="PASSING_YEAR[row'+count+']" required="required"></td>';
        //html_code +='<td><input class="form-control" type="text" name="BOARD[row'+count+']" required="required"></td>';
        html_code +="<td>" +
            "<select name='BOARD[row"+count+"]' data-placeholder='Choose One...' class='chosen-select form-control' tabindex='2'>"+
            "<option selected='selected' disabled='disabled' value=''>Select Board Name</option>"+
            "<?php foreach($NM_BOARD as $ky=>$row) {
                echo '<option value='."$row->BOARD_ID". '>' . $row->BOARD_NAME . '</option>';
            } ?>"+
            "</select>"+
            "</td>";
        //html_code +='<td><input class="form-control" type="text" name="GROUP[row'+count+']" required="required"></td>';
        html_code +="<td>" +
            "<select name='GROUP[row"+count+"]' data-placeholder='Choose One...' class='chosen-select form-control' tabindex='2'>"+
            "<option selected='selected' disabled='disabled' value=''>Select Group</option>"+
            "<?php foreach($NM_EXAMGROUP as $ky=>$row) {
                echo '<option value='."$row->EXAMGROUP_ID". '>' . $row->EXAMGROUP_NAME . '</option>';
            } ?>"+
            "</select>"+
            "</td>";
        html_code +='<td><input class="form-control" type="text" name="GPA[row'+count+']" required="required"></td>';
        html_code +='<td><input class="form-control" type="text" name="INSTITUTE[row'+count+']" required="required"></td>';
        html_code +='<td><button type="button" data-row="row'+count+'" class="btn btn-danger btn-xs remove_row pull-right"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>';
        html_code +='</tr>';
        $('#edu_qua_tbl_bdy').append(html_code);


        var config = {
            '.chosen-select'           : {allow_single_deselect:true},
            '.chosen-select-deselect'  : {allow_single_deselect:true},
            '.chosen-select-no-single' : {disable_search_threshold:10},
            '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
            '.chosen-select-width'     : {width:"95%"}
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }

    });

    $(document).on('click','.remove_row',function(){
        var delete_row = $(this).data("row");
        $('#' + delete_row).remove();
    });


    $(document).ready(function () {
        $('#LG_OCCU_ID_chosen').css('width','100%');
    });

    function search_student()
    {
        console.log('works');

        var std_no = $('#roll_reg_no').val();

        $.ajax({

            type: "POST",
            url: "<?=base_url();?>admission/search_student_data",
            data:  {std_no:std_no},
            success: function (data)
            {
                if(data)
                {
                    alert(data);

                }
            }
        });
    }

    function validate_regi_no()
    {
        var dt = "Regi";
        var std_no = $('#REGISTRATION_SL').val();

        $.ajax({

            type: "POST",
            url: "<?=base_url();?>admission/validate_data",
            data:  {std_no:std_no,dt: dt},
            success: function (data)
            {
                if(data)
                {
                    alert(data);

                }
            }
        });
    }

    function validate_roll_no()
    {
        var dt = "Roll";
        var std_no = $('#ADM_TEST_ROLL').val();

        $.ajax({

            type: "POST",
            url: "<?=base_url();?>admission/validate_data",
            data:  {std_no:std_no, dt: dt},
            success: function (data)
            {
                if(data)
                {
                    alert(data);

                }
            }
        });
    }

</script>

<!--Start Jquery file upload url-->
<script>
    $(document).ready(function () {
        $('#fileupload').fileupload({
            dataType: 'json',
            url: '<?php echo base_url(); ?>assets/doc_upload/server/php/',
            add: function (e, data) {
                var count = data.files.length;
                var i;
                for (i = 0; i < count; i++) {
                    data.files[i].uploadName =
                        Math.floor(Math.random() * 1000) + '_' + data.files[i].name;
                }
                data.submit();
            }
        });

    });

</script>
<!--End Jquery file upload url-->