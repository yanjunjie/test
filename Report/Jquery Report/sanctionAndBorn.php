<style>
    #sailorTableArea {
        max-height: 300px;
        overflow-x: auto;
        overflow-y: auto;
    }

    #sailorTable {
        white-space: nowrap;
    }
    #print_header_area {
        display: none !important;
    }
</style>

<div class="col-sm-12 text-right">
    <button class="btn btn-success btn-xs printButton" style="margin-bottom: 10px;">Print</button>
</div>
<div class="clearfix"></div>

<div class="table-responsive" id="sailorTableArea">
    <div id="printablediv">
        <style media="screen,print">
            table {
                border-collapse: collapse;
            }

            table, td, th {
                border: 1px solid black;
            }
            table > thead > tr > th {
                padding-left: 5px !important;
            }

            table > tr > th {
                padding-left: 5px !important;
            }

            table > tbody > tr > td {
                padding-left: 5px !important;
            }

            table > tbody > tr > th {
                padding-left: 5px !important;
            }

            table.customTable {
                text-transform: uppercase;
            }
            #print_header_area{
                display: block;
                text-align: center;
                line-height: 1.20;
            }
        </style>

        <div id="print_header_area">
            <h3>Sanction & Borne Status</h3>
        </div>

        <table id="sailorTable" class="table table-striped table-bordered" width="100%">
            <?php

            $branchNameViewArrayData = explode(",", $partiiIDView);
            $arrySizeBranch = sizeof($branchNameViewArrayData);
            $queryData = "";
            $branchNameViewArrayDataRow = explode(",", $partiiIDView);
            for ($i = 0; $i < $arrySizeBranch; $i++) {

                $branchNameLatestDataR = array_pop($branchNameViewArrayDataRow);

                $queryData .= "COUNT(CASE WHEN bnb.BRANCH_ID = '$branchNameLatestDataR' THEN 1 ELSE NULL END) AS 'datavalue_$branchNameLatestDataR',";

            }

            $newarraynama = rtrim($queryData, ",");
            ?>
            <?php foreach ($shifIDSize as $row) {

                $latest_value = array_pop($shifIDSize);
                $branchNameLatestData = array_pop($branchNameViewArrayData);
                $sancAndBorne = $this->db->query("select * , count(sai.EQUIVALANTRANKID) as number, $newarraynama
		from sailor sai
		left join bn_branch bnb on bnb.BRANCH_ID= sai.BRANCHID
		left join bn_rank bnr on bnr.RANK_ID=sai.RANKID 
		left join partii part on part.PartIIID=sai.FIRSTPARTID
		where part.PartIIID in ($partiiIDView) and sai.SHIPESTABLISHMENTID in ($latest_value) group by sai.EQUIVALANTRANKID")->result();
                $afftedRow = $this->db->affected_rows();
                ?>

                <thead style="border-top: 1px solid #ddd;">
                <tr>
                    <th rowspan="2" colspan="1"></th>
                    <th rowspan="2" colspan="2">RANK</th>

                    <?php
                    $branchNameViewArray = explode(",", $partiiIDView);
                    foreach ($branchNameViewArray as $headerTop) {

                        $headerTopLatest = array_pop($branchNameViewArray);

                        $headeValue = $this->db->query("select Name partii_name from partii where PartIIID='$headerTopLatest'")->row();
                        ?>
                        <th colspan="2"><?php echo $headeValue->partii_name;
                            ?></th>
                    <?php } ?>

                    <th colspan="2">TOTAL</th>
                </tr>
                <tr>

                    <?php
                    $branchNameViewArrySecond = explode(",", $partiiIDView);
                    $arraySize = sizeof($branchNameViewArrySecond); ?>
                    <?php for ($i = 0; $i <= $arraySize; $i++) { ?>
                        <th>S</th>
                        <th>B</th>

                    <?php } ?>
                </tr>
                </thead>
                <tbody>
                <?php
                $arraySizeShip = sizeof($shifIDSize);
                ?>
                <tr>
                    <td colspan="" rowspan="16" style=" writing-mode: tb-rl; min-width: 26px;">
                        <?php $shipName = $this->db->query("select NAME FROM bn_ship_establishment where SHIP_ESTABLISHMENTID= '$latest_value'")->row();
                        echo $shipName->NAME;
                        ?>
                    </td>
                </tr>

                <tr>
                    <td colspan="2"><?php echo "MCPO"; ?></td>

                    <?php foreach ($sancAndBorne as $tablebody) {
                        if ($tablebody->EQUIVALANT_RANKID == "2") {
                            ?>
                            <?php $arraySize = sizeof($branchNameViewArrySecond);
                            $arrayTwo = $arraySize + $arraySize;
                            ?>

                            <?php
                            $branchNameViewArray = explode(",", $partiiIDView);
                            //array_shift();
                            $arrayReverse = array_reverse($branchNameViewArray);
                            foreach ($arrayReverse as $headerTop) {
                                $danamicBranchId = "datavalue_" . $headerTop;

                                ?>
                                <td>
                                    <?php

                                    echo $tablebody->$danamicBranchId;

                                    ?>

                                </td>
                                <td></td>

                            <?php } ?>


                            <td><?php echo $tablebody->number; ?></td>
                            <td></td>

                            <?php

                        }

                    } ?>

                </tr>
                <tr>

                    <td colspan="2">UD(+/-)</td>
                    <td></td>

                    <?php
                    $arraySize = sizeof($branchNameViewArrySecond);
                    $arrayTwoDuble = $arraySize + $arraySize;
                    ?>
                    <?php for ($i = 0; $i <= $arrayTwoDuble; $i++) { ?>
                        <td></td>
                    <?php } ?>

                </tr>
                <tr>
                    <td colspan="2"><?php echo "SCPO"; ?></td>


                    <?php foreach ($sancAndBorne as $tablebody) {
                        if ($tablebody->EQUIVALANT_RANKID == "10") {

                            ?>
                            <?php $arraySize = sizeof($branchNameViewArrySecond);
                            $arrayTwo = $arraySize + $arraySize;
                            ?>


                            <?php
                            $branchNameViewArray = explode(",", $partiiIDView);
                            //array_shift();
                            $arrayReverse = array_reverse($branchNameViewArray);
                            foreach ($arrayReverse as $headerTop) {
                                $danamicBranchId = "datavalue_" . $headerTop;

                                ?>
                                <td>
                                    <?php

                                    echo $tablebody->$danamicBranchId;

                                    ?>

                                </td>
                                <td></td>

                            <?php } ?>


                            <td><?php echo $tablebody->number; ?></td>
                            <td></td>

                            <?php


                        }
                    } ?>


                </tr>
                <tr>
                    <td colspan="2">UD(+/-)</td>
                    <td></td>

                    <?php
                    $arraySize = sizeof($branchNameViewArrySecond);
                    $arrayTwoDuble = $arraySize + $arraySize;
                    ?>
                    <?php for ($i = 0; $i <= $arrayTwoDuble; $i++) { ?>
                        <td></td>
                    <?php } ?>

                </tr>
                <tr>
                    <td colspan="2"><?php echo "CPO"; ?></td>

                    <?php foreach ($sancAndBorne as $tablebody) {
                        if ($tablebody->EQUIVALANT_RANKID == "3") {

                            ?>
                            <?php $arraySize = sizeof($branchNameViewArrySecond);
                            $arrayTwo = $arraySize + $arraySize;
                            ?>


                            <?php
                            $branchNameViewArray = explode(",", $partiiIDView);
                            //array_shift();
                            $arrayReverse = array_reverse($branchNameViewArray);
                            foreach ($arrayReverse as $headerTop) {
                                $danamicBranchId = "datavalue_" . $headerTop;

                                ?>
                                <td>
                                    <?php

                                    echo $tablebody->$danamicBranchId;

                                    ?>

                                </td>
                                <td></td>

                            <?php } ?>


                            <td><?php echo $tablebody->number; ?></td>
                            <td></td>

                            <?php


                        }
                    } ?>

                </tr>
                <tr>
                    <td colspan="2">UD(+/-)</td>
                    <td></td>

                    <?php
                    $arraySize = sizeof($branchNameViewArrySecond);
                    $arrayTwoDuble = $arraySize + $arraySize;
                    ?>
                    <?php for ($i = 0; $i <= $arrayTwoDuble; $i++) { ?>
                        <td></td>
                    <?php } ?>


                </tr>
                <tr>
                    <td colspan="2"><?php echo "PO"; ?></td>

                    <?php foreach ($sancAndBorne as $tablebody) {
                        if ($tablebody->EQUIVALANT_RANKID == "4") {

                            ?>
                            <?php $arraySize = sizeof($branchNameViewArrySecond);
                            $arrayTwo = $arraySize + $arraySize;
                            ?>


                            <?php
                            $branchNameViewArray = explode(",", $partiiIDView);
                            //array_shift();
                            $arrayReverse = array_reverse($branchNameViewArray);
                            foreach ($arrayReverse as $headerTop) {
                                $danamicBranchId = "datavalue_" . $headerTop;

                                ?>
                                <td>
                                    <?php

                                    echo $tablebody->$danamicBranchId;

                                    ?>

                                </td>
                                <td></td>

                            <?php } ?>


                            <td><?php echo $tablebody->number; ?></td>
                            <td></td>

                            <?php


                        }
                    } ?>

                </tr>
                <tr>
                    <td colspan="2">UD(+/-)</td>
                    <td></td>

                    <?php
                    $arraySize = sizeof($branchNameViewArrySecond);
                    $arrayTwoDuble = $arraySize + $arraySize;
                    ?>
                    <?php for ($i = 0; $i <= $arrayTwoDuble; $i++) { ?>
                        <td></td>
                    <?php } ?>

                </tr>
                <tr>
                    <td colspan="2"><?php echo "LS"; ?></td>

                    <?php foreach ($sancAndBorne as $tablebody) {
                        if ($tablebody->EQUIVALANT_RANKID == "5") {

                            ?>
                            <?php $arraySize = sizeof($branchNameViewArrySecond);
                            $arrayTwo = $arraySize + $arraySize;
                            ?>


                            <?php
                            $branchNameViewArray = explode(",", $partiiIDView);
                            //array_shift();
                            $arrayReverse = array_reverse($branchNameViewArray);
                            foreach ($arrayReverse as $headerTop) {
                                $danamicBranchId = "datavalue_" . $headerTop;

                                ?>
                                <td>
                                    <?php

                                    echo $tablebody->$danamicBranchId;

                                    ?>

                                </td>
                                <td></td>

                            <?php } ?>


                            <td><?php echo $tablebody->number; ?></td>
                            <td></td>

                            <?php


                        }
                    } ?>

                </tr>
                <tr>
                    <td colspan="2">UD(+/-)</td>
                    <td></td>

                    <?php
                    $arraySize = sizeof($branchNameViewArrySecond);
                    $arrayTwoDuble = $arraySize + $arraySize;
                    ?>
                    <?php for ($i = 0; $i <= $arrayTwoDuble; $i++) { ?>
                        <td></td>
                    <?php } ?>

                </tr>
                <tr>
                    <td colspan="2"><?php echo "AB"; ?></td>


                    <?php foreach ($sancAndBorne as $tablebody) {
                        if ($tablebody->EQUIVALANT_RANKID == "6") {

                            ?>
                            <?php $arraySize = sizeof($branchNameViewArrySecond);
                            $arrayTwo = $arraySize + $arraySize;
                            ?>


                            <?php
                            $branchNameViewArray = explode(",", $partiiIDView);
                            //array_shift();
                            $arrayReverse = array_reverse($branchNameViewArray);
                            foreach ($arrayReverse as $headerTop) {
                                $danamicBranchId = "datavalue_" . $headerTop;

                                ?>
                                <td>
                                    <?php

                                    echo $tablebody->$danamicBranchId;

                                    ?>

                                </td>
                                <td></td>

                            <?php } ?>


                            <td><?php echo $tablebody->number; ?></td>
                            <td></td>

                            <?php


                        }
                    } ?>

                </tr>
                <tr>
                    <td colspan="2">UD(+/-)</td>
                    <td></td>

                    <?php
                    $arraySize = sizeof($branchNameViewArrySecond);
                    $arrayTwoDuble = $arraySize + $arraySize;
                    ?>
                    <?php for ($i = 0; $i <= $arrayTwoDuble; $i++) { ?>
                        <td></td>
                    <?php } ?>

                </tr>
                <tr>
                    <td colspan="2"><?php echo "OD"; ?></td>
                    <?php foreach ($sancAndBorne as $tablebody) {
                        if ($tablebody->EQUIVALANT_RANKID == "7") {

                            ?>
                            <?php $arraySize = sizeof($branchNameViewArrySecond);
                            $arrayTwo = $arraySize + $arraySize;
                            ?>


                            <?php
                            $branchNameViewArray = explode(",", $partiiIDView);
                            //array_shift();
                            $arrayReverse = array_reverse($branchNameViewArray);
                            foreach ($arrayReverse as $headerTop) {
                                $danamicBranchId = "datavalue_" . $headerTop;

                                ?>
                                <td>
                                    <?php

                                    echo $tablebody->$danamicBranchId;

                                    ?>

                                </td>
                                <td></td>

                            <?php } ?>


                            <td><?php echo $tablebody->number; ?></td>
                            <td></td>

                            <?php


                        }
                    } ?>

                </tr>
                <tr>
                    <td colspan="2">UD(+/-)</td>
                    <td></td>

                    <?php
                    $arraySize = sizeof($branchNameViewArrySecond);
                    $arrayTwoDuble = $arraySize + $arraySize;
                    ?>
                    <?php for ($i = 0; $i <= $arrayTwoDuble; $i++) { ?>
                        <td></td>
                    <?php } ?>

                </tr>


                </tbody>
            <?php } ?>
        </table>
    </div">
</div>
