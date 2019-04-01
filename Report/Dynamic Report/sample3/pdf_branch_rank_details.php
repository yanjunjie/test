<script src="<?php echo base_url('dist/scripts/jquery.min.js'); ?>"></script>
<style>
    #footer {
        text-align: center;
    }

    .footer-text {
        text-align: center;
    }

    #aca_tbl th, #aca_tbl td {
        border: 1px solid black;
        padding: 5px;
    }

    #aca_tbl {
        border-collapse: collapse;
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

<?php
//rowspan count for each branch
function rowspan_count($query_result, $query_attr, $query_value)
{
    $newarr = [];
    foreach ($query_result as $key => $value) {
        $newarr[] = $value->$query_attr;
    }
    $counts_each_branch = array_count_values($newarr);
    $total_branch = $counts_each_branch[$query_value];
    return $total_branch;
}

//rowspan count for each branch using groupby
function rowspan_count_groupby($query_result, $countable, $ship_value, $unit_value, $branch_value)
{

    $ships = [];
    $units = [];
    $branches = [];

    //ship
    $previousShipValue = '';
    foreach ($query_result as $key => $row) {
        //$currentShipValue = $row->{$ship_value};

        $arr_row = (array)$row;
        if (in_array($ship_value, $arr_row)) {
            $currentShipValue = $ship_value;
        } else {
            $currentShipValue = '';
        }

        if($previousShipValue) {
            if($currentShipValue == $previousShipValue) {
                array_push($ships, $row); //ship
            } else {
                break;
            }
        } else {
            array_push($ships, $row); //ship, first value
        }

        $previousShipValue = $currentShipValue;
    }

    //units based on ship
    if(!empty($ships))
    {
        $previousUnitValue = '';
        foreach ($ships as $key => $row) {
            /*$arr_row = (array)$row;
              if (in_array($unit_name, $arr_row)) {
              array_push($units, $row); //units
           }*/
            //$currentUnitValue = $row->{$unit_value};

            $arr_row = (array)$row;
            if (in_array($unit_value, $arr_row)) {
                $currentUnitValue = $unit_value;
            } else {
                $currentUnitValue = '';
            }

            if($previousUnitValue) {
                if($currentUnitValue == $previousUnitValue) {
                    array_push($units, $row); //units
                } else {
                    break;
                }
            } else {
                array_push($units, $row); //units, first value
            }

            $previousUnitValue = $currentUnitValue;
        }
    }


    //branches based on unit
    if(!empty($units)) {
        $previousBranchValue = '';
        foreach ($units as $key => $row) {
            //$currentBranchValue = $row->{$branch_value};

            $arr_row = (array)$row;
            if (in_array($branch_value, $arr_row)) {
                $currentBranchValue = $branch_value;
            } else {
                $currentBranchValue = '';
            }

            if($previousBranchValue) {
                if($currentBranchValue == $previousBranchValue) {
                    array_push($branches, $row); //branch
                } else {
                    break;
                }
            } else {
                array_push($branches, $row); //branch, first value
            }

            $previousBranchValue = $currentBranchValue;
        }
    }

    if ($countable == 'ship') {
        return count($ships);
    } else if ($countable == 'unit') {
        return count($units);
    } else if ($countable == 'branch') {
        return count($branches);
    } else {
        return 1;
    }
}

// zone and area name
$arr_zone_area = [];
foreach ($area as $key_area => $row_area) {
    foreach ($nominalRoll as $key => $value) {
        if ($row_area->ADMIN_ID == $value->AREA_ID) {
            $arr_zone_area[$key_area] = (object)[
                'ZONE_NAME' => $row_area->ZONE_NAME,
                'AREA_NAME' => $row_area->AREA_NAME,
                'ADMIN_ID' => $row_area->ADMIN_ID,
            ];
        }
    }
}

/*// zone name
$arr_zone = [];
foreach ($zone as $key_zone => $row_zone) {
    foreach ($nominalRoll as $key => $value) {
        if ($row_zone->ADMIN_ID == $value->AREA_ID) {
            $arr_zone[$key_zone] = (object)[
                'ZONE_NAME' => $row_zone->NAME,
                'ADMIN_ID' => $row_zone->ADMIN_ID,
            ];
        }
    }
}*/




$gTotalBorn = 0;
$gTotalSanc = 0;
$gTotalIn = 0;
$gTotalOut = 0;


$last_nomi_element = end($nominalRoll);
$last_nomi_element_key = key($nominalRoll);
//die(var_dump($last_nomi_element_key,count($nominalRoll)-1));
$gTotalBorn = $last_nomi_element->Borne;
$gTotalSanc = $last_nomi_element->sanction;
$gTotalIn = $last_nomi_element->TotalIn;
$gTotalOut = $last_nomi_element->TotalOut;

//die(print_r($nominalRoll));

//rearrange nominal records according to Area
/*$reNominalRoll = [];
foreach ($area as $key_area => $row_area) {
    foreach ($nominalRoll as $key => $value) {
        if ($row_area->ADMIN_ID == $value->AREA_ID) {
            array_push($reNominalRoll, $value);
        }
    }
}*/

//die(print_r($reNominalRoll));


$count = 0;
$count2 = 0;
$count3 = 0;

$total = 0;
$total2 = 0;
$total3 = 0;

$ship = 0;
$unit = 0;
$branch = 0;


$zoneTotalBorne = 0;
$zoneTotalSanc = 0;
$zoneTotalIn = 0;
$zoneTotalOut = 0;

$last_zone_element = end($arr_zone_area);
$last_zone_element_key = key($arr_zone_area);

foreach ($arr_zone_area as $key_area => $row_area)
{
    $areaTotalBorne = 0;
    $areaTotalSanc = 0;
    $areaTotalIn = 0;
    $areaTotalOut = 0;

?>

<table class="table" id="aca_tbl" width="100%" cellspacing="0">
    <thead>
    <tr>
        <th style="border: none; text-align: left" colspan="8"><?php echo "<br/>" . "Zone : " . $row_area->ZONE_NAME; ?></th>
        <th style="border: none; text-align: right"><?php echo "<br/>" . "Area : " . $row_area->AREA_NAME; ?></th>
    </tr>
    <tr>
        <th>Ship</th>
        <th>Unit</th>
        <th>Branch</th>
        <th>Rank</th>
        <th>Part-II</th>
        <th>Sanct.</th>
        <th>Brone</th>
        <th>In</th>
        <th>Out</th>
    </tr>
    </thead>
    <tbody>
    <?php

    foreach ($nominalRoll as $key => $value) {
        /*$gTotalBorn += (int)$value->Borne;
        $gTotalSanc += (int)$value->sanction;*/

        // filtering data area wise
        if ($row_area->ADMIN_ID == $value->AREA_ID) {
            $total = rowspan_count_groupby(array_slice($nominalRoll,$key, null, true), 'ship', $value->ShipName, $value->PostingName, $value->Branch);
            $total2 = rowspan_count_groupby(array_slice($nominalRoll,$key, null, true), 'unit', $value->ShipName, $value->PostingName, $value->Branch);
            $total3 = rowspan_count_groupby(array_slice($nominalRoll,$key, null, true), 'branch', $value->ShipName, $value->PostingName, $value->Branch);

            //die(var_dump($total,$total2,$total3));

            /*$total = rowspan_count_groupby($reNominalRoll, 'ship', 'ShipName', 'PostingName', 'Branch');
            $total2 = rowspan_count_groupby($reNominalRoll, 'unit', 'ShipName', 'PostingName', 'Branch');
            $total3 = rowspan_count_groupby($reNominalRoll, 'branch', 'ShipName', 'PostingName', 'Branch');*/

            /*area total*/
            if ($value->PostingName == 'Ship Total' && $last_nomi_element_key != $key) {
                $areaTotalBorne += $value->Borne;
                $areaTotalSanc += $value->sanction;
                $areaTotalIn += $value->TotalIn;
                $areaTotalOut += $value->TotalOut;
            }
            ?>
            <tr class="allrow">
                <!--Ship Col-->
                <?php
                if ($count != 0)
                    $count--;
                else {
                    echo "<td rowspan=" . ($total) . ">" . $value->ShipName . "</td>";
                    $count = $total - 1;
                }
                ?>

                <!--Posting Col-->
                <?php
                if ($count2 != 0) {
                    $count2--;
                } else {
                    echo "<td rowspan=" . ($total2) . ">" . $value->PostingName . "</td>";
                    $count2 = $total2 - 1;
                }
                ?>

                <!--Branch Col-->
                <?php
                if ($count3 != 0)
                    $count3--;
                else {
                    echo "<td rowspan=" . ($total3) . ">" . $value->Branch . "</td>";
                    $count3 = $total3 - 1;
                    $status = 1;
                }
                ?>

                <td><?php echo $value->RANK_NAME ?></td>
                <td><?php echo $value->Part ?></td>
                <td><?php echo $value->sanction; ?></td>
                <td><?php echo $value->Borne; ?></td>
                <td><?php echo $value->TotalIn ?></td>
                <td><?php echo $value->TotalOut ?></td>
            </tr>

            <?php

            /*if ($count3 == 0) {
                //Branch Total Row
                echo "<tr>";
                echo "<td style='color:#000;font-weight: bold;'>Branch Total</td>";
                echo "<td style='color:#000;font-weight: bold;'>" . $bTotalSanc . "</td>";
                echo "<td style='color:#000;font-weight: bold;'>" . $bTotalBorn . "</td>";
                echo "<td style='color:#000;font-weight: bold;'></td>";
                echo "<td style='color:#000;font-weight: bold;'></td>";
                echo "<td style='color:#000;font-weight: bold;'></td>";
                echo "</tr>";

                $bTotalSanc = 0;
                $bTotalBorn = 0;
            }*/
            }
        }
        ?>

        <!--Area Total Row-->
        <tr>
            <td style="text-align: center; font-weight: bold;" colspan="5">Area Total</td>
            <td style="text-align: left; font-weight: bold;"><?php echo $areaTotalSanc; ?></td>
            <td style="text-align: left; font-weight: bold;"><?php echo $areaTotalBorne; ?></td>
            <td style="text-align: left; font-weight: bold;"><?php echo $areaTotalIn; ?></td>
            <td style="text-align: left; font-weight: bold;"><?php echo $areaTotalOut; ?></td>
        </tr>

            <?php

                $zoneTotalBorne += $areaTotalBorne;
                $zoneTotalSanc += $areaTotalSanc;
                $zoneTotalIn += $areaTotalIn;
                $zoneTotalOut += $areaTotalOut;

                $total_zone = rowspan_count($arr_zone_area, 'ZONE_NAME', $row_area->ZONE_NAME);

                if (!empty($total_zone_count)) {
                    $total_zone_count--;
                } else {
                    $total_zone_count = $total_zone - 1;
                }

            if ($total_zone_count == 0) {
                ?>
                <!--Zone Total Row-->
                <tr>
                    <td style="text-align: center; font-weight: bold;" colspan="5">Zone Total</td>
                    <td style="text-align: left; font-weight: bold;"><?php echo $zoneTotalSanc; ?></td>
                    <td style="text-align: left; font-weight: bold;"><?php echo $zoneTotalBorne; ?></td>
                    <td style="text-align: left; font-weight: bold;"><?php echo $zoneTotalIn; ?></td>
                    <td style="text-align: left; font-weight: bold;"><?php echo $zoneTotalOut; ?></td>
                </tr>
                <?php

                $zoneTotalBorne = 0;
                $zoneTotalSanc= 0;
                $zoneTotalIn= 0;
                $zoneTotalOut= 0;
            }
    }
    ?>

    <!--Grand Total Row-->
    <tr>
        <td style="text-align: center; font-weight: bold;" colspan="5">Grand Total</td>
        <td style="text-align: left; font-weight: bold;"><?php echo $gTotalSanc; ?></td>
        <td style="text-align: left; font-weight: bold;"><?php echo $gTotalBorn; ?></td>
        <td style="text-align: left; font-weight: bold;"><?php echo $gTotalIn; ?></td>
        <td style="text-align: left; font-weight: bold;"><?php echo $gTotalOut; ?></td>
    </tr>
    </tbody>
</table>

<br><br>

<script>
    $(document).ready(function () {

        // Branch Total
        $("tbody tr td").each(function() {
            var thisTr = $(this).parent();
            var tdText = $(this).text();
            if ($.trim(tdText) == "Branch Total") {
                $(thisTr).find('td').slice(1, 2).remove();
                $(this).attr("colspan", 2).css({"text-align":"left"});
                $(thisTr).find('td').css({"font-weight":"bold"});
            }
        });

        // Unit Total
        $("tbody tr td").each(function() {
            var thisTr = $(this).parent();
            var tdText = $(this).text();
            if ($.trim(tdText) == "Unit Total") {
                $(thisTr).find('td').slice(1, 2).remove();
                $(this).attr("colspan", 3).css({"text-align":"left"});
                $(thisTr).find('td').css({"font-weight":"bold"});
            }
        });

        // Ship Total
        $("tbody tr td").each(function() {
            var thisTr = $(this).parent();
            var tdText = $(this).text();
            if ($.trim(tdText) == "Ship Total") {
                $(thisTr).find('td').slice(1, 3).remove();
                $(this).attr("colspan", 4).css({"text-align":"left"});
                $(thisTr).find('td').css({"font-weight":"bold"});
            }
        });


        // Grand Total
        $("tbody tr td").each(function() {
            var thisTr = $(this).parent();
            var tdText = $(this).text();
            if ($.trim(tdText) == "GrandTotal") {
                $(thisTr).remove();
            }
        });

        // Grand Total
        /*$('tbody tr:last td').slice(1, 3).remove();
        $('tbody tr:last td:eq(0)').attr("colspan", 5).css({"text-align":"left", 'font-weight':'bold'});*/

    });
</script>