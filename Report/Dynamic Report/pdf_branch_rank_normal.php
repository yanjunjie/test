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
        <td width="33%" align="center" style="font-weight: bold; font-family: serif; font-size: 10pt;"><?php echo $reportTitle; ?></td>
        <td width="33%"></td>
    </tr>
    <tr>
        <td width="33%"></td>
        <td width="33%" align="center" style="font-weight: bold; font-style: italic; font-size: 8pt;"><?php echo $reportSubTitle; ?></td>
        <td width="33%"></td>
    </tr>

</table>

<style type="text/css">
    #aca_tbl, #aca_tbl th, #aca_tbl td {
        border: 1px solid black;
        padding: 5px;
    }

    #aca_tbl {
        border-collapse: collapse;
    }
</style>

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
        $gTotalBorn =  0;
        $gTotalSanc =  0;

        $bTotalBorn =  0;
        $bTotalSanc =  0;

        // rowspan count
        $count = 0;
        $newarr = [];
        foreach ($branchNormal as $key=>$value)
        {
            $newarr[] =  $value->Branch;
        }
        $counts_each_branch = array_count_values($newarr);


        foreach ($branchNormal as $key => $value)
        {
            $gTotalBorn += $value->Borne;
            $gTotalSanc += $value->sanction;
            ?>
            <tr>
                <?php
                $total = $counts_each_branch[$value->Branch];

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
        <tr>
            <td style="text-align: center; font-weight: bold;" colspan="3">Grand Total</td>
            <td style="text-align: center; font-weight: bold;"><?php echo $gTotalSanc ?></td>
            <td style="text-align: center; font-weight: bold;"><?php echo $gTotalBorn ?></td>
            <td></td>
        </tr>
    </tbody>
</table>
<br><br>


<!--<tbody>
        <?php
        $tSanc = 0;
        $tBorne = 0;
        $gtSanc = 0;
        $gtBorne = 0;
        ?>
        <?php
        $arr = array();
        $branch = array();
        $rank = array();
        $part = array();
        $sanc = array();
        $borne = array();
        $remarks = array();

        foreach ($branchNormal as $key => $row) {
            array_push($branch, $row->Branch);
            array_push($rank, $row->Rank);
            array_push($part, $row->Part);
            array_push($borne, $row->Borne);
            //array_push($sanc, $sanctionInfo);
            array_push($sanc, $row->sanction);
            array_push($remarks, '');

            // increment rowspan
            if (empty($arr[$row->Branch])) {
                $arr[$row->Branch]['rowspan'] = 1;
            } else {
                $arr[$row->Branch]['rowspan'] += 1;
                
                $arr[$row->Branch]['printed'] = 'no';
            }
        }


        for ($i = 0; $i < sizeof($branch); $i++) {
            $branchName = $branch[$i];

            echo "<tr>";

            // Branch Name
            if ($arr[$branchName]['printed'] == 'no') {
                echo "<td rowspan='" . ($arr[$branchName]['rowspan'] + 1) . "'>" . $branchName . "</td>";
                $arr[$branchName]['printed'] = 'yes';
                $rowspan = $arr[$branchName]['rowspan'];
            } else {
                $rowspan -= 1;
            }

            echo "<td>" . $rank[$i] . "</td>";
            echo "<td>" . $part[$i] . "</td>";
            echo "<td>" . $sanc[$i] . "</td>";
            echo "<td>" . $borne[$i] . "</td>";
            echo "<td>" . $remarks[$i] . "</td>";
            echo "</tr>";

            $tSanc += is_numeric($sanc[$i]) ? $sanc[$i] : 0;
            $tBorne += is_numeric($borne[$i]) ? $borne[$i] : 0;

            if ($rowspan == 1)
            {
                echo "<tr>";
                echo "<td style='color:#000;'><b>Branch Total</b></td>";
                echo "<td style='color:#000;'></td>";
                echo "<td style='color:#000;'><b>" . $tSanc . "</b></td>";
                echo "<td style='color:#000;'><b>" . $tBorne . "</b></td>";
                echo "<td style='color:#000;'></td>";
                echo "</tr>";
                $gtSanc += $tSanc;
                $gtBorne += $tBorne;
                $tBorne = 0;
                $tSanc = 0;
            }

            if (($i + 1) == count($branch)) {
                echo "<tr>";
                echo "<td colspan='2' style='color:#000; text-align: center'><b>Grand Total</b></td>";
                echo "<td style='color:#000;'></td>";
                echo "<td style='color:#000;'><b>" . $gtSanc . "</b></td>";
                echo "<td style='color:#000;'><b>" . $gtBorne . "</b></td>";
                echo "<td style='color:#000;'></td>";
                echo "</tr>";
            }
        }
        ?>
    </tbody>-->