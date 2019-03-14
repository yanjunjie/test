<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends CI_Controller {

    /**
     * @access      public
     * @param       officiar number
     * @author      Nurullah<nurul@atilimited.net>
     * @return      Sailor Id, Sailor Name, Rank_name, ship name, Posting unit name, Posting date
     */
    function getSailorInfoByOfficialNumber() {
        $officalNumber = $this->input->post("officeNumber");
        $officalNumber = preg_replace('/\s+/', '', $officalNumber);
        $count = strlen($officalNumber);
        $x = 8 - $count;
        if ($x == 1) {
            $zero = '0';
        } elseif ($x == 2) {
            $zero = '00';
        } elseif ($x == 3) {
            $zero = '000';
        } else {
            $zero = '';
        }
        $officalNumber = $count == 8 ? $officalNumber : $zero . $officalNumber;
        /*
        $this->db->select('s.SAILORID, s.FULLNAME, r.RANK_ID, s.REMARKS, (CASE WHEN (p.Name != "") THEN concat(r.RANK_NAME,"(", p.Name, ")") ELSE r.RANK_NAME END) AS RANK_NAME, sh.SHORT_NAME SHIP_ESTABLISHMENT, pu.NAME POSTING_UNIT_NAME, DATE_FORMAT(s.POSTINGDATE,"%d-%m-%Y") POSTING_DATE, mc.MedicalCategoryName');
        $this->db->from('sailor as s');
        $this->db->join('bn_posting_unit as pu', 'pu.POSTING_UNITID = s.POSTINGUNITID', 'LEFT');
        $this->db->join('partii as p', 's.FIRSTPARTID = p.PartIIID', 'LEFT');
        $this->db->join('bn_ship_establishment as sh', 'sh.SHIP_ESTABLISHMENTID = s.SHIPESTABLISHMENTID', 'LEFT');
        $this->db->join('bn_rank as r', 'r.RANK_ID = s.RANKID', 'LEFT');
        $this->db->join('medicalcategory as mc', 'mc.MedicalCategoryID = s.MEDICALCATEGORY', 'LEFT');
        $condition = array('s.SAILORSTATUS' => 1, 's.OFFICIALNUMBER' => $officalNumber);
        $this->db->where($condition);
        */
        $data=$this->db->query("SELECT s.SAILORID, s.FULLNAME, r.RANK_ID, s.REMARKS, (CASE WHEN (p.Name != '') THEN concat(r.RANK_NAME, '(', p.Name, ')') ELSE r.RANK_NAME END) AS RANK_NAME,
                                sh.SHORT_NAME SHIP_ESTABLISHMENT, pu.NAME POSTING_UNIT_NAME, DATE_FORMAT(s.POSTINGDATE, '%d-%m-%Y') POSTING_DATE, mc.MedicalCategoryName
                                FROM sailor as s
                                LEFT JOIN bn_posting_unit as pu ON pu.POSTING_UNITID = s.POSTINGUNITID
                                LEFT JOIN partii as p ON s.FIRSTPARTID = p.PartIIID
                                LEFT JOIN bn_ship_establishment as sh ON sh.SHIP_ESTABLISHMENTID = s.SHIPESTABLISHMENTID
                                LEFT JOIN bn_rank as r ON r.RANK_ID = s.RANKID
                                LEFT JOIN medicalcategory as mc ON mc.MedicalCategoryID = s.MEDICALCATEGORY
                                WHERE s.SAILORSTATUS IN (1,2) AND s.OFFICIALNUMBER = $officalNumber")->row_array();
        echo json_encode($data);
        //echo json_encode($this->db->get()->row_array());
    }

    /*
    * @author   Bablu <bablu@atilimited.net>
    * @return   Ajax Modal, Tree View
    */
    public function treeAppliedShip() {
        $data['zone'] = $this->db->query("select ADMIN_ID, CODE, NAME from bn_navyadminhierarchy where ADMIN_TYPE = 1")->result();
        $this->load->view('common/treeAppliedShip', $data);
    }

    /*
    * @author   Bablu <bablu@atilimited.net>
    * @return   Ajax Modal, Tree View
    */
    public function treeBranchRank() {
        $data['equivalent_rank'] = $this->utilities->findAllByAttributeWithOrderBy('bn_equivalent_rank', array("ACTIVE_STATUS" => 1), "POSITION");
        $data['branch'] = $this->db->query("select BRANCH_CODE, BRANCH_ID, BRANCH_NAME from bn_branch where ACTIVE_STATUS = 1 ")->result();
        $this->load->view('common/treeBranchRank', $data);
    }

    /*
    * @author   Bablu <bablu@atilimited.net>
    * @return   Ajax Modal, Tree View
    */
    public function treeEquRank()
    {
        $equRankIds = $this->input->post('equRankIds');
        
        $data['branch'] = $this->db->query("select BRANCH_CODE, BRANCH_ID, BRANCH_NAME from bn_branch where ACTIVE_STATUS = 1 ")->result();
        $data['equRankIds'] = "";
        if($equRankIds == 'null'){
            $data['equRankIds'] .= ' ';
        }  else {
            $data['equRankIds'] .= ' AND EQUIVALANT_RANKID IN ('.$equRankIds.')';
        }
        return $this->load->view('common/treeEquRank',$data);
    }

}

/* End of file common.php */
/* Location: ./application/controllers/common.php */
