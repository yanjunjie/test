
<link href="<?php echo base_url(); ?>assets/css/plugins/datapicker/jquery-ui.datepicker.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/keyboard/keyboard.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url()?>/assets/css/plugins/jQueryUI/jquery-ui.css">
<script src="<?php echo base_url(); ?>assets/js/printThis.js"></script>

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
        background-color: #FCF8E3;
        padding: 10px;
        border-radius: 10px;
    }
</style>


<style>
    /*Custom Style*/
    .user-row {
        margin-bottom: 14px;
    }

    .user-row:last-child {
        margin-bottom: 0;
    }

    .dropdown-user {
        margin: 13px 0;
        padding: 5px;
        height: 100%;
    }

    .dropdown-user:hover {
        cursor: pointer;
    }

    .table-user-information{
        margin-bottom: 20px;
    }

    .table-user-information > tbody > tr {
        border-top: 1px solid rgb(221, 221, 221);
    }

    .table-user-information > tbody > tr:first-child {
        border-top: 0;
    }


    .table-user-information > tbody > tr > td {
        border-top: 0;
    }
    .toppad
    {margin-top:20px;
    }
    .panel-heading {
        padding: 5px 15px;
    }
    .float-e-margins .btn {
        margin-bottom: 0px !important;
    }
    .profile_sec_title{
        /*margin-bottom: 20px;*/
    }

    .table>tbody>tr.info>td, .table>tbody>tr.info>th, .table>tbody>tr>td.info, .table>tbody>tr>th.info, .table>tfoot>tr.info>td, .table>tfoot>tr.info>th, .table>tfoot>tr>td.info, .table>tfoot>tr>th.info, .table>thead>tr.info>td, .table>thead>tr.info>th, .table>thead>tr>td.info, .table>thead>tr>th.info {
        background-color: #d9edf7 !important;
        color: #666A6C !important;
        font-weight: 700;
    }
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
        border-top: 1px solid #e7eaec;
        line-height: 1.42857;
        padding: 3px 5px;
        vertical-align: top;
    }

</style>

<style>
    /*Profile*/
    .profile-thumb {
        background-size: cover !important;
        background-position: center center;
        background-repeat: no-repeat;
        position: relative;
        max-height: 130px;
        max-width: 130px;
        margin: 0 auto;
        margin-bottom: 15px;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        border-radius: 50%;
    }
    .profile-thumb {
        background-color: rgba(243,246,248,.94);
        border: 4px solid #fff;
        box-shadow: inset 0 1.5px 3px 0 rgba(0,0,0,.3), 0 1.5px 3px 0 rgba(0,0,0,.3);
        box-sizing: border-box;
        overflow: hidden;
    }

    @media print {
        .page-break, h3 { float:none !important; page-break-before:always !important; color:green;}
    }
</style>


<link href="<?php echo base_url(); ?>assets/css/plugins/jQueryUI/jquery-ui-1.10.4.custom.min.css" rel="stylesheet">


<div id="admission_form_div">

    <div class="msg">
        <?php
        if (empty($applicantData[0]->GENDER))
        {
            echo '<div role="alert" class="alert alert-danger alert-dismissible">';
            echo '<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>';
            echo '<p>Please logout first and login again because you have changed <b>"Registration Number"</b></p>';
            echo '</div>';

            error_reporting(0);
            ini_set('display_errors', 0);
        }
        ?>
    </div>

    <div class="ibox float-e-margins">

        <?php
        $applicant_summary=$this->session->userdata('applicant_summary');
        $app_academic_sess_array=$this->session->userdata('app_academic_sess_array');

        ?>

        <div class="personal-info-section">
            <div class="col-md-12 toppad" >
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div style="float: left;" class="profile_title"><h3 class="panel-title">All Applicant List</h3></div>
                        <div style="float: right;">
                            <button style="margin-left: 3px;" title="Print" class="btn btn-success btn-xs allApplicantList" ><i class="fa fa-print"></i> Print </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div id="printabledivasd" class="panel-body">
                        <style>
                            @media print {
                                .page-break {
                                    page-break-before: always;
                                }

                                .display_none{
                                    display: none;
                                }

                            }
                        </style>

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="all_applicant_list">
                                        <thead>
                                        <tr>
                                            <td>Applicant Name</td>
                                            <td>Applicant ID</td>
                                            <td>Merit Position</td>
                                            <td>Quota</td>
                                            <td>Status</td>
                                            <td class="display_none">Action</td>
                                        </tr>
                                        </thead>
                                        <tbody style="border-top: 0px solid transparent; ">
                                        <?php foreach ($applicantData as $row): ?>
                                            <tr>
                                                <td><a href="#" data-id="<?php echo $row->APPLICATION_ID; ?>" class="btn btn-xs details"><?php echo $row->FULL_NAME_ENG; ?></a></td>
                                                <td><?php echo $row->APPLICATION_ID; ?></td>
                                                <td><?php echo $row->MERIT_POSITION; ?></td>
                                                <td><?php echo $row->QUOTA_NAME; ?></td>
                                                <td><?php echo $row->ACTIVE_FLAG=='Y'?'<span style="color:green;">Selected</span>':'<span style="color:red;">Not Selected</span>'; ?></td>
                                                <td class="display_none">
                                                    <?php if($row->ACTIVE_FLAG=='N'): ?>
                                                    <button data-id="<?php echo $row->APPLICATION_ID; ?>" class="btn btn-info btn-xs selectAsMerit">Add to Merit List </button> <button data-id="<?php echo $row->APPLICATION_ID; ?>" class="btn btn-primary btn-xs details">Details</button>
                                                    <?php else: ?>
                                                    <button data-id="<?php echo $row->APPLICATION_ID; ?>" class="btn btn-danger btn-xs deselectAsMerit">Remove From Merit List </button> <button data-id="<?php echo $row->APPLICATION_ID; ?>" class="btn btn-primary btn-xs details">Details</button>
                                                    <?php endif; ?>
                                                </td>
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


        <!-- Applican tDetails Modal -->
        <<div id="applicant_details_modal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <h3>Applicant's Details</h3>
                    </div>
                    <div class="modal-body" id="applicant_details_modal_body">
                       <!-- --><?php /*$this->load->view('admin/applicant/all_applicant_list_details'); */?>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Applican tDetails Modal -->

    </div>

</div>
<!--<script src="<?php //echo base_url();                                                                                                                                         ?>assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>-->

<script src="<?php echo base_url(); ?>assets/js/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>assets/keyboard/keyboard.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
<script>


    //Print
    $(document).ready(function(){

        $( ".print" ).click(function() {
            $('#printablediv').printThis({
                header: "<center><h2>Student Information</h2></center>",               // prefix to html
                footer: null

            });
        });

        //All Applicant List
        $( ".allApplicantList" ).click(function() {
            $('#printabledivasd').printThis({
                header: "<center><h2>All Applican List</h2></center>",               // prefix to html
                footer: null

            });
        });

    });

    //Applicant Details
    $(document).on("click", ".details", function(){

        var applicant_id = $(this).data('id');

        var url = '<?= site_url("admission/all_applicant_details"); ?>';
        $.ajax({
            type:'post',
            url:url,
            cache: false,
            data:{applicant_id:applicant_id},
            success:function(data){
                //console.log(data);
                $('#applicant_details_modal').modal('show');
                $('#applicant_details_modal_body').html(data);
            },
            error:function(){
                alert('Error Selecting');
            }
        });
    });

    //Select to Merit List
    $(document).on("click", ".selectAsMerit", function(){

        var id = $(this).data('id');

        var url = '<?= site_url("admission/selected_as_merit"); ?>';
        $.ajax({
            type:'post',
            url:url,
            cache: false,
            data:{APPLICATION_ID:id},
            success:function(data){
                console.log(data);
                if (data=='yes') {
                    //Reload particular element with jQuery
                    $("#printabledivasd").load(location.href + " #printabledivasd"); // Add space between URL and selector.
                }
            },
            error:function(){
                alert('Error Selecting');
            }
        });
    });

    //Deselect from Merit List
    $(document).on("click", ".deselectAsMerit", function(){

        var id = $(this).data('id');

        var url = '<?= site_url("admission/deselected_as_merit"); ?>';
        $.ajax({
            type:'post',
            url:url,
            cache: false,
            data:{APPLICATION_ID:id},
            success:function(data){
                console.log(data);
                if (data=='yes') {
                    //Datatable Refresh
                    //$('.dataTables').DataTable().ajax.reload();

                    //Refresh particular element with jQuery
                    $("#printabledivasd").load(location.href + " #printabledivasd"); // Add space between URL and selector.

                }
            },
            error:function(){
                alert('Error Deselecting');
            }
        });
    });


</script>
