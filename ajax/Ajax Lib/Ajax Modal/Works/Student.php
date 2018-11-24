<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller
{
    protected $STUDENT_ID;
    private $user;
    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stu_logged_in') == FALSE && $this->session->userdata('logged_in') == FALSE) {
            redirect('auth/studentLogin', 'refresh');
        }

        $this->user = $user_data = $this->session->userdata('stu_logged_in');
        $this->STUDENT_ID = $user_data['STUDENT_ID'];

        header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->load->model('utilities');
        $this->load->library('upload');
        date_default_timezone_set("Asia/Dhaka");
        $this->db->query("alter session set nls_date_format='YYYY-MM-DD HH24:MI:SS'");
    }

    /**
     * @methodName  index()
     * @access
     * @param
     * @author      Rakib Roni <rakib@atilimited.net>
     * @return      student ndashboard
     */
    public function index()
    {

        $data['contentTitle'] = 'Dashboard';
        $data["breadcrumbs"] = array(
            "Dashboard" => '#'
        );

        $data['pageTitle'] = 'University student portal';
        $stu_session = $this->session->userdata('stu_logged_in');
        $stu_id = $stu_session["STUDENT_ID"];
        $data['days']=$this->utilities->getAll('weeks');

        $session_id = $stu_session["SESSION_ID"];
        $data['registered_courses']=$this->course_model->getStudentSessionWiseCourseList($stu_id,$session_id);
        $data['student_info_data']=$this->student_model->getStudentInfoAll($stu_id);

        $data['session_id']=$session_id ;
        $data['content_view_page'] = 'student/index';
        $this->student_portal->display($data);
    }

    function fee_report()
    {
        $stu_session = $this->session->userdata('stu_logged_in');
        $stu_id = $stu_session["STUDENT_ID"];
        $data['current_sem_stu_info'] = $this->db->query("SELECT a.FACULTY_ID,
            a.DEPT_ID,
            a.PROGRAM_ID,
            a.SESSION_ID,
            a.SEMISTER_ID,
            a.STUDENT_ID
            FROM stu_courseinfo a
            WHERE STUDENT_ID = $stu_id and a.IS_CURRENT=1")->row();

        //$txtStudent = $data['current_sem_stu_info']->STUDENT_ID;
        $prevSemesterAmt = array();
        $prev_expenses = array();
        $txtStudent = $data['current_sem_stu_info']->STUDENT_ID;
        $txtFaculty = $data['current_sem_stu_info']->FACULTY_ID;
        $txtDept = $data['current_sem_stu_info']->DEPT_ID;
        $txtProgram = $data['current_sem_stu_info']->PROGRAM_ID;
        $txtSession = $data['current_sem_stu_info']->SESSION_ID;
        $semester = $data['current_sem_stu_info']->SEMISTER_ID;
        $semester_seq = $this->utilities->findByAttribute("m00_lkpdata", array("LKP_ID" => $data["current_sem_stu_info"]->SEMISTER_ID));
        $data["semester_seq"] = $semester_seq;
        $exp_cond = array(
            "FACULTY_ID" => $txtFaculty,
            "DEPT_ID" => $txtDept,
            "PROGRAM_ID" => $txtProgram,
            "SESSION_ID" => $txtSession,
            "SEMESTER_ID" => $semester
        );
        $data["expenses"] = $this->utilities->findAllByAttributeWithJoin("ac_program_particulars", "ac_academic_charge", "PARTICULAR_ID", "CHARGE_ID", "CHARGE_NAME", $exp_cond);
        $data["dueAmt"] = $this->utilities->getStuPaidAmt($txtStudent, $semester);
        $previous_semester_id = $this->db->query("SELECT LKP_ID FROM m00_lkpdata WHERE LKP_ID = (select max(m.LKP_ID) from m00_lkpdata m where LKP_ID < $semester AND GRP_ID = 16)")->row();
        //print_r($previous_semester_id);
        if (!empty($previous_semester_id)) {
            $ids = array();
            $prev_all_semester_ids = $this->db->query("SELECT LKP_ID FROM m00_lkpdata WHERE LKP_ID IN (select m.LKP_ID from m00_lkpdata m where LKP_ID < $semester AND GRP_ID = 16)")->result();
            foreach ($prev_all_semester_ids as $prev_all_semester_id) {
                $ids[] = $prev_all_semester_id->LKP_ID;
            }
            $all_ids = implode(",", $ids);
            $data["prevSemesterAmt"] = $this->utilities->getStuPaidAmt($txtStudent, $all_ids);
            $data["prev_expenses"] = $this->db->query("SELECT SUM(PARTICULAR_AMOUNT)PARTICULAR_AMOUNT FROM ac_program_particulars
                WHERE `FACULTY_ID` = $txtFaculty AND `DEPT_ID` = $txtDept AND `PROGRAM_ID` = $txtProgram
                AND `SESSION_ID` = $txtSession AND `SEMESTER_ID` IN ($all_ids)")->row();
        }

        $this->load->view('student/dash_fees_payment', $data);
    }

    /**
     * @methodName  stuProfile()
     * @access
     * @param
     * @author      rakib <rakib@atilimited.net>
     * @return      View the student's details
     */
    function stuProfile()
    {
        $data['contentTitle'] = 'Profile';
        $data["breadcrumbs"] = array(
            "Profile" => '#'
        );
        $stu_session = $this->session->userdata('stu_logged_in');
        $stu_id = $stu_session["STUDENT_ID"];

        $data['applicant'] = $this->db->query("SELECT a.*,
            (SELECT b.BLOODGROUP_NAME
            FROM sav_bloodgrp b
            WHERE b.BLOODGROUP_ID = a.BLOOD_GROUP)
            blood,
            (SELECT m.LKP_NAME
            FROM m00_lkpdata m
            WHERE m.LKP_ID = a.MARITAL_STATUS)
            marital,
            (SELECT n.nationality
            FROM country n
            WHERE n.id = a.NATIONALITY)
            nationality,
            (SELECT group_concat(c.CONTACTS)
            FROM stu_contractinfo c
            WHERE c.STUDENT_ID = a.STUDENT_ID)
            contact,
            (SELECT r.RELIGION_NAME
            FROM sav_religion r
            WHERE r.RELIGION_ID = a.RELIGION_ID)
            relegion
            FROM students_info a
            WHERE a.STUDENT_ID =$stu_id")->row();

        $data['course'] = $this->db->query("SELECT c.OFFERED_COURSE_ID,
            (SELECT s.SESSION_NAME FROM session s WHERE s.SESSION_ID = c.SESSION_ID)session,
            (SELECT sem.SEMESTER_NAME FROM sav_semester sem WHERE sem.SEMESTER_ID = c.SEMISTER_ID)semester
            FROM stu_courseinfo c WHERE c.STUDENT_ID = '$stu_id'")->row();

        $data['courseList'] = $this->db->query("SELECT a.*, b.COURSE_CODE, b.COURSE_TITLE
            FROM stu_courseinfo a LEFT JOIN aca_course b ON a.COURSE_ID = b.COURSE_ID
            WHERE a.STUDENT_ID = '$stu_id' AND a.IS_CURRENT = '1'")->result();
        $data['admission'] = $this->db->query("SELECT a.*,
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
        //print_r($data['admission']);exit;
        $data["contact"] = $this->utilities->findAllByAttribute('stu_contractinfo', array("STUDENT_ID" => $stu_id, "CONTACT_TYPE" => 'M'));
        $data["email"] = $this->utilities->findAllByAttribute('stu_contractinfo', array("STUDENT_ID" => $stu_id, "CONTACT_TYPE" => 'E'));
        $data["current_academic_info"] = $this->db->query("SELECT a.*,
            b.SESSION_NAME,
            c.SEMESTER_NAME,
            d.FACULTY_NAME,
            e.DEPT_NAME,
            f.PROGRAM_NAME
            FROM stu_semesterinfo a
            LEFT JOIN session_view b ON a.SESSION_ID = b.SESSION_ID
            LEFT JOIN sav_semester c ON a.SEMESTER_ID = c.SEMESTER_ID
            LEFT JOIN faculty d ON a.FACULTY_ID = d.FACULTY_ID
            LEFT JOIN department e ON a.DEPT_ID = e.DEPT_ID
            LEFT JOIN program f ON a.PROGRAM_ID = f.PROGRAM_ID
            WHERE a.STUDENT_ID = '$stu_id' AND a.IS_CURRENT='1'")->row();

        $data["fathersInfo"] = $this->db->query("SELECT f.EMAIL_ADRESS,
            (SELECT fo.OCCUPATION_NAME FROM sav_occupation fo WHERE fo.OCCUPATION_ID = f.OCCUPATION)f_occupation FROM stu_parentinfo f WHERE f.STUDENT_ID = '$stu_id'")->row();

        $data["motherInfo"] = $this->db->query("SELECT m.EMAIL_ADRESS,
            (SELECT mo.OCCUPATION_NAME FROM sav_occupation mo WHERE mo.OCCUPATION_ID = m.OCCUPATION)m_occupation FROM stu_parentinfo m WHERE m.STUDENT_ID = '$stu_id'")->row();

        $data["father_contact"] = $this->utilities->findAllByAttribute('stu_pgscontract', array("STUDENT_ID" => $stu_id, "PGSC_TYPE" => 'F', "CONTACT_TYPE" => 'M'));
        $data["father_email"] = $this->utilities->findAllByAttribute('stu_pgscontract', array("STUDENT_ID" => $stu_id, "PGSC_TYPE" => 'F', "CONTACT_TYPE" => 'E'));

        $data["mother_contact"] = $this->utilities->findAllByAttribute('stu_pgscontract', array("STUDENT_ID" => $stu_id, "PGSC_TYPE" => 'M', "CONTACT_TYPE" => 'M'));
        $data["mother_email"] = $this->utilities->findAllByAttribute('stu_pgscontract', array("STUDENT_ID" => $stu_id, "PGSC_TYPE" => 'M', "CONTACT_TYPE" => 'E'));

        $data["addrInfo"] = $this->db->query("SELECT a.STUDENT_ID, a.ADRESS_TYPE, a.SAS_PSORPR, a.HOUSE_NO_NAME, a.ROAD_AVENO_NAME, a.VILLAGE_WARD, a.DISTRICT_ID, a.DIVISION_ID, a.POLICE_STATION_ID, a.POST_OFFICE_ID, a.THANA_ID, a.UNION_ID,
            (SELECT b.DIVISION_ENAME FROM sa_divisions b WHERE b.DIVISION_ID = a.DIVISION_ID)DIVIS_NAME,
            (SELECT d.DISTRICT_ENAME FROM sa_districts d WHERE d.DISTRICT_ID = a.DISTRICT_ID)DIST_NAME,
            (SELECT p.PS_ENAME FROM sa_police_station p WHERE p.POLICE_STATION_ID = a.POLICE_STATION_ID)PLOSC,
            (SELECT po.POST_OFFICE_ENAME FROM sa_post_offices po WHERE po.POST_OFFICE_ID = a.POST_OFFICE_ID)POSTO,
            (SELECT t.THANA_ENAME FROM sa_thanas t WHERE t.THANA_ID = a.THANA_ID)thn,
            (SELECT u.UNION_NAME FROM sa_unions u WHERE u.UNION_ID = a.UNION_ID)uni FROM stu_adressinfo a WHERE a.STUDENT_ID = '$stu_id' AND a.ADRESS_TYPE = 'PS'")->row();

        $data["parAddrInfo"] = $this->db->query("SELECT a.STUDENT_ID, a.ADRESS_TYPE, a.SAS_PSORPR, a.HOUSE_NO_NAME, a.ROAD_AVENO_NAME, a.VILLAGE_WARD, a.DISTRICT_ID, a.DIVISION_ID, a.POLICE_STATION_ID, a.POST_OFFICE_ID, a.THANA_ID, a.UNION_ID,
            (SELECT b.DIVISION_ENAME FROM sa_divisions b WHERE b.DIVISION_ID = a.DIVISION_ID)DIVIS_NAME,
            (SELECT d.DISTRICT_ENAME FROM sa_districts d WHERE d.DISTRICT_ID = a.DISTRICT_ID)DIST_NAME,
            (SELECT p.PS_ENAME FROM sa_police_station p WHERE p.POLICE_STATION_ID = a.POLICE_STATION_ID)PLOSC,
            (SELECT po.POST_OFFICE_ENAME FROM sa_post_offices po WHERE po.POST_OFFICE_ID = a.POST_OFFICE_ID)POSTO,
            (SELECT t.THANA_ENAME FROM sa_thanas t WHERE t.THANA_ID = a.THANA_ID)thn,
            (SELECT u.UNION_NAME FROM sa_unions u WHERE u.UNION_ID = a.UNION_ID)uni FROM stu_adressinfo a WHERE a.STUDENT_ID = '$stu_id' AND a.ADRESS_TYPE != 'PS'")->row();

        // $data['guardianInfo'] = $this->db->query("SELECT g.GFULL_NAME, g.EMAIL_ADRESS, g.ADDRESS,
        //     (SELECT gr.RELATION_NAME FROM sav_relation gr WHERE gr.RELATION_ID = g.RELATION_ID)relation FROM stu_guardians g WHERE g.STUDENT_ID = '$stu_id' ")->row();

        $data['guardian_contact'] = $this->utilities->findAllByAttribute('stu_pgscontract', array("STUDENT_ID" => '$stu_id', "PGSC_TYPE" => 'E'));

        $data['spouse'] = $this->db->query("SELECT s.SFULL_NAME,s.MARRIAGE_DT,s.EMAIL_ADRESS,
            (SELECT r.RELATION_NAME FROM sav_relation r WHERE r.RELATION_ID = s.RELATION_ID)relation FROM stu_spouseinfo s WHERE s.STUDENT_ID = '$stu_id'")->row();

        $data['academic'] = $this->db->query("SELECT a.INSTITUTION, a.RESULT_GRADE, a.PASSING_YEAR, a.ACHIEVEMENT,
           (SELECT dg.EDUDEGREE_NAME FROM sav_edudegree dg WHERE dg.EDUDEGREE_ID = a.EXAM_DEGREE_ID )deg,
           (SELECT brd.UNIVERSITY_BOARD_NAME FROM sav_university_board brd WHERE brd.UNIVERSITY_BOARD_ID = a.BOARD )board,
           (SELECT mg.EDUCATION_GROUP_NAME FROM sav_education_group mg WHERE mg.EDUCATION_GROUP_ID = a.MAJOR_GROUP_ID )grp FROM stu_acadimicinfo a WHERE a.STUDENT_ID = '$stu_id' ")->result();

        $data['medical'] = $this->db->query("SELECT m.CURRENTLY_USED, m.PREVIOUSLY_USED, m.TYPE_AMOUNT_FREQUENCY, m.DURATION, m.STOP_DT,
            (SELECT s.SUBSTANCES_NAME FROM sav_substances s WHERE s.SUBSTANCES_ID = m.SUBSTANCE)substances FROM stu_medicalinfo m WHERE m.STUDENT_ID = '$stu_id'")->result();

        $data['disease'] = $this->db->query("SELECT d.DISEASE_NAME, d.START_DT, d.END_DT, d.DOCTOR_NAME FROM stu_diseaseinfo d WHERE d.STUDENT_ID = '$stu_id'")->result();

        $data['waiver'] = $this->db->query("SELECT w.PERCENTAGE, w.REASON FROM stu_weaverinfo w WHERE w.STUDENT_ID = '$stu_id'")->row();
        $data['sibling'] = $this->db->query("SELECT s.SBLN_ROLL_NO FROM stu_siblings s WHERE s.STUDENT_ID = '$stu_id'")->row();
        $data['content_view_page'] = 'student/student_details';
        $this->student_portal->display($data);
    }

    function studentNotice()
    {

        $data['contentTitle'] = 'Notice Board';
        $data["breadcrumbs"] = array(
            "Notice" => '#'
        );
        $stu_session = $this->session->userdata('stu_logged_in');
        $stu_id = $stu_session["STUDENT_ID"];
        $student_info = $this->utilities->studentInfo($stu_id);
        $data['notice'] = $this->db->query("select a.* from notice a where a.FACULTY_ID = $student_info->FACULTY_ID  and a.DEPT_ID =$student_info->DEPT_ID and a.PROGRAM_ID =$student_info->PROGRAM_ID ")->result();

        $data['content_view_page'] = 'student/student_notice';
        $this->student_portal->display($data);
    }

    public function print_stu_information()
    {
        $data['pageTitle'] = 'Print PDF';
        $stu_session = $this->session->userdata('stu_logged_in');
        $stu_id = $stu_session["STUDENT_ID"];
        $data['applicant'] = $this->db->query("SELECT a.STUDENT_ID, a.ROLL_NO, a.FIRST_NAME, a.MIDDLE_NAME, a.LAST_NAME, a.FULL_NAME_EN,a.FULL_NAME_BN, a.STUD_PHOTO, a.GENDER, a.NATIONAL_ID, a.MOBILE_NO, a.EMAIL_ADRESS, a.FATHER_NAME, a.MOTHER_NAME, a.MARITAL_STATUS, a.SPOUSE_NAME, a.DATH_OF_BIRTH, a.HEIGHT_CM, a.WEIGHT_KG, a.PASSWORD,
            a.GENDER, a.NATIONAL_ID, a.PASSPORT_NO, a.SSOF_FINANC, a.FMLY_INCOME,
            (SELECT b.BLOODGROUP_NAME FROM sav_bloodgrp b WHERE b.BLOODGROUP_ID = a.BLOOD_GROUP)blood,
            (SELECT m.LKP_NAME FROM m00_lkpdata m WHERE m.LKP_ID = a.MARITAL_STATUS)marital,
            (SELECT n.nationality FROM country n WHERE n.id = a.NATIONALITY)nationality,
            (SELECT m.BATCH_TITLE FROM aca_batch m WHERE m.BATCH_ID = a.BATCH_ID)batch,
            (SELECT group_concat(c.CONTACTS) FROM stu_contractinfo c WHERE c.STUDENT_ID = a.STUDENT_ID)contact,
            (SELECT r.RELIGION_NAME FROM sav_religion r WHERE r.RELIGION_ID = a.RELIGION_ID)relegion FROM students_info a WHERE a.STUDENT_ID = '$stu_id'")->result();

        $data['course'] = $this->db->query("SELECT c.OFFERED_COURSE_ID,
            (SELECT s.SESSION_NAME FROM session s WHERE s.SESSION_ID = c.SESSION_ID)session,
            (SELECT sem.SEMESTER_NAME FROM sav_semester sem WHERE sem.SEMESTER_ID = c.SEMISTER_ID)semester
            FROM stu_courseinfo c WHERE c.STUDENT_ID = '$stu_id'")->row();

        $data['courseList'] = $this->db->query("SELECT a.*, b.COURSE_CODE, b.COURSE_TITLE
            FROM stu_courseinfo a LEFT JOIN aca_course b ON a.COURSE_ID = b.COURSE_ID
            WHERE a.STUDENT_ID = '$stu_id' AND a.IS_CURRENT = '1'")->result();

        $data['admission'] = $this->utilities->admissionInfoByStu($stu_id);

        $data["contact"] = $this->utilities->findAllByAttribute('stu_contractinfo', array("STUDENT_ID" => $stu_id, "CONTACT_TYPE" => 'M'));
        $data["email"] = $this->utilities->findAllByAttribute('stu_contractinfo', array("STUDENT_ID" => $stu_id, "CONTACT_TYPE" => 'E'));
        $data["academic_info"] = $this->db->query("SELECT a.CREATE_DATE,
            (SELECT s.SESSION_NAME FROM session s WHERE s.SESSION_ID = a.SESSION_ID)session,
            (SELECT f.FACULTY_NAME FROM faculty f WHERE f.FACULTY_ID = a.FACULTY_ID)faculty,
            (SELECT d.DEPT_NAME FROM department d WHERE d.DEPT_ID = a.DEPT_ID)department,
            (SELECT p.PROGRAM_NAME FROM program p WHERE p.PROGRAM_ID = a.PROGRAM_ID)program,
            (SELECT sem.SEMESTER_NAME FROM sav_semester sem WHERE sem.SEMESTER_ID = a.SEMISTER_ID)semester FROM stu_admissioninfo a WHERE a.STUDENT_ID = '$stu_id'")->row();
        $data["current_academic_info"] = $this->db->query("SELECT a.*,
            b.SESSION_NAME,
            c.SEMESTER_NAME,
            d.FACULTY_NAME,
            e.DEPT_NAME,
            f.PROGRAM_NAME
            FROM stu_semesterinfo a
            LEFT JOIN session_view b ON a.SEM_SESSION = b.SESSION_ID
            LEFT JOIN sav_semester c ON a.SEMESTER_ID = c.SEMESTER_ID
            LEFT JOIN faculty d ON a.FACULTY_ID = d.FACULTY_ID
            LEFT JOIN department e ON a.DEPT_ID = e.DEPT_ID
            LEFT JOIN program f ON a.PROGRAM_ID = f.PROGRAM_ID
            WHERE a.STUDENT_ID = '$stu_id' AND a.IS_CURRENT='1'")->row();

        $data["fathersInfo"] = $this->db->query("SELECT f.EMAIL_ADRESS,f.PARENT_PHOTO,
            (SELECT fo.OCCUPATION_NAME FROM sav_occupation fo WHERE fo.OCCUPATION_ID = f.OCCUPATION)f_occupation FROM stu_parentinfo f WHERE f.STUDENT_ID = '$stu_id' and f.PARENTS_TYPE='F'")->row();

        $data["motherInfo"] = $this->db->query("SELECT m.EMAIL_ADRESS,m.PARENT_PHOTO,
            (SELECT mo.OCCUPATION_NAME FROM sav_occupation mo WHERE mo.OCCUPATION_ID = m.OCCUPATION)m_occupation FROM stu_parentinfo m WHERE m.STUDENT_ID = '$stu_id' and m.PARENTS_TYPE='M'")->row();
        //echo "<pre>"; print_r($data["motherInfo"]); exit; echo "</pre>";

        $data["father_contact"] = $this->utilities->findAllByAttribute('stu_pgscontract', array("STUDENT_ID" => $stu_id, "PGSC_TYPE" => 'F', "CONTACT_TYPE" => 'M'));
        $data["father_email"] = $this->utilities->findAllByAttribute('stu_pgscontract', array("STUDENT_ID" => $stu_id, "PGSC_TYPE" => 'F', "CONTACT_TYPE" => 'E'));

        $data["mother_contact"] = $this->utilities->findAllByAttribute('stu_pgscontract', array("STUDENT_ID" => $stu_id, "PGSC_TYPE" => 'M', "CONTACT_TYPE" => 'M'));
        $data["mother_email"] = $this->utilities->findAllByAttribute('stu_pgscontract', array("STUDENT_ID" => $stu_id, "PGSC_TYPE" => 'M', "CONTACT_TYPE" => 'E'));

        $data["addrInfo"] = $this->db->query("SELECT a.STUDENT_ID, a.ADRESS_TYPE, a.SAS_PSORPR, a.HOUSE_NO_NAME, a.ROAD_AVENO_NAME, a.VILLAGE_WARD, a.DISTRICT_ID, a.DIVISION_ID, a.POLICE_STATION_ID, a.POST_OFFICE_ID, a.THANA_ID, a.UNION_ID,
            (SELECT b.DIVISION_ENAME FROM sa_divisions b WHERE b.DIVISION_ID = a.DIVISION_ID)DIVIS_NAME,
            (SELECT d.DISTRICT_ENAME FROM sa_districts d WHERE d.DISTRICT_ID = a.DISTRICT_ID)DIST_NAME,
            (SELECT p.PS_ENAME FROM sa_police_station p WHERE p.POLICE_STATION_ID = a.POLICE_STATION_ID)PLOSC,
            (SELECT po.POST_OFFICE_ENAME FROM sa_post_offices po WHERE po.POST_OFFICE_ID = a.POST_OFFICE_ID)POSTO,
            (SELECT t.THANA_ENAME FROM sa_thanas t WHERE t.THANA_ID = a.THANA_ID)thn,
            (SELECT u.UNION_NAME FROM sa_unions u WHERE u.UNION_ID = a.UNION_ID)uni FROM stu_adressinfo a WHERE a.STUDENT_ID = '$stu_id' AND a.ADRESS_TYPE = 'PS'")->result();

        $data["parAddrInfo"] = $this->db->query("SELECT a.STUDENT_ID, a.ADRESS_TYPE, a.SAS_PSORPR, a.HOUSE_NO_NAME, a.ROAD_AVENO_NAME, a.VILLAGE_WARD, a.DISTRICT_ID, a.DIVISION_ID, a.POLICE_STATION_ID, a.POST_OFFICE_ID, a.THANA_ID, a.UNION_ID,
            (SELECT b.DIVISION_ENAME FROM sa_divisions b WHERE b.DIVISION_ID = a.DIVISION_ID)DIVIS_NAME,
            (SELECT d.DISTRICT_ENAME FROM sa_districts d WHERE d.DISTRICT_ID = a.DISTRICT_ID)DIST_NAME,
            (SELECT p.PS_ENAME FROM sa_police_station p WHERE p.POLICE_STATION_ID = a.POLICE_STATION_ID)PLOSC,
            (SELECT po.POST_OFFICE_ENAME FROM sa_post_offices po WHERE po.POST_OFFICE_ID = a.POST_OFFICE_ID)POSTO,
            (SELECT t.THANA_ENAME FROM sa_thanas t WHERE t.THANA_ID = a.THANA_ID)thn,
            (SELECT u.UNION_NAME FROM sa_unions u WHERE u.UNION_ID = a.UNION_ID)uni FROM stu_adressinfo a WHERE a.STUDENT_ID = '$stu_id' AND a.ADRESS_TYPE != 'PS'")->row();

        // $data['guardianInfo'] = $this->db->query("SELECT g.GFULL_NAME, g.EMAIL_ADRESS, g.ADDRESS,
        //        (SELECT gr.RELATION_NAME FROM sav_relation gr WHERE gr.RELATION_ID = g.RELATION_ID)relation FROM stu_guardians g WHERE g.STUDENT_ID = '$stu_id' ")->row();

        $data['guardian_contact'] = $this->utilities->findAllByAttribute('stu_pgscontract', array("STUDENT_ID" => '$stu_id', "PGSC_TYPE" => 'E'));

        $data['spouse'] = $this->db->query("SELECT s.SFULL_NAME,s.MARRIAGE_DT,s.EMAIL_ADRESS,
            (SELECT r.RELATION_NAME FROM sav_relation r WHERE r.RELATION_ID = s.RELATION_ID)relation FROM stu_spouseinfo s WHERE s.STUDENT_ID = '$stu_id'")->row();

        $data['academic'] = $this->db->query("SELECT a.INSTITUTION, a.RESULT_GRADE, a.PASSING_YEAR, a.ACHIEVEMENT,
           (SELECT dg.EDUDEGREE_NAME FROM sav_edudegree dg WHERE dg.EDUDEGREE_ID = a.EXAM_DEGREE_ID )deg,
           (SELECT brd.UNIVERSITY_BOARD_NAME FROM sav_university_board brd WHERE brd.UNIVERSITY_BOARD_ID = a.BOARD )board,
           (SELECT mg.EDUCATION_GROUP_NAME FROM sav_education_group mg WHERE mg.EDUCATION_GROUP_ID = a.MAJOR_GROUP_ID )grp FROM stu_acadimicinfo a WHERE a.STUDENT_ID = '$stu_id' ")->result();

        $data['medical'] = $this->db->query("SELECT m.CURRENTLY_USED, m.PREVIOUSLY_USED, m.TYPE_AMOUNT_FREQUENCY, m.DURATION, m.STOP_DT,
            (SELECT s.SUBSTANCES_NAME FROM sav_substances s WHERE s.SUBSTANCES_ID = m.SUBSTANCE)substances FROM stu_medicalinfo m WHERE m.STUDENT_ID = '$stu_id'")->result();

        $data['disease'] = $this->db->query("SELECT d.DISEASE_NAME, d.START_DT, d.END_DT, d.DOCTOR_NAME FROM stu_diseaseinfo d WHERE d.STUDENT_ID = '$stu_id'")->result();

        $data['waiver'] = $this->db->query("SELECT w.PERCENTAGE, w.REASON FROM stu_weaverinfo w WHERE w.STUDENT_ID = '$stu_id'")->row();
        $data['sibling'] = $this->db->query("SELECT s.SBLN_ROLL_NO FROM stu_siblings s WHERE s.STUDENT_ID = '$stu_id'")->row();

        include('mpdf/mpdf.php');
        $mpdf = new mPDF();
        $mpdf->mirrorMargins = 1;
        $mpdf->useOnlyCoreFonts = true;
        // $mpdf->SetWatermarkImage('resources/img/dgdp_logo.png');
        //$mpdf->showWatermarkImage = true;
        $report = $this->load->view('student/print_stu_information', $data, TRUE);
        $mpdf->WriteHTML("body { font-family: arial; }$report");
        $mpdf->Output();
        exit;
    }

    function registraredCourseBySemester()
    {

        $data['contentTitle'] = 'Registered Course Content';
        $data["breadcrumbs"] = array(
            "Registered Course Content" => '#'
        );
        $stu_session = $this->session->userdata('stu_logged_in');
        $stu_id = $stu_session["STUDENT_ID"];
        $student_info = $this->utilities->studentInfo($stu_id);
        $data['session_info'] = $this->utilities->universityStudentSessionInfo($stu_id);
        $data['sem_session'] = $student_info;
        //print_r($student_info);exit;
        $data['current_reg_course'] = $this->db->query("SELECT a.STU_CRS_ID,
            a.STUDENT_ID,
            a.OFFERED_COURSE_ID,
            a.SESSION_ID,
            a.SEMISTER_ID,
            a.FACULTY_ID,
            a.DEPT_ID,
            a.PROGRAM_ID,
            a.COURSE_ID,
            a.IS_CURRENT,
            a.ACTIVE_STATUS,
            b.COURSE_CODE,
            b.COURSE_TITLE,
            b.CREDIT
            FROM stu_courseinfo a LEFT JOIN aca_course b ON a.COURSE_ID = b.COURSE_ID
            WHERE a.STUDENT_ID = $stu_id and a.IS_CURRENT=1")->result();
        $data['all_course_content'] = $this->db->query("SELECT a.*, b.CONTENT_TITLE, b.CONTENT_URI
            FROM aca_crs_content_distribution a
            LEFT JOIN aca_crs_content b ON a.C_CONTENT_ID = b.C_CONTENT_ID
            WHERE     a.FACULTY_ID = $student_info->FACULTY_ID
            AND a.DEPT_ID = $student_info->DEPT_ID
            AND a.PROGRAM_ID = $student_info->PROGRAM_ID
            AND a.SEM_SESSION = $student_info->SESSION_ID
            AND a.SEMESTER_ID = $student_info->SEMESTER_ID")->result();
        // echo "<pre>";print_r($data['all_course_content']);exit;
        $data['content_view_page'] = 'student/registered_courses';
        $this->student_portal->display($data);
    }

    /**
     * @methodName  conByCorss()
     * @access
     * @param
     * @author      rakib <rakib@atilimited.net>
     * @return      course wise content view
     */
    function conByCorss()
    {
        $course_id = $_POST['course_id'];
        $stu_session = $this->session->userdata('stu_logged_in');
        $stu_id = $stu_session["STUDENT_ID"];
        $studnet_info = $this->utilities->studentInfo($stu_id);
        // echo "<pre>"; print_r($studnet_info); exit; echo "</pre>";
        $data['content_by_course'] = $this->db->query("SELECT a.*, b.CONTENT_TITLE, b.CONTENT_URI
            FROM aca_crs_content_distribution a
            LEFT JOIN aca_crs_content b ON a.C_CONTENT_ID = b.C_CONTENT_ID
            WHERE     a.FACULTY_ID = $studnet_info->FACULTY_ID
            AND a.DEPT_ID = $studnet_info->DEPT_ID
            AND a.PROGRAM_ID = $studnet_info->PROGRAM_ID
            AND a.SEM_SESSION = $studnet_info->SEM_SESSION
            AND a.SEMESTER_ID = $studnet_info->SEMESTER_ID
            AND a.COURSE_ID =  $course_id")->result();
        //echo "<pre>"; print_r($this->db->last_query()); exit; echo "</pre>";
        $this->load->view('student/content_by_course', $data);
    }

    /**
     * @methodName  coursesBySession()
     * @access
     * @param
     * @author      rakib <rakib@atilimited.net>
     * @return      semester session wise course list
     */
    function coursesBySession()
    {
        $session_id = $_POST['session_id'];
        $stu_session = $this->session->userdata('stu_logged_in');
        $stu_id = $stu_session["STUDENT_ID"];

        $course_list = $this->db->query("SELECT a.COURSE_ID, b.COURSE_TITLE, b.COURSE_CODE
            FROM stu_courseinfo a LEFT JOIN aca_course b ON a.COURSE_ID = b.COURSE_ID
            WHERE a.SEM_SESSION = $session_id AND a.STUDENT_ID = $stu_id")->result();
        $l = '';
        foreach ($course_list as $row) {
            $l .= '<li style="background-color: lightyellow;padding: 4px"><span  class="courseList pointer" data-course-id="' . $row->COURSE_ID . '"><i class="fa fa-folder "></i> <span class="label label-info" style="padding: 1px !important"><b>' . $row->COURSE_CODE . '</span>&nbsp;&nbsp;' . $row->COURSE_TITLE . '</b></span></li>';
        }
        echo $l;
    }

    function noteNoticeByCourse()
    {

        $data['contentTitle'] = 'Course Notice and Notes';
        $data["breadcrumbs"] = array(
            "Course Notice and Notes" => '#'
        );
//        $stu_session = $this->session->userdata('stu_logged_in');
//        $stu_id = $stu_session["STUDENT_ID"];
//
//        $data['current_reg_course']=$this->db->query("SELECT a.STU_CRS_ID,
//                                                                    a.STUDENT_ID,
//                                                                    a.OFFERED_COURSE_ID,
//                                                                    a.SESSION_ID,
//                                                                    a.SEMISTER_ID,
//                                                                    a.FACULTY_ID,
//                                                                    a.DEPT_ID,
//                                                                    a.PROGRAM_ID,
//                                                                    a.COURSE_ID,
//                                                                    a.IS_CURRENT,
//                                                                    a.ACTIVE_STATUS,
//                                                                    b.COURSE_CODE,
//                                                                    b.COURSE_TITLE,
//                                                                    b.CREDIT
//                                                                FROM stu_courseinfo a LEFT JOIN course b ON a.COURSE_ID = b.COURSE_ID
//                                                                WHERE a.STUDENT_ID = $stu_id and a.IS_CURRENT=1")->result();
//        //echo "<pre>";print_r($data['current_reg_course']);exit;
        $data['content_view_page'] = 'student/reg_course_note_notice';
        $this->student_portal->display($data);
    }

    function reportSemPayment()
    {

        $this->load->view('student/report_sem_payment');
    }

    function reportSemResultDetails()
    {

        $this->load->view('student/report_sem_result_details');
    }

    function libraryDetials()
    {

        $this->load->view('student/report_library_details');
    }

    /**
     * @methodName  calendarEvents()
     * @access
     * @param
     * @author      Sultan Ahmmed <sultan@atilimited.net>
     * @return      Calender Task Schedule
     */
    function calendarEvents()
    {
        $events = $this->utilities->findAllFromView('events'); // select all data from event where event type id

        $returnArray = array();
        foreach ($events as $event_slot) {

            if ($event_slot->ACTIVE_STATUS == 1) {
                $color = '#1AB394';
            } else {
                $color = '#D9EDF7';
            }
            $returnArray[] = array(
                'id' => $event_slot->EVENT_ID,
                'title' => $event_slot->E_TITLE,
                'start' => date('Y-m-d', strtotime($event_slot->START_DT)) . " " . $event_slot->START_TIME,
                'end' => date('Y-m-d', strtotime($event_slot->END_DT)) . " " . $event_slot->END_TIME,
                //'color' => 'rgba(116,166,117,.7)',
//'patient_id' => $event_slot->HN_NO,
                'color' => $color,
                'allDay' => false
            );
        }

        echo json_encode($returnArray);
    }

    /*
     * @methodName eventInfo()
     * @access none
     * @param  $event_id
     * @return Mixed Template
     */

    function eventInfo()
    {
        $event_id = $this->input->post('param');
        // select all data from event with inforamtion
        $data['event'] = $this->db->query("SELECT e.EVENT_ID, e.E_TITLE, e.E_DESC, e.START_DT, e.END_DT,e.START_TIME,e.END_TIME, e.ACTIVE_STATUS,
            (SELECT t.E_TYPE_NAME FROM event_type t WHERE t.E_TYPE_ID = e.E_TYPE_ID)type FROM event e WHERE e.EVENT_ID = '$event_id'")->row();
        /* var_dump($data['event']);
        exit(); */
        $this->load->view("admin/setup/event/event_info", $data);
    }

    /**
     * @methodName  calender()
     * @access
     * @param
     * @author      Sultan Ahmmed <sultan@atilimited.net>
     * @return      Calender Task Schedule
     */
    function calendar()
    {
        $data['contentTitle'] = 'Calendar';
        $data["breadcrumbs"] = array(
            "Admin" => "admin/index",
            "Calendar" => '#'
        );
        $data['event'] = $this->utilities->getAll('events'); // Get all event data
        $data['content_view_page'] = 'student/calendar/index';
        $this->student_portal->display($data);
    }


    function weeklySch()
    {
        $this->load->view('student/weekly_class_schedule');
    }


    function dashBoard()
    {
        $data["breadcrumbs"] = array(
            "Student" => "#",
            "Dashboard" => "#",
        );

        $data['content_view_page'] = 'applicant/welcome.php';
        $this->student_portal->display($data);
    }

    public function studentInfo()
    {
        $data['contentTitle'] = 'Student';
        $data["breadcrumbs"] = array(
            "Student" => "#",
            "Info" => '#'
        );

        $data['pageTitle'] = 'Online University Management System';
//        $this->load->helper(array('form', 'url'));
//        $this->load->library('form_validation');
//        $this->form_validation->set_rules('FULL_NAME_BN', 'full name', 'required');
        //$this->form_validation->set_rules('PLACE_OF_BIRTH', 'place of birth', 'required');
        // $this->form_validation->set_rules('NATIONAL_ID', 'national id', 'required');

        $applicant_ses = $this->session->userdata('applicant_logged_in');


        if ($this->form_validation->run() == FALSE) {


            // print_r($this->session->userdata('applicant_logged_in'));  echo
            $data['division'] = $this->utilities->getAll('sa_divisions');
            $data['nationality'] = $this->utilities->getAll('country');
            $data['extra_activity_type'] = $this->utilities->getAll('extra_activity_type');
            $data['religion'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 3));
            $data['merital_status'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 8));
            $data['blood_group'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 4));
            $data['substance'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 56));
            $data['exam_name'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 13));
            $data['board_name'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 24));
            $data['group_name'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 25));
            $data['occupation'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 21));
            $data['relation'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 40));
            // $data['session'] = $this->utilities->getAll('session_view');
            $data['faculty'] = $this->utilities->findAllByAttribute('ins_faculty', array('ACTIVE_STATUS' => 1));
            $data['department'] = $this->utilities->findAllByAttribute('ins_dept', array('ACTIVE_STATUS' => 1));
            $data['semester'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 16));
            $data['applicant_user'] = $this->utilities->findAllByAttribute('applicant_user', array('APPLICANT_USER_ID' => $applicant_ses['APPLICANT_USER_ID']));
            //print_r($data['applicant_user'] );exit;
            // echo $data['applicant_user'][0]->APPLICANT_USER_ID;exit;
            if ($data['applicant_user'][0]->FF_COM_STATUS == 0) {
                $data['content_view_page'] = 'applicant/admission';
            } else {
                redirect('student/studentDetails');
            }

        } else {

            require(APPPATH . 'views/common/image_upload/class.upload.php');
            $applicant_photo_name = '';
            $signature_photo_name = '';
            $foo = new Upload($_FILES['photo']);
            if ($foo->uploaded) {
                // large size image
                //$foo->file_new_name_body = 'foo';
                $foo->image_border = 1;
                //$foo->file_new_name_body = 'photo_123';
                //$foo->image_border_color    = '#231F20';
                $foo->allowed = array('image/*');
                $foo->Process('upload/applicant/photo/');
                if ($foo->processed) {
                    //$applicant_photo_name=  $foo->file_src_name;
                    $applicant_photo_name = $foo->file_src_name;
                } else {
                    echo 'error : ' . $foo->error;
                }
            }

            $sig_photo = new Upload($_FILES['signature']);
            if ($sig_photo->uploaded) {
                // large size image
                //$foo->file_new_name_body = 'foo';
                $sig_photo->image_border = 1;
                //$foo->image_border_color    = '#231F20';
                $sig_photo->allowed = array('image/*');
                $sig_photo->Process('upload/applicant/signature/');
                if ($sig_photo->processed) {
                    $signature_photo_name = $sig_photo->file_src_name;
                } else {
                    echo 'error : ' . $sig_photo->error;
                }
            }
            // ### applicant personal information ###
            $current_adm_info = $this->utilities->findByAttribute('adm_ysession', array('IS_CURRENT' => 1));
            $current_session_id = $current_adm_info->SESSION_ID;
            $current_session_year = $current_adm_info->DINYEAR;
            $ADM_ROLL_NO = $this->utilities->get_addmission_roll_number($current_session_year, $current_session_id, $applicant_ses['FACULTY_ID'], $applicant_ses['DEPT_ID'], $applicant_ses['PROGRAM_ID']);

            $applicnt_personal_info = array(
                'FULL_NAME_EN' => $applicant_ses['FULL_NAME'],
                'MOBILE_NO' => $applicant_ses['MOBILE'],
                'GENDER' => $applicant_ses['GENDER'],
                'DATH_OF_BIRTH' => $applicant_ses['BIRTH_DT'],
                'EMAIL_ADRESS' => $applicant_ses['EMAIL'],
                'APPLICANT_USER_ID' => $applicant_ses['APPLICANT_USER_ID'],
                'ADM_SESSION_ID' => $current_session_id,
                'ADM_ROLL_NO' => $ADM_ROLL_NO,

                'DEGREE_ID' => $applicant_ses['DEGREE_ID'],
                'FACULTY_ID' => $applicant_ses['FACULTY_ID'],
                'DEPT_ID' => $applicant_ses['DEPT_ID'],
                'PROGRAM_ID' => $applicant_ses['PROGRAM_ID'],

                'MOTHER_NAME' => $this->input->post('MOTHER_NAME'),
                'FATHER_NAME' => $this->input->post('FATHER_NAME'),
                'PLACE_OF_BIRTH' => $this->input->post('PLACE_OF_BIRTH'),
                'FULL_NAME_BN' => $this->input->post('FULL_NAME_BN'),
                'BLOOD_GROUP' => $this->input->post('BLOOD_GRP'),
                'MARITAL_STATUS' => $this->input->post('MARITAL_STATUS'),
                'NATIONALITY' => $this->input->post('NATIONALITY'),
                'RELIGION_ID' => $this->input->post('RELIGION_ID'),
                'BIRTH_CERTIFICATE' => $this->input->post('BIRTH_CERTIFICATE'),
                'NATIONAL_ID' => $this->input->post('NATIONAL_ID'),
                'HEIGHT_FEET' => $this->input->post('HEIGHT_FEET'),
                'HEIGHT_CM' => $this->input->post('HEIGHT_CM'),
                'WEIGHT_KG' => $this->input->post('WEIGHT_KG'),
                'WEIGHT_LBS' => $this->input->post('WEIGHT_LBS'),
                'PHOTO' => $applicant_photo_name,
                'SIGNATURE_PHOTO' => $signature_photo_name,
                'ANNUAL_INCOME' => $this->input->post('ANNUAL_INCOME'),
                'SCHOLARSHIP' => $this->input->post('SCHOLARSHIP'),
                'SCHOLARSHIP_DESC' => $this->input->post('SCHOLARSHIP_DESC'),
                'EXPELLED' => $this->input->post('EXPELLED'),
                'EXPELLED_DESC' => $this->input->post('EXPELLED_DESC'),
                'ARRESTED' => $this->input->post('ARRESTED'),
                'ARRESTED_DESC' => $this->input->post('ARRESTED_DESC'),
                'CONVICTED' => $this->input->post('CONVICTED'),
                'CONVICTED_DESC' => $this->input->post('CONVICTED_DESC'),
                'APPLY_BEFORE' => $this->input->post('APPLY_BEFORE'),
                'APPLY_SEMESTER' => $this->input->post('APPLY_SEMESTER'),
                'APPLY_YEAR' => $this->input->post('APPLY_YEAR'),
                'SIBLING_EXIST' => $this->input->post('SIBLING_EXIST'),
                'SBLN_ROLL_NO' => $this->input->post('SBLN_ROLL_NO'),
            );
            // print_r($applicnt_personal_info);exit;
            $this->utilities->insert('applicant_personal_info', $applicnt_personal_info);
            $applicant_id = $this->db->insert_id();

            // ### applicant father information ###
            $applicant_father_info = array(
                'APPLICANT_ID' => $applicant_id,
                'GURDIAN_NAME' => $this->input->post('FATHER_NAME'),
                'OCCUPATION' => $this->input->post('FATHER_OCU'),
                'MOBILE_NO' => $this->input->post('FATHER_PHN'),
                'EMAIL_ADRESS' => $this->input->post('FATHER_EMAIL'),
                'WORKING_ORG' => $this->input->post('FATHER_WORK_ADRESS'),
                'GUARDIAN_TYPE' => 'F',
            );
            $this->utilities->insert('applicant_gurdianinfo', $applicant_father_info);
            // ### applicant mother information ###
            $applicant_mother_info = array(
                'APPLICANT_ID' => $applicant_id,
                'GURDIAN_NAME' => $this->input->post('MOTHER_NAME'),
                'OCCUPATION' => $this->input->post('MOTHER_OCU'),
                'MOBILE_NO' => $this->input->post('MOTHER_PHN'),
                'EMAIL_ADRESS' => $this->input->post('MOTHER_EMAIL'),
                'WORKING_ORG' => $this->input->post('MOTHER_WORK_ADRESS'),
                'GUARDIAN_TYPE' => 'M',
            );
            $this->utilities->insert('applicant_gurdianinfo', $applicant_mother_info);
            // ### applicant mother information ###
            if ($this->input->post('local_emergency_guardian') == 'F') {
                $local_guandian_flag = array(
                    'LOCAL_GUARDIAN_FG' => 1,
                );
                $this->utilities->updateData('applicant_gurdianinfo', $local_guandian_flag, array("APPLICANT_ID" => $applicant_id, "GUARDIAN_TYPE" => 'F',));
            } else if ($this->input->post('local_emergency_guardian') == 'M') {
                $local_guandian_flag = array(
                    'LOCAL_GUARDIAN_FG' => 1,
                );
                $this->utilities->updateData('applicant_gurdianinfo', $local_guandian_flag, array("APPLICANT_ID" => $applicant_id, "GUARDIAN_TYPE" => 'M',));

            } else {
                $applicant_local_guardian_info = array(
                    'APPLICANT_ID' => $applicant_id,
                    'GURDIAN_NAME' => $this->input->post('LOCAL_GAR_NAME'),
                    'GUARDIAN_RELATION' => $this->input->post('LOCAL_GAR_RELATION'),
                    'ADDRESS' => $this->input->post('LOCAL_GAR_ADDRESS'),
                    'MOBILE_NO' => $this->input->post('LOCAL_GAR_PHN'),
                    'GUARDIAN_TYPE' => 'O',
                    'LOCAL_GUARDIAN_FG' => 1,
                );
                $this->utilities->insert('applicant_gurdianinfo', $applicant_local_guardian_info);
            }

            // present and permanet address insertion
            if ($this->input->post('same_as_present') == 'YES') {
                $present_address = array(
                    'APPLICANT_ID' => $applicant_id,
                    'ADRESS_TYPE' => 'PS',
                    'SAS_PSORPR' => 'PS',
                    'VILLAGE_WARD' => $this->input->post('VILLAGE'),
                    'UNION_ID' => $this->input->post('UNION_ID'),
                    'THANA_ID' => $this->input->post('THANA_ID'),
                    'POST_OFFICE_ID' => $this->input->post('POST_OFFICE_ID'),
                    'POLICE_STATION_ID' => $this->input->post('POLICE_STATION_ID'),
                    'DISTRICT_ID' => $this->input->post('DISTRICT_ID'),
                    'DIVISION_ID' => $this->input->post('DIVISION_ID'),
                    'ACTIVE_FLAG' => 1
                );
                $this->utilities->insertData($present_address, 'applicant_adressinfo');
            } else {
                $present_address = array(
                    'APPLICANT_ID' => $applicant_id,
                    'ADRESS_TYPE' => 'PS',
                    'SAS_PSORPR' => '',
                    'VILLAGE_WARD' => $this->input->post('VILLAGE'),
                    'UNION_ID' => $this->input->post('UNION_ID'),
                    'THANA_ID' => $this->input->post('THANA_ID'),
                    'POST_OFFICE_ID' => $this->input->post('POST_OFFICE_ID'),
                    'POLICE_STATION_ID' => $this->input->post('POLICE_STATION_ID'),
                    'DISTRICT_ID' => $this->input->post('DISTRICT_ID'),
                    'DIVISION_ID' => $this->input->post('DIVISION_ID'),
                    'ACTIVE_FLAG' => 1
                );
                $this->utilities->insertData($present_address, 'applicant_adressinfo');

                $permanent_address = array(
                    'APPLICANT_ID' => $applicant_id,
                    'ADRESS_TYPE' => 'PR',
                    'SAS_PSORPR' => '',
                    'VILLAGE_WARD' => $this->input->post('P_VILLAGE'),
                    'UNION_ID' => $this->input->post('P_UNION_ID'),
                    'THANA_ID' => $this->input->post('P_THANA_ID'),
                    'POST_OFFICE_ID' => $this->input->post('P_POST_OFFICE_ID'),
                    'POLICE_STATION_ID' => $this->input->post('P_POLICE_STATION_ID'),
                    'DISTRICT_ID' => $this->input->post('P_DISTRICT_ID'),
                    'DIVISION_ID' => $this->input->post('P_DIVISION_ID'),
                    'ACTIVE_FLAG' => 1
                );
                $this->utilities->insertData($permanent_address, 'applicant_adressinfo');
            }
            //end address insertion

//academic information insertion
            $EXAM_NAME = $this->input->post("EXAM_NAME");
            $PASSING_YEAR = $this->input->post("PASSING_YEAR");
            $BOARD = $this->input->post("BOARD");
            $GROUP = $this->input->post("GROUP");
            $GPA = $this->input->post("GPA");
            $INSTITUTE = $this->input->post("INSTITUTE");
            $GPAWA = $this->input->post("GPAWA");

            foreach ($EXAM_NAME as $key => $value) {
                $applicant_academic_info = array(
                    'APPLICANT_ID' => $applicant_id,
                    'EXAM_DEGREE_ID' => $EXAM_NAME[$key],
                    'PASSING_YEAR' => $PASSING_YEAR[$key],
                    'BOARD' => $BOARD[$key],
                    'MAJOR_GROUP_ID' => $GROUP[$key],
                    'RESULT_GRADE' => $GPA[$key],
                    'RESULT_GRADE_WA' => $GPAWA[$key],
                    'INSTITUTION' => $INSTITUTE[$key]
                );
                $this->utilities->insert('applicant_acadimicinfo', $applicant_academic_info);
            }

            $form_complete_status = array(
                'FF_COM_STATUS' => '1'
            );
            $this->utilities->updateData('applicant_user', $form_complete_status, array('APPLICANT_USER_ID' => $applicant_ses['APPLICANT_USER_ID']));

            redirect('applicant/admissionNotification');
        }


        $this->applicant_portal->display($data);

    }


    function studentModal()
    {
        $STUDENT_ID = $_POST['STUDENT_ID'];
        $data['view_only'] = 'yes';
        $data['student_id'] = $STUDENT_ID;
        $data["students_info"] = $this->student_model->getStudentInfoAll($STUDENT_ID);
        //echo "<pre>"; print_r($data); exit; echo "</pre>";
        echo $this->load->view('student/details_modal_view', $data, true);
    }


    function studentDetails($param_student_id = '')
    {
        if ($param_student_id != '') {
            $student_id = $param_student_id;
        } else {
            $student_id = $this->STUDENT_ID;
        }

        $data['student_id'] = $student_id;
        $data["students_info"] = $this->student_model->getStudentInfoAll($student_id);
        //echo "<pre>"; print_r($data["students_info"]); exit; echo "</pre>";
        $data['content_view_page'] = 'student/details_modal_view';


        if ($this->STUDENT_ID != '') {
            $this->student_portal->display($data);
        } else {
            $this->admin_template->display($data);
        }
    }

    function personalDetails($param_student_id = '')
    {

        if ($param_student_id != '') {
            $student_id = $param_student_id;
        } else {
            $student_id = $this->STUDENT_ID;
        }


        $data['student_id'] = $student_id;
        $data["students_info"] = $this->student_model->getStudentInfoAll($student_id);

        $this->load->view('student/student_personal_information', $data);
    }


    function updateStudentPersonalDetails($param_student_id = '')
    {
        if ($param_student_id != '') {
            $student_id = $param_student_id;

        } else {
            $student_id = $this->STUDENT_ID;
        }

        $data['student_id'] = $student_id;


        if (1) {
            $this->form_validation->set_rules('FULL_NAME_BN', 'Full name BN', 'required');
            $this->form_validation->set_rules('PLACE_OF_BIRTH', 'place', 'required');

            $student_info = $this->student_model->getStudentInfoAll($student_id);

            $data["student_info"] = $this->student_model->getStudentInfoAll($student_id);

            if ($this->form_validation->run() == FALSE) {
                //   echo "false";exit;

                $data['nationality'] = $this->utilities->getAll('country');
                $data['religion'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 3));
                $data['merital_status'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 8));
                $data['blood_group'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 4));

                $this->load->view('student/update_student_personal_information', $data);
            } else {

                require(APPPATH . 'views/common/image_upload/class.upload.php');
                $applicant_photo_name = '';
                $signature_photo_name = '';
                $foo = new Upload($_FILES['photo']);
                if ($foo->uploaded) {
                    // large size image
                    $foo->file_new_name_body = 'photo_' . $student_info->REGISTRATION_NO;
                    $foo->image_border = 1;
                    $foo->file_overwrite = true;
                    //$foo->image_border_color    = '#231F20';
                    $foo->allowed = array('image/*');
                    $foo->Process('upload/student/photo/');
                    if ($foo->processed) {
                        $applicant_photo_name = 'photo_' . $student_info->REGISTRATION_NO . '.' . $foo->file_src_name_ext;
                    } else {
                        echo 'error : ' . $foo->error;
                    }
                }

                $sig_photo = new Upload($_FILES['signature']);
                if ($sig_photo->uploaded) {
                    // large size image
                    $sig_photo->file_new_name_body = 'signature_' . $student_info->REGISTRATION_NO;
                    $sig_photo->image_border = 1;
                    $sig_photo->file_overwrite = true;
                    //$foo->image_border_color    = '#231F20';
                    $sig_photo->allowed = array('image/*');
                    $sig_photo->Process('upload/student/signature/');
                    if ($sig_photo->processed) {
                        $signature_photo_name = 'signature_' . $student_info->REGISTRATION_NO . '.' . $sig_photo->file_src_name_ext;
                    } else {
                        echo 'error : ' . $sig_photo->error;
                    }
                }
                // ### student personal information ###
                $student_info = array(
                    'FULL_NAME_BN' => $this->input->post('FULL_NAME_BN'),
                    'PLACE_OF_BIRTH' => $this->input->post('PLACE_OF_BIRTH'),
                    'BLOOD_GROUP' => $this->input->post('BLOOD_GRP'),
                    'MARITAL_STATUS' => $this->input->post('MARITAL_STATUS'),
                    'NATIONALITY' => $this->input->post('NATIONALITY'),
                    'NATIONAL_ID' => $this->input->post('NATIONAL_ID'),
                    'BIRTH_CERTIFICATE' => $this->input->post('BIRTH_CERTIFICATE'),
                    'RELIGION_ID' => $this->input->post('RELIGION_ID'),


                    'HEIGHT_FEET' => $this->input->post('HEIGHT_FEET'),
                    'HEIGHT_CM' => $this->input->post('HEIGHT_CM'),
                    'WEIGHT_KG' => $this->input->post('WEIGHT_KG'),
                    'WEIGHT_LBS' => $this->input->post('WEIGHT_LBS'),
                );

                //echo "<pre>"; print_r($student_info); exit;

                if ($applicant_photo_name != '') {
                    $student_info['PHOTO'] = $applicant_photo_name;

                }
                if ($signature_photo_name != '') {
                    $student_info['SIGNATURE_PHOTO'] = $signature_photo_name;

                }

                $this->utilities->updateData('student_personal_info', $student_info, array('STUDENT_ID' => $student_id));

                echo $applicant_photo_name;
            }

        } else {

            redirect('applicant/applicantDetails');
        }

    }


    function familyDetails($param_student_id = '')
    {
        if ($param_student_id != '') {
            $student_id = $param_student_id;
        } else {
            $student_id = $this->STUDENT_ID;
        }

        $data['student_id'] = $student_id;

        $data["fathersInfo"] = $this->student_model->getStudentFatherInfo($student_id);
        $data["motherInfo"] = $this->student_model->getStudentMotherInfo($student_id);
        $data["local_guardian"] = $this->student_model->getStudentLocalGuardianInfo($student_id);

        $this->load->view('student/student_family_details', $data);
    }


    function updateStudentFamilyDetails($param_student_id = '')
    {

        if ($param_student_id != '') {
            $student_id = $param_student_id;
        } else {
            $student_id = $this->STUDENT_ID;
        }

        $data['student_id'] = $student_id;

        if (1) {
            $this->form_validation->set_rules('FATHER_NAME', 'Father name', 'required');

            if ($this->form_validation->run() == FALSE) {

                $data['occupation'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 21));
                $data['relation'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 40));

                $data["fathersInfo"] = $this->student_model->getStudentFatherInfo($student_id);
                $data["motherInfo"] = $this->student_model->getStudentMotherInfo($student_id);
                $data["local_guardian"] = $this->student_model->getStudentLocalGuardianInfo($student_id);
                $data["local_Other_guardian"] = $this->student_model->getStudentLocalOtherGuardianInfo($student_id);


                //echo "<pre>"; print_r($data["local_Other_guardian"]); exit;

                $this->load->view('student/update_student_family_information', $data);

            } else {

                // ### student father information ###

                $data["fathersInfo"] = $this->student_model->getStudentFatherInfo($student_id);

                if (!empty($data["fathersInfo"])) {
                    // not empty

                    $student_father_info = array(
                        'STUDENT_ID' => $student_id,
                        'GURDIAN_NAME' => $this->input->post('FATHER_NAME'),
                        'OCCUPATION' => $this->input->post('FATHER_OCU'),
                        'MOBILE_NO' => $this->input->post('FATHER_PHN'),
                        'EMAIL_ADRESS' => $this->input->post('FATHER_EMAIL'),
                        'WORKING_ORG' => $this->input->post('FATHER_WORK_ADRESS'),
                        'GUARDIAN_TYPE' => 'F',
                    );

                    //echo "<pre>"; print_r($student_father_info); exit;

                    $father_id = $this->input->post('APP_FATHER_ID');


                    $this->utilities->updateData('student_gurdianinfo', $student_father_info, array('STU_PARENT_ID' => $father_id));

                } else {

                    // empty

                    $student_father_info = array(
                        'STUDENT_ID' => $student_id,
                        'GURDIAN_NAME' => $this->input->post('FATHER_NAME'),
                        'OCCUPATION' => $this->input->post('FATHER_OCU'),
                        'MOBILE_NO' => $this->input->post('FATHER_PHN'),
                        'EMAIL_ADRESS' => $this->input->post('FATHER_EMAIL'),
                        'WORKING_ORG' => $this->input->post('FATHER_WORK_ADRESS'),
                        'GUARDIAN_TYPE' => 'F',
                    );

                    $this->utilities->insert('student_gurdianinfo', $student_father_info);
                }

                // ## Student Mother Info ##

                $data["motherInfo"] = $this->student_model->getStudentMotherInfo($student_id);

                if (!empty($data["motherInfo"])) {
                    $student_mother_info = array(
                        'STUDENT_ID' => $student_id,
                        'GURDIAN_NAME' => $this->input->post('MOTHER_NAME'),
                        'OCCUPATION' => $this->input->post('MOTHER_OCU'),
                        'MOBILE_NO' => $this->input->post('MOTHER_PHN'),
                        'EMAIL_ADRESS' => $this->input->post('MOTHER_EMAIL'),
                        'WORKING_ORG' => $this->input->post('MOTHER_WORK_ADDRESS'),
                        'GUARDIAN_TYPE' => 'M',
                    );

                    $mother_id = $this->input->post('APP_MOTHER_ID');


                    $this->utilities->updateData('student_gurdianinfo', $student_mother_info, array('STU_PARENT_ID' => $mother_id));
                } else {

                    $student_mother_info = array(
                        'STUDENT_ID' => $student_id,
                        'GURDIAN_NAME' => $this->input->post('MOTHER_NAME'),
                        'OCCUPATION' => $this->input->post('MOTHER_OCU'),
                        'MOBILE_NO' => $this->input->post('MOTHER_PHN'),
                        'EMAIL_ADRESS' => $this->input->post('MOTHER_EMAIL'),
                        'WORKING_ORG' => $this->input->post('MOTHER_WORK_ADDRESS'),
                        'GUARDIAN_TYPE' => 'M',
                    );

                    $this->utilities->insert('student_gurdianinfo', $student_mother_info);
                }

                // ### applicant local guardian information ###
                if ($this->input->post('local_emergency_guardian') == 'F') {
                    $local_guandian_flag = array(
                        'LOCAL_GUARDIAN_FG' => 1,
                    );
                    $local_guandian_remove_flag = array(
                        'LOCAL_GUARDIAN_FG' => 0,
                    );

                    $this->utilities->updateData('STUDENT_gurdianinfo', $local_guandian_remove_flag, array("STUDENT_ID" => $student_id, "LOCAL_GUARDIAN_FG" => 1,));
                    $this->utilities->updateData('STUDENT_gurdianinfo', $local_guandian_flag, array("STUDENT_ID" => $student_id, "GUARDIAN_TYPE" => 'F',));
                    $this->db->delete('STUDENT_gurdianinfo', array("STUDENT_ID" => $student_id, 'GUARDIAN_TYPE' => 'O'));

                } else if ($this->input->post('local_emergency_guardian') == 'M') {
                    $local_guandian_flag = array(
                        'LOCAL_GUARDIAN_FG' => 1,
                    );
                    $local_guandian_remove_flag = array(
                        'LOCAL_GUARDIAN_FG' => 0,
                    );

                    $this->utilities->updateData('STUDENT_gurdianinfo', $local_guandian_remove_flag, array("STUDENT_ID" => $student_id, "LOCAL_GUARDIAN_FG" => 1,));
                    $this->utilities->updateData('STUDENT_gurdianinfo', $local_guandian_flag, array("STUDENT_ID" => $student_id, "GUARDIAN_TYPE" => 'M',));
                    $this->db->delete('STUDENT_gurdianinfo', array("STUDENT_ID" => $student_id, 'GUARDIAN_TYPE' => 'O'));

                } else {

                    if (!empty($data["local_Other_guardian"])) {

                        //echo "Hello"; exit;

                        $applicant_local_guardian_info = array(
                            'STUDENT_ID' => $student_id,
                            'GURDIAN_NAME' => $this->input->post('LOCAL_GAR_NAME'),
                            'GUARDIAN_RELATION' => $this->input->post('LOCAL_GAR_RELATION'),
                            'ADDRESS' => $this->input->post('LOCAL_GAR_ADDRESS'),
                            'MOBILE_NO' => $this->input->post('LOCAL_GAR_PHN'),
                            'GUARDIAN_TYPE' => 'O',
                            'LOCAL_GUARDIAN_FG' => 1,
                        );

                        $local_guandian_remove_flag = array(
                            'LOCAL_GUARDIAN_FG' => 0,
                        );

                        $this->db->delete('STUDENT_gurdianinfo', array("STUDENT_ID" => $student_id, 'GUARDIAN_TYPE' => 'O'));
                        $this->utilities->insert('STUDENT_gurdianinfo', $applicant_local_guardian_info);
                        $this->utilities->updateData('STUDENT_gurdianinfo', $local_guandian_remove_flag, array("STUDENT_ID" => $student_id, "GUARDIAN_TYPE" => 'M',));
                        $this->utilities->updateData('STUDENT_gurdianinfo', $local_guandian_remove_flag, array("STUDENT_ID" => $student_id, "GUARDIAN_TYPE" => 'F',));

                    } else {

                        $applicant_local_guardian_info = array(
                            'STUDENT_ID' => $student_id,
                            'GURDIAN_NAME' => $this->input->post('LOCAL_GAR_NAME'),
                            'GUARDIAN_RELATION' => $this->input->post('LOCAL_GAR_RELATION'),
                            'ADDRESS' => $this->input->post('LOCAL_GAR_ADDRESS'),
                            'MOBILE_NO' => $this->input->post('LOCAL_GAR_PHN'),
                            'GUARDIAN_TYPE' => 'O',
                            'LOCAL_GUARDIAN_FG' => 1,
                        );

                        $local_guandian_remove_flag = array(
                            'LOCAL_GUARDIAN_FG' => 0,
                        );

                        $this->db->delete('STUDENT_gurdianinfo', array("STUDENT_ID" => $student_id, 'GUARDIAN_TYPE' => 'O'));
                        $this->utilities->insert('STUDENT_gurdianinfo', $applicant_local_guardian_info);
                        $this->utilities->updateData('STUDENT_gurdianinfo', $local_guandian_remove_flag, array("STUDENT_ID" => $student_id, "GUARDIAN_TYPE" => 'M',));
                        $this->utilities->updateData('STUDENT_gurdianinfo', $local_guandian_remove_flag, array("STUDENT_ID" => $student_id, "GUARDIAN_TYPE" => 'F',));
                    }

                }

                $this->session->set_flashdata('Success', 'Successfully Updated');
            }
        } else {

            redirect('applicant/applicantDetails');
        }


    }


    public function addressInfo($param_student_id = '')
    {
        if ($param_student_id != '') {
            $student_id = $param_student_id;
        } else {
            $student_id = $this->STUDENT_ID;
        }

        $data['student_id'] = $student_id;

        $data['local_present_adddress'] = $this->student_model->getLocalPresentAddress($student_id);
        $data['local_permanent_adddress'] = $this->student_model->getLocalPermanentAddress($student_id);

        $this->load->view('student/student_address', $data);
    }


    function updateStudentAddressInfo($param_student_id = '')
    {
        if ($param_student_id != '') {
            $student_id = $param_student_id;
        } else {
            $student_id = $this->STUDENT_ID;
        }

        $data['student_id'] = $student_id;

        if (1) {

            $data['local_present_adddress'] = $this->student_model->getLocalPresentAddress($student_id);
            $data['local_permanent_adddress'] = $this->student_model->getLocalPermanentAddress($student_id);

            //echo "<pre>"; echo print_r($data['local_present_adddress']); exit; echo "</pre>";

            $this->form_validation->set_rules('DIVISION_ID', 'Division name', 'required');

            if ($this->form_validation->run() == FALSE) {

                $data['division'] = $this->utilities->getAll('sa_divisions');
                $data['district'] = $this->utilities->getAll('sa_districts');
                $data['thana'] = $this->utilities->getAll('sa_thanas');
                $data['police_station'] = $this->utilities->getAll('sa_police_station');
                $data['ward_no'] = $this->utilities->getAll('sa_unions');
                $data['post_office'] = $this->utilities->getAll('sa_post_offices');

                $this->load->view('student/update_student_address', $data);
            } else {


                if (empty($data['local_present_adddress'])) {

                    /*
                    * Present and Permanent Address Insert
                    */

                    if ($this->input->post('same_as_present') == 'YES') {
                        $present_address = array(
                            'STUDENT_ID' => $student_id,
                            'ADRESS_TYPE' => 'PS',
                            'SAS_PSORPR' => 'PS',
                            'VILLAGE_WARD' => $this->input->post('VILLAGE'),
                            'UNION_ID' => $this->input->post('UNION_ID'),
                            'THANA_ID' => $this->input->post('THANA_ID'),
                            'POST_OFFICE_ID' => $this->input->post('POST_OFFICE_ID'),
                            'POLICE_STATION_ID' => $this->input->post('POLICE_STATION_ID'),
                            'DISTRICT_ID' => $this->input->post('DISTRICT_ID'),
                            'DIVISION_ID' => $this->input->post('DIVISION_ID'),
                            'ACTIVE_FLAG' => 1
                        );

                        $this->utilities->insert('student_adressinfo', $present_address);

                        $this->session->set_flashdata('Success', 'Successfully Updated');

                    } else {
                        $present_address = array(
                            'STUDENT_ID' => $student_id,
                            'ADRESS_TYPE' => 'PS',
                            'SAS_PSORPR' => '',
                            'VILLAGE_WARD' => $this->input->post('VILLAGE'),
                            'UNION_ID' => $this->input->post('UNION_ID'),
                            'THANA_ID' => $this->input->post('THANA_ID'),
                            'POST_OFFICE_ID' => $this->input->post('POST_OFFICE_ID'),
                            'POLICE_STATION_ID' => $this->input->post('POLICE_STATION_ID'),
                            'DISTRICT_ID' => $this->input->post('DISTRICT_ID'),
                            'DIVISION_ID' => $this->input->post('DIVISION_ID'),
                            'ACTIVE_FLAG' => 1
                        );

                        $this->utilities->insert('student_adressinfo', $present_address);

                        $permanent_address = array(
                            'STUDENT_ID' => $student_id,
                            'ADRESS_TYPE' => 'PR',
                            'SAS_PSORPR' => '',
                            'VILLAGE_WARD' => $this->input->post('P_VILLAGE'),
                            'UNION_ID' => $this->input->post('P_UNION_ID'),
                            'THANA_ID' => $this->input->post('P_THANA_ID'),
                            'POST_OFFICE_ID' => $this->input->post('P_POST_OFFICE_ID'),
                            'POLICE_STATION_ID' => $this->input->post('P_POLICE_STATION_ID'),
                            'DISTRICT_ID' => $this->input->post('P_DISTRICT_ID'),
                            'DIVISION_ID' => $this->input->post('P_DIVISION_ID'),
                            'ACTIVE_FLAG' => 1
                        );

                        $this->utilities->insert('student_adressinfo', $permanent_address);
                    }

                    $this->session->set_flashdata('Success', 'Successfully Updated');

                } else {

                    /*
                     * Present and Permanent Address Update
                     */

                    if ($this->input->post('same_as_present') == 'YES') {
                        $present_address = array(
                            //'STUDENT_ID' => $student_id,
                            'ADRESS_TYPE' => 'PS',
                            'SAS_PSORPR' => 'PS',
                            'VILLAGE_WARD' => $this->input->post('VILLAGE'),
                            'UNION_ID' => $this->input->post('UNION_ID'),
                            'THANA_ID' => $this->input->post('THANA_ID'),
                            'POST_OFFICE_ID' => $this->input->post('POST_OFFICE_ID'),
                            'POLICE_STATION_ID' => $this->input->post('POLICE_STATION_ID'),
                            'DISTRICT_ID' => $this->input->post('DISTRICT_ID'),
                            'DIVISION_ID' => $this->input->post('DIVISION_ID'),
                            'ACTIVE_FLAG' => 1
                        );

                        $this->utilities->updateData('student_adressinfo', $present_address, array('STUDENT_ID' => $student_id, 'ADRESS_TYPE' => 'PS'));


                        $this->session->set_flashdata('Success', 'Successfully Updated');

                    } else {
                        $present_address = array(
                            //'STUDENT_ID' => $student_id,
                            'ADRESS_TYPE' => 'PS',
                            'SAS_PSORPR' => '',
                            'VILLAGE_WARD' => $this->input->post('VILLAGE'),
                            'UNION_ID' => $this->input->post('UNION_ID'),
                            'THANA_ID' => $this->input->post('THANA_ID'),
                            'POST_OFFICE_ID' => $this->input->post('POST_OFFICE_ID'),
                            'POLICE_STATION_ID' => $this->input->post('POLICE_STATION_ID'),
                            'DISTRICT_ID' => $this->input->post('DISTRICT_ID'),
                            'DIVISION_ID' => $this->input->post('DIVISION_ID'),
                            'ACTIVE_FLAG' => 1
                        );

                        $this->utilities->updateData('student_adressinfo', $present_address, array('STUDENT_ID' => $student_id, 'ADRESS_TYPE' => 'PS'));


                        if (empty($data['local_permanent_adddress'])) {
                            $permanent_address = array(
                                'STUDENT_ID' => $student_id,
                                'ADRESS_TYPE' => 'PR',
                                'SAS_PSORPR' => '',
                                'VILLAGE_WARD' => $this->input->post('P_VILLAGE'),
                                'UNION_ID' => $this->input->post('P_UNION_ID'),
                                'THANA_ID' => $this->input->post('P_THANA_ID'),
                                'POST_OFFICE_ID' => $this->input->post('P_POST_OFFICE_ID'),
                                'POLICE_STATION_ID' => $this->input->post('P_POLICE_STATION_ID'),
                                'DISTRICT_ID' => $this->input->post('P_DISTRICT_ID'),
                                'DIVISION_ID' => $this->input->post('P_DIVISION_ID'),
                                'ACTIVE_FLAG' => 1
                            );

                            $this->utilities->insert('student_adressinfo', $permanent_address);

                        } else {

                            $permanent_address = array(
                                //'STUDENT_ID' => $student_id,
                                'ADRESS_TYPE' => 'PR',
                                'SAS_PSORPR' => '',
                                'VILLAGE_WARD' => $this->input->post('P_VILLAGE'),
                                'UNION_ID' => $this->input->post('P_UNION_ID'),
                                'THANA_ID' => $this->input->post('P_THANA_ID'),
                                'POST_OFFICE_ID' => $this->input->post('P_POST_OFFICE_ID'),
                                'POLICE_STATION_ID' => $this->input->post('P_POLICE_STATION_ID'),
                                'DISTRICT_ID' => $this->input->post('P_DISTRICT_ID'),
                                'DIVISION_ID' => $this->input->post('P_DIVISION_ID'),
                                'ACTIVE_FLAG' => 1
                            );

                            //echo "<pre>"; print_r($permanent_address); exit;

                            $this->utilities->updateData('student_adressinfo', $permanent_address, array('STUDENT_ID' => $student_id, 'ADRESS_TYPE' => 'PR'));

                            $this->session->set_flashdata('Success', 'Successfully Updated');

                        }

                    }

                }
            }
        } else {

            redirect('student/studentDetails/' . $student_id);
        }

    }


    function academicInfo($param_student_id = '')
    {
        if ($param_student_id != '')
        {
            $student_id = $param_student_id;
        }
        else
        {
            $student_id = $this->STUDENT_ID;
        }

        $data['student_id'] = $student_id;
        $data['academic'] = $this->student_model->getStudentAcademicInfo($student_id);
        //Commons
        $data['exam_name'] = $all_exam_name = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 13));
        $data['division'] = $this->utilities->getAll('sa_divisions');
        $data['nationality'] = $this->utilities->getAll('country');
        $data['extra_activity_type'] = $this->utilities->getAll('extra_activity_type');
        $data['religion'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 3));
        $data['merital_status'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 8));
        $data['blood_group'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 4));
        $data['substance'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 56));
        $data['board_name'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 24));
        $data['group_name'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 25));
        $data['occupation'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 21));
        $data['relation'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 40));
        $data['degree'] = $this->utilities->findAllByAttribute('ins_degree', array('ACTIVE_STATUS' => 1));
        $data['UM_INSTITUTIONS'] = $this->utilities->findAllByAttribute('UM_INSTITUTIONS',array('ACTIVE_STATUS' =>'Y'));
        $this->load->view('student/student_academic_info', $data);
    }


    function updateStudentAcademicInfo($param_student_id = '')
    {
        if ($param_student_id != '') {
            $student_id = $param_student_id;
        } else {
            $student_id = $this->STUDENT_ID;
        }

        $data['student_id'] = $student_id;
        $data['academic'] = $all_academic = $this->student_model->getStudentAcademicInfo($student_id);
        $STUDENT_PERSONAL_INFO = $this->utilities->findByAttribute('STUDENT_PERSONAL_INFO', array('STUDENT_ID' => $student_id));
        //$SKILL_DEV_ELEMENT = $this->utilities->findAllByAttribute('SKILL_DEV_ELEMENT', array('ACTIVE_STATUS' => 'Y'));
        $SKILL_DEV_DIRECTORY = $this->utilities->findAllByAttribute('SKILL_DEV_DIRECTORY',array('ACTIVE_STATUS' =>'Y'));

        //Common
        $data['exam_name'] = $all_exam_name = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 13));
        $data['division'] = $this->utilities->getAll('sa_divisions');
        $data['nationality'] = $this->utilities->getAll('country');
        $data['extra_activity_type'] = $this->utilities->getAll('extra_activity_type');
        $data['religion'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 3));
        $data['merital_status'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 8));
        $data['blood_group'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 4));
        $data['substance'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 56));
        $data['board_name'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 24));
        $data['group_name'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 25));
        $data['occupation'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 21));
        $data['relation'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 40));
        $data['degree'] = $this->utilities->findAllByAttribute('ins_degree', array('ACTIVE_STATUS' => 1));
        $data['UM_INSTITUTIONS'] = $this->utilities->findAllByAttribute('UM_INSTITUTIONS', array('ACTIVE_STATUS' => 'Y'));
        $data['board_name'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 24));
        $data['group_name'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 25));

        $this->form_validation->set_rules('EXAM_NAME[]', 'Exam name', 'required');


        if ($this->form_validation->run() == FALSE) {
            $this->load->view('student/update_student_academic_info', $data);
        } else {
            ini_set('max_execution_time', 0);
            ini_set("memory_limit", -1);
            $this->db->trans_begin();

            //STUDENT_ACADIMICINFO
            //$STUDENT_ACADIMICINFO = $this->utilities->findById('STUDENT_ACADIMICINFO', 'STUDENT_ID', $student_id);
            //academic information insertion
            $EXAM_NAME = $this->input->post("EXAM_NAME");
            $PASSING_YEAR = $this->input->post("PASSING_YEAR");
            $BOARD = $this->input->post("BOARD");
            $GROUP = $this->input->post("GROUP");
            $GPA = $this->input->post("GPA");
            $INSTITUTE = $this->input->post("INSTITUTE");
            $GPAWA = $this->input->post("GPAWA");

            $ij = 1;
            foreach ($all_academic as $key1 => $row1) {
                $student_academic_info = array(
                    'EXAM_DEGREE_ID' => $EXAM_NAME[$ij],
                    'PASSING_YEAR' => $PASSING_YEAR[$ij],
                    'BOARD' => $BOARD[$ij],
                    'MAJOR_GROUP_ID' => $GROUP[$ij],
                    'RESULT_GRADE' => $GPA[$ij],
                    'RESULT_GRADE_WA' => $GPAWA[$ij],
                    'INSTITUTION' => $INSTITUTE[$ij]
                );

                //Start Certificate update
                $applicant_certificate_path = '';
                $upload_path = '';
                $file_name = '';
                $SD_ID = '';
                $ELEMENT_EXT = '';
                $APPLICANT_ID = $STUDENT_PERSONAL_INFO->APPLICANT_ID;
                if (!empty($_FILES['CERTIFICATE']['name'][$ij])) {
                    $_FILES['file_cer']['name'] = $_FILES['CERTIFICATE']['name'][$ij];
                    $_FILES['file_cer']['type'] = $_FILES['CERTIFICATE']['type'][$ij];
                    $_FILES['file_cer']['tmp_name'] = $_FILES['CERTIFICATE']['tmp_name'][$ij];
                    $_FILES['file_cer']['error'] = $_FILES['CERTIFICATE']['error'][$ij];
                    $_FILES['file_cer']['size'] = $_FILES['CERTIFICATE']['size'][$ij];

                    $file_ext4 = pathinfo($_FILES['file_cer']['name'], PATHINFO_EXTENSION);

                    //Setting Path and File name
                    /*foreach ($SKILL_DEV_ELEMENT as $keyy => $row2) {
                        if (($EXAM_NAME[$ij] == '27' || $EXAM_NAME[$ij] == '181') && $row2->SD_ID == '81') //SSC or O-level
                        {
                            $upload_path = $row2->DIRECTORY_PATH;
                            $file_name = $STUDENT_PERSONAL_INFO->REGISTRATION_NO . "_ssc";
                            $SD_ID = $row2->SD_ID;
                            break;
                        } else if (($EXAM_NAME[$ij] == '28' || $EXAM_NAME[$ij] == '182') && $row2->SD_ID == '82') //HSC or A-level
                        {
                            $upload_path = $row2->DIRECTORY_PATH;
                            $file_name = $STUDENT_PERSONAL_INFO->REGISTRATION_NO . "_hsc";
                            $SD_ID = $row2->SD_ID;
                            break;
                        } else if ($EXAM_NAME[$ij] == "249" && $row2->SD_ID == '83')//MBBS
                        {
                            $upload_path = $row2->DIRECTORY_PATH;
                            $file_name = $STUDENT_PERSONAL_INFO->REGISTRATION_NO . "_mbbs";
                            $SD_ID = $row2->SD_ID;
                            break;
                        } else if ($EXAM_NAME[$ij] == "381" && $row2->SD_ID == '84')//POST-GRADUATE
                        {
                            $upload_path = $row2->DIRECTORY_PATH;
                            $file_name = $STUDENT_PERSONAL_INFO->REGISTRATION_NO . "_post_graduate";
                            $SD_ID = $row2->SD_ID;
                            break;
                        }
                    }*/

                    foreach ($SKILL_DEV_DIRECTORY as $keyy=>$row2)
                    {
                        if(($EXAM_NAME[$ij]=='27' || $EXAM_NAME[$ij]=='181') && $row2->SD_ID=='81') //SSC or O-level
                        {
                            $upload_path = $row2->DIRECTORY_PATH;
                            $file_name = $row1->ADM_ROLL_NO."_ssc";
                            $SD_ID=$row2->SD_ID;
                            break;
                        }
                        else if(($EXAM_NAME[$ij]=='28' || $EXAM_NAME[$ij]=='182') && $row2->SD_ID=='82') //HSC or A-level
                        {
                            $upload_path = $row2->DIRECTORY_PATH;
                            $file_name = $row1->ADM_ROLL_NO."_hsc";
                            $SD_ID=$row2->SD_ID;
                            break;
                        }
                        else if($EXAM_NAME[$ij]=="249" && $row2->SD_ID=='83')//MBBS
                        {
                            $upload_path = $row2->DIRECTORY_PATH;
                            $file_name = $row1->ADM_ROLL_NO."_mbbs";
                            $SD_ID=$row2->SD_ID;
                            break;
                        }
                        else if($EXAM_NAME[$ij]=="381" && $row2->SD_ID=='84')//POST-GRADUATE
                        {
                            $upload_path = $row2->DIRECTORY_PATH;
                            $file_name = $row1->ADM_ROLL_NO."_post_graduate";
                            $SD_ID=$row2->SD_ID;
                            break;
                        }
                    }

                    // File upload configuration
                    $config4['upload_path'] = $upload_path; //upload/applicant/docs/
                    is_file($config4['upload_path']) ? chmod($config4['upload_path'], 0755) : ''; //Upload permission
                    $config4['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
                    $config4['file_name'] = $file_name . '.' . $file_ext4;

                    // Load and initialize upload library
                    $this->upload->initialize($config4);

                    // Upload file to server
                    if ($this->upload->do_upload('file_cer')) {
                        // Uploaded file data
                        $fileData2 = $this->upload->data();
                        //$applicant_certificate_path = $fileData2['file_name'];
                        $applicant_certificate_path = $file_name;
                        $ELEMENT_EXT = $file_ext4;
                    }
                }

                //Unlink Previous Certificate
                if (!empty($applicant_certificate_path)) {
                    if(file_exists($upload_path . $applicant_certificate_path . '.' . $ELEMENT_EXT))
                    {
                        unlink($upload_path . $applicant_certificate_path . '.' . $ELEMENT_EXT);
                    }
                }

                $cer_info['ELEMENT_TITLE'] = $applicant_certificate_path;
                $cer_info['ELEMENT_URL'] = $applicant_certificate_path;
                $cer_info['ELEMENT_EXT'] = $ELEMENT_EXT;
                $cer_info['SD_ID'] = $SD_ID;
                $cer_info['CRE_BY'] = $student_id;
                $cer_info['CRE_DT'] = date("Y-m-d G:i:s");
                die(var_dump($upload_path));
                //Applicant Certificate Info Update
                $resss = $this->utilities->update2('SKILL_DEV_ELEMENT', array("SD_ID" => $SD_ID, "APPLICANT_ID" => $APPLICANT_ID), $cer_info);
                //End Certificate Update

                //Applicant Academic info
                //$this->utilities->update2('STUDENT_ACADIMICINFO', array("STU_AI_ID" => ($row1->STU_AI_ID), "STUDENT_ID" => $student_id), $student_academic_info);
                $this->db->query("
                    UPDATE STUDENT_ACADIMICINFO SET EXAM_DEGREE_ID = '$EXAM_NAME[$ij]', PASSING_YEAR = '$PASSING_YEAR[$ij]', BOARD = '$BOARD[$ij]', MAJOR_GROUP_ID = '$GROUP[$ij]', RESULT_GRADE = '$GPA[$ij]', RESULT_GRADE_WA = '$GPAWA[$ij]', INSTITUTION = '$INSTITUTE[$ij]' WHERE STU_AI_ID = '$row1->STU_AI_ID' AND STUDENT_ID = '$student_id'
                ");

                $ij++;
            }


            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('Error', 'Error! Record not updated successfully.');
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('Success', 'Success! Record updated successfully.');
            }
            redirect('applicant/applicantDetails');
        }
    }


    function otherDetailsInfo($param_student_id = '')
    {
        if ($param_student_id != '') {
            $student_id = $param_student_id;
        } else {
            $student_id = $this->STUDENT_ID;
        }


        $data['student_id'] = $student_id;
        $data["applicant_info"] = $this->student_model->getStudentInfoAll($student_id);

        $this->load->view('student/student_others_info', $data);
    }

    function instituteInfo($param_student_id = '')
    {
        if ($param_student_id != '') {
            $student_id = $param_student_id;
        } else {
            $student_id = $this->STUDENT_ID;
        }

        $data['student_id'] = $student_id;
        $data["students_info"] = $this->student_model->getStudentInfoAll($student_id);

        //echo "<pre>"; print_r($data["students_info"]); exit;

        $this->load->view('student/student_institute_info', $data);
    }


    function updateInstituteInfo($param_student_id = '')
    {
        if ($param_student_id != '') {
            $student_id = $param_student_id;

        } else {
            $student_id = $this->STUDENT_ID;
        }

        $data['student_id'] = $student_id;

        if (1) {

            $this->form_validation->set_rules('ADM_SESSION_ID', 'Admission Session ', 'required');

            $data["students_info"] = $this->student_model->getStudentInfoAll($student_id);

            if ($this->form_validation->run() == FALSE) {

                $data["session"] = $this->utilities->admissionSessionList();
                $data["ins_session"] = $this->utilities->academicSessionList();

                $data['program'] = $this->utilities->getAll('ins_program');
                $data['batch'] = $this->db->query("SELECT a.BATCH_TITLE,a.BATCH_ID FROM aca_batch a;")->result();
                $data['section'] = $this->db->query("SELECT a.SECTION_ID,a.NAME FROM aca_section a;")->result();


                $this->load->view('student/update_student_institute_info', $data);

            } else {

                // ### student institute information ###

                $program_details = $this->db->get_where('ins_program', array('PROGRAM_ID' => $this->input->post('PROGRAM_ID')))->row();

                $institute_info = array(
                    'ADM_SESSION_ID' => $this->input->post('ADM_SESSION_ID'),
                    'SESSION_ID' => $this->input->post('INS_SESSION_ID'),
                    'PROGRAM_ID' => $this->input->post('PROGRAM_ID'),
                    'BATCH_ID' => $this->input->post('BATCH_ID'),
                    'SECTION_ID' => $this->input->post('SECTION_ID'),

                    'FACULTY_ID' => $program_details->FACULTY_ID,
                    'DEGREE_ID' => $program_details->DEGREE_ID,
                    'DEPT_ID' => $program_details->DEPT_ID,
                );

                $this->utilities->updateData('student_personal_info', $institute_info, array('STUDENT_ID' => $student_id));
            }

        } else {

            redirect('applicant/applicantDetails');
        }

    }


    function waiverInfo($param_student_id = '')
    {
        if ($param_student_id != '') {
            $student_id = $param_student_id;
        } else {
            $student_id = $this->STUDENT_ID;
        }

        $data['student_id'] = $student_id;
        $data['student_info'] = $this->student_model->getStudentAllWaiverInfo($student_id);

        //echo "<pre>"; print_r($data['student_info']); exit;

        $this->load->view('student/student_waiver_info', $data);
    }

    function updateWaiverInfo($param_student_id = '', $stu_waiver_id = '')
    {
        if ($param_student_id != '') {
            $student_id = $param_student_id;
        } else {
            $student_id = $this->STUDENT_ID;
        }

        $data['student_id'] = $student_id;

        if (1) {

            $data["ins_session"] = $this->utilities->academicSessionList();
            $data["student_waiver_info"] = $this->student_model->getStudentWaiverInfo($student_id, $stu_waiver_id);

            $data["waiver_type"] = $this->db->get('waiver_view')->result();

            //echo "<pre>"; print_r($data["waiver_type"]); exit;

            $this->form_validation->set_rules('SESSION_ID', 'Session', 'required');

            if ($this->form_validation->run() == FALSE) {

                $this->load->view('student/update_waiver_info', $data);
            } else {

                $STU_WAIVER_ID = $this->input->post('stu_waiver_id');

                $student_waiver_info = array(
                    'STUDENT_ID' => $student_id,
                    'SESSION_ID' => $this->input->post('SESSION_ID'),
                    'WAIVER_TYPE' => $this->input->post('WAIVER_ID'),
                    'PERCENTAGE' => $this->input->post('PERCENTAGE'),
                    'ACTIVE_STATUS' => $this->input->post('is_active')
                );

                $inactive_status_all = array(
                    'ACTIVE_STATUS' => ''
                );

                //echo "<pre>"; print_r($student_waiver_info); exit;

                $this->utilities->updateData('student_waiver_info', $inactive_status_all, array('STUDENT_ID' => $student_id));
                $this->utilities->updateData('student_waiver_info', $student_waiver_info, array('STUDENT_ID' => $student_id, 'STU_WAIVER_ID' => $STU_WAIVER_ID));

            }

        } else {

            redirect('applicant/applicantDetails');
        }
    }

    function addWaiverInfo($param_student_id = '')
    {
        if ($param_student_id != '') {
            $student_id = $param_student_id;
        } else {
            $student_id = $this->STUDENT_ID;
        }

        $data['student_id'] = $student_id;

        if (1) {

            //$data["ins_session"] = $this->student_model->getAllSessionByStudentId($student_id);

            $data["ins_session"] = $this->utilities->academicSessionList();
            $data["student_waiver_info"] = $this->student_model->getStudentWaiverInfo($student_id);

            $data["waiver_type"] = $this->db->get('waiver_view')->result();

            //echo "<pre>"; print_r($data["waiver_type"]); exit;

            $this->form_validation->set_rules('SESSION_ID', 'Session', 'required');

            if ($this->form_validation->run() == FALSE) {

                $this->load->view('student/add_waiver_info', $data);
            } else {

                $student_waiver_info = array(
                    'STUDENT_ID' => $student_id,
                    'SESSION_ID' => $this->input->post('SESSION_ID'),
                    'WAIVER_TYPE' => $this->input->post('WAIVER_ID'),
                    'PERCENTAGE' => $this->input->post('PERCENTAGE'),
                    'ACTIVE_STATUS' => $this->input->post('is_active')
                );


                $this->utilities->insert('student_waiver_info', $student_waiver_info);
                //$this->utilities->updateData('student_waiver_info', $student_waiver_info, array('STUDENT_ID' => $student_id));
                $this->session->set_flashdata('Success', 'Successfully Updated');
            }

        } else {

            redirect('applicant/applicantDetails');
        }
    }


    function updateStudentOtherDetailsInfo($param_student_id = '')
    {
        if ($param_student_id != '') {
            $student_id = $param_student_id;
        } else {
            $student_id = $this->STUDENT_ID;
        }

        $data['student_id'] = $student_id;

        if (1) {
            $data['student_id'] = $student_id;

            $data["applicant_info"] = $this->student_model->getStudentInfoAll($student_id);

            $this->form_validation->set_rules('ANNUAL_INCOME', 'Annual Income', 'required');

            if ($this->form_validation->run() == FALSE) {

                $this->load->view('student/update_student_others_info', $data);
            } else {

                $student_other_info = array(

                    'ANNUAL_INCOME' => $this->input->post('ANNUAL_INCOME'),
                    'SCHOLARSHIP' => $this->input->post('SCHOLARSHIP'),
                    'SCHOLARSHIP_DESC' => $this->input->post('SCHOLARSHIP_DESC'),
                    'EXPELLED' => $this->input->post('EXPELLED'),
                    'EXPELLED_DESC' => $this->input->post('EXPELLED_DESC'),
                    'ARRESTED' => $this->input->post('ARRESTED'),
                    'ARRESTED_DESC' => $this->input->post('ARRESTED_DESC'),
                    'CONVICTED' => $this->input->post('CONVICTED'),
                    'CONVICTED_DESC' => $this->input->post('CONVICTED_DESC'),
                    'APPLY_BEFORE' => $this->input->post('APPLY_BEFORE'),
                    'APPLY_SEMESTER' => $this->input->post('APPLY_SEMESTER'),
                    'APPLY_YEAR' => $this->input->post('APPLY_YEAR'),
                    'SIBLING_EXIST' => $this->input->post('SIBLING_EXIST'),
                    'SBLN_ROLL_NO' => $this->input->post('SBLN_ROLL_NO'),
                );

                $this->utilities->updateData('student_personal_info', $student_other_info, array('STUDENT_ID' => $student_id));
                $this->session->set_flashdata('Success', 'Successfully Updated');
            }

        } else {

            redirect('applicant/applicantDetails');
        }

    }


    /**
     * @methodName
     * @access
     * @param
     * @author  Abhijit Monal Abhi <abhijit@atilimited.net>
     * @return  none
     */

    function studentCurriculum()
    {
        $student_id = $this->STUDENT_ID;
        $students_info = $this->student_model->getStudentInfoAll($student_id);

        $session = $students_info->SESSION_ID;

        if (!empty($session)) {
            $data['session_name'] = $this->utilities->academicSessionById($session);
        } else {

            $data['session_name'] = 'empty';
        }

        $data["session"] = $session;
        $program = $students_info->PROGRAM_ID;
        //$OfferType = $offered_type;
        //$data['flag'] = $_POST['flag'];
        $data['courseCat'] = $this->utilities->getAll("aca_course_category");
        $data["program"] = $program;
        $data["offerType"] = 'F';
        $data["semester"] = $this->utilities->getAll("sav_semester");

        $data['content_view_page'] = 'student/course_curriculum/student_course_curriculum';
        $this->student_portal->display($data);

    }

    function assignments()
    {
        $student_id = $this->STUDENT_ID;
        $students_info = $this->student_model->getStudentInfoAll($student_id);

        $session = $students_info->SESSION_ID;

        if (!empty($session)) {
            $data['session_name'] = $this->utilities->academicSessionById($session);
        } else {

            $data['session_name'] = 'empty';
        }

        $data['UMS_ASSIGNMENTS_FUTURE']=$this->student_model->assignmentsByLeftJoin();
        $data['UMS_ASSIGNMENTS_PREVIOUS']=$this->utilities->findAllByAttribute('UMS_ASSIGNMENTS', array('ACTIVE_STATUS'=>'Y', 'SUBMISSION_DT<'=>date('Y-m-d')));
        $data['UMS_ASSIGNMENTS']=$this->utilities->findAllByAttribute('UMS_ASSIGNMENTS', array('ACTIVE_STATUS'=>'Y'));
        //$data['UMS_STUDENT_ASSIGNMENT']=$this->utilities->findAll('UMS_STUDENT_ASSIGNMENT');
        //die(var_dump($data['UMS_ASSIGNMENTS_FUTURE']));
        $data["session"] = $session;
        $program = $students_info->PROGRAM_ID;
        //$OfferType = $offered_type;
        //$data['flag'] = $_POST['flag'];
        $data['courseCat'] = $this->utilities->getAll("aca_course_category");
        $data["program"] = $program;
        $data["offerType"] = 'F';
        $data["semester"] = $this->utilities->getAll("sav_semester");
        $data['content_view_page'] = 'student/assignments/assignment_list';

        $this->form_validation->set_rules('ASSIGNMENT_ID','Assignment Name', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->student_portal->display($data);
        }
        else
        {
            $this->db->trans_begin();
            $assi_data['ASSIGNMENT_ID'] = $this->input->post('ASSIGNMENT_ID');
            $assi_data['SUBMISSION_DT'] = date("Y-m-d");
            $assi_data['STUDENT_ID'] = $student_id;
            $assi_data['CRE_BY'] = $student_id;
            $assi_data['CRE_DT'] = date("Y-m-d G:i:s");

            //Start file upload
            $ASSIGNMENT_FILE_PATH = '';
            if(!empty($_FILES['ASSIGNMENT_FILE']['name']))
            {
                $file_ext = pathinfo($_FILES['ASSIGNMENT_FILE']['name'],PATHINFO_EXTENSION);
                $config['upload_path'] = 'upload/assignments/';
                $config['allowed_types'] = 'doc|docx|pdf';
                $config['file_name'] = $student_id.'-'.date('Y-m-d-H-i-s').'.'.$file_ext;

                //initialize configuration
                $this->upload->initialize($config);

                if($this->upload->do_upload('ASSIGNMENT_FILE')){
                    $finfo = $this->upload->data(); //upload the file to the above mentioned path
                    $ASSIGNMENT_FILE_PATH = $finfo['file_name'];
                }
            }
            //End file upload

            $assi_data['ASSIGNMENT_FILE'] = $ASSIGNMENT_FILE_PATH;
            $this->utilities->insert('UMS_STUDENT_ASSIGNMENT', $assi_data);


            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                //$this->session->set_flashdata('Error', 'Error! Data not inserted successfully.');
                echo 'no';
            }
            else
            {
                $this->db->trans_commit();
                //$this->session->set_flashdata('Success', 'Success! Data inserted successfully.');
                echo 'yes';
            }
            exit();
            //redirect('lab_schedule/generate_schedule');
        }
    }

    public function assignment_modal()
    {
        $assignm_id = $_POST['assignm_id'];
        $data['assignm_id'] = $assignm_id;
        $student_id = $this->STUDENT_ID;

        if (!empty($session)) {
            $data['session_name'] = $this->utilities->academicSessionById($session);
        } else {

            $data['session_name'] = 'empty';
        }

        $data['UMS_ASSIGNMENTS_FUTURE']=$this->student_model->assignmentsByLeftJoin();
        $data['UMS_ASSIGNMENTS_PREVIOUS']=$this->utilities->findAllByAttribute('UMS_ASSIGNMENTS', array('ACTIVE_STATUS'=>'Y', 'SUBMISSION_DT<'=>date('Y-m-d')));
        $data['UMS_ASSIGNMENTS']=$this->utilities->findAllByAttribute('UMS_ASSIGNMENTS', array('ACTIVE_STATUS'=>'Y'));


        $data['assignm_id']=$assignm_id?$assignm_id:'';
        $data['UMS_ASSIGNMENTS_DETAILS']=$this->student_model->assignmentsByLeftJoinAssID($assignm_id);
        echo $this->load->view('student/assignments/submit_assignm', $data, true);
    }


    function coursesAndResult()
    {
        $student_id = $this->STUDENT_ID;
        $data["session"] = $this->student_model->getAllSessionByStudentId($student_id);
        $data['content_view_page'] = 'student/courses_and_result/courses_and_result';
        $this->student_portal->display($data);
    }


    /**
     * @methodName
     * @access
     * @param
     * @author      Abhijit Mondal Abhi <abhijit@atilimited.net>
     * @return      none
     */


    function coursesBySemester()
    {
        $student_id = $this->STUDENT_ID;
        $ysession_id = $this->input->post('YSESSION_ID');
        $data['semester_wise_course'] = $this->student_model->getAllCourseByStudentIdAndSessionWise($student_id, $ysession_id);
        $this->load->view('student/courses_and_result/semester_wise_course', $data);
    }


    /**
     * @methodName  studentSemesterCourse()
     * @access
     * @param
     * @author      Emdadul Huq <Emdadul@atilimited.net>
     * @return      none
     */

    function studentSemesterCourse()
    {
        $data['contentTitle'] = "Student's Course";
        $data['pageTitle'] = "Studnet's Registration";
        $data["breadcrumbs"] = array(
            "Student" => "registration",
        );
        $stu_session = $this->session->userdata('stu_logged_in');
        $stu_id = $stu_session["STUDENT_ID"];
        $data['semester'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 16));
        $data['std_current'] = $this->db->query("SELECT DISTINCT aco.OFFER_TYPE, sc.STUDENT_ID, sc.SESSION_ID, sc.SEMISTER_ID, sc.FACULTY_ID, sc.DEPT_ID, sc.STUDENT_ID, sc.PROGRAM_ID, ml.LKP_NAME
            FROM stu_courseinfo sc
            LEFT JOIN aca_course_offer aco on aco.OFFERED_COURSE_ID = sc.OFFERED_COURSE_ID
            LEFT JOIN students_info si on si.STUDENT_ID = sc.STUDENT_ID
            LEFT JOIN m00_lkpdata ml on ml.LKP_ID = sc.SEMISTER_ID
            WHERE si.STUDENT_ID = $stu_id AND sc.IS_CURRENT = 1")->row();

        $data['content_view_page'] = 'student/student_course/index';
        $this->student_portal->display($data);
    }

    function addOfferCourse()
    {

        $stu_session = $this->session->userdata('stu_logged_in');
        $stdId = $stu_session["STUDENT_ID"]; // current session student id
        $reg_period = $_POST['reg_period']; // come from reg_crs_reg_per table
        $faculty = $_POST['faculty'];
        $dept = $_POST['dept'];
        $program = $_POST['program'];
        $semester = $_POST['semester'];
        $session = $_POST['session'];
        $offerType = $_POST['offerType'];
        $courseId = $_POST['chkCourses'];
        $this->db->query("DELETE FROM reg_stu_crs_request WHERE STUDENT_ID = $stdId AND SEMESTER_ID = $semester");
        $check = $this->utilities->findByAttribute("reg_stu_crs_request", array("STUDENT_ID" => $stdId, "SEMESTER_ID" => $semester));
        if (empty($check)) {
            for ($i = 0; $i < count($courseId); $i++) {
                $courseInfo = array(
                    "REG_PERIOD_ID" => $reg_period,
                    "STUDENT_ID" => $stdId,
                    "FACULTY_ID" => $faculty,
                    "DEPT_ID" => $dept,
                    "PROGRAM_ID" => $program,
                    "SESSION_ID" => $session,
                    "SEMESTER_ID" => $semester,
                    "COURSE_ID" => $courseId[$i],
                    "ACTIVE_STATUS" => 1,
                    'CREATED_BY' => 1
                );
                $success = $this->utilities->insertData($courseInfo, 'reg_stu_crs_request');
            }
            if ($success) { // if data inserted successfully
                echo "&nbsp;&nbsp;<span class='btn btn-outline btn-primary btn-sm'>Student's course add successfully &nbsp;<span class='text-primary'> <i class='fa fa-check'></i></span></span>";
            } else { // if data inserted failed
                echo "&nbsp;&nbsp;<span class='btn btn-outline btn-danger btn-sm'>Student's course insert failed &nbsp;<span class='text-primary'> <i class='fa fa-check'></i></span></span>";
            }
        } else {
            echo "&nbsp;&nbsp;<span class='btn btn-outline btn-danger btn-sm'>Student's course Taken Already Exist &nbsp;<span class='text-primary'> <i class='fa fa-warning'></i></span></span>";
        }
    }

    /**
     * @methodName  editExistingStu()
     * @access      public
     * @param
     * @author      Rakib Roni <rakib@atilimited.net>
     * @return      edit existing registration student
     */
    function editExistingStu()
    {
        $stu_session = $this->session->userdata('stu_logged_in');
        $studnet_id = $stu_session["STUDENT_ID"]; // current session student id

        /*  $PROGRAM_ID = $this->db->query("SELECT PROGRAM_ID
                                        FROM stu_semesterinfo
                                        WHERE STUDENT_ID = $studnet_id AND IS_CURRENT = 1")->row()->PROGRAM_ID;*/


                                        $data['contentTitle'] = 'Update Existing Student';
                                        $data["breadcrumbs"] = array(
                                            "Admin" => "admin/index",
                                            "Update Existing Studnet" => '#'
                                        );
                                        $data['pageTitle'] = 'Update Existing Student';
        //start dropdown value
                                        $data['extra_activity_type'] = $this->utilities->getAll('extra_activity_type');
                                        $data['division'] = $this->utilities->getAll('sa_divisions');
                                        $data['district'] = $this->utilities->getAll('sa_districts');
                                        $data['thana'] = $this->utilities->getAll('sa_thanas');
                                        $data['police_station'] = $this->utilities->getAll('sa_police_station');
                                        $data['union'] = $this->utilities->getAll('sa_unions');
                                        $data['post_office'] = $this->utilities->getAll('sa_post_offices');
                                        $data['nationality'] = $this->utilities->getAll('country');
                                        $data['program'] = $this->utilities->getAll('program');
                                        $data['batch'] = $this->utilities->getAll('aca_batch');
                                        $data['religion'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 3));
                                        $data['merital_status'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 8));
                                        $data['blood_group'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 4));
                                        $data['substance'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 56));
                                        $data['exam_name'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 13));
                                        $data['board_name'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 24));
                                        $data['group_name'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 25));
                                        $data['occupation'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 21));
                                        $data['relation'] = $this->utilities->findAllByAttribute('m00_lkpdata', array('GRP_ID' => 40));
                                        $data['session'] = $this->utilities->getAll('session_view');
                                        $data['faculty'] = $this->utilities->findAllByAttribute('faculty', array('ACTIVE_STATUS' => 1));
                                        $data['department'] = $this->utilities->findAllByAttribute('department', array('ACTIVE_STATUS' => 1));
                                        $data['semester'] = $this->utilities->getAll('sav_semester');
        //end drop down value
        // start student existing data
                                        $data['applicant'] = $this->db->query("SELECT a.*,
                                            (SELECT b.BLOODGROUP_NAME FROM sav_bloodgrp b WHERE b.BLOODGROUP_ID = a.BLOOD_GROUP)blood,
                                            (SELECT m.MARITAL_NAME FROM sav_maritals m WHERE m.MARITAL_ID = a.MARITAL_STATUS)marital,
                                            (SELECT n.NICENAME FROM sa_country n WHERE n.ID = a.MARITAL_STATUS)nationality,
                                            (SELECT group_concat(c.CONTACTS) FROM stu_contractinfo c WHERE c.STUDENT_ID = a.STUDENT_ID)contact,
                                            (SELECT r.RELIGION_NAME FROM sav_religion r WHERE r.RELIGION_ID = a.RELIGION_ID)relegion
                                            FROM students_info a WHERE a.STUDENT_ID = '$studnet_id'")->row();

                                        $data['admission'] = $this->db->query("SELECT a.* FROM stu_admissioninfo a WHERE a.STUDENT_ID ='$studnet_id'")->row();
                                        $data["contact"] = $this->utilities->findAllByAttribute('stu_contractinfo', array("STUDENT_ID" => $studnet_id, "CONTACT_TYPE" => 'M'));
                                        $data["email"] = $this->utilities->findAllByAttribute('stu_contractinfo', array("STUDENT_ID" => $studnet_id, "CONTACT_TYPE" => 'E'));
                                        $data["current_academic_info"] = $this->db->query("SELECT a.*,
                                            b.SESSION_NAME,
                                            c.SEMESTER_NAME,
                                            d.FACULTY_NAME,
                                            e.DEPT_NAME,
                                            f.PROGRAM_NAME
                                            FROM stu_semesterinfo a
                                            LEFT JOIN session_view b ON a.SESSION_ID = b.SESSION_ID
                                            LEFT JOIN sav_semester c ON a.SEMESTER_ID = c.SEMESTER_ID
                                            LEFT JOIN faculty d ON a.FACULTY_ID = d.FACULTY_ID
                                            LEFT JOIN department e ON a.DEPT_ID = e.DEPT_ID
                                            LEFT JOIN program f ON a.PROGRAM_ID = f.PROGRAM_ID
                                            WHERE a.STUDENT_ID = '$studnet_id' AND a.IS_CURRENT='1'")->row();

                                        $data["fathersInfo"] = $this->db->query("SELECT f.* FROM stu_parentinfo f WHERE f.STUDENT_ID = '$studnet_id' and f.PARENTS_TYPE='F'")->row();
                                        $data["motherInfo"] = $this->db->query("SELECT f.* FROM stu_parentinfo f WHERE f.STUDENT_ID = '$studnet_id' and f.PARENTS_TYPE='M'")->row();
                                        $data["father_contact"] = $this->utilities->findAllByAttribute('stu_pgscontract', array("STUDENT_ID" => $studnet_id, "PGSC_TYPE" => 'F', "CONTACT_TYPE" => 'M'));
                                        $data["father_email"] = $this->utilities->findAllByAttribute('stu_pgscontract', array("STUDENT_ID" => $studnet_id, "PGSC_TYPE" => 'F', "CONTACT_TYPE" => 'E'));

                                        $data["mother_contact"] = $this->utilities->findAllByAttribute('stu_pgscontract', array("STUDENT_ID" => $studnet_id, "PGSC_TYPE" => 'M', "CONTACT_TYPE" => 'M'));
                                        $data["mother_email"] = $this->utilities->findAllByAttribute('stu_pgscontract', array("STUDENT_ID" => $studnet_id, "PGSC_TYPE" => 'M', "CONTACT_TYPE" => 'E'));

                                        $data["addrInfo"] = $this->db->query("SELECT a.STU_ADRESS_ID,a.STUDENT_ID, a.ADRESS_TYPE, a.SAS_PSORPR, a.HOUSE_NO_NAME, a.ROAD_AVENO_NAME, a.VILLAGE_WARD, a.DISTRICT_ID, a.DIVISION_ID, a.POLICE_STATION_ID, a.POST_OFFICE_ID, a.THANA_ID, a.UNION_ID,
                                            (SELECT b.DIVISION_ENAME FROM sa_divisions b WHERE b.DIVISION_ID = a.DIVISION_ID)DIVIS_NAME,
                                            (SELECT d.DISTRICT_ENAME FROM sa_districts d WHERE d.DISTRICT_ID = a.DISTRICT_ID)DIST_NAME,
                                            (SELECT p.PS_ENAME FROM sa_police_station p WHERE p.POLICE_STATION_ID = a.POLICE_STATION_ID)PLOSC,
                                            (SELECT po.POST_OFFICE_ENAME FROM sa_post_offices po WHERE po.POST_OFFICE_ID = a.POST_OFFICE_ID)POSTO,
                                            (SELECT t.THANA_ENAME FROM sa_thanas t WHERE t.THANA_ID = a.THANA_ID)thn,
                                            (SELECT u.UNION_NAME FROM sa_unions u WHERE u.UNION_ID = a.UNION_ID)uni FROM stu_adressinfo a WHERE a.STUDENT_ID = '$studnet_id' AND a.ADRESS_TYPE = 'PS'")->row();

                                        $data["parAddrInfo"] = $this->db->query("SELECT a.STU_ADRESS_ID,a.STUDENT_ID, a.ADRESS_TYPE, a.SAS_PSORPR, a.HOUSE_NO_NAME, a.ROAD_AVENO_NAME, a.VILLAGE_WARD, a.DISTRICT_ID, a.DIVISION_ID, a.POLICE_STATION_ID, a.POST_OFFICE_ID, a.THANA_ID, a.UNION_ID,
                                            (SELECT b.DIVISION_ENAME FROM sa_divisions b WHERE b.DIVISION_ID = a.DIVISION_ID)DIVIS_NAME,
                                            (SELECT d.DISTRICT_ENAME FROM sa_districts d WHERE d.DISTRICT_ID = a.DISTRICT_ID)DIST_NAME,
                                            (SELECT p.PS_ENAME FROM sa_police_station p WHERE p.POLICE_STATION_ID = a.POLICE_STATION_ID)PLOSC,
                                            (SELECT po.POST_OFFICE_ENAME FROM sa_post_offices po WHERE po.POST_OFFICE_ID = a.POST_OFFICE_ID)POSTO,
                                            (SELECT t.THANA_ENAME FROM sa_thanas t WHERE t.THANA_ID = a.THANA_ID)thn,
                                            (SELECT u.UNION_NAME FROM sa_unions u WHERE u.UNION_ID = a.UNION_ID)uni FROM stu_adressinfo a WHERE a.STUDENT_ID = '$studnet_id' AND a.ADRESS_TYPE != 'PS'")->row();

        //$data['guardianInfo'] = $this->db->query("SELECT g.* FROM stu_guardians g WHERE g.STUDENT_ID = '$studnet_id' ")->row();

                                        $data['guardian_contact'] = $this->utilities->findAllByAttribute('stu_pgscontract', array("STUDENT_ID" => $studnet_id, "PGSC_TYPE" => 'E'));

                                        $data['spouse'] = $this->db->query("SELECT s.SFULL_NAME,s.MARRIAGE_DT,s.EMAIL_ADRESS,
                                            (SELECT r.RELATION_NAME FROM sav_relation r WHERE r.RELATION_ID = s.RELATION_ID)relation FROM stu_spouseinfo s WHERE s.STUDENT_ID = '$studnet_id'")->row();

                                        $data['academic'] = $this->db->query("SELECT a.* FROM stu_acadimicinfo a WHERE a.STUDENT_ID ='$studnet_id' ")->result();

                                        $data['medical'] = $this->db->query("SELECT m.STU_MEDI_ID, m.SUBSTANCE,m.CURRENTLY_USED, m.PREVIOUSLY_USED, m.TYPE_AMOUNT_FREQUENCY, m.DURATION, m.STOP_DT,
                                            (SELECT s.SUBSTANCES_NAME FROM sav_substances s WHERE s.SUBSTANCES_ID = m.SUBSTANCE)substances FROM stu_medicalinfo m WHERE m.STUDENT_ID = '$studnet_id'")->result();

                                        $data['disease'] = $this->db->query("SELECT d.STU_DISEASE_ID,d.DISEASE_NAME, d.START_DT, d.END_DT, d.DOCTOR_NAME FROM stu_diseaseinfo d WHERE d.STUDENT_ID = '$studnet_id'")->result();

                                        $data['waiver'] = $this->db->query("SELECT w.* FROM stu_weaverinfo w WHERE w.STUDENT_ID = '$studnet_id'")->row();
                                        $data['sibling'] = $this->db->query("SELECT s.* FROM stu_siblings s WHERE s.STUDENT_ID = '$studnet_id'")->row();
                                        $data['extra_activity'] = $this->db->query("select a.*,b.ACTIVITY_NAME from stu_extra_activities a
                                            left join extra_activity_type b  on a.ACTIVITY_TYPE_ID = b.ACTIVITY_TYPE_ID
                                            where a.STUDENT_ID='$studnet_id'")->result();
        // end student existing data
                                        $data['content_view_page'] = 'student/student_profile/edit_student_profile';
                                        $this->student_portal->display($data);
                                    }

    /**
     * @methodName  updateExistingStu()
     * @access      public
     * @param
     * @author      Rakib Roni <rakib@atilimited.net>
     * @return      udpate existing student information.
     */
    function updateExistingStu($stu_id)
    {
        $file_name = "";
        /* if (!empty($_FILES)) {
             $this->load->library('upload');
             $this->load->helper('string');
             $config['upload_path'] = 'upload/existing_studnet_photo/';
             $config['allowed_types'] = 'gif|jpg|jpeg|png';
             $config['overwrite'] = false;
             $config['remove_spaces'] = true;
             $this->upload->initialize($config);
             if ($this->upload->do_upload('photo')) {
                 $file_data = $this->upload->data();
                 $file_name = $file_data['file_name'];
             }
         }*/
         require(APPPATH . 'views/common/image_upload/class.upload.php');

         $foo = new Upload($_FILES['photo']);
         if ($foo->uploaded) {
            // large size image
            //$foo->file_new_name_body = 'foo';
            $foo->image_resize = true;
            $foo->image_y = 300;
            $foo->image_x = 280;
            $foo->image_border = 1;
            //$foo->image_border_color    = '#231F20';
            $foo->allowed = array('image/*');
            $foo->Process('upload/existing_studnet_photo/large/');
            if ($foo->processed) {
                $file_name = $foo->file_src_name;
            }

            // medium size image
            //$foo->file_new_name_body = 'foo';
            $foo->image_resize = true;
            $foo->image_y = 135;
            $foo->image_x = 135;
            $foo->image_border = 1;
            // $foo->image_border_color    = '#231F20';
            $foo->allowed = array('image/*');
            $foo->Process('upload/existing_studnet_photo/');
            $foo->processed;
            // thumbs size image
            // $foo->file_new_name_body = 'image_resized';
            $foo->image_resize = true;
            $foo->image_y = 50;
            $foo->image_x = 50;
            $foo->image_border = 1;
            //$foo->image_border_color    = '#231F20';
            $foo->allowed = array('image/*');
            $foo->Process('upload/existing_studnet_photo/thumbs/');
            $foo->processed;

        }
        $update_student_info = array(
            'FULL_NAME_EN' => $this->input->post('FULL_NAME_EN'),
            'FULL_NAME_BN' => $this->input->post('FULL_NAME_BN'),
            'DATH_OF_BIRTH' => date('Y-m-d', strtotime($this->input->post('DATH_OF_BIRTH'))),
            'GENDER' => $this->input->post('GENDER'),
            'RELIGION_ID' => $this->input->post('RELIGION_ID'),
            'NATIONAL_ID' => $this->input->post('NATIONAL_ID'),
            'PLACE_OF_BIRTH' => $this->input->post('PLACE_OF_BIRTH'),
            'NATIONALITY' => $this->input->post('NATIONALITY'),
            'FATHER_NAME' => $this->input->post('FATHER_NAME'),
            'MOTHER_NAME' => $this->input->post('MOTHER_NAME'),
            'MARITAL_STATUS' => $this->input->post('MARITAL_STATUS'),
            'SPOUSE_NAME' => $this->input->post('SPOUSE_NAME'),
            'HEIGHT_FEET' => $this->input->post('HEIGHT_FEET'),
            'HEIGHT_CM' => $this->input->post('HEIGHT_CM'),
            'WEIGHT_KG' => $this->input->post('WEIGHT_KG'),
            'WEIGHT_LBS' => $this->input->post('WEIGHT_LBS'),
            'BLOOD_GROUP' => $this->input->post('BLOOD_GRP'),

            'SSOF_FINANC' => $this->input->post('SSOF_FINANC'),
            'FMLY_INCOME' => $this->input->post('FMLY_INCOME'),
            'PASSPORT_NO' => $this->input->post('PASSPORT_NO'),

            'SIBLING_EXIST' => $this->input->post('SIBLING_EXIST'),
            'HOBBY' => $this->input->post('HOBBY'),
            'BATCH_ID' => $this->input->post('BATCH_ID')
        );

        if ($file_name != "") {
            $update_student_info["STUD_PHOTO"] = $file_name;
        }
        $this->utilities->updateData('students_info', $update_student_info, array('STUDENT_ID' => $stu_id));

        // insert stundent extra curriculm activity
        $ACTIVITY_TYPE_ID = $this->input->post('ACTIVITY_TYPE_ID');
        $DESCRIPTION = $this->input->post('DESCRIPTION');
        if (!empty($ACTIVITY_TYPE_ID)) {
            for ($i = 0; $i < sizeof($ACTIVITY_TYPE_ID); $i++) {
                if ($ACTIVITY_TYPE_ID [$i] != '') {
                    $insert_extra_activity = array(
                        'STU_EXTRA_ACTIVITIES_ID' => $this->utilities->pk_f('stu_extra_activities'),
                        'STUDENT_ID' => $stu_id,
                        'ACTIVITY_TYPE_ID' => $ACTIVITY_TYPE_ID[$i],
                        'DESCRIPTION' => $DESCRIPTION [$i],
                        'ACTIVE_STATUS' => 1
                    );
                    //print_r($insert_extra_activity);exit;
                    $this->utilities->insertData($insert_extra_activity, 'stu_extra_activities');
                }
            }
        }
        // update studnet multiple eamil address
        $EMAIL_ADRESS = $this->input->post('EMAIL_ADRESS');
        $STU_CI_ID = $this->input->post('STU_CI_ID');

        if (!empty($EMAIL_ADRESS)) {
            for ($i = 0; $i < sizeof($EMAIL_ADRESS); $i++) {

                if ($EMAIL_ADRESS[$i] != "") {
                    $email_data = array(
                        'CONTACTS' => $EMAIL_ADRESS [$i]
                    );

                    if ($STU_CI_ID[$i] == "") {
                        $email_data["STU_CI_ID"] = $this->utilities->pk_f('stu_contractinfo');
                        $email_data["STUDENT_ID"] = $stu_id;
                        $email_data["CONTACT_TYPE"] = "E";
                        $email_data["ORG_ID"] = 1;
                        $email_data["DEFAULT_FG"] = 1;
                        $this->utilities->insertData($email_data, 'stu_contractinfo');
                    } else {

                        $this->utilities->updateData('stu_contractinfo', $email_data, array('STU_CI_ID' => $STU_CI_ID[$i]));
                    }
                }
            }
        }
        // update studnet multiple mobile number
        $MOBILE_NO = $this->input->post('MOBILE_NO');
        $STU_CI_ID_M = $this->input->post('STU_CI_ID_M');
        if (!empty($MOBILE_NO)) {
            for ($i = 0; $i < sizeof($MOBILE_NO); $i++) {
                if ($MOBILE_NO[$i] != "") {
                    $mobile_data = array(
                        'CONTACTS' => $MOBILE_NO [$i]
                    );

                    if ($STU_CI_ID_M[$i] == "") {
                        $mobile_data["STU_CI_ID"] = $this->utilities->pk_f('stu_contractinfo');
                        $mobile_data["STUDENT_ID"] = $stu_id;
                        $mobile_data["CONTACT_TYPE"] = "M";
                        $mobile_data["ORG_ID"] = 1;
                        $mobile_data["DEFAULT_FG"] = 1;
                        $this->utilities->insertData($mobile_data, 'stu_contractinfo');
                    } else {

                        $this->utilities->updateData('stu_contractinfo', $mobile_data, array('STU_CI_ID' => $STU_CI_ID_M[$i]));
                    }
                }
            }
        }
        // update father information
        /* $f_file_name = "";
         if (!empty($_FILES)) {
             $this->load->library('upload');
             $this->load->helper('string');
             $configf['upload_path'] = 'upload/existing_studnet_photo/parent/';
             $configf['allowed_types'] = 'gif|jpg|jpeg|png';
             $configf['overwrite'] = false;
             $configf['remove_spaces'] = true;
             $this->upload->initialize($configf);
             if ($this->upload->do_upload('father_photo')) {
                 $file_data = $this->upload->data();
                 $f_file_name = $file_data['file_name'];
             }
         }*/


         $foo = new Upload($_FILES['father_photo']);
         if ($foo->uploaded) {
            // large size image
            //$foo->file_new_name_body = 'foo';
            $foo->image_resize = true;
            $foo->image_y = 300;
            $foo->image_x = 280;
            $foo->image_border = 1;
            //$foo->image_border_color    = '#231F20';
            $foo->allowed = array('image/*');
            $foo->Process('upload/existing_studnet_photo/parent/large/');
            if ($foo->processed) {
                $f_file_name = $foo->file_src_name;
            }

            // medium size image
            //$foo->file_new_name_body = 'foo';
            $foo->image_resize = true;
            $foo->image_y = 135;
            $foo->image_x = 135;
            $foo->image_border = 1;
            // $foo->image_border_color    = '#231F20';
            $foo->allowed = array('image/*');
            $foo->Process('upload/existing_studnet_photo/parent/');
            $foo->processed;
            // thumbs size image
            // $foo->file_new_name_body = 'image_resized';
            $foo->image_resize = true;
            $foo->image_y = 50;
            $foo->image_x = 50;
            $foo->image_border = 1;
            //$foo->image_border_color    = '#231F20';
            $foo->allowed = array('image/*');
            $foo->Process('upload/existing_studnet_photo/parent/thumbs/');
            $foo->processed;

        }
        $STU_PARENT_ID_F = $this->input->post('STU_PARENT_ID_F');
        $fahter_info = array(
            'STUDENT_ID' => $stu_id,
            'PARENTS_TYPE' => 'F',
            'OCCUPATION' => $this->input->post('FATHER_OCU'),
            'ECP_FG' => 0,
            'ORG_ID' => 1,
            'ACTIVE_FLAG' => 1
        );
        if ($f_file_name != "") {
            $fahter_info["PARENT_PHOTO"] = $f_file_name;
        }
        $this->utilities->updateData('stu_parentinfo', $fahter_info, array('STU_PARENT_ID' => $STU_PARENT_ID_F));
        // update father multiple mobile
        $FATHER_PHN = $this->input->post('FATHER_PHN');
        $STU_PGS_ID_F = $this->input->post('STU_PGS_ID_F');

        if (!empty($FATHER_PHN)) {
            for ($i = 0; $i < sizeof($FATHER_PHN); $i++) {

                if ($FATHER_PHN[$i] != "") {
                    $mobile_data_f = array(
                        'CONTACTS' => $FATHER_PHN [$i]
                    );
                    if ($STU_PGS_ID_F[$i] == "") {
                        $mobile_data_f["STU_PGS_ID"] = $this->utilities->pk_f('stu_pgscontract');
                        $mobile_data_f["STUDENT_ID"] = $stu_id;
                        $mobile_data_f["PGSC_TYPE"] = 'F';
                        $mobile_data_f["PGSC_ID"] = $STU_PARENT_ID_F;
                        $mobile_data_f["CONTACT_TYPE"] = 'M';
                        $mobile_data_f["ORG_ID"] = 1;
                        $mobile_data_f["DEFAULT_FG"] = 1;
                        $mobile_data_f["ACTIVE_STATUS"] = 1;
                        $this->utilities->insertData($mobile_data_f, 'stu_pgscontract');
                    } else {
                        $this->utilities->updateData('stu_pgscontract', $mobile_data_f, array('STU_PGS_ID' => $STU_PGS_ID_F[$i]));
                    }
                }
            }
        }

        // update father multiple email
        $FATHER_EMAIL = $this->input->post('FATHER_EMAIL');
        $STU_PGS_ID_FE = $this->input->post('STU_PGS_ID_FE');

        if (!empty($FATHER_EMAIL)) {
            for ($i = 0; $i < sizeof($FATHER_EMAIL); $i++) {
                if ($FATHER_EMAIL[$i] != "") {
                    $eamil_data_f = array(
                        'CONTACTS' => $FATHER_EMAIL [$i]
                    );
                    if ($STU_PGS_ID_FE[$i] == "") {
                        $eamil_data_f["STU_PGS_ID"] = $this->utilities->pk_f('stu_pgscontract');
                        $eamil_data_f["STUDENT_ID"] = $stu_id;
                        $eamil_data_f["PGSC_TYPE"] = 'F';
                        $eamil_data_f["PGSC_ID"] = $STU_PARENT_ID_F;
                        $eamil_data_f["CONTACT_TYPE"] = 'E';
                        $eamil_data_f["ORG_ID"] = 1;
                        $eamil_data_f["DEFAULT_FG"] = 1;
                        $eamil_data_f["ACTIVE_STATUS"] = 1;
                        $this->utilities->insertData($eamil_data_f, 'stu_pgscontract');
                    } else {
                        $this->utilities->updateData('stu_pgscontract', $eamil_data_f, array('STU_PGS_ID' => $STU_PGS_ID_FE[$i]));
                    }
                }
            }
        }
        // update mother information
        $m_file_name = "";
        /*if (!empty($_FILES)) {
            $this->load->library('upload');
            $this->load->helper('string');
            $configm['upload_path'] = 'upload/existing_studnet_photo/parent/';
            $configm['allowed_types'] = 'gif|jpg|jpeg|png';
            $configm['overwrite'] = false;
            $configm['remove_spaces'] = true;
            $this->upload->initialize($configm);
            if ($this->upload->do_upload('mother_photo')) {
                $file_data = $this->upload->data();
                $m_file_name = $file_data['file_name'];
            }
        }*/
        $foo = new Upload($_FILES['mother_photo']);
        if ($foo->uploaded) {
            // large size image

            $foo->image_resize = true;
            $foo->image_y = 300;
            $foo->image_x = 280;
            $foo->image_border = 1;
            //$foo->image_border_color    = '#231F20';
            $foo->allowed = array('image/*');
            $foo->Process('upload/existing_studnet_photo/parent/large/');
            if ($foo->processed) {
                $m_file_name = $foo->file_src_name;
            }

            // medium size image
            //$foo->file_new_name_body = 'foo';
            $foo->image_resize = true;
            $foo->image_y = 135;
            $foo->image_x = 135;
            $foo->image_border = 1;
            // $foo->image_border_color    = '#231F20';
            $foo->allowed = array('image/*');
            $foo->Process('upload/existing_studnet_photo/parent/');
            $foo->processed;
            // thumbs size image
            // $foo->file_new_name_body = 'image_resized';
            $foo->image_resize = true;
            $foo->image_y = 50;
            $foo->image_x = 50;
            $foo->image_border = 1;
            //$foo->image_border_color    = '#231F20';
            $foo->allowed = array('image/*');
            $foo->Process('upload/existing_studnet_photo/parent/thumbs/');
            $foo->processed;

        }
        $STU_PARENT_ID_M = $this->input->post('STU_PARENT_ID_M');
        $mother_info = array(
            'STUDENT_ID' => $stu_id,
            'PARENTS_TYPE' => 'M',
            'OCCUPATION' => $this->input->post('MOTHER_OCU'),
            'ECP_FG' => 0,
            'ORG_ID' => 1,
            'ACTIVE_FLAG' => 1
        );
        if ($m_file_name != "") {
            $mother_info["PARENT_PHOTO"] = $m_file_name;
        }
        $this->utilities->updateData('stu_parentinfo', $mother_info, array('STU_PARENT_ID' => $STU_PARENT_ID_M));
        // update mother multiple mobile
        $MOTHER_PHN = $this->input->post('MOTHER_PHN');
        $STU_PGS_ID_M = $this->input->post('STU_PGS_ID_M');
        if (!empty($MOTHER_PHN)) {
            for ($i = 0; $i < sizeof($MOTHER_PHN); $i++) {

                if ($MOTHER_PHN[$i] != "") {
                    $mobile_data_m = array(
                        'CONTACTS' => $MOTHER_PHN [$i]
                    );
                    if ($STU_PGS_ID_M[$i] == "") {
                        $mobile_data_m["STU_PGS_ID"] = $this->utilities->pk_f('stu_pgscontract');
                        $mobile_data_m["STUDENT_ID"] = $stu_id;
                        $mobile_data_m["PGSC_TYPE"] = 'M';
                        $mobile_data_m["PGSC_ID"] = $STU_PARENT_ID_M;
                        $mobile_data_m["CONTACT_TYPE"] = 'M';
                        $mobile_data_m["ORG_ID"] = 1;
                        $mobile_data_m["DEFAULT_FG"] = 1;
                        $mobile_data_m["ACTIVE_STATUS"] = 1;
                        $this->utilities->insertData($mobile_data_m, 'stu_pgscontract');
                    } else {
                        $this->utilities->updateData('stu_pgscontract', $mobile_data_m, array('STU_PGS_ID' => $STU_PGS_ID_M[$i]));
                    }
                }
            }
        }
        // update mother multiple email
        $MOTHER_EMAIL = $this->input->post('MOTHER_EMAIL');
        $STU_PGS_ID_ME = $this->input->post('STU_PGS_ID_ME');
        if (!empty($MOTHER_EMAIL)) {
            for ($i = 0; $i < sizeof($MOTHER_EMAIL); $i++) {
                if ($MOTHER_EMAIL[$i] != "") {
                    $eamil_data_m = array(
                        'CONTACTS' => $MOTHER_EMAIL [$i]
                    );
                    if ($STU_PGS_ID_ME[$i] == "") {
                        $eamil_data_m["STU_PGS_ID"] = $this->utilities->pk_f('stu_pgscontract');
                        $eamil_data_m["STUDENT_ID"] = $stu_id;
                        $eamil_data_m["PGSC_TYPE"] = 'M';
                        $eamil_data_m["PGSC_ID"] = $STU_PARENT_ID_M;
                        $eamil_data_m["CONTACT_TYPE"] = 'E';
                        $eamil_data_m["ORG_ID"] = 1;
                        $eamil_data_m["DEFAULT_FG"] = 1;
                        $eamil_data_m["ACTIVE_STATUS"] = 1;
                        $this->utilities->insertData($eamil_data_m, 'stu_pgscontract');
                    } else {
                        $this->utilities->updateData('stu_pgscontract', $eamil_data_m, array('STU_PGS_ID' => $STU_PGS_ID_ME[$i]));
                    }
                }
            }
        }
        // present and permanet address insertion
        if ($this->input->post('SAS_PSORPR') == 1) {
            $present_address = array(
                'ADRESS_TYPE' => 'PS',
                'SAS_PSORPR' => 'PS',
                'VILLAGE_WARD' => $this->input->post('VILLAGE'),
                'UNION_ID' => $this->input->post('UNION_ID'),
                'THANA_ID' => $this->input->post('THANA_ID'),
                'POST_OFFICE_ID' => $this->input->post('POST_OFFICE_ID'),
                'POLICE_STATION_ID' => $this->input->post('POLICE_STATION_ID'),
                'DISTRICT_ID' => $this->input->post('DISTRICT_ID'),
                'DIVISION_ID' => $this->input->post('DIVISION_ID'),
                'ACTIVE_FLAG' => 1
            );
            $this->utilities->updateData('stu_adressinfo', $present_address, array('STU_ADRESS_ID' => $this->input->post('STU_ADRESS_ID_PS')));
            $this->utilities->deleteRowByAttribute('stu_adressinfo', array('STU_ADRESS_ID' => $this->input->post('STU_ADRESS_ID_PR'), 'ADRESS_TYPE' => 'PR'));
        } else {

            $present_address = array(
                'STUDENT_ID' => $stu_id,
                'ADRESS_TYPE' => 'PS',
                'SAS_PSORPR' => '',
                'VILLAGE_WARD' => $this->input->post('VILLAGE'),
                'UNION_ID' => $this->input->post('UNION_ID'),
                'THANA_ID' => $this->input->post('THANA_ID'),
                'POST_OFFICE_ID' => $this->input->post('POST_OFFICE_ID'),
                'POLICE_STATION_ID' => $this->input->post('POLICE_STATION_ID'),
                'DISTRICT_ID' => $this->input->post('DISTRICT_ID'),
                'DIVISION_ID' => $this->input->post('DIVISION_ID'),
                'ACTIVE_FLAG' => 1
            );
            $this->utilities->updateData('stu_adressinfo', $present_address, array('STU_ADRESS_ID' => $this->input->post('STU_ADRESS_ID_PS')));
            $u_permanent_address = array(
                'STUDENT_ID' => $stu_id,
                'ADRESS_TYPE' => 'PR',
                'SAS_PSORPR' => '',
                'VILLAGE_WARD' => $this->input->post('P_VILLAGE'),
                'UNION_ID' => $this->input->post('P_UNION_ID'),
                'THANA_ID' => $this->input->post('P_THANA_ID'),
                'POST_OFFICE_ID' => $this->input->post('P_POST_OFFICE_ID'),
                'POLICE_STATION_ID' => $this->input->post('P_POLICE_STATION_ID'),
                'DISTRICT_ID' => $this->input->post('P_DISTRICT_ID'),
                'DIVISION_ID' => $this->input->post('P_DIVISION_ID'),
                'ACTIVE_FLAG' => 1
            );
            // $check=$this->utilities->hasInformationByThisId('stu_contractinfo',array('STU_ADRESS_ID'=>$this->input->post('STU_ADRESS_ID_PR'),'ADRESS_TYPE'=>'PR'));
            if ($this->input->post('STU_ADRESS_ID_PR') != '') {
                $this->utilities->updateData('stu_adressinfo', $u_permanent_address, array('STU_ADRESS_ID' => $this->input->post('STU_ADRESS_ID_PR')));
            } else {
                $permanent_address = array(
                    'STU_ADRESS_ID' => $this->utilities->pk_f('stu_adressinfo'),
                    'STUDENT_ID' => $stu_id,
                    'ADRESS_TYPE' => 'PR',
                    'SAS_PSORPR' => '',
                    'VILLAGE_WARD' => $this->input->post('P_VILLAGE'),
                    'UNION_ID' => $this->input->post('P_UNION_ID'),
                    'THANA_ID' => $this->input->post('P_THANA_ID'),
                    'POST_OFFICE_ID' => $this->input->post('P_POST_OFFICE_ID'),
                    'POLICE_STATION_ID' => $this->input->post('P_POLICE_STATION_ID'),
                    'DISTRICT_ID' => $this->input->post('P_DISTRICT_ID'),
                    'DIVISION_ID' => $this->input->post('P_DIVISION_ID'),
                    'ACTIVE_FLAG' => 1
                );
                $this->utilities->insertData($permanent_address, 'stu_adressinfo');
            }
        }
        //end address insertion
        //start local guardian and emegensy contact person

        $leg = $this->input->post('local_emergency_guardian');

        if ($leg == 'F') {
            $update_f_info = array(
                'ECP_FG' => 1,
            );
            $this->utilities->updateData('stu_parentinfo', $update_f_info, array('STU_PARENT_ID' => $STU_PARENT_ID_F));
            if ($this->input->post('STU_GI_ID_LG') != '') {
                $this->utilities->deleteRowByAttribute('stu_guardians', array('STU_GI_ID' => $this->input->post('STU_GI_ID_LG')));
                $STU_PGS_ID_EP = $this->input->post('STU_PGS_ID_EP');
                for ($i = 0; $i < sizeof($STU_PGS_ID_EP); $i++) {
                    $this->utilities->deleteRowByAttribute('stu_pgscontract', array('STU_PGS_ID' => $STU_PGS_ID_EP[$i]));
                }
            }
        } else if ($leg == 'M') {
            $update_m_info = array(
                'ECP_FG' => 1,
            );
            $this->utilities->updateData('stu_parentinfo', $update_m_info, array('STU_PARENT_ID' => $STU_PARENT_ID_M));
            if ($this->input->post('STU_GI_ID_LG') != '') {
                $this->utilities->deleteRowByAttribute('stu_guardians', array('STU_GI_ID' => $this->input->post('STU_GI_ID_LG')));
                $STU_PGS_ID_EP = $this->input->post('STU_PGS_ID_EP');
                for ($i = 0; $i < sizeof($STU_PGS_ID_EP); $i++) {
                    $this->utilities->deleteRowByAttribute('stu_pgscontract', array('STU_PGS_ID' => $STU_PGS_ID_EP[$i]));
                }
            }
        } else {
            $STU_GI_ID_LG = $this->input->post('STU_GI_ID_LG');
            $local_emergency_guardian = array(
                'GFULL_NAME' => $this->input->post('LOCAL_GAR_NAME'),
                'RELATION_ID' => $this->input->post('LOCAL_GAR_RELATION'),
                'ADDRESS' => $this->input->post('LOCAL_GAR_ADDRESS'),
                'ECP_FG' => 1,
                'ORG_ID' => 1,
                'ACTIVE_FLAG' => 1
            );
            if ($STU_GI_ID_LG) {
                $this->utilities->updateData('stu_guardians', $local_emergency_guardian, array('STU_GI_ID' => $STU_GI_ID_LG));
            } else {
                $new_guardian_id = $this->utilities->pk_f('stu_guardians');
                $insert_local_emergency_guardian = array(
                    'STU_GI_ID' => $new_guardian_id,
                    'STUDENT_ID' => $stu_id,
                    'GFULL_NAME' => $this->input->post('LOCAL_GAR_NAME'),
                    'RELATION_ID' => $this->input->post('LOCAL_GAR_RELATION'),
                    'ADDRESS' => $this->input->post('LOCAL_GAR_ADDRESS'),
                    'ECP_FG' => 1,
                    'ORG_ID' => 1,
                    'ACTIVE_FLAG' => 1
                );
                $this->utilities->insertData($insert_local_emergency_guardian, 'stu_guardians');

                $LOCAL_GAR_PHN = $this->input->post('LOCAL_GAR_PHN');
                $STU_PGS_ID_EP = $this->input->post('STU_PGS_ID_EP');
                if (!empty($LOCAL_GAR_PHN)) {
                    for ($i = 0; $i < sizeof($LOCAL_GAR_PHN); $i++) {
                        if ($LOCAL_GAR_PHN[$i] != "") {
                            $mobile_data_lg = array(
                                'CONTACTS' => $LOCAL_GAR_PHN [$i]
                            );
                            if ($STU_PGS_ID_EP[$i] == "") {
                                $mobile_data_lg["STU_PGS_ID"] = $this->utilities->pk_f('stu_pgscontract');
                                $mobile_data_lg["STUDENT_ID"] = $stu_id;
                                $mobile_data_lg["PGSC_TYPE"] = 'EG';
                                $mobile_data_lg["PGSC_ID"] = $new_guardian_id;
                                $mobile_data_lg["CONTACT_TYPE"] = 'E';
                                $mobile_data_lg["ORG_ID"] = 1;
                                $mobile_data_lg["DEFAULT_FG"] = 1;
                                $mobile_data_lg["ACTIVE_STATUS"] = 1;
                                $this->utilities->insertData($mobile_data_lg, 'stu_pgscontract');
                            } else {

                                $this->utilities->updateData('stu_pgscontract', $mobile_data_lg, array('STU_PGS_ID' => $STU_PGS_ID_EP[$i]));
                            }
                        }
                    }
                }
            }
        }
        //start admission information insertion

        $admission_info = array(
            'STUDENT_ID' => $stu_id,
            'ADMISSION_DATE' => date('Y-m-d', strtotime($this->input->post('ADMISSION_DATE'))),
            'SESSION_ID' => $this->input->post('SESSION'),
            'FACULTY_ID' => $this->input->post('FACULTY'),
            'DEPT_ID' => $this->input->post('DEPT_ID'),
            'PROGRAM_ID' => $this->input->post('PROGRAM_ID'),
            'SEMISTER_ID' => $this->input->post('SEMESTER'),
            'ACTIVE_STATUS' => 1
        );

        $this->utilities->updateData('stu_admissioninfo', $admission_info, array('STU_ADMISSION_ID' => $this->input->post('STU_ADMISSION_ID')));
        //end admission information insertion

        $SUBSTANCE = $this->input->post('SUBSTANCE');
        $CURRENTLY_USED = $this->input->post('CURRENTLY_USED');
        $PREVIOUSLY_USED = $this->input->post('PREVIOUSLY_USED');
        $TYPE_AMOUNT_FREQUENCY = $this->input->post('TYPE_AMOUNT_FREQUENCY');
        $DURATION = $this->input->post('DURATION');
        $STOP_DT = $this->input->post('STOP_DT');
        $STU_MEDI_ID = $this->input->post('STU_MEDI_ID');
        if (!empty($SUBSTANCE)) {
            for ($i = 0; $i < sizeof($SUBSTANCE); $i++) {

                $update_medical_info = array(
                    'STUDENT_ID' => $stu_id,
                    'SUBSTANCE' => $SUBSTANCE[$i],
                    'CURRENTLY_USED' => $CURRENTLY_USED[$i],
                    'PREVIOUSLY_USED' => $PREVIOUSLY_USED[$i],
                    'TYPE_AMOUNT_FREQUENCY' => $TYPE_AMOUNT_FREQUENCY[$i],
                    'DURATION' => $DURATION[$i],
                    'STOP_DT' => ($STOP_DT[$i] != '') ? date('Y-m-d', strtotime($STOP_DT[$i])) : '',
                    'ACTIVE_STATUS' => 1
                );
                //echo "<pre>";print_r($update_medical_info);
                $this->utilities->updateData('stu_medicalinfo', $update_medical_info, array('STU_MEDI_ID' => $STU_MEDI_ID[$i]));
            }
        }
        //end medicle insertion
        //start diseases  insertion

        $DISEASE_NAME = $this->input->post('DISEASE_NAME');
        $START_DT = $this->input->post('START_DT');
        $END_DT = $this->input->post('END_DT');
        $DOCTOR_NAME = $this->input->post('DOCTOR_NAME');

        if (!empty($DISEASE_NAME)) {
            for ($i = 0; $i < sizeof($DISEASE_NAME); $i++) {
                $diseases_pk = $this->utilities->pk_f('stu_diseaseinfo');
                $insert_dises_info = array(
                    'STU_DISEASE_ID' => $diseases_pk,
                    'STUDENT_ID' => $stu_id,
                    'DISEASE_NAME' => $DISEASE_NAME[$i],
                    'START_DT' => date('Y-m-d', strtotime($START_DT[$i])),
                    'END_DT' => date('Y-m-d', strtotime($END_DT[$i])),
                    'DOCTOR_NAME' => $DOCTOR_NAME[$i],
                    'ACTIVE_STATUS' => 1
                );
                $this->utilities->insertData($insert_dises_info, 'stu_diseaseinfo');
            }
        }
        //end diseases insertion
        // academic information insertion
        $COUNTER = $this->input->post('COUNTER');
        $file_name = "";
        $this->load->library('upload');
        $this->load->helper('string');
        $configc['upload_path'] = 'upload/academin_certificate/';
        //$config['allowed_types'] = '*';
        $configc['allowed_types'] = 'gif|jpg|jpeg|png';
        $configc['overwrite'] = false;
        $configc['remove_spaces'] = true;
        //$config['max_size']	= '100';// in KB
        $this->upload->initialize($configc);

        for ($i = 1; $i <= ($COUNTER); $i++) {
            $ac_info_pk = $this->input->post("AC_PK_$i");
            if ($ac_info_pk != "") {
                $ac_pk = $this->utilities->pk_f('stu_acadimicinfo');
                $academic_info_update = array(
                    'EXAM_DEGREE_ID' => $this->input->post('EXAM_NAME_' . $i),
                    'MAJOR_GROUP_ID' => $this->input->post('GROUP_' . $i),
                    'INSTITUTION' => $this->input->post('INSTITUTE_' . $i),
                    'BOARD' => $this->input->post('BOARD_' . $i),
                    'RESULT_GRADE' => $this->input->post('GPA_' . $i),
                    'PASSING_YEAR' => $this->input->post('PASSING_YEAR_' . $i)
                );
                if ($this->upload->do_upload('CERTIFICATE_' . $i)) {
                    $file_data = $this->upload->data();
                    $file_name = $file_data['file_name'];
                    $academic_info_update["ACHIEVEMENT"] = $file_name;
                }
                $this->utilities->updateData('stu_acadimicinfo', $academic_info_update, array('STU_AI_ID' => $ac_info_pk));
            } else {
                if ($this->upload->do_upload('CERTIFICATE_' . $i)) {
                    $file_data = $this->upload->data();
                    $file_name = $file_data['file_name'];
                    $ac_pk = $this->utilities->pk_f('stu_acadimicinfo');
                    $academic_info = array(
                        'STU_AI_ID' => $ac_pk,
                        'STUDENT_ID' => $stu_id,
                        'EXAM_DEGREE_ID' => $this->input->post('EXAM_NAME_' . $i),
                        'MAJOR_GROUP_ID' => $this->input->post('GROUP_' . $i),
                        'INSTITUTION' => $this->input->post('INSTITUTE_' . $i),
                        'BOARD' => $this->input->post('BOARD_' . $i),
                        'RESULT_GRADE' => $this->input->post('GPA_' . $i),
                        'PASSING_YEAR' => $this->input->post('PASSING_YEAR_' . $i),
                        'ACHIEVEMENT' => $file_name,
                        'ACTIVE_FLAG' => 1
                    );
                    $this->utilities->insertData($academic_info, 'stu_acadimicinfo');
                }
            }
        }
        //end academic information insertion
        $previous_course_result = array();
        $faculty = $this->input->post('FACULTY_C');
        $dept = $this->input->post('DEPT_ID_C');
        $program = $this->input->post('PROGRAM_ID_C');
        $semester = $this->input->post('SEMISTER_ID_C');
        $sem_session = $this->input->post('SESSION_ID_C');
        $selected_courses = $this->input->post('COURSE_ID');
        $offered_course_id = $this->input->post('OFFERED_COURSE_ID');


        // preparing ids to be used in "IN()" operator
        $course_ids = implode(",", $selected_courses);
        // delete the other course ids found in the database
        $this->db->query("DELETE FROM stu_courseinfo WHERE STUDENT_ID = '$stu_id' AND FACULTY_ID = $faculty AND DEPT_ID = $dept
          AND PROGRAM_ID = $program AND SEMISTER_ID = $semester AND SEM_SESSION = $sem_session
          AND COURSE_ID NOT IN ($course_ids)");
        // echo "<pre>"; print_r($this->db->last_query()); exit; echo "</pre>";
        // looping the new courses to insert
        for ($i = 0; $i < sizeof($selected_courses); $i++) {
            $check_current_courses = array(
                'STUDENT_ID' => $stu_id,
                'SEM_SESSION' => $sem_session,
                'SESSION_ID' => $this->input->post('SESSION'),
                'SEMISTER_ID' => $semester,
                'FACULTY_ID' => $faculty,
                'DEPT_ID' => $dept,
                'PROGRAM_ID' => $program,
                'COURSE_ID' => $selected_courses[$i],
                'IS_CURRENT' => 1
            );
            // check if course info already exist
            if ($this->utilities->hasInformationByThisId('stu_courseinfo', $check_current_courses) == FALSE) {
                // get the offer course ids from "course_offer" table
                $offered_course = $this->db->query("SELECT c.OFFERED_COURSE_ID FROM aca_course_offer c
                    WHERE c.FACULTY_ID = $faculty AND c.DEPT_ID = $dept AND c.PROGRAM_ID = $program
                    AND c.COURSE_ID = $selected_courses[$i]")->row();
                // Prepare the primary key of the table
                $course_info_pk = $this->utilities->pk_f('stu_courseinfo');
                // preparing student course information data to insert
                $student_current_courses = array(
                    'STU_CRS_ID' => $course_info_pk,
                    'STUDENT_ID' => $stu_id,
                    'OFFERED_COURSE_ID' => $offered_course->OFFERED_COURSE_ID,
                    'SEM_SESSION' => $sem_session,
                    'SESSION_ID' => $this->input->post('SESSION'),
                    'SEMISTER_ID' => $semester,
                    'FACULTY_ID' => $faculty,
                    'DEPT_ID' => $dept,
                    'PROGRAM_ID' => $program,
                    'COURSE_ID' => $selected_courses[$i],
                    'IS_CURRENT' => 1,
                    'ACTIVE_STATUS' => 1
                );
                // insert student course informations
                $this->utilities->insertData($student_current_courses, 'stu_courseinfo');
            }
        }
        $student_semester_info = array(

            'FACULTY_ID' => $faculty,
            'DEPT_ID' => $dept,
            'PROGRAM_ID' => $program,
            'SESSION_ID' => $this->input->post('SESSION'),
            'SEMESTER_ID' => $semester,
            'SEM_SESSION' => $sem_session,
            'BATCH_ID' => $this->input->post('BATCH_ID')
        );
        //$semester_info = $this->utilities->findByAttribute('stu_semesterinfo',$student_semester_info);
        $this->utilities->updateData('stu_semesterinfo', $student_semester_info, array('STUDENT_ID' => $stu_id, 'IS_CURRENT' => 1));


        //start waiver information insertion

        $update_waiver_info = array(
            'PERCENTAGE' => $this->input->post('WEAVER_PERCENTAGE'),
            'REASON' => $this->input->post('WEAVER_REASON'),
            'ACTIVE_STATUS' => 1
        );
        if ($this->input->post('STU_WEAVER_ID') != '') {
            $this->utilities->updateData('stu_weaverinfo', $update_waiver_info, array('STU_WEAVER_ID' => $this->input->post('STU_WEAVER_ID')));
        } else {
            $waiver_pk = $this->utilities->pk_f('stu_weaverinfo');
            $waiver_info = array(
                'STU_WEAVER_ID' => $waiver_pk,
                'STUDENT_ID' => $stu_id,
                'PERCENTAGE' => $this->input->post('WEAVER_PERCENTAGE'),
                'REASON' => $this->input->post('WEAVER_REASON'),
                'ACTIVE_STATUS' => 1
            );
            $this->utilities->insertData($waiver_info, 'stu_weaverinfo');
        }
        //end waiver information insertion
        //start sibling insertion
        if ($this->input->post('SIBLING_EXIST') == 1) {
            $sibling_info = array(
                'SBLN_ROLL_NO' => $this->input->post('SBLN_ROLL_NO'),
                'STUDENT_ID' => $stu_id,
                'ACTIVE_STATUS' => 1
            );
            if ($this->input->post('STU_SBLN_ID') != '') {
                $this->utilities->updateData('stu_siblings', $sibling_info, array('STU_SBLN_ID' => $this->input->post('STU_SBLN_ID')));
            } else {
                $data_sibling_info = array(
                    'STU_SBLN_ID' => $this->utilities->pk_f('stu_siblings'),
                    'STUDENT_ID' => $stu_id,
                    'SBLN_ROLL_NO' => $this->input->post('SBLN_ROLL_NO'),
                    'STUDENT_ID' => $stu_id,
                    'ACTIVE_STATUS' => 1
                );
                $this->utilities->insertData($data_sibling_info, 'stu_siblings');
            }
        } else {
            $this->utilities->deleteRowByAttribute('stu_siblings', array('STU_SBLN_ID' => $this->input->post('STU_SBLN_ID')));
        }
        //end sibling insertion
        //redirect to update student form
        redirect('student/editExistingStu');
    }

    /**
     * @methodName  studentDeposit()
     * @access
     * @param
     * @author      rakib roni <rakbironicse@gmail.com>
     * @return      student deposit for final exam registration
     */
    function studentDepositBtn()
    {
        $data['contentTitle'] = 'Deposit Now';
        $data["breadcrumbs"] = array(
            "Admin" => "admin/index",
            "Deposit Button" => '#'
        );
        $app_policy = $this->db->query("select VALUE_FLAG from app_policy WHERE POLICY_NAME='GLOBAL EXAM'")->row()->VALUE_FLAG;
        if ($app_policy == 1) {
            $data['exam'] = $this->db->query("SELECT *
              FROM exam
              WHERE CURDATE() BETWEEN EX_DT_FROM AND EX_DT_TO AND IS_GLOBAL = 1")->row();
        } else {
            $user_session = $this->session->userdata('stu_logged_in');
            $stu_id = $user_session['STUDENT_ID'];
            $student = $this->db->query("SELECT *
              FROM stu_semesterinfo
              WHERE STUDENT_ID = $stu_id AND IS_CURRENT = 1")->row();

            $data['exam'] = $this->db->query("SELECT a.* FROM exam a
                left join exam_programs b on a.EXAM_ID=b.EXAM_ID
                WHERE CURDATE() BETWEEN a.EX_DT_FROM AND a.EX_DT_TO AND PROGRAM_ID=$student->PROGRAM_ID")->row();
        }
        $data['content_view_page'] = 'student/deposit/deposit_btn';
        $this->student_portal->display($data);
    }

    /**
     * @methodName  studentDeposit()
     * @access
     * @param
     * @author      rakib roni <rakbironicse@gmail.com>
     * @return      student deposit for final exam registration
     */
    function studentDeposit()
    {
        $data['contentTitle'] = 'Deposit';
        $data["breadcrumbs"] = array(
            "Admin" => "admin/index",
            "Deposit" => '#'
        );
        $data['exam_id'] = $this->input->post('exam_id');
        $this->load->view('student/deposit/deposit', $data);
        // $this->student_portal->display($data);
    }

    /**
     * @methodName  studentDeposit()
     * @access
     * @param
     * @author      rakib roni <rakbironicse@gmail.com>
     * @return      student deposit for final exam registration
     */

    function saveStuBankDeposit()
    {
        $user_session = $this->session->userdata('stu_logged_in');
        $stu_id = $user_session['STUDENT_ID'];
        $student = $this->db->query("SELECT *
          FROM stu_semesterinfo
          WHERE STUDENT_ID = $stu_id AND IS_CURRENT = 1")->row();
        $DEPOSITE_NO = $this->input->post('DEPOSITE_NO');
        $check = $this->utilities->hasInformationByThisId("exam_student_deposit", array("DEPOSITE_NO" => $DEPOSITE_NO));
        if (empty($check)) {
            $stu_bank_deposit = array(
                'STUDENT_ID' => $stu_id,
                'SESSION_ID' => $student->SESSION_ID,
                'FACULTY_ID' => $student->FACULTY_ID,
                'DEPT_ID' => $student->DEPT_ID,
                'PROGRAM_ID' => $student->PROGRAM_ID,
                'SEMESTER_ID' => $student->SEMESTER_ID,
                'BATCH_ID' => $student->BATCH_ID,
                'EXAM_ID' => $this->input->post('EXAM_ID')
            );
            if ($EX_APP_ID = $this->utilities->insert('exam_application', $stu_bank_deposit)) {
                $data_dep_app_id = array(
                    'EX_APP_ID' => $EX_APP_ID,
                    'DEPOSITE_NO' => $DEPOSITE_NO
                );
                $this->utilities->insert('exam_student_deposit', $data_dep_app_id);

                $this->session->set_flashdata('Success', 'Congratulation ! Bank Deposit successfully.');
            } else {

                $this->session->set_flashdata('Error', 'Invalid Deposit No.');
            }
        } else {

            $this->session->set_flashdata('Error', 'This Deposit No. Already Exits.');
        }
        redirect('student/studentDeposit', 'refresh');
    }

    /**
     * @methodName  examRegistration()
     * @access
     * @param
     * @author      rakib roni <rakbironicse@gmail.com>
     * @return      examination registration
     */
    function examRegistration()
    {
        $data['contentTitle'] = 'Exam Registration';
        $data["breadcrumbs"] = array(
            "Admin" => "admin/index",
            "Deposit" => '#'
        );
        $stu_session = $this->session->userdata('stu_logged_in');
        $stu_id = $stu_session["STUDENT_ID"];
        $student_info = $this->utilities->studentInfo($stu_id);
        $program_id = $student_info->PROGRAM_ID;

        $data['reg_course'] = $this->db->query("select b.COURSE_ID, b.COURSE_CODE,b.COURSE_TITLE from stu_courseinfo a
            left join aca_course b on a.COURSE_ID = b.COURSE_ID
            where a.STUDENT_ID=$stu_id ")->result();


        $data['reg_period'] = $this->db->query("SELECT a.PROGRAM_ID,b.EXAM_ID
          FROM exam_programs a
          LEFT JOIN exam_reg_period b ON a.EXAM_ID = b.EXAM_ID
          WHERE  a.PROGRAM_ID=$program_id and  CURDATE() BETWEEN b.ERP_DT_FROM AND b.ERP_DT_TO ")->row();
        //$exam_id = $data['reg_period']->EXAM_ID;
        $data['ex_app_value'] = $this->utilities->findAllByAttribute('exam_application', array('STUDENT_ID' => $stu_id));
        //print_r($data['reg_period']);exit;
        $data['bank_branch'] = $this->utilities->findAllFromView('bank_branch');
        $data['app_policy'] = $this->utilities->findAllFromView('app_policy');
        $data['content_view_page'] = 'student/registration/exam_registration';
        $this->student_portal->display($data);
    }

    /**
     * @methodName  saveExamRegistration()
     * @access
     * @param
     * @author      rakib roni <rakbironicse@gmail.com>
     * @return      examination registration
     */
    function saveExamRegistration()
    {

        $DEPOSITE_NO = $this->input->post('DEPOSITE_NO');
        $BANK_BRANCH_ID = $this->input->post('BANK_BRANCH_ID');
        $chk_deposit_no = $this->utilities->findByAttribute('exam_bank_deposit', array('DEPOSITE_NO' => $DEPOSITE_NO, 'BANK_BRANCH_ID' => $BANK_BRANCH_ID));

        if (empty($chk_deposit_no)) {
            echo "N";
        } else {
            $stu_session = $this->session->userdata('stu_logged_in');
            $stu_id = $stu_session["STUDENT_ID"];
            $student_info = $this->utilities->studentInfo($stu_id);
            $COURSE_ID = $this->input->post('COURSE_ID');
            $EXAM_ID = $this->input->post('EXAM_ID');
            $ex_app_data = array(
                'EXAM_ID' => $EXAM_ID,
                'STUDENT_ID' => $student_info->STUDENT_ID,
                'SESSION_ID' => $student_info->SESSION_ID,
                'FACULTY_ID' => $student_info->FACULTY_ID,
                'DEPT_ID' => $student_info->DEPT_ID,
                'PROGRAM_ID' => $student_info->PROGRAM_ID,
                'SEMESTER_ID' => $student_info->SEMESTER_ID,
                'BATCH_ID' => $student_info->BATCH_ID,

            );
            $EX_APP_ID = $this->utilities->insert('exam_application', $ex_app_data);
            foreach ($COURSE_ID as $key => $value) {
                $ex_app_cr_data = array(
                    'EX_APP_ID' => $EX_APP_ID,
                    'COURSE_ID' => $value
                );
                $this->utilities->insert('exam_application_courses', $ex_app_cr_data);
            }
            $ex_stu_deposit_data = array(
                'EX_APP_ID' => $EX_APP_ID,
                'DEPOSITE_NO' => $this->input->post('DEPOSITE_NO'),
            );
            $this->utilities->insert('exam_student_deposit', $ex_stu_deposit_data);
            $app_policy = $this->utilities->findAllByAttribute('app_policy', array('POLICY_ID' => 8));

            $app_policy[0]->POLICY_FLAG;
            if ($app_policy[0]->POLICY_FLAG == 0) {
                $data['contentTitle'] = 'Exam Admit Card';
                $data["breadcrumbs"] = array(
                    "Admin" => "admin/index",
                    "Deposit" => '#'
                );
                $data['reg_course'] = $this->db->query("select b.COURSE_ID, b.COURSE_CODE,b.COURSE_TITLE from stu_courseinfo a
                    left join aca_course b on a.COURSE_ID = b.COURSE_ID
                    where a.STUDENT_ID=$stu_id ")->result();
                $data['faculty_info'] = $this->utilities->studentInfo($stu_id);
                //$data['exam_info']=$this->utilities->findAllByAttribute('exam_application', array('EXAM_ID' => $EXAM_ID));
                echo $this->load->view('student/registration/admit_card');

            } else {
                echo "Your deposit on processing";
            }
        }
    }

    function admitCard()
    {
        $stu_session = $this->session->userdata('stu_logged_in');
        $stu_id = $stu_session["STUDENT_ID"];
        $data['reg_course'] = $this->db->query("select b.COURSE_ID, b.COURSE_CODE,b.COURSE_TITLE from stu_courseinfo a
            left join aca_course b on a.COURSE_ID = b.COURSE_ID
            where a.STUDENT_ID=$stu_id ")->result();
        $data['faculty_info'] = $this->utilities->studentInfo($stu_id);
        //print_r($data['faculty_info']);exit;
        // $data['exam_info']=$this->utilities->findAllByAttribute('exam_application', array('EXAM_ID' => $EXAM_ID));

        $data['content_view_page'] = 'student/registration/admit_card';
        $this->student_portal->display($data);
    }

    function chkDepositNo()
    {
        $deposit_no = $_POST['deposit_no'];
        $branch_id = $_POST['branch_id'];
        $chk_result = $this->utilities->findAllByAttribute('exam_bank_deposit', array('DEPOSITE_NO' => $deposit_no, 'BANK_BRANCH_ID' => $branch_id));

        if (!empty($chk_result)) {
            echo "Y";
        } else {
            echo "N";
        }
    }

    function currentRegCourse()
    {

        $data['contentTitle'] = 'Current Registered Course';
        $data["breadcrumbs"] = array(
            "Student" => "#",
            "Registered Course" => '#'
        );
        $stu_session = $this->session->userdata('stu_logged_in');
        $stu_id = $stu_session["STUDENT_ID"];

        $data['courses'] = $this->db->query("SELECT a.*, c.*
          FROM stu_courseinfo a
          LEFT JOIN aca_course_offer b
          ON a.OFFERED_COURSE_ID = b.OFFERED_COURSE_ID
          LEFT JOIN aca_course c ON b.COURSE_ID = c.COURSE_ID
          WHERE a.STUDENT_ID = $stu_id and a.IS_CURRENT='1'")->result();
        $data['content_view_page'] = 'student/student_course/current_sem_course';
        $this->student_portal->display($data);
    }


    function applicationForm()
    {

        $data['contentTitle'] = 'Application Form';
        $data["breadcrumbs"] = array(
            "Student" => "#",
            "Application Form" => '#'
        );

        $data['content_view_page'] = 'student/application_form_pdf';
        $this->student_portal->display($data);
    }

    function assignmentList()
    {
        $data['contentTitle'] = 'Assignment';
        $data["breadcrumbs"] = array(
            "Student" => "#",
            "Assignment List" => '#'
        );
        $stu_session = $this->session->userdata('stu_logged_in');
        $stu_id = $stu_session["STUDENT_ID"];
        $student_info = $this->utilities->studentInfo($stu_id);
        $data['session_info'] = $this->utilities->universityStudentSessionInfo($stu_id);
        $data['sem_session'] = $student_info;
        $data['current_reg_course'] = $this->db->query("SELECT a.STU_CRS_ID,
            a.STUDENT_ID,
            a.OFFERED_COURSE_ID,
            a.SESSION_ID,
            a.SEMISTER_ID,
            a.FACULTY_ID,
            a.DEPT_ID,
            a.PROGRAM_ID,
            a.COURSE_ID,
            a.IS_CURRENT,
            a.ACTIVE_STATUS,
            b.COURSE_CODE,
            b.COURSE_TITLE,
            b.CREDIT
            FROM stu_courseinfo a LEFT JOIN aca_course b ON a.COURSE_ID = b.COURSE_ID
            WHERE a.STUDENT_ID = $stu_id and a.IS_CURRENT=1")->result();

        $data['content_view_page'] = 'student/semester_wise_assignment';
        $this->student_portal->display($data);
    }

    function assignmentByCourse()
    {
        $stu_session = $this->session->userdata('stu_logged_in');
        $stu_id = $stu_session["STUDENT_ID"];
        $student_info = $this->utilities->studentInfo($stu_id);
        $course_id = $this->input->post('course_id');

        $data['assignments_by_course'] = $this->db->query("SELECT a.*, b.ASSIGN_TITLE, b.ASSIGN_DESC
          FROM aca_assignment_distribution a
          LEFT JOIN aca_assignment b ON a.ASSIGN_ID = b.ASSIGN_ID
          WHERE a.COURSE_ID =$course_id  AND a.PROGRAM_ID=$student_info->PROGRAM_ID AND a.SESSION_ID=$student_info->SEM_SESSION AND a.SEMESTER_ID =$student_info->SEMESTER_ID")->result();

        $this->load->view('student/assignments_by_course', $data);
    }

    function studentPayment(){
        $data['contentTitle'] = 'Payment';
        $data['breadcrumbs'] = array(
            'Finance' => '#',
            'Payment' => '#',
        );
        $student_id = $this->STUDENT_ID;
        $data['content_view_page'] = 'admin/payment/student_payment_form';
        $data["session"] = $this->student_model->getAllSessionByStudentId($student_id);
        $this->student_portal->display($data);
    }


    function paymentDetailsBySemester()
    {
        $student_id = $this->STUDENT_ID;
        $ysession_id = $this->input->post('YSESSION_ID');
        $data['student_info'] = $this->utilities->findByAttribute('student_personal_info',array('STUDENT_ID'=>$student_id));
        $data['semester_wise_course'] = $this->student_model->getAllCourseByStudentIdAndSessionWise($student_id, $ysession_id);
        $data['charge_rate'] = $this->student_model->getChargeRate($data['student_info']->PROGRAM_ID, $ysession_id);
        $this->load->view('admin/payment/semester_wise_student_payment_form', $data);
    }

    function printId($student_id)
    {

        $data['student_info'] = $this->student_model->getStudentInfoAll($student_id);

        //echo "<pre>"; print_r($data["student_info"]); exit;


        include('mpdf/mpdf.php');
        $mpdf = new mPDF();
        $mpdf->SetTitle('Offered Course');
        $mpdf->mirrorMargins = 1;
        $mpdf->useOnlyCoreFonts = true;
        $report = $this->load->view('student/student_id_card.php', $data, TRUE);
        //$footer = $this->load->view('admin/course/semester_course_info_footer', $data, TRUE);
        $mpdf->WriteHTML("$report");
        $mpdf->SetHTMLFooter("$footer");
        $mpdf->Output();
        exit;
    }
    function residentApplication(){
        $data['contentTitle'] = 'Resident Application';
        $data['breadcrumbs'] = array(
            'Resident' => '#',
            'Applicattion' => '#',
        );
        $student_id = $this->STUDENT_ID;
        $data['student_details'] = $this->student_model->getStudentInfoAll($student_id);
        $data['local_present_adddress'] = $this->student_model->getLocalPresentAddress($student_id);
        $data['local_permanent_adddress'] = $this->student_model->getLocalPermanentAddress($student_id);

        $data['content_view_page'] = 'student/hostel/index';
        $this->student_portal->display($data);
    }
    function residentPolicy(){
       $resident_policy=$this->utilities->findAllByAttribute('m00_lkpdata',array('GRP_ID'=>78));
       // echo "<pre>"; print_r($resident_policy);exit;
       $terms_and_condition='';
       $i=1;
       foreach($resident_policy as $row):
           $terms_and_condition .= '<p>'. $i++ .'. '. $row->LKP_NAME.'</p>';
       endforeach;
       echo $terms_and_condition;
   }
   function saveResidentApplicant(){

        $resident_application_data=array(
        'APPLICATION_TYPE'=>$this->input->post('APPLICATION_TYPE'),
        'APPLICANT_ID'=>$this->STUDENT_ID,
        'APPLICANT_TYPE'=>'S',
        'APPLICANT_DT'=>date('Y-m-d'),
        'REASON_OF_ALLOCATION'=>$this->input->post('REASON_OF_ALLOCATION'),
        'TERMS'=>$this->input->post('TERMS'),
        'ACTIVE_STATUS'=>1
        );
        if($this->input->post('APPLICATION_TYPE') == 'A'){
            $check=$this->utilities->hasInformationByThisId('resident_application',array('APPLICANT_ID'=>$this->STUDENT_ID,'APPLICATION_TYPE'=>'A'));
        }else{
            $check=$this->utilities->hasInformationByThisId('resident_application',array('APPLICANT_ID'=>$this->STUDENT_ID,'APPLICATION_TYPE'=>'C'));
        }


        if(empty($check)):
            $this->utilities->insertData($resident_application_data, 'resident_application');
        endif;

   }




//Start Code by Nawim

  /*
  * @methodName libraryMemberApplication
  * @access
  * @param  none
  * @author Abu Nawim <nawim@atilimited.net>
  * @return
  */

    function libraryMemberApplication(){

        $data['contentTitle'] = 'Library Member Application';
        $data['breadcrumbs'] = array(
            'Member' => '#',
            'Applicattion' => '#',
        );
        $student_id = $this->STUDENT_ID;

        $data['student_details'] = $this->student_model->getStudentInfoAll($student_id);
        $data['local_present_adddress'] = $this->student_model->getLocalPresentAddress($student_id);
        $data['local_permanent_adddress'] = $this->student_model->getLocalPermanentAddress($student_id);
        $studentId=$data['student_details']->STUDENT_ID;

         $checkLiberyMemeber=$this->db->query('select ACTIVE_STATUS from lib_members where MEBBER_ID ='.$studentId)->result();
         $avaliable=count($checkLiberyMemeber); //$this->db->affected_rows($checkLiberyMemeber);


        if($avaliable<1){
        $data['content_view_page'] = 'student/library/apply_library_member';
        }
        else{

           $data['member']=$this->student_model->checkLibraryMember($data['student_details']->STUDENT_ID);
           $data['content_view_page'] = 'student/library/library_member_available';

        }

        $this->student_portal->display($data);

    }

  /*
  * @methodName libraryMemberPolicy
  * @access
  * @param  none
  * @author Abu Nawim <nawim@atilimited.net>
  * @return
  */


    function libraryMemberPolicy(){
       $library_policy=$this->utilities->findAllByAttribute('m00_lkpdata',array('GRP_ID'=>83));
       $terms_and_condition='';
       $i=1;
       foreach($library_policy as $row):
           $terms_and_condition .= '<p>'. $i++ .'. '. $row->LKP_NAME.'</p>';
       endforeach;
       echo $terms_and_condition;
   }


 /*
  * @methodName libraryMemberApplicationSave
  * @access
  * @param  none
  * @author Abu Nawim <nawim@atilimited.net>
  * @return
  */

    function libraryMemberApplicationSave(){
        $data['contentTitle'] = 'Library Member Application';
        $data['breadcrumbs'] = array(
            'Member' => '#',
            'Applicattion' => '#',
        );

        $student_id = $this->STUDENT_ID;

         $member_application = array(
          'MEBBER_ID' => $student_id,
          'MEMBER_TYPE' => $this->input->post('MEMBER_TYPE'),
          'TERMS_CON_STATUS' => $this->input->post('TERMS'),
          'REMARKS' => $this->input->post('REMARKS'),

          );

        $emp_id= $this->utilities->insert('lib_members', $member_application);
        $data['content_view_page'] = 'student/library/apply_library_member';
        $this->student_portal->display($data);
    }


  /*
  * @methodName libraryMemberItemBorrowHistory
  * @access
  * @param  none
  * @author Abu Nawim <nawim@atilimited.net>
  * @return
  */

    function libraryMemberItemBorrowHistory(){
        $data['contentTitle'] = 'Library Member Item Borrow History';
        $data['breadcrumbs'] = array(
            'Member' => '#',
            'Item Borrow History' => '#',
        );
       $student_id = $this->STUDENT_ID;
       $data['dataStudentBorrowHistory'] = $this->student_model->studentItemBorrowHistory($student_id);

        $data['content_view_page'] = 'student/library/library_item_borrow_history';
        $this->student_portal->display($data);
    }



// End code by nawim

     /*
      * @methodName studentInfoPdf
      * @access
      * @param  none
      * @author Md.Reazul Islam <reazul@atilimited.net>
      * @return
      */

  function studentInfoPdf($param_student_id = '')
    {

         if ($param_student_id != '') {
            $student_id = $param_student_id;
        } else {
            $student_id = $this->STUDENT_ID;
        }
        $data['pageTitle'] = 'Print PDF';
        $data['student_id'] = $student_id;
        $data['student_info'] = $this->student_model->getStudentInfoAll($student_id);
        $data["fathersInfo"] = $this->student_model->getStudentFatherInfo($student_id);
        $data["motherInfo"] = $this->student_model->getStudentMotherInfo($student_id);
        $data["local_guardian"] = $this->student_model->getStudentLocalGuardianInfo($student_id);
        $data['local_present_adddress'] = $this->student_model->getLocalPresentAddress($student_id);
        $data['local_permanent_adddress'] = $this->student_model->getLocalPermanentAddress($student_id);
        $data['academic'] = $this->student_model->getStudentAcademicInfo($student_id);
        $data["applicant_info"] = $this->student_model->getStudentInfoAll($student_id);
        $data['waiver_info'] = $this->student_model->getStudentAllWaiverInfo($student_id);

    //echo "<pre>";print_r($data['student_info']);exit();
      include('mpdf/mpdf.php');
      $mpdf = new mPDF('','A4',10,'');
      $mpdf->autoLangToFont = true;
      $mpdf->SetTitle('Student Information');
      $mpdf->mirrorMargins = 1;
      $mpdf->useOnlyCoreFonts = true;
      $report = $this->load->view('student/student_mpdf_info/student_pdf_info', $data, TRUE);
        $mpdf->WriteHTML("$report");
      $mpdf->SetHTMLFooter("$footer");
      $mpdf->Output();
      exit;
    }
    public function holidayCalendar()
    {
      $data['contentTitle'] = 'Event Calender';
          $data['breadcrumbs'] = array(
              'Admin' => '#',
              'Event' => '#',
          );
  		$data['content_view_page'] = 'student/calendar/holidayCalendar';
      $this->student_portal->display($data);
    }
    /*
      Fahim Area Start
    */

    /*
      Fahim Area End
    */



//***************************
}
