<style>
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
    /*.modal-dialog {
        width: 80%;
        height: 80%;
    }*/

   /* .modal-content {
        height: auto;
        min-height: 80%;
        border-radius: 0;
    }*/
    @media (min-width: 768px)
    {
        .form-horizontal .control-label {
            text-align: left;
            margin-bottom: 0;
            padding-top: 7px;
            padding-left: 0;
        }
    }

</style>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-base">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-1 col-sm-2 col-xs-4">
                        <a class="btn btn-danger btn-xs "  href="<?php echo site_url('sailorsInfo/OverweightInfo/index'); ?>" title="Overweight information">
                            <i class="glyphicon glyphicon-chevron-left"></i>
                        </a>
                    </div>
                    <div class="col-md-11 col-sm-10 col-xs-8">
                        <h3 class="panel-title text-center">Create Overweight Information</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="panel-body">
                <span class="frmMsg"></span>
                <form class="form-horizontal frmContent" id="MainForm" method="post">
                    <div class="col-sm-12">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-5 control-label"><span>Date of Return <span class="text-danger"> * </span></span></label>
                                <div class="col-sm-6" >
                                    <?php /*echo form_input(array('name' => 'dateOfReturn', 'id' => "dateOfReturnID", "class" => "dateTimePicker form-control required", 'value' => date('d-m-Y'), 'placeholder' => 'Date of return', 'style' => 'padding-right: 0px')); */?>
                                    <div class="input-group">
                                        <div class="inputholder form-control date">
                                            <input maxlength="2" class="dateField bdday" style="width: 24px;" type="text" placeholder="DD" onclick="this.focus();this.select()">
                                            <input tabindex="-1" class="dateField bdmonth" style="width: 32px;" type="text" placeholder="MM" onclick="this.focus();this.select()">
                                            <input maxlength="4" tabindex="-1" class="dateField bdyear" style="width: 40px;" type="text" placeholder="YYYY" onclick="this.focus();this.select()">
                                        </div>
                                        <input name="dateOfReturn" type="hidden" class="form-control bdpicker_hidden_input">
                                        <div class="input-group-addon datepickerTrigger">
                                            <span class="glyphicon glyphicon-calendar">
                                                <span style="pointer-events:none;padding: 0;" class="datepicker"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 control-label">Authority Number <span class="text-danger">* </span></label>
                                <div class="col-sm-6">
                                    <?php echo form_input(array('name' => 'authorityNo', "class" => "form-control required", 'placeholder' => 'Number')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-5 control-label" >Authority Date <span class="text-danger"> * </span></label>
                                <div class="col-sm-6">
                                    <?php /*echo form_input(array('name' => 'authorityDate', "class" => "datePicker form-control required", 'value' => date('d-m-Y'), 'placeholder' => 'Authority date', 'style' => 'padding-right: 0px')); */?>
                                    <div class="input-group">
                                        <div class="inputholder form-control date">
                                            <input maxlength="2" class="dateField bdday" style="width: 24px;" type="text" placeholder="DD" onclick="this.focus();this.select()">
                                            <input tabindex="-1" class="dateField bdmonth" style="width: 32px;" type="text" placeholder="MM" onclick="this.focus();this.select()">
                                            <input maxlength="4" tabindex="-1" class="dateField bdyear" style="width: 40px;" type="text" placeholder="YYYY" onclick="this.focus();this.select()">
                                        </div>
                                        <input name="authorityDate" type="hidden" class="form-control bdpicker_hidden_input">
                                        <div class="input-group-addon datepickerTrigger">
                                            <span class="glyphicon glyphicon-calendar">
                                                <span style="pointer-events:none;padding: 0;" class="datepicker"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6 col-sm-offset-5">
                                    <a class="btn btn-sm btn-primary modalLink text-right"  href= "<?php echo site_url('pickSailor/index/overweight') ?>" title="Search Overweight Information From Query Tool">
                                        <i class="">Pick Sailor</i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-5 control-label">Authority Ship <span class="text-danger"> * </span></label>
                                <div class="col-sm-6">
                                    <select class="select2 form-control" id="SHIP_ID" data-tags="true" data-placeholder="Select ship" data-allow-clear="true">
                                        <option value="">Select ship</option>
                                        <?php
                                        foreach ($shipEstablishment as $row):
                                            ?>
                                            <option value="<?php echo $row->SHIP_ESTABLISHMENTID ?>"><?php echo '[' . $row->CODE . '] ' . $row->NAME ?></option>
                                            <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                                <!--<button style="margin-left: -10px; margin-top: 5px; width: 24px;" type="button" class="btn btn-info btn-xs col-sm-1 cia_modal_btn"
                                        title="Authority Ship" data-action="<?php /*echo base_url('common/treeAppliedShip') */?>" data-modal-size="modal-sm">
                                    <i class="glyphicon glyphicon-option-horizontal"></i>
                                </button>-->
                            </div>
                        </div>
                    </div>

                    <span class="totalRecords" style="color: green;">Total Records :: 0</span>
                    <table id="sailorTable" class="table table-bordered " style="width:100%;">
                        <thead>
                            <tr>
                                <th>Official Number</th>
                                <th>Full Name</th>
                                <th>Rank</th>
                                <th>Overweight(KG)</th>
                                <th>Return Auth.</th>
                                <th>Prev. Overweight(KG)</th>
                                <th>Prev. Dt. of Ret.</th>
                                <th>Prev. Ret. Auth.</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="showPickSailor">
                            <tr id="tr_1">
                                <td>
                                    <input style="width: 100px;" type="text" id="OFFICIAL_NO_1" data-value="1" class="form-control OFFICIAL_NO inputs" maxlength="8" />
                                    <input type="hidden" name="SAILORID[]">
                                </td>
                                <td>
                                    <input style="width: 180px;" type="text" id="FULLNAME_1" class="form-control inputs" />
                                </td>
                                <td>
                                    <input style="width: 80px;" type="text" id="RANK_1" class="form-control inputs" />
                                </td>
                                <td>
                                    <input type="text" name="OverWeight[]" id="OverWeight_1"  class="inputs lst form-control overweight"  placeholder="weight" style="width: 90px;">
                                </td>
                                <td>
                                    <select class="select2 form-control" name="SHIP_ID[]" id="SHIP_ID_1" data-tags="true" data-placeholder="Select Return Authority" data-allow-clear="true" style="width: 180px;">
                                        <option value="">Return Auth</option>
                                        <?php
                                        foreach ($shipEstablishment as $row):
                                            ?>
                                            <option value="<?php echo $row->SHIP_ESTABLISHMENTID ?>"><?php echo $row->NAME ?></option>
                                            <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" id="WEIGHT_1"  class="inputs lst form-control " readonly="readonly" placeholder="Prev.Overweight" style="width: 150px;">
                                </td>
                                <td>
                                    <input type="text" id="DATE_OF_RETURN_1"  class="inputs lst form-control " readonly="readonly" placeholder="Authority Date" style="width: 150px;">
                                </td>
                                <td>
                                    <input type="text" id="AUTHORITY_NUMBER_1"  class="inputs lst form-control " readonly="readonly" placeholder="Return Authority" style="width: 150px;">
                                </td>
                                <td class="text-center">
                                    <!--<span class="btn btn-xs btn-danger remove_tr" id="1st_tr_remove"><i style="cursor:pointer" class=" fa fa-times" >Remove</i></span>-->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <input type="button" class="btn btn-primary btn-sm formSubmitWithRedirect" data-action="<?php echo 'sailorsInfo/overweightInfo/save' ?>" data-redirect-action="<?php echo 'sailorsInfo/overweightInfo/index' ?>" value="Submit">
                            <input type="button" class="btn btn-warning btn-sm clearAllBtn" value="Clear All">
                            <span class="loadingImg"></span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Select Ship Using tree in Modal-->
<?php $this->load->view('common/modal'); ?>
<?php $this->load->view('common/jsAppliedShip'); ?>
<?php $this->load->view('common/customBSDatepicker'); ?>

<script type="text/javascript">

    $(window).load(function(){
        $('.OFFICIAL_NO').focus();
    });

    $(document).on('keydown', 'table input', function(e) {
        if (e.keyCode == 13 || e.keyCode == 9) { // Enter and tab Key
            var $this = $(this), index = $this.closest('td').index();
            $this.closest('tr').next().find('td').eq(index).find('input').focus();
            e.preventDefault();
        }
    });

    $(document).on('keydown', '.OFFICIAL_NO', function(event) {
        var trNo = $('#showPickSailor tr').length;
        var oNumber = $(this).val();
        var dateOfReturnID = $("#dateOfReturnID").val();
        var retAuth = $("#SHIP_ID").val();

        if (dateOfReturnID == "") {
            alert('Please Enter Return Date');
        }
        else
        {
            if ((event.keyCode == 13 || event.keyCode == 9) && oNumber != "") {

                $("#tr_1").show();
                var officialNoId = $(this).attr('id');
                var len = officialNoId.length;
                var lastD = officialNoId.charAt(len - 1); /*find id attribute of the last official no. input field */
                var dataList = $(".OFFICIAL_NO").map(function() {
                    return parseInt($(this).attr("data-value"));
                }).get();

                var maxID = Math.max.apply(null, dataList);
                let thisFieldId = "#OFFICIAL_NO_" + (parseInt(maxID) + 1);

                // already selected
                if (officialNumberHaveDuplicateValues() != false) {
                    $("#OFFICIAL_NO_" + lastD).val('');
                    $("#FULLNAME_" + lastD).val('');
                    $("#RANK_" + lastD).val('');
                    //var inputsWithSameValue = "";
                    alert("This official number is already added");
                } else {
                    $.ajax({
                        url: '<?php echo base_url("sailorsInfo/OverweightInfo/infoByOfficialNumber") ?>',
                        type: 'post',
                        dataType: 'html',
                        async: false,
                        data: {oNumber: oNumber, dateOfReturnID: dateOfReturnID, maxID: maxID, trNo: trNo},
                        beforeSend: function() {
                            $(".totalRecords").html("<img src='<?php echo base_url(); ?>dist/img/loader-small.gif' />");
                        },
                        success: function(data) {
                            if (data == 'N') {
                                $("#OFFICIAL_NO_" + lastD).val('');
                                $("#FULLNAME_" + lastD).val('');
                                $("#RANK_" + lastD).val('');
                                alert('Please Enter Valid Official Number !');
                            } else if (data == 'Y') {
                                $("#OFFICIAL_NO_" + lastD).val('');
                                $("#FULLNAME_" + lastD).val('');
                                $("#RANK_" + lastD).val('');
                                alert('This Sailor Already Added In This Date !');
                            } else {
                                if (lastD == 1) {/*For Ajax Data Row*/
                                    //$("tr:last", $("#sailorTable tbody").parents('table')).before(data);
                                    $("tr:last").before(data);
                                    $("#OFFICIAL_NO_" + lastD).val('');
                                    $(".OFFICIAL_NO").focus();
                                    if(!!retAuth)
                                    {
                                        $("tr:last").prev().find('.SHIP_ID').val(retAuth).change();
                                    }
                                } else {/*For Only Initial Entry Ajax Row*/
                                    $("#tr_" + lastD).replaceWith(data);
                                    let thisRow = $(thisFieldId).closest('tr');
                                   // $(".OFFICIAL_NO").focus();
                                    thisRow.next().find('.OFFICIAL_NO').focus();

                                    if(!!retAuth)
                                    {
                                        thisRow.find('.SHIP_ID').val(retAuth).change();
                                    }
                                }
                            }

                            let rowCount = $('#sailorTable>tbody>tr:not([style*="display: none"],#tr_1)').length;
                            $(".totalRecords").html("Total Records :: " + rowCount);
                            $('.select2').select2();

                        }
                    })
                }
            }
        }
    });

    // check dublicate selection value
    function officialNumberHaveDuplicateValues() {
        var hasDuplicates = false;
        $('.OFFICIAL_NO').each(function() {
            var inputsWithSameValue = $(this).val();
            hasDuplicates = $('.OFFICIAL_NO').not(this).filter(function() {
                return $(this).val() === inputsWithSameValue;
            }).length > 0;
            if (hasDuplicates) {
                return false;
            }
        });
        return hasDuplicates;
    }

    // row remove with count
    $(document).on('click ', '.remove_tr', function() {
        var rowCount = $('#sailorTable>tbody>tr:not([style*="display: none"])').length;
        var main_tr = $(this).closest('#tr_1').length;

        if(rowCount>1)
        {
            if(main_tr)
                $(this).closest('tr').hide();
            else
                $(this).closest('tr').remove();
        }

        rowCount = $('#sailorTable>tbody>tr:not([style*="display: none"],#tr_1)').length;
        $(".totalRecords").html("Total Records :: " + rowCount);
        return false;
    });

   /* // Second modal toggle
    $(document).on('hidden.bs.modal', '#cia_modal', function () {
        $('#showDetaildModal').modal('show'); // First modal
        $('#showDetaildModal').find('#cia_modal').modal('hide'); // Second modal
    });*/

    // at input box add/remove the class current
    $(document).on('click','#sailorTable tr td input', function(){
        $('#sailorTable tr').css('background','transparent');
        $('#sailorTable tr td input.current').removeClass('current');
        $(this).addClass('current');
        $(this).closest('tr').css('background','rgba(178, 210, 251, 0.36)');
    });

    // after active an input box change its row's return auth value if change Authority Ship value
    $(document).on('change','#SHIP_ID', function(){
        let thisVal = $(this).val();
        $('.current').closest('tr').find('.SHIP_ID').val(thisVal).change();
    });

    // arrow key events
    $(document).on('keyup','.OFFICIAL_NO',function (e) {
        let thisRow = $(this).closest('tr');
        if (e.keyCode == 38) { // Up Key
            thisRow.prev().find('.OFFICIAL_NO').focus();
        }
        if ( e.keyCode == 40) // Down Key
        {
            thisRow.next().find('.OFFICIAL_NO').focus();
        }
    });

    // Load Selected Data For Pick Sailor
    function selectedDataForPickSailor() {
        let shipId = $("#SHIP_ID").val();
        let table = $('#sailorTable');
        table.find('.SHIP_ID').val(shipId).change();
    }


</script>