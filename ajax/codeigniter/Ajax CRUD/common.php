<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends CI_Controller {

    /**
     * @methodName  dis_by_div_id()
     * @access      
     * @param        
     * @author   Rakib Roni <rakib@atilimited.net>
     * @return      ajax district list by division ID
     */
    function dis_by_div_id() {
        $DIVISION_ID = $_POST['DIVISION_ID'];
        $query = $this->utilities->findAllByAttribute('sa_districts', array("DIVISION_ID" => $DIVISION_ID, "ACTIVE_FLAG" => 1));
        $returnVal = '<option value = "">--Select--</option>';
        if (!empty($query)) {
            foreach ($query as $row) {
                $returnVal .= '<option value = "' . $row->DISTRICT_ID . '">' . $row->DISTRICT_ENAME . '</option>';
            }
        }
        echo $returnVal;
    }

    /**
     * @methodName  up_thana_by_dis_id()
     * @access      
     * @param        
     * @author   Rakib Roni <rakib@atilimited.net>
     * @return      ajax district list by division ID
     */
    function up_thana_by_dis_id() {
        $DISTRICT_ID = $_POST['DISTRICT_ID'];
        $query = $this->utilities->findAllByAttribute('sa_thanas', array("DISTRICT_ID" => $DISTRICT_ID));
        $returnVal = '<option value = "">--Select--</option>';
        if (!empty($query)) {
            foreach ($query as $row) {
                $returnVal .= '<option value = "' . $row->THANA_ID . '">' . $row->THANA_ENAME . '</option>';
            }
        }
        echo $returnVal;
    }

    /**
     * @methodName  police_station_by_thana_id()
     * @access      
     * @param        
     * @author   Rakib Roni <rakib@atilimited.net>
     * @return      ajax district list by division ID
     */
    function police_station_by_thana_id() {
        $THANA_ID = $_POST['THANA_ID'];
        $query = $this->utilities->findAllByAttribute('sa_police_station', array("THANA_ID" => $THANA_ID));
        $returnVal = '<option value = "">--Select--</option>';
        if (!empty($query)) {
            foreach ($query as $row) {
                $returnVal .= '<option value = "' . $row->POLICE_STATION_ID . '">' . $row->PS_ENAME . '</option>';
            }
        }
        echo $returnVal;
    }

    /**
     * @methodName  union_by_thana_id()
     * @access     
     * @param        
     * @author   Rakib Roni <rakib@atilimited.net>
     * @return      ajax district list by division ID
     */
    function union_by_thana_id() {
        $THANA_ID = $_POST['THANA_ID'];
        $query = $this->utilities->findAllByAttribute('sa_unions', array("THANA_ID" => $THANA_ID));
        $returnVal = '<option value = "">--Select--</option>';
        if (!empty($query)) {
            foreach ($query as $row) {
                $returnVal .= '<option value = "' . $row->UNION_ID . '">' . $row->UNION_NAME . '</option>';
            }
        }
        echo $returnVal;
    }

    /**
     * @methodName  post_office_by_thana_id()
     * @access      
     * @param        
     * @author   Rakib Roni <rakib@atilimited.net>
     * @return      ajax district list by division ID
     */
    function post_office_by_thana_id() {
        $THANA_ID = $_POST['THANA_ID'];
        $query = $this->utilities->findAllByAttribute('sa_post_offices', array("THANA_ID" => $THANA_ID));
        $returnVal = '<option value = "">--Select--</option>';
        if (!empty($query)) {
            foreach ($query as $row) {
                $returnVal .= '<option value = "' . $row->POST_OFFICE_ID . '">' . $row->POST_OFFICE_ENAME . ' [ ' . $row->POST_CODE . ' ] ' . '</option>';
            }
        }
        echo $returnVal;
    }

    /**
     * @methodName  departmentByFaculty()
     * @access public
     * @param
     * @author   Rakib Roni <rakib@atilimited.net> 
     * @return      ajax department list by faculty ID
     */
    public function departmentByFaculty() {
        $faculty_id = $_POST['faculty_id'];
        $query = $this->utilities->deptByFacId($faculty_id);        
        $returnVal = '<option value = "">--Select--</option>';
        if (!empty($query)) {
            foreach ($query as $row) {
                $returnVal .= '<option value = "' . $row->DEPT_ID . '">' . $row->DEPT_NAME . '</option>';
            }
        }
        echo $returnVal;
    }

    /**
     * @methodName  departmentByFaculty()
     * @access public
     * @param 
     * @author   Rakib Roni <rakib@atilimited.net> 
     * @return      ajax program list by faculty ID
     */
    public function programByFaculty() {
        $faculty_id = $_POST['faculty_id'];
        $query = $this->utilities->findAllByAttribute('program', array("FACULTY_ID" => $faculty_id, "ACTIVE_STATUS" => 1));
        $returnVal = '<option value = "">--Select--</option>';
        if (!empty($query)) {
            foreach ($query as $row) {
                $returnVal .= '<option value = "' . $row->PROGRAM_ID . '">' . $row->PROGRAM_NAME . '</option>';
            }
        }
        echo $returnVal;
    }

    /**
     * @methodName  programByFaculty()
     * @access public
     * @param 
     * @author   Rakib Roni <rakib@atilimited.net>
     * @return      ajax program list by department ID
     */
    public function programByDepartment() {
        $department_id = $_POST['department_id'];
        $query = $this->utilities->findAllByAttribute('ins_program', array("DEPT_ID" => $department_id, "ACTIVE_STATUS" => 1));
        $returnVal = '<option value = "">--Select--</option>';
        if (!empty($query)) {
            foreach ($query as $row) {
                $returnVal .= '<option value = "' . $row->PROGRAM_ID . '">' . $row->PROGRAM_NAME . '</option>';
            }
        }
        echo $returnVal;
    }
    /**
     * @methodName  batchByProgramId()
     * @access public
     * @param
     * @author   Rakib Roni <rakib@atilimited.net>
     * @return      ajax program list by department ID
     */
    public function batchByProgramId() {
        $program_id = $_POST['program_id'];
        $session_id = $_POST['session_id'];
        $query = $this->utilities->findAllByAttribute('aca_batch', array("PROGRAM_ID" => $program_id,"SESSION_ID"=>$session_id, "ACTIVE_STATUS" => 1));
        $returnVal = '<option value = "">--Select--</option>';
        if (!empty($query)) {
            foreach ($query as $row) {
                $returnVal .= '<option value = "' . $row->BATCH_ID . '">' . $row->BATCH_TITLE . '</option>';
            }
        }
        echo $returnVal;
    }
    public function designationByDept() {
        $DEPT_ID= $_POST['DEPT_ID'];

        $query = $this->utilities->findAllByAttribute('designations', array("DEPT_ID" => $DEPT_ID, "ACTIVE_STATUS" => 1));
        $returnVal = '<option value = "">--Select--</option>';
        if (!empty($query)) {
            foreach ($query as $row) {
                $returnVal .= '<option value = "' . $row->DESIGNATION_ID . '">' . $row->DESIGNATION . '</option>';
            }
        }
        echo $returnVal;
    }
    /**
     * @methodName  batchByProgramId()
     * @access public
     * @param
     * @author   Rakib Roni <rakib@atilimited.net>
     * @return      ajax program list by department ID
     */
    public function programWiseBatch() {
        $program_id = $_POST['program_id'];

        $query = $this->db->query("SELECT b.BATCH_ID, b.BATCH_TITLE
          FROM aca_batch_prog a, aca_batch b
          WHERE a.BATCH_ID = b.BATCH_ID AND a.PROGRAM_ID =$program_id")->result();
        $returnVal = '<option value = "">--Select--</option>';
        if (!empty($query)) {
            foreach ($query as $row) {
                $returnVal .= '<option value = "' . $row->BATCH_ID . '">' . $row->BATCH_TITLE . '</option>';
            }
        }
        echo $returnVal;
    }

    public function buildingNameByCampus() {
        $campus_id = $_POST['campus_id'];

        $query = $this->db->query("SELECT *
          FROM sa_building a
          WHERE a.CAMPUS_ID = $campus_id")->result();

        $returnVal = '<option value = "">-- Select Building Name --</option>';
        if (!empty($query)) {
            foreach ($query as $row) {
                $returnVal .= '<option value = "' . $row->BUILDING_ID . '">' . $row->BUILDING_NAME . '</option>';
            }
        }
        echo $returnVal;
    }

    public function roomNoByThisAttribute() {
        $campus_id = $_POST['campus_id'];
        $building_id = $_POST['building_id'];
        $floor_id = $_POST['floor_id'];

        $query = $this->db->query("SELECT *
          FROM sa_room a
          WHERE a.CAMPUS_ID = $campus_id AND a.BUILDING_ID = $building_id AND a.FLOOR_ID = $floor_id")->result();

        $returnVal = '<option value = "">-- Select Room No. --</option>';
        if (!empty($query)) {
            foreach ($query as $row) {
                $returnVal .= '<option value = "' . $row->ROOM_ID . '">' . $row->ROOM_NO . '</option>';
            }
        }
        echo $returnVal;
    }

    public function programWiseCourse() {

        $session_id = $_POST['session_id'];
        $emp_id = $_POST['emp_id'];

        $query = $this->db->join('aca_course b', 'a.COURSE_ID = b.COURSE_ID', 'left')
            ->get_where('teacher_course_map a', array('a.SESSION_ID' => $session_id, 'a.EMP_ID' => $emp_id))->result();

        $returnVal = '<option value = "">--Select--</option>';
        if (!empty($query)) {
            foreach ($query as $row) {
                $returnVal .= '<option value = "' . $row->COURSE_ID . '">' . $row->COURSE_TITLE . '</option>';
            }
        }
        echo $returnVal;
    }

    public function studentListByThisAttribute() {

        $faculty_id = $_POST['FACULTY_ID'];
        $dept_id = $_POST['DEPT_ID'];
        $program_id = $_POST['PROGRAM_ID'];
        $batch_id = $_POST['BATCH_ID'];
        $section_id = $_POST['SECTION_ID'];

        $query = $this->db->get_where('student_personal_info a', array('a.FACULTY_ID' => $faculty_id, 'a.DEPT_ID' => $dept_id, 'a.PROGRAM_ID' => $program_id, 'a.BATCH_ID' => $batch_id, 'a.SECTION_ID' => $section_id ))->result();

        $returnVal = '<option value = "">--Select--</option>';
        if (!empty($query)) {
            foreach ($query as $row) {
                $returnVal .= '<option value = "' . $row->STUDENT_ID . '">' . $row->FULL_NAME_EN . '</option>';
            }
        }
        echo $returnVal;
    }

    public function deptWiseCourse() {
        $dept_id = $_POST['dept_id'];
        $session_id = $_POST['session_id'];

        //echo $program_id; exit;

        $query = $this->db->join('aca_course b', 'a.COURSE_ID = b.COURSE_ID', 'left')
        ->get_where('aca_semester_course a', array('a.SESSION_ID' => $session_id, 'a.DEPT_ID' => $dept_id))->result();

        // echo "<pre>"; print_r($data['abc']); exit;

        $returnVal = '<option value = "">--Select--</option>';
        if (!empty($query)) {
            foreach ($query as $row) {
                $returnVal .= '<option value = "' . $row->COURSE_ID . '">' . $row->COURSE_TITLE . '</option>';
            }
        }
        echo $returnVal;
    }

    /**
     * @access public
     * @param 
     * @author   Rakib Roni <rakib@atilimited.net> 
     * @return      ajax course list by faculty,department,program ID
     */
    public function getCourseByID() {
        $faculty_id = $_POST['faculty_id'];
        $department_id = $_POST['department_id'];
        $program_id = $_POST['program_id'];
        $semester_id = $_POST['semester_id'];
        //$data["courses"] = $this->utilities->findAllByAttribute('course_offer', array("FACULTY_ID" => $faculty_id, "DEPT_ID" => $department_id, "PROGRAM_ID" => $program_id, "ACTIVE_STATUS" => 1));
        $data['courses'] = $this->db->query("SELECT a.*,

            b.COURSE_CODE,
            b.COURSE_TITLE,
            b.CREDIT
            FROM aca_semester_course a LEFT JOIN aca_course b ON a.COURSE_ID = b.COURSE_ID
            WHERE a.FACULTY_ID = $faculty_id AND a.DEPT_ID = $department_id AND a.PROGRAM_ID = $program_id AND a.SEMESTER_ID = $semester_id")->result();
        $this->load->view('admin/admission/course_by_id', $data);
    }

    /**
     * @access public
     * @param 
     * @author   Rakib Roni <rakib@atilimited.net> 
     * @return      ajax course list by faculty,department,program ID
     */
    public function getCourseList() {
        $result = array();
        $return_arr = array();
        $term = $_REQUEST["term"];
        $courses = $this->db->query("SELECT COURSE_ID, COURSE_CODE, COURSE_TITLE FROM aca_course WHERE ACTIVE_STATUS = 1 AND COURSE_TITLE LIKE '%$term%'")->result();
        if (!empty($courses)) {
            foreach ($courses as $key => $value) {
                $return_arr['id'] = $value->COURSE_ID;
                $return_arr['text'] = $value->COURSE_TITLE;
                array_push($result, $return_arr);
            }
            $a['results'] = $result;
        }
        echo json_encode($a);
    }

    /**
     * @methodName  delRowData()
     * @access public
     * @param 
     * @author   Rakib Roni <rakib@atilimited.net> 
     * @return    ajax call common function for delete table row data 
     */
    function delRowData() {
        $attribute_id = $_POST['attribute_id'];
        $attribute = $_POST['attribute'];
        $table_name = $_POST['table_name'];
        if ($this->utilities->deleteRowByAttribute($table_name, array($attribute => $attribute_id))) {
            echo 'Y';
        } else {
            echo 'N';
        }
    }

    /**
     * @methodName  getCourseByProgramFromCourseOffer()
     * @access      public
     * @param
     * @author      Rakib Roni <rakib@atilimited.net>
     * @return
     */
    public function getCourseByProgramFromCourseOffer() {
        $program = $_POST['PROGRAM_ID'];
        $moderator = $_POST['MODERATOR_ID'];
        $teacher_assign_course = $this->db->query("SELECT a.COURSE_ID, b.COURSE_TITLE
          FROM techer_assigned_courses a
          LEFT JOIN aca_course b ON a.COURSE_ID = b.COURSE_ID
          WHERE a.TEACHER_ID = $moderator AND a.PROGRAM_ID = $program")->result();

        $courses = $this->db->query("SELECT b.COURSE_ID, b.COURSE_TITLE
            FROM aca_course_offer a LEFT JOIN aca_course b ON a.COURSE_ID = b.COURSE_ID
            WHERE a.PROGRAM_ID =$program ")->result();

        $coursesArray = array();
        if (!empty($courses)) {
            foreach ($courses as $row) {
                $coursesArray[$row->COURSE_ID] = $row->COURSE_TITLE;
            }
        }
        $teacherCoursesArray = array();
        if (!empty($teacher_assign_course)) {
            foreach ($teacher_assign_course as $row) {
                $teacherCoursesArray[$row->COURSE_ID] = $row->COURSE_TITLE;
            }
        }
        $course_list = array_diff($coursesArray, $teacherCoursesArray);

        $result = '<option value = "">--Select--</option>';
        foreach ($course_list as $m => $n) {
            $result .='<option value="' . $m . '">' . $n . '</option>';
        }
        echo $result;
    }

    /**
     * @method  string getOfferedCoursesByProgram()
     * @access      public
     * @param       PROGRAM_ID is a integer defining Program id
     * @author      Jahid Hasan <jahid@atilimited.net>
     * @return      
     */
    public function getOfferedCoursesByProgram() {
        $faculty = $_POST['FACULTY_ID'];
        $dept = $_POST['DEPT_ID'];
        $program = $_POST['PROGRAM_ID'];
        $dataArray = array("aca_course_offer.PROGRAM_ID" => $program, "aca_course_offer.FACULTY_ID" => $faculty, "aca_course_offer.DEPT_ID" => $dept);
        $courses = $this->utilities->findAllByAttributeWithJoinMF("aca_course_offer", "aca_course", "COURSE_ID", "COURSE_ID", "aca_course.COURSE_ID, aca_course.COURSE_TITLE", $dataArray, $joinType = 'inner');
        $result = '<option value = "">--Select--</option>';
        if (!empty($courses)):
            foreach ($courses as $row) {
                $result .='<option value="' . $row->COURSE_ID . '">' . $row->COURSE_TITLE . '</option>';
            }
            else:
                $result = '<option value = "">No Course Found</option>';
            endif;
            echo $result;
        }

    /**
     * @method  string getBatchBySemester()
     * @access      public
     * @param       PROGRAM_ID is a integer defining Program id
     * @author      Jahid Hasan <jahid@atilimited.net>
     * @return      
     */
    public function getBatchBySemester() {
        $faculty = $_POST['FACULTY_ID'];
        $dept = $_POST['DEPT_ID'];
        $program = $_POST['PROGRAM_ID'];
        $semester = implode(",", $_POST['SEMESTER_ID']);
        $session = $_POST['SESSION_ID'];
        $batches = $this->db->query("SELECT BATCH_ID, BATCH_TITLE, (SELECT s.SEMESTER_NAME FROM sav_semester s WHERE s.SEMESTER_ID = aca_batch.SEMESTER_ID)SEMESTER_NAME
            FROM aca_batch WHERE `PROGRAM_ID` = '$program' AND `FACULTY_ID` = '$faculty' AND `DEPT_ID` = '$dept' 
            AND SEMESTER_ID IN ($semester) AND `SESSION_ID` = '$session'")->result();
        if (!empty($batches)):
            foreach ($batches as $row) {
                $result = '<option value="' . $row->BATCH_ID . '">' . $row->BATCH_TITLE . '</option>';
            }
            else:
                $result = '<option value = "">No Batch Found</option>';
            endif;
            echo $result;
        }

    /**
     * @methodName  teacherByDepartment()
     * @access      public
     * @param
     * @author      Rakib Roni <rakib@atilimited.net>
     * @return      teacher list by department id
     */
    function teacherByDepartment() {
        $department_id = $_POST['department_id'];
        $query = $this->utilities->findAllByAttribute('sa_users', array("DEPT_ID" => $department_id));
        $returnVal = '';
        if (!empty($query)) {
            foreach ($query as $row) {
                $returnVal .= '<option value="'.$row->USER_ID.'">' . $row->FULL_NAME . '</option>';
            }
        }else {
            $returnVal='';
        }
        echo $returnVal;
    }

    /**
     * @methodName  teacherByDepartment()
     * @access      public
     * @param
     * @author      Rakib Roni <rakib@atilimited.net>
     * @return      teacher list table view by department id
     */
    function teacherSearchList() {

        $department_id = $_POST['department_id'];
        $department_sql = "";
        if ($department_id != "") {
            $department_sql = " AND a.DEPT_ID = $department_id";
        }
        $GENDER = $_POST['GENDER'];
        $gender_sql = "";
        if ($GENDER != "") {
            $gender_sql = " AND a.GENDER = '$GENDER'";
        }
        $RELIGION = $_POST['RELIGION'];
        $RELIGION_sql = "";
        if ($RELIGION != "") {
            $RELIGION_sql = " AND a.RELIGION_ID = $RELIGION";
        }
        $BLOOD_GROUP = $_POST['BLOOD_GROUP'];
        $BLOOD_GROUP_sql = "";
        if ($BLOOD_GROUP != "") {
            $BLOOD_GROUP_sql = " AND a.BLOOD_GROUP = $BLOOD_GROUP";
        }
        $MERITAL_STATUS = $_POST['MERITAL_STATUS'];
        $MERITAL_STATUS_sql = "";
        if ($MERITAL_STATUS != "") {
            $MERITAL_STATUS_sql = " AND a.MARITAL_STATUS = $MERITAL_STATUS";
        }
        $SKILL_ID = $_POST['SKILL_ID'];
        $SKILL_ID_sql = "";
        if ($SKILL_ID != "") {
            $SKILL_ID_sql = " AND b.SKILL_AREA = $SKILL_ID";
        }

        $data['teachers'] = $this->db->query("select * from faculty")->result();
        $data['teachers'] = $this->db->query("SELECT a.*,c.DESIGNATION
         FROM sa_users a


         LEFT JOIN teacher_staff_skill b ON a.USER_ID=b.USER_ID
         left join designations c on a.DESIGNATION_ID =c.DESIGNATION_ID
         WHERE a.USER_TYPE =290 $department_sql $gender_sql $RELIGION_sql $BLOOD_GROUP_sql $MERITAL_STATUS_sql $SKILL_ID_sql GROUP BY a.USER_ID")->result();
        $this->load->view('teacher/teacher_tbl_view_by_dep_id', $data);
    }

    /**
     * @methodName  courseListByTeahcerId()
     * @access      public
     * @param
     * @author      Rakib Roni <rakib@atilimited.net>
     * @return      teacher list by department id
     */
    function courseListByTeahcerId() {
        $teacher_id = $_POST['teacher_id'];
        $query = $this->db->query("SELECT b.COURSE_TITLE, b.COURSE_CODE
          FROM techer_assigned_courses a
          LEFT JOIN aca_course b ON a.COURSE_ID = b.COURSE_ID
          WHERE a.TEACHER_ID =$teacher_id")->result();
        $returnVal = '';
        if (!empty($query)) {
            foreach ($query as $row) {

                $returnVal .= '<li>' . $row->COURSE_TITLE . '&nbsp;&nbsp;&nbsp;[&nbsp;' . $row->COURSE_CODE . '&nbsp;]</li>';
            }
        } else {
            $returnVal = 'No data found';
        }
        echo $returnVal;
    }
    /**
     * @methodName  courseListByTeahcerId()
     * @access      public
     * @param
     * @author      Rakib Roni <rakib@atilimited.net>
     * @return      teacher list by department id
     */
    function courseListByDepId() {
        $department_id = $_POST['dept_id'];
        $query = $this->db->query("SELECT a.*
          FROM aca_course a
          WHERE a.DEPT_ID =$department_id")->result();
        $returnVal = '<option value="">--Select-- </option>';
        if (!empty($query)) {
            foreach ($query as $row) {

                $returnVal .= '<option value="' . $row->COURSE_ID . '">' . $row->COURSE_TITLE . '&nbsp;&nbsp;&nbsp;[&nbsp;' . $row->COURSE_CODE . '&nbsp;]</option>';
            }
        } else {
            $returnVal='';
        }
        echo $returnVal;
    }
    /**
     * @methodName  userLavelByGrId()
     * @access
     * @param
     * @author      Rakib Roni <rakib@atilimited.net>
     * @return      user group wise lavel list
     */
    function userLavelByGrId() {
        $user_group_id = $_POST['user_group_id'];
        $data['user_group_lavel'] = $this->utilities->findAllByAttribute('sa_ug_level', array('USERGRP_ID' => $user_group_id));
        $this->load->view('admin/ajax_lavel_list', $data);
    } 
       /**
     * @methodName  userLavelByGrId()
     * @access
     * @param
     * @author      Rakib Roni <rakib@atilimited.net>
     * @return      user group wise lavel list
     */
       function deptWiseTeacherList() {
        $dept_id = $_POST['dept_id'];
         $query= $this->db->query("SELECT a.*
            FROM hr_emp a, hr_edeptdesi b
            WHERE     a.EMP_ID = b.EMP_ID
            AND a.EMP_TYPE = 'T'
            AND b.DEPT_ID = $dept_id
            AND b.ACTIVE_STATUS = 1")->result();
        $returnVal = '<option value="0" >--Select--</option>';
        if (!empty($query)) {
            foreach ($query as $row) {
                $returnVal .= '<option value="' . $row->EMP_ID . '">' . $row->FULL_ENAME .'</option>';
            }
        }
        echo $returnVal;

    }

    /**
     * @methodName  checkDuplicateByField()
     * @access      public
     * @param
     * @author      Rakib Roni <rakib@atilimited.net>
     * @return      check duplicate by attribute value
     */
    function checkDuplicateByField() {

        $table_name = $_POST['table_name'];
        $attribute_name = $_POST['attribute_name'];
        $attribute_value = $_POST['attribute_value'];
        $chk = $this->utilities->hasInformationByThisId($table_name, array($attribute_name => $attribute_value));
        if ($chk == TRUE) {
            echo 'Y';
        } else {
            echo 'N';
        }
    }

    function allBlogPost()
    {
        $user_session = $this->session->userdata('logged_in');
        $user_type = $user_session['USER_TYPE'];
        $this->user_id = $user_session['USER_ID'];

        $user_session = $this->session->userdata('stu_logged_in');
        $user_type = $user_session['USER_TYPE'];


        $data['contentTitle'] = 'Blog List';
        $data["breadcrumbs"] = array(
            "Teacher" => "#",
            "Blog List" => '#'
            );
        $this->load->library('pagination');
        $config = array();
        $config["base_url"] = base_url() . "common/allBlogPost";
        $total_post = $this->db->count_all("blog_post");

        $config["total_rows"] = $total_post;

        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $limit = $config["per_page"] = 5;
        //pagination style start
        $config['full_tag_open'] = '<ul class="tsc_pagination tsc_paginationA tsc_paginationA01">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="current"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['first_link'] = '&lt;&lt;';
        $config['last_link'] = '&gt;&gt;';
        //pagination style end
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['blog_list'] = $this->db->query("SELECT a.*, b.POST_TAGS,c.FULL_NAME
            FROM blog_post a LEFT JOIN blog_tag b ON a.POST_ID = b.POST_ID
            left join sa_users c on a.ENTERED_BY=c.USER_ID  where a.APPROVE_BY_ADMIN=1 LIMIT $limit OFFSET $page
            ")->result();
        $data["links"] = $this->pagination->create_links();
        $data['content_view_page'] = 'teacher/blog/all_blog_post';
        if($user_type == 'Student'){
            $this->student_portal->display($data);
        }else{
            $this->admin_template->display($data);
        }
    }
    function blogDetails($id)
    {




        $user_session = $this->session->userdata('stu_logged_in');
        $user_type = $user_session['USER_TYPE'];

        $data['user_id'] = '' ;
        $data['contentTitle'] = 'Blog';
        $data['breadcrumbs'] = array(
            'Blog' => '#',
            'Blog Details' => '#',
            );
        $data['blog_details'] = $this->db->query("SELECT a.*, b.POST_TAGS,c.FULL_NAME,c.USER_IMG
            FROM blog_post a
            LEFT JOIN blog_tag b ON a.POST_ID = b.POST_ID
            LEFT JOIN sa_users c ON a.ENTERED_BY = c.USER_ID

            WHERE a.POST_ID = $id")->row();
        $data['cmt_by_post_id'] = $this->db->query("SELECT a.*, b.FULL_NAME, b.USER_IMG
            FROM blog_post_comment a
            LEFT JOIN sa_users b ON a.COMMENT_BY = b.USER_ID
            WHERE a.POST_ID =$id")->result();

        $data['content_view_page'] = 'teacher/blog/blog_details';

        if($user_type == 'Student'){
            $this->student_portal->display($data);
        }else{
            $user_session = $this->session->userdata('logged_in');
            $this->user_id = $user_session['USER_ID'];
            $data['user_id'] = $this->user_id ;
            $data['user_details'] = $this->db->query("select * from sa_users where USER_ID=$this->user_id")->row();
            $this->admin_template->display($data);
        }
    }

    /**
     * @access      public
     * @param       stu_logged_in is defining student session details
     * @author      Jahid Hasan <jahid@atilimited.net>
     * @return      All Semester Expnense Details Of Student
     */
    function allSemesterExpense()
    {
        $data['contentTitle'] = 'Payment History';
        $data["breadcrumbs"] = array(
            "Payment" => "common/allSemesterExpense",
            "payment history" => '#'
            );
        $data['pageTitle'] = 'Payment History';
        if($this->session->userdata('parents_logged_in')){
            $user_session = $this->session->userdata('parents_logged_in');
            $stu_id = $user_session['STUDENT_ID'];
            $txtStudent = $stu_id;
        }else{
            $stu_session = $this->session->userdata('stu_logged_in');
            $txtStudent = $stu_session["STUDENT_ID"];
        }

        $data['student_department_info'] = $this->db->query("SELECT a.FACULTY_ID,
            a.DEPT_ID,
            a.PROGRAM_ID,
            a.SEM_SESSION,
            a.SEMESTER_ID
            FROM stu_semesterinfo a
            WHERE a.STUDENT_ID = $txtStudent and a.IS_CURRENT='1'
            ")->row();

        $txtProgram = $data['student_department_info']->PROGRAM_ID;
        $txtFaculty = $data['student_department_info']->FACULTY_ID;
        $txtDept = $data['student_department_info']->DEPT_ID;
        $txtSession = $data['student_department_info']->SEM_SESSION;
        $semester = $data['student_department_info']->SEMESTER_ID;

        $data['txtStudent'] = $txtStudent;
        $data['txtFaculty'] = $txtFaculty;
        $data['txtDept'] = $txtDept;
        $data['txtProgram'] = $txtProgram;

        // getting all semester ids of student
        $prev_all_semester_ids = $this->db->query("SELECT s.S_SEMESTER_ID, s.STUDENT_ID, s.SEMESTER_ID, sv.SEMESTER_NAME, sv.SL_NO
            FROM stu_semesterinfo s INNER JOIN sav_semester sv ON s.SEMESTER_ID = sv.SEMESTER_ID
            WHERE s.STUDENT_ID = '$txtStudent' AND s.FACULTY_ID = '$txtFaculty' AND s.DEPT_ID = '$txtDept'
            AND s.PROGRAM_ID = '$txtProgram'")->result();
        $ids = array();
        foreach ($prev_all_semester_ids as $prev_all_semester_id) {
            // pushing all semester ids into array
            $ids[] = $prev_all_semester_id->SEMESTER_ID;
        }
        $all_ids = implode(",", $ids);
        // getting expense details by semester ids
        $data["expenses"] = $this->db->query("SELECT m.LKP_ID,m.LKP_NAME, p.SESSION_ID, s.SESSION_NAME SESSION, SUM(p.PARTICULAR_AMOUNT)EXPENSE_AMT
            FROM ac_program_particulars p LEFT JOIN m00_lkpdata m ON p.SEMESTER_ID = m.LKP_ID
            INNER JOIN session_view s ON p.SESSION_ID = s.SESSION_ID
            WHERE p.FACULTY_ID = $txtFaculty AND p.DEPT_ID = $txtDept AND p.PROGRAM_ID = $txtProgram
            AND p.SEMESTER_ID IN ($all_ids) GROUP BY p.SEMESTER_ID ORDER BY p.SEMESTER_ID DESC")->result();
        // total payment of a student in a semester
        $data["dueAmt"] = $this->db->query("SELECT v.VOUCHER_NO, v.VOUCHER_DT, v.STUDENT_ID, v.ROLL_NO, v.REMARKS, l.TRX_CODE_NO, l.TRX_TRAN_NO, l.CR_AMT, sum(l.DR_AMT) DEBIT
            FROM bm_vouchermst v INNER JOIN bm_vn_ledgers l ON v.VOUCHER_NO = l.VOUCHER_NO
            WHERE v.STUDENT_ID = '$txtStudent' AND l.TRX_CODE_NO = 'PM' GROUP BY v.STUDENT_ID")->row();
        $data['content_view_page'] = 'common/payment/stu_all_expense_details';
        if($this->session->userdata('parents_logged_in')){
            $this->parents_template->display($data);
        }else{
            $this->student_portal->display($data);
        }
    }


    function classSchedule()
    {
        $data['contentTitle'] = 'Class Schedule';
        $data["breadcrumbs"] = array(
            "Admin" => "admin/index",
            "Class Schedule" => '#'
            );
        if($this->session->userdata('parents_logged_in')){
            $user_session = $this->session->userdata('parents_logged_in');
            $stu_id = $user_session['STUDENT_ID'];

        }else{
            $stu_session = $this->session->userdata('stu_logged_in');
            $stu_id = $stu_session["STUDENT_ID"];
        }

        $data['student_info'] = $this->utilities->findByAttribute('stu_semesterinfo', array('STUDENT_ID' => $stu_id, 'IS_CURRENT' => 1));
        $data['reg_course'] = $this->db->query("SELECT a.COURSE_ID, b.COURSE_TITLE, b.COURSE_CODE
          FROM stu_courseinfo a LEFT JOIN aca_course b ON a.COURSE_ID = b.COURSE_ID
          WHERE a.STUDENT_ID = '$stu_id' and a.IS_CURRENT='1'")->result();

        $data['content_view_page'] = 'student/class_schedule';
        if($this->session->userdata('parents_logged_in')){
            $this->parents_template->display($data);
        }else{
            $this->student_portal->display($data);

        }
    }

    function examSchedule()
    {

        $data['contentTitle'] = 'Exam Schedule';
        $data["breadcrumbs"] = array(
            "Student" => "#",
            "Exam Schedule" => '#'
            );
        if($this->session->userdata('parents_logged_in')){
            $user_session = $this->session->userdata('parents_logged_in');
            $stu_id = $user_session["STUDENT_ID"];
            $student_info = $this->utilities->studentInfo($stu_id);
            $program = $student_info->PROGRAM_ID;
            $session = $student_info->SEM_SESSION;

        }else{
            $stu_session = $this->session->userdata('stu_logged_in');
            $stu_id = $stu_session["STUDENT_ID"];
            $student_info = $this->utilities->studentInfo($stu_id);
            $program = $student_info->PROGRAM_ID;
            $session = $student_info->SEM_SESSION;
        }


        $data['exam_schedule_list'] = $this->db->query("SELECT a.*,
         b.EX_TITLE,
         c.PROGRAM_NAME,
         d.COURSE_CODE,
         d.COURSE_TITLE,
         e.SESSION_NAME,
         f.BR_CODE,
         f.BR_NAME
         FROM exam_schedule a
         LEFT JOIN exam b ON a.EXAM_ID = b.EXAM_ID
         LEFT JOIN program c ON a.PROGRAM_ID = c.PROGRAM_ID
         LEFT JOIN aca_course d ON a.COURSE_ID = d.COURSE_ID
         LEFT JOIN session_view e ON a.SESSION_ID = e.SESSION_ID
         LEFT JOIN sc_building_room f ON a.BR_ID = f.BR_ID
         where a.PROGRAM_ID=$program and b.SESSION_ID=$session")->result();
        $data['content_view_page'] = 'student/exam_schedule_list';
        if($this->session->userdata('parents_logged_in')){
            $this->parents_template->display($data);
        }else{
            $this->student_portal->display($data);

        }
    }

    function studentCurriculms()
    {

        $data['contentTitle'] = 'Curriculum';
        $data["breadcrumbs"] = array(
            "Student" => "#",
            "Curriculum" => '#'
            );
        if($this->session->userdata('parents_logged_in')){
            $user_session = $this->session->userdata('parents_logged_in');

            $stu_id = $user_session["STUDENT_ID"];
            $student_info = $this->utilities->studentInfo($stu_id);


            $program = $student_info->PROGRAM_ID;
            $dept = $student_info->DEPT_ID;
            $faculty = $student_info->FACULTY_ID;
            $session = $student_info->SESSION_ID;

        }else{

            $stu_session = $this->session->userdata('stu_logged_in');
            $stu_id = $stu_session["STUDENT_ID"];
            $student_info = $this->utilities->studentInfo($stu_id);
            $program = $student_info->PROGRAM_ID;
            $dept = $student_info->DEPT_ID;
            $faculty = $student_info->FACULTY_ID;
            $session = $student_info->SESSION_ID;
        }


        $data["info"] = $this->db->query("SELECT DISTINCT(f.FACULTY_NAME), f.FACULTY_ID, dg.DEGREE_NAME, d.DEPT_ID, d.DEPT_NAME, p.PROGRAM_ID, p.PROGRAM_NAME,asca.SESSION_ID, s.SESSION_NAME, ys.YEAR_SETUP_TITLE
            FROM aca_semester_course asca
            LEFT JOIN faculty f on f.FACULTY_ID = asca.FACULTY_ID
            LEFT JOIN department d on d.DEPT_ID = asca.DEPT_ID
            LEFT JOIN program p on p.PROGRAM_ID = asca.PROGRAM_ID
            LEFT JOIN degree dg on dg.DEGREE_ID = p.DEGREE_ID
            LEFT JOIN session_year sy on sy.SES_YEAR_ID = asca.SESSION_ID
            LEFT JOIN session s on s.SESSION_ID = sy.SESSION
            LEFT JOIN year_setup ys on ys.YEAR_SETUP_ID = sy.YEAR_SETUP_ID
            WHERE asca.PROGRAM_ID = $program AND asca.DEPT_ID = $dept AND asca.FACULTY_ID = $faculty ")->result();


        $data["courses"] = $this->db->query("SELECT a.PROGRAM_ID, a.SEMESTER_ID, a.SESSION_ID, ac.COURSE_ID, ac.COURSE_TITLE,  ac.COURSE_CODE, ac.CREDIT, lkp.LKP_NAME
            FROM aca_semester_course a
            LEFT JOIN aca_course ac on a.COURSE_ID = ac.COURSE_ID
            LEFT JOIN m00_lkpdata lkp on lkp.LKP_ID = a.SEMESTER_ID
            WHERE a.PROGRAM_ID = $program AND a.DEPT_ID = $dept AND a.FACULTY_ID = $faculty
            ORDER BY a.SEMESTER_ID")->result();
       // echo "<pre>"; print_r($this->db->last_query()); exit; echo "</pre>";

        $data['content_view_page'] = 'student/student_course/semester_wise_course_list';
        if($this->session->userdata('parents_logged_in')){
            $this->parents_template->display($data);
        }else{
            $this->student_portal->display($data);

        }

    }



    /**
     * @access none
     * @param  none
     * @return pdf
     * @author Abhijit Mondal Abhi <abhijit@atilimited.net>
     */

    function coursecurriculum($session_id, $program_id, $offered_type)
    {

        $session = $session_id;
        $data['session_name']=$this->utilities->academicSessionById($session);
        $data["session"] =$session ;
        $program = $program_id;
        $OfferType = $offered_type;
        //$data['flag'] = $_POST['flag'];
        $data['courseCat'] = $this->utilities->getAll("aca_course_category");
        $data["program"] = $program;
        $data["offerType"] = $OfferType;
        $data["semester"] = $this->utilities->getAll("sav_semester");

        include('mpdf/mpdf.php');
        $mpdf = new mPDF();
        $mpdf->SetTitle('Offered Course');
        $mpdf->mirrorMargins = 1;
        $mpdf->useOnlyCoreFonts = true;
        $report = $this->load->view('admin/course/course_curriculum_pdf', $data, TRUE);
        //$footer = $this->load->view('admin/course/semester_course_info_footer', $data, TRUE);
        $mpdf->WriteHTML("$report");
        $mpdf->SetHTMLFooter("$footer");
        $mpdf->Output();
        exit;
    }




    //##################################################################

}

