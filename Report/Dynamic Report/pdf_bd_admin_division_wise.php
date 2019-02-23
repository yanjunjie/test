<div style="text-align: right;">
    <input type="Submit" name="Submit" value="Print" id="print" onclick='printDivSecond();'>
</div>


<div id="printallsection">
    <?php if ($showGrid == 0) { ?>

        <style type="text/css">
            #aca_tbl th, #aca_tbl td {
                border: 1px solid black;
                padding: 5px;
            }

            #aca_tbl {
                border-collapse: collapse;
            }
        </style>
    <?php } ?>
    <style type="text/css">
        #footer {
            text-align: center;
        }

        .footer-text {
            text-align: center;
        }
    </style>
    <table width="100%" style="vertical-align: bottom; color: #000000; font-weight: bold; font-style: italic;">

        <tr>
            <td width="33%"></td>
            <td width="33%" align="center" style="font-weight: bold; font-family: serif; font-size: 10pt;"><?php echo $headerText; ?></td>
            <td width="33%"></td>
        </tr>

        <tr>
            <td width="33%"></td>
            <td width="33%" align="center" style="font-weight: bold; font-family: serif; font-size: 10pt;"><h4><u><b><?php echo $reportTitle; ?></b></u></h4></td>
            <td width="33%"></td>
        </tr>
        <tr>
            <td width="33%"></td>
            <td width="33%" align="center" style="font-weight: bold; font-family: serif; font-size: 10pt;"><h4 style="margin-top: -7px !important;"><u><b><?php echo $reportSubTitle; ?></b></u></h4></td>
            <td width="33%"></td>
        </tr>

        <tr>
            <td></td>
            <td></td>
            <td align="right">
                <u>
                    <?php if ($reportDate == '1') {
                        echo "Report Date : ";
                        echo date('Y-m-d');
                    } ?>
                </u>
            </td>

        </tr>

    </table>
    <hr>

    <table class="table" width="100%" cellspacing="0" id="aca_tbl">
        <thead>
        <tr>
            <th>Division</th>
            <th>District</th>
            <th>HLT</th>
            <th>HSLT</th>
            <th>MCPO</th>
            <th>SCPO</th>
            <th>CPO</th>
            <th>PO</th>
            <th>LDG</th>
            <th>AB</th>
            <th>OD</th>
            <th>OD/UT</th>
            <th>DE/UC</th>
            <th>Total</th>
        </tr>
        </thead>

        <tbody>
        <?php
        $gTHLT = 0;
        $gTHSLT = 0;
        $gTMCPO = 0;
        $gTSCPO = 0;
        $gTCPO = 0;
        $gTPO = 0;
        $gTLDG = 0;
        $gTAB = 0;
        $gTOD = 0;
        $gTODUT = 0;
        $gTDEUC = 0;
        $gTTotal = 0;

        $count = 0;
        $division_id = 0;
        $tHLT = 0;
        $tHSLT = 0;
        $tMCPO = 0;
        $tSCPO = 0;
        $tCPO = 0;
        $tPO = 0;
        $tLDG = 0;
        $tAB = 0;
        $tOD = 0;
        $tODUT = 0;
        $tDEUC = 0;
        $tTotal = 0;

        $newarr = [];
        foreach ($dbAdmin as $key=>$value)
        {
            $newarr[] =  $value->DIVISIONID;
        }
        $counts_division_id = array_count_values($newarr);

        ?>
        <?php foreach ($dbAdmin as $key => $row) { ?>
            <tr>
                <?php
                //$total = $row->totalDis;
                $total = $counts_division_id[$row->DIVISIONID];
                if ($count != 0)
                {
                    $count--;
                }
                else
                {
                    echo "<td rowspan=" . ($total + 1) . ">" . $row->Division . "</td>";
                    $count = $total - 1;
                }

                ?>
                <td><?php echo $row->District; ?></td>
                <td><?php echo $row->HLT; ?></td>
                <td><?php echo $row->HSLT; ?></td>
                <td><?php echo $row->MCPO; ?></td>
                <td><?php echo $row->SCPO; ?></td>
                <td><?php echo $row->CPO; ?></td>
                <td><?php echo $row->PO; ?></td>
                <td><?php echo $row->LDG; ?></td>
                <td><?php echo $row->AB; ?></td>
                <td><?php echo $row->OD; ?></td>
                <td><?php echo $row->ODUT; ?></td>
                <td><?php echo $row->DEUC; ?></td>
                <td><?php echo $row->Total; ?></td>
            </tr>

            <?php
                $tHLT += $row->HLT;
                $tHSLT += $row->HSLT;
                $tMCPO += $row->MCPO;
                $tSCPO += $row->SCPO;
                $tCPO += $row->CPO;
                $tPO += $row->PO;
                $tLDG += $row->LDG;
                $tAB += $row->AB;
                $tOD += $row->OD;
                $tODUT += $row->ODUT;
                $tDEUC += $row->DEUC;
                $tTotal += $row->Total;

                $gTHLT += $row->HLT;
                $gTHSLT += $row->HSLT;
                $gTMCPO += $row->MCPO;
                $gTSCPO += $row->SCPO;
                $gTCPO += $row->CPO;
                $gTPO += $row->PO;
                $gTLDG += $row->LDG;
                $gTAB += $row->AB;
                $gTOD += $row->OD;
                $gTODUT += $row->ODUT;
                $gTDEUC += $row->DEUC;
                $gTTotal += $row->Total;

                if ($count == 0) {
                    echo "<tr>";
                    echo "<td style='color:#000;'><b>Division Total</b></td>";
                    echo "<td style='color:#000;'><b>" . $tHLT . "</b></td>";
                    echo "<td style='color:#000;'><b>" . $tHSLT . "</b></td>";
                    echo "<td style='color:#000;'><b>" . $tMCPO . "</b></td>";
                    echo "<td style='color:#000;'><b>" . $tSCPO . "</b></td>";
                    echo "<td style='color:#000;'><b>" . $tCPO . "</b></td>";
                    echo "<td style='color:#000;'><b>" . $tPO . "</b></td>";
                    echo "<td style='color:#000;'><b>" . $tLDG . "</b></td>";
                    echo "<td style='color:#000;'><b>" . $tAB . "</b></td>";
                    echo "<td style='color:#000;'><b>" . $tOD . "</b></td>";
                    echo "<td style='color:#000;'><b>" . $tODUT . "</b></td>";
                    echo "<td style='color:#000;'><b>" . $tDEUC . "</b></td>";
                    echo "<td style='color:#000;'><b>" . $tTotal . "</b></td>";
                    echo "</tr>";

                    $tHLT = 0;
                    $tHSLT = 0;
                    $tMCPO = 0;
                    $tSCPO = 0;
                    $tCPO = 0;
                    $tPO = 0;
                    $tLDG = 0;
                    $tAB = 0;
                    $tOD = 0;
                    $tODUT = 0;
                    $tDEUC = 0;
                    $tTotal = 0;
                }

            }

                echo "<tr>";
                echo "<td>&nbsp;</td>";
                echo "<td style='color:#000;'><b>Grand Total</b></td>";
                echo "<td style='color:#000;'><b>" . $gTHLT . "</b></td>";
                echo "<td style='color:#000;'><b>" . $gTHSLT . "</b></td>";
                echo "<td style='color:#000;'><b>" . $gTMCPO . "</b></td>";
                echo "<td style='color:#000;'><b>" . $gTSCPO . "</b></td>";
                echo "<td style='color:#000;'><b>" . $gTCPO . "</b></td>";
                echo "<td style='color:#000;'><b>" . $gTPO . "</b></td>";
                echo "<td style='color:#000;'><b>" . $gTLDG . "</b></td>";
                echo "<td style='color:#000;'><b>" . $gTAB . "</b></td>";
                echo "<td style='color:#000;'><b>" . $gTOD . "</b></td>";
                echo "<td style='color:#000;'><b>" . $gTODUT . "</b></td>";
                echo "<td style='color:#000;'><b>" . $gTDEUC . "</b></td>";
                echo "<td style='color:#000;'><b>" . $gTTotal . "</b></td>";
                echo "</tr>";

            ?>

        </tbody>
    </table>

    <div>
        <?php // echo $headerText; ?>
        <p style="min-height:50px; text-align: center;"><?php echo $footerText; ?></p>
    </div>

</div>
<script type="text/javascript">

    function printDivSecond() {
        var divToPrint = document.getElementById('printallsection');
        var newWin = window.open('', 'Print-Window');
        newWin.document.open();
        newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');
        newWin.document.close();

        setTimeout(function () {
            newWin.close();
        }, 10);
    }
</script>
       