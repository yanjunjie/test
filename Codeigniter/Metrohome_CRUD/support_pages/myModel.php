<?php

class MyModel extends CI_Model {

    //CONST TABLE	                    = 'organization_user_details';
    public static $admin	            = 'admin';
    public static $metro_police	        = 'metro_police';

    public static $landlord	            = 'landloard';
    public static $lnd_familymember	    = 'lnd_familymember';
    public static $lnd_homeworker	    = 'lnd_homeworker';
    public static $lnd_driver	        = 'lnd_driver';

    public static $renter	            = 'renter';
    public static $renter_familymember	= 'renter_familymember';
    public static $renter_homeworker	= 'renter_homeworker';
    public static $renter_driver	    = 'renter_driver';

    public function __construct()
    {
        parent::__construct();

    }

    //Admin login info
    public function check_admin_login_info($user_name, $user_pass, $user_type){
        $this->db->select('*');
        $this->db->from(self::$admin);
        $this->db->where('adm_username', $user_name);
        $this->db->where('adm_userpass', $user_pass);
        $this->db->where('user_type', $user_type);
        $query = $this->db->get();
        return $query->row();
    }

    //Landlord login info
    public function check_landloard_login_info($user_name, $user_pass, $user_type){
        $this->db->select('*');
        $this->db->from(self::$landlord);
        $this->db->where('lnd_nid', $user_name);
        $this->db->where('lnd_pass', $user_pass);
        $this->db->where('user_type', $user_type);
        $query = $this->db->get();
        return $query->row();
    }

    //Renter login info
    public function check_renter_login_info($user_name, $user_pass, $user_type){
        $renter_birth_date = strtotime($user_pass);
        $user_pass = date("Y-m-d",$renter_birth_date); /* password*/

        $this->db->select('*');
        $this->db->from(self::$renter);
        $this->db->where('renter_nid', $user_name);
        $this->db->where('renter_birth_date', $user_pass);
        $this->db->where('user_type', $user_type);
        $query = $this->db->get();
        return $query->row();
    }

    public function check_metro_police_login_info($user_name, $user_pass, $user_type){

        $this->db->select('*');
        $this->db->from(self::$metro_police);
        $this->db->where('metro_police_username', $user_name);
        $this->db->where('metro_police_userpass', $user_pass);
        $this->db->where('user_type', $user_type);
        $query = $this->db->get();
        return $query->row();

    }

    public function check_genUser_login_info($user_name, $user_pass, $user_type){

        $this->db->select('*');
        $this->db->from('ads_account_general');
        $this->db->where('ad_lnd_username', $user_name);
        $this->db->where('ad_lnd_password', $user_pass);
        $this->db->where('ad_lnd_user_type', $user_type);
        $query = $this->db->get();
        return $query->row();
    }

    //Renter info store
    public function save_renter_reg_data($reterData){
        $this->db->insert(self::$renter, $reterData);
        return $this->db->insert_id();
    }

    public function save_renterFM_data($renterFMData){
        for($i = 0; $i < count($renterFMData['family_member_name']); $i++)
            $batch[] = array(   "renter_id" =>$renterFMData['renter_id'],
                                "family_member_name" => $renterFMData['family_member_name'][$i],
                                "family_member_age" => $renterFMData['family_member_age'][$i],
                                "family_member_job" => $renterFMData['family_member_job'][$i],
                                "family_member_phone" => $renterFMData['family_member_phone'][$i]
                            );

        return $this->db->insert_batch(self::$renter_familymember, $batch);
    }

    public function save_renterHW_data($renterHWData){
        $this->db->insert(self::$renter_homeworker, $renterHWData);
        return $this->db->insert_id();
    }

    public function save_renterDriver_data($renter_driverData){
        $this->db->insert(self::$renter_driver, $renter_driverData);
        return $this->db->insert_id();
    }
    //End Renter info store

    //Landlord info store
    public function save_lnd_reg_data($lndData){
        $this->db->insert(self::$landlord, $lndData);
        return $this->db->insert_id();
    }

    public function save_lndFM_data($lndFMData){
        for($i = 0; $i < count($lndFMData['family_member_name']); $i++)
            $batch[] = array(   "lnd_id" =>$lndFMData['lnd_id'],
                                "family_member_name" => $lndFMData['family_member_name'][$i],
                                "family_member_age" => $lndFMData['family_member_age'][$i],
                                "family_member_job" => $lndFMData['family_member_job'][$i],
                                "family_member_phone" => $lndFMData['family_member_phone'][$i]
                            );

        return $this->db->insert_batch(self::$lnd_familymember, $batch);
    }

    public function save_lndHW_data($lndHWData){
        $this->db->insert(self::$lnd_homeworker, $lndHWData);
        return $this->db->insert_id();
    }

    public function save_lndDriver_data($lnd_driverData){
        $this->db->insert(self::$lnd_driver, $lnd_driverData);
        return $this->db->insert_id();
    }
    //End Landlord info store

    //Form validation of Renter
    public function checkDuplicateDataRenterM($table, $where){
        $this->db->select("*");
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }
    // End Form validation of Renter

    //Form validation of Renter
    public function checkDuplicateDataLandlordM($table, $where){
        $this->db->select("*");
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }
    // End Form validation of Renter

    public function testt($username){
        $this->db->insert('users', ['user_name'=>$username]);
        return $this->db->insert_id();
    }

    //Check renter info addNewRenterToLet
    public function renter_check($table, $where){
        $this->db->select("*");
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }
    // End Check renter info addNewRenterToLet

    //Check landlord info addNewRenterToLet
    public function landlord_check($table, $where){
        $this->db->select("*");
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }
    // End Check landlord info addNewRenterToLet

    //Renter Tracking Data save
    public function addNewRenterToLetM($table, $trackingData){
        $this->db->insert($table, $trackingData);
        return $this->db->insert_id();
    }

    //Find renter location in details
    public function findRenterLocationFromDBM($search_renter){

        //$this->db->like('renter_nid',$search_renter);
        $this->db->select('*');
        $this->db->from('renter_tracking_tbl');
        $this->db->where(['renter_nid'=>$search_renter]);
        $query = $this->db->get();
        return $query->result();

    }

    public function updatePreviousLastDate($data, $renter_nid){
       
        $this->db->order_by("tracking_id", "desc");
        $this->db->limit(1);
        $this->db->where('renter_nid', $renter_nid);
        $this->db->update('renter_tracking_tbl', $data);
        
    }

    //Ads Account
    public function adsRegistration($tbl_name, $data){
       
        $this->db->insert($tbl_name, $data);
        return $this->db->insert_id();
        
    }

    //Pagination
    public function get_all($limit, $page)
    {       
        $offset = ($page - 1) * $limit;
        $this->db->order_by('publicity_created_date','desc');
        $query  = $this->db->limit($limit, $offset)->get('publicity');
        return $query->result();
    }

    public function get_total()
    {
        return $this->db->count_all('publicity');
    }
    //End pagination

    //Search pagination data
    public function search_publicityM($search_publicity, $home_search)
    {
        if (!empty($home_search)) {
            $this->db->select('*');
            $this->db->from('publicity');
            $array = array('publicity_address' => $home_search, 'publicity_city' => $search_publicity);
            $this->db->like($array);
            $query = $this->db->get();
            return $query->result();
        }else{
            $this->db->select('*');
            $this->db->from('publicity');
            $this->db->like('publicity_city', $search_publicity);
            $query = $this->db->get();
            return $query->result();
        }
    }

    public function publish_publicity($data)
    {
        $this->db->insert('publicity', $data);
        return $this->db->insert_id();
    }

    public function getAllPublicityByID($userId, $userType)
    {
        $this->db->from('publicity');
        $this->db->where('publicity_userid', $userId);
        $this->db->where('publicity_usertype', $userType);
        return $this->db->get()->result();
    }

    //publicity delete
    public function deletePublicity($id)
    {
        return $this->db->delete('publicity', array('publicity_id' => $id));
    }

    //publicity update
    public function updatePublicityForm($id)
    {
        return $this->db->get_where('publicity', array('publicity_id' => $id))->row();
        //echo $this->db->last_query();
    }

    public function updatePublicity($id, $data)
    {
       return $this->db->update('publicity', $data, array('publicity_id' => $id));
    }

    //Find By ID
    public function findByPublicityId($table, $id)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('publicity_id', $id);
        $query = $this->db->get();
        return $query->row();
    }



    //CRUD Operation
    //Insert
    public function save($table, $data){
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    //update
    public function update($table, $tid, $id, $data)
    {
        $updated_status = $this->db->update($table, $data, array($tid => $id));
        if($updated_status):
            return $id;
        else:
            return false;
        endif;
    }
    //Batch Update
    public function updateByBatch($table, $tid, $id, $batch){
        return $this->db->insert_batch(self::$renter_familymember, $batch);
    }
    //delete
    public function delete($table, $tid, $id)
    {
        return $this->db->delete($table, array($tid => $id));
    }
    //Find all
    public function findAll($table, $tid)
    {
        $this->db->select('*', $tid);
        $this->db->from($table);
        $this->db->order_by($tid, "desc");
        $query = $this->db->get();
        return $query->result();
    }
    //Find all by asc
    public function findAllByAsc($table, $field)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by($field, "asc");
        $query = $this->db->get();
        return $query->result();
    }
    //Find all by desc
    public function findAllByDesc($table, $field)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by($field, "desc");
        $query = $this->db->get();
        return $query->result();
    }
    //Find by id
    public function findById($table, $tid, $id)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($tid, $id);
        $query = $this->db->get();
        return $query->result();
    }
    // Find All by Limit
    public function findAllByLimit($table, $tid, $limit='', $offset='') {
        $this->db->select('*');
        $this->db->order_by($tid, 'DESC');
        $this->db->from($table);
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result();
    }
    // Find by ID & Limit
    public function findByIdAndLimit($table, $tid, $id='', $limit='', $offset='') {
        $this->db->select('*');
        $this->db->order_by($tid, 'DESC');
        $this->db->from($table);
        $this->db->limit($limit, $offset);
        $this->db->where(array($tid => $id));
        $query = $this->db->get();
        return $query->result();
    }
    //End CRUD Operation



}
?>