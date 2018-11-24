<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @category
 * @package
 * @author     Abhijit M. Abhi <abhijit@atilimited.net>
 * @copyright  2017 ATI Limited Development Group
 */
class Exam extends MY_Controller
{

    private $user;
    public $user_id = null;

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_in') == FALSE) {
            redirect('auth/login', 'refresh');
        }
        $user_session = $this->user = $this->session->userdata("logged_in");
        $this->user_id = $user_session['USER_TYPE'];
        $this->load->model('utilities');
    }

    /**
     * @methodName checkPrevilege
     * @access none
     * @param  none
     * @author Abhijit M. Abhi <abhijit@atilimited.net>
     * @return previlege
     */

    public function checkPrevilege($param = "")
    {
        if ($param == "") {
            $controller = $this->uri->segment(1, 'dashboard');
            $action = $this->uri->segment(2, 'index');
            $link = "$controller/$action";
        } else {
            $link = "$param";
        }
        return $this->security_model->get_all_checked_module_links_by_user($link, $this->user['USERGRP_ID'], $this->user['USERLVL_ID'], $this->user['USER_ID']);
    }

    ##########################################################################################################
    /*                                          Exam Grade policy                                           */
    ##########################################################################################################

    /**
     * @methodName policy
     * @access
     * @param  none
     * @author Abhijit M. Abhi <abhijit@atilimited.net>
     * @return
     */

    function policy()
    {
        $data['contentTitle'] = 'Exam';
        $data['breadcrumbs'] = array(
            'Exam' => '#',
            'Grade Policy List' => '#',
            );
        $data["previlages"] = $this->checkPrevilege();
        $data['grade_policy'] = $this->utilities->getAll('exam_grade_policy');
        $data['content_view_page'] = 'admin/setup/exam/policy/policy_index';
        $this->admin_template->display($data);
    }

    /*
    * @methodName policyFormInsert
    * @access
    * @param  none
    * @author Abhijit M. Abhi <abhijit@atilimited.net>
    * @return policy add form
    */

    function policyFormInsert()
    {
        $data["ac_type"] = 1;
        $this->load->view('admin/setup/exam/policy/add_policy', $data);
    }

    /*
    * @methodName createPolicy
    * @accesss
    * @param  none
    * @author Abhijit M. Abhi <abhijit@atilimited.net>
    * @return
    */

    function createPolicy()
    {
        $grade_policy_Name = $this->input->post('grade_policy_Name');
        $grade_policy_Desc = $this->input->post('grade_policy_Desc');
        $start_date_string = $this->input->post('start_date');
        $end_date_string = $this->input->post('end_date');

        $start_date = date('Y-m-d', strtotime($start_date_string));
        $end_date = date('Y-m-d', strtotime($end_date_string));

        $status = ((isset($_POST['status'])) ? 1 : 0);

        $check = $this->utilities->hasInformationByThisId("exam_grade_policy", array("GR_POLICY_NAME" => $grade_policy_Name));
        if (empty($check)) {

            $policy = array(
                'GR_POLICY_NAME' => $grade_policy_Name,
                'GR_POLICY_DESC' => $grade_policy_Desc,
                'START_DATE' => $start_date,
                'END_DATE' => $end_date,
                'CREATED_BY' => $this->user["USER_ID"],
                'ACTIVE_STATUS' => $status,
                );

//            echo "<pre>"; print_r($policy); exit;

            if ($this->utilities->insertData($policy, 'exam_grade_policy')) {
                // if data inserted successfully
                echo "<div class='alert alert-success'>Policy Create successfully</div>";
            } else {
                // if data inserted failed
                echo "<div class='alert alert-danger'>Policy Name insert failed</div>";
            }
        } else {
            // if degree name not available
            echo "<div class='alert alert-danger'>Policy Name Already Exist</div>";
        }
    }

    /*
    * @methodName policyList
    * @access
    * @param  none
    * @author Abhijit M. Abhi <abhijit@atilimited.net>
    * @return list
    */

    function policyList()
    {
        $data["previlages"] = $this->checkPrevilege("exam/policy");
        $data['grade_policy'] = $this->utilities->findAllFromView('exam_grade_policy');
        $this->load->view("admin/setup/exam/policy/policy_list", $data);
    }

    /*
    * @methodName policyFormUpdate
    * @access
    * @param  none
    * @author Abhijit M. Abhi <abhijit@atilimited.net>
    * @return
    */

    function policyFormUpdate()
    {
        $data["ac_type"] = 2;
        $id = $this->input->post('param');
        $data['grade_policy'] = $this->utilities->findByAttribute('exam_grade_policy', array('GR_POLICY_ID' => $id));
        $this->load->view('admin/setup/exam/policy/add_policy', $data);
    }

    /*
    * @methodName updatePolicy
    * @access
    * @param  none
    * @author Abhijit M. Abhi <abhijit@atilimited.net>
    * @return
    */

    function updatePolicy()
    {
        $grd_policy_id = $this->input->post('txtgrade_policyId');
        $grade_policy_Name = $this->input->post('grade_policy_Name');
        $grade_policy_Desc = $this->input->post('grade_policy_Desc');
        $start_date_string = $this->input->post('start_date');
        $end_date_string = $this->input->post('end_date');
        $status = $this->input->post('status');

        $start_date = date('Y-m-d', strtotime($start_date_string));
        $end_date = date('Y-m-d', strtotime($end_date_string));

        $check = $this->utilities->hasInformationByThisId("exam_grade_policy", array("GR_POLICY_NAME" => $grade_policy_Name, "GR_POLICY_ID !=" => $grd_policy_id));

        if (empty($check)) {

            $policy = array(
                'GR_POLICY_NAME' => $grade_policy_Name,
                'GR_POLICY_DESC' => $grade_policy_Desc,
                'START_DATE' => $start_date,
                'END_DATE' => $end_date,
                'CREATED_BY' => $this->user["USER_ID"],
                'ACTIVE_STATUS' => $status,
                );

            if ($this->utilities->updateData('exam_grade_policy', $policy, array('GR_POLICY_ID' => $grd_policy_id))) {
                echo "<div class='alert alert-success'>Exam Grade Policy Update successfully</div>";
            } else { // if data update failed
                echo "<div class='alert alert-danger'>Exam Grade Policy Update failed</div>";
            }
        } else {// if degree name not available
            echo "<div class='alert alert-danger'>Exam Grade Policy Name Already Exist</div>";
        }
    }

    /*
    * @methodName policyById
    * @access
    * @param  none
    * @author Abhijit M. Abhi <abhijit@atilimited.net>
    * @return
    */

    function policyById()
    {
        $grd_policy_id = $this->input->post('param');
        $data["previlages"] = $this->checkPrevilege("exam/policy");
        $data['row'] = $this->utilities->findByAttribute('exam_grade_policy', array('GR_POLICY_ID' => $grd_policy_id));
        $this->load->view('admin/setup/exam/policy/single_policy_row', $data);
    }

    /*
    * @methodName deleteItem
    * @access
    * @param  none
    * @author Abhijit M. Abhi <abhijit@atilimited.net>
    * @return
    */

    public function deleteItem()
    {
        $item_id = $this->input->post('item_id');
        $data_tbl = $this->input->post('data_tbl');
        $data_field = $this->input->post('data_field');
        $attribute = array(
            "$data_field" => $item_id

            );
        $result = $this->utilities->deleteRowByAttribute($data_tbl, $attribute);
        if ($result == TRUE) {
            echo "Y";
        } else {
            echo "N";
        }
    }

    /*
     * @methodName statusItem
     * @access
     * @param  none
     * @author Abhijit M. Abhi <abhijit@atilimited.net>
     * @return
     */

    function statusItem()
    {
        $item_id = $this->input->post('item_id');
        $status = $this->input->post('status');
        $data_tbl = $this->input->post('data_tbl');
        $data_field = $this->input->post('data_field');
        $data_fieldId = $this->input->post('data_fieldId');
        if ($status == 1) {
            $new_status = 0;
        } else {
            $new_status = 1;
        }
        $update_status = array(
            "$data_field" => $new_status
            );
        if ($this->utilities->updateData($data_tbl, $update_status, array("$data_fieldId" => $item_id))) {
            echo "Y";
        } else {
            echo "N";
        }
    }


    ##########################################################################################################
    /*                                          Exam Grade                                         */
    ##########################################################################################################

    /**
     * @methodName grade
     * @access
     * @param  none
     * @author Abhijit M. Abhi <abhijit@atilimited.net>
     * @return
     */

    function grade()
    {
        $data['contentTitle'] = 'Exam';
        $data['breadcrumbs'] = array(
            'Exam' => '#',
            'Grade Setup' => '#',
            );
        $data["previlages"] = $this->checkPrevilege();
        $data['exam_grade'] = $this->exam_model->getAllExamSetup();

        //echo "<pre>"; print_r($data['exam_grade']); exit;

        $data['content_view_page'] = 'admin/setup/exam/grade/grade_index';
        $this->admin_template->display($data);
    }

    /*
    * @methodName gradeFormInsert
    * @access
    * @param  none
    * @author Abhijit M. Abhi <abhijit@atilimited.net>
    * @return policy add form
    */

    function gradeFormInsert()
    {
        $data["ac_type"] = 1;
        $data['exam_policy'] = $this->exam_model->getExamPolicies();
        // echo "sdf";
        // exit;
        $data['ins_degree'] = $this->utilities->getAll('ins_degree');
        $this->load->view('admin/setup/exam/grade/add_grade', $data);
    }

    /*
    * @methodName createGrade
    * @accesss
    * @param  none
    * @author Abhijit M. Abhi <abhijit@atilimited.net>
    * @return
    */

    function createGrade()
    {
        $grade_policy_id = $this->input->post('GR_POLICY_ID');
        $mark_start = $this->input->post('mark_start');
        $mark_end = $this->input->post('mark_end');
        $grade_letter = $this->input->post('grade_letter');
        $grade_point = $this->input->post('grade_point');

        $status = ((isset($_POST['status'])) ? 1 : 0);

        $check = $this->utilities->hasInformationByThisId("exam_grade", array("GR_POLICY_ID" => $grade_policy_id, "GR_LETTER" => $grade_letter));

        if (empty($check)) {

            $grade = array(
                'GR_POLICY_ID' => $grade_policy_id,
                'GR_MARKS_FROM' => $mark_start,
                'GR_MARKS_TO' => $mark_end,
                'GR_LETTER' => $grade_letter,
                'GRADE_POINT' => $grade_point,
                'CREATED_BY' => $this->user["USER_ID"],
                'ACTIVE_STATUS' => $status,
                );

            if ($this->utilities->insertData($grade, 'exam_grade')) {
                echo "<div class='alert alert-success'>Grade Create successfully</div>";
            } else {
                echo "<div class='alert alert-danger'>Grade insert failed</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Grade Already Exist</div>";
        }
    }

    /*
    * @methodName gradeList
    * @access
    * @param  none
    * @author Abhijit M. Abhi <abhijit@atilimited.net>
    * @return list
    */

    function gradeList()
    {
        $data["previlages"] = $this->checkPrevilege("exam/grade");
        $data['exam_grade'] = $this->exam_model->getAllExamSetup();
        $this->load->view("admin/setup/exam/grade/grade_list", $data);
    }

    /*
   * @methodName gradeFormUpdate
   * @access
   * @param  none
   * @author Abhijit M. Abhi <abhijit@atilimited.net>
   * @return
   */

    function gradeFormUpdate()
    {
        $data["ac_type"] = 2;
        $id = $this->input->post('param');
        $data['exam_policy'] = $this->utilities->getAll('exam_grade_policy');
        $data['ins_degree'] = $this->utilities->getAll('ins_degree');
        $data['exam_grade'] = $this->exam_model->getAllExamSetupById($id);
        $this->load->view('admin/setup/exam/grade/add_grade', $data);
    }

    /*
   * @methodName updateGrade
   * @access
   * @param  none
   * @author Abhijit M. Abhi <abhijit@atilimited.net>
   * @return
   */

    function updateGrade()
    {
        $grd_id = $this->input->post('txtexam_gradeId');
        $grade_policy_id = $this->input->post('GR_POLICY_ID');
        $mark_start = $this->input->post('mark_start');
        $mark_end = $this->input->post('mark_end');
        $grade_letter = $this->input->post('grade_letter');
        $grade_point = $this->input->post('grade_point');
        $status = $this->input->post('status');

        $grade = array(
            'GR_POLICY_ID' => $grade_policy_id,
            'GR_MARKS_FROM' => $mark_start,
            'GR_MARKS_TO' => $mark_end,
            'GR_LETTER' => $grade_letter,
            'GRADE_POINT' => $grade_point,
            'CREATED_BY' => $this->user["USER_ID"],
            'ACTIVE_STATUS' => $status,
            );

        if ($this->utilities->updateData('exam_grade', $grade, array('GR_ID' => $grd_id))) {
            echo "<div class='alert alert-success'>Exam Grade Setup Update successfully</div>";
        } else { // if data update failed
            echo "<div class='alert alert-danger'>Exam Grade Setup Update failed</div>";
        }

    }

    /*
   * @methodName gradeById
   * @access
   * @param  none
   * @author Abhijit M. Abhi <abhijit@atilimited.net>
   * @return
   */

    function gradeById()
    {
        $grd_id = $this->input->post('param');
        $data["previlages"] = $this->checkPrevilege("exam/policy");
        $data['row'] = $this->exam_model->getAllExamSetupById($grd_id);
        $this->load->view('admin/setup/exam/grade/single_grade_row', $data);
    }


    ##########################################################################################################
    /*                                          Exam Type                                                   */
    ##########################################################################################################

    /**
     * @methodName examType
     * @access
     * @param  none
     * @author Abhijit M. Abhi <abhijit@atilimited.net>
     * @return
     */

    function examMarksType()
    {
        $data['contentTitle'] = 'Exam';
        $data['breadcrumbs'] = array(
            'Exam' => '#',
            'Exam Marks Type' => '#',
            );
        $data["previlages"] = $this->checkPrevilege();
        $data['exam_type'] = $this->utilities->getAll('exam_marks_type');

        //echo "<pre>"; print_r($data['exam_grade']); exit;

        $data['content_view_page'] = 'admin/setup/exam/examMarksType/examMarksType_index';
        $this->admin_template->display($data);
    }

    /*
    * @methodName examTypeFormInsert
    * @access
    * @param  none
    * @author Abhijit M. Abhi <abhijit@atilimited.net>
    * @return policy add form
    */

    function examMarksTypeFormInsert()
    {
        $data["ac_type"] = 1;
        $this->load->view('admin/setup/exam/examMarksType/add_examMarksType', $data);
    }

    /*
   * @methodName createExamType
   * @accesss
   * @param  none
   * @author Abhijit M. Abhi <abhijit@atilimited.net>
   * @return
   */

    function createExamMarksType()
    {
        $exam_title = $this->input->post('exam_title');
        $exam_type_Desc = $this->input->post('exam_type_Desc');

        $status = ((isset($_POST['status'])) ? 1 : 0);

        $check = $this->utilities->hasInformationByThisId("exam_marks_type", array("MARKS_TITLE" => $exam_title));

        if (empty($check)) {

            $exam_type = array(
                'MARKS_TITLE' => $exam_title,
                'EX_DESC' => $exam_type_Desc,
                'CREATED_BY' => $this->user["USER_ID"],
                'ACTIVE_STATUS' => $status,
                );

            if ($this->utilities->insertData($exam_type, 'exam_marks_type')) {
                echo "<div class='alert alert-success'>Exam Marks Type created successfully</div>";
            } else {
                echo "<div class='alert alert-danger'>Exam Marks Type inserted failed</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Exam Marks Type  already Exist</div>";
        }
    }

    /*
   * @methodName examTypeList
   * @access
   * @param  none
   * @author Abhijit M. Abhi <abhijit@atilimited.net>
   * @return list
   */

    function examMarksTypeList()
    {
        $data["previlages"] = $this->checkPrevilege("exam/examMarksType");
        $data['exam_type'] = $this->utilities->findAllFromView('exam_marks_type');
        $this->load->view("admin/setup/exam/examMarksType/examMarksType_list", $data);
    }

    /*
    * @methodName examTypeFormUpdate
    * @access
    * @param  none
    * @author Abhijit M. Abhi <abhijit@atilimited.net>
    * @return
    */

    function examMarksTypeFormUpdate()
    {
        $data["ac_type"] = 2;
        $id = $this->input->post('param');
        $data['exam_type'] = $this->utilities->findByAttribute('exam_marks_type', array('EXAM_MARKS_TYPE_ID' => $id));
        $this->load->view('admin/setup/exam/examMarksType/add_examMarksType', $data);
    }

    /*
    * @methodName updateExamType
    * @access
    * @param  none
    * @author Abhijit M. Abhi <abhijit@atilimited.net>
    * @return
    */

    function updateExamMarksType()
    {
        $txtexam_typeId = $this->input->post('txtexam_typeId');
        $exam_title = $this->input->post('exam_title');
        $exam_type_Desc = $this->input->post('exam_type_Desc');

        $status = $this->input->post('status');

        $exam_type = array(
            'MARKS_TITLE' => $exam_title,
            'EX_DESC' => $exam_type_Desc,
            'CREATED_BY' => $this->user["USER_ID"],
            'ACTIVE_STATUS' => $status,
            );

        if ($this->utilities->updateData('exam_marks_type', $exam_type, array('EXAM_MARKS_TYPE_ID' => $txtexam_typeId))) {
            echo "<div class='alert alert-success'>Exam Marks Type Updated successfully</div>";
        } else {
            echo "<div class='alert alert-danger'>Exam Marks Type Updated failed</div>";
        }

    }

    /*
      * @methodName examTypeById
      * @access
      * @param  none
      * @author Abhijit M. Abhi <abhijit@atilimited.net>
      * @return
      */

    function examMarksTypeById()
    {
        $examType_id = $this->input->post('param');
        $data["previlages"] = $this->checkPrevilege("exam/examMarksType");
        $data['row'] = $this->utilities->findByAttribute('exam_marks_type', array('EXAM_MARKS_TYPE_ID' => $examType_id));
        $this->load->view('admin/setup/exam/examMarksType/single_examMarksType_row', $data);
    }


    ##########################################################################################################
    /*                                          Grading                                                     */
    ##########################################################################################################


    /*
   * @methodName grading
   * @access
   * @param  none
   * @author Abhijit M. Abhi <abhijit@atilimited.net>
   * @return
   */

    function grading()
    {
        $data['contentTitle'] = 'Exam';
        $data["breadcrumbs"] = array(
            "Exam" => "#",
            "Grading" => '#'
            );

        $department = $this->utilities->findByAttribute('ins_dept', array('DEPT_ID' => $this->session->userdata['logged_in']['DEPT_ID']));


        $data['dept_id'] = $department->DEPT_ID;
        $data['program'] = $this->utilities->findAllByAttribute('ins_program', array("DEPT_ID" => $department->DEPT_ID, "ACTIVE_STATUS" => 1));
        $data['session'] = $this->session->userdata['logged_in']['SESSION_ID'];
        $data['emp_id'] = $this->session->userdata['logged_in']['EMP_ID'];
        $data['section'] = $this->utilities->findAllByAttribute('aca_section', array("ACTIVE_STATUS" => 1));

        $data['mark_type'] = $this->exam_model->getAllMarksTypeByDept($department->DEPT_ID);

      //  echo "<pre>"; print_r($data['mark_type']); exit;

        //$data["session"] = $this->utilities->academicSessionList();
        $data['content_view_page'] = 'admin/setup/exam/grading/student_list';
        $this->admin_template->display($data);
    }

    /*
    * @methodName getCourses
    * @access
    * @param  none
    * @author Abhijit M. Abhi <abhijit@atilimited.net>
    * @return
    */

    function getCourses()
    {
        $data['course'] = $this->db->join('aca_course b', 'a.COURSE_ID = b.COURSE_ID')
        ->get_where('aca_semester_course a', array('a.SESSION_ID' => $session_id, 'a.PROGRAM_ID' => $program_id));
    }

    /*
    * @methodName studentList
    * @access
    * @param  none
    * @author Abhijit M. Abhi <abhijit@atilimited.net>
    * @return
    */


    function studentList()
    {
        $program_id = $this->input->post("PROGRAM_ID");
        $session_id = $this->input->post("INS_SESSION_ID");
        $batch_id = $this->input->post("BATCH_ID");
        $section_id = $this->input->post("SECTION_ID");
        $course_id = $this->input->post("COURSE_ID");
        $mark_type_id = $this->input->post("MARK_TYPE_ID");

        $data['percentage_val'] = $this->input->post('PERCENTAGE_VAL');

        //echo $mark_type_id.' hello'; exit;

        $data['program_id'] = $program_id;
        $data['session_id'] = $session_id;
        $data['batch_id'] = $batch_id;
        $data['section_id'] = $section_id;
        $data['mark_type_id'] = $mark_type_id;
        $data['offer_type'] = 'F';
        // echo "<pre>";
        // print_r($_POST);
        // exit;
        $data['student_list'] = $this->exam_model->getAllCourseEnrolledStudent($program_id, $session_id, $batch_id, $section_id, $course_id);
        $data['exam_type'] = $this->db->get_where('exam_marks_type', array('ACTIVE_STATUS' => 1))->result();


        $this->load->view('admin/setup/exam/grading/search_student_list', $data);
    }

    /*
    * @methodName loadStudentListWithMarks
    * @access
    * @param  none
    * @author Abhijit M. Abhi <abhijit@atilimited.net>
    * @return
    */

    function loadStudentListWithMarks()
    {
        $program_id = $this->input->post("PROGRAM_ID");
        $session_id = $this->input->post("INS_SESSION_ID");
        $batch_id = $this->input->post("BATCH_ID");
        $section_id = $this->input->post("SECTION_ID");
        $course_id = $this->input->post("COURSE_ID");
        $mark_type_id = $this->input->post("MARK_TYPE_ID");

        $data['program_id'] = $program_id;
        $data['session_id'] = $session_id;
        $data['batch_id'] = $batch_id;
        $data['section_id'] = $section_id;
        $data['mark_type_id'] = $mark_type_id;
        $data['offer_type'] = 'F';

        $data['student_marks'] = $this->exam_model->getStudentExamMarks($program_id, $session_id, $batch_id, $section_id, $course_id, $mark_type_id);
        $data['exam_type'] = $this->db->get_where('exam_marks_type', array('ACTIVE_STATUS' => 1))->result();

        //echo "<pre>"; print_r($data['student_marks']); exit;

        $this->load->view('admin/setup/exam/grading/load_student_result', $data);
    }

    /*
    * @methodName studentMarksInsert
    * @access
    * @param  none
    * @author Abhijit M. Abhi <abhijit@atilimited.net>
    * @return
    */

    function studentMarksInsert()
    {
        $session_id = $this->input->post('INS_SESSION_ID');
        $program_id = $this->input->post('PROGRAM_ID');
        $course_id = $this->input->post('COURSE_ID');
        $batch_id = $this->input->post('BATCH_ID');
        $section_id = $this->input->post('SECTION_ID');
        $emp_id = $this->input->post('EMP_ID');
        $dept_id = $this->input->post('DEPT_ID');
        $course_for = $this->input->post('COURSE_FOR');

        $STUDENT_ID = $this->input->post('STUDENT_ID');
        $mark_type_id = $this->input->post('MARK_TYPE_ID');
        $exam_mark = $this->input->post('mark');
        $mark_id = $this->input->post('MARK_ID');
        $remarks = $this->input->post('REMARKS');

        $allocated_marks = $this->input->post('ALLOCATED_MARKS');
        $grace_marks = $this->input->post('GRACE_MARKS');
        $percentage_val = $this->input->post('PERCENTAGE_VAL');


//        echo "<pre>"; print_r($STUDENT_ID); exit;

        foreach ($STUDENT_ID as $key => $value) {


            // Skips Marks Entry if Mark not given
            if (empty($exam_mark[$key])) {
                continue;
            }

            $check = $this->utilities->hasInformationByThisId("exam_student_marks", array("STUDENT_ID" => $STUDENT_ID[$key], "COURSE_ID" => $course_id, "MARKS_TYPE_ID" => $mark_type_id));

            $exam_marks = array(
                'STUDENT_ID' => $STUDENT_ID[$key],
                'SESSION_ID' => $session_id,
                'PROGRAM_ID' => $program_id,
                'COURSE_ID' => $course_id,
                'BATCH_ID' => $batch_id,
                'SECTION_ID' => $section_id,
                'CREATED_BY' => $emp_id,
                'DEPT_ID' => $dept_id,
                'MARKS_TYPE_ID' => $mark_type_id,
                'MARKS' => $this->utilities->percentCalculation($exam_mark[$key], $allocated_marks[$key], $percentage_val),
                'ALLOCATION_MARKS' => $allocated_marks[$key],
                'OBTAIN_MARKS' => $exam_mark[$key],
                'GRACE_MARKS' => $grace_marks[$key],
                'GRACE_MARKS_PER' => $this->utilities->percentCalculation($grace_marks[$key], $allocated_marks[$key], $percentage_val),
                'COURSE_FOR' => $course_for[$key],
                'REMARKS' => $remarks[$key],
                );


            if (empty($check)) {

                $this->utilities->insert('exam_student_marks', $exam_marks);

            } else {

                $exx = $mark_id[$key];

                $this->utilities->updateData('exam_student_marks', $exam_marks, array('EX_MARKS_ID' => $exx, 'REVIEW_STATUS!=' => 1));
            }


        } exit;

    }


    ##################################################################################################
    /*                                       Result                                                */
    ##################################################################################################


    function result()
    {
        $data['contentTitle'] = 'Result';
        $data["breadcrumbs"] = array(
            "Result" => "#",
            "Result Sheet" => '#'
            );

        $data['program'] = $this->utilities->getAll('ins_program');
        $data['section'] = $this->utilities->findAllByAttribute('aca_section', array("ACTIVE_STATUS" => 1));
        $data["session"] = $this->utilities->academicSessionList();

        $data['content_view_page'] = 'admin/setup/exam/result/result_list';
        $this->admin_template->display($data);
    }

    function resultList()
    {
        $program_id = $this->input->post("PROGRAM_ID");
        $session_id = $this->input->post("INS_SESSION_ID");
        $batch_id = $this->input->post("BATCH_ID");
        $section_id = $this->input->post("SECTION_ID");
        $course_id = $this->input->post("COURSE_ID");

        $data['program_id'] = $program_id;
        $data['session_id'] = $session_id;
        $data['batch_id'] = $batch_id;
        $data['section_id'] = $section_id;
        $data['course_id'] = $course_id;
        $data['offer_type'] = 'F';

        $data['student_list'] = $this->db->query("SELECT a.*
          FROM student_personal_info a
          LEFT JOIN student_courseinfo b ON a.STUDENT_ID = b.STUDENT_ID
          WHERE     a.PROGRAM_ID = $program_id
          AND a.SESSION_ID = $session_id
          AND a.BATCH_ID = $batch_id
          AND a.SECTION_ID = $section_id
          AND b.COURSE_ID = $course_id
          AND a.STUDENT_ID IN (SELECT b.STUDENT_ID
          FROM student_semesterinfo b )")->result();

        $data['exam_type'] = $this->db->get_where('exam a', array('a.ACTIVE_STATUS' => 1))->result();

        //echo "<pre>"; print_r($data['student_list']); exit;

        $this->load->view('admin/setup/exam/result/search_result_list', $data);
    }


    function resultPrint($session_id, $program_id, $batch_id, $section_id, $course_id)
    {
        $data['program_id'] = $program_id;
        $data['session_id'] = $session_id;
        $data['batch_id'] = $batch_id;
        $data['section_id'] = $section_id;
        $data['course_id'] = $course_id;

        $data['student_list'] = $this->db->query("SELECT a.*
          FROM student_personal_info a
          LEFT JOIN student_courseinfo b ON a.STUDENT_ID = b.STUDENT_ID
          WHERE     a.PROGRAM_ID = $program_id
          AND a.SESSION_ID = $session_id
          AND a.BATCH_ID = $batch_id
          AND a.SECTION_ID = $section_id
          AND b.COURSE_ID = $course_id
          AND a.STUDENT_ID IN (SELECT b.STUDENT_ID
          FROM student_semesterinfo b )")->result();

        $data['exam_type'] = $this->db->get_where('exam a', array('a.ACTIVE_STATUS' => 1))->result();

        include('mpdf/mpdf.php');
        $mpdf = new mPDF();
        $mpdf->SetTitle('Offered Course');
        $mpdf->mirrorMargins = 1;
        $mpdf->useOnlyCoreFonts = true;
        $report = $this->load->view('admin/setup/exam/result/result_pdf', $data, TRUE);
        //$footer = $this->load->view('admin/course/semester_course_info_footer', $data, TRUE);
        $mpdf->WriteHTML("$report");
        $mpdf->SetHTMLFooter("$footer");
        $mpdf->Output();
        exit;
    }

    ##################################################################################################
    /*                                       Exam Application                                       */
    ##################################################################################################

    /**
     * @methodName examApplication
     * @access
     * @param  none
     * @author Abhijit M. Abhi <abhijit@atilimited.net>
     * @return
     */

    function examApplication()
    {
        $data['contentTitle'] = 'Exam Application';
        $data['breadcrumbs'] = array(
            'Exam Application' => '#',
            'List' => '#',
            );
        $data["previlages"] = $this->checkPrevilege();
        $data['exam_application'] = $this->exam_model->getAllExamApplication();

      //  echo "<pre>"; print_r($data['exam_application']); exit;

        $data['content_view_page'] = 'admin/setup/exam/examApplication/exam_application_index';
        $this->admin_template->display($data);
    }

    /*
   * @methodName examApplicationFormInsert
   * @access
   * @param  none
   * @author Abhijit M. Abhi <abhijit@atilimited.net>
   * @return policy add form
   */

    function examApplicationFormInsert()
    {
        $data["ac_type"] = 1;
        $data["session"] = $this->utilities->academicSessionList();

        //echo "<pre>"; print_r($data["session"]); exit;

        $data['exam_type'] = $this->db->get_where('exam_marks_type', array('ACTIVE_STATUS' => 1))->result();
        $this->load->view('admin/setup/exam/examApplication/add_exam_application', $data);
    }


    /*
   * @methodName createExamApplication
   * @accesss
   * @param  none
   * @author Abhijit M. Abhi <abhijit@atilimited.net>
   * @return
   */

    function createExamApplication()
    {
        $exam_application_Name = $this->input->post('exam_application_Name');
        $ins_session_id = $this->input->post('INS_SESSION_ID');
        $exam_type_id = $this->input->post('EXAM_TYPE_ID');
        $start_date_string = $this->input->post('start_date');
        $end_date_string = $this->input->post('end_date');

        $start_date = date('Y-m-d', strtotime($start_date_string));
        $end_date = date('Y-m-d', strtotime($end_date_string));

        $status = ((isset($_POST['status'])) ? 1 : 0);

        $check = $this->utilities->hasInformationByThisId("exam_application", array("EXAM_APP_TITLE" => $exam_application_Name));
        if (empty($check)) {

            $exam_application = array(
                'EXAM_APP_TITLE' => $exam_application_Name,
                'SESSION_ID' => $ins_session_id,
                'EXAM_ID' => $exam_type_id,
                'START_DT' => $start_date,
                'END_DT' => $end_date,
                'CREATED_BY' => $this->user["USER_ID"],
                'ACTIVE_STATUS' => $status,
                );

            if ($this->utilities->insertData($exam_application, 'exam_application')) {
                // if data inserted successfully
                echo "<div class='alert alert-success'>Exam Application Create successfully</div>";
            } else {
                // if data inserted failed
                echo "<div class='alert alert-danger'>Exam Application Name insert failed</div>";
            }
        } else {
            // if degree name not available
            echo "<div class='alert alert-danger'>Exam Application Name Already Exist</div>";
        }
    }

    /*
   * @methodName examApplicationList
   * @access
   * @param  none
   * @author Abhijit M. Abhi <abhijit@atilimited.net>
   * @return list
   */

    function examApplicationList()
    {
        $data["previlages"] = $this->checkPrevilege("exam/examApplication");
        $data['exam_application'] = $this->exam_model->getAllExamApplication();
        $this->load->view("admin/setup/exam/examApplication/exam_application_list", $data);
    }

    /*
   * @methodName examApplicationFormUpdate
   * @access
   * @param  none
   * @author Abhijit M. Abhi <abhijit@atilimited.net>
   * @return
   */

    function examApplicationFormUpdate()
    {
        $data["ac_type"] = 2;
        $id = $this->input->post('param');
        $data["session"] = $this->utilities->academicSessionList();
        $data['exam_type'] = $this->db->get_where('EXAM_MARKS_TYPE', array('ACTIVE_STATUS' => 1))->result();
        $data['exam_application'] = $this->exam_model->getAllExamApplicationById($id);

        //echo "<pre>"; print_r($data['exam_application']); exit;

        $this->load->view('admin/setup/exam/examApplication/add_exam_application', $data);
    }


    /*
    * @methodName updateExamApplication
    * @access
    * @param  none
    * @author Abhijit M. Abhi <abhijit@atilimited.net>
    * @return
    */

    function updateExamApplication()
    {
        $ex_application_id = $this->input->post('txtexam_applicationId');
        $exam_application_Name = $this->input->post('exam_application_Name');
        $ins_session_id = $this->input->post('INS_SESSION_ID');
        $exam_type_id = $this->input->post('EXAM_TYPE_ID');
        $start_date_string = $this->input->post('start_date');
        $end_date_string = $this->input->post('end_date');

        $status = $this->input->post('status');

        $start_date = date('Y-m-d', strtotime($start_date_string));
        $end_date = date('Y-m-d', strtotime($end_date_string));

        $check = $this->utilities->hasInformationByThisId("exam_application", array("EXAM_APP_TITLE" => $exam_application_Name, "EX_APP_ID !=" => $ex_application_id));

        if (empty($check)) {

            $exam_application = array(
                'EXAM_APP_TITLE' => $exam_application_Name,
                'SESSION_ID' => $ins_session_id,
                'EXAM_ID' => $exam_type_id,
                'START_DT' => $start_date,
                'END_DT' => $end_date,
                'CREATED_BY' => $this->user["USER_ID"],
                'ACTIVE_STATUS' => $status,
                );

            if ($this->utilities->updateData('exam_application', $exam_application, array('EX_APP_ID' => $ex_application_id))) {
                echo "<div class='alert alert-success'>Exam Application Update successfully</div>";
            } else { // if data update failed
                echo "<div class='alert alert-danger'>Exam Application Update failed</div>";
            }
        } else {// if degree name not available
            echo "<div class='alert alert-danger'>Exam Application Name Already Exist</div>";
        }
    }


    /*
    * @methodName examApplicationById
    * @access
    * @param  none
    * @author Abhijit M. Abhi <abhijit@atilimited.net>
    * @return
    */

    function examApplicationById()
    {
        $ex_application_id = $this->input->post('param');
        $data["previlages"] = $this->checkPrevilege("exam/examApplication");
        $data['row'] = $this->exam_model->getAllExamApplicationById($ex_application_id);
        $this->load->view('admin/setup/exam/examApplication/single_exam_application_row', $data);
    }


    ##################################################################################################
    /*                                       Grade Sheet                                     */
    ##################################################################################################

    /**
     * @methodName gradeSheet
     * @access
     * @param  none
     * @author Abhijit M. Abhi <abhijit@atilimited.net>
     * @return
     */

    function gradeSheet()
    {
        $data['contentTitle'] = 'Exam Grade Sheet';
        $data['breadcrumbs'] = array(
            'Exam Grade Sheet' => '#',
            'List' => '#',
            );

        $data['ins_dept'] = $this->utilities->findAllByAttributeWithOrderBy('ins_dept',array('ACTIVE_STATUS' => '1'),'DEPT_NAME','ASC');
         $data['ins_degree'] = $this->utilities->getAll('ins_degree');
        $data['exam_type'] = $this->utilities->findAllByAttribute('exam_type',array('ACTIVE_STATUS'=>1));

        $data["previlages"] = $this->checkPrevilege();

        $data['exam_grade_sheet'] = $this->exam_model->getAllExamGradeSheet();


        $data['content_view_page'] = 'admin/setup/exam/gradeSheet/grade_sheet_index';
        $this->admin_template->display($data);
    }

    /*
      * @methodName gradeSheetFormInsert
      * @access
      * @param  none
      * @author Abhijit M. Abhi <abhijit@atilimited.net>
      * @return p
      */

    function gradeSheetFormInsert()
    {
        $data["ac_type"] = 1;
        $data['ins_dept'] = $this->utilities->findAllByAttributeWithOrderBy('ins_dept',array('ACTIVE_STATUS' => '1'),'DEPT_NAME','ASC');
        $data['ins_degree'] = $this->utilities->getAll('ins_degree');
        $data['exam_type'] = $this->utilities->findAllByAttribute('exam_type',array('ACTIVE_STATUS'=>1));

        //echo "<pre>"; print_r($data["ins_dept"]); exit;

        $data['exam_marks_type'] = $this->utilities->findAllByAttributeWithOrderBy('exam_marks_type',array('ACTIVE_STATUS' => 1),'MARKS_TITLE','ASC');
        $this->load->view('admin/setup/exam/gradeSheet/add_grade_sheet', $data);
    }

    /*
       * @methodName createGradeSheet
       * @accesss
       * @param  none
       * @author Abhijit M. Abhi <abhijit@atilimited.net>
       * @return
       */

    function createGradeSheet()
    {
        $dept_id = $this->input->post('dept_id');
        $marks_type_id = $this->input->post('mark_type');
        $DEGREE_ID = $this->input->post('DEGREE_ID');
        $EXAM_TYPE_ID = $this->input->post('EXAM_TYPE_ID');
        $status = ((isset($_POST['status'])) ? 1 : 0);

        for ($i = 0; $i < sizeof($marks_type_id); $i++) {

            $check = $this->utilities->hasInformationByThisId("exam_grade_sheet", array("DEGREE_ID"=> $DEGREE_ID,"DEPT_ID" => $dept_id,"EXAM_TYPE_ID"=>$EXAM_TYPE_ID,"EXAM_MARKS_TYPE_ID"=>$marks_type_id[$i]));
            if (empty($check)) {
                $gradeSheet = array(
                    'EXAM_MARKS_TYPE_ID' => $marks_type_id[$i],
                    'MARKS_PER' => $this->input->post('MARK_PERCENTAGE_'.$marks_type_id[$i]),
                    'DEPT_ID' => $dept_id,
                    'DEGREE_ID' => $DEGREE_ID,
                    'EXAM_TYPE_ID' => $EXAM_TYPE_ID,
                    'ACTIVE_STATUS' => $status,
                    'CREATED_BY' => $this->user["USER_ID"]
                    );
                //echo "<pre>"; print_r($gradeSheet); exit;
                $this->utilities->insertData($gradeSheet, 'exam_grade_sheet');
            }
        }

        echo "<div class='alert alert-success'>Exam Grade Sheet Created successfully</div>";

    }

    /*
    * @methodName gradeList
    * @access
    * @param  none
    * @author Abhijit M. Abhi <abhijit@atilimited.net>
    * @return list
    */

    function gradeSheetList()
    {
         $data['ins_degree'] = $this->utilities->getAll('ins_degree');
        $data['exam_type'] = $this->utilities->findAllByAttribute('exam_type',array('ACTIVE_STATUS'=>1));
        $data['ins_dept'] = $this->utilities->findAllByAttributeWithOrderBy('ins_dept',array('ACTIVE_STATUS' => 1,'UFOR_ACM'=>1),'DEPT_NAME','ASC');
        $data["previlages"] = $this->checkPrevilege("exam/gradeSheet");
        $data['exam_grade_sheet'] = $this->exam_model->getAllExamGradeSheet();
        $this->load->view("admin/setup/exam/gradeSheet/grade_sheet_list", $data);
    }

     /*
    * @methodName departmentWiseSearch
    * @access
    * @param  none
    * @author Md. Reazul Islam <reazul@atilimited.net>
    * @return list
    */


     function departmentWiseMarksList()
     {
       $data["previlages"] = $this->checkPrevilege("exam/gradeSheet");
       $DEGREE_ID = $this->input->post('DEGREE_ID');
       $depId = $this->input->post('DEP_ID');
       $EXAM_TYPE_ID = $this->input->post('EXAM_TYPE_ID');
       if ($depId!='') {
        $data['depWiseData']= $this->db->query("SELECT a.*,b.EXAM_TITLE,c.MARKS_TITLE,d.DEPT_NAME,e.DEGREE_NAME FROM exam_grade_sheet a
            left join exam_type b on a.EXAM_TYPE_ID = b.EXAM_TYPE_ID
            left join exam_marks_type c on a.EXAM_MARKS_TYPE_ID = c.EXAM_MARKS_TYPE_ID
            left join ins_dept d on a.DEPT_ID = d.DEPT_ID
            left join ins_degree e on a.DEGREE_ID = e.DEGREE_ID
            where a.DEPT_ID= $depId and a.EXAM_TYPE_ID=$EXAM_TYPE_ID and a.DEGREE_ID= $DEGREE_ID ")->result();
         //echo "<pre>";print_r($data['depWiseData']);exit();
        $this->load->view("admin/setup/exam/gradeSheet/depermentWiseSearch",$data);
    }

}

    /*
      * @methodName gradeSheetById
      * @access
      * @param  none
      * @author Abhijit M. Abhi <abhijit@atilimited.net>
      * @return
      */

    function gradeSheetById()
    {
        $grd_sheet_id = $this->input->post('param');
        $data["previlages"] = $this->checkPrevilege("exam/gradeSheet");
        $data['row'] = $this->exam_model->getAllExamGradeSheetById($grd_sheet_id);

        $this->load->view('admin/setup/exam/gradeSheet/single_grade_sheet_row', $data);
    }

    /*
      * @methodName gradeSheetFormUpdate
      * @access
      * @param  none
      * @author Abhijit M. Abhi <abhijit@atilimited.net>
      * @return
     */

    function gradeSheetFormUpdate()
    {
        $data["ac_type"] = 2;
        $id = $this->input->post('param');
        $data['exam_grade_sheet'] = $this->exam_model->getAllExamGradeSheetById($id);

        $data['exam_marks_type'] = $this->db->get_where('EXAM_MARKS_TYPE', array('ACTIVE_STATUS' => 1))->result();

        $data['exam_type'] = $this->utilities->findAllByAttribute('exam_type',array('ACTIVE_STATUS'=>1));

        $data['ins_degree'] = $this->utilities->getAll('ins_degree');
        $data['ins_dept'] = $this->utilities->getAll('ins_dept');
        $this->load->view('admin/setup/exam/gradeSheet/grade_sheet_edit', $data);
    }

    /*
     * @methodName updateGradeSheet
     * @access
     * @param  none
     * @author Abhijit M. Abhi <abhijit@atilimited.net>
     * @return
     */

    function updateGradeSheet()
    {
        $grd_sheet_id = $this->input->post('txtexam_gradeId');
        $dept_id = $this->input->post('dept_id');
        $DEGREE_ID = $this->input->post('DEGREE_ID');
        $EXAM_TYPE_ID = $this->input->post('EXAM_TYPE_ID');
        $EXAM_TYPE_ID = $this->input->post('EXAM_TYPE_ID');
        $exam_marks_title = $this->input->post('exam_marks_type');
        $exam_marks_percentage = $this->input->post('exam_marks_percentage');
        $status = $this->input->post('status');

        $gradeSheet = array(
            'EXAM_MARKS_TYPE_ID' => $exam_marks_title,
            'MARKS_PER' => $exam_marks_percentage,
            'DEGREE_ID' => $DEGREE_ID,
            'DEPT_ID' => $dept_id,
            'EXAM_TYPE_ID' => $EXAM_TYPE_ID,
            'ACTIVE_STATUS' => $status,
            'CREATED_BY' => $this->user["USER_ID"]
            );

        if ($this->utilities->updateData('exam_grade_sheet', $gradeSheet, array('EXAM_GRADE_SHEET_ID' => $grd_sheet_id))) {
            echo "<div class='alert alert-success'>Exam Grade Sheet Update successfully</div>";
        } else { // if data update failed
            echo "<div class='alert alert-danger'>Exam Grade Sheet Update failed</div>";
        }

    }

    function gradeSheetIndex()
    {
        $data['contentTitle'] = 'Grade Sheet';
        $data['breadcrumbs'] = array(
            'Result' => '#',
            'Grade Sheet' => '#',
            );
        $data['exam_grade'] = $this->exam_model->getAllExamSetup();
        $data['aca_ses_list'] = $this->utilities->academicSessionList();
        $data["section"] = $this->utilities->findAllByAttribute("aca_section", array('ACTIVE_STATUS' => 1));
        $data["faculty"] = $this->utilities->findAllByAttribute("ins_faculty", array('ACTIVE_STATUS' => 1));
        $data['content_view_page'] = 'admin/setup/exam/grading/result_grade_sheet_index';
        $this->admin_template->display($data);
    }


    function resultGradeSheet()
    {


        $FACULTY_ID = $this->input->post('FACULTY_ID');
        $DEPT_ID = $this->input->post('DEPT_ID');
        $PROGRAM_ID = $this->input->post('PROGRAM_ID');
        $BATCH_ID = $this->input->post('BATCH_ID');
        $SECTION_ID = $this->input->post('SECTION_ID');
        $SESSION_ID = $this->input->post('SESSION_ID');
        $COURSE_ID = $this->input->post('COURSE_ID');
        $TEACHER_ID = $this->input->post('TEACHER_ID');

        $data['ins_faculty'] = $this->utilities->findByAttribute('ins_faculty', array('FACULTY_ID' => $FACULTY_ID));

        $data['ins_dept'] = $this->utilities->findByAttribute('ins_dept', array('DEPT_ID' => $DEPT_ID));
        $data['ins_program'] = $this->utilities->findByAttribute('ins_program', array('PROGRAM_ID' => $PROGRAM_ID));
        $data['aca_batch'] = $this->utilities->findByAttribute('aca_batch', array('BATCH_ID' => $BATCH_ID));
        $data['aca_section'] = $this->utilities->findByAttribute('aca_section', array('SECTION_ID' => $SECTION_ID));
        $data['aca_course'] = $this->utilities->findByAttribute('aca_course', array('COURSE_ID' => $COURSE_ID));
        $data['employe'] = $this->utilities->findByAttribute('hr_emp', array('EMP_ID' => $TEACHER_ID));

        $data['session'] = $this->utilities->academicSessionById($SESSION_ID);

        $data['exam_grade'] = $this->exam_model->getAllExamSetup();

        $data['exam_grade_sheet'] = $this->exam_model->getExamGradeSheet($DEPT_ID);

        $data['course_student'] = $this->exam_model->getCourseStudent($PROGRAM_ID, $BATCH_ID, $SECTION_ID, $SESSION_ID, $COURSE_ID);
          //  exit;
        // echo "<pre>";print_r($data['course_student'] );exit;
        $this->load->view('admin/setup/exam/grading/result_grade_sheet', $data);

    }

    /*
    * @methodName reviewGradeSheetIndex
    * @access
    * @param  none
    * @author Abhijit M. Abhi <abhijit@atilimited.net>
    * @return
    */

    function reviewGradeSheetIndex()
    {
        $data['contentTitle'] = 'Grade Sheet';
        $data['breadcrumbs'] = array(
            'Result' => '#',
            'Grade Sheet' => '#',
            );
        $data['exam_grade'] = $this->exam_model->getAllExamSetup();
        $data['aca_ses_list'] = $this->utilities->academicSessionList();
        $data["section"] = $this->utilities->findAllByAttribute("aca_section", array('ACTIVE_STATUS' => 1));
        $data["faculty"] = $this->utilities->findAllByAttribute("ins_faculty", array('ACTIVE_STATUS' => 1));
        $data['content_view_page'] = 'admin/setup/exam/grading/review_result_grade_sheet_index';
        $this->admin_template->display($data);
    }

    /*
    * @methodName reviewResultGradeSheet
    * @access
    * @param  none
    * @author Abhijit M. Abhi <abhijit@atilimited.net>
    * @return
    */


    function reviewResultGradeSheet()
    {

        $FACULTY_ID = $this->input->post('FACULTY_ID');
        $DEPT_ID = $this->input->post('DEPT_ID');
        $PROGRAM_ID = $this->input->post('PROGRAM_ID');
        $BATCH_ID = $this->input->post('BATCH_ID');
        $SECTION_ID = $this->input->post('SECTION_ID');
        $SESSION_ID = $this->input->post('SESSION_ID');
        $COURSE_ID = $this->input->post('COURSE_ID');
        $TEACHER_ID = $this->input->post('TEACHER_ID');

        $data['SESSION_ID'] = $SESSION_ID;
        $data['DEPT_ID'] = $DEPT_ID;
        $data['PROGRAM_ID'] = $PROGRAM_ID;
        $data['BATCH_ID'] = $BATCH_ID;
        $data['SECTION_ID'] = $SECTION_ID;
        $data['COURSE_ID'] = $COURSE_ID;

        $data['FACULTY_ID'] = $FACULTY_ID;
        $data['TEACHER_ID'] = $TEACHER_ID;


        $data['ins_faculty'] = $this->utilities->findByAttribute('ins_faculty', array('FACULTY_ID' => $FACULTY_ID));
        $data['ins_dept'] = $this->utilities->findByAttribute('ins_dept', array('DEPT_ID' => $DEPT_ID));
        $data['ins_program'] = $this->utilities->findByAttribute('ins_program', array('PROGRAM_ID' => $PROGRAM_ID));
        $data['aca_batch'] = $this->utilities->findByAttribute('aca_batch', array('BATCH_ID' => $BATCH_ID));
        $data['aca_section'] = $this->utilities->findByAttribute('aca_section', array('SECTION_ID' => $SECTION_ID));
        $data['aca_course'] = $this->utilities->findByAttribute('aca_course', array('COURSE_ID' => $COURSE_ID));
        $data['employe'] = $this->utilities->findByAttribute('hr_emp', array('EMP_ID' => $TEACHER_ID));
        $data['session'] = $this->utilities->academicSessionById($SESSION_ID);

        //echo "<pre>"; print_r($SESSION_ID); exit;

        $data['exam_grade'] = $this->exam_model->getAllExamSetup();
        $data['exam_grade_sheet'] = $this->exam_model->getExamGradeSheet($DEPT_ID);
        $data['course_student'] = $this->exam_model->getCourseStudent($PROGRAM_ID, $BATCH_ID, $SECTION_ID, $SESSION_ID, $COURSE_ID);
        //echo "<pre>";print_r($data['course_student'] );exit;
        $this->load->view('admin/setup/exam/grading/review_result_grade_sheet', $data);

    }

    /*
   * @methodName reviewMarkFormUpdate
   * @access
   * @param  none
   * @author Abhijit M. Abhi <abhijit@atilimited.net>
   * @return
   */

    function reviewMarkFormUpdate()
    {
        $data["ac_type"] = 2;
        $student_id = $this->input->post('stu_id');
        $session_id = $this->input->post('session_id');
        $dept_id = $this->input->post('dept_id');
        $program_id = $this->input->post('program_id');
        $batch_id = $this->input->post('batch_id');
        $section_id = $this->input->post('section_id');
        $course_id = $this->input->post('course_id');
        $faculty_id = $this->input->post('faculty_id');
        $teacher_id = $this->input->post('teacher_id');

        $data['session_id'] = $session_id;
        $data['dept_id'] = $dept_id;
        $data['program_id'] = $program_id;
        $data['batch_id'] = $batch_id;
        $data['section_id'] = $section_id;
        $data['course_id'] = $course_id;
        $data['faculty_id'] = $faculty_id;
        $data['teacher_id'] = $teacher_id;

        $data['student_info'] = $this->utilities->findByAttribute('student_personal_info', array('STUDENT_ID' => $student_id));

        //echo "<pre>"; print_r($data['student_info']); exit;

        $data['stu_mark_info'] = $this->db->query("SELECT
         a.*,  b.*
         ,(select
         c.MARKS_PER
         from
         exam_grade_sheet c
         where
         c.DEPT_ID = 1 and
         c.EXAM_MARKS_TYPE_ID = b.EXAM_MARKS_TYPE_ID)
         as MARKS_PER FROM exam_student_marks a
         LEFT JOIN exam_marks_type b ON a.MARKS_TYPE_ID = b.EXAM_MARKS_TYPE_ID

         WHERE a.STUDENT_ID = $student_id
         AND a.SESSION_ID = $session_id
         AND a.COURSE_ID = $course_id")->result();

        //echo "<pre>"; print_r($data['stu_mark_info']); exit;

        $this->load->view('admin/setup/exam/grading/review_grade_edit', $data);
    }

    /*
      * @methodName updateReviewGrade
      * @access
      * @param  none
      * @author Abhijit M. Abhi <abhijit@atilimited.net>
      * @return
      */

    function updateReviewGrade()
    {

        $stu_id = $this->input->post('STU_ID');
        $ex_marks_id = $this->input->post('EX_MARKS_ID');
        $mark_type_id = $this->input->post('MARK_TYPE_ID');
        $exam_mark = $this->input->post('EXAM_MARK');

        $allocation_marks = $this->input->post('ALLOCATION_MARKS');
        $obtain_marks = $this->input->post('OBTAIN_MARKS');
        $grace_marks = $this->input->post('GRACE_MARKS');
        $marks_per = $this->input->post('MARKS_PER');
//         print_r($mark_type_id); exit;
        $update = false;

        for ($i = 0; $i < sizeof($mark_type_id); $i++) {
            //echo $obtain_marks[$i].'-' .$allocation_marks[$i].'-'. $marks_per[$i]; exit;
            // echo $this->utilities->percentCalculation($obtain_marks[$i], $allocation_marks[$i], $marks_per[$i]); exit;
            $gradeSheet = array(
                'MARKS' => $this->utilities->percentCalculation($obtain_marks[$i], $allocation_marks[$i], $marks_per[$i]),
                'GRACE_MARKS_PER' => $this->utilities->percentCalculation($grace_marks[$i], $allocation_marks[$i], $marks_per[$i]),
                'OBTAIN_MARKS' => $obtain_marks[$i],
                'GRACE_MARKS' => $grace_marks[$i],
                'CREATED_BY' => $this->user["USER_ID"],

                );

//            echo "<pre>"; print_r($gradeSheet); exit;

            if ($this->utilities->updateData('exam_student_marks', $gradeSheet, array('STUDENT_ID' => $stu_id, 'EX_MARKS_ID' => $ex_marks_id[$i]))) {
                $update = true;
            }
        }

        if ($update == true) {
            echo "<div class='alert alert-success'>Updated Successfully</div>";
            $this->session->set_flashdata('msg', 'Room added');
        }
    }

    /*
     * @methodName gradeSheetReview
     * @access
     * @param  none
     * @author Abhijit M. Abhi <abhijit@atilimited.net>
     * @return
     */

    function gradeSheetReview()
    {
        $data["ac_type"] = 2;
        $student_id = $this->input->post('stu_id');
        $session_id = $this->input->post('session_id');
        $dept_id = $this->input->post('dept_id');
        $program_id = $this->input->post('program_id');
        $batch_id = $this->input->post('batch_id');
        $section_id = $this->input->post('section_id');
        $course_id = $this->input->post('course_id');
        $faculty_id = $this->input->post('faculty_id');
        $teacher_id = $this->input->post('teacher_id');

        $total_mark = $this->input->post('total_mark');
        $grade_point = $this->input->post('grade_point');
        $grade_letter = $this->input->post('grade_letter');

        $ex_marks_id = $this->input->post('ex_marks_id');

        $total_obtain_per = $this->input->post('total_obtain_per');
        $total_grace_per = $this->input->post('total_grace_per');

        $data['session_id'] = $session_id;
        $data['dept_id'] = $dept_id;
        $data['program_id'] = $program_id;
        $data['batch_id'] = $batch_id;
        $data['section_id'] = $section_id;
        $data['course_id'] = $course_id;
        $data['faculty_id'] = $faculty_id;
        $data['teacher_id'] = $teacher_id;

        $data['total_mark'] = $total_mark;
        $data['grade_point'] = $grade_point;
        $data['grade_letter'] = $grade_letter;
        $data['ex_marks_id'] = $ex_marks_id;

        $data['total_obtain_per'] = $total_obtain_per;
        $data['total_grace_per'] = $total_grace_per;

        //echo $point_secured; exit;

        //echo "<pre>"; print_r($course_info); exit;

        $data['student_info'] = $this->utilities->findByAttribute('student_personal_info', array('STUDENT_ID' => $student_id));


        $this->load->view('admin/setup/exam/grading/review_grade_remark', $data);
    }

    /*
    * @methodName gradeSheetReviewInsert
    * @access
    * @param  none
    * @author Abhijit M. Abhi <abhijit@atilimited.net>
    * @return
    */

    function gradeSheetReviewInsert()
    {
        $student_id = $this->input->post('STU_ID');
        $session_id = $this->input->post('SESSION_ID');
        $dept_id = $this->input->post('DEPT_ID');
        $program_id = $this->input->post('PROGRAM_ID');
        $batch_id = $this->input->post('BATCH_ID');
        $section_id = $this->input->post('SECTION_ID');
        $course_id = $this->input->post('COURSE_ID');
        $faculty_id = $this->input->post('FACULTY_ID');
        $teacher_id = $this->input->post('TEACHER_ID');

        $grade_point = $this->input->post('GRADE_POINT');
        $grade_letter = $this->input->post('GRADE_LETTER');

        $ex_marks_id = $this->input->post('EX_MARKS_ID');
        $remark = $this->input->post('REMARK');

        $total_marks = $this->input->post('MARKS');
        $total_grace_marks = $this->input->post('TOTAL_GRACE_MARKS');

//        echo $total_marks; exit;

        $user_id = $this->user["USER_ID"];

        $course_info = $this->db->query("SELECT * FROM exam_student_marks a
          LEFT JOIN aca_course b ON a.COURSE_ID = b.COURSE_ID
          WHERE a.EX_MARKS_ID = $ex_marks_id")->row();

        $credit_earned = $course_info->CREDIT;

        $point_secured = $grade_point * $credit_earned;

        $tabulation_sheet = array(

            'COURSE_ID' => $course_id,
            'MARKS' => $total_marks,
            'TOTAL_GRACE_MARKS' => $total_grace_marks,
            'GRADE_POINT' => $grade_point,
            'GRADE_LETTER' => $grade_letter,
            'CREDIT_EARNED' => $credit_earned,
            'POINTS_SEQURED' => $point_secured,
            'COURSE_FOR' => $course_info->COURSE_FOR,
            'STUDENT_ID' => $student_id,
            'SESSION_ID' => $session_id,
            'FACULTY_ID' => $faculty_id,
            'DEPT_ID' => $dept_id,
            'PROGRAM_ID' => $program_id,
            'BATCH_ID' => $batch_id,
            'SECTION_ID' => $section_id,
            'REMARKS' => $remark,
            );

        //echo "<pre>"; print_r($tabulation_sheet); exit;
        $this->utilities->insertData($tabulation_sheet, 'exam_tabulation_sheet');

        $review_info = array(
            'REVIEW_STATUS' => 1,
            'REVIEW_BY' => $this->user["USER_ID"],
            );


        $this->db->query("UPDATE exam_student_marks SET REVIEW_STATUS=1, REVIEW_BY= '$user_id' WHERE
           STUDENT_ID = $student_id AND COURSE_ID = $course_id AND SESSION_ID = $session_id ");


    }

    #################################### Academic Transcript ###########################################################


    /*
    * @methodName academicTranscriptIndex
    * @access
    * @param  none
    * @author Abhijit M. Abhi <abhijit@atilimited.net>
    * @return
    */

    function academicTranscriptIndex()
    {
        $data['contentTitle'] = 'Academic Transcript';
        $data['breadcrumbs'] = array(
            'Result' => '#',
            'Academic Transcript' => '#',
            );

        $data['exam_grade'] = $this->exam_model->getAllExamSetup();
        $data['aca_ses_list'] = $this->utilities->academicSessionList();
        $data["section"] = $this->utilities->findAllByAttribute("aca_section", array('ACTIVE_STATUS' => 1));
        $data["faculty"] = $this->utilities->findAllByAttribute("ins_faculty", array('ACTIVE_STATUS' => 1));
        $data['content_view_page'] = 'admin/setup/exam/grading/academic_transcript_index';
        $this->admin_template->display($data);
    }

    /*
   * @methodName studentListByThisAttribute
   * @access
   * @param  none
   * @author Abhijit M. Abhi <abhijit@atilimited.net>
   * @return
   */

    function studentListByThisAttribute()
    {
        $session_id = $_POST['SESSION_ID'];
        $faculty_id = $_POST['FACULTY_ID'];
        $dept_id = $_POST['DEPT_ID'];
        $program_id = $_POST['PROGRAM_ID'];
        $batch_id = $_POST['BATCH_ID'];
        $section_id = $_POST['SECTION_ID'];

        $data['SESSION_ID'] = $session_id;
        $data['FACULTY_ID'] = $faculty_id;
        $data['DEPT_ID'] = $dept_id;
        $data['PROGRAM_ID'] = $program_id;
        $data['BATCH_ID'] = $batch_id;
        $data['SECTION_ID'] = $section_id;


        //data['student_list'] = $this->db->get_where('student_personal_info a', array('a.FACULTY_ID' => $faculty_id, 'a.DEPT_ID' => $dept_id, 'a.PROGRAM_ID' => $program_id, 'a.BATCH_ID' => $batch_id, 'a.SECTION_ID' => $section_id))->result();
        $data['student_list']=$this->db->query("   SELECT * FROM student_personal_info a
   where a.FACULTY_ID=$faculty_id
   AND a.DEPT_ID=$dept_id
   AND a.PROGRAM_ID=$program_id
   AND  a.BATCH_ID=$batch_id
   and A.SECTION_ID=$section_id"
          )->result();

//        echo "<pre>"; print_r($data['student_list']); exit;

        $this->load->view('admin/setup/exam/grading/academic_transcript_student_list', $data);
    }

    /*
      * @methodName academicTranscript
      * @access
      * @param  none
      * @author Abhijit M. Abhi <abhijit@atilimited.net>
      * @return
      */

    function academicTranscript()
    {
        $SESSION_ID = $this->uri->segment(3);
        $FACULTY_ID = $this->uri->segment(4);
        $DEPT_ID = $this->uri->segment(5);
        $PROGRAM_ID = $this->uri->segment(6);
        $BATCH_ID = $this->uri->segment(7);
        $SECTION_ID = $this->uri->segment(8);
        $STUDENT_ID = $this->uri->segment(9);
        $data['SESSION_ID'] = $SESSION_ID;
        $data['DEPT_ID'] = $DEPT_ID;
        $data['PROGRAM_ID'] = $PROGRAM_ID;
        $data['BATCH_ID'] = $BATCH_ID;
        $data['SECTION_ID'] = $SECTION_ID;
        $data['FACULTY_ID'] = $FACULTY_ID;
        $data['STUDENT_ID'] = $STUDENT_ID;
        $data['ins_faculty'] = $this->utilities->findByAttribute('ins_faculty', array('FACULTY_ID' => $FACULTY_ID));
        $data['ins_dept'] = $this->utilities->findByAttribute('ins_dept', array('DEPT_ID' => $DEPT_ID));
        $data['ins_program'] = $this->utilities->findByAttribute('ins_program', array('PROGRAM_ID' => $PROGRAM_ID));
        $data['aca_batch'] = $this->utilities->findByAttribute('aca_batch', array('BATCH_ID' => $BATCH_ID));
        $data['aca_section'] = $this->utilities->findByAttribute('aca_section', array('SECTION_ID' => $SECTION_ID));
        $data['session'] = $this->utilities->academicSessionById($SESSION_ID);
        $data['exam_grade'] = $this->exam_model->getAllExamSetup();
        $data['exam_grade_sheet'] = $this->exam_model->getExamGradeSheet($DEPT_ID);
        $data['student_info'] = $this->student_model->getStudentInfoAll($STUDENT_ID);
        $data['count_row'] = $this->exam_model->countRowWithData($STUDENT_ID);
      // $data['batch'] = $this->db->get_where('aca_batch a', array('a.BATCH_ID' => $BATCH_ID))->row();

        $data['batch']=$this->db->query("SELECT * FROM aca_batch  WHERE BATCH_ID=$BATCH_ID")->row();

        //echo "<pre>"; print_r($user_session); exit;
        $orgId=$this->getOrganizationId();
      //  exit;
        $data['orgInfo']=$this->db->query("SELECT * FROM sa_organizations WHERE ORG_ID=$orgId")->row();
          //echo "<pre>"; print_r($data['orgInfo']); exit;
        $data['content_view_page'] = 'admin/setup/exam/grading/academic_transcript';
        $this->admin_template->display($data);
    }
    public function getOrganizationId()
    {
      $user_session = $this->user = $this->session->userdata("logged_in");
      $orgid=$user_session['ORG_ID'];
      return $orgid;
    }
    ###################################### Previous Student Marks Entry ################################################

    /*
     * @methodName previousMarksIndex
     * @access
     * @param  none
     * @author Abhijit M. Abhi <abhijit@atilimited.net>
     * @return
     */

    function previousMarksIndex()
    {
        $data['contentTitle'] = 'Previous Marks Entry';
        $data['breadcrumbs'] = array(
            'Marks' => '#',
            'Previous Marks Entry' => '#',
            );

        $data['exam_grade'] = $this->exam_model->getAllExamSetup();
        $data["ins_session"] = $this->utilities->academicSessionList();
        $data["section"] = $this->utilities->findAllByAttribute("aca_section", array('ACTIVE_STATUS' => 1));
        $data["faculty"] = $this->utilities->findAllByAttribute("ins_faculty", array('ACTIVE_STATUS' => 1));
        $data['content_view_page'] = 'admin/setup/exam/previousMarksEntry/previous_marks_entry_index';
        $this->admin_template->display($data);
    }

    /*
 * @methodName existingStudentList
 * @access
 * @param  none
 * @author Abhijit M. Abhi <abhijit@atilimited.net>
 * @return
 */

    function existingStudentList()
    {
        $session_id = $_POST['SESSION_ID'];
        $faculty_id = $_POST['FACULTY_ID'];
        $dept_id = $_POST['DEPT_ID'];
        $program_id = $_POST['PROGRAM_ID'];
        $course_id = $_POST['COURSE_ID'];
        $batch_id = $_POST['BATCH_ID'];
        $section_id = $_POST['SECTION_ID'];

        $data['SESSION_ID'] = $session_id;
        $data['FACULTY_ID'] = $faculty_id;
        $data['DEPT_ID'] = $dept_id;
        $data['PROGRAM_ID'] = $program_id;
        $data['COURSE_ID'] = $course_id;
        $data['BATCH_ID'] = $batch_id;
        $data['SECTION_ID'] = $section_id;

        $data["ins_session"] = $this->utilities->academicSessionList();

//        $data['existing_student_list'] = $this->db->get_where('student_personal_info a',
//            array('a.FACULTY_ID' => $faculty_id, 'a.DEPT_ID' => $dept_id,
//                'a.PROGRAM_ID' => $program_id, 'a.BATCH_ID' => $batch_id,
//                'a.SECTION_ID' => $section_id, 'a.PREVIOUS_STU_FG' => 1,
//                 ))->result();

        $data['existing_student_list'] = $this->db->query("SELECT * FROM student_personal_info a
            WHERE a.FACULTY_ID = $faculty_id
            AND a.DEPT_ID = $dept_id
            AND a.PROGRAM_ID = $program_id
            AND a.SECTION_ID = $section_id
            AND a.BATCH_ID = $batch_id
            AND a.PREVIOUS_STU_FG = 1
            ")->result();


        //echo "<pre>"; print_r($data['existing_student_list']); exit;

        $this->load->view('admin/setup/exam/previousMarksEntry/existing_student_list', $data);
    }


    /*
  * @methodName existingStudentSession
  * @access
  * @param  none
  * @author Abhijit M. Abhi <abhijit@atilimited.net>
  * @return
  */

    function existingStudentSession()
    {
        $faculty_id = $_POST['FACULTY_ID'];
        $dept_id = $_POST['DEPT_ID'];
        $program_id = $_POST['PROGRAM_ID'];
//        $course_id = $_POST['COURSE_ID'];
        $batch_id = $_POST['BATCH_ID'];
        $section_id = $_POST['SECTION_ID'];

        $data['FACULTY_ID'] = $faculty_id;
        $data['DEPT_ID'] = $dept_id;
        $data['PROGRAM_ID'] = $program_id;
//        $data['COURSE_ID'] = $course_id;
        $data['BATCH_ID'] = $batch_id;
        $data['SECTION_ID'] = $section_id;

        //echo $batch_id; exit;

        $data["ins_session"] = $this->utilities->academicSessionList();

        $data['existing_student_list'] = $this->db->query("SELECT * FROM student_personal_info a
            WHERE a.FACULTY_ID = $faculty_id
            AND a.DEPT_ID = $dept_id
            AND a.PROGRAM_ID = $program_id
            AND a.SECTION_ID = $section_id
            AND a.BATCH_ID = $batch_id
            AND a.PREVIOUS_STU_FG = 1
            ")->result();


//        echo "<pre>"; print_r($data['existing_student_list']); exit;

        $this->load->view('admin/setup/exam/previousMarksEntry/previous_marks_entry_list', $data);
    }

    /*
     * @methodName calculateGradeLetter
     * @access
     * @param  none
     * @author Abhijit M. Abhi <abhijit@atilimited.net>
     * @return
     */

    function calculateGradeLetter()
    {
        $mark = $this->input->post('mark');
        $final_mark = $this->exam_model->gradePointLetter($mark);

        echo json_encode($final_mark);
    }

    /*
    * @methodName existingStudentMarksInsert
    * @access
    * @param  none
    * @author Abhijit M. Abhi <abhijit@atilimited.net>
    * @return
    */

    function existingStudentMarksInsert()
    {
        $session_id = $this->input->post('SESSION_ID');
        $faculty_id = $this->input->post('FACULTY_ID');
        $program_id = $this->input->post('PROGRAM_ID');
        $course_id = $this->input->post('COURSE_ID');
        $batch_id = $this->input->post('BATCH_ID');
        $section_id = $this->input->post('SECTION_ID');
        $dept_id = $this->input->post('DEPT_ID');
        $course_for = $this->input->post('COURSE_FOR');

        $STUDENT_ID = $this->input->post('STU_ID');
        $mark = $this->input->post('MARK');
        $ex_tabulation_sheet_id = $this->input->post('EX_TABULATION_SHEET_ID');

        foreach ($STUDENT_ID as $key => $value) {


            // Skips Marks Entry if Mark not given
            if (empty($mark[$key])) {
                continue;
            }

            $check = $this->utilities->hasInformationByThisId("exam_tabulation_sheet", array("STUDENT_ID" => $STUDENT_ID[$key], "COURSE_ID" => $course_id, "SESSION_ID" => $session_id));

            $final_mark = $this->exam_model->gradePointLetter($mark[$key]);

            $course_info = $this->db->get_where('aca_course a', array('a.COURSE_ID' => $course_id))->row();

            $point_secured = round($final_mark->GRADE_POINT * $course_info->CREDIT, 2);

            if (empty($check)) {

                $exam_marks = array(
                    'STUDENT_ID' => $STUDENT_ID[$key],
                    'SESSION_ID' => $session_id,
                    'FACULTY_ID' => $faculty_id,
                    'PROGRAM_ID' => $program_id,
                    'COURSE_ID' => $course_id,
                    'BATCH_ID' => $batch_id,
                    'SECTION_ID' => $section_id,
                    'CREATED_BY' => '',
                    'DEPT_ID' => $dept_id,
                    'MARKS' => $mark[$key],
                    'CREDIT_EARNED' => $course_info->CREDIT,
                    'GRADE_POINT' => $final_mark->GRADE_POINT,
                    'GRADE_LETTER' => $final_mark->GR_LETTER,
                    'POINTS_SEQURED' => $point_secured,
                    'COURSE_FOR' => $course_for[$key],
                    'REMARKS' => '',
                    );

                //echo "<pre>"; print_r($exam_marks); exit;

                $this->utilities->insert('exam_tabulation_sheet', $exam_marks);

            } else {

                $exx = $ex_tabulation_sheet_id[$key];

                $exam_marks = array(
                    'STUDENT_ID' => $STUDENT_ID[$key],
                    'SESSION_ID' => $session_id,
                    'FACULTY_ID' => $faculty_id,
                    'PROGRAM_ID' => $program_id,
                    'COURSE_ID' => $course_id,
                    'BATCH_ID' => $batch_id,
                    'SECTION_ID' => $section_id,
                    'CREATED_BY' => '',
                    'DEPT_ID' => $dept_id,
                    'MARKS' => $mark[$key],
                    'CREDIT_EARNED' => $course_info->CREDIT,
                    'GRADE_POINT' => $final_mark->GRADE_POINT,
                    'GRADE_LETTER' => $final_mark->GR_LETTER,
                    'POINTS_SEQURED' => $point_secured,
                    'COURSE_FOR' => $course_for[$key],
                    'REMARKS' => '',
                    );

//                echo "<pre>"; print_r($exam_marks); exit;

                $this->utilities->updateData('exam_tabulation_sheet', $exam_marks, array('EX_TABULATION_SHEET_ID' => $exx));
            }


        }

    }

    ######################################### Partial Academic Transcript ##############################################

    /*
    * @methodName partialAcademicTranscript
    * @access
    * @param  none
    * @author Abhijit M. Abhi <abhijit@atilimited.net>
    * @return
    */

    function partialAcademicTranscript()
    {
        $SESSION_ID = $this->uri->segment(3);
        $FACULTY_ID = $this->uri->segment(4);
        $DEPT_ID = $this->uri->segment(5);
        $PROGRAM_ID = $this->uri->segment(6);
        $BATCH_ID = $this->uri->segment(7);
        $SECTION_ID = $this->uri->segment(8);
        $STUDENT_ID = $this->uri->segment(9);

        $data['SESSION_ID'] = $SESSION_ID;
        $data['DEPT_ID'] = $DEPT_ID;
        $data['PROGRAM_ID'] = $PROGRAM_ID;
        $data['BATCH_ID'] = $BATCH_ID;
        $data['SECTION_ID'] = $SECTION_ID;

        $data['FACULTY_ID'] = $FACULTY_ID;
        $data['STUDENT_ID'] = $STUDENT_ID;

        $data['ins_faculty'] = $this->utilities->findByAttribute('ins_faculty', array('FACULTY_ID' => $FACULTY_ID));
        $data['ins_dept'] = $this->utilities->findByAttribute('ins_dept', array('DEPT_ID' => $DEPT_ID));
        $data['ins_program'] = $this->utilities->findByAttribute('ins_program', array('PROGRAM_ID' => $PROGRAM_ID));
        $data['aca_batch'] = $this->utilities->findByAttribute('aca_batch', array('BATCH_ID' => $BATCH_ID));
        $data['aca_section'] = $this->utilities->findByAttribute('aca_section', array('SECTION_ID' => $SECTION_ID));

        $data['session'] = $this->utilities->academicSessionById($SESSION_ID);

        $data['exam_grade'] = $this->exam_model->getAllExamSetup();
        $data['exam_grade_sheet'] = $this->exam_model->getExamGradeSheet($DEPT_ID);
        $data['student_info'] = $this->student_model->getStudentInfoAll($STUDENT_ID);
        $data['count_row'] = $this->exam_model->countRowWithData($STUDENT_ID);

        $data['batch'] = $this->db->get_where('aca_batch', array('BATCH_ID' => $BATCH_ID))->row();

        //echo "<pre>"; print_r($data['count_row']); exit;
        $orgId=$this->getOrganizationId();
          $data['orgInfo']=$this->db->query("SELECT * FROM sa_organizations WHERE ORG_ID=$orgId")->row();
        $data['content_view_page'] = 'admin/setup/exam/grading/partial_academic_transcript';
        $this->admin_template->display($data);

    }

    ############################################### Final Exam Transcript ##############################################

    /*
     * @methodName finalExamTranscriptIndex
     * @access
     * @param  none
     * @author Abhijit M. Abhi <abhijit@atilimited.net>
     * @return
     */

    function finalExamTranscriptIndex()
    {
        $data['contentTitle'] = 'Final Exam Transcript';
        $data['breadcrumbs'] = array(
            'Exam' => '#',
            'Final Exam Transcript' => '#',
            );

        $data['exam_grade'] = $this->exam_model->getAllExamSetup();
        $data["ins_session"] = $this->utilities->academicSessionList();
        $data["section"] = $this->utilities->findAllByAttribute("aca_section", array('ACTIVE_STATUS' => 1));
        $data["faculty"] = $this->utilities->findAllByAttribute("ins_faculty", array('ACTIVE_STATUS' => 1));
        $data['content_view_page'] = 'admin/setup/exam/finalExamTranscript/final_exam_transcript_index';
        $this->admin_template->display($data);
    }

    /*
    * @methodName finalExamTranscriptStudentList
    * @access
    * @param  none
    * @author Abhijit M. Abhi <abhijit@atilimited.net>
    * @return
    */

    function finalExamTranscriptStudentList()
    {
        $session_id = $_POST['SESSION_ID'];
        $data['SESSION_ID'] = $session_id;
        $data['academic_session'] = $this->utilities->academicSessionById($session_id);
      //  $data['student_list'] = $this->exam_model->getRetakeImprovementStudentList($session_id);
      $data['student_list']=$this->db->query("  SELECT * FROM (SELECT a.STUDENT_ID,
                                               f.SESSION_NAME || ' ' ||  e.DINYEAR ADM_SESSION_NAME,
                                               c.DEPT_NAME,
                                               d.BATCH_ID,
                                               f.SESSION_ID,
                                               b.REGISTRATION_NO,
                                               b.FULL_NAME_EN,
                                               c.DEPT_ABBR,
                                               d.BATCH_TITLE
                                          FROM exam_tabulation_sheet a
                                               LEFT JOIN student_personal_info b
                                                  ON a.STUDENT_ID = b.STUDENT_ID
                                               LEFT JOIN ins_dept c
                                                  ON b.DEPT_ID = c.DEPT_ID
                                               LEFT JOIN aca_batch d
                                                  ON b.BATCH_ID = d.BATCH_ID
                                               LEFT JOIN adm_ysession e
                                                  ON b.ADM_SESSION_ID = e.YSESSION_ID
                                               LEFT JOIN ins_session f
                                                  ON e.SESSION_ID = f.SESSION_ID
                                         WHERE     a.COURSE_FOR IN ('R', 'I','F')
                                               AND a.SESSION_ID = '$session_id'
                                              AND b.SESSION_ID = '$session_id'
                                      ORDER BY a.STUDENT_ID ASC) k GROUP BY  STUDENT_ID,ADM_SESSION_NAME,DEPT_NAME,BATCH_ID,SESSION_ID,REGISTRATION_NO,FULL_NAME_EN,DEPT_ABBR,BATCH_TITLE")->result();

        $this->load->view('admin/setup/exam/finalExamTranscript/final_exam_transcript_list', $data);
    }

    /*
     * @methodName examEligibility
     * @access
     * @param  none
     * @author Rakib Roni <rakib@atilimited.net>
     * @return
     */

    function examEligibility()
    {
        $data['contentTitle'] = 'Exam Eligibility';
        $data['breadcrumbs'] = array(
            'Exam' => '#',
            'Exam Eligibility' => '#',
            );


        $data["exam_application"] = $this->utilities->findAllByAttribute("exam_application", array('ACTIVE_STATUS' => 1));
        $data["section"] = $this->utilities->findAllByAttribute("aca_section", array('ACTIVE_STATUS' => 1));
        $data["faculty"] = $this->utilities->findAllByAttribute("ins_faculty", array('ACTIVE_STATUS' => 1));
        $data['content_view_page'] = 'admin/setup/exam/examApplication/exam_eligibility';
        $this->admin_template->display($data);
    }

    /*
     * @methodName eligibilityStudentList
     * @access
     * @param  none
     * @author Rakib Roni <rakib@atilimited.net>
     * @return
     */

    function eligibilityStudentList()
    {
        $EX_APP_ID=$this->input->post('EX_APP_ID');
        $PROGRAM_ID=$this->input->post('PROGRAM_ID');
        $data["eligibility_student"] = $this->exam_model->getEligibilityStudent($PROGRAM_ID,$EX_APP_ID);
        //print_r($data);exit;
        $this->load->view('admin/setup/exam/examApplication/exam_eligibility_list',$data);

    }

    /*
     * @methodName saveExamEligibleStudent
     * @access
     * @param  none
     * @author Rakib Roni <rakib@atilimited.net>
     * @return
     */

    function saveExamEligibleStudent()
    {
     $student_id=$this->input->post('STUDENT_ID');
     $exam_app_id=$this->input->post('EX_APP_ID');

     for($i=0; $i<sizeof($student_id);$i++){
        $eligibility_student = array(
            'STUDENT_ID' => $student_id[$i],
            'PROGRAM_ID' => $this->input->post('PROGRAM_ID'),
            'EX_APP_ID' =>$exam_app_id ,
            'DEPT_ID' => $this->input->post('DEPT_ID'),

            );
        $check = $this->utilities->hasInformationByThisId("exam_eligible", array("EX_APP_ID" => $exam_app_id, 'STUDENT_ID' => $student_id[$i]));
        if (empty($check)) {
            $this->utilities->insertData($eligibility_student, 'exam_eligible');

        }
    }

}

 /**
     * @methodName examType
     * @access
     * @param  none
     * @author Md. Reazul Islam <reazul@atilimited.net>
     * @return
     */

    function examType()
    {
        $data['contentTitle'] = 'Exam';
        $data['breadcrumbs'] = array(
            'Exam' => '#',
            'Exam Type' => '#',
            );
        $data["previlages"] = $this->checkPrevilege();
        $data['exam_type'] = $this->utilities->getAll('exam_type');

        //echo "<pre>"; print_r($data['exam_grade']); exit;

        $data['content_view_page'] = 'admin/setup/exam/examType/examType_index';
        $this->admin_template->display($data);
    }

    /*
    * @methodName examTypeFormInsert
    * @access
    * @param  none
    * @author Md. Reazul Islam <reazul@atilimited.net>
    * @return policy add form
    */

    function examTypeFormInsert()
    {
        $data["ac_type"] = 1;
        $this->load->view('admin/setup/exam/examType/add_examType', $data);
    }

    /*
   * @methodName createExamType
   * @accesss
   * @param  none
   * @author Md. Reazul Islam <reazul@atilimited.net>
   * @return
   */

    function createExamType()
    {
        $exam_title = $this->input->post('exam_title');
        $exam_type_Desc = $this->input->post('exam_type_Desc');

        $status = ((isset($_POST['status'])) ? 1 : 0);

        $check = $this->utilities->hasInformationByThisId("exam_marks_type", array("MARKS_TITLE" => $exam_title));

        if (empty($check)) {

            $exam_type = array(
                'EXAM_TITLE' => $exam_title,
                'EX_DESC' => $exam_type_Desc,
                'CREATED_BY' => $this->user["USER_ID"],
                'ACTIVE_STATUS' => $status,
                );

            if ($this->utilities->insertData($exam_type, 'exam_type')) {
                echo "<div class='alert alert-success'>Exam Type created successfully</div>";
            } else {
                echo "<div class='alert alert-danger'>Exam Type inserted failed</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Exam Type  already Exist</div>";
        }
    }

    /*
   * @methodName examTypeList
   * @access
   * @param  none
   * @author Md. Reazul Islam <reazul@atilimited.net>
   * @return list
   */

    function examTypeList()
    {
        $data["previlages"] = $this->checkPrevilege("exam/examType");
        $data['exam_type'] = $this->utilities->findAllFromView('exam_type');
        $this->load->view("admin/setup/exam/examType/examType_list", $data);
    }

    /*
    * @methodName examTypeFormUpdate
    * @access
    * @param  none
    * @author Md. Reazul Islam <reazul@atilimited.net>
    * @return
    */

    function examTypeFormUpdate()
    {
        $data["ac_type"] = 2;
        $id = $this->input->post('param');
        $data['exam_type'] = $this->utilities->findByAttribute('exam_type', array('EXAM_TYPE_ID' => $id));
        $this->load->view('admin/setup/exam/examType/add_examType', $data);
    }

    /*
    * @methodName updateExamType
    * @access
    * @param  none
    * @author Md. Reazul Islam <reazul@atilimited.net>
    * @return
    */

    function updateExamType()
    {
        $txtexam_typeId = $this->input->post('txtexam_typeId');
        $exam_title = $this->input->post('exam_title');
        $exam_type_Desc = $this->input->post('exam_type_Desc');

        $status = $this->input->post('status');

        $exam_type = array(
            'EXAM_TITLE' => $exam_title,
            'EX_DESC' => $exam_type_Desc,
            'CREATED_BY' => $this->user["USER_ID"],
            'ACTIVE_STATUS' => $status,
            );

        if ($this->utilities->updateData('exam_type', $exam_type, array('EXAM_TYPE_ID' => $txtexam_typeId))) {
            echo "<div class='alert alert-success'>Exam Type Updated successfully</div>";
        } else {
            echo "<div class='alert alert-danger'>Exam Type Updated failed</div>";
        }

    }

    /*
      * @methodName examTypeById
      * @access
      * @param  none
      * @author Md. Reazul Islam <reazul@atilimited.net>
      * @return
      */

    function examTypeById()
    {
        $examType_id = $this->input->post('param');
        $data["previlages"] = $this->checkPrevilege("exam/examType");
        $data['row'] = $this->utilities->findByAttribute('exam_type', array('EXAM_TYPE_ID' => $examType_id));
        $this->load->view('admin/setup/exam/examType/single_examType_row', $data);
    }
    /*
      Fahim Start
    */
    private function pr($data)
    {
      echo "<pre>";
      print_r($data);
      exit;
    }
    private function semesterInfo($totalSemester)
    {
      $data=array();
      for($i=1;$i<=$totalSemester;$i++)
      {
        if($i==1)
        {
          $ext='st';
        }
        else if($i==2)
        {
          $ext='nd';
        }else if($i==3)
        {
          $ext='rd';
        }
        else
        {
          $ext='th';
        }
        $data[$i]=$i.$ext.' Semester';
      }
      return $data;
    }
    private function yearInfo()
    {
      $currentYear=date("Y");
      $startYear=$currentYear-5;
      $endyear=$currentYear+5;
      $yearInfo=array();
      for($i=$startYear;$i<=$endyear;$i++)
      {
        $yearInfo[]=$i;
      }
      return $yearInfo;
    }
    public function generateAdmitCard()
    {
    if($_POST)
    {
      $sessionId=$this->input->post('sessionId');
      $programId=$this->input->post('programId');
      $semesterNo=$this->input->post('semesterNo');
      $year=$this->input->post('yearInfo');
      $isRegular=$this->input->post('isRegular');
      $data['isRegular']=$isRegular;
      $data['session'] = $this->utilities->findByAttribute('INS_YEAR_SESSION', array('SESSION_ID' => $sessionId));
      $data['program'] = $this->utilities->findByAttribute('ins_program', array('PROGRAM_ID' => $programId));
      $data['semester']=$this->semesterInfo(8)[$semesterNo];
      $data['year']=$year;
      $data['postData']=$_POST;
      if($isRegular=='1')
      {
        $data['students']=$this->db->query("SELECT a.STUDENT_ID,B.REGISTRATION_NO,B.FULL_NAME_EN,
                                    (SELECT COUNT(*) FROM UMS_ADMIT_CARD_MST WHERE
                                      PROGRAM_ID=a.PROGRAM_ID
                                      AND SESSION_ID=a.SESSION_ID
                                      AND STUDENT_ID=a.STUDENT_ID
                                      AND SEMESTER_NO=a.SEMESTER_SL_NO
                                      AND EXAM_YEAR=$year)
                                    EXIST,
                                    (SELECT MAX (ADMT_CRD_ID)
                                      FROM UMS_ADMIT_CARD_MST
                                     WHERE     PROGRAM_ID = a.PROGRAM_ID
                                           AND SESSION_ID = a.SESSION_ID
                                           AND STUDENT_ID = a.STUDENT_ID
                                           AND SEMESTER_NO = a.SEMESTER_SL_NO
                                           AND EXAM_YEAR = $year) MAX_ADMT_CRD_ID
                                    FROM STUDENT_SEMESTERINFO a
                                    LEFT JOIN STUDENT_PERSONAL_INFO b ON a.STUDENT_ID=b.STUDENT_ID
                                    WHERE A.PROGRAM_ID=$programId
                                    AND A.SESSION_ID=$sessionId
                                    AND A.SEMESTER_SL_NO=$semesterNo
                                    AND a.IS_CURRENT=1
                                    ORDER BY FULL_NAME_EN ASC")->result();
      }
      //$this->pr($data);
      echo $this->load->view('admin/setup/exam/admit/generateAdmitCardPost', $data, true);

    //  $this->pr($students);
      exit;
    }
      $data['contentTitle'] = 'Generate Admit Card';
      $data['breadcrumbs'] = array(
          'Exam' => '#',
          'Admit card' => '#',
          );
      $semesterInfo=$this->semesterInfo(8);
      $yearInfo=$this->yearInfo();
      $data['yearInfo']=$yearInfo;
      $data['semesterInfo']=$semesterInfo;

      $data["ins_session"] = $this->db->query("SELECT * FROM INS_YEAR_SESSION")->result();
      $data['program'] = $this->utilities->getAll('ins_program');
      $data['content_view_page'] = 'admin/setup/exam/admit/generateAdmitCard';
      $this->admin_template->display($data);
    }
    public function generateAdmitCardPost()
    {
      $students=$this->input->post('studentId');
      $sessionId=$this->input->post('sessionId');
      $programId=$this->input->post('programId');
      $semesterNo=$this->input->post('semesterNo');
      $year=$this->input->post('yearInfo');
      $isRegular=$this->input->post('isRegular');
      $lastCollectionDate=date('Y-m-d', strtotime($this->input->post('SDL_DT')));
      foreach($students as $key=>$value)
      {
        $maxId=$this->db->query("SELECT max(ADMT_CRD_ID) ADMT_CRD_ID FROM UMS_ADMIT_CARD_MST WHERE
          PROGRAM_ID=$programId
          AND SESSION_ID=$sessionId
          AND STUDENT_ID=$value
          AND SEMESTER_NO=$semesterNo
          AND EXAM_YEAR=$year")->row();
        $insertArray=array(
          'SEMESTER_NO'=>$semesterNo,
          'PROGRAM_ID'=>$programId,
          'STUDENT_ID'=>$value,
          'IS_REGULAR'=>$isRegular,
          'SESSION_ID'=>$sessionId,
          'EXAM_YEAR'=>$year,
          'CRE_BY'=>$this->session->userdata("logged_in")['USER_ID'],
          'CRE_DT'=>date("Y-m-d G:i:s"),
          'LAST_COLLECTION_DT'=>$lastCollectionDate,
        );
        if($maxId->ADMT_CRD_ID=='')
        {
          if ($this->utilities->insertData($insertArray, 'UMS_ADMIT_CARD_MST'))
          {
            $maxAdmitId=$this->db->query("SELECT MAX(ADMT_CRD_ID) MAX_ADMIT_ID FROM UMS_ADMIT_CARD_MST")->row();
            $admitId=$maxAdmitId->MAX_ADMIT_ID;
            $this->db->query("INSERT INTO UMS_ADMIT_CARD_CHD (COURSE_ID,ADMT_CRD_ID)
                              SELECT COURSE_ID,(SELECT $admitId FROM DUAL)
                              FROM STUDENT_COURSEINFO WHERE STUDENT_ID=$value
                              AND SEMISTER_SL_NO=$semesterNo");
          }
        }
        else
        {
          if ($this->utilities->updateData('UMS_ADMIT_CARD_MST', $insertArray, array('ADMT_CRD_ID' => $maxId->ADMT_CRD_ID))) {
            $item_id =$maxId->ADMT_CRD_ID;
            $data_tbl ='UMS_ADMIT_CARD_CHD';
            $data_field ='ADMT_CRD_ID';
            $attribute = array(
                "$data_field" => $item_id
                );
            $result = $this->utilities->deleteRowByAttribute($data_tbl, $attribute);
            if($result)
            {
              $this->db->query("INSERT INTO UMS_ADMIT_CARD_CHD (COURSE_ID,ADMT_CRD_ID)
                                SELECT COURSE_ID,(SELECT $maxId->ADMT_CRD_ID FROM DUAL)
                                FROM STUDENT_COURSEINFO WHERE STUDENT_ID=$value
                                AND SEMISTER_SL_NO=$semesterNo");
            }

          }
        }
      }
      redirect("exam/generateAdmitCard");

    }
    public function deleteAdmitCard($admitId)
    {
      $this->utilities->deleteRowByAttribute('UMS_ADMIT_CARD_CHD', array('ADMT_CRD_ID'=>$admitId));
      $this->utilities->deleteRowByAttribute('UMS_ADMIT_CARD_MST', array('ADMT_CRD_ID'=>$admitId));
    }
    public function downloadAdmitCard()
    {
      $data['contentTitle'] = 'Generate Admit Card';
      $data['breadcrumbs'] = array(
          'Download' => '#',
          'Admit card' => '#',
          );
      $semesterInfo=$this->semesterInfo(8);
      $yearInfo=$this->yearInfo();
      $data['yearInfo']=$yearInfo;
      $data['semesterInfo']=$semesterInfo;

      $data["ins_session"] = $this->db->query("SELECT * FROM INS_YEAR_SESSION")->result();
      $data['program'] = $this->utilities->getAll('ins_program');
      $data['content_view_page'] = 'admin/setup/exam/admit/downloadAdmitCard';
      $this->admin_template->display($data);
    }
    /*
      Fahim End
    */

    //Generate Exam Schedule
    public function generate_exam_schedule()
    {
        $data['contentTitle'] = 'Exam Schedule';
        $data['breadcrumbs'] = array(
            'Exam' => '#',
            'Generate Exam Schedule' => '#',
        );
        $semesterInfo=$this->semesterInfo(8);
        $yearInfo=$this->yearInfo();
        $data['yearInfo']=$yearInfo;
        $data['semesterInfo']=$semesterInfo;

        //$data['all_exam_aschedule_info'] = $this->utilities->exam_aschedule_info();
        $data["ins_session"] = $this->db->query("SELECT * FROM INS_YEAR_SESSION")->result();
        $data['program'] = $this->utilities->getAll('ins_program');
        $data['content_view_page'] = 'admin/setup/exam/admit/generate_exam_schedule';

        $this->form_validation->set_rules('PROGRAM_ID', 'Program', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->admin_template->display($data);
        }
        else
        {
            $PROGRAM_ID=$this->input->post('PROGRAM_ID');
            $SEMESTER_ID=$this->input->post('SEMESTER_NO');
            $SESSION_ID=$this->input->post('SESSION_ID');
            $EXAM_YEAR=$this->input->post('EXAM_YEAR');

            //First check
            $is_exist = $this->exam_model->checkAceSemesterCourse($PROGRAM_ID,$SEMESTER_ID,$SESSION_ID,$EXAM_YEAR);

            if($is_exist)
                die(var_dump($is_exist));


            $data['getCoursesByPidSidSid'] = $this->exam_model->getAceSemesterCourse($PROGRAM_ID,$SEMESTER_ID,$SESSION_ID);
            //die(var_dump($data['getCoursesByPidSidSid']));
            echo $this->load->view('admin/setup/exam/admit/generateExamSchedulePost', $data, true);
            exit;
        }
    }

    //Generate Exam Schedule
    public function generate_exam_schedule_post()
    {

        $this->form_validation->set_rules('TITLE', 'Title', 'required');
        $this->form_validation->set_rules('PROGRAM_ID', 'Program', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            echo 'v_error';
            exit;
        }
        else
        {
            $this->db->trans_begin();

            //Exam Schedule Master
            $exsm_data['EXAM_YEAR']=$this->input->post('EXAM_YEAR');
            $exsm_data['PROGRAM_ID']=$this->input->post('PROGRAM_ID');
            $exsm_data['SEMESTER_NO']=$this->input->post('SEMESTER_NO');
            $exsm_data['SESSION_ID']=$this->input->post('SESSION_ID');
            $exsm_data['TITLE']=$this->input->post('TITLE');
            $exsm_data['CRE_BY'] = $this->user['EMP_ID'];
            $exsm_data['CRE_DT'] = date("Y-m-d G:i:s");

            $EXM_SDL_MST_ID = $this->utilities->insert('UMS_EXAM_SCHEDULE_MST', $exsm_data);

            //Exam Schedule Child
            $COURSE_IDs=$this->input->post('COURSE_ID');
            $END_TIMEs = $this->input->post('END_TIME');
            $START_TIMEs = $this->input->post('START_TIME');
            $EXAM_DTs = $this->input->post('EXAM_DT');
            foreach ($COURSE_IDs as $key=>$value)
            {
                $exsc_data['COURSE_ID'] = $value;
                $exsc_data['END_TIME'] = date("Y-m-d G:i:s", strtotime($END_TIMEs[$value]));;
                $exsc_data['START_TIME'] = date("Y-m-d G:i:s", strtotime($START_TIMEs[$value]));
                $exsc_data['EXAM_DT'] = date("Y-m-d", strtotime(str_replace('/', '-', $EXAM_DTs[$value])));
                $exsc_data['EXM_SDL_MST_ID'] = $EXM_SDL_MST_ID;
                $this->utilities->insert('UMS_EXAM_SCHEDULE_CHD', $exsc_data);

            }

            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                echo 'no';
            }
            else
            {
                $this->db->trans_commit();
                echo 'yes';
            }
            exit();
        }
    }


}
