<style type="text/css">
    table {
        font-family: arial;
        font-size: 13px;
        border-collapse: collapse;
        width: 100%;
        border-spacing: 0;
    }
    .table td, .table th {
        border: 1px solid black;
    }
</style>
<p style="text-align: center;" id="exportActionID">
    <button id="export">Word</button>
    <button id="exportExcelID">Excel</button>
    <button onclick="myFunction('docx')">Print</button>
    <button onclick="javascript:demoFromHTML();">PDF</button>
</p>
<div id="docx" class="WordSection1">
    <style>
        @page { size: auto;  margin: 0mm; }
    </style>
    <table>
        <tr>
            <td>Calculation Date: <?php echo $calculationDate ?></td>
            <td style="font-size: 15; text-align: center; text-transform: uppercase;"><strong>Panel For D&L 'Q'</strong></td>
            <td style="text-align: right;">End Date: <?php echo $missionEndDate ?></td>
        </tr>
    </table>
    <br/>
    <table class="table table-striped table-bordered table2excel">
        <thead>
            <tr>
                <td style="width: 1cm;">S No</td>
                <td style="text-align: left;">O No</td>
                <td style="text-align: left; width: 3.2cm;">Name</td>
                <td style="text-align: left;">Rank</td>
                <td style="text-align: left;">Present Billet</td>
                <td style="text-align: center;">Med<br/>Cat</td>
                <td style="text-align: left;">WP</td>
                <td style="text-align: center;">Entry Dt</td>
                <td style="text-align: center;">Dt.of Adv.</td>

                <?php if ($calculation->CourseSeniorityPoint > 0) { ?>
                    <td>CS</td>
                <?php }if ($calculation->ExamSeniority > 0) { ?>
                    <td rowspan="2">Exam Seniority </td>
                <?php } if ($calculation->Medal > 0) { ?>
                    <td rowspan="2">Medal</td>
                <?php }if ($calculation->Honor > 0) { ?>
                    <td rowspan="2">Honor</td>
                <?php }if ($calculation->VGSuperPoint > 0) { ?>
                    <td>VGS</td>
                <?php }if ($calculation->RedRecommendation > 0) { ?>
                    <td>Red Rec</td>
                <?php }if ($calculation->NoofRecommendation > 0) { ?>
                    <td rowspan="2">No of Recommendation</td>
                <?php }if ($calculation->RankServicePoin > 0) { ?>
                    <td>Rank Svc</td>
                <?php }if ($calculation->TotalServicePoint > 0) { ?>
                    <td>Total Svc</td>
                <?php }if ($calculation->SeaService > 0) { ?>
                    <td>Sea Svc</td>
                <?php }if ($calculation->InstructorService > 0) { ?>
                    <td>Instr Svc</td>
                <?php }if ($calculation->IndustrialService > 0) { ?>
                    <td rowspan="2">Industrial Service</td>
                <?php }if ($calculation->RetinueService > 0) { ?>
                    <td rowspan="2">Retinue Svc</td>
                <?php }if ($calculation->AviationService > 0) { ?>
                    <td rowspan="2">Aviation Service</td>
                <?php } ?>

                <td style="text-align: center;">Total</td>
                <td>Remarks</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sailorInfo as $key => $value) { ?>
                <tr>
                    <td style="text-align: left;"><?php echo $key + 1 ?></td>
                    <td style="text-align: left;"><?php echo $value->OfficialNumber ?></td>
                    <td style="text-align: left;"><?php echo $value->FullName ?></td>
                    <td style="text-align: left;"><?php echo $value->RankName ?></td>
                    <td style="text-align: left;"><?php echo $value->PresentBillet . '<br/>' . $value->UnderDraft ?></td>
                    <td style="text-align: center;"><?php echo $value->MedCat ?></td>
                    <td style="text-align: left;"><?php echo $value->WP ?></td>
                    <td style="text-align: center;"><?php echo $value->EntryDate ?></td>
                    <td style="text-align: center;"><?php echo $value->PromotionDate ?></td>

                    <?php if ($calculation->CourseSeniorityPoint > 0) { ?>
                        <td style="text-align: center;"><?php echo $value->CrsSeniority ?></td>
                    <?php }if ($calculation->ExamSeniority > 0) { ?>
                        <td style="text-align: center;"><?php echo $value->ExamSeniority ?></td>
                    <?php }if ($calculation->Medal > 0) { ?>
                        <td><?php echo $value->Medal ?></td>
                    <?php }if ($calculation->Honor > 0) { ?>
                        <td><?php echo $value->Honor ?></td>
                    <?php }if ($calculation->VGSuperPoint > 0) { ?>
                        <td style="text-align: center;"><?php echo $value->VGSupperPt ?></td>
                    <?php }if ($calculation->RedRecommendation > 0) { ?>
                        <td><?php echo $value->RedRecommendation ?></td>
                    <?php }if ($calculation->NoofRecommendation > 0) { ?>
                        <td><?php echo $value->NoofRecommendation ?></td>
                    <?php }if ($calculation->RankServicePoin > 0) { ?>
                        <td style="text-align: center;"><?php echo $value->RankSvcPointText . '<br/>' . $value->RankSvcPoint ?></td>
                    <?php }if ($calculation->TotalServicePoint > 0) { ?>
                        <td style="text-align: center;"><?php echo $value->TotalSvcPointText . '<br/>' . $value->TotalSvcPoint ?></td>
                    <?php }if ($calculation->SeaService > 0) { ?>
                        <td style="text-align: center;"><?php echo $value->SeaSvcPointText . '<br/>' . $value->SeaSvcPoint ?></td>
                    <?php }if ($calculation->InstructorService > 0) { ?>
                        <td><?php echo $value->InstructorServiceText . '<br/>' . $value->InstructorService ?></td>
                    <?php }if ($calculation->IndustrialService > 0) { ?>
                        <td><?php echo $value->IndustrialServiceText . '<br/>' . $value->IndustrialService ?></td>
                    <?php }if ($calculation->RetinueService > 0) { ?>
                        <td><?php echo $value->RetinueServiceText . '<br/>' . $value->RetinueService ?></td>
                    <?php }if ($calculation->AviationService > 0) { ?>
                        <td><?php echo $value->AviationServiceText . '<br/>' . $value->AviationService ?></td>
                    <?php } ?>
                    <td style="text-align: center;"><?php echo $value->TotalPoint ?></td>
                    <td style="text-align: left;">
                        <?php
                        $remarks = $value->OverRemarks != '' ? $value->OverRemarks . '@' . $value->Remarks : $value->Remarks;
                        $explor = array_filter(explode('@', $remarks));
                        foreach ($explor as $key => $value) {
                            echo $key + 1 . '. ' . $value . "<br>";
                        }
                        ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script src="<?php echo base_url('dist/scripts/jquery.min.js') ?>"></script>
<script src="<?php echo base_url('dist/jquery.table2excel.js') ?>"></script>
<script src="<?php echo base_url('dist/jspdf.debug.js') ?>"></script>
<script src="<?php echo base_url('dist/html2canvas.js') ?>"></script>


<script>
        function demoFromHTML() {// For PDF Generate
            $("#exportActionID").css("display", "none");
            let doc = new jsPDF('l', 'pt', 'a3');
            doc.addHTML(document.body, function() {
                doc.save('html.pdf');
            });
        }
        function myFunction(divName) {// For Print Generate
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
        $("#exportExcelID").click(function() {// For Excel Generate
            $(".table2excel").table2excel({
                // exclude CSS class
                exclude: ".noExl",
                name: "Worksheet Name",
                filename: "SomeFile" //do not include extension
            });
        });
        /* HTML to Microsoft Word Export Demo 
         * This code demonstrates how to export an html element to Microsoft Word
         * with CSS styles to set page orientation and paper size.
         * Tested with Word 2010, 2013 and FireFox, Chrome, Opera, IE10-11
         * Fails in legacy browsers (IE<10) that lack window.Blob object
         */
        window.export.onclick = function() {// For Word Generate

            if (!window.Blob) {
                alert('Your legacy browser does not support this action.');
                return;
            }

            var html, link, blob, url, css;

            // EU A4 use: size: 841.95pt 595.35pt;
            // US Letter use: size:11.0in 8.5in;

            css = (
                    '<style>' +
                    '@page WordSection1{size: 841.95pt 595.35pt;mso-page-orientation: landscape;}' +
                    'div.WordSection1 {page: WordSection1;}' +
                    'table{border-collapse:collapse;}td{border:1px gray solid;width:5em;padding:2px;}' +
                    '</style>'
                    );

            html = window.docx.innerHTML;
            blob = new Blob(['\ufeff', css + html], {
                type: 'application/msword'
            });
            url = URL.createObjectURL(blob);
            link = document.createElement('A');
            link.href = url;
            // Set default file name. 
            // Word will append file extension - do not add an extension here.
            link.download = 'Document';
            document.body.appendChild(link);
            if (navigator.msSaveOrOpenBlob)
                navigator.msSaveOrOpenBlob(blob, 'Document.doc'); // IE10-11
            else
                link.click();  // other browsers
            document.body.removeChild(link);
        };
</script>