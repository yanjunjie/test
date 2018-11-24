
        <div class="personal-info-section">
            <div class="col-md-12" >
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div style="float: left;" class="profile_title"><h3 class="panel-title">Profile</h3></div>
                        <div style="float: right;">
                            <a href="<?php echo base_url();?>applicant/update_applicant" title="Update Personal Info" class="btn btn-success btn-xs" > <i class="fa fa-edit"></i> Edit </a><button style="margin-left: 3px;" title="Print" class="btn btn-success btn-xs print" ><i class="fa fa-print"></i> Print </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div id="printablediv" class="panel-body">
                        <style>
                            @media print {
                                .page-break {
                                    page-break-before: always;
                                    float:none !important;
                                }

                                .display_none{
                                    display: none;
                                }

                                .profile-thumb{-webkit-border-radius: 0 !important; border-radius: 0 !important; !important; max-height: 130px !important; max-width: 130px !important; margin: 0 auto 20px !important;}

                                .profile-thumb img{ -webkit-border-radius: 0 !important; border-radius: 0 !important; background-color: transparent !important; }
                            }
                        </style>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="profile_sec_title">
                                    <h3>Personal Info</h3>
                                </div>

                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <td>Full Name: </td>
                                        <td> <?php echo isset($applicantData[0]->FULL_NAME_ENG)?$applicantData[0]->FULL_NAME_ENG:''; ?></td>
                                        <td rowspan="11">
                                            <div class="profile-thumb">
                                                <?php if(isset($applicantData[0]->APPLICANT_PHOTO_PATH)) : ?>
                                                    <img class="img-circle img-responsive" id="img_id" src="<?php echo base_url().'upload/applicant/photo/' . $applicantData[0]->APPLICANT_PHOTO_PATH; ?>" alt="select photo"  style="width: 150px;"/>
                                                <?php else: ?>
                                                    <img class="img-circle img-responsive" id="img_id" src="<?php echo base_url('upload/default/default_pic.png'); ?>" alt="select photo"  style="width: 150px;"/>
                                                <?php endif; ?>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="signature text-center">
                                                <div class="sig-img" style="margin-top: 5px;">
                                                    <?php if(isset($applicantData[0]->APPLICANT_SIGN_PATH)) : ?>
                                                        <img id="sig_id" src="<?php echo base_url().'upload/applicant/signature/' . $applicantData[0]->APPLICANT_SIGN_PATH; ?>" alt="select photo"  style="width: 80px;"/>
                                                    <?php else: ?>
                                                        <img id="sig_id" src="<?php echo base_url('upload/default/default_sign.png'); ?>" alt="select photo"  style="width: 80px;"/>
                                                    <?php endif; ?>
                                                </div>

                                                <div class="date" style="margin-top: 5px;">
                                                    <b>Signature Date</b>: <p><?php echo isset($applicantData[0]->APPLICANT_SIGN_DATE)?date("d-m-Y", strtotime($applicantData[0]->APPLICANT_SIGN_DATE)):''; ?></p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>নাম ( বাংলা ) : </td>
                                        <td><?php echo isset($applicantData[0]->FULL_NAME_BNG)?$applicantData[0]->FULL_NAME_BNG:''; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Gender: </td>
                                        <td><?php if ($applicantData[0]->GENDER == 'O') echo 'Others'; else if ($applicantData[0]->GENDER == 'M') echo 'Male'; else echo 'Female'; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Course: </td>
                                        <td> <?php echo isset($applicantData[0]->COURSE_NAME)?$applicantData[0]->COURSE_NAME:''; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Mobile No: </td>
                                        <td> <?php echo isset($applicantData[0]->MOBILE_NUMBER)?$applicantData[0]->MOBILE_NUMBER:''; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Email: </td>
                                        <td> <?php echo isset($applicantData[0]->EMAIL_ADDRESS)?$applicantData[0]->EMAIL_ADDRESS:''; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Date of Birth: </td>
                                        <td> <?php echo isset($applicantData[0]->BIRTH_DATE)? date("d-m-Y", strtotime($applicantData[0]->BIRTH_DATE)):''; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Blood Group: </td>
                                        <td> <?php echo $applicantData[0]->BLOOD_GROUP ?></td>
                                    </tr>
                                    <tr>
                                        <td>Marital Status: </td>
                                        <td> <?php echo $applicantData[0]->MARITAL_STATUS ?></td>
                                    </tr>
                                    <tr>
                                        <td>Nationality: </td>
                                        <td> <?php echo isset($applicantData[0]->NATIONALITY)?$applicantData[0]->NATIONALITY:''; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Religion: </td>
                                        <td>  <?php echo isset($applicantData[0]->RELIGION_NAME)?$applicantData[0]->RELIGION_NAME:''; ?> </td>
                                    </tr>

                                    </tbody>
                                </table>
                                <div class="clearfix"></div>

                                <div class="profile_sec_title">
                                    <h3>Family Information</h3>
                                </div>

                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <td width="50%">
                                            <table class="table table-bordered">
                                                <tbody>
                                                <tr class="info">
                                                    <td colspan="2"><b>Father Info</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Father's Name: </td>
                                                    <td> <?php echo isset($applicantData[0]->FATHER_NAME_ENG)?$applicantData[0]->FATHER_NAME_ENG:''; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Father's Occupation : </td>
                                                    <td><?php echo isset($applicantData[0]->FATHER_OCCUPATION)?$applicantData[0]->FATHER_OCCUPATION:''; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Father's Mobile: </td>
                                                    <td><?php echo isset($applicantData[0]->FATHER_MOBILE)?$applicantData[0]->FATHER_MOBILE:''; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Father's Email: </td>
                                                    <td> <?php echo isset($applicantData[0]->FATHER_EMAIL)?$applicantData[0]->FATHER_EMAIL:''; ?></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>

                                        <td width="50%">
                                            <div>
                                                <table class="table table-bordered">
                                                    <tbody>
                                                    <tr class="info">
                                                        <td colspan="2"><b>Mother Info</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Mother's Name: </td>
                                                        <td> <?php echo isset($applicantData[0]->MOTHER_NAME_ENG)?$applicantData[0]->MOTHER_NAME_ENG:''; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Mother's Occupation : </td>
                                                        <td><?php echo isset($applicantData[0]->MOTHER_OCCUPATION)?$applicantData[0]->MOTHER_OCCUPATION:''; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Mother's Mobile: </td>
                                                        <td><?php echo isset($applicantData[0]->MOTHER_MOBILE)?$applicantData[0]->MOTHER_MOBILE:''; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Mother's Email: </td>
                                                        <td> <?php echo isset($applicantData[0]->MOTHER_EMAIL)?$applicantData[0]->MOTHER_EMAIL:''; ?></td>
                                                    </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                <div class="clearfix"></div>
                                <br>

                                <div class="profile_sec_title applicant_address page-break">
                                    <h3>Address</h3>
                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <td width="50%">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                    <tr class="info">
                                                        <td colspan="2"><b>Present Address</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td>District: </td>
                                                        <td> <?php echo isset($applicantData[0]->PRE_DISTRICT)?$applicantData[0]->PRE_DISTRICT:''; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Upazila/Thana : </td>
                                                        <td><?php echo isset($applicantData[0]->PRE_UPAZILLA)?$applicantData[0]->PRE_UPAZILLA:''; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Post office: </td>
                                                        <td><?php echo isset($applicantData[0]->PRE_POST_OFFICE)?$applicantData[0]->PRE_POST_OFFICE:''; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Vill/House no/Road no: </td>
                                                        <td> <?php echo isset($applicantData[0]->PRE_VILLAGE)?$applicantData[0]->PRE_VILLAGE:''; ?></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>

                                            <td width="50%">
                                                <div id="SAME_AS_PRESENT">
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                        <tr class="info">
                                                            <td colspan="2"><b>Permanent Address</b></td>
                                                        </tr>

                                                        <?php if ($applicantData[0]->ADDRESS_TYPE == 'NO'): ?>

                                                            <tr>
                                                                <td>District: </td>
                                                                <td> <?php echo isset($applicantData[0]->PER_DISTRICT)?$applicantData[0]->PER_DISTRICT:''; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Upazila/Thana : </td>
                                                                <td><?php echo isset($applicantData[0]->PER_UPAZILLA)?$applicantData[0]->PER_UPAZILLA:''; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Post office: </td>
                                                                <td><?php echo isset($applicantData[0]->PER_POST_OFFICE)?$applicantData[0]->PER_POST_OFFICE:''; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Vill/House no/Road no: </td>
                                                                <td> <?php echo isset($applicantData[0]->PER_VILLAGE)?$applicantData[0]->PER_VILLAGE:''; ?></td>
                                                            </tr>


                                                        <?php else: ?>

                                                            <tr>
                                                                <td colspan="2">
                                                                    <p style="margin-bottom: 20px;"><?php if ($applicantData[0]->ADDRESS_TYPE == 'YES') echo 'Same as present'; ?></p>
                                                                    <div class="clearfix"></div>
                                                                </td>
                                                            </tr>

                                                        <?php endif; ?>

                                                        </tbody>
                                                    </table>

                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="clearfix"></div>


                                <div class="profile_sec_title">
                                    <h3>Local Emergency Guardian</h3>
                                </div>

                                <?php if ($applicantData[0]->LOCAL_GUARDIAN_FG == 'O'): ?>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr class="info">
                                            <td>Guardian Name</td>
                                            <td>Guardian Relation</td>
                                            <td>Guardian Mobile</td>
                                            <td>Guardian Occupation</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td> <?php echo isset($applicantData[0]->LG_NAME)?$applicantData[0]->LG_NAME:''; ?></td>
                                            <td><?php if ($applicantData[0]->LOCAL_GUARDIAN_FG == 'O') echo 'Others'; ?></td>
                                            <td><?php echo isset($applicantData[0]->LG_MOBILE)?$applicantData[0]->LG_MOBILE:''; ?></td>
                                            <td> <?php echo isset($applicantData[0]->LG_OCCUPATION)?$applicantData[0]->LG_OCCUPATION:''; ?></td>
                                        </tr>
                                        </tbody>
                                    </table>

                                <?php else: ?>

                                    <p style="margin-bottom: 20px;"><?php if ($applicantData[0]->LOCAL_GUARDIAN_FG == 'F') echo 'Father'; else if ($applicantData[0]->LOCAL_GUARDIAN_FG == 'M') echo 'Mother'; ?></p>
                                    <div class="clearfix"></div>
                                <?php endif; ?>

                                <div class="clearfix"></div>

                                <div class="profile_sec_title">
                                    <h3>Admission Test</h3>
                                </div>

                                <table class="table table-bordered">
                                    <thead>
                                    <tr class="info">
                                        <td>Registration No</td>
                                        <td>Roll No</td>
                                        <td>College Code</td>
                                        <td>Merit Position</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td> <?php echo isset($applicantData[0]->REGISTRATION_NUMBER)?$applicantData[0]->REGISTRATION_NUMBER:''; ?></td>
                                        <td><?php echo isset($applicantData[0]->ROLL_NUMBER)?$applicantData[0]->ROLL_NUMBER:''; ?></td>
                                        <td><?php echo isset($applicantData[0]->COLLEGE_CODE)?$applicantData[0]->COLLEGE_CODE:''; ?></td>
                                        <td> <?php echo isset($applicantData[0]->MERIT_POSITION)?$applicantData[0]->MERIT_POSITION:''; ?></td>
                                    </tr>
                                    </tbody>
                                </table>

                                <div class="clearfix"></div>

                                <div class="profile_sec_title">
                                    <h3>Academic Information</h3>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr class="info">
                                            <td>Exam Name</td>
                                            <td>Year</td>
                                            <td>Board</td>
                                            <td>Group</td>
                                            <td>GPA</td>
                                            <td>Institute Name</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($applicantAcaData as $row): ?>
                                            <tr>
                                                <td> <?php echo isset($row->EXAM_NAME)?$row->EXAM_NAME:''; ?></td>
                                                <td> <?php echo isset($row->PASSING_YEAR)?$row->PASSING_YEAR:''; ?></td>
                                                <td> <?php echo isset($row->BOARD_NAME)?$row->BOARD_NAME:''; ?></td>
                                                <td> <?php echo isset($row->EXAMGROUP_NAME)?$row->EXAMGROUP_NAME:''; ?></td>
                                                <td> <?php echo isset($row->GPA)?$row->GPA:''; ?></td>
                                                <td> <?php echo isset($row->INSTITUTE_NAME)?$row->INSTITUTE_NAME:''; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="clearfix"></div>

<script>
    //Print
    $(document).ready(function(){

        $( ".print" ).click(function() {
            $('#printablediv').printThis({
                header: "<center><h3>Student Information</h3></center>",               // prefix to html
                footer: null

            });
        });

    });

</script>
