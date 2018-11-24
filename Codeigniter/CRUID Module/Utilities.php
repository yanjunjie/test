<?php

<?php

class Utilities extends CI_Model
{

    function __construct()
    {
        parent::__construct();

    }
	
	function search_student_data($std_id)
	{
		die('hi');
		$this->db->select('*');
		$this->db->from('NM_APPLICATION');
		$this->db->where('REGISTRATION_NUMBER',$std_id);
		$this->db->or_where('ROLL_NUMBER',$std_id);
		
		$profile_data = $this->db->get();		
				
		
		if($profile_data->num_rows() > 0)
		{
			/*foreach($profile_data->result_array() as $prf_dt)
			{
				$data['APPLICATION_ID'] 	= $prf_dt->APPLICATION_ID;
				$data['FULL_NAME_ENG'] 		= $prf_dt->FULL_NAME_ENG;
				$data['FULL_NAME_BNG']		= $prf_dt->FULL_NAME_BNG;
				
				echo json_encode($data);
			}*/
			
			echo json_encode($profile_data->result_array());
		}
	}
	
	function validate_data($std_id,$type)
	{
		$this->db->select('REGISTRATION_NUMBER');
		$this->db->from('NM_APPLICATION');
		
		$this->db->where('REGISTRATION_NUMBER',$std_id);
		
		$profile_data = $this->db->get();		
				
		if($profile_data->num_rows() > 0)
		{			
			echo json_encode($profile_data->result_array());
		}
	}

    function get_max_value($tableName, $fieldName)
    {
        return $this->db->select_max($fieldName)->get($tableName)->row()->{$fieldName};
    }

    function get_max_value_by_attribute($tableName, $fieldName, $attribute)
    {
        return $this->db->select_max($fieldName)->where($attribute)->get($tableName)->row()->{$fieldName};
    }

    function get_sequence_next_value($sequenceName)
    {
        $conn = $this->db->conn_id;
        $sql = "SELECT $sequenceName.NEXTVAL FROM dual";
        $stmt = oci_parse($conn, $sql);
        oci_execute($stmt) or die("Unable to Execute Query .");

        while ($row = oci_fetch_assoc($stmt)) {
            return $row['NEXTVAL'];
        }
    }

    function get_field_value_by_attribute($tableName, $fieldName, $attribute)
    {
        return $this->db->get_where($tableName, $attribute)->row()->{$fieldName};
    }

    function oneFieldToOther($tableName, $fieldName, $condition)
    {
        $query = $this->db->get_where($tableName, $condition);
        $field = '';
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $labelText = '';
                for ($i = 0; $i < sizeof($fieldName); $i++) {
                    $labelText = $labelText . ' ' . $row->{$fieldName[$i]};
                }
                $field = $labelText;
            }
        }
        return $field;
    }

    function lookupInfo($LOOKUP_NO, $SELECT_TEXT)
    {
        $query = $this->db->get_where('CM_LOOKUP_DTL', array('LOOKUP_NO' => $LOOKUP_NO));
        $lookupInfo = array();

        if ($query->num_rows() > 0) {
            $lookupInfo = array(
                '' => $SELECT_TEXT
            );
            foreach ($query->result() as $row) {
                $lookupInfo[$row->LOOKUPDTL_NO] = $row->DTL_NAME;
            }
        }
        return $lookupInfo;
    }

    function dropdownFromTable($tableName, $selectText, $key, $labels)
    {
        $query = $this->db->get($tableName);
        $lookupInfo = array();

        if ($query->num_rows() > 0) {
            $lookupInfo = array(
                '' => $selectText
            );
            foreach ($query->result() as $row) {
                $labelText = '';
                for ($i = 0; $i < sizeof($labels); $i++) {
                    $labelText = $labelText . ' ' . $row->{$labels[$i]};
                }
                $lookupInfo[$row->{$key}] = $labelText;
            }
        }
        return $lookupInfo;
    }

    function dropdownFromTableWithCondition($tableName, $selectText, $key, $value, $condition = '')
    {
        if (!empty($condition)) {
            $this->db->where($condition);
        }
        $query = $this->db->get($tableName);

        if (empty($selectText)) {
            $selectText = '--- Select ---';
        }

        $lookupInfo = array('' => $selectText);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                if (!empty($row->{$value})) {
                    $lookupInfo[$row->{$key}] = $row->{$value};
                }
            }
        }
        return $lookupInfo;
    }

    public function hasInformationByThisId($tableName, $attribute)
    {
        $query = $this->db->get_where($tableName, $attribute);
        $no_of_row = 0;
        if (!empty($query)) {
            $no_of_row = $query->num_rows();
        }
        return ($no_of_row > 0) ? TRUE : FALSE;
    }

    public function countRowByAttribute($tableName, $attribute)
    {
        return $this->db->get_where($tableName, $attribute)->num_rows();
    }

    function insertData($post, $tableName)
    {
        $this->db->trans_start();
        $this->db->insert($tableName, $post);
        $this->db->trans_complete();
        if ($this->db->trans_status() == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }

    }

    function get_next_sequence_value($sequenceName = '')
    {
        $conn = $this->db->conn_id;
        $sql = "SELECT $sequenceName.NEXTVAL FROM dual";
        $stmt = oci_parse($conn, $sql);
        oci_execute($stmt)
        or die("Unable to Execute Query .");

        while ($row = oci_fetch_assoc($stmt)) {
            return $row['NEXTVAL'];
        }
    }

    function insert($tableName, $post)
    {
        $res = $this->db->insert($tableName, $post);

        if($this->session->userdata('my_db')=='ORACLE')
        {
            //First select id attribute name
            $query = $this->db->get($tableName);
            $row = array_keys($query->row_array());
            $id_attr = $row[0];

            //Last Inserted id
            if($res){
                $query2 = $this->db->query("select MAX($id_attr) from $tableName");
                $row2 = array_values($query2->row_array());
                $id = $row2[0];
                return $id;
            }else{
                return false;
            }

        }else
            return $this->db->insert_id();

    }

    function updateData($tableName, $data, $condition)
    {
        $this->db->trans_start();
        $this->db->update($tableName, $data, $condition);
        $this->db->trans_complete();
        if ($this->db->trans_status() == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteRowByAttribute($tableName, $attribute)
    {
        $this->db->trans_start();
        $this->db->delete($tableName, $attribute);
        $this->db->trans_complete();
        if ($this->db->trans_status() == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /*function findById($tableName, $attribute, $value)
    {
        return $this->db->query("SELECT * FROM $tableName WHERE $attribute = $value")->row();
    }*/

    function findByAttribute($tableName, $attribute)
    {
        return $this->db->get_where($tableName, $attribute)->row();
    }

    function rowCountByAttribute($tableName, $attribute)
    {
        return $this->db->get_where($tableName, $attribute)->num_rows();
    }

    function change_status_by_attribute($table_name, $attribute)
    {
        $rowInfo = $this->findByAttribute($table_name, $attribute);
        if (empty($rowInfo)) {
            $returnValue = 'Invalid';
        } else {
            if ($rowInfo->ACTIVE_STAT == 'Y') {
                $returnValue = 'Inactivated';
            } else {
                $returnValue = 'Activated';
            }
            $this->ACTIVE_STAT = ($rowInfo->ACTIVE_STAT == 'Y') ? 'N' : 'Y';
            $this->db->update($table_name, $this, $attribute);
        }
        return $returnValue;
    }

    function change_new_table_status_by_attribute($table_name, $attribute)
    {
        $rowInfo = $this->findByAttribute($table_name, $attribute);
        if (empty($rowInfo)) {
            $returnValue = 'Invalid';
        } else {
            if ($rowInfo->STA_FG == 1) {
                $returnValue = 'Inactivated';
            } else {
                $returnValue = 'Activated';
            }
            $this->STA_FG = ($rowInfo->STA_FG == 1) ? 0 : 1;
            $this->db->update($table_name, $this, $attribute);
        }
        return $returnValue;
    }

    function lookupTypesByLookupNo($lookupNo, $selectedText = '--- Select ---')
    {
        $query = $this->db->get_where('CM_LOOKUP_DTL', array('LOOKUP_NO' => $lookupNo, 'ACTIVE_STAT' => 'Y'));
        $docType = array();
        if ($query->num_rows() > 0) {
            $docType = array(
                '' => $selectedText
            );
            foreach ($query->result() as $row) {
                $docType[$row->LOOKUPDTL_NO] = $row->DTL_NAME;
            }
        }
        return $docType;
    }

    function attributeArrayByGroupId($group_id, $selectedText = '--- Select ---')
    {
        $query = $this->db->get_where('A00_ATRB', array('GRP_ID' => $group_id, 'STA_FG' => 1));
        $returnArray = array();
        if ($query->num_rows() > 0) {
            $returnArray = array(
                '' => $selectedText
            );
            foreach ($query->result() as $row) {
                $returnArray[$row->ATRB_ID] = $row->ATRB_NAME;
            }
        }
        return $returnArray;
    }

    function findAllFromView($viewName)
    {
        return $this->db->get($viewName)->result();
    }

    function getAll($tableName)
    {
        return $this->db->get($tableName)->result();
    }

    function findAllByAttributeWithLike($tableName, $attribute, $like)
    {
        //echo $like; exit;
        if (!empty($like)) {
            $this->db->like($like);
        }
        if (!empty($attribute)) {
            $this->db->where($attribute);
        }
        return $this->db->get($tableName)->result();
    }

    function findAllByAttribute($tableName, $attribute)
    {
        return $this->db->get_where($tableName, $attribute)->result();
    }

    function findAllByAttributeWithOrderBy($tableName, $attribute, $order_by_field_name, $order_by = 'ASC')
    {
        return $this->db->order_by("$order_by_field_name", "$order_by")->get_where($tableName, $attribute)->result();
    }

    function findAllWithOrderBy($tableName, $order_by_field_name, $order_by = 'ASC')
    {
        return $this->db->order_by("$order_by_field_name", "$order_by")->get($tableName)->result();
    }

    function getIdByName($tableName, $name, $returnFieldName)
    {
        return $this->db->query("SELECT $returnFieldName  FROM $tableName WHERE (FIRST_NAME||' '||LAST_NAME)='$name'")->row()->{$returnFieldName};
    }

    function findByAttributeWithJoin($mainTableName, $joinTableName, $joinByFieldName, $joinWithFieldName, $joinFieldName, $attribute, $joinType = 'left')
    {
        $this->db->select("$mainTableName.*, $joinTableName.$joinFieldName");
        $this->db->from($mainTableName);
        $this->db->join($joinTableName, "$mainTableName.$joinByFieldName = $joinTableName.$joinWithFieldName", $joinType);
        $this->db->where($attribute);
        return $this->db->get()->row();
    }

    function findAllByAttributeWithJoin($mainTableName, $joinTableName, $joinByFieldName, $joinWithFieldName, $joinFieldName, $attribute = '', $joinType = 'left')
    {
        $this->db->select("$mainTableName.*, $joinTableName.$joinFieldName");
        $this->db->from($mainTableName);
        $this->db->join($joinTableName, "$mainTableName.$joinByFieldName = $joinTableName.$joinWithFieldName", $joinType);
        if (!empty($attribute)) {
            $this->db->where($attribute);
        }
        return $this->db->get()->result();
    }

    function findByAttributeWithJoinMF($mainTableName, $joinTableName, $joinByFieldName, $joinWithFieldName, $returnValue, $attribute = '', $joinType = 'left')
    {
        $this->db->select($returnValue);
        $this->db->from($mainTableName);
        $this->db->join($joinTableName, "$mainTableName.$joinByFieldName = $joinTableName.$joinWithFieldName", $joinType);
        if (!empty($attribute)) {
            $this->db->where($attribute);
        }
        return $this->db->get()->row();
    }

    function findAllByAttributeWithJoinMF($mainTableName, $joinTableName, $joinByFieldName, $joinWithFieldName, $returnValue, $attribute = '', $joinType = 'left')
    {
        $this->db->select($returnValue);
        $this->db->from($mainTableName);
        $this->db->join($joinTableName, "$mainTableName.$joinByFieldName = $joinTableName.$joinWithFieldName", $joinType);
        if (!empty($attribute)) {
            $this->db->where($attribute);
        }
        return $this->db->get()->result();
    }

    function is_it_checked_or_not($role_id, $form_id)
    {
        $role_permission_info = $this->db->get_where('SM_ROLE_FORMS', array('ROLE_ID' => $role_id, 'FORM_ID' => $form_id))->row();
        if (empty($role_permission_info)) {
            return FALSE;
        } else {
            if ($role_permission_info->ACTIVE_STAT == 'Y') {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    function change_access_forms_by_ajax($role_id, $form_id, $status)
    {
        $role_form_info = $this->db->get_where('SM_ROLE_FORMS', array('ROLE_ID' => $role_id, 'FORM_ID' => $form_id))->row();
        $session_info = $this->session->userdata('logged_in');
        if (empty($role_form_info)) {
            $this->ROLE_FORMS_ID = $this->get_max_value('SM_ROLE_FORMS', 'ROLE_FORMS_ID') + 1;
            $this->ROLE_ID = $role_id;
            $this->FORM_ID = $form_id;
            $this->ACTIVE_STAT = $status;
            $this->CRE_BY = $session_info['USER_ID'];
            $this->db->insert('SM_ROLE_FORMS', $this);
        } else {
            $this->ACTIVE_STAT = $status;
            $this->UPD_BY = $session_info['USER_ID'];
            $this->UPD_DT = date('d-M-Y h:i:s A');
            $this->db->update('SM_ROLE_FORMS', $this, array('ROLE_FORMS_ID' => $role_form_info->ROLE_FORMS_ID));
        }
    }

    function SPEL_OUT_AMOUNT($amount)
    {
        return $this->db->query("SELECT SPEL_OUT ($amount) AS IN_WORD  FROM dual")->row()->IN_WORD;
    }

    function remove_case_doc_by_id($id)
    {
        if (is_numeric($id) && $id > 0) {
            $row = $this->findByAttribute('CM_CASE_DOC', array('CASE_DOC_ID' => $id));
            $file_name = $row->FILE_NAME;
            if (!empty($file_name)) {
                $path = APPPATH . '../resources/docStore/' . $file_name;
                if (file_exists($path)) {
                    unlink($path) or die('failed deleting: ' . $path);
                }
            }
            $this->db->where('CASE_DOC_ID', $id);
            $this->db->delete('CM_CASE_DOC');
            return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
        } else {
            return FALSE;
        }
    }

    function getPreviousArrayByAttribute($tableName, $returnFieldName, $attribute)
    {
        $preRecords = $this->db->select($returnFieldName)->get_where($tableName, $attribute)->result();
        $singleArray = array();
        if (!empty($preRecords)) {
            foreach ($preRecords as $preRecord) {
                $singleArray[] = $preRecord->{$returnFieldName};
            }
        }
        return $singleArray;
    }

    function getRowArrayByAttribute($tableName, $attribute)
    {
        $preRecords = $this->db->select('*')->get_where($tableName, $attribute)->result();
        $singleArray = array();
        if (!empty($preRecords)) {
            foreach ($preRecords as $preRecord) {
                $singleArray[] = $preRecord;
            }
        }
        return $singleArray;
    }

    public function get_php_date_format($string)
    {
        list($date, $time, $ampm) = explode(' ', $string);
        list($hour, $minute, $second) = explode('.', $time);
        $second = substr($second, 0, 2);
        $time = $hour . '.' . $minute . '.' . $second . '' . $ampm;
        return date('F d, Y h:i:s a', strtotime($date . ' ' . $time));
    }

    public function get_item_usage_info_by_item_id($user_id, $item_id)
    {
        $query_for_last_info = $this->db->query("SELECT A.IRITM_ID, A.RCV_QTY, A.RCV_DT FROM A32_ISITM A, A32_IS S WHERE A.IS_ID = S.IS_ID AND A.RCV_FG = 1 AND A.ITM_ID = $item_id AND S.IS_TO = $user_id ORDER BY A.RCV_DT DESC")->first_row();
        $IRITM_ID = '';
        $RCV_QTY = 'N/A';
        $RCV_DT = 'N/A';
        $TOTAL_USAGE = 'N/A';
        if (!empty($query_for_last_info)) {
            $IRITM_ID = $query_for_last_info->IRITM_ID;
            $RCV_QTY = $query_for_last_info->RCV_QTY;
            $RCV_DT = date('d-M-Y', strtotime($query_for_last_info->RCV_DT));
        }
        $bgt_range = $this->db->query("SELECT DT1, DT2 FROM A32_BGTYRRANGE WHERE BGTYR_ID = (SELECT MAX(BGTYR_ID) FROM A32_BGTYRRANGE)")->row();
        if (!empty($bgt_range)) {
            $DT1 = date('d-M-Y', strtotime($bgt_range->DT1));
            $DT2 = date('d-M-Y', strtotime($bgt_range->DT2));
            $TOTAL_USAGE = $this->db->query("SELECT SUM(A.RCV_QTY) TOTAL_USAGE FROM A32_ISITM A, A32_IS S WHERE A.IS_ID = S.IS_ID AND A.RCV_FG = 1 AND A.ITM_ID = $item_id AND S.IS_TO = $user_id AND A.RCV_DT BETWEEN '" . $DT1 . "' AND '" . $DT2 . "' ORDER BY A.RCV_DT DESC")->row()->TOTAL_USAGE;
        }
        return array('IRITM_ID' => $IRITM_ID, 'RCV_QTY' => $RCV_QTY, 'RCV_DT' => $RCV_DT, 'TOTAL_USAGE' => $TOTAL_USAGE);
    }

    public function get_item_points_info_by_item_point_id($user_id, $item_id, $point_id)
    {
        $query_for_last_info = $this->db->query("SELECT A.CRE_DT FROM A32_ITMINSTPOINT A, A32_IRITM IRI WHERE A.IRITM_ID = IRI.IRITM_ID AND A.IS_VERIFIED = 1 AND A.CRE_BY = $user_id AND IRI.ITM_ID = $item_id AND A.INSTPOINT_ID = $point_id ORDER BY A.CRE_DT DESC")->first_row();
        $PT_RCV_DT = 'N/A';
        $PT_TOTAL_USAGE = 'N/A';
        if (!empty($query_for_last_info)) {
            $PT_RCV_DT = $query_for_last_info->CRE_DT;
        }
        $bgt_range = $this->db->query("SELECT DT1, DT2 FROM A32_BGTYRRANGE WHERE BGTYR_ID = (SELECT MAX(BGTYR_ID) FROM A32_BGTYRRANGE)")->row();
        if (!empty($bgt_range)) {
            $DT1 = date('d-M-Y', strtotime($bgt_range->DT1));
            $DT2 = date('d-M-Y', strtotime($bgt_range->DT2));
            $PT_TOTAL_USAGE = $this->db->query("SELECT COUNT(A.IRITM_ID) TOTAL_USAGE FROM A32_ITMINSTPOINT A, A32_IRITM IRI WHERE A.IRITM_ID = IRI.IRITM_ID AND A.IS_VERIFIED = 1 AND A.CRE_BY = $user_id AND IRI.ITM_ID = $item_id AND A.INSTPOINT_ID = $point_id AND TRUNC(A.CRE_DT) BETWEEN '" . $DT1 . "' AND '" . $DT2 . "'")->row()->TOTAL_USAGE;
        }
        return array('PT_RCV_DT' => $PT_RCV_DT, 'PT_TOTAL_USAGE' => $PT_TOTAL_USAGE);
    }

    public function programList()
    {
        return $this->db->query("SELECT p.program_id,
            p.programe_name,
            p.degree_type_id,
            p.department_id,
            p.sem_per_year,
            p.tot_semester,
            p.status,
            dt.degree_name,
            d.department_full_name
            FROM program AS p
            LEFT JOIN degree_type AS dt ON p.degree_type_id = dt.degree_type_id
            LEFT JOIN department AS d ON p.department_id = d.department_id")->result();
    }

    function get_roll_number($year, $id)
    {

        $condition = $year . $id;
        $row = $this->db->query("SELECT (IFNULL(MAX(SUBSTR(roll_no,5)), 0)+1) next_sn FROM admission WHERE roll_no LIKE '$condition%'")->row();
        $sl = str_pad($row->next_sn, 3, "0", STR_PAD_LEFT);
        return $condition . $sl;
    }

    function get_addmission_roll_number($year,$session,$faculty,$department,$program)
    {
        $yr = substr($year, -2);
        $ses = str_pad($session, 2, "0", STR_PAD_LEFT);        
        $dept = str_pad($department, 2, "0", STR_PAD_LEFT);
        $prog = str_pad($program, 2, "0", STR_PAD_LEFT);
        $condition = $yr . $ses . $faculty . $dept . $prog;
        $row = $this->db->query("SELECT (IFNULL(MAX(SUBSTR(ADM_ROLL_NO,10)), 0)+1) next_sn FROM applicant_personal_info WHERE ADM_ROLL_NO LIKE '$condition%'")->row();
        $sl = str_pad($row->next_sn, 3, "0", STR_PAD_LEFT);
        return $condition . $sl;
    }
    function get_registration_no($year,$session,$faculty,$program)
    {
        $yr = $year;        
        $ses = $session;
        $fac = str_pad($faculty, 2, "0", STR_PAD_LEFT);
        $prog = str_pad($program, 2, "0", STR_PAD_LEFT);
        $condition = $yr . $ses . $fac . $prog;
        $row = $this->db->query("SELECT (IFNULL(MAX(SUBSTR(REGISTRATION_NO,13)), 0)+1) next_sn FROM student_personal_info WHERE REGISTRATION_NO LIKE '$condition%'")->row();
        $sl = str_pad($row->next_sn, 4, "0", STR_PAD_LEFT);
        return $condition . $sl;
    }

    function student_reg_id($year, $id)
    {

        $condition = $year . $id;
        $row = $this->db->query("SELECT (IFNULL(MAX(SUBSTR(STUDENT_REG_NO,5)), 0)+1) next_sn FROM registration WHERE STUDENT_REG_NO LIKE '$condition%'")->row();
        $sl = str_pad($row->next_sn, 4, "0", STR_PAD_LEFT);
        return $condition . $sl;
    }

    function student_invoice_no($year)
    {

        $condition = $year;
        $row = $this->db->query("SELECT (IFNULL(MAX(SUBSTR(INVOICE_NO,7)), 0)+1) next_sn FROM invoice_mst WHERE INVOICE_NO LIKE '$condition%'")->row();
        $sl = str_pad($row->next_sn, 7, "0", STR_PAD_LEFT);
        return $condition . $sl;
    }

    function findAllByAttributeFromProgram()
    {
        $row = $this->db->query("SELECT ins_program.*,
           ins_degree.DEGREE_NAME,
           ins_dept.DEPT_NAME,
           ins_faculty.FACULTY_NAME
           FROM ins_program
           LEFT JOIN ins_degree ON ins_program.DEGREE_ID = ins_degree.DEGREE_ID
           LEFT JOIN ins_dept ON ins_program.DEPT_ID = ins_dept.DEPT_ID
           LEFT JOIN ins_faculty
           ON ins_program.FACULTY_ID = ins_faculty.FACULTY_ID
           ")->result();
        return $row;
    }

    function findAllByAttributeFromProgramWithId($id)
    {
        $row = $this->db->query(" SELECT ins_program.*,
            ins_degree.DEGREE_NAME, ins_dept.DEPT_NAME, ins_faculty.FACULTY_NAME
            from ins_program
            left join ins_degree on ins_program.DEGREE_ID = ins_degree.DEGREE_ID
            left join ins_dept on ins_program.DEPT_ID = ins_dept.DEPT_ID
            left join ins_faculty on ins_program.FACULTY_ID = ins_faculty.FACULTY_ID
            WHERE ins_program.PROGRAM_ID = $id
            ")->result();
        return $row;
    }

    function findAllByAttributeFromUserWithId($id)
    {
        $row = $this->db->query("SELECT su.*,sug.USERGRP_NAME, sul.UGLEVE_NAME, a.*, b.DEPT_NAME, c.DESIGNATION
            FROM SA_USERS su 

            INNER JOIN SA_USER_GROUP sug on sug.USERGRP_ID = su.USERGRP_ID
            INNER JOIN SA_UG_LEVEL sul on sul.UG_LEVEL_ID = su.USERLVL_ID
            INNER JOIN hr_emp a on su.EMP_ID = a.EMP_ID
            INNER JOIN ins_dept b on su.DEPT_ID = b.DEPT_ID
            INNER JOIN hr_desig c on su.DESIG_ID = c.DESIG_ID WHERE su.USER_ID = '$id'
            ")->result();
        return $row;
    }

    function findAllByAttributeFromDepartment()
    {
        $row = $this->db->query(" SELECT department.*, faculty.FACULTY_NAME FROM department
            left join faculty on department.FACULTY_ID = faculty.FACULTY_ID

            ")->result();
        return $row;
    }

    function findAllByAttributeFromDepartmentWithId($dept_id)
    {
        $row = $this->db->query(" SELECT department.*, faculty.FACULTY_NAME FROM department
            left join faculty on department.FACULTY_ID = faculty.FACULTY_ID
            where department.DEPT_ID = $dept_id
            ")->result();
        return $row;
    }

    function findAllByAttributeFromCourseOffer()
    {
        $row = $this->db->query("SELECT aca_course_offer.*, department.DEPT_NAME, program.PROGRAM_NAME, aca_course.COURSE_CODE, aca_course.COURSE_TITLE FROM aca_course_offer
            LEFT JOIN department on aca_course_offer.DEPT_ID = department.DEPT_ID
            LEFT JOIN program on aca_course_offer.PROGRAM_ID = program.PROGRAM_ID
            LEFT JOIN aca_course on aca_course_offer.COURSE_ID = aca_course.COURSE_ID")->result();
        return $row;
    }

    function getOfferedCoursesWithId($id)
    {
        $row = $this->db->query(" SELECT aca_course_offer.*, faculty.FACULTY_ID, faculty.FACULTY_NAME, department.DEPT_NAME, m00_lkpdata.LKP_NAME, program.PROGRAM_NAME, aca_course.COURSE_ID, aca_course.COURSE_CODE, aca_course.CREDIT, aca_course.COURSE_TITLE FROM aca_course_offer
            LEFT JOIN department on aca_course_offer.DEPT_ID = department.DEPT_ID
            LEFT JOIN m00_lkpdata on aca_course_offer.SEMESTER_ID = m00_lkpdata.LKP_ID
            LEFT JOIN program on aca_course_offer.PROGRAM_ID = program.PROGRAM_ID
            LEFT JOIN aca_course on aca_course_offer.COURSE_ID = aca_course.COURSE_ID
            LEFT JOIN faculty on department.FACULTY_ID = faculty.FACULTY_ID
            WHERE aca_course_offer.OFFERED_COURSE_ID = $id
            ")->result();
        return $row;
    }

    function getOfferedCourses($faculty, $department, $program, $offer_type)
    {
        $condition = "";
        if ($faculty != "") {
            $condition .= " co.FACULTY_ID = $faculty";
        }
        if ($department != "") {
            $condition .= " AND co.DEPT_ID = $department";
        }
        if ($program != "") {
            $condition .= " AND co.PROGRAM_ID = $program";
        }
        if ($offer_type != "") {
            $condition .= " AND co.OFFER_TYPE = '$offer_type'";
        }
        return $this->db->query("SELECT co.OFFERED_COURSE_ID, co.OFFER_TYPE, co.PROGRAM_ID,co.DEPT_ID,co.FACULTY_ID,f.FACULTY_NAME, d.DEPT_NAME, p.PROGRAM_NAME, COUNT(co.COURSE_ID)COUNTER, SUM(CREDIT) TOTAL_CREDIT
            FROM aca_course_offer co
            INNER JOIN faculty f ON co.FACULTY_ID = f.FACULTY_ID
            INNER JOIN department d ON co.DEPT_ID = d.DEPT_ID
            INNER JOIN program p ON co.PROGRAM_ID = p.PROGRAM_ID
            INNER JOIN aca_course c ON co.COURSE_ID = c.COURSE_ID
            WHERE $condition AND co.ACTIVE_STATUS = 1 GROUP BY co.FACULTY_ID,co.DEPT_ID,co.PROGRAM_ID
            ORDER BY f.FACULTY_NAME,d.DEPT_NAME,p.PROGRAM_NAME")->result();
    }

    function getCourseNotInCOurseOffer($dept_id)
    {
        return $this->db->query("SELECT COURSE_ID, DEPT_ID, COURSE_CODE, COURSE_TITLE, CREDIT, COURSE_DESC, C_CAT_ID, ACTIVE_STATUS, CREATED_BY, CREATE_DATE, UPDATED_BY, UPDATE_DATE,
            (SELECT cc.CAT_NAME FROM aca_course_category cc WHERE cc.C_CAT_ID = aca_course.C_CAT_ID )CAT_NAME,
            (SELECT cc.CAT_COLOR FROM aca_course_category cc WHERE cc.C_CAT_ID = aca_course.C_CAT_ID )CAT_COLOR
            FROM  aca_course WHERE DEPT_ID = 1 AND COURSE_ID NOT IN (SELECT COURSE_ID FROM aca_course_offer)")->result();
    }

    function getOfferedCoursesWithCondition($faculty, $department, $program, $offerType)
    {
        $this->db->select("*, aca_course_offer.DURATION CRS_DURATION");
        $this->db->from("aca_course_offer");
        $this->db->join('faculty', 'aca_course_offer.FACULTY_ID = faculty.FACULTY_ID', 'inner');
        $this->db->join('aca_course', 'aca_course_offer.COURSE_ID = aca_course.COURSE_ID', 'inner');
        $this->db->join('department', 'aca_course_offer.DEPT_ID = department.DEPT_ID', 'inner');
        $this->db->join('program', 'aca_course_offer.PROGRAM_ID = program.PROGRAM_ID', 'inner');
        $this->db->join('aca_course_category', 'aca_course_offer.COURSE_CATEGORY_ID = aca_course_category.C_CAT_ID', 'left');

        if ($faculty != "") {
            $this->db->where("aca_course_offer.FACULTY_ID", $faculty);
        }
        if ($department != "") {
            $this->db->where("aca_course_offer.DEPT_ID", $department);
        }
        if ($program != "") {
            $this->db->where("aca_course_offer.PROGRAM_ID", $program);
        }
        if ($offerType != "") {
            $this->db->where("aca_course_offer.OFFER_TYPE", $offerType);
        }
        $this->db->where("aca_course.ACTIVE_STATUS", 1);
        if ($faculty == "" && $department == "" && $program == "" && $offerType == "") {
            return 0;
        } else {
            return $this->db->get()->result();
        }
    }

    function getDeptNotInCourseOffer($program_id)
    {
        return $this->db->query("SELECT * FROM aca_course_offer WHERE PROGRAM_ID = $program_id")->result();
    }

    function pk_f($table_name)
    {
        $session_info = $this->session->userdata('logged_in');
        $row = $this->db->query("SELECT fnc_pkid('$table_name')PK")->row();
        return $pk = $session_info['PKPLUS'] + $row->PK;
    }

    function pk_f_applicant($table_name)
    {
        $session_info = $this->session->userdata('applicant_logged_in');
        $row = $this->db->query("select fnc_pkid('$table_name')PK")->row();
        return $pk = $session_info['PKPLUS_APPLICANT'] + $row->PK;
    }
    function pk_f_sibling($table_name)
    {
        $session_info = $this->session->userdata('applicant_logged_in');
        $row = $this->db->query("select fnc_pkid('$table_name')PK")->row();
        return $pk = $session_info['PKPLUS_SIBLING'] + $row->PK;
    }

    function userlist($group_id, $userLevel_id, $department_id = "", $designation_id = "", $gender_id = "")
    {
        $department_sql = "";
        if ($department_id != "") {
            $department_sql = " AND u.DEPT_ID = $department_id";
        }
        $designation_sql = "";
        if ($designation_id != "") {
            $designation_sql = " AND u.DESIGNATION_ID = $designation_id";
        }
        $gender_sql = "";
        if ($gender_id != "") {
            $gender_sql = " AND u.GENDER = '$gender_id'";
        }
        return $this->db->query("SELECT u.USER_ID, u.USER_IMG, u.FULL_NAME, u.MOBILE,u.EMAIL,(SELECT d.DESIGNATION FROM designations d WHERE d.DESIGNATION_ID = u.DESIGNATION_ID)DESIGNATION FROM SA_USERS u "
            . " WHERE u.USERGRP_ID = $group_id AND u.USERLVL_ID = $userLevel_id $department_sql $designation_sql $gender_sql")->result();
    }

    function getOfferedCoursesWithProgram($program)
    {
        return $this->db->query("SELECT c.* FROM aca_course c
            LEFT JOIN aca_course_offer co ON co.COURSE_ID = c.COURSE_ID
            WHERE co.PROGRAM_ID = $program")->result();
    }

    function findAllDistinectAtt($degree)
    {
        return $this->db->query(" SELECT distinct(d.DEPT_NAME), d.DEPT_ID FROM department d
            LEFT JOIN program p on p.DEPT_ID = d.DEPT_ID
            WHERE p.DEGREE_ID = $degree")->result();
    }

    function formatDate($format, $dateStr)
    {
        if (trim($dateStr) == '' || substr($dateStr, 0, 10) == '0000-00-00') {
            return '';
        }
        $ts = strtotime($dateStr);
        if ($ts === false) {
            return '';
        }
        return date($format, $ts);
    }

    function getStuPaidAmt($std, $semester)
    {
        return $this->db->query("SELECT v.VOUCHER_NO, v.VOUCHER_DT, v.STUDENT_ID, v.ROLL_NO, v.REMARKS, l.TRX_CODE_NO, l.TRX_TRAN_NO, l.CR_AMT, sum(l.DR_AMT) DEBIT
            FROM bm_vouchermst v INNER JOIN bm_vn_ledgers l ON v.VOUCHER_NO = l.VOUCHER_NO
            WHERE v.STUDENT_ID = '$std' AND v.SEMESTER_ID IN ($semester) AND l.TRX_CODE_NO = 'PM' GROUP BY v.STUDENT_ID")->row();
    }

    function studentInfo($id)
    {

        return $this->db->query("SELECT a.*,
           b.SESSION_NAME,
           c.SEMESTER_NAME,
           d.FACULTY_NAME,
           e.DEPT_NAME,
           f.PROGRAM_NAME,
           g.LKP_NAME AS semester
           FROM stu_semesterinfo a
           LEFT JOIN session_view b ON a.SEM_SESSION = b.SESSION_ID
           LEFT JOIN sav_semester c ON a.SEMESTER_ID = c.SEMESTER_ID
           LEFT JOIN faculty d ON a.FACULTY_ID = d.FACULTY_ID
           LEFT JOIN department e ON a.DEPT_ID = e.DEPT_ID
           LEFT JOIN program f ON a.PROGRAM_ID = f.PROGRAM_ID
           LEFT JOIN m00_lkpdata g ON a.SEMESTER_ID = g.LKP_ID
           WHERE a.STUDENT_ID = $id AND a.IS_CURRENT = '1'")->row();

    }

    function universityStudentSessionInfo($id)
    {
        return $this->db->query("SELECT b.SESSION_ID, b.SESSION_NAME
          FROM stu_courseinfo a
          LEFT JOIN session_view b ON a.SEM_SESSION = b.SESSION_ID
          WHERE a.STUDENT_ID = $id
          GROUP BY b.SESSION_ID
          ORDER BY b.SESSION_ID DESC")->result();
    }

    function semesterSession()
    {
        return $this->db->query("SELECT a.SES_YEAR_ID as SESSION_ID, concat( b.SESSION_NAME, ' (', c.YEAR_SETUP_TITLE, ')') SESSION_NAME
            FROM session_year a
            LEFT JOIN session b ON a.SESSION = b.SESSION_ID
            LEFT JOIN year_setup c ON a.YEAR_SETUP_ID = c.YEAR_SETUP_ID")->result();
    }

    function sessionViewWithCondition($session)
    {
        return $this->db->query("SELECT sy.SES_YEAR_ID, s.SESSION_NAME, ys.YEAR_SETUP_TITLE
            FROM session_year sy
            LEFT JOIN session s on s.SESSION_ID = sy.SESSION
            LEFT JOIN year_setup ys on ys.YEAR_SETUP_ID = sy.YEAR_SETUP_ID
            WHERE sy.SES_YEAR_ID = $session")->row();
    }

    function admissionInfoByStu($stu_id)
    {
        return $this->db->query("SELECT a.*,
            b.SESSION_NAME,
            c.SEMESTER_NAME,
            d.FACULTY_NAME,
            e.DEPT_NAME,
            f.PROGRAM_NAME
            FROM stu_admissioninfo a
            LEFT JOIN session_view b ON a.SESSION_ID = b.SESSION_ID
            LEFT JOIN sav_semester c ON a.SEMISTER_ID = c.SEMESTER_ID
            LEFT JOIN faculty d ON a.FACULTY_ID = d.FACULTY_ID
            LEFT JOIN department e ON a.DEPT_ID = e.DEPT_ID
            LEFT JOIN program f ON a.PROGRAM_ID = f.PROGRAM_ID
            WHERE a.STUDENT_ID = '$stu_id'")->row();
    }

    function findAllByAttributeFromDesignation()
    {
        return $this->db->query("SELECT des.*, d.DEPT_NAME FROM designations des
            LEFT JOIN department d on d.DEPT_ID = des.DEPT_ID")->result();
    }

    function findAllByAttributeFromDesignationWithId($id)
    {
        $row = $this->db->query("SELECT des.*, d.DEPT_NAME FROM designations des
            LEFT JOIN department d on d.DEPT_ID = des.DEPT_ID
            WHERE des.DESIGNATION_ID = $id")->result();
        return $row;
    }

    function programWiseBatchList($id)
    {
        $query = $this->db->query("select b.BATCH_ID,b.BATCH_TITLE from aca_batch_prog a
            left join aca_batch b on a.BATCH_ID=b.BATCH_ID where a.PROGRAM_ID=$id ")->result();
        return $query;
    }
    function batchProgList()
    {
        $query = $this->db->query("SELECT a.*,b.BATCH_TITLE,c.DEPT_ABBR,d.YEAR_TITLE
           from  aca_batch_prog a,
           aca_batch b,
           ins_dept c,
           ins_years d
           where a.BATCH_ID = b.BATCH_ID 
           and  a.PROGRAM_ID = c.DEPT_ID
           AND a.YSESSION_ID = d.YEAR_ID and a.ACTIVE_STATUS=1")->result();
        return $query;
    }

    function findSingleRowFromBatch($id)
    {
        $row = $this->db->query("SELECT ab.*,
         p.PROGRAM_NAME,
         concat(q.SESSION_NAME, ' - ', s.DINYEAR) AS SESSION_NAME
         FROM aca_batch ab
         INNER JOIN ins_program p ON p.PROGRAM_ID = ab.PROGRAM_ID
         INNER JOIN ins_ysession s ON s.YSESSION_ID = ab.YSESSION_ID
         INNER JOIN ins_session q ON q.SESSION_ID = s.SESSION_ID where ab.BATCH_ID= $id
         ")->row();
        return $row;
    }

    function departmentList(){

     return  $this->db->query("select * from ins_dept ")->result();
 }
 function departmentByid($id){

     return  $this->db->query("select a.*,b.FAC_DEPT_ID,b.FACULTY_ID,c.FACULTY_NAME from ins_dept a 
        left join ins_fac_dept b on a.DEPT_ID = b.DEPT_ID
        left join ins_faculty c on b.FACULTY_ID = c.FACULTY_ID where a.DEPT_ID=$id")->row();
 }
 function deptByFacId($id){

     return  $this->db->query("select a.*,b.FAC_DEPT_ID,b.FACULTY_ID,c.FACULTY_NAME from ins_dept a 
        left join ins_fac_dept b on a.DEPT_ID = b.DEPT_ID
        left join ins_faculty c on b.FACULTY_ID = c.FACULTY_ID where b.FACULTY_ID=$id")->result();
 }
 function admissionSessionList(){

     return  $this->db->query("SELECT ye.YEAR_ID,ye.YEAR_TITLE FROM ins_years ye ")->result();
 }
 function admissionSessionById($id){

     return  $this->db->query("SELECT a.*, concat(b.SESSION_NAME, ' - ', a.DINYEAR) AS SESSION_NAME
      FROM adm_ysession a LEFT JOIN ins_session b ON a.SESSION_ID = b.SESSION_ID
      WHERE a.YSESSION_ID =$id")->row();
 }  
 function academicSessionList(){

     return  $this->db->query("SELECT se.YEAR_ID,se.YEAR_TITLE FROM ins_years se")->result();
 }   
 function academicSession(){

     return  $this->db->query("SELECT se.YEAR_ID,se.YEAR_TITLE FROM ins_years se")->result();
 } 

 function academicSessionById($id){

     return  $this->db->query("SELECT a.*, concat(b.SESSION_NAME, ' - ', a.DINYEAR) AS SESSION_NAME
      FROM ins_ysession a LEFT JOIN ins_session b ON a.SESSION_ID = b.SESSION_ID
      WHERE a.YSESSION_ID =$id")->row();
 }

 function admissionProgramList(){

     return  $this->db->query("select a.*,b.*,c.PROGRAM_NAME,d.DEGREE_NAME from adm_program a 
        left join adm_prgdesc b on b.APRGDESC_ID=a.APRGDESC_ID
        left join ins_program c on a.PROGRAM_ID = c.PROGRAM_ID
        left join ins_degree d on a.DEGREE_ID=d.DEGREE_ID")->result();
 }
 function currentOfferdProgramList($degree_id){

     return  $this->db->query("select a.*,b.*,c.DEPT_NAME,c.DEPT_ID from adm_program a 
        left join adm_prgdesc b on b.APRGDESC_ID=a.APRGDESC_ID
        left join ins_dept c on a.COURSE_ID = c.DEPT_ID
        
        where   a.DEGREE_ID='$degree_id'")->result();
 }


 function getAllUserInfo()
 {
     return  $this->db->query("SELECT su.*,sug.USERGRP_NAME, sul.UGLEVE_NAME, a.*, b.DEPT_NAME, c.DESIGNATION
        FROM SA_USERS su 

        INNER JOIN SA_USER_GROUP sug on sug.USERGRP_ID = su.USERGRP_ID
        INNER JOIN SA_UG_LEVEL sul on sul.UG_LEVEL_ID = su.USERLVL_ID
        INNER JOIN hr_emp a on su.EMP_ID = a.EMP_ID
        INNER JOIN ins_dept b on su.DEPT_ID = b.DEPT_ID
        INNER JOIN hr_desig c on su.DESIG_ID = c.DESIG_ID")->result();
 }

 function getThisUserInfo($user_id)
 {
    return  $this->db->query("SELECT su.*,sug.USERGRP_NAME, sul.UGLEVE_NAME, a.*, b.DEPT_NAME, c.DESIGNATION
        FROM SA_USERS su 

        INNER JOIN SA_USER_GROUP sug on sug.USERGRP_ID = su.USERGRP_ID
        INNER JOIN SA_UG_LEVEL sul on sul.UG_LEVEL_ID = su.USERLVL_ID
        INNER JOIN hr_emp a on su.EMP_ID = a.EMP_ID
        INNER JOIN ins_dept b on su.DEPT_ID = b.DEPT_ID
        INNER JOIN hr_desig c on su.DESIG_ID = c.DESIG_ID WHERE su.USER_ID = '$user_id'")->result();
}

    function percentCalculation($obtain_marks, $allocated_marks, $percentage)
    {
         $percentage_mark = ( $obtain_marks / $allocated_marks ) * 100; // 100% marks conversion
         return $obtained_percentage_mark = round(($percentage / 100 ) * $percentage_mark); // Obtained Percentage Mark
     }

    //CRUD Operation
    //Insert
    public function save($table, $data){
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
    //Batch Insert
    public function saveByBatch($table, $batch){
        return $this->db->insert_batch($table, $batch);
    }

    //update
    public function update($table, $fld, $id, $data)
    {
        // get the record that you want to update
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where(array($fld => $id));
        $query = $this->db->get();

        // getting the Id
        $row = array_values($query->row_array());
        $updated_id = $row[0];

        // updating the record
        $updated_status = $this->db->update($table, $data, array($fld => $id));

        if($updated_status):
            return $updated_id;
        else:
            return false;
        endif;
    }

    //update2 for multi update
    public function update2($table, $where, $data)
    {
        // updating the record
        return $this->db->update($table, $data, $where);
    }


    //Batch Update
    public function updateByBatch($table, $fld, $batch){
        return $this->db->update_batch($table, $batch, $fld);
    }
    //Update Previous or Last Row
    public function updateLastRow($table, $fld, $where, $data){
        $this->db->order_by($fld, "desc");
        $this->db->limit(1);
        $this->db->where($where);
        $this->db->update($table, $data);
    }
    //delete
    public function delete($table, $where=array())
    {
        return $this->db->delete($table, $where);
    }
    //Find all
    public function findAll($table)
    {
        $this->db->select('*');
        $this->db->from($table);
        $query = $this->db->get();
        return $query->result();
    }
    //Find all by Desc
    public function findAllByDesc($table, $fld)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by($fld, "desc");
        $query = $this->db->get();
        return $query->result();
    }
    //Find by value
    public function findById($table, $attribute, $value)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($attribute, $value);
        $query = $this->db->get();
        return $query->result();
    }
    // Find All by Limit
    public function findAllByLimit($table, $fld, $limit='', $offset='') {
        $this->db->select('*');
        $this->db->order_by($fld, 'DESC');
        $this->db->from($table);
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result();
    }
    // Find by ID & Limit
    public function findByIdAndLimit($table, $fld, $id='', $limit='', $offset='') {
        $this->db->select('*');
        $this->db->order_by($fld, 'DESC');
        $this->db->from($table);
        $this->db->limit($limit, $offset);
        $this->db->where(array($fld => $id));
        $query = $this->db->get();
        return $query->result();
    }

    // Find by multiple && condition
    public function findByAndWhere($table, $where) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    // Find by multiple && with || condition
    public function findByOrWhere($table, $where, $or_where) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where);
        $this->db->or_where($or_where);
        $query = $this->db->get();
        return $query->result();
    }

    //Find By Left Join using tow Tables
    function findByLeftJoinT2($table1, $table2, $t2attr, $t1id, $where, $group_by_id='', $order_by_id='')
    {
        //die(var_dump($where));
        if($this->session->userdata('my_db')=='ORACLE')
        {
            return $this->db->query("
            SELECT t1.*, t2.* FROM ".$table1." t1 LEFT JOIN ".$table2." t2 ON t2.".$t2attr." = t1.".$t1id.$where." ORDER BY ".$order_by_id." DESC
        ")->result();
        }
        else
        {
            $this->db->select("t1.*,t2.*");
            $this->db->from($table1." t1");
            $this->db->join($table2." t2", "t2.".$t2attr." = t1.".$t1id,'left');
            $this->db->where($where);
            $this->db->group_by('t1.'.$group_by_id);
            $this->db->order_by('t1.'.$order_by_id, "DESC");
            $query = $this->db->get();
            return $query->result();
        }
    }

    //End CRUD Operation


    //Datatables
    private function _get_datatables_query($table)
    {

        //Searchable columns
        $column = array('FULL_NAME_ENG','APPLICATION_ID', 'MERIT_POSITION');
        $order = array('MERIT_POSITION' => 'desc');

        $this->db->from($table);

        $i = 0;
        foreach ($column as $item)
        {
            if(!empty($_POST['search']['value']))
            {
                ($i === 0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
            }

            $column[$i] = $item;
            $i++;
        }

        if(isset($_POST['order']))
        {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($table)
    {
        $this->_get_datatables_query($table);

        if(!empty($_POST['length']))
        {
            if($_POST['length'] != -1)
            {
                $this->db->limit($_POST['length'], $_POST['start']);
            }
        }

        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($table)
    {
        $this->_get_datatables_query($table);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($table)
    {
        $this->db->from($table);
        return $this->db->count_all_results();
    }
    //End Datatables


}

