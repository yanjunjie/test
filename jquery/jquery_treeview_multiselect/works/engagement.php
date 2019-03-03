<fieldset class="scheduler-border">
    <legend class="scheduler-border">Engagement Information</legend>
    <div class="col-md-12">
        <div class="form-group">
            <label class="col-md-2 control-label" style="padding-left: 0px">Engag. No</label>
            <div class="col-md-4">
                <select name="ENGAGEMENTNOFILTER" id="ENGAGEMENTNOFILTER_ID" class="select2" data-live-search="true" data-placeholder="No Filter"  data-placeholder="No Filter" data-allow-clear = "true">
                    <option value="">No Filter</option>
                    <option value="1">=</option>
                    <option value="2"><</option>
                    <option value="3">></option>
                    <option value="4">Between</option>
                </select>
            </div>
            <div class="col-md-3">
                <?php echo form_input(array('name' => 'ENGAGEMENTFROMNO', 'id' => 'ENGAGEMENTFROMNO_ID', "class" => "form-control", 'placeholder' => '0')); ?>
            </div>
            <div class="col-md-3">
                <?php echo form_input(array('name' => 'ENGAGEMENTTONO', 'id' => 'ENGAGEMENTTONO_ID', "class" => "form-control", 'placeholder' => '0')); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">Engag. Date</label>
            <div class="col-md-4" >
                <select name="ENGAGEMENTDATEFILTER" id="ENGAGEMENTDATEFILTER_ID" class="select2" data-live-search="true" data-placeholder="No Filter"  data-allow-clear = "true">
                    <option value="">No Filter</option>
                    <option value="1">=</option>
                    <option value="2"><</option>
                    <option value="3">></option>
                    <option value="4">Between</option>
                </select>
            </div>
            <div class="col-md-3">
                <?php
                echo form_input(array('name' => 'ENGAGEMENTFROMDATE', 'id' => 'ENGAGEMENTFROMDATE_ID', "class" => "datePicker form-control",
                    'placeholder' => 'From Date'));
                ?>
            </div>
            <div class="col-md-3">
                <?php
                echo form_input(array('name' => 'ENGAGEMENTTODATE', 'id' => 'ENGAGEMENTTODATE_ID', "class" => "datePicker form-control",
                    'placeholder' => 'End Date'));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">Expiry Date</label>
            <div class="col-md-4" >
                <select name="ENGAGEEXPIRYFILTER" id="ENGAGEEXPIRYFILTER_ID" class="select2" data-live-search="true" data-placeholder="No Filter" data-allow-clear = "true">
                    <option value="">No Filter</option>
                    <option value="1">=</option>
                    <option value="2"><</option>
                    <option value="3">></option>
                    <option value="4">Between</option>
                </select>
            </div>
            <div class="col-md-3">
                <?php
                echo form_input(array('name' => 'EXPIRYFROMDATE', 'id' => 'EXPIRYFROMDATE_ID', "class" => "datePicker form-control",
                    'placeholder' => 'From Date'));
                ?>
            </div>
            <div class="col-md-3">
                <?php
                echo form_input(array('name' => 'EXPIRYTODATE', 'id' => 'EXPIRYTODATE_ID', "class" => "datePicker form-control",
                    'placeholder' => 'End Date'));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" style="padding-left: 0px">Re. Eng. Due On</label>
            <div class="col-md-4" >
                <select name="REENGDUEFILTER" id="REENGDUEFILTER_ID" class="select2" data-live-search="true" data-placeholder="No Filter" data-allow-clear = "true">
                    <option value="">No Filter</option>
                    <option value="1">=</option>
                    <option value="2"><</option>
                    <option value="3">></option>
                    <option value="4">Between</option>
                </select>
            </div>
            <div class="col-md-3">
                <?php
                echo form_input(array('name' => 'REENGFROMDUE', 'id' => 'REENGFROMDUE_ID', "class" => "datePicker form-control",
                    'placeholder' => 'From Date'));
                ?>
            </div>
            <div class="col-md-3">
                <?php
                echo form_input(array('name' => 'REENGTODUE', 'id' => 'REENGTODUE_ID', "class" => "datePicker form-control",
                    'placeholder' => 'End Date'));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">Engag. Type</label>
            <div class="col-md-4">
                <select class="selectpicker" multiple data-actions-box="true" id="ENGAGEMENTTYPE_ID" name="ENGAGEMENTTYPE"  data-live-search="true" data-placeholder="Select Engagement Type" data-width="170px">
                    <option value="1">Normal</option>
                    <option value="2">Extension</option>
                    <option value="3">Compulsary_Extension</option>
                    <option value="4">Punishment_Extension</option>
                    <option value="5">Hospital_Extension</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="checkbox" class="serial" name="engagement.ISNCSToCS" id="ISNCSTOCS_ID" value="1"> &nbsp;&nbsp;<label>Is Ncs To Cs</label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">Applied Ship</label>
            <div class="col-md-4">
                <select name="APPLIEDSHIP" id="APPLIEDSHIP_ID" class="selectpicker" multiple data-actions-box="true"  data-live-search="true" data-placeholder="No Filter" data-width="170px" data-size="5">
                    <?php
                    foreach ($shipEstablishment as $value) {
                        ?>
                        <option value="<?php echo $value->SHIP_ESTABLISHMENTID ?>"><?php echo $value->NAME ?></option>
                    <?php } ?>
                </select>
            </div>
            <button style="margin-left: 5px; margin-top: 5px;" type="button" class="btn btn-info btn-xs cia_modal_btn" title="Applied Ship"
                          data-action="<?php echo base_url('report/QueryTool/engagementReport')?>">
                <i class="glyphicon glyphicon-option-horizontal"></i>
            </button>
        </div>
    </div>
</fieldset>
<fieldset class="scheduler-border">
    <legend class="scheduler-border">Assessment</legend>
    <div class="col-md-12">
        <div class="form-group">
            <label class="col-md-3 control-label">Ship/Establishment</label>
            <div class="col-md-4">
                <select name="ASSESSMENTSHIPFILTER" id="ASSESSMENTSHIPFILTER_ID" class="selectpicker" multiple data-actions-box="true"  data-live-search="true" data-placeholder="No Filter" data-width="170px" data-size="5">
                    <?php
                    foreach ($shipEstablishment as $values) {
                        ?>
                        <option value="<?php echo $values->SHIP_ESTABLISHMENTID; ?>"><?php echo $values->NAME ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <label class="col-md-3 control-label">Point</label>
            <div class="col-md-2">
                <input type="text" class="form-control" name="assessmentPoint" id="assessmentPointID">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">Year</label>
            <div class="col-md-4" >
                <select name="ASSESSYEARFILTER" id="ASSESSYEARFILTER_ID" class="select2" data-live-search="true" data-placeholder="No Filter" data-allow-clear = "true">
                    <option value="">No Filter</option>
                    <option value="1">=</option>
                    <option value="2"><</option>
                    <option value="3">></option>
                    <option value="4">Between</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="ASSESSFROMYEAR" id="ASSESSFROMYEAR_ID" maxlength="4">
<!--                <select name="ASSESSFROMYEAR" id="ASSESSFROMYEAR_ID"
                        class="select2" data-placeholder="From Year" aria-hidden="true"
                        data-allow-clear="true" data-width="125px">
                    <option value="">From Year</option>
                    <?php
                    for ($i = 1975; $i <= date("Y"); $i++) {
                        ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php
                    }
                    ?>
                </select>-->
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="ASSESSTOYEAR" id="ASSESSTOYEAR_ID" maxlength="4">
<!--                <select name="ASSESSTOYEAR" id="ASSESSTOYEAR_ID"
                        class="select2" data-placeholder="To Year" aria-hidden="true"
                        data-allow-clear="true" data-width="125px">
                    <option value="">To Year</option>
                    <?php
                    for ($i = 1975; $i <= date("Y"); $i++) {
                        ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php
                    }
                    ?>
                </select>-->
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">Character</label>
            <div class="col-md-4" >
                <select class="select2 form-control serial"  name="assessment.CharacterType" id="ASSESSCHARACTERTYPE_ID" data-tags="true" data-placeholder="Select Character Type" data-width="150px" data-allow-clear="true" >
                    <option value="">No Filter</option>
                    <option value="0">VG</option>
                    <option value="1">VG*</option>
                    <option value="2">GOOD</option>
                    <option value="3">FAIR</option>
                    <option value="4">INDIF</option>
                    <option value="5">BAD</option>
                </select>
            </div>
            <label class="col-md-2 control-label">Efficiency</label>
            <div class="col-md-3">
                <select name="assessment.EfficiencyType" id="ASSESSEFFICIENCYTYPE_ID" class="selectpicker" multiple data-actions-box="true"  data-live-search="true" data-placeholder="No Filter" data-width="170px" data-size="5">
                    <option value="0">SUPER</option>
                    <option value="1">SAT</option>
                    <option value="2">MOD</option>
                    <option value="3">INFER</option>
                    <option value="4">UT</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" style="padding-left: 0px">No. Of VG Super</label>
            <div class="col-md-4" >
                <select name="VGNUMBERFILTER" id="VGNUMBERFILTER_ID" class="select2" data-allow-clear="true" data-live-search="true" data-placeholder="No Filter">
                    <option value="">No Filter</option>
                    <option value="1">=</option>
                    <option value="2"><</option>
                    <option value="3">></option>
                    <option value="4">Between</option>
                </select>
            </div>
            <div class="col-md-3">
                <?php echo form_input(array('name' => 'NUMBERVGFROM', 'id' => 'NUMBERVGFROM_ID', "class" => "form-control", 'placeholder' => '0')); ?>
            </div>
            <div class="col-md-3">
                <?php echo form_input(array('name' => 'NUMBERVGTO', 'id' => 'NUMBERVGTO_ID', "class" => "form-control", 'placeholder' => '0')); ?>
            </div>
        </div>
    </div>
</fieldset>
<fieldset class="scheduler-border">
    <legend class="scheduler-border">Branch Change Information</legend>
    <div class="col-md-12">
        <div class="form-group">
            <label class="col-md-2 control-label" style="padding-left: 0px">Previous Branch</label>
            <div class="col-md-4">
                <select name="PREVIOUSBRANCH" id="PREVIOUSBRANCH_ID" class="selectpicker" multiple data-actions-box="true" data-size="5" data-live-search="true" data-placeholder="Select Branch" data-width="170px">
                    <?php
                    foreach ($branch as $br) {
                        ?>
                        <option value="<?php echo $br->BRANCH_ID ?>"><?php echo $br->BRANCH_NAME ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" style="padding-left: 0px">Current Branch</label>
            <div class="col-md-4">
                <select name="CURRENTBRANCH" id="CURRENTBRANCH_ID" class="selectpicker" multiple data-actions-box="true" data-size="5" data-live-search="true" data-placeholder="Select Branch" data-width="170px">
                    <?php
                    foreach ($branch as $br) {
                        ?>
                        <option value="<?php echo $br->BRANCH_ID ?>"><?php echo $br->BRANCH_NAME ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">Change Date</label>
            <div class="col-md-4" >
                <select name="BRANCHCHANGEFILTER" id="BRANCHCHANGEFILTER_ID" class="select2" data-allow-clear="true" data-live-search="true" data-placeholder="No Filter">
                    <option value="">No Filter</option>
                    <option value="1">=</option>
                    <option value="2"><</option>
                    <option value="3">></option>
                    <option value="4">Between</option>
                </select>
            </div>
            <div class="col-md-3">
                <?php
                echo form_input(array('name' => 'CHANGEFROMDATE', 'id' => 'CHANGEFROMDATE_ID', "class" => "datePicker form-control",
                    'placeholder' => 'From Date'));
                ?>
            </div>
            <div class="col-md-3">
                <?php
                echo form_input(array('name' => 'CHANGETODATE', 'id' => 'CHANGETODATE_ID', "class" => "datePicker form-control",
                    'placeholder' => 'End Date'));
                ?>
            </div>
        </div>
    </div>
</fieldset>

<!--Modal-->
<div class="modal fade cia_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">Title Here</h4>
            </div>
            <div class="modal-body">
                Content
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary okBtn" data-dismiss="modal">Ok</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--End Modal-->

<script>
    //Engagement Information
    //Engag. No
    $("#ENGAGEMENTFROMNO_ID").prop('disabled', true);
    $("#ENGAGEMENTTONO_ID").prop('disabled', true);
    $(document).on('change', '#ENGAGEMENTNOFILTER_ID', function() {
        var val = $(this).val();
        if (val == "") {
            $("#ENGAGEMENTFROMNO_ID").val('');
            $("#ENGAGEMENTTONO_ID").val('');
            $("#ENGAGEMENTFROMNO_ID").prop('disabled', true);
            $("#ENGAGEMENTTONO_ID").prop('disabled', true);
        } else if (val == 4) {
            $("#ENGAGEMENTFROMNO_ID").prop('disabled', false);
            $("#ENGAGEMENTTONO_ID").prop('disabled', false);
        } else {
            $("#ENGAGEMENTFROMNO_ID").prop('disabled', false);
            $("#ENGAGEMENTTONO_ID").prop('disabled', true);
            $("#ENGAGEMENTTONO_ID").val('');
        }
    });
    //Engag. Date
    $("#ENGAGEMENTFROMDATE_ID").prop('disabled', true);
    $("#ENGAGEMENTTODATE_ID").prop('disabled', true);
    $(document).on('change', '#ENGAGEMENTDATEFILTER_ID', function() {
        var val = $(this).val();
        if (val == "") {
            $("#ENGAGEMENTFROMDATE_ID").val('');
            $("#ENGAGEMENTTODATE_ID").val('');
            $("#ENGAGEMENTFROMDATE_ID").prop('disabled', true);
            $("#ENGAGEMENTTODATE_ID").prop('disabled', true);
        } else if (val == 4) {
            $("#ENGAGEMENTFROMDATE_ID").prop('disabled', false);
            $("#ENGAGEMENTTODATE_ID").prop('disabled', false);
        } else {
            $("#ENGAGEMENTFROMDATE_ID").prop('disabled', false);
            $("#ENGAGEMENTTODATE_ID").prop('disabled', true);
            $("#ENGAGEMENTTODATE_ID").val('');
        }
    });
    //Expiry Date
    $("#EXPIRYFROMDATE_ID").prop('disabled', true);
    $("#EXPIRYTODATE_ID").prop('disabled', true);
    $(document).on('change', '#ENGAGEEXPIRYFILTER_ID', function() {
        var val = $(this).val();
        if (val == "") {
            $("#EXPIRYFROMDATE_ID").val('');
            $("#EXPIRYTODATE_ID").val('');
            $("#EXPIRYFROMDATE_ID").prop('disabled', true);
            $("#EXPIRYTODATE_ID").prop('disabled', true);
        } else if (val == 4) {
            $("#EXPIRYFROMDATE_ID").prop('disabled', false);
            $("#EXPIRYTODATE_ID").prop('disabled', false);
        } else {
            $("#EXPIRYFROMDATE_ID").prop('disabled', false);
            $("#EXPIRYTODATE_ID").prop('disabled', true);
            $("#EXPIRYTODATE_ID").val('');
        }
    });
    //Re. Eng. Due On
    $("#REENGFROMDUE_ID").prop('disabled', true);
    $("#REENGTODUE_ID").prop('disabled', true);
    $(document).on('change', '#REENGDUEFILTER_ID', function() {
        var val = $(this).val();
        if (val == "") {
            $("#REENGFROMDUE_ID").val('');
            $("#REENGTODUE_ID").val('');
            $("#REENGFROMDUE_ID").prop('disabled', true);
            $("#REENGTODUE_ID").prop('disabled', true);
        } else if (val == 4) {
            $("#REENGFROMDUE_ID").prop('disabled', false);
            $("#REENGTODUE_ID").prop('disabled', false);
        } else {
            $("#REENGFROMDUE_ID").prop('disabled', false);
            $("#REENGTODUE_ID").prop('disabled', true);
            $("#REENGTODUE_ID").val('');
        }
    });
    //Assessment
    //Year
    $("#ASSESSFROMYEAR_ID").prop('disabled', true);
    $("#ASSESSTOYEAR_ID").prop('disabled', true);
    $(document).on('change', '#ASSESSYEARFILTER_ID', function() {
        var val = $(this).val();
        if (val == "") {
            $("#ASSESSFROMYEAR_ID").val('');
            $("#ASSESSTOYEAR_ID").val('');
            $("#ASSESSFROMYEAR_ID").prop('disabled', true);
            $("#ASSESSTOYEAR_ID").prop('disabled', true);
        } else if (val == 4) {
            $("#ASSESSFROMYEAR_ID").prop('disabled', false);
            $("#ASSESSTOYEAR_ID").prop('disabled', false);
        } else {
            $("#ASSESSFROMYEAR_ID").prop('disabled', false);
            $("#ASSESSTOYEAR_ID").prop('disabled', true);
            $("#ASSESSTOYEAR_ID").val('');
        }
    });
    //No. Of VG Super
    $("#NUMBERVGFROM_ID").prop('disabled', true);
    $("#NUMBERVGTO_ID").prop('disabled', true);
    $(document).on('change', '#VGNUMBERFILTER_ID', function() {
        var val = $(this).val();
        if (val == "") {
            $("#NUMBERVGFROM_ID").val('');
            $("#NUMBERVGTO_ID").val('');
            $("#NUMBERVGFROM_ID").prop('disabled', true);
            $("#NUMBERVGTO_ID").prop('disabled', true);
        } else if (val == 4) {
            $("#NUMBERVGFROM_ID").prop('disabled', false);
            $("#NUMBERVGTO_ID").prop('disabled', false);
        } else {
            $("#NUMBERVGFROM_ID").prop('disabled', false);
            $("#NUMBERVGTO_ID").prop('disabled', true);
            $("#NUMBERVGTO_ID").val('');
        }
    });
    //Branch Change Information
    //Change Date
    $("#CHANGEFROMDATE_ID").prop('disabled', true);
    $("#CHANGETODATE_ID").prop('disabled', true);
    $(document).on('change', '#BRANCHCHANGEFILTER_ID', function() {
        var val = $(this).val();
        if (val == "") {
            $("#CHANGEFROMDATE_ID").val('');
            $("#CHANGETODATE_ID").val('');
            $("#CHANGEFROMDATE_ID").prop('disabled', true);
            $("#CHANGETODATE_ID").prop('disabled', true);
        } else if (val == 4) {
            $("#CHANGEFROMDATE_ID").prop('disabled', false);
            $("#CHANGETODATE_ID").prop('disabled', false);
        } else {
            $("#CHANGEFROMDATE_ID").prop('disabled', false);
            $("#CHANGETODATE_ID").prop('disabled', true);
            $("#CHANGETODATE_ID").val('');
        }
    });


    /*
    * @author   Bablu <bablu@atilimited.net>
    * @return   Ajax Modal
    */
    $(document).on("click", ".cia_modal_btn", function (e) {
        e.preventDefault();
        e.stopPropagation();

        //Default Settings
        let IdD = '';
        let tableD = "";
        let attrD = "";
        let actionD = "";
        let titleD = "";
        let modalTitleD = "";
        let headerBgD = "";
        let modalTypeD = "";
        let modalContentD = "";

        //Attributes:
        let dataId = $(this).attr('data-id');
        let dataTable = $(this).attr('data-table');
        let dataAttr = $(this).attr('data-attr');
        let dataAction = $(this).attr('data-action');
        let dataTitle = $(this).attr("title");
        //let dataModalTitle = $(this).attr("data-modal-title");
        let dataHeaderBg = $(this).attr("data-header-bg");
        let dataModalType = $(this).attr("data-modal-type");
        let dataModalContent = $(this).attr("data-modal-content");

        //Ajax Params:
        let id = dataId?dataId:(IdD?IdD:'');
        let table = dataTable?dataTable:(tableD?tableD:'');
        let attr = dataAttr?dataAttr:(attrD?attrD:'');
        let url = dataAction?dataAction:(actionD?actionD:'');
        let title = dataTitle?dataTitle:(titleD?titleD:'');
        //let modalTitle = dataModalTitle?dataModalTitle:(modalTitleD?modalTitleD:'');
        let headerBg = dataHeaderBg?dataHeaderBg:(headerBgD?headerBgD:'');
        let modalType = dataModalType?dataModalType:(modalTypeD?modalTypeD:'');
        let modalContent = dataModalContent?dataModalContent:(modalContentD?modalContentD:'');

        //Modal elements to show contents
        let cia_modal = $('.cia_modal');
        let modal_dialog = cia_modal.find('.modal-dialog');
        let modal_header = cia_modal.find('.modal-header');
        let modal_title = cia_modal.find('.modal-title');
        let modal_body = cia_modal.find('.modal-body');
        let modal_footer = cia_modal.find('.modal-footer');

        //Set modal show/hide
        cia_modal.modal('toggle');

        //Set Modal Title
        if(title && (title!=null))
        {
            modal_title.html(title);
        }
        //Set Modal Header Background
        if(headerBg && (headerBg!=null))
        {
            modal_header.attr('class', 'modal-header');
            modal_header.addClass(headerBg);
        }
        //Set Modal Size
        if(modalType && (modalType!=null))
        {
            modal_dialog.attr('class', 'modal-dialog');
            modal_dialog.addClass(modalType);
        }
        //Set Form Data
        let formData = new FormData();
        formData.append('id',id);
        formData.append('table',table);
        formData.append('attr',attr);
        formData.append('modalContent',modalContent);

        $.ajax({
            type: 'post',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            async: false,
            beforeSend: function () {
                modal_body.html("<img src='<?php echo base_url(); ?>dist/img/loader-small.gif' />");
            },
            success: function (data) {
                modal_body.html(data);
            },
            error: function( req, status, err ) {
                alert("Error! " + err + " (" + status + ") ");
            }
        });
    });

    // Tree View
    /*$(document).on('click','.carett',function () {
        $(this).parent().find('.nested').toggleClass("active");
        $(this).toggleClass("carett-down");
    });*/

    // All checkbox select
    $(document).on('click','.chkAll',function () {

        // Fetch all child CheckBoxes.
        var chkboxes = $(this).closest('li').find("input:checkbox").not(':first');

        // Check each child CheckBox.
        if(this.checked) {
            chkboxes.each(function() {
                this.checked = true;
                $(this).attr("checked", "checked");
            });
        }else{
            chkboxes.each(function() {
                this.checked = false;
                $(this).removeAttr("checked");
            });
        }

    });

    // select value using tree
    $(document).on("click",".okBtn", function(){
        let values = (function() {
            let shipIds = [];
            $('input[name=ship_ids][checked=checked]').each(function() {
                shipIds.push(this.value);
            });
            return shipIds;
        })();

        // select for ship applied
        $("#APPLIEDSHIP_ID").val(values).change();
        $(".selectpicker").selectpicker('refresh');
    });


</script>