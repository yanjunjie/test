<div class="row">
    <div class="col-md-12">
        <div class="panel panel-base">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-1 col-sm-2 col-xs-4">
                        <a class="btn btn-danger btn-xs "  href= "<?php //echo ($flag == 1)? site_url('Retirement/HistoryTran/examTestInfo/index') : site_url('regularTransaction/examTestInfo/index') ?>" title="List exam/test informaion">
                            <i class="glyphicon glyphicon-chevron-left"></i>
                        </a>
                    </div>
                    <div class="col-md-11 col-sm-10 col-xs-8">
                        <h3 class="panel-title">Strength By Branch</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <form class="form-horizontal frmContent" id="MainForm" method="post">
                    <span class="frmMsg"></span>
                    <div class="col-md-12">
                        <fieldset class="">
                            <div class="col-md-6">

                                <?php $this->load->view("reportViewPrint/common/dao_zone_area"); ?>
                                <?php $this->load->view("reportViewPrint/common/shipest_postingunit"); ?>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Organization <span class="zone"></span></label>
                                    <div class="col-sm-3" >
                                        <select class="selectpicker show-tick form-control" name="orgInNotIn" id="orgInNotIn" data-placeholder="Select Option" aria-hidden="true" >
                                            <option value="1" selected>In</option>
                                            <option value="2">Not In</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6" >
                                        <select class="selectpicker form-control" name="org[]" id="org" data-placeholder="Select Organization" multiple data-actions-box="true">
                                            <?php
                                            foreach ($org as $row):
                                                ?>
                                                <option value="<?php echo $row->ORG_ID; ?>"><?php echo $row->ORG_NAME; ?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <?php $this->load->view("reportViewPrint/common/sailor_status"); ?>
                            </div>
                            <div class="col-md-6">

                                <?php $this->load->view("reportViewPrint/common/equi_rank"); ?>
                                <?php $this->load->view("reportViewPrint/common/branch_rank"); ?>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Trade <span class="trade"></span></label>
                                    <div class="col-sm-3" >
                                        <select class="selectpicker show-tick form-control" name="tradeInNotIn" id="tradeInNotIn" data-placeholder="Select Option" aria-hidden="true" >
                                            <option value="1" selected>In</option>
                                            <option value="2">Not In</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6" >
                                        <select class="selectpicker" data-live-search="true" name="trade[]" id="trade" liveSearch="true" data-placeholder="Select Trade" multiple data-actions-box="true"  data-size="5">
                                            <?php
                                                foreach ($trade as $row):
                                                ?>
                                                <option value="<?php echo $row->TRADE_ID ?>"><?php echo "[".$row->CODE."] ".$row->NAME ?></option>
                                            <?php
                                                endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <?php $this->load->view('reportViewPrint/common/partII') ?>

                            </div>
                        </fieldset>
                    </div>
                    <div class="col-md-12">
                        <fieldset class="">
                            <legend  class="legend">Printing Option</legend>
                            <?php $this->load->view('reportViewPrint/common/report_header_footer'); ?>
                        </fieldset>
                        <fieldset class="">
                            <legend  class="legend"></legend>
                            <!-- Next section -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-md-2 control-label"><input type="radio" id="branchRank" name="branchRank" value="0" checked></label>
                                    <div class="col-md-9 control-label" style="text-align: left !important;">
                                        Branch and Rank
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label"><input type="radio" id="branchEquiRank" name="branchRank" value="1"></label>
                                    <div class="col-md-9 control-label" style="text-align: left !important;">
                                        Branch and Eq.Rank
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group col-md-12 branchRank">
                                    <label class="col-md-3 control-label" style="text-align: left !important;"><input type="radio" class="normalDetails" name="normalDetails" value="0" checked> Normal</label>
                                    <label class="col-md-3 control-label" style="text-align: left !important;"><input type="radio" class="normalDetails" name="normalDetails" value="1"> Details</label>
                                </div>
                                <div class="form-group col-md-12 branchEquiRank">
                                    <label class="col-md-3 control-label" style="text-align: left !important;"><input type="radio" class="borneANDSan" name="borneANDSan" value="0" checked> Borne</label>
                                    <label class="col-md-4 control-label" style="text-align: left !important;"><input type="radio" class="borneANDSan" name="borneANDSan" value="1"> Sanction</label>
                                    <label class="col-md-5 control-label" style="text-align: left !important;"><input type="radio" class="borneANDSan" name="borneANDSan" value="2"> Borne & Sanction</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-md-2 control-label"><input type="checkbox" name="showGrid" value="0"></label>
                                    <div class="col-md-9 control-label" style="text-align: left !important;">
                                        Show Grid
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label"><input type="checkbox" name="reportDate" value="1"></label>
                                    <div class="col-md-9 control-label" style="text-align: left !important;">
                                        Report Date
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-md-12">
                        <fieldset class="">
                            <legend  class="legend"></legend>
                            <div class="col-sm-1"></div>
                            <div class="col-sm-2"><input type="button" class="btn btn-warning btn-sm preview" value="Preview"></div>
                            <div class="col-sm-2"><input type="button" class="btn btn-success btn-sm allReport" data-rType="pdf" value="Print"><span id="print"></span></div>
                            <div class="col-sm-2"><input type="button" class="btn btn-primary btn-sm allReport" data-rType="excel" value="Excel"><span id="excel"></span></div>
                            <div class="col-sm-2"><input type="button" class="btn btn-primary btn-sm allReport" data-rType="word" value="Word"><span id="word"></span></div>
                        </fieldset>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="editorText"></div>

<?php $this->load->view("common/sailors_info"); ?>
<?php $this->load->view("common/report_js"); ?>

<script src="<?php echo base_url('dist/scripts/jquery.min.js') ?>"></script>
<script src="<?php echo base_url('dist/jquery.table2excel.js') ?>"></script>
<script src="<?php echo base_url('dist/html2canvas.js') ?>"></script>
<script src="<?php echo base_url('dist/jspdf.debug.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.0.15/jspdf.plugin.autotable.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.0.15/jspdf.plugin.autotable.src.js"></script>

<script>
    $(document).on('click', '.preview', function(event) {
        event.preventDefault();
        if (confirm("Are You Sure?")) {
            var daoGroup = $("#daoGroup").val();
            if (daoGroup == undefined && daoGroup === null) {
                alert("Select DAO Groups");
            }else{
                /* Act on the event */
                var data = $(".frmContent").serialize();
                var url = '<?php echo base_url() ?>reportViewPrint/strengthByBranch/branchPreview';
                window.open(url+'?'+ data, '_blank');

                /*$.ajax({
                    url: '<--?php echo base_url() ?>reportViewPrint/sailorNominalRoll/testTab',
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    beforeSend: function () {
                        $(".training_dropdown").html("<img src='<--?php echo base_url(); ?>dist/img/loader.gif' />");
                    },
                    success: function (data1) {
                        window.open(url+'?'+ data, '_blank');
                        //$('.training_dropdown').html(data);
                    }
                });*/
            }
        }else {
            return false;
        }
    });

    /*$(document).on('click', '.excel', function(event) {
        event.preventDefault();
        if (confirm("Are You Sure?")) {
            var data = $(".frmContent").serialize();
            /!* Act on the event *!/
            $.ajax({
                url: '<--?php echo base_url() ?>reportViewPrint/strengthByBranch/genExcel',
                type: 'GET',
                dataType: 'json',
                data: data,
                beforeSend: function () {
                    $("#excel").html("<img src='<--?php echo base_url(); ?>dist/img/loader-small.gif' />");
                },
                success: function (data) {
                    $("#excel").hide();
                    alert(data+" Excel File create successfully.");
                }
            });
        }else {
            return false;
        }

    });

    $(document).on('click', '.word', function(event) {
        event.preventDefault();
        if (confirm("Are You Sure?")) {
            /!* Act on the event *!/
            var data = $(".frmContent").serialize();
            /!* Act on the event *!/
            $.ajax({
                url: '<--?php echo base_url() ?>reportViewPrint/strengthByBranch/genWord',
                type: 'GET',
                dataType: 'json',
                data: data,
                beforeSend: function () {
                    $('#word').show();
                    $("#word").html("<img src='<--?php echo base_url(); ?>dist/img/loader-small.gif' />");
                },
                success: function (data) {
                    $('#word').hide();
                    alert(data+" Word File create successfully.");
                }
            });
        }else {
            return false;
        }
    });*/

    $(document).on('click', '.print', function(event) {
        event.preventDefault();
        /* Act on the event */
        if (confirm("Are You Sure?")) {
            var daoGroup = $("#daoGroup").val();
            if (daoGroup == undefined && daoGroup === null) {
                alert("Select DAO Groups");
            }else{
                /* Act on the event */
                var data = $(".frmContent").serialize();
                var url = '<?php echo base_url() ?>reportViewPrint/strengthByBranch/genPDF';
                $.ajax({
                    url: '<?php echo base_url() ?>reportViewPrint/strengthByBDAdmin/testTab',
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    beforeSend: function () {
                        $("#print").hide();
                        $("#print").html("<img src='<?php echo base_url(); ?>dist/img/loader-small.gif' />");
                    },
                    success: function (data1) {
                        $("#print").hide();
                        window.open(url+'?'+ data, '_blank');
                        //$('.training_dropdown').html(data);
                    }
                });
            }
        }else{
            return false;
        }
    });


    // All kinds of reports
    $(document).on('click', '.allReport', function(event) {
        event.preventDefault();
        let thisBtn = $(this);

        // report type like print, pdf, word, excel
        let rType = thisBtn.attr('data-rType');

        if(!rType) {
            alert('Please set report type');
            return false;
        }

        if (confirm("Are You Sure?")) {
            var data = $(".frmContent").serialize();

            $.ajax({
                url: '<?php echo base_url() ?>reportViewPrint/strengthByBranch/branchPreview',
                type: 'GET',
                data: data,
                async: false,
                beforeSend: function () {
                    thisBtn.before('<img class="thisLoadingImg" style="margin-right: 5px;" src="<?php echo base_url(); ?>dist/img/loader-small.gif" />');
                },
                success: function (data) {

                    $('html').prepend('<div class="thisReportData">'+ data +'</div>');

                    let htmlData = $('.thisReportData').html();

                    if(rType === 'print')
                    {

                    }

                    if(rType === 'pdf')
                    {
                        htmlToPdf(data,'','aca_tbl');
                        //htmlToPdf(data);
                    }

                    if(rType === 'word')
                    {

                    }

                    if(rType === 'excel')
                    {
                        htmlToExcel('aca_tbl', 'name', 'report.xls');
                    }

                    $('.thisReportData').remove();
                    $('.thisLoadingImg').remove();
                }
            });

        }else {
            return false;
        }

    });


    // html to word function
    function htmlToWord() {

    }

    // html to excel function
    function htmlToExcel(table, name, filename) {

        let uri = 'data:application/vnd.ms-excel;base64,',
            template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><title></title><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>',
            base64 = function (s) {
                return window.btoa(decodeURIComponent(encodeURIComponent(s)))
            }, format = function (s, c) {
                return s.replace(/{(\w+)}/g, function (m, p) {
                    return c[p];
                })
            };

        if (!table.nodeType) table = document.getElementById(table);
        var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML};

        var link = document.createElement('a');
        link.download = filename;
        link.href = uri + base64(format(template, ctx));
        link.click();
    }

    // html to pdf function
    function htmlToPdf(html = '', fileName = '', autoTableId='') {
        //let doc = new jsPDF('l', 'pt', 'a3');
        let doc = new jsPDF('p', 'pt', 'a4',true);
        let newFileName = fileName ? (fileName + '.pdf') : 'report.pdf';

        /*doc.addHTML(html, function() {
            doc.save(newFileName);
        });*/
        //doc.fromHTML(html);
        //doc.save(newFileName);

        doc.cellInitialize();


        // auto table
       /* if(!!autoTableId) {
            doc.autoTable({html: '#'+autoTableId});
        }*/

        var specialElementHandlers = {
            '#editorText': function (element,renderer) {
                return true;
            }
        };

        // to skip special element to be rendered
        /*let specialElementHandlers = {
            '#skipToBePDF': function (element, renderer) {
                return true
            }
        };*/

        let margins = {
            top: 10,
            bottom: 60,
            left: 50,
            width: 800
        };

        let options = {
            'width': margins.width, // max width of content on PDF
            'elementHandlers': specialElementHandlers,
            //pagesplit: true
        };

        //doc.autoPrint();

        //cell.styles.cellPadding = styles.cellPadding || 5;

        // all coords and widths are in jsPDF instance's declared units, 'inches' in this case
        doc.fromHTML(
            html,
            margins.left, // x coord
            margins.top, // y coord
            options,
            function (dispose) {
                // dispose: object with X, Y of the last line add to the PDF. This allows the insertion of new lines after html
                doc.save(newFileName);
            }, margins);
    }

    // html to print function
    function htmlToPrint() {

    }




</script>
