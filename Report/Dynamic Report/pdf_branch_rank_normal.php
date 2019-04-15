<div class="downloadable">
    <?php if ($showGrid == 0) { ?>

        <style type="text/css">
            #aca_tbl th, #aca_tbl td {
                border: 1px solid black;
                padding: 3px;
            }

            #aca_tbl {
                border-collapse: collapse;
                vertical-align: middle;
                color: #000000;
                text-align: center;
            }
            .grand_total {}
            .grand_total td{
                text-align: center; font-weight: bold;
            }
        </style>
    <?php } else {
        ?>
        <style>
            #aca_tbl {
                border-collapse: collapse;
            }
            #aca_tbl th {
                vertical-align: middle;
                text-align: left;
                padding-bottom: 10px;
            }
            .grand_total {}
            .grand_total td{
                text-align: left; font-weight: bold;
            }
        </style>
        <?php
    }
    ?>

    <div id="aca_tbl_header" class="title_area" style="font-family: serif; vertical-align: bottom; color: #000000; font-weight: bold; margin-bottom: 10px; line-height: 1.10;">
        <div style="text-align: center;">
            <div style="font-family: serif; font-size: 18px;"><?php echo $headerText; ?></div>
            <div style="font-size: 17px;"><?php echo $reportTitle; ?></div>
            <div style="font-style: italic; font-size: 15px;"><?php echo $reportSubTitle; ?></div>
        </div>
        <div>
            <div style="font-size: 14px; text-align: right;">
                <?php if ($reportDate == '1') {
                    echo "Report Date : ".date('d-m-Y');
                } ?>
            </div>
        </div>
    </div>

    <table id="aca_tbl" width="100%">
        <thead>
        <tr>
            <th>Branch</th>
            <th>Rank</th>
            <th>Part-II</th>
            <th>Saction</th>
            <th>Borne</th>
            <th>Remarks</th>
        </tr>
        </thead>

        <tbody>
        <?php

        //rowspan count for each branch
        function rowspan_count($query_result, $query_attr, $query_value)
        {
            $newarr = [];
            foreach ($query_result as $key=>$value)
            {
                $newarr[] =  $value->$query_attr;
            }
            $counts_each_branch = array_count_values($newarr);
            $total_branch = $counts_each_branch[$query_value];
            return $total_branch;
        }

        $gTotalBorn =  0;
        $gTotalSanc =  0;

        $bTotalBorn =  0;
        $bTotalSanc =  0;

        $count = 0;

        foreach ($branchNormal as $key => $value)
        {
            $gTotalBorn += $value->Borne;
            $gTotalSanc += $value->sanction;
            ?>
            <tr>
                <?php
                $total = rowspan_count($branchNormal, 'Branch',  $value->Branch);
                if ($count != 0)
                    $count--;
                else
                {
                    echo "<td rowspan=" . ($total + 1). ">" . $value->Branch . "</td>";
                    $count = $total-1;
                }
                ?>
                <td><?php echo $value->Rank ?></td>
                <td><?php echo $value->Part ?></td>
                <td><?php echo $value->sanction; $bTotalSanc += $value->sanction; ?></td>
                <td><?php echo $value->Borne; $bTotalBorn += $value->Borne;?></td>
                <td></td>
            </tr>

            <!--Branch Total Row-->
            <?php
            if ($count == 0)
            {
                echo "<tr>";
                echo "<td style='color:#000;font-weight: bold;'><b>Branch Total</b></td>";
                echo "<td style='color:#000;font-weight: bold;'></td>";
                echo "<td style='color:#000;font-weight: bold;'>".$bTotalSanc."</td>";
                echo "<td style='color:#000;font-weight: bold;'>".$bTotalBorn."</td>";
                echo "<td style='color:#000;font-weight: bold;'></td>";
                echo "</tr>";

                $bTotalSanc = 0;
                $bTotalBorn = 0;
            }
            ?>

        <?php }?>

        <!--Grand Total Row-->
        <tr class="grand_total">
            <td colspan="3">Grand Total</td>
            <td><?php echo $gTotalSanc ?></td>
            <td><?php echo $gTotalBorn ?></td>
            <td></td>
        </tr>
        </tbody>
    </table>

    <div id="aca_tbl_footer" style="margin-top: 20px;">
        <p style="min-height:50px; text-align: center;"><?php echo $footerText; ?></p>
    </div>
</div>