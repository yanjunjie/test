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
    //die(var_dump($ship_value, $unit_value, $branch_value));

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

//rearrange nominal records
$reNominalRoll = [];
foreach ($area as $key_area => $row_area) {
    foreach ($nominalRoll as $key => $value) {
        if ($row_area->ADMIN_ID == $value->AREA_ID) {
            array_push($reNominalRoll, $value);
        }
    }
}


$count = 0;
$count2 = 0;
$count3 = 0;

$total = 0;
$total2 = 0;
$total3 = 0;

$ship = 0;
$unit = 0;
$branch = 0;

$gTotalBorn = 0;
$gTotalSanc = 0;
$bTotalBorn = 0;
$bTotalSanc = 0;

foreach ($arr_zone_area as $key_area => $row_area)
{
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
    $status = 0;
    $newTotal = 0;
    foreach ($reNominalRoll as $key => $value) {
        if ($row_area->ADMIN_ID == $value->AREA_ID) {
            $gTotalBorn += (int)$value->Borne;
            $gTotalSanc += (int)$value->sanction;

            $total = rowspan_count_groupby(array_slice($reNominalRoll,$key, null, true), 'ship', $value->ShipName, $value->PostingName, $value->Branch);
            $total2 = rowspan_count_groupby(array_slice($reNominalRoll,$key, null, true), 'unit', $value->ShipName, $value->PostingName, $value->Branch);
            $total3 = rowspan_count_groupby(array_slice($reNominalRoll,$key, null, true), 'branch', $value->ShipName, $value->PostingName, $value->Branch);

            //die(var_dump($total,$total2,$total3));

            /*$total = rowspan_count_groupby($reNominalRoll, 'ship', 'ShipName', 'PostingName', 'Branch');
            $total2 = rowspan_count_groupby($reNominalRoll, 'unit', 'ShipName', 'PostingName', 'Branch');
            $total3 = rowspan_count_groupby($reNominalRoll, 'branch', 'ShipName', 'PostingName', 'Branch');*/

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

                <td><?php echo $value->Rank ?></td>
                <td><?php echo $value->Part ?></td>
                <td><?php echo $value->sanction;
                    $bTotalSanc += (int)$value->sanction; ?>
                    <input class="sancSubTotal" type="hidden" value="<?php echo $bTotalSanc; ?>">
                </td>
                <td>
                    <?php echo $value->Borne;
                    $bTotalBorn += (int)$value->Borne; ?>
                    <input class="borneSubTotal" type="hidden" value="<?php echo $bTotalBorn; ?>">
                </td>
                <td><?php echo $value->TotalIn ?></td>
                <td><?php echo $value->TotalOut ?></td>
            </tr>

            <!--Branch Total Row-->
            <?php

            if ($count3 == 0) {

                /*echo "<tr>";
                echo "<td style='color:#000;font-weight: bold;'>Branch Total</td>";
                echo "<td style='color:#000;font-weight: bold;'>" . $bTotalSanc . "</td>";
                echo "<td style='color:#000;font-weight: bold;'>" . $bTotalBorn . "</td>";
                echo "<td style='color:#000;font-weight: bold;'></td>";
                echo "<td style='color:#000;font-weight: bold;'></td>";
                echo "<td style='color:#000;font-weight: bold;'></td>";
                echo "</tr>";*/

                $bTotalSanc = 0;
                $bTotalBorn = 0;
            }
        }
    }
    }
    ?>

    <!--Grand Total Row-->
    <!--<tr>
        <td style="text-align: center; font-weight: bold;" colspan="5">Grand Total</td>
        <td style="text-align: center; font-weight: bold;"><?php /*echo $gTotalSanc; */?></td>
        <td style="text-align: center; font-weight: bold;"><?php /*echo $gTotalBorn; */?></td>
        <td></td>
        <td></td>
    </tr>-->
    </tbody>
</table>

<br><br>

<script>
    /*$(document).ready(function () {
        let allrow = $('body .allrow');

        /!*$('.allrow').filter(function(){
            return $('[rowspan]', this).length > 2;
        }).addClass('ships');*!/

        // add ships class
        $('.allrow').each(function() {
            if ($(this).find('td[rowspan]').length > 2) {
                $(this).addClass('ships');
            }
        });
        // end add ships class

        // add units class
        if (allrow.hasClass('ships')) {
            $('.ships').each(function () {
                let thisShip = $(this);
                let allTrBetweenTwoShip = thisShip.nextUntil(thisShip).addBack();

                // add new new class 'units'
                allTrBetweenTwoShip.each(function () {

                    // below conditions for identify the unit based on rowspan length
                    if ($(this).find('td[rowspan]').length == 2) {
                        if (parseInt($(this).find('td[rowspan]:first').attr('rowspan')) > 1) {
                            $(this).addClass('units');
                        }
                    }

                    if ($(this).find('td[rowspan]').length == 3) {
                        if (parseInt($(this).find('td[rowspan]:eq(1)').attr('rowspan')) > 1) {
                            $(this).addClass('units');
                        }
                    }
                });
            });
        }
        // end add units class

        // add expected row class
        if (allrow.hasClass('units')) {

            // add new class 'expectedRow'
            allrow.each(function () {
                let thisRow = $(this);
                let thisIndex = $(this).index();
                let firstColUnit = '';
                let secondColUnit = '';
                if ($(this).find('td[rowspan]').length == 2) {
                    firstColUnit = $(this).find('td:eq(0)');
                    secondColUnit = $(this).find('td:eq(1)');
                }

                if ($(this).find('td[rowspan]').length == 3) {
                    firstColUnit = $(this).find('td:eq(1)');
                    secondColUnit = $(this).find('td:eq(2)');
                }

                let firstColRowspanUnit = firstColUnit ? parseInt(firstColUnit.attr('rowspan')) : 0;
                let secondColRowspanUnit = secondColUnit ? parseInt(secondColUnit.attr('rowspan')) : 0;

                // expectedRow class added here
                if (thisRow.hasClass('units')) {
                    let expectedIndex = parseInt(thisIndex) + firstColRowspanUnit;
                    let expectedRow = $('.allrow:eq(' + (expectedIndex - 1) + ')');
                    expectedRow.addClass('expectedRow');
                }
            });
        }
        // end add expected row class

        // add branch total row after each 'expectedRow' class
        if (allrow.hasClass('expectedRow')) {
            $('.expectedRow').each(function () {
                let thisRow = $(this);
                let prevShip = thisRow.prevAll('.ships:first');
                let prevUnit = thisRow.prevAll('.units:first');
                let prevBranch = thisRow.prevAll('.units:first');

                let sancSubTotal = thisRow.find('.sancSubTotal').val();
                let borneSubTotal = thisRow.find('.borneSubTotal').val();

                sancSubTotal = sancSubTotal?sancSubTotal:0;
                borneSubTotal = borneSubTotal?borneSubTotal:0;

                // thisRow.after('<tr><td colspan="6"><strong>Branch Total</strong></td></tr>');

                // unit total
                thisRow.after('<tr>'+
                    '<td><strong>Unit Total</strong></td>'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td><strong>'+sancSubTotal+'</strong></td>'+
                    '<td><strong>'+borneSubTotal+'</strong></td>'+
                    '<td></td>'+
                    '<td></td>'+
                    '</tr>');

                // branch total
                thisRow.after('<tr>'+
                    '<td><strong>Branch Total</strong></td>'+
                    '<td></td>'+
                    '<td><strong>'+sancSubTotal+'</strong></td>'+
                    '<td><strong>'+borneSubTotal+'</strong></td>'+
                    '<td></td>'+
                    '<td></td>'+
                    '</tr>');

                // below conditions for identify the unit based on rowspan length
                if (prevUnit.find('td[rowspan]').length == 2) {
                    // ship rowspan incremented by 1
                    let prevShipRowspan = parseInt(prevShip.find('td:first').attr('rowspan'));
                    let newPrevShipRowspan = prevShipRowspan+2;
                    prevShip.find('td:first').attr('rowspan',newPrevShipRowspan);

                    // unit rowspan incremented by 2
                    let unitRowspan = parseInt(prevUnit.find('td:first').attr('rowspan'));
                    let newUnitRowspan = unitRowspan+2;
                    prevUnit.find('td:first').attr('rowspan',newUnitRowspan);

                    // branch rowspan incremented by 1
                    let branchRowspan = parseInt(prevUnit.find('td:eq(1)').attr('rowspan'));
                    let newBranchRowspan = branchRowspan+1;
                    prevBranch.find('td:eq(1)').attr('rowspan',newBranchRowspan);
                }

                else if (prevUnit.find('td[rowspan]').length == 3) {
                    // ship rowspan incremented by 2
                    let prevShipRowspan = parseInt(prevShip.find('td:first').attr('rowspan'));
                    let newPrevShipRowspan = prevShipRowspan+2;
                    prevShip.find('td:first').attr('rowspan',newPrevShipRowspan);

                    // unit rowspan incremented by 2
                    let unitRowspan = parseInt(prevUnit.find('td:eq(1)').attr('rowspan'));
                    let newUnitRowspan = unitRowspan+2;
                    prevUnit.find('td:eq(1)').attr('rowspan',newUnitRowspan);

                    // branch rowspan incremented by 1
                    let branchRowspan = parseInt(prevBranch.find('td:eq(2)').attr('rowspan'));
                    let newBranchRowspan = branchRowspan+1;
                    prevBranch.find('td:eq(2)').attr('rowspan',newBranchRowspan);
                }
            });
        }
        // end add branch total row

    });*/
</script>
