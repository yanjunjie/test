//Done query:
alter session set nls_date_format='YYYY-MM-DD HH24:MI:SS';
$this->db->query("alter session set nls_date_format='YYYY-MM-DD HH24:MI:SS'");
/
SELECT accr.*, acc.AC_NAME, insprogram.PROGRAM_NAME, ins_s.SESSION_NAME || '-' || ins_y.DINYEAR AS SESSION_NAME
FROM fn_academic_charge_rate accr
LEFT JOIN fn_achead acc ON accr.AC_NO = acc.AC_NO
LEFT JOIN ins_program insprogram ON accr.PROGRAM_ID = insprogram.PROGRAM_ID
LEFT JOIN ins_ysession ins_y ON accr.SESSION_ID = ins_y.YSESSION_ID
LEFT JOIN ins_session ins_s ON ins_s.SESSION_ID = ins_y.SESSION_ID ORDER BY accr.RATE_ID ASC;
/
SELECT * FROM student_semesterinfo sem
          LEFT JOIN student_personal_info stu_info ON stu_info.STUDENT_ID = sem.STUDENT_ID
          WHERE sem.SESSION_ID = 6 AND sem.PROGRAM_ID = 3
          AND stu_info.STUDENT_ID NOT IN (SELECT billMst.STUDENT_ID FROM fn_billing_mst billMst WHERE billMst.BILL_TYPE = 'A')
/
SELECT * 
FROM resident_seat_allocation res_s_allocation
LEFT JOIN resident_seat_mapping res_s_mapping ON res_s_allocation.SEAT_MAPPING_ID = res_s_mapping.SEAT_MAPPING_ID
LEFT JOIN student_personal_info stu_info ON res_s_allocation.APPLICANT_ID = stu_info.STUDENT_ID
WHERE res_s_mapping.BUILDING_ID = 3 AND stu_info.STUDENT_ID NOT IN (SELECT billMst.STUDENT_ID FROM fn_billing_mst billMst LEFT JOIN fn_billing_chd billChild ON billChild.BILLING_MST_ID = billMst.BILLING_MST_ID WHERE billMst.BILL_TYPE = 'R' AND TO_CHAR(billChild.BILLING_MONTH,'YYYY') = 2018 AND TO_CHAR(billChild.BILLING_MONTH,'MM') = 10)
/
SELECT b.STUDENT_ID,b.SESSION_ID, b.REGISTRATION_NO, b.FULL_NAME_EN,c.PROGRAM_ID, c.PROGRAM_NAME 
FROM student_semesterinfo a, student_personal_info b, ins_program c 
WHERE a.STUDENT_ID = b.STUDENT_ID AND b.PROGRAM_ID = c.PROGRAM_ID 
GROUP BY b.STUDENT_ID,b.SESSION_ID, b.REGISTRATION_NO, b.FULL_NAME_EN,c.PROGRAM_ID, c.PROGRAM_NAME
/
SELECT b.YSESSION_ID, c.SESSION_NAME || ' - ' || b.DINYEAR AS SESSION_NAME 
FROM student_semesterinfo a LEFT JOIN ins_ysession b ON a.SESSION_ID=b.YSESSION_ID LEFT JOIN ins_session c ON b.SESSION_ID = c.SESSION_ID 
WHERE a.STUDENT_ID = 278;
/
SELECT b.BILLING_CHD_ID, b.BILLING_MST_ID, b.AC_NO, b.RATE_ID, b.RATE_AMT, b.TOTAL_BILL, b.DISC_AMT, b.VAT_AMT, b.BILL_AMT, b.BILLING_MONTH, b.REMARKS, c.AC_NAME, SUM(d.PAID_AMT) AS PAID_AMT, (b.BILL_AMT - ABS(SUM(d.PAID_AMT))) AS DUE_AMT 
FROM fn_billing_mst a LEFT JOIN fn_billing_chd b ON a.BILLING_MST_ID = b.BILLING_MST_ID LEFT JOIN fn_achead c on b.AC_NO = c.AC_NO LEFT JOIN fn_voucherchd d ON d.BILLING_CHD_ID = b.BILLING_CHD_ID 
WHERE a.STUDENT_ID = 278 AND a.SESSION_ID = 6
GROUP BY b.BILLING_CHD_ID, b.BILLING_MST_ID, b.AC_NO, b.RATE_ID, b.RATE_AMT, b.TOTAL_BILL, b.DISC_AMT, b.VAT_AMT, b.BILL_AMT, b.BILLING_MONTH, b.REMARKS, c.AC_NAME;
/
SELECT b.COURSE_CODE, b.COURSE_TITLE, b.CREDIT
FROM student_courseinfo a, aca_course b
WHERE a.COURSE_ID = b.COURSE_ID
   AND a.SESSION_ID = 8
   AND a.STUDENT_ID = 278
/
select a.*, b.LKP_NAME as FATHER_OCCU 
from student_gurdianinfo a LEFT JOIN M00_LKPDATA b ON a.OCCUPATION=to_char(b.LKP_ID)
WHERE a.STUDENT_ID=31 AND a.GUARDIAN_TYPE='F';
/
SELECT prs.PR_RET_DATE,prc.ITEM_ID,itm.ITEM_NAME,itm.UNIT_ID,u.UNIT_NAME,
sum(prc.RET_RECEIVE_QTY) TOTAL_RET_RECEIVE_QTY 
FROM inv_pr_return_mst prs LEFT JOIN inv_pr_return_chd prc ON prs.PR_RET_MST_ID = prc.PR_RET_MST_ID LEFT JOIN inv_item itm ON prc.ITEM_ID=itm.ITEM_ID LEFT JOIN inv_unit u ON itm.UNIT_ID=u.UNIT_ID
where prs.PR_RET_DATE BETWEEN TO_DATE('2017-09-12', 'YYYY-MM-DD') and TO_DATE('2018-09-12', 'YYYY-MM-DD')
group by prs.PR_RET_DATE,prc.ITEM_ID,itm.ITEM_NAME,itm.UNIT_ID,u.UNIT_NAME;
/
SELECT MAX(SUBSTR(issue.ISSUE_NO,9)) AS MAX_ISSUE_NO FROM inv_issue_mst issue;
/
SELECT SUM(ich.ISSUED_QTY) TOTAL_ISSUED_QTY
FROM inv_requisition_mst rm LEFT JOIN inv_requisition_chd rc 
ON rm.REQ_MST_ID=rc.REQ_MST_ID 
LEFT JOIN inv_issue_chd ich 
ON ich.REQ_CHD_ID=rc.REQ_CHD_ID 
WHERE to_char(rm.REQ_MST_ID) = 3;
/
--For Backup one table data to another table
create table inv_issue_chd_200918
as select * from inv_issue_chd;
/
--Truncate the table for empty
truncate table inv_issue_chd;
/
--Now modify attribute type
alter table inv_issue_chd
modify ISSUED_QTY number(10,2);
/
--Now reload data after modifying 
insert into inv_issue_chd
select * from inv_issue_chd_200918;
/
--Drop the backup table
drop table inv_issue_chd_200918;
--Done!
/
SELECT DISTINCT(pod.PO_CHD_ID),pod.PO_MST_ID,sup.*,itm.ITEM_NAME,itm.UNIT_ID ,u.UNIT_NAME,pod.ITEM_ID,pod.SUPPLIER_ID,pod.ORDER_QTY,pod.ACTIVE_STATUS, (SELECT SUM(por.RECEIVE_QTY)
FROM inv_pr_chd por 
WHERE por.PO_CHD_ID=pod.PO_CHD_ID)RECEIVE_QTY 
FROM inv_po_chd pod 
LEFT JOIN inv_pr_chd por ON pod.PO_CHD_ID=por.PO_CHD_ID
LEFT JOIN inv_item itm ON por.ITEM_ID=itm.ITEM_ID
LEFT JOIN inv_unit u ON itm.UNIT_ID=u.UNIT_ID
LEFT JOIN inv_supplier sup ON por.SUPPLIER_ID = sup.SUPPLIER_ID 
WHERE pod.PO_MST_ID=1 ORDER BY pod.PO_CHD_ID
/
alter table INV_SUPPLIER drop column ORG_ADDRESS;
alter table INV_SUPPLIER add ORG_ADDRESS varchar2(4000);
/
INSERT INTO nm_admission (APPLICATION_ID,SESSION_ID,ADMISSION_SL,COURSE_ID,BATCH_MAP_ID,POLICYMST_ID,FULL_NAME_ENG,FULL_NAME_BNG,BIRTH_DATE,GENDER,BLOOD_GROUP,MARITAL_STATUS,MOBILE_NUMBER,EMAIL_ADDRESS,NATIONALITY,RELIGION_NO,APPLICANT_PHOTO,APPLICANT_SIGN,APPLICANT_SIGN_DATE,REGISTRATION_NUMBER,ROLL_NUMBER,EXAM_DATE,COLLEGE_CODE,MERIT_POSITION,FATHER_NAME_ENG,FATHER_NAME_BNG,FATHER_MOBILE,FATHER_EMAIL,FATHER_OCCU_ID,MOTHER_NAME_ENG,MOTHER_NAME_BNG,MOTHER_MOBILE,MOTHER_EMAIL,MOTHER_OCCU_ID,GUARDIAN_SIGN,GUARDIAN_SIGN_DATE,LG_NAME,LG_DETAILS,LG_OCCU_ID,LG_MOBILE,LG_EMAIL,LG_VILLAGE,LG_POST_OFFICE,LG_UPAZILLA,LG_DISTRICT,RELATION_WITH_LG,PRE_VILLAGE,PRE_POST_OFFICE,PRE_UPAZILLA,PRE_DISTRICT,PRE_MOBILE,PER_VILLAGE,PER_POST_OFFICE,PER_MOBILE,PER_UPAZILLA,PER_DISTRICT,EDU_QUALI_ID,ACTIVE_FLAG,ENTERED_BY,ENTRY_TIMESTAMP,UPDATED_BY,UPDATE_TIMESTAMP,COMPANY_NO,APPLICANT_PHOTO_PATH,APPLICANT_SIGN_PATH, ADDRESS_TYPE, LOCAL_GUARDIAN_FG)
SELECT APPLICATION_ID,SESSION_ID,APPLICATION_SL,COURSE_ID,BATCH_MAP_ID,POLICYMST_ID,FULL_NAME_ENG,FULL_NAME_BNG,BIRTH_DATE,GENDER,BLOOD_GROUP,MARITAL_STATUS,MOBILE_NUMBER,EMAIL_ADDRESS,NATIONALITY,RELIGION_NO,APPLICANT_PHOTO,APPLICANT_SIGN,APPLICANT_SIGN_DATE,REGISTRATION_NUMBER,ROLL_NUMBER,EXAM_DATE,COLLEGE_CODE,MERIT_POSITION,FATHER_NAME_ENG,FATHER_NAME_BNG,FATHER_MOBILE,FATHER_EMAIL,FATHER_OCCU_ID,MOTHER_NAME_ENG,MOTHER_NAME_BNG,MOTHER_MOBILE,MOTHER_EMAIL,MOTHER_OCCU_ID,GUARDIAN_SIGN,GUARDIAN_SIGN_DATE,LG_NAME,LG_DETAILS,LG_OCCU_ID,LG_MOBILE,LG_EMAIL,LG_VILLAGE,LG_POST_OFFICE,LG_UPAZILLA,LG_DISTRICT,RELATION_WITH_LG,PRE_VILLAGE,PRE_POST_OFFICE,PRE_UPAZILLA,PRE_DISTRICT,PRE_MOBILE,PER_VILLAGE,PER_POST_OFFICE,PER_MOBILE,PER_UPAZILLA,PER_DISTRICT,EDU_QUALI_ID,ACTIVE_FLAG,ENTERED_BY,ENTRY_TIMESTAMP,UPDATED_BY,UPDATE_TIMESTAMP,COMPANY_NO,APPLICANT_PHOTO_PATH,APPLICANT_SIGN_PATH,ADDRESS_TYPE,LOCAL_GUARDIAN_FG
from nm_application 
where APPLICATION_ID = 'R180901000004';
/
SELECT *
FROM nm_admission
WHERE UPPER (user_name) = UPPER ('S180901000203') --Username
AND UPPER(security_word) = pkg_password.encrypt_passmd5 ('a119525259') --Pass
AND ACTIVE_FLAG = 'Y';
/
insert into UM_LABRATORIES (LAB_NAME,LAB_DESC,CRE_BY,ORG_ID,ORDER_NO) values('Pathology', 'Desc', '2','1','2');
/
select x.EXP_NAME, l.lab_name, s.EMP_NAME
from UM_LAB_EXPERIMENT x
left join UM_LAB_EXP_ASSIGN xa on x.EXP_ID=xa.EXP_ID
left join UM_LABRATORIES l on l.lab_id = xa.lab_id
left join UM_LAB_SUPERVISOR_ASSIGN sa on sa.EXP_ID=x.EXP_ID  
left join HR_EMPLOYEE s on s.EMP_NO = sa.EMP_NO
/
select x.EXP_NAME, l.lab_name
from UM_LABRATORIES l
left join UM_LAB_EXP_ASSIGN xa on xa.lab_id=l.lab_id
left join UM_LAB_EXPERIMENT x on x.EXP_ID=xa.EXP_ID  
where xa.EXP_ID = 1;
/
select l.lab_name
from UM_LABRATORIES l
left join UM_LAB_EXP_ASSIGN xa on xa.lab_id=l.lab_id
where xa.EXP_ID = 1;

/
select l.lab_name
from UM_LABRATORIES l
left join UM_LAB_EXP_ASSIGN xa on xa.lab_id=l.lab_id
where xa.EXP_ID = 1;
/
INSERT INTO "UMS_LAB_SCHEDULE" (FACULTY_ID, SESSION_ID, DEGREE_ID, DEPT_ID, PROGRAM_ID, BATCH_ID, SECTION_ID, ROOM_NO, CLASS_START_TIME, CLASS_END_TIME, STUDENT_ID, SDL_DT, ACTIVE_STATUS) 
VALUES (1, 1, 3, 2, 1, 8, 1, 102, '2018-10-01 04:08:00', '2018-10-01 04:08:00', 1, '2018-10-12 12:00:00', 'Y');
/
select std.STUDENT_ID,std.REGISTRATION_NO,std.FULL_NAME_EN,std.EMAIL_ADRESS,std.MOBILE_NO, s.SESSION_NAME, sy.DINYEAR, d.DEGREE_NAME, dpt.DEPT_NAME, p.PROGRAM_NAME, b.BATCH_TITLE, f.FACULTY_NAME 
FROM STUDENT_PERSONAL_INFO std LEFT JOIN INS_SESSION s ON s.SESSION_ID = std.ADM_SESSION_ID 
LEFT JOIN ADM_YSESSION sy ON sy.SESSION_ID = s.SESSION_ID 
LEFT JOIN INS_DEGREE d ON d.DEGREE_ID = std.DEGREE_ID 
LEFT JOIN INS_DEPT dpt ON dpt.DEPT_ID = std.DEPT_ID 
LEFT JOIN INS_PROGRAM p ON p.PROGRAM_ID = std.PROGRAM_ID
LEFT JOIN ACA_BATCH b ON b.BATCH_ID = std.BATCH_ID 
LEFT JOIN INS_FACULTY f ON f.FACULTY_ID = std.FACULTY_ID 
--where std.ADM_SESSION_ID = 'STUDENT_PERSONAL_INFO' And std.DEGREE_ID=14 And std.FACULTY_ID=6 And std.DEPT_ID=1 And std.PROGRAM_ID=6 And std.BATCH_ID=6 And std.SECTION_ID=2 
where std.ADM_SESSION_ID = 'STUDENT_PERSONAL_INFO' And std.DEGREE_ID=14 And std.FACULTY_ID=6 And std.DEPT_ID=1 And std.PROGRAM_ID=6 And std.BATCH_ID=6 And std.SECTION_ID=2 
GROUP BY std.STUDENT_ID,std.REGISTRATION_NO,std.FULL_NAME_EN,std.EMAIL_ADRESS,std.MOBILE_NO, s.SESSION_NAME, sy.DINYEAR, d.DEGREE_NAME, dpt.DEPT_NAME, p.PROGRAM_NAME, b.BATCH_TITLE, f.FACULTY_NAME 
/
UPDATE UM_LAB_EXP_ASSIGN
SET LAB_ID = CASE WHEN EXP_ID = 25 THEN 37 
--WHEN EXP_ID = 25 THEN '5' 
ELSE LAB_ID END, 
ACTIVE_STATUS = CASE WHEN EXP_ID = 25 THEN 'Y' 
--WHEN EXP_ID = 25 THEN 'Y' 
ELSE ACTIVE_STATUS END, 
CRE_BY = CASE WHEN EXP_ID = 25 THEN 9 
--WHEN EXP_ID = 25 THEN '9' 
ELSE CRE_BY END, 
ORG_ID = CASE WHEN EXP_ID = 25 THEN 1 
--WHEN EXP_ID = 25 THEN '1' 
ELSE ORG_ID END 
WHERE EXP_ID = 25
/
select a.* from applicant_personal_info a 
WHERE ELIGIBLE_BY_DEPT_HEAD IS NOT NULL 
AND ELIGIBLE_STU_FG != '1' 
and PROGRAM_ID='61' 
and ADM_SESSION_ID='41' 
order by APPLICANT_ID desc
/
SELECT a.*,f.*, b.LKP_NAME as ed,c.LKP_NAME as mg,d.LKP_NAME as br FROM student_acadimicinfo a
left join m00_lkpdata b on a.EXAM_DEGREE_ID=b.LKP_ID
left join m00_lkpdata c on a.MAJOR_GROUP_ID=c.LKP_ID
left join m00_lkpdata d on a.BOARD = d.LKP_ID
left join STUDENT_PERSONAL_INFO e on e.STUDENT_ID = a.STUDENT_ID
left join SKILL_DEV_ELEMENT f on f.APPLICANT_ID = e.APPLICANT_ID
WHERE a.STUDENT_ID ='$student_id' order by STU_AI_ID asc
/
SELECT a.STU_AI_ID, a.STUDENT_ID,a.EXAM_DEGREE_ID,a.MAJOR_GROUP_ID,a.INSTITUTION,a.BOARD,RESULT_GRADE,a.RESULT_GRADE_WA,a.CGPA_MARKPCT,a.SCALE_MARKS,a.PASSING_YEAR, b.LKP_NAME as ed,
c.LKP_NAME as mg,
d.LKP_NAME as br, 
g.SD_ID, g.DIRECTORY_PATH 
FROM student_acadimicinfo a 
left join m00_lkpdata b on a.EXAM_DEGREE_ID=b.LKP_ID 
left join m00_lkpdata c on a.MAJOR_GROUP_ID=c.LKP_ID 
left join m00_lkpdata d on a.BOARD = d.LKP_ID 
left join STUDENT_PERSONAL_INFO e on e.STUDENT_ID = a.STUDENT_ID 
left join SKILL_DEV_ELEMENT f on f.APPLICANT_ID = e.APPLICANT_ID 
left join SKILL_DEV_DIRECTORY g on g.SD_ID = f.SD_ID 
WHERE a.STUDENT_ID ='342'
group by a.STU_AI_ID,a.STUDENT_ID,a.EXAM_DEGREE_ID,a.MAJOR_GROUP_ID,a.INSTITUTION,a.BOARD,RESULT_GRADE,a.RESULT_GRADE_WA,a.CGPA_MARKPCT,a.SCALE_MARKS,a.PASSING_YEAR, b.LKP_NAME,c.LKP_NAME,d.LKP_NAME, g.SD_ID, g.DIRECTORY_PATH 
order by a.STU_AI_ID asc;
/
SELECT a.STU_AI_ID, a.STUDENT_ID,a.EXAM_DEGREE_ID,a.MAJOR_GROUP_ID,a.INSTITUTION,a.BOARD,RESULT_GRADE,a.RESULT_GRADE_WA,a.CGPA_MARKPCT,a.SCALE_MARKS,a.PASSING_YEAR
--g.SD_ID, g.DIRECTORY_PATH 
FROM student_acadimicinfo a 
left join m00_lkpdata b on b.LKP_ID=a.EXAM_DEGREE_ID

left join STUDENT_PERSONAL_INFO e on e.STUDENT_ID = a.STUDENT_ID 
left join SKILL_DEV_ELEMENT f on f.APPLICANT_ID = e.APPLICANT_ID 
left join SKILL_DEV_DIRECTORY g on g.SD_ID = f.SD_ID 
WHERE a.STUDENT_ID ='342'
grou
/
select a.*, b.SUBMISSION_DT SUBMITTED_AT, b.ASSIGNMENT_FILE 
from UMS_ASSIGNMENTS a  
left join UMS_STUDENT_ASSIGNMENT b on b.ASSIGNMENT_ID =a.ASSIGNMENT_ID 
where b.SUBMISSION_DT > '2018-10-27' and a.ACTIVE_STATUS ='Y'
/
 public function assignmentsByLeftJoin($where)
 {
     $today = date('Y-m-d');
     return $this->db->query("
            select a.ASSIGNMENT_ID,a.ASSIGNMENT_TITLE,a.DESCRIPTION,a.SUBMISSION_DT, b.SUBMISSION_DT SUBMITTED_AT, b.ASSIGNMENT_FILE,b.STUDENT_ID, c.COURSE_TITLE 
            from UMS_ASSIGNMENTS a left join UMS_STUDENT_ASSIGNMENT b on b.ASSIGNMENT_ID =a.ASSIGNMENT_ID 
            left join ACA_COURSE c on c.COURSE_ID =a.COURSE_ID 
            where a.SUBMISSION_DT >= '$today' and a.ACTIVE_STATUS ='Y' $where
            group by a.ASSIGNMENT_ID,a.ASSIGNMENT_TITLE,a.DESCRIPTION,a.SUBMISSION_DT,b.SUBMISSION_DT, b.ASSIGNMENT_FILE,b.STUDENT_ID, c.COURSE_TITLE
        ")->result();
 }

/
select a.ASSIGNMENT_TITLE,a.DESCRIPTION,a.SUBMISSION_DT, b.SUBMISSION_DT SUBMITTED_AT, b.ASSIGNMENT_FILE,b.STUDENT_ID, c.COURSE_TITLE 
from UMS_ASSIGNMENTS a left join UMS_STUDENT_ASSIGNMENT b on b.ASSIGNMENT_ID =a.ASSIGNMENT_ID 
left join ACA_COURSE c on c.COURSE_ID =a.COURSE_ID 
where a.SUBMISSION_DT >= '2018-10-31' and a.ACTIVE_STATUS ='Y' 
group by a.ASSIGNMENT_TITLE,a.DESCRIPTION,a.SUBMISSION_DT,b.SUBMISSION_DT, b.ASSIGNMENT_FILE,b.STUDENT_ID, c.COURSE_TITLE;
/
select b.*
from INS_PROGRAM a
left join aca_course b on b.DEPT_ID = a.DEPT_ID
where a.PROGRAM_ID = '61'
/
select b.*
from $table a
left join $table2 b on b.$attr2 = a.$attr2
where a.$attr1 = '$id'
/
select c.*
from INS_YSESSION a
left join ACA_BATCH_PROG b on b.YSESSION_ID = a.YSESSION_ID
left join ACA_BATCH c on c.BATCH_ID = b.BATCH_ID
where a.YSESSION_ID = '61'
/
alter table UMS_LAB_SCHEDULE modify (ACTIVE_STATUS null);
/

//Existence Check
SELECT count (*) is_exist 
FROM UMS_EXAM_SCHEDULE_MST a, UMS_EXAM_SCHEDULE_CHD b 
WHERE a.EXM_SDL_MST_ID = b.EXM_SDL_MST_ID 
AND a.PROGRAM_ID = '61' 
AND a.SEMESTER_NO = '1' 
AND a.SESSION_ID = '41' 
AND a.EXAM_YEAR = '2018'

//OR
SELECT a.STUDENT_ID,a.FULL_NAME_EN,(SELECT COUNT(*) FROM UMS_LAB_SCHEDULE
WHERE STUDENT_ID=a.STUDENT_ID ) IS_EXIST FROM STUDENT_PERSONAL_INFO a;

/
select DBMS_LOB.substr(FORUM_DESC, 4000) FORUM_DESC, FORUM_ID, FORUM_TITLE, IS_STUDENT, CRE_BY, CRE_DT from UMS_FORUM_MST order by FORUM_ID desc
/
select DBMS_LOB.substr(REPLY_DESC, 4000) REPLY_DESC, FORUM_ID, REPLY_ID, IS_STUDENT, CRE_BY, CRE_DT,
    case when r.IS_STUDENT = 'Y' then
            select  distinct FULL_NAME_EN
            from STUDENT_PERSONAL_INFO
            where STUDENT_ID = r.CRE_BY
       /* when IS_STUDENT = 'N' then
            select FULL_NAME
            from SA_USERS
            where USER_ID =  r.CRE_BY*/
    end avatar_name

from UMS_FORUM_REPLY r
where FORUM_ID = '41' 
order by CRE_DT asc
/
select DBMS_LOB.substr(REPLY_DESC, 4000) REPLY_DESC, FORUM_ID, REPLY_ID, IS_STUDENT, CRE_BY, CRE_DT,
fnc_avatar_name(CRE_BY, IS_STUDENT) avatar_name
from UMS_FORUM_REPLY
where FORUM_ID = '41' 
order by CRE_DT asc
/

select d.REPLY_ID
from UMS_FORUM_MST m, UMS_FORUM_REPLY d
where m.FORUM_ID = d.FORUM_ID
and d.CRE_DT = (select max(CRE_DT) from UMS_FORUM_REPLY where FORUM_ID = m.FORUM_ID and CRE_BY = d.CRE_BY)
and m.FORUM_ID = '41' 
group by d.REPLY_ID, d.CRE_BY
/
create or replace function fnc_avatar_name (p_id number, p_flg varchar2)
return varchar2 is 
v_avatar_name varchar2(200);
begin
if p_flg = 'Y' then
select FULL_NAME_EN
into v_avatar_name
from STUDENT_PERSONAL_INFO
where STUDENT_ID = p_id;
elsif p_flg = 'N' then
select FULL_NAME
into v_avatar_name
from SA_USERS
where USER_ID = p_id;
else
null;
end if; 
return v_avatar_name;
exception
when others then 
return null; 
end;

/

create or replace function fnc_avatar_name (p_id number, p_stdflf varchar2, p_flg varchar2)
return varchar2 is 
    v_avatar_name varchar2(200);
begin
    if p_flg = 'S' then
        if p_stdflf = 'Y' then
            select  FULL_NAME_EN
            into v_avatar_name
            from STUDENT_PERSONAL_INFO
            where STUDENT_ID = p_id;
        elsif p_stdflf = 'N' then
            select FULL_NAME
            into v_avatar_name
            from SA_USERS
            where USER_ID = p_id;
        else
            null;
        end if;    
    elsif p_flg = 'G' then
         if p_stdflf = 'Y' then
            select  GENDER
            into v_avatar_name
            from STUDENT_PERSONAL_INFO
            where STUDENT_ID = p_id;
        elsif p_stdflf = 'N' then
            select GENDER
            into v_avatar_name
            from SA_USERS
            where USER_ID = p_id;
        else
            null;
        end if;    
    
    else
        null;    
    end if;    
   
    return v_avatar_name;
        
exception
    when others then 
    return null;        
end;

/









