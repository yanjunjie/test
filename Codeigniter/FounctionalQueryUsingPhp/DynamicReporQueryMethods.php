<?php
// By selecting (<,>, == etc) searched by User for report
function bdAdminget()
{
    $sql = "";

    /*ZONE Section*/
    if (isset($_GET['zone'])) {
        $zone = $this->input->get('zone');
        $zoneInNotIn = $this->input->get('zoneInNotIn');

        $result = $this->arrayToValue($zone);
        if ($zoneInNotIn == 1) {
            $sql .= " AND s.ZONEID IN ($result)";
        } else {
            $sql .= " AND s.ZONEID NOT IN ($result)";
        }
    }

    /*AREA Section*/
    if (isset($_GET['area'])) {
        $area = $this->input->get('area');
        $areaInNotIn = $this->input->get('areaInNotIn');

        $result = $this->arrayToValue($area);
        if ($areaInNotIn == 1) {
            $sql .= " AND s.AREAID IN ($result)";
        } else {
            $sql .= " AND s.AREAID NOT IN ($result)";
        }

    }

    /*Ship Establishment Section*/
    if (isset($_GET['shipEst'])) {
        $shipEst = $this->input->get('shipEst');
        $shipInNotIn = $this->input->get('shipInNotIn');

        $result = $this->arrayToValue($shipEst);
        if ($shipInNotIn == 1) {
            $sql .= " AND s.SHIPESTABLISHMENTID IN ($result)";
        } else {
            $sql .= " AND s.SHIPESTABLISHMENTID NOT IN ($result)";
        }
    }

    /*geting Unit Section*/
    if (isset($_GET['postingUnit'])) {
        $postingUnit = $this->input->get('postingUnit');
        $puInNotIn = $this->input->get('puInNotIn');

        $result = $this->arrayToValue($postingUnit);
        if ($puInNotIn == 1) {
            $sql .= " AND s.POSTINGUNITID IN ($result)";
        } else {
            $sql .= " AND s.POSTINGUNITID NOT IN ($result)";
        }
    }

    /*RANK Section*/
    if (isset($_GET['rank'])) {
        $rank = $this->input->get('rank');
        $brInNotIn = $this->input->get('brInNotIn');

        $result = $this->arrayToValue($rank);
        if ($brInNotIn == 1) {
            $sql .= " AND s.RANKID IN ($result)";
        } else {
            $sql .= " AND s.RANKID NOT IN ($result)";
        }
    }

    /*Division Section*/
    if (isset($_GET['division'])) {
        $division = $this->input->get('division');
        $divisionInNotIn = $this->input->get('divisionInNotIn');

        $result = $this->arrayToValue($division);
        if ($divisionInNotIn == 1) {
            $sql .= " AND s.DIVISIONID IN ($result)";
        } else {
            $sql .= " AND s.DIVISIONID NOT IN ($result)";
        }
    }
    /*District Section*/
    if (isset($_GET['district'])) {
        $district = $this->input->get('district');
        $districtInNotIn = $this->input->get('districtInNotIn');

        $result = $this->arrayToValue($district);
        if ($districtInNotIn == 1) {
            $sql .= " AND s.DISTRICTID IN ($result)";
        } else {
            $sql .= " AND s.DISTRICTID NOT IN ($result)";
        }
    }
    /*District Section*/
    if (isset($_GET['thana'])) {
        $thana = $this->input->get('thana');
        $thanaInNotIn = $this->input->get('thanaInNotIn');

        $result = $this->arrayToValue($thana);
        if ($thanaInNotIn == 1) {
            $sql .= " AND s.THANAID IN ($result)";
        } else {
            $sql .= " AND s.THANAID NOT IN ($result)";
        }
    }
    /*Part II Section*/
    if (isset($_GET['partTwo'])) {
        $partTwo = $this->input->get('partTwo');
        $partInNotIn = $this->input->get('partInNotIn');

        $result = $this->arrayToValue($partTwo);
        if ($partInNotIn == 1) {
            $sql .= " AND p.PartIIID IN ($result)";
        } else {
            $sql .= " AND p.PartIIID NOT IN ($result)";
        }
    }

    return $sql;
}
function DAOGroup(){
    $grp ="";
    /*DAO GROUP Section*/
    if (!empty($_GET['daoGroup'])) {

        $daoGroup = $this->input->get('daoGroup');
        $daoInNotIn = $this->input->get('daoInNotIn');

        $result = $this->arrayToValue($daoGroup);

        if($daoInNotIn == 1){
            $grp .= " AND dao.GROUP_ID IN ($result)";
        }else{
            $grp .= " AND dao.GROUP_ID NOT IN ($result)";
        }
    }
    return $grp;
}
function tradeContinuousVg(){
    $trade ="";
    /*trade Section*/
    if (!empty($_GET['trade'])) {

        $tradeId = $this->input->get('trade');
        $tradeInNotIn = $this->input->get('tradeInNotIn');

        $result = $this->arrayToValue($tradeId);

        if($tradeInNotIn == 1){

            $trade .= " AND p.TradeID IN ($result)";
        }else{
            $trade .= " AND p.TradeID NOT IN ($result)";
        }
    }


    /*equRank Section*/
    if (!empty($_GET['equRank'])) {

        $equRank = $this->input->get('equRank');
        $equRankInNotIn = $this->input->get('equRankInNotIn');

        $result = $this->arrayToValue($equRank);

        if($equRankInNotIn == 1){

            $trade .= " AND r.EQUIVALANT_RANKID IN ($result)";
        }else{
            $trade .= " AND r.EQUIVALANT_RANKID NOT IN ($result)";
        }
    }


    return $trade;
}
function bdAdminDAOGroup(){
    $grp ="";
    /*DAO GROUP Section*/
    if (!empty($_GET['daoGroup'])) {
        $daoGroup = $this->input->get('daoGroup');
        $daoInNotIn = $this->input->get('daoInNotIn');

        $result = $this->arrayToValue($daoGroup);

        if($daoInNotIn == 1){
            $grp .= " AND a.GROUP_ID IN ($result)";
        }else{
            $grp .= " AND a.GROUP_ID NOT IN ($result)";
        }
    }
    return $grp;
}

// Call method
function sailorNominalRoll()
{

    $sailorStatus = $this->input->get('sailorStatus');
    $sql = $this->bdAdminget();
    $daoGroup = $this->DAOGroup();
    $tradeEquilRank = $this->tradeContinuousVg();

    return $this->db->query("SELECT DISTINCT s.OFFICIALNUMBER AS O_No, s.FULLNAME AS NAME, r.RANK_NAME AS Rank,  s.BRANCHID, s.RANKID, bpu.NAME AS present_unit,  
                                  date_format(s.POSTINGDATE, '%d-%m-%Y') AS Date_Of_Posting,
                                  (SELECT bpu.NAME FROM   bn_posting_unit bpu WHERE  t.PostingUnitID = bpu.POSTING_UNITID) AS Under_Draft_unit, date_format(t.TODate, '%d-%m-%Y') AS Order_date
                              FROM sailor s
                                 LEFT JOIN bn_rank r ON s.RANKID = r.RANK_ID
                                 LEFT JOIN bn_branch b ON s.BRANCHID = b.BRANCH_ID
                                 LEFT JOIN bn_daogroup dao ON b.DAO_GROUPID = dao.GROUP_ID
                                 LEFT JOIN bn_posting_unit bpu ON s.POSTINGUNITID = bpu.POSTING_UNITID
                                 LEFT JOIN transfer t ON s.SAILORID = t.SailorID
                                 LEFT JOIN bn_ship_establishment bse ON s.SHIPESTABLISHMENTID = bse.SHIP_ESTABLISHMENTID
                                 LEFT JOIN bn_trade td ON s.BRANCHID = td.BRANCH_ID
                                 LEFT JOIN partii p ON td.TRADE_ID = p.TradeID
                              WHERE s.SAILORSTATUS = $sailorStatus $sql $tradeEquilRank $daoGroup 
                              ORDER BY r.POSITION")->result();
}
