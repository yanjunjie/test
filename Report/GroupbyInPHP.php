//rowspan count for each branch using groupby
        function rowspan_count_groupby($query_result, $countable, $ship_name, $unit_name, $branch_name)
        {
            $newarr = [];
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

            //units
            foreach ($ships as $key=>$row)
            {
                foreach ($row as $item)
                {
                    if($item == $unit_name)
                    {
                        array_push($units, $row); //units
                    }

                }
            }

            //branches
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




            /*die(var_dump($ships, $units, $branches));
            $counts_each_branch = array_count_values($newarr[$group_val1][$group_val2]);
            $total_branch = $counts_each_branch[$query_value];
            return $total_branch;*/
        }


//Uses of it...
<!--<td><?php /*echo $value->ShipName */?></td>-->
<?php
//$total = rowspan_count($nominalRoll, 'ShipName', $value->ShipName);
$total = rowspan_count_groupby($nominalRoll, 'ship', $value->ShipName, $value->PostingName, $value->Branch);
if (!empty($count))
$count--;
else
{
echo "<td rowspan=" . $total . ">" . $value->ShipName . "</td>";
$count = $total-1;
}
?>

