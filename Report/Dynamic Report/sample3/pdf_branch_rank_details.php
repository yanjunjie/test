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
$count = 0;
$count2 = 0;
$count3 = 0;

$total = 0;
$totol2 = 0;
$total3 = 0;

//echo $row_zone->NAME. "<br/>";
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

//rowspan count for each branch using groupby
function rowspan_count_groupby($query_result, $countable, $ship_name, $unit_name, $branch_name)
{
    $ships = [];
    $units = [];
    $branches = [];
    foreach ($query_result as $key=>$row)
    {
        //ship
        foreach ($row as $item)
        {
            if($item == $ship_name)
            {
                array_push($ships, $row); //ship
            }
        }
        //$newarr[$group_val1][$group_val2][] =  $row->$query_attr;
    }

    //units based on ship & branch
    foreach ($ships as $key=>$row)
    {
        $arr_row = (array)$row;
        if(in_array($unit_name, $arr_row) && in_array($branch_name, $arr_row)){
            array_push($units, $row); //units
        }
    }

    //branches based on ship & unit
    foreach ($units as $key=>$row)
    {
        foreach ($row as $item)
        {
            if($item == $branch_name)
            {
                array_push($branches, $row); //branch
            }

        }
    }

    if($countable == 'ship')
    {
        return count($ships);
    }
    else if($countable == 'unit')
    {
        return count($units);
    }
    else if($countable == 'branch')
    {
        return count($branches);
    }
    else
    {
        return true;
    }
}

// zone and area name
$arr_zone_area = [];
foreach ($area as $key_area=>$row_area)
{
    foreach ($nominalRoll as $key => $value)
    {
        if ($row_area->ADMIN_ID == $value->AREA_ID)
        {
            /*$arr_zone_area[$key_area]['ZONE_NAME'] = $row_area->ZONE_NAME;
            $arr_zone_area[$key_area]['AREA_NAME'] = $row_area->AREA_NAME;
            $arr_zone_area[$key_area]['ADMIN_ID'] = $row_area->ADMIN_ID;*/

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
foreach ($area as $key_area=>$row_area)
{
    foreach ($nominalRoll as $key => $value)
    {
        if ($row_area->ADMIN_ID == $value->AREA_ID)
        {
           array_push($reNominalRoll,$value);
        }
    }
}


foreach ($arr_zone_area as $key_area=>$row_area)
{
    ?>


    <table class="table" id="aca_tbl" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th style="border: none; text-align: left" colspan="8"><?php echo "<br/>"."Zone : ".$row_area->ZONE_NAME;?></th>
            <th style="border: none; text-align: right"><?php echo "<br/>"."Area : ".$row_area->AREA_NAME;?></th>
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

        //die(print_r($nominalRoll));
        foreach ($reNominalRoll as $key => $value)
        { ?>
            <tr>
                <!--<td><?php /*echo $value->ShipName */?></td>-->
                <?php
                //$total = rowspan_count($reNominalRoll, 'ShipName', $value->ShipName);
                $total = rowspan_count_groupby($nominalRoll, 'ship', $value->ShipName, $value->PostingName, $value->Branch);
                if (!empty($count))
                    $count--;
                else
                {
                    echo "<td rowspan=" . $total . ">" . $value->ShipName . "</td>";
                    $count = $total-1;
                }
                ?>

                <!--<td><?php /*echo $value->PostingName */?></td>-->
                <?php
                //$total2 = rowspan_count($nominalRoll, 'PostingName', $value->PostingName);
                $total2 = rowspan_count_groupby($reNominalRoll, 'unit', $value->ShipName, $value->PostingName, $value->Branch);
                if (!empty($count2))
                {
                    $count2--;
                }
                else
                {
                    echo "<td rowspan=" . $total2 . ">" . $value->PostingName . "</td>";
                    $count2 = $total2-1;
                }
                ?>

                <!--<td><?php /*echo $value->Branch */?></td>-->
                <?php
                //$total3 = rowspan_count($nominalRoll, 'Branch', $value->Branch);
                $total3 = rowspan_count_groupby($reNominalRoll, 'branch', $value->ShipName, $value->PostingName, $value->Branch);
                if (!empty($count3))
                    $count3--;
                else
                {
                    echo "<td rowspan=" . $total3 . ">" . $value->Branch . "</td>";
                    $count3 = $total3-1;
                }
                ?>

                <td><?php echo $value->Rank ?></td>
                <td><?php echo $value->Part ?></td>
                <td><?php echo $value->sanction ?></td>
                <td><?php echo $value->Borne ?></td>
                <td><?php echo $value->TotalIn ?></td>
                <td><?php echo $value->TotalOut ?></td>
            </tr>
        <?php }?>

        </tbody>
    </table>

<?php } ?>

<br><br>

