<div class="text-right">
    <button style="margin-bottom: -40px;" type="button" class="btn btn-info btn-xs print">Print</button>
</div>
<div class="clearfix"></div>
<div id="printablediv">
    <style type="text/css">
        @media print, screen {
            body {
                font-size: 12pt;
                font-family: Arial, Helvetica, sans-serif;
            }

            h1, h2, h3, h4, h5, h6 {
                page-break-after: avoid;
                page-break-before: always;
            }

            p {
                page-break-inside: avoid;
            }

            table {
                font-family: Arial, sans-serif;
                font-size: 13px;
                border-collapse: collapse;
                width: 100%;
                border-spacing: 0;
            }

            .table td, table th {
                border: 1px solid black;
            }

            /* header style*/
            .header-area {
                display: block;
                width: 100%;
                margin-bottom: 25px;
            }

            .header-left {
                text-align: left;
            }

            .header-right {
                text-align: right;
            }

            .header-middle {
                text-align: center;
            }

            .title-group {
                line-height: 1.2;
                text-align: center;
                text-transform: uppercase;
            }

            .main-title {
                font-size: 17px;
                font-weight: bold;
                margin: 0;
            }

            .sub-title {
                font-size: 15px;
                font-weight: normal;
                margin: 0;
            }

            /* end header style*/
        }

        @media print {
            html, body {
                box-shadow: none;
                width: 210mm;
                height: 297mm;
            }

            .page[size="A4"][layout="portrait"] {
                width: 8.5in;
                height: 11in;
                padding: .5in 16mm 16mm 16mm;

            @page {
                size: A4;
                margin: 0;
            }

        ;
        }

        .page[size="A4"][layout="landscape"] {
            width: 11in;
            height: 8.5in;
            padding: .5in 16mm 16mm 16mm;
            @page {
                size: A4;
                margin: 0;
            }
        }
    }
    </style>
    <div class="page" size="A4" layout="portrait">
        <div class="title-group" style="text-decoration: underline; font-weight: bold">
            <p class="main-title">Daily Report - Data Entry</p>
        </div>
        <br>
        <table class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th rowspan="2" style="text-align: center; vertical-align: middle">Ser</th>
                <th rowspan="2" style="text-align: center; vertical-align: top">User Name</th>
                <th rowspan="2" style="text-align: center; vertical-align: top">Transaction Field</th>
                <th style="text-align: center; vertical-align: middle" colspan="6">Input</th>
                <th style="text-align: center; vertical-align: middle" colspan="4">Output</th>
                <th style="text-align: center; vertical-align: middle">Entry User</th>
                <th style="text-align: center; vertical-align: middle">Entry Date</th>
                <th style="text-align: center; vertical-align: middle">Remarks</th>
            </tr>
            <tr>
                <th style="text-align: center; vertical-align: top">Date</th>
                <th style="text-align: center; vertical-align: top">Time</th>
                <th style="text-align: center; vertical-align: top">Total Entry</th>
                <th style="text-align: center; vertical-align: top">Details Sailor</th>

                <!--<th style="text-align: center; vertical-align: top">Transaction Field</th>-->
                <th style="text-align: center; vertical-align: top">Date</th>
                <th style="text-align: center; vertical-align: top">Time</th>
                <th style="text-align: center; vertical-align: top">Total Output</th>
                <th style="text-align: center; vertical-align: top">Details Sailor</th>

                <th style="text-align: center; vertical-align: top"></th>
                <th style="text-align: center; vertical-align: top"></th>
                <th style="text-align: center; vertical-align: top"></th>
                <th style="text-align: center; vertical-align: top"></th>
                <th style="text-align: center; vertical-align: top"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 0;
            foreach ($entryStateResult as $key => $row) { ?>
                <tr>
                    <td><?php echo ++$i; ?></td>
                    <td><?php echo $row->CRE_BY ?></td>
                    <td><?php echo $row->TranField ?></td>
                    <td><?php echo $row->CRE_DT ?></td>
                    <td><?php echo $row->CRE_TM ?></td>
                    <td><?php echo $row->TotalEntry ?></td>
                    <td>O No <?php echo preg_replace( '/[^0-9]/', '',  $row->CRE_BY ) ?></td>

                    <td><?php echo $row->UPD_DT ?></td>
                    <td><?php echo $row->UPD_TM ?></td>
                    <td><?php echo $row->TotUpd ?></td>
                    <td>O No <?php echo preg_replace( '/[^0-9]/', '',  $row->UPD_BY ) ?></td>

                    <td><?php echo $row->CRE_BY ?></td>
                    <td><?php echo $row->CRE_DT ?></td>

                    <td></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
