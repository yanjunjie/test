<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Models\Ati_sausers; 
use App\Models\WorkReports;
use App\models\LeaveModel ;
use App\models\EmployeeModel;
use Illuminate\Support\Facades\Auth; 
use Validator;
use DB;
use PDO;
use Mail;
Use Session;

use Doctrine\DBAL\Driver\PDOConnection;

define('FIREBASE_API_KEY', 'AIzaSyBJGX9JUpuoEYPESb8KrdfHqoZsLpSAHvg');
//define('FIREBASE_API_KEY', 'AAAARqgeHZs:APA91bFPbCztV-JruaVxs_mwGH18ogHbomoVSmUQhFFNRmNjzMpjCvRd79-195xHOK8v2N-qkW5gUlmcecUfG_qp0zIBmtmTxvH4uPoazxfbBdwL5yN7BuQ9ZuyKR3UjzteHZrk-otd_');

class UserController extends Controller 
{
    public $successStatus = 200;
/** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
public function login(){ 

 $userdata = array(
    'AUSER_NAME'   => request('email'),
    'ASTATUS_FG'   => '1',
    'password'     =>request('password')
            //'FCM_REG_ID'     =>request('fcm')
);
 if (Auth::attempt($userdata)) {
   $user = Auth::User();
            //start fcm id
            //get apps fcm registration id from android
   $post_fcm_reg_id=request('fcm_reg_id'); 
   $FCM_REG_ID =  Auth::user()->FCM_REG_ID;
   if(!empty($post_fcm_reg_id)){
    if(!empty($FCM_REG_ID)){
        if( $post_fcm_reg_id != $FCM_REG_ID){
           DB::table('ATI_SAUSERS')->where('SAUSERS_ID','=', Auth::user()->SAUSERS_ID)->update(['FCM_REG_ID' => $post_fcm_reg_id]);
       }
   }else{
    DB::table('ATI_SAUSERS')->where('SAUSERS_ID','=', Auth::user()->SAUSERS_ID)->update(['FCM_REG_ID' => $post_fcm_reg_id]);
}    
}

             //end fcm id

$pdo = DB::getPdo();
$p_sausersid =  Auth::user()->SAUSERS_ID;
$p_employeid =  Auth::user()->EMPLOYE_ID;
$p_acpinfoid =  Auth::user()->ACPINFO_ID;
$p_mnlagrpid =  Auth::user()->MNLAGRP_ID;
$p_baselnkid =  Auth::user()->BASELNK_ID;
$p_desgtonid =  Auth::user()->DESGTON_ID;
$p_deprtmnid =  Auth::user()->DEPRTMN_ID;
$p_companyid =  Auth::user()->COMPANY_ID;


$stmt = $pdo->prepare("begin 
 pkg_userinfo.prc_usrlogin(:p_sausersid,:p_employeid,:p_acpinfoid,:p_mnlagrpid,
 :p_baselnkid,:p_desgtonid,:p_deprtmnid,:p_companyid, 
 :p_designame,:p_deprtname,:p_agrpename,:p_agrp_nkey,
 :p_controler,:p_route_url,:p_atiafw_id,:p_recshowfg, 
 :p_dateftype,:p_timeftype,:p_dttiftype,:p_ogcbuname,
 :p_ogcbudimg ); 
 end;");

$stmt->bindParam(':p_sausersid', $p_sausersid, PDO::PARAM_STR,14);
$stmt->bindParam(':p_employeid', $p_employeid, PDO::PARAM_STR,14);
$stmt->bindParam(':p_acpinfoid', $p_acpinfoid, PDO::PARAM_STR,14);
$stmt->bindParam(':p_mnlagrpid', $p_mnlagrpid, PDO::PARAM_STR,14);
$stmt->bindParam(':p_baselnkid', $p_baselnkid, PDO::PARAM_STR,14);
$stmt->bindParam(':p_desgtonid', $p_desgtonid, PDO::PARAM_STR,14); 
$stmt->bindParam(':p_deprtmnid', $p_deprtmnid, PDO::PARAM_STR,14); 
$stmt->bindParam(':p_companyid', $p_companyid, PDO::PARAM_STR,14); 
$stmt->bindParam(':p_designame', $p_designame, PDO::PARAM_STR,200);
$stmt->bindParam(':p_deprtname', $p_deprtname, PDO::PARAM_STR,200); 
$stmt->bindParam(':p_agrpename', $p_agrpename, PDO::PARAM_STR,200);
$stmt->bindParam(':p_agrp_nkey', $p_agrp_nkey, PDO::PARAM_STR,200);
$stmt->bindParam(':p_controler', $p_controler, PDO::PARAM_STR,200);
$stmt->bindParam(':p_route_url', $p_route_url, PDO::PARAM_STR,200);
$stmt->bindParam(':p_atiafw_id', $p_atiafw_id, PDO::PARAM_STR,14);
$stmt->bindParam(':p_recshowfg', $p_recshowfg, PDO::PARAM_INT,1);
$stmt->bindParam(':p_dateftype', $p_dateftype, PDO::PARAM_STR,14);
$stmt->bindParam(':p_timeftype', $p_timeftype, PDO::PARAM_STR,14);
$stmt->bindParam(':p_dttiftype', $p_dttiftype, PDO::PARAM_STR,24);
$stmt->bindParam(':p_ogcbuname', $p_ogcbuname, PDO::PARAM_STR,120);
$stmt->bindParam(':p_ogcbudimg', $p_ogcbudimg, PDO::PARAM_STR,200);


$stmt->execute();


$user_details =array(
    'DESIG_NAME'=> $p_designame,
    'DEPRT_NAME'=> $p_deprtname,

    'AGRP_ENAME'=> $p_agrpename,
    'AGRP_N_KEY'=> $p_agrp_nkey,
    'CONTROLLER'=> $p_controler,
    'ROUTE_URLS'=> $p_route_url,
    'ATI_AFW_ID'=> $p_atiafw_id,
    'RECSHOW_FG'=> $p_recshowfg,


                 'DATE_FTYPE'=> $p_dateftype, // 'd-m-Y';
                 'TIME_FTYPE'=> $p_timeftype, // 'h:i A';
                 'DTTI_FTYPE'=> $p_dttiftype, // 'd/m/Y H:i'; date time formate

                 'OGCBU_NAME'=> $p_ogcbuname,
                 'OGCBU_DIMG'=> $p_ogcbudimg,
                 
                 
                 'PK_PLUSVAL'=> (((date('ym')*10)+0)*1000000000),
                 'COMPANY_NO' =>1
             );

$allmodules=DB::select(DB::raw("SELECT MMNLINK_ID, MLINK_NAME, MENUB_ICON 
    FROM   ATI_MMNLINK 
    WHERE  MMNLINK_ID IN (SELECT  MODLINK_ID FROM ATI_GRPLINK WHERE MNLAGRP_ID = $p_mnlagrpid AND ASTATUS_FG = 1)
    and    MNLNK_TYPE = 'M'
    AND    ASTATUS_FG = 1 
    and MOB_APP_FG=1
    AND    ATI_AFW_ID = $p_atiafw_id
    ORDER BY  USERDSL_NO"));
                // $allmodulesL = array();
foreach($allmodules as $allmodule) {



   $all_module_list[] = array(
    'MMNLINK_ID' => $allmodule->MMNLINK_ID,
    'MLINK_NAME' => $allmodule->MLINK_NAME,
    'MENUB_ICON' => $allmodule->MENUB_ICON,
    'SUB_MODULE_LIST' =>  DB::select(DB::raw("SELECT  gl.mmnlink_id, gl.mlink_name, gl.mnlnk_type, gl.crudlac_fg,
     gl.crudlar_fg, gl.crudlau_fg, gl.crudlad_fg, gl.rpt_prt_fg,
     gl.accessb_fg, gl.baselnk_id, bl.route_urls, bl.methodtype,
     bl.controller, gl.userdsl_no
     FROM ati_baselnk bl,
     (SELECT NVL (gl.mmnlink_id, ml.mmnlink_id) mmnlink_id, ml.mlink_name,
     ml.mnlnk_type, gl.crudlac_fg, gl.crudlar_fg, gl.crudlau_fg,
     gl.crudlad_fg, gl.rpt_prt_fg, gl.accessb_fg, ml.baselnk_id,
     NVL (gl.userdsl_no, ml.userdsl_no) userdsl_no
     FROM ati_mmnlink ml,
     (SELECT gl.mmnlink_id, gl.crudlac_fg, gl.crudlar_fg,
     gl.crudlau_fg, gl.crudlad_fg, gl.rpt_prt_fg,
     gl.accessb_fg, gl.userdsl_no
     FROM ati_grplink gl
     WHERE gl.mnlagrp_id = $p_mnlagrpid
     AND modlink_id = $allmodule->MMNLINK_ID
     AND gl.astatus_fg = 1) gl
     WHERE ml.mmnlink_id = gl.mmnlink_id
     AND ptgmlnk_id = $allmodule->MMNLINK_ID
     AND MOB_APP_FG = 1
     AND astatus_fg = 1) gl
     WHERE bl.baselnk_id(+) = gl.baselnk_id
     AND NVL (maptype_id, 'M') = 'M'
     AND NVL (astatus_fg, 1) = 1
     ORDER BY userdsl_no
     "))
);
}

            //user photo convert
$file_name=DB::select(DB::raw("SELECT EMPL_PHOTO,SORGNDR_ID 
    FROM   HRV_EMPLYEE 
    WHERE  
    ASTATUS_FG=1
    AND    EMPLOYE_ID = $p_employeid
    "));





$emp_photo_name= $file_name[0]->EMPL_PHOTO;
$file_path = 'UPLOADS/ATTACHMENT/EMPLOYEE/';
$user_photo='';
if(!empty($emp_photo_name)){
    $file_path_name=$file_path. $emp_photo_name;               
    $type = pathinfo($file_path_name, PATHINFO_EXTENSION);
    $user_photo_file = file_get_contents($file_path_name);
    $user_photo = 'data:image/' . $type . ';base64,' . base64_encode($user_photo_file);
}else if(empty($emp_photo_name) && $file_name[0]->SORGNDR_ID == 'M' ){

    $file_path_name='UPLOADS/ATTACHMENT/EMPLOYEE/EMPLMPHOTO.png';
    $type = pathinfo($file_path_name, PATHINFO_EXTENSION);
    $user_photo_file = file_get_contents($file_path_name);
    $user_photo = 'data:image/' . $type . ';base64,' . base64_encode($user_photo_file);
}else if(empty($emp_photo_name) && $file_name[0]->SORGNDR_ID == 'F' ){
    $file_path_name='UPLOADS/ATTACHMENT/EMPLOYEE/EMPLFPHOTO.png';
    $type = pathinfo($file_path_name, PATHINFO_EXTENSION);
    $user_photo_file = file_get_contents($file_path_name);
    $user_photo = 'data:image/' . $type . ';base64,' . base64_encode($user_photo_file);

}else if(empty($emp_photo_name)) {
   $file_path_name='UPLOADS/ATTACHMENT/EMPLOYEE/EMPLMFPHOTO.png';
   $type = pathinfo($file_path_name, PATHINFO_EXTENSION);
   $user_photo_file = file_get_contents($file_path_name);
   $user_photo = 'data:image/' . $type . ';base64,' . base64_encode($user_photo_file);
}     

$today = date('d-M-Y');

$BIOMETICID = DB::selectOne(DB::raw("SELECT e.BIOMETICID from hr_employee e 
    where e.EMPLOYE_ID='$p_employeid'"));
                //echo $BIOMETICID->BIOMETICID; exit();
$countLate = DB::selectOne(DB::raw("SELECT count(a.A_IIN_TIME) CONT_IN_TIME from HR_ATENDNCE a
    where a.BIOMETICID=$BIOMETICID->BIOMETICID
    and  to_char(a.ATEDNCE_DT,'MMYY') =  to_char(SYSDATE,'MMYY')
    and a.A_IIN_TIME>=33360"));

$getCount = $countLate->CONT_IN_TIME;

$empAttendance = DB::select(DB::raw("SELECT (atten.A_IIN_TIME)logtime from HR_ATENDNCE atten
   where atten.BIOMETICID=$BIOMETICID->BIOMETICID and atten.ASTATUS_FG='1' and 
   atten.ATEDNCE_DT = TO_DATE('$today','dd-MM-YY')"));
                //print_r($empAttendance);eixt;

if($empAttendance){
    $loginTime = gmdate('h:i A', $empAttendance[0]->LOGTIME);
}else{
    $loginTime = 'Not entered yet!';
}                             

return response()->json([
    'success'=>true,
    'totalLate'  => $getCount,
    'TodayLoginTime'  => $loginTime,                                      
    'details'=>$user,
    'user_details'=>$user_details,
    'all_module_list'=>$all_module_list,
    'user_photo' =>$user_photo,


]);

}                    
}

public function dashboard(Request $request){
    $input =  $request->json()->all();
    $P_EMPLOYEID= $input['EMPLOYE_ID']; 
    $today = date('d-M-Y');

    $BIOMETICID = DB::selectOne(DB::raw("SELECT e.BIOMETICID from hr_employee e 
        where e.EMPLOYE_ID='$P_EMPLOYEID'"));
                //echo $BIOMETICID->BIOMETICID; exit();
    $countLate = DB::selectOne(DB::raw("SELECT count(a.A_IIN_TIME) CONT_IN_TIME from HR_ATENDNCE a
        where a.BIOMETICID=$BIOMETICID->BIOMETICID
        and  to_char(a.ATEDNCE_DT,'MMYY') =  to_char(SYSDATE,'MMYY')
        and a.A_IIN_TIME>=33360"));

    $getCount = $countLate->CONT_IN_TIME;

    $empAttendance = DB::select(DB::raw("SELECT (atten.A_IIN_TIME)logtime from HR_ATENDNCE atten
       where atten.BIOMETICID=$BIOMETICID->BIOMETICID and atten.ASTATUS_FG='1' and 
       atten.ATEDNCE_DT = TO_DATE('$today','dd-MM-YY')"));
                //print_r($empAttendance);eixt;

    if($empAttendance){
        $loginTime = gmdate('h:i A', $empAttendance[0]->LOGTIME);
    }else{
        $loginTime = 'Not entered yet!';
    }                             

    return response()->json([
        'success'=>true,
        'totalLate'  => $getCount,
        'TodayLoginTime'  => $loginTime


    ]);

}



public function getAppSignOut() {         
 unset(Auth::user()->key);
 return response()->json([
    'success'=>true 
]);
}

    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], $this-> successStatus); 
    } 
    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function empMovementView() 
    { 

        $allClients=DB::table('ATI_CLIENTS')
        ->where('ATI_CLIENTS.ASTATUS_FG','=',1)
        ->orderBy('ATI_CLIENTS.CLIENTS_ID','=','ATI_CLIENTS.CLIENTS_ID')
        ->get();

        $allProject=DB::table('ATI_PROJECT')
        ->where('ATI_PROJECT.ASTATUS_FG','=',1)
        ->orderBy('ATI_PROJECT.PROJECT_ID','=','ATI_PROJECT.PROJECT_ID')
        ->get(); 

        $allEmployee=DB::table('HR_EMPLOYEE')
        ->where('HR_EMPLOYEE.ASTATUS_FG','=',1)
        ->orderBy('HR_EMPLOYEE.EMPLOYE_ID','=','HR_EMPLOYEE.EMPLOYE_ID')
        ->get(); 

        $movementStartVisit=DB::table('HRV_VISTFRM')
        ->where('HRV_VISTFRM.ASTATUS_FG','=',1)
        ->get();

        $movementTitle=DB::table('HRV_OMTITLE')
        ->select('HRV_OMTITLE.*')
        ->where('HRV_OMTITLE.ASTATUS_FG','=','1')
        ->get();        
        $movementDtyp=DB::table('HRV_MVTDTYP')
        ->select('HRV_MVTDTYP.*')
        ->where('HRV_MVTDTYP.ASTATUS_FG','=','1')
        ->get();        


        
        return response()->json([
            'success'=>true, 
            'clients'=>$allClients,
            'projects'=>$allProject,
            'employee'=>$allEmployee,
            'movementStartVisit'=>$movementStartVisit,
            'movementTitle'=>$movementTitle,
            'movementDtyp'=>$movementDtyp,



        ]);

    }  

    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function supportTicket() 
    { 
        $allClients= DB::table('ATI_CLIENTS')
        ->where('ATI_CLIENTS.ASTATUS_FG','=',1)
        ->orderBy('ATI_CLIENTS.CLIENTS_ID','=','ATI_CLIENTS.CLIENTS_ID')
        ->get();

        $allProject=  DB::table('ATI_PROJECT')
        ->where('ATI_PROJECT.ASTATUS_FG','=',1)
        ->orderBy('ATI_PROJECT.PROJECT_ID','=','ATI_PROJECT.PROJECT_ID')
        ->get(); 
        $ticketPriority = DB::table('SMV_TKT_PRI')
        ->select('TKT_PRI_ID', 'T_PRIORITY')
        ->get();

        $requestType =  DB::table('SMV_TR_TYPE')
        ->select('TR_TYPE_ID', 'T_REQ_TYPE')
        ->get(); 

        $requestMode=DB::table('SMV_TR_MODE')
        ->select('TR_MODE_ID', 'T_REQ_MODE')
        ->get(); 

        $ticketStatus=DB::table('SMV_TKTSTUS')
        ->select('TKTSTUS_ID', 'TICKSTATUS')
        ->get();

        
        
        return response()->json([
            'success'=>true, 
            'clients'=>$allClients,
            'projects'=>$allProject,
            'ticketPriority'=>$ticketPriority,
            'requestType'=>$requestType,
            'requestMode'=>$requestMode,
            'ticketStatus'=>$ticketStatus

        ]);

    } 
     /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
     public function saveEmpMovement(Request $request) 
     { 

        $input=  $request->json()->all();
        $PRIMARY_IDD=DB::select(DB::raw("SELECT
            FNC_primekey('SEQ_ATI_EMP_MOVEMENT','1') NEXT_PK from dual"));
        $PRIMARY_ID = $PRIMARY_IDD[0]->NEXT_PK;
        DB::table('HR_MOVT_REC')->insert([
            'MOVTREC_ID' => $PRIMARY_ID,
            'MOVT_LADDR' => $input['ClientAddress'],
            'CLIENTS_ID' => $input['clientName'],
            'A_DURATION' => $input['durationTime'],
            'MOVEMNT_DT' =>date('Y-m-d', strtotime( $input['fromdate'])),
            'EMOVT_DESC' => $input['movementPurpose'],
            'OMTITLE_ID' => $input['movementTitle'],
            'PRESENCEON' => $this->convertSecond($input['presenceOn']),
            'PROJECT_ID' => $input['projectName'],
            'MOVT_ET_DT' => date('Y-m-d', strtotime( $input['todate'])), 
            'VISITS_FRM' => $input['startVisit'],
            'MVTDTYP_ID' => $input['durationType'],
            'M_LATITUDE' => $input['latitude'],
            'M_LONGITDE' => $input['longitde'],                                       
            'CREATED_BY' =>  $input['createdby']                                        
        ]);

        $employeeNameArray= explode(",",$input['employeeAllName']);
        //print_r($employeeNameArray);exit;
        foreach ($employeeNameArray as $row) {

            $PRIMARY_DTL=DB::select(DB::raw("SELECT FNC_primekey('SEQ_ATI_EMP_MOVEMENT_DTL','1') NEXT_PK from dual"));
            $PRIMARY_ID_DTL = $PRIMARY_DTL[0]->NEXT_PK;
            DB::table('HR_MOVT_EMP')->insert([
                'MOVTEMP_ID' => $PRIMARY_ID_DTL,
                'MOVTREC_ID' => $PRIMARY_ID,
                'EMPLOYE_ID' => $row,
                'MOVEMNT_DT' => date('Y-m-d', strtotime( $input['fromdate'])), 
            ]);

        } 

        return response()->json([
            'success'=>true,

        ]);

    }
    public static function convertSecond($conSecond){
        $secondCal= date("H:i", strtotime($conSecond));
        $second=strtotime($secondCal)- strtotime('TODAY');
        return $second;
    }
    public function empWiseMovementList() 
    { 

        $EMPLOYE_ID= request('EMPLOYE_ID');
        
        $empWiseMovList=DB::select(DB::raw("SELECT distinct(mr.MOVTREC_ID),mr.OMTITLE_ID ,mr.EMOVT_DESC,mr.MOVEMNT_DT,mr.MOVT_LADDR,mr.ACTON_TIME,mr.A_DURATION,mr.PRESENCEON,mr.NOOFPERSON,mr.CREATED_BY,mr.MOVT_LADDR,mr.MVTDTYP_ID,
            mr.MOVT_SF_DT,mr.MOVT_STIME,mr.MOVT_ET_DT,mr.MOVT_ETIME,mr.MVERIFY_FG,mr.CLIENTS_ID,mr.PROJECT_ID,mr.VISITS_FRM,mr.ASTATUS_FG,cli.CLINT_NAME,pro.PROJT_NAME,omt.OMTTL_NAME,vf.SVIST_NAME
            from HR_MOVT_REC mr
            left join ati_clients cli on mr.CLIENTS_ID=cli.CLIENTS_ID
            left join ati_project pro on mr.PROJECT_ID=pro.PROJECT_ID
            left join HRV_OMTITLE omt on mr.OMTITLE_ID=omt.OMTITLE_ID
            left join HRV_VISTFRM vf on mr.VISITS_FRM=vf.VISTFRM_ID
            left join HR_MOVT_EMP memp on mr.MOVTREC_ID=memp.MOVTREC_ID
            where memp.EMPLOYE_ID=$EMPLOYE_ID or mr.CREATED_BY=$EMPLOYE_ID
            order by mr.MOVTREC_ID desc"));
        
        

        return response()->json([
            'success'=>true, 
            'empWiseMovList'=>$empWiseMovList


        ]);

    }
    
    public function saveCallerInformation(Request $request){
        $PRIMARY_IDD=DB::select(DB::raw("SELECT FNC_primekey('SM_CALLINFO_SEQ','1') NEXT_PK from dual"));
        $PRIMARY_ID = $PRIMARY_IDD[0]->NEXT_PK;

        $input=  $request->json()->all();

        $p_calinfo_id=$PRIMARY_ID;
        $p_calltyp_id=$input['callType'];
        $p_call_xnmbr= $input['clientPhoneNumber'];
        $p_call_ynmbr= $input['ownPhoneNumber'];
        $p_xnmbr_text= $input['dialerText'];
        $p_ynmbr_text= $input['reciverText'];
        $p_tcallt_dur = $input['callDuration'];
        $p_drmcall_dt= date('d-M-Y',strtotime($input['callDate'])); 
        $p_perform_by=$input['createdby']; 
//start procedure 
        $pdo = DB::getPdo();        
        $call_information = $pdo->prepare("begin 
           PKG_CALLINFO.PRC_CALLINFO(
           :p_calinfo_id, 
           :p_calltyp_id, 
           :p_drmcall_dt, 
           :p_call_xnmbr,
           :p_xnmbr_text, 
           :p_call_ynmbr,
           :p_ynmbr_text,
           :p_drslt_text,
           :p_tcallt_dur,
           :p_perform_by,
           :p_company_id,
           :p_cbranch_id,
           :p_cobunit_id,
           :p_ptgunit_id,
           :p_pkplusval
           ); 
           end;");

        $call_information->bindParam(':p_calinfo_id', $p_calinfo_id, PDO::PARAM_STR,14);
        $call_information->bindParam(':p_calltyp_id', $p_calltyp_id, PDO::PARAM_STR,16);
        $call_information->bindParam(':p_drmcall_dt', $p_drmcall_dt, PDO::PARAM_STR,14);
        $call_information->bindParam(':p_call_xnmbr', $p_call_xnmbr, PDO::PARAM_STR,14);
        $call_information->bindParam(':p_xnmbr_text', $p_xnmbr_text, PDO::PARAM_STR,14);
        $call_information->bindParam(':p_call_ynmbr', $p_call_ynmbr, PDO::PARAM_STR,14);
        $call_information->bindParam(':p_ynmbr_text', $p_ynmbr_text, PDO::PARAM_STR,14);
        $call_information->bindParam(':p_drslt_text', $p_drslt_text, PDO::PARAM_STR,14);
        $call_information->bindParam(':p_tcallt_dur', $p_tcallt_dur, PDO::PARAM_STR,14);
        $call_information->bindParam(':p_perform_by', $p_perform_by, PDO::PARAM_STR,14);
        $call_information->bindParam(':p_company_id', $p_company_id, PDO::PARAM_STR,14);
        $call_information->bindParam(':p_cbranch_id', $p_cbranch_id, PDO::PARAM_STR,14);
        $call_information->bindParam(':p_cobunit_id', $p_cobunit_id, PDO::PARAM_STR,14);
        $call_information->bindParam(':p_ptgunit_id', $p_ptgunit_id, PDO::PARAM_STR,14);
        $call_information->bindParam(':p_pkplusval', $p_pkplusval, PDO::PARAM_STR,14);

        if( $call_information->execute()){
           return response()->json([
            'success'=>true                                    

        ]);
       }


   }
   function dailyWorkReportForm($employee_id){

       $professional_projects = DB::select(DB::raw("SELECT project_id,
         FNC_CLNTABBR (clients_id) || ' :: ' || projt_name projt_name
         FROM ati_project
         WHERE 
         project_id in
         (select a.project_id
         from pj_rltd_emp a
         where     a.employe_id = $employee_id
         and a.astatus_fg = 1
         and a.recshow_fg = 1)

         and    astatus_fg = 1
         and    recshow_fg = 1
         order by  userdsl_no
         "));   
       $reporting_person = DB::select(DB::raw("select employe_id, efull_name

        from   hr_employee

        where  
        ofie_email is not null

        and    astatus_fg = 1

        and    recshow_fg = 1

        order by  userdsl_no"));


       return response()->json([
        'success'=>true,                                    
        'professional_projects'=>$professional_projects,                                    
        'reporting_person'=>$reporting_person                                    

    ]);


   }
   function saveDailyWorkReport(Request $request){
    $input=  $request->json()->all();        
    $PRIMARY_IDD=DB::select(DB::raw("SELECT FNC_primekey('ATI_PDWREPS_SEQ','1') NEXT_PK from dual"));
    $PRIMARY_ID = $PRIMARY_IDD[0]->NEXT_PK; 
    $PROJECT_ID=$input['prjectName'];
    $CLI_ID=DB::selectOne(DB::raw("SELECT pro.CLIENTS_ID from ATI_PROJECT pro where pro.PROJECT_ID='$PROJECT_ID'"));
    $CLIENT_ID=$CLI_ID->CLIENTS_ID; 
    $ASSIGN_DT=$input['fromDate'];
    $cdate=$input['toDate'];
        // $indate='';
        // if(!empty($cdate)){
        //     $indate=date("Y-m-d",strtotime($input['WRKFCST_DT')));
        // }        
    $conSecond=$input['fromTime'];
    $conSecondE=$input['toTime'];

    $WASSIGN_DT=date("Y-M-d",strtotime($input['fromDate']));
    $WRKFCST_DT=date("Y-M-d",strtotime($input['toDate']));
    $WASGN_TIME=date("H:i A");
    $PWREP_TIME=date("H:i A");
    $CON_A_TIME=WorkReports::convertSecond($WASGN_TIME);
    $PWREP_R_TIME=WorkReports::convertSecond($PWREP_TIME);

    $sTime=WorkReports::convertSecond($conSecond);
    $cEndTime=WorkReports::conENdTimeSecond($conSecondE);

    DB::table('ATI_PDWREPS')->insert([
        'PDWREPS_ID' => $PRIMARY_ID,            
        'PROFEMP_ID' => $input['createdby'],
        'TASK_TITLE' => $input['taskTittle'],
        'TASK_DESCR' => $input['taskDetails'],
        'PROJECT_ID' => $PROJECT_ID,
        'WRKAEMP_ID'   => $input['assignBy'],
           // 'WRKAEMP_ID' => $input['WRKAEMP_ID'),
        'WRKSTATION' => $input['workStation'],
        'START_TIME' => $sTime, 
        'ENDTO_TIME' => $cEndTime, 
        'TCOMPL_PCT' => $input['taskStatus'], 
           // 'RPERSON_ID' => Input::get('RPERSON_ID'),
        'CLIENTS_ID' => $CLIENT_ID,
        'WASSIGN_DT' => $WASSIGN_DT,
        'WASGN_TIME' => $CON_A_TIME,
        'PWREP_TIME' =>$PWREP_R_TIME,
        'WRKFCST_DT' => $WRKFCST_DT, 
        'ASTATUS_FG' => 1,
        'COMPANY_ID' => $input['companyId'],
        'CBRANCH_ID' => $input['companyBranchId'],
        'COBUNIT_ID' => $input['companyBranchUnitId'],
        'PTGUNIT_ID' => $input['parentUnitId'],
        'CREATED_BY' => $input['createdby'],
        'CREATED_AT' => date("Y-m-d h:i:s")
    ]); 

    return response()->json([
        'success'=>true

    ]);

} 
function saveLeaveApplication(Request $request){

   $input=  $request->json()->all();
   $PRIMARY_IDD=DB::select(DB::raw("SELECT FNC_primekey('MM_ITEMINFO_SEQ','1') NEXT_PK from dual"));
   $PRIMARY_ID = $PRIMARY_IDD[0]->NEXT_PK;
   $leave_id= DB::table('HR_LEAVETYP')
   ->where('HR_LEAVETYP.LTYPE_NAME','=',$input['LEAV_CATEG'])
   ->first();


           //earn leave data     
   $data = array(
    'LAV_APP_ID' =>$PRIMARY_ID,
    'LAV_REASON' =>$input['LAV_REASON'], 
    'EMPLOYE_ID' =>$input['CREATED_BY'], 
    'LEAVETP_ID' =>$leave_id->LEAVETP_ID,
    'L_START_DT' => date('Y-m-d',strtotime($input['L_START_DT'])),             
    'L_ENDTO_DT' => date('Y-m-d',strtotime($input['L_ENDTO_DT'])),
    'LAV_REQ_DT' => date('Y-m-d',strtotime($input['LAV_REQ_DT'])),
    'STATJRN_AT' => date('Y-m-d',strtotime($input['STATJRN_AT'])),
    'DLWYW_STAY' =>$input['DLWYW_STAY'],
    'EMERG_CONS' =>$input['EMERG_CONS'],
    'L_DURATION' =>$input['L_DURATION'],
    'L_DUR_TYPE' =>$input['L_DUR_TYPE'],
    'NO_OF_DAYS' =>$input['NO_OF_DAYS'],
    'UGO_WITHUR' =>$input['UGO_WITHUR'],
    'LAV_REQ_BY' =>$input['LAV_REQ_BY'],
    'PTGUNIT_ID' =>$input['PTGUNIT_ID'],
    'CBRANCH_ID' =>$input['CBRANCH_ID'],
    'COBUNIT_ID' =>$input['COBUNIT_ID'],   
    'COMPANY_ID' =>$input['COMPANY_ID'],
    'EMERG_CONS' =>$input['EMERG_CONS'],   
    'CREATED_AT' => date("Y-m-d h:i:s")
);
   DB::table('HR_LEAVEAPP')->insert($data);


   return response()->json([
    'success'=>true

]);
}

    // function leaveInformation($employee_id){ 
    //      $allLeaveTypes = DB::table('HRV_LAPPTYP')->get(); 
    //      return response()->json([
    //                                 'success'=>true,                                    

    //                                 'leave_type'=>$allLeaveTypes
    //                             ]);
    //     }      

function leaveInformation(Request $request){

   $input=  $request->json()->all();
   $employe_id=$input['EMPLOYE_ID'];



   $allLeaveTypes = DB::table('HRV_LAPPTYP')->get();
   $leaveType=DB::table('HR_LEAVETYP')
   ->where('HR_LEAVETYP.ASTATUS_FG','=',1)
   ->get();


   return response()->json([
    'success'=>true,                                  
    'leave_menu'=>$allLeaveTypes,
    'leave_type'=>$leaveType    
]);


}
function empWiseTaskList(Request $request){

    $input=  $request->json()->all();

    $USEREMP_ID=$input['USEREMP_ID'];
    $COMPANY_ID=$input['COMPANY_ID'];
    $CBRANCH_ID=$input['CBRANCH_ID'];
    $COBUNIT_ID=$input['COBUNIT_ID'];
    $todayTask=DB::select(DB::raw("SELECT   WRK.PDWREPS_ID, WRK.PROJECT_ID,(FNC_CLNTABBR(CLIENTS_ID) || ' :: '  || FNC_PROJNAME (PROJECT_ID)) as PROJT_NAME,
     WRK.TASK_TITLE, FNC_EFULNAME (WRKAEMP_ID) ASSIGN_EMP, WRK.WASSIGN_DT,
     WRK.START_TIME, WRK.ENDTO_TIME,WRK.PROWREP_DT,WRK.TASK_DESCR,
     CASE
     WHEN WASSIGN_DT = TRUNC (SYSDATE)
     AND  PROWREP_DT = TRUNC (SYSDATE)
     THEN 'New'
     ELSE 'Old'
     END TASK_STAUS,
     WRK.PCOMPL_PCT,
     WRK.TCOMPL_PCT, WRK.WRKFCST_DT, PWREP_TIME,
     WRK.WRKSTATION
     FROM ATI_PDWREPS WRK
     WHERE PROFEMP_ID = $USEREMP_ID
     AND (   (TCOMPL_PCT = 100 AND PROWREP_DT = TRUNC (SYSDATE))
     OR TCOMPL_PCT < 100)
     AND WRK.COMPANY_ID = nvl($COMPANY_ID,WRK.COMPANY_ID)
     AND WRK.CBRANCH_ID = nvl($CBRANCH_ID,WRK.CBRANCH_ID)
     AND WRK.COBUNIT_ID = nvl($COBUNIT_ID,WRK.COBUNIT_ID)  
     ORDER BY WRK.PROWREP_DT DESC, WRK.PWREP_TIME")); 

    $emp_info = DB::selectOne(DB::raw("SELECT emp.EMP_TEMP_TO, emp.EMP_TEMP_CC, emp.EFULL_NAME from hr_employee emp where emp.EMPLOYE_ID='$USEREMP_ID'")); 
    $email_info=array(
        'email_to'=>   DB::selectOne(DB::raw("SELECT emm.RPERSON_ID,empe.OFIE_EMAIL OFIE_EMAIL_TO
         from WR_EMPNSDWR emm
         left join hr_employee empe on emm.RPERSON_ID=empe.EMPLOYE_ID 
         where emm.PROFEMP_ID='$USEREMP_ID'")),
        'email_cc'=>DB::select(DB::raw("SELECT distinct(emd.RCPNEMP_ID),emp.OFIE_EMAIL,emd.RCPNEMP_ID,empe.OFIE_EMAIL OFIE_EMAIL_CC,empe.USERDSL_NO
            from  WR_EWRREMIL emd
            left join hr_employee emp on emd.PROFEMP_ID=emp.EMPLOYE_ID 
            left join hr_employee empe on emd.RCPNEMP_ID=empe.EMPLOYE_ID 
            where emd.PROFEMP_ID='$USEREMP_ID' and emd.EMAILRT_ID='CC' order by empe.USERDSL_NO asc")),
        'email_bcc'=>DB::select(DB::raw("SELECT distinct(emd.RCPNEMP_ID),emp.OFIE_EMAIL,emd.RCPNEMP_ID,empe.OFIE_EMAIL OFIE_EMAIL_BCC
            from  WR_EWRREMIL emd
            left join hr_employee emp on emd.PROFEMP_ID=emp.EMPLOYE_ID 
            left join hr_employee empe on emd.RCPNEMP_ID=empe.EMPLOYE_ID 
            where emd.PROFEMP_ID='$USEREMP_ID' and emd.EMAILRT_ID='BCC'"))
    );  

    $completeTask=DB::select(DB::raw("SELECT   WRK.PDWREPS_ID, WRK.PROJECT_ID, FNC_PROJNAME (PROJECT_ID) PROJT_NAME,
     WRK.TASK_TITLE, FNC_EFULNAME (WRKAEMP_ID) ASSIGN_EMP, WRK.WASSIGN_DT,
     WRK.START_TIME, WRK.ENDTO_TIME,WRK.PROWREP_DT,WRK.WRKAEMP_ID,
     CASE
     WHEN WASSIGN_DT = TRUNC (SYSDATE)
     AND PROWREP_DT = TRUNC (SYSDATE)
     THEN 'New'
     ELSE 'Old'
     END TASK_STAUS,
     WRK.PCOMPL_PCT,
     WRK.TCOMPL_PCT, WRK.WRKFCST_DT, PWREP_TIME,
     WRK.WRKSTATION
     FROM ATI_PDWREPS WRK
     WHERE PROFEMP_ID = '$USEREMP_ID'
     AND PROWREP_DT = TRUNC (SYSDATE) 
     AND WRK.COMPANY_ID = nvl($COMPANY_ID,WRK.COMPANY_ID)
     AND WRK.CBRANCH_ID = nvl($CBRANCH_ID,WRK.CBRANCH_ID)
     AND WRK.COBUNIT_ID = nvl($COBUNIT_ID,WRK.COBUNIT_ID) 

     ORDER BY WRK.PROWREP_DT DESC, PWREP_TIME"));

    return response()->json([
        'success'=>true,                                    
        'todayTask'=>$todayTask,             
        'completeTask'=>$completeTask,             
        'emp_info'=>$emp_info,             
        'email_info'=>$email_info             

    ]);
}
function updateDailyWorkReport(Request $request){
    $input=  $request->json()->all(); 

    $TCOMPL_PCT=$input['TCOMPL_PCT'];
    $empId=$input['createdby'];
    $task_id = $input["task_id"];
    $status=DB::selectOne(DB::raw("select wrk.TCOMPL_PCT from ati_pdwreps wrk where wrk.PDWREPS_ID='$task_id'"));
    $tstatus=$status->TCOMPL_PCT;
    if($TCOMPL_PCT<$tstatus){

    }else{
        $s_time = $input["START_TIME"];
        $s_time24 =  date("H:i", strtotime($s_time));
        $s_hm = explode(":", $s_time24);
        $startTime = ($s_hm[0]*60) + ($s_hm[1]);

        $e_time = $input["ENDTO_TIME"];
        $e_time24 =  date("H:i", strtotime($e_time));
        $e_hm = explode(":", $e_time24);
        $endTime = ($e_hm[0]*60) + ($e_hm[1]);
        $conSecond=$input["START_TIME"];
        $conSecondE=$input["ENDTO_TIME"];
        $sTime=WorkReports::convertSecond($conSecond);
        $cEndTime=WorkReports::conENdTimeSecond($conSecondE);
        $cdate=$input['WRKFCST_DT'];
        $indate='';
        if(!empty($cdate)){
            $indate=date("Y-m-d",strtotime($input['WRKFCST_DT']));
        }
        $updateTask = array(
            'TASK_TITLE' => $input['TASK_TITLE'],
            'TASK_DESCR' => $input['TASK_DESCR'],
            'START_TIME' => $sTime,
            'ENDTO_TIME' => $cEndTime,
            'TCOMPL_PCT' => $input['TCOMPL_PCT'],
            'PROWREP_DT' => date("Y-m-d"),
            'WRKFCST_DT' => $indate,
            'WRKSTATION' => $input['WRKSTATION'],
            'UPDATED_BY' => $empId,
            'UPDATED_AT' => date("Y-m-d h:i:s"),

        );
                   // var_dump($updateTask);exit;
        DB::table('ATI_PDWREPS')
        ->where('PDWREPS_ID', $task_id)
        ->update($updateTask); 

        return response()->json([
            'success'=>true                                    



        ]);

    }
}
function dailyWorkReportSendList(Request $request){

    $input=  $request->json()->all();

    $USEREMP_ID=$input['USEREMP_ID'];
    $COMPANY_ID=$input['COMPANY_ID'];
    $CBRANCH_ID=$input['CBRANCH_ID'];
    $COBUNIT_ID=$input['COBUNIT_ID'];

    $completeTask=DB::select(DB::raw("SELECT   WRK.PDWREPS_ID, WRK.PROJECT_ID,FNC_PROJNAME (PROJECT_ID) PROJT_NAME,
     WRK.TASK_TITLE, FNC_EFULNAME (WRKAEMP_ID) ASSIGN_EMP, WRK.WASSIGN_DT,
     WRK.START_TIME, WRK.ENDTO_TIME,WRK.PROWREP_DT,WRK.WRKAEMP_ID,
     CASE
     WHEN WASSIGN_DT = TRUNC (SYSDATE)
     AND PROWREP_DT = TRUNC (SYSDATE)
     THEN 'New'
     ELSE 'Old'
     END TASK_STAUS,
     WRK.PCOMPL_PCT,
     WRK.TCOMPL_PCT, WRK.WRKFCST_DT, PWREP_TIME,
     WRK.WRKSTATION
     FROM ATI_PDWREPS WRK
     WHERE PROFEMP_ID = '$USEREMP_ID'
     AND PROWREP_DT = TRUNC (SYSDATE) 
     AND WRK.COMPANY_ID = nvl($COMPANY_ID,WRK.COMPANY_ID)
     AND WRK.CBRANCH_ID = nvl($CBRANCH_ID,WRK.CBRANCH_ID)
     AND WRK.COBUNIT_ID = nvl($COBUNIT_ID,WRK.COBUNIT_ID) 

     ORDER BY WRK.PROWREP_DT DESC, PWREP_TIME"));

    $emp_info = DB::selectOne(DB::raw("SELECT emp.EMP_TEMP_TO, emp.EMP_TEMP_CC, emp.EFULL_NAME from hr_employee emp where emp.EMPLOYE_ID='$USEREMP_ID'")); 
    $email_info=array(
        'email_to'=>   DB::selectOne(DB::raw("SELECT emm.RPERSON_ID,empe.OFIE_EMAIL OFIE_EMAIL_TO
         from WR_EMPNSDWR emm
         left join hr_employee empe on emm.RPERSON_ID=empe.EMPLOYE_ID 
         where emm.PROFEMP_ID='$USEREMP_ID'")),
        'email_cc'=>DB::select(DB::raw("SELECT distinct(emd.RCPNEMP_ID),emp.OFIE_EMAIL,emd.RCPNEMP_ID,empe.OFIE_EMAIL OFIE_EMAIL_CC,empe.USERDSL_NO
            from  WR_EWRREMIL emd
            left join hr_employee emp on emd.PROFEMP_ID=emp.EMPLOYE_ID 
            left join hr_employee empe on emd.RCPNEMP_ID=empe.EMPLOYE_ID 
            where emd.PROFEMP_ID='$USEREMP_ID' and emd.EMAILRT_ID='CC' order by empe.USERDSL_NO asc")),
        'email_bcc'=>DB::select(DB::raw("SELECT distinct(emd.RCPNEMP_ID),emp.OFIE_EMAIL,emd.RCPNEMP_ID,empe.OFIE_EMAIL OFIE_EMAIL_BCC
            from  WR_EWRREMIL emd
            left join hr_employee emp on emd.PROFEMP_ID=emp.EMPLOYE_ID 
            left join hr_employee empe on emd.RCPNEMP_ID=empe.EMPLOYE_ID 
            where emd.PROFEMP_ID='$USEREMP_ID' and emd.EMAILRT_ID='BCC'"))
    );

    

    return response()->json([
        'success'=>true,                                    
        'completeTask'=>$completeTask,                                    
        'emp_info'=>$emp_info,                                    
        'email_info'=>$email_info,                                    




    ]);
}
function empWorkReportSendEmail(Request $request){

   $input=  $request->json()->all();      



   $emp_id = $input['employe_id'];
   $emp_name = $input['emp_name'];
   $name_with_underscore = str_replace(' ', '_', $emp_name);
   $from =$input['USER_EMAIL'];

   $email_to=  $input['email_info']['email_to']['OFIE_EMAIL_TO'];
         //cc emails
   $cc_email=$input['email_info']['email_cc'];  
   for ($i=0; $i< sizeof($cc_email); $i++ ) {
       $cc[]=$cc_email[$i]['OFIE_EMAIL_CC'];
   }
         //bcc emails
   $bcc_email=$input['email_info']['email_bcc'];  
   for ($i=0; $i< sizeof($bcc_email); $i++ ) {
       $bcc[]=$bcc_email[$i]['OFIE_EMAIL_BCC'];
   }

   $date_time = date('Ymdhi');
   $data['other_info'] = DB::selectOne(DB::raw("SELECT c.orggcbu_id,
     c.ogcbu_name,
     c.adres_info,
     NVL (c.ogcbu_logo, '00000000000000.png') ogcbu_logo,
     c.employe_id,
     c.efull_name,
     c.desig_name,
     c.deprt_name,
     c.empl_photo,
     TO_CHAR (SYSDATE, 'DD-Mon-YYYY') prowrep_dt,
     c.rpson_name,
     fnc_profat2d (biometicid) paduration
     FROM (SELECT a.orggcbu_id,
     a.ogcbu_name,
     a.adres_info,
     a.ogcbu_logo,
     b.employe_id,
     b.efull_name,
     b.desig_name,
     b.deprt_name,
     b.empl_photo,
     b.biometicid,
     b.rpson_name
     FROM sa_orgngcbu a,
     (SELECT employe_id,
     efull_name,
     fnc_desgtion (desgton_id) desig_name,
     fnc_deprtmnt (deprtmn_id) deprt_name,
     NVL (empl_photo, '00000000000000.png') empl_photo,
     biometicid,
     fnc_wrepdes (employe_id) rpson_name,
     company_id
     FROM hr_employee
     WHERE employe_id = '$emp_id') b
     WHERE a.orggcbu_id = b.company_id) c"));
   $data['work_report_details'] = DB::select(DB::raw("SELECT   wrk.pdwreps_id, wrk.project_id, fnc_projname (project_id)
    projt_name,
    wrk.task_title, wrk.wrkaemp_id, wrk.wrkfcst_dt, wrk.prowrep_dt,
    TO_CHAR (TO_DATE (wrk.START_TIME, 'sssss'), 'HH12:MI AM')
    START_TIME,
    TO_CHAR (TO_DATE (wrk.ENDTO_TIME, 'sssss'), 'HH12:MI AM')
    ENDTO_TIME,wrk.pcompl_pct,
    wrk.tcompl_pct, wrk.wassign_dt, fnc_efulname (wrkaemp_id)
    assign_emp,
    pwrep_time, wrk.wrkstation
    FROM ati_pdwreps wrk
    WHERE profemp_id = '$emp_id'
    AND prowrep_dt = TRUNC (SYSDATE)
    ORDER BY wrk.START_TIME , pwrep_time"));
               // echo '<pre>';print_r($data['other_info']);exit;
   $data['title'] = 'Daily Work Report' . ', ' . date('d-M-Y') . ', ' . $data['other_info']->EFULL_NAME;
   if($bcc!=''){
    $sent = Mail::send('emails.work_report_email_apps', $data, function ($email) use ($data,$from,$email_to,$cc,$bcc) {
      $email->subject($data['title']);
      $email->from($from);
      $email->to($email_to);
      $email->cc($cc);
      $email->bcc($bcc);
  });
}else{
    $sent = Mail::send('emails.work_report_email_apps', $data, function ($email) use ($data,$from,$emil_to,$cc) {
      $email->subject($data['title']);
      $email->from($from);
      $email->to($emil_to);
      $email->cc($cc);
           // $email->bcc($bcc);

  });
}


          //call a oracle procedure
$pdo = DB::getPdo();
$P_PROFEMPID = $emp_id;
$P_DWRSENDDT = date('Y-M-d h:i:s');

$work_report_sending_message = $pdo->prepare("begin 
 pkg_DWREPORT.PRC_DREMLSND(:P_PROFEMPID, :P_DWRSENDDT, :p_WRMESSAGE 
 ); 
 end;");

$work_report_sending_message->bindParam(':P_PROFEMPID', $P_PROFEMPID, PDO::PARAM_STR,14);
$work_report_sending_message->bindParam(':P_DWRSENDDT', $P_DWRSENDDT, PDO::PARAM_STR,50);
$work_report_sending_message->bindParam(':p_WRMESSAGE', $p_WRMESSAGE, PDO::PARAM_STR,300);

$work_report_sending_message->execute();

return response()->json([
    'success'=>true   
]);
}


function ticketEmailSend(Request $request){
    $input=  $request->json()->all(); 
    $p_cticketid=$input['CTICKET_ID'];

         // START ::: send email after generate a ticket
    $data['form_email'] = 'rakib@atilimited.net';
    $data['form_name'] = 'Md. Rakib Mostofa';

    $data['to_email'] =  'support@atilimited.net';

    $data['to_name'] =  'ATI Support';
    $data['title'] = 'Support | ATI Limited :: Open Ticket :: Open Ticket :: High';
    $pdo = DB::getPdo();
    $p_cticketid = $p_cticketid;
    $p_dttiftype = 'd-M-Y';

    $NEW_TICKET_DETAILS = $pdo->prepare("begin 
       PKG_TKT_INFO.prc_anticket(:p_cticketid,:p_dttiftype, :p_ticketuid, :p_ticketgdt, :p_csttitles, 
       :p_ticktdesc, :p_tpriority, :p_tickstats, :p_treq_mode, :p_treq_type,
       :p_clientsid, :p_clintabbr, :p_projectid, :p_projtname, :p_cltcpname, :p_deprtname, :p_designame,
       :p_ccpmobile, :p_cltcemail

       ); 
       end;");

    $NEW_TICKET_DETAILS->bindParam(':p_cticketid', $p_cticketid, PDO::PARAM_STR,14);
    $NEW_TICKET_DETAILS->bindParam(':p_dttiftype', $p_dttiftype, PDO::PARAM_STR,20);
    $NEW_TICKET_DETAILS->bindParam(':p_ticketuid', $p_ticketuid, PDO::PARAM_STR,14);
    $NEW_TICKET_DETAILS->bindParam(':p_ticketgdt', $p_ticketgdt, PDO::PARAM_STR,22);
    $NEW_TICKET_DETAILS->bindParam(':p_csttitles', $p_csttitles, PDO::PARAM_STR,120);
    $NEW_TICKET_DETAILS->bindParam(':p_ticktdesc', $p_ticktdesc, PDO::PARAM_STR,300);
    $NEW_TICKET_DETAILS->bindParam(':p_tpriority', $p_tpriority, PDO::PARAM_STR,100);
    $NEW_TICKET_DETAILS->bindParam(':p_tickstats', $p_tickstats, PDO::PARAM_STR,100);
    $NEW_TICKET_DETAILS->bindParam(':p_treq_mode', $p_treq_mode, PDO::PARAM_STR,100);
    $NEW_TICKET_DETAILS->bindParam(':p_treq_type', $p_treq_type, PDO::PARAM_STR,100);
    $NEW_TICKET_DETAILS->bindParam(':p_clientsid', $p_clientsid, PDO::PARAM_STR,100);
    $NEW_TICKET_DETAILS->bindParam(':p_clintabbr', $p_clintabbr, PDO::PARAM_STR,100);
    $NEW_TICKET_DETAILS->bindParam(':p_projectid', $p_projectid, PDO::PARAM_STR,300);
    $NEW_TICKET_DETAILS->bindParam(':p_projtname', $p_projtname, PDO::PARAM_STR,300);
    $NEW_TICKET_DETAILS->bindParam(':p_cltcpname', $p_cltcpname, PDO::PARAM_STR,120);
    $NEW_TICKET_DETAILS->bindParam(':p_deprtname', $p_deprtname, PDO::PARAM_STR,120);
    $NEW_TICKET_DETAILS->bindParam(':p_designame', $p_designame, PDO::PARAM_STR,120);
    $NEW_TICKET_DETAILS->bindParam(':p_ccpmobile', $p_ccpmobile, PDO::PARAM_STR,22);
    $NEW_TICKET_DETAILS->bindParam(':p_cltcemail', $p_cltcemail, PDO::PARAM_STR,50);
    $NEW_TICKET_DETAILS->execute();

    $data['p_cticketid'] = $p_cticketid;
    $data['p_ticketgdt'] = $p_ticketgdt;
    $data['p_csttitles'] = $p_csttitles;
    $data['p_ticktdesc'] = $p_ticktdesc;
    $data['p_tpriority'] = $p_tpriority;
    $data['p_tickstats'] = $p_tickstats;
    $data['p_treq_mode'] = $p_treq_mode;
    $data['p_treq_type'] = $p_treq_type;
    $data['p_clintabbr'] = $p_clintabbr;
    $data['p_projtname'] = $p_projtname;
    $data['p_cltcpname'] = $p_cltcpname;
    $data['p_deprtname'] = $p_deprtname;
    $data['p_designame'] = $p_designame;
    $data['p_ccpmobile'] = $p_ccpmobile;
    $data['p_cltcemail'] = $p_cltcemail;
    $data['p_ticketuid'] = $p_ticketuid;

        //for client email address procedure

    $pdo = DB::getPdo();
    $stmt = $pdo->prepare("begin 
       pkg_cptemail.prc_cptemail(:p_clientsid,:p_projectid,:p_tcc_email); 
       end;");
    $stmt->bindParam(':p_clientsid', $p_clientsid, PDO::PARAM_STR,14);
    $stmt->bindParam(':p_projectid', $p_projectid, PDO::PARAM_STR,14);
    $stmt->bindParam(':p_tcc_email', $p_tcc_email, PDO::PARAM_STR,700);
    $stmt->execute();
    $cc_email= $p_tcc_email;
    $x = explode(',' ,  $cc_email);
    $data['cc']  = $x;
        //end for client email address procedure

    $data['ticket_id'] = $p_cticketid;
    $data['ticket_title'] = $p_csttitles; 

    Mail::send('emails.message_bdy', $data, function ($m) use ($data) {
        $m->from($data['form_email'], $data['form_name']);
        $m->to($data['to_email'], $data['to_name']);
                //$m->cc($data['cc'], $data['to_name']);
        $m->subject($data['title']); 
    });
    return response()->json([
        'status'=>true  
    ]);
}

function hrEmployee(Request $request){

    $input=  $request->json()->all();     
    $USEREMP_ID= $input['USEREMP_ID'];
    $RECSHOWFG= $input['RECSHOWFG'];
    $COMPANY_ID= $input['COMPANY_ID'];
    $CBRANCH_ID= $input['CBRANCH_ID'];
    $COBUNIT_ID= $input['COBUNIT_ID'];
    $PTGUNITID= $input['PTGUNITID'];


    $pdo = DB::getPdo(); 
    $stmt = $pdo->prepare("begin 
        PKG_CALLINFO.PRC_EMPCINFO(
        :P_REF_EMP411,
        :P_EMPLOYEID, 
        :P_RECSHOWFG, 
        :P_COMPANYID, 
        :P_CBRANCHID, 
        :P_COBUNITID, 
        :P_PTGUNITID
        );
        end;");


    $stmt->bindParam(':P_REF_EMP411', $P_REF_EMP411, PDO::PARAM_STMT);
    $stmt->bindParam(':P_EMPLOYEID', $USEREMP_ID, PDO::PARAM_STR,100);
    $stmt->bindParam(':P_RECSHOWFG', $RECSHOWFG, PDO::PARAM_STR,100);
    $stmt->bindParam(':P_COMPANYID', $COMPANY_ID, PDO::PARAM_STR, 100);
    $stmt->bindParam(':P_CBRANCHID', $CBRANCH_ID, PDO::PARAM_STR, 100);
    $stmt->bindParam(':P_COBUNITID', $COBUNIT_ID, PDO::PARAM_STR, 100);
    $stmt->bindParam(':P_PTGUNITID', $PTGUNITID, PDO::PARAM_STR, 100);
    $stmt->execute();

    oci_execute($P_REF_EMP411, OCI_DEFAULT);
    oci_fetch_all($P_REF_EMP411, $empList, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC );
    oci_free_cursor($P_REF_EMP411);


    $path='{ 
        "path_name": "UPLOADS/ATTACHMENT/EMPLOYEE/" 
    }';
    
    $empPhotoPath= json_decode($path);

    return response()->json([
        'success'=>true,  
        'empList'=>$empList,  
        'emp_photo_path'=>$empPhotoPath  
    ]);

}

function employeeAttendance(Request $request){

    $input=  $request->json()->all();

    $P_EMPLOYEID= $input['EMPLOYE_ID']; 
    $P_STARTDATE= $input['START_DT']; 
    $P_ENDTODATE= $input['END_DT']; 
    $pdo = DB::getPdo(); 
    $stmt = $pdo->prepare("begin 
        PKG_ATENDNCE.PRC_EMPCINFO(
        :P_REF_IEA411,
        :P_EMPLOYEID, 
        :P_STARTDATE, 
        :P_ENDTODATE  
        );
        end;");


    $stmt->bindParam(':P_REF_IEA411', $P_REF_IEA411, PDO::PARAM_STMT);
    $stmt->bindParam(':P_EMPLOYEID', $P_EMPLOYEID, PDO::PARAM_STR,100);
    $stmt->bindParam(':P_STARTDATE', $P_STARTDATE, PDO::PARAM_STR,100);
    $stmt->bindParam(':P_ENDTODATE', $P_ENDTODATE, PDO::PARAM_STR, 100); 
    $stmt->execute();

    oci_execute($P_REF_IEA411, OCI_DEFAULT);
    oci_fetch_all($P_REF_IEA411, $empAttendanceList, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC );
    oci_free_cursor($P_REF_IEA411);


    

    return response()->json([
        'success'=>true,  
        'empAttendanceList'=>$empAttendanceList
    ]);

}

function monthList(){

   $monthList=DB::select(DB::raw("select TRIM(MNTHF_NAME)||', '||YEARF_YYYY MONTH_YEAR,START_DATE, ENDTO_DATE from HRV_ATTFTDT"));

   return response()->json([
    'success'=>true,  
    'monthList'=>$monthList
]);

}

function employeeLeave(Request $request){


    $input=  $request->json()->all(); 
   // print_r($input);exit;
    $PRIMARY_IDD=DB::select(DB::raw("SELECT FNC_primekey('HR_LEAVEAPP_SEQ','1') NEXT_PK from dual"));
    $PRIMARY_ID = $PRIMARY_IDD[0]->NEXT_PK;

    $conSecond = $_POST["START_TIME"];
    $conSecondE= $_POST["ENDTO_TIME"];
    $sTime     = $this->convertStart($conSecond);
    $cEndTime  = $this->convertEnd($conSecondE); 

    $data = array(
        'LAV_APP_ID' =>$PRIMARY_ID,
            //'LEAVETP_ID' =>$input['LEAVETP_ID'], 
        'LAV_REASON' =>$input['LAV_REASON'],
        'EMPLOYE_ID' =>$input['EMPLOYE_ID'], 
        'LAV_REQ_DT' =>date('Y-M-d'),
            //'RLDURATION' =>$input['RLDURATION'],
        'RLSTART_DT' =>date('Y-M-d',strtotime($input['RLSTART_DT'])),
        'RLENDTO_DT' =>date('Y-M-d',strtotime($input['RLENDTO_DT'])),
        'RLBA_LUNCH' =>'',
            //'RLBA_LUNCH' =>$input['RLBA_LUNCH'],
        'LEAV_CATEG' =>'',

            //'RLSTART_TM' => $this->convertStart($input['START_TIME']),
        'RLSTART_TM' => $sTime,
            //'RLSTART_TM' => '',
            //'RLENDTO_TM' => '',
            //'RLENDTO_TM' => $this->convertEnd($input['ENDTO_TIME']),
        'RLENDTO_TM' => $cEndTime,

        'DLWYW_STAY' =>$input['DLWYW_STAY'],
        'EMERG_CONS' =>$input['EMERG_CONS'],
        'LAPPTYP_ID' =>$input['LAPPTYP_ID'],
            //'ALTWKG_DTS' =>$input['ALTWKG_DTS'],

        'ASTATUS_FG' =>'1',
        'LORAS_TYPE' =>'1',
        'RLDUR_TYPE' =>'D',
        'LAV_REQ_BY' => $input['EMPLOYE_ID'],

            // 'COMPANY_ID' => '',
            // 'CBRANCH_ID' => '',
            // 'COBUNIT_ID' => '',
            // 'PTGUNIT_ID' => '',

        'COMPANY_ID' => $input['COMPANY_ID'],
        'CBRANCH_ID' => $input['CBRANCH_ID'],
        'COBUNIT_ID' => $input['COBUNIT_ID'],
        'PTGUNIT_ID' => $input['PTGUNIT_ID'],

        'CREATED_BY' => $input['EMPLOYE_ID'],
        'CREATED_AT' => date("Y-m-d h:i:s")
    ); 
          //echo "<pre>";   
          //echo print_r($data);exit();      
    DB::table('HR_LEAVEAPP')->insert($data);  

    return response()->json([
       'success'=>true 
   ]);


}

public static function convertSecondLeave($conSecond){
  $secondCal= date("H:i", strtotime($conSecond));
  $second=strtotime($secondCal)- strtotime('TODAY');
  return $second;
}
public static function conENdTimeSecond($conSecondE){
  $conSeEndTme= date("H:i", strtotime($conSecondE));
  $secondendtime=strtotime($conSeEndTme)- strtotime('TODAY');
  return $secondendtime;
}

public static function convertStart($conSecond){
  $secondCal= date("H:i", strtotime($conSecond));
  $second=strtotime($secondCal)- strtotime('TODAY');
  return $second;
}
public static function convertEnd($conSecondE){
  $conSeEndTme= date("H:i", strtotime($conSecondE));
  $secondendtime=strtotime($conSeEndTme)- strtotime('TODAY');
  return $secondendtime;
}

public function employeeLeaveView(){ 

  $allEmployeeLeave=DB::table('HR_LEAVEAPP')
  ->where('HR_LEAVEAPP.ASTATUS_FG','=',1)
  ->get();
  return response()->json([
    'success'=>true, 
    'employee_leave_view'=>$allEmployeeLeave
]);

}
public function employeeLeaveTypeView(){ 

  $leaveType=DB::table('HR_LEAVETYP')
  ->where('HR_LEAVETYP.ASTATUS_FG','=',1)
  ->get();
  return response()->json([
    'success'=>true, 
    'leave_type'=>$leaveType
]);
}

public function employeeLeaveCategory(){
  $leaveCat = DB::table('HRV_LAPPTYP')->where('HRV_LAPPTYP.ASTATUS_FG','=',1)->get();
  return response()->json([
     'success' => true,
     'leave-cat' => $leaveCat
 ]);
}


public function addLeaveTypeApp(Request $request){
    $input=  $request->json()->all();
    $P_EMPLOYEID  = $input['CREATED_BY']; 
    $P_RLSTARTDT  = date('Y-M-d',strtotime($input['RLSTART_DT']));

    $P_RLDURTYPE  = 'D';
    $P_NOFRLDAYS  ='';
    $P_RLENDTODT  = date('Y-M-d',strtotime($input['RLENDTO_DT']));

    if($input['LAPPTYP_ID'] == 1) {
        $P_LEAVETPID  = $input['LEAVETP_ID'];            

    }else if ($input['LAPPTYP_ID'] == 2){
       $P_LEAVETPID  = $input['LEAVETP_ID'];
       $P_RLDURATON  = $input['RLDURATION'];

   }else{
    $P_LEAVETPID  = '';
    $P_RLDURATON  = ''; 
}

//start procedure 
        //actual date calculation procedure
$pdo = DB::getPdo();        
$leave_calculation = $pdo->prepare("begin 
   PKG_EMPLEAVE.PRC_CLEAVDAY(
   :P_EMPLOYEID, 
   :P_RLSTARTDT, 
   :P_RLDURATON,
   :P_RLDURTYPE, 
   :P_NOFRLDAYS, 
   :P_RLENDTODT,
   :P_ALSTART_DT, 
   :P_NOFLC_DAYS,
   :P_ALENDTO_DT
   ); 
   end;");

$leave_calculation->bindParam(':P_EMPLOYEID',  $P_EMPLOYEID, PDO::PARAM_INT,100);
$leave_calculation->bindParam(':P_RLSTARTDT',  $P_RLSTARTDT, PDO::PARAM_STR,100);
$leave_calculation->bindParam(':P_RLDURATON',  $P_RLDURATON, PDO::PARAM_INT,100);
$leave_calculation->bindParam(':P_RLDURTYPE',  $P_RLDURTYPE, PDO::PARAM_STR,100);
$leave_calculation->bindParam(':P_NOFRLDAYS',  $P_NOFRLDAYS, PDO::PARAM_INT,100);
$leave_calculation->bindParam(':P_RLENDTODT',  $P_RLENDTODT, PDO::PARAM_STR,100);
$leave_calculation->bindParam(':P_ALSTART_DT', $P_ALSTART_DT,PDO::PARAM_STR,100);
$leave_calculation->bindParam(':P_NOFLC_DAYS', $P_NOFLC_DAYS,PDO::PARAM_STR,100);
$leave_calculation->bindParam(':P_ALENDTO_DT', $P_ALENDTO_DT,PDO::PARAM_STR,100); 

$leave_calculation->execute();
       // echo $P_ALSTART_DT.'/ '.$P_NOFLC_DAYS.' /'.$P_ALENDTO_DT .'/'. $P_NOFRLDAYS .'/'.$P_RLENDTODT.'emp_id'.$_SESSION['EMPLOYE_ID'];
        //exit();

        // ======================================================================
        //leave application
$P_LAVAPP_ID  = 1;
$P_EMPLOYEID  = $input['CREATED_BY']; 
$P_LAVREQ_BY  = $input['CREATED_BY'];
$P_LAVREQ_DT  = date('Y-M-d');
$P_LAVREASON  = $input['LAV_REASON'];
        $P_RLSTARTDT  = date('Y-M-d',strtotime($input['RLSTART_DT'])); //multiple
        //$P_RLDURATON  = $input['RLDURATION']; //multiple
        $P_RLDURTYPE  = 'D';
        $P_NOFRLDAYS  = '';
        $P_NOF_RLHRS  = '';



        if($input['LAPPTYP_ID'] == 1) {
           $P_LEAVETPID  = $input['LEAVETP_ID'];

       }else if($input['LAPPTYP_ID'] == 2){
          $P_LEAVETPID  = $input['LEAVETP_ID'];
          $P_RLDURATON  = $input['RLDURATION'];

      }else if($input['LAPPTYP_ID'] == 5){
         $P_RLBALUNCH  = $input['RLBA_LUNCH']; //after lanunch and before launch value 

     }else if($input['LAPPTYP_ID'] == 6){

       $P_RLSTARTTM = $this->convertStart($input['RLSTART_TM']);
       $P_RLENDTOTM = $this->convertEnd($input['RLENDTO_TM']);  

   }else{
    $P_LEAVETPID  = '';
    $P_RLDURATON  = '';
        $P_RLBALUNCH  = ''; //after lanunch and before launch value
        $P_RLSTARTTM  = ''; // hourly
        $P_RLENDTOTM  = ''; // hourly 
    }
    


//end 
        $P_RLENDTODT  = date('Y-M-d',strtotime($input['RLENDTO_DT'])); //multiple
        //$P_LEAVETPID  = $input['LEAVETP_ID']; //multiple 
        $P_EMERGCONS  = $input['EMERG_CONS']; 
        $P_DLWYWSTAY  = $input['DLWYW_STAY'];
        $P_ALSTART_DT = $P_ALSTART_DT; 
        $P_NOFLC_DAYS = $P_NOFLC_DAYS; 
        $P_ALENDTO_DT = $P_ALENDTO_DT; 
        $P_LAPPTYPID  = $input['LAPPTYP_ID']; 

        // $P_COMPANYID     = $_SESSION['COMPANY_ID'];
        // $P_CBRANCHID     = $_SESSION['CBRANCH_ID'];
        // $P_COBUNITID     = $_SESSION['COBUNIT_ID'];
        // $P_PTGUNITID     = $_SESSION['PTGUNIT_ID'];
        // $P_PERFORMBY     = $_SESSION['EMPLOYE_ID'];
        $P_COMPANYID     = '';
        $P_CBRANCHID     = '';
        $P_COBUNITID     = '';
        $P_PTGUNITID     = '';
        $P_PERFORMBY     = '';
        $P_PERFORMDT     = '';
        $P_PKPLUSVAL     = '';

//start procedure 
        $pdo = DB::getPdo();        
        $leave_app = $pdo->prepare("begin 
           PKG_EMPLEAVE.PRC_LEAV_APP(
           :P_LAVAPP_ID, 
           :P_EMPLOYEID, 
           :P_LAVREQ_BY,
           :P_LAVREQ_DT, 
           :P_LAVREASON, 
           :P_RLSTARTDT,
           :P_RLDURATON, 
           :P_RLDURTYPE,
           :P_NOFRLDAYS,
           :P_RLBALUNCH,
           :P_RLSTARTTM,
           :P_NOF_RLHRS,
           :P_RLENDTOTM, 
           :P_RLENDTODT,
           :P_LEAVETPID,
           :P_EMERGCONS,
           :P_DLWYWSTAY,
           :P_ALSTART_DT,
           :P_NOFLC_DAYS,
           :P_ALENDTO_DT,
           :P_LAPPTYPID,

           :P_COMPANYID,
           :P_CBRANCHID,
           :P_COBUNITID,
           :P_PTGUNITID,
           :P_PERFORMBY,
           :P_PERFORMDT,
           :P_PKPLUSVAL,

           :P_RETURNMSG
           ); 
           end;");

        $leave_app->bindParam(':P_LAVAPP_ID',  $P_LAVAPP_ID, PDO::PARAM_STR,200);
        $leave_app->bindParam(':P_EMPLOYEID',  $P_EMPLOYEID, PDO::PARAM_STR,200);
        $leave_app->bindParam(':P_LAVREQ_BY',  $P_LAVREQ_BY, PDO::PARAM_STR,200);
        $leave_app->bindParam(':P_LAVREQ_DT',  $P_LAVREQ_DT, PDO::PARAM_STR,200);
        $leave_app->bindParam(':P_LAVREASON',  $P_LAVREASON, PDO::PARAM_STR,200);
        $leave_app->bindParam(':P_RLSTARTDT',  $P_RLSTARTDT, PDO::PARAM_STR,200);
        $leave_app->bindParam(':P_RLDURATON',  $P_RLDURATON, PDO::PARAM_STR,200);
        $leave_app->bindParam(':P_RLDURTYPE',  $P_RLDURTYPE, PDO::PARAM_STR,200);
        $leave_app->bindParam(':P_NOFRLDAYS',  $P_NOFRLDAYS, PDO::PARAM_STR,200);

        $leave_app->bindParam(':P_RLBALUNCH',  $P_RLBALUNCH, PDO::PARAM_STR,200);
        $leave_app->bindParam(':P_RLSTARTTM',  $P_RLSTARTTM, PDO::PARAM_STR,200);
        $leave_app->bindParam(':P_NOF_RLHRS',  $P_NOF_RLHRS, PDO::PARAM_STR,200);
        $leave_app->bindParam(':P_RLENDTOTM',  $P_RLENDTOTM, PDO::PARAM_STR,200);



        $leave_app->bindParam(':P_RLENDTODT',  $P_RLENDTODT, PDO::PARAM_STR,200);
        $leave_app->bindParam(':P_LEAVETPID',  $P_LEAVETPID, PDO::PARAM_STR,200);
        $leave_app->bindParam(':P_EMERGCONS',  $P_EMERGCONS, PDO::PARAM_STR,200);
        $leave_app->bindParam(':P_DLWYWSTAY',  $P_DLWYWSTAY, PDO::PARAM_STR,200);
        $leave_app->bindParam(':P_ALSTART_DT', $P_ALSTART_DT,PDO::PARAM_STR,200);
        $leave_app->bindParam(':P_NOFLC_DAYS', $P_NOFLC_DAYS,PDO::PARAM_STR,200);
        $leave_app->bindParam(':P_ALENDTO_DT', $P_ALENDTO_DT,PDO::PARAM_STR,200);
        $leave_app->bindParam(':P_LAPPTYPID',  $P_LAPPTYPID, PDO::PARAM_STR,200);

        $leave_app->bindParam(':P_COMPANYID',  $P_COMPANYID, PDO::PARAM_STR,200);
        $leave_app->bindParam(':P_CBRANCHID',  $P_CBRANCHID, PDO::PARAM_STR,200);
        $leave_app->bindParam(':P_COBUNITID',  $P_COBUNITID, PDO::PARAM_STR,200);
        $leave_app->bindParam(':P_PTGUNITID',  $P_PTGUNITID, PDO::PARAM_STR,200);
        $leave_app->bindParam(':P_PERFORMBY',  $P_PERFORMBY, PDO::PARAM_STR,200);
        $leave_app->bindParam(':P_PERFORMDT',  $P_PERFORMDT, PDO::PARAM_STR,200);
        $leave_app->bindParam(':P_PKPLUSVAL',  $P_PKPLUSVAL, PDO::PARAM_STR,200);

        $leave_app->bindParam(':P_RETURNMSG',  $P_RETURNMSG, PDO::PARAM_STR,200);
        
        
        $leave_app->execute();
        //echo $P_RETURNMSG;
       // DB::table('HR_LEAVEAPP')->insert($data);
        return response()->json([
           'success'=>true 
       ]);  

    }

    public function getNotificatin($message_title,$message){
        $notification = array();
        $notification['title'] = 'ATI::ERP';
        $notification['tag'] =$message_title;
        $notification['body'] =$message; 

        return $notification;
    }
    // sending push message to single user by firebase reg id
    public function sendNotification(Request $request) {
        $input=  $request->json()->all();   
        $message= $input['message'];
        $message_title= $input['title'];
        $requestData = $this->getNotificatin($message_title,$message);

        $fields = array(
            'to' => $input['to'],
            'notification' => $requestData


        );
        return $this->sendPushNotification($fields);
    }
    // function makes curl request to firebase servers
    private function sendPushNotification($fields) {

       // require_once __DIR__ . '/config.php';

        // Set POST variables

        $url = 'https://fcm.googleapis.com/fcm/send';

        $headers = array(
            'Authorization: key='.FIREBASE_API_KEY,
            'Content-Type: application/json'
        );
       // print_r($headers);exit();
        // Open connection
        $ch = curl_init();



        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        print_r($result);exit;
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
        return response()->json([
           'success'=>true, 
           'result'=>$result 
       ]); 

        //return $result;
    }

    public function getEmpMovement(Request $request){
        //$id = '18111000000534';

        $getVal = DB::table('HR_MOVT_REC')
        ->where('HR_MOVT_REC.ASTATUS_FG', 1)
        ->get();

        return response()->json([
            'success' => true,
            'result'  =>$getVal
        ]);    
    }
    
    public function updateEmpMovement(Request $request){ 

        $input = $request->json()->all();

        $updateMovement = array(
            'MOVT_LADDR' => $input['ClientAddress'],
            'CLIENTS_ID' => $input['clientName'],
            'A_DURATION' => $input['durationTime'],
            'MOVEMNT_DT' => date('Y-m-d', strtotime( $input['fromdate'])),
            'EMOVT_DESC' => $input['movementPurpose'],
            'OMTITLE_ID' => $input['movementTitle'],
            'PRESENCEON' => $this->convertSecond($input['presenceOn']),
            'PROJECT_ID' => $input['projectName'],
            'MOVT_ET_DT' => date('Y-m-d', strtotime( $input['todate'])), 
            'VISITS_FRM' => $input['startVisit'],
            'MVTDTYP_ID' => $input['durationType'],
            'M_LATITUDE' => $input['latitude'],
            'M_LONGITDE' => $input['longitde']                                       
        );

        DB::table('HR_MOVT_REC')->where('MOVTREC_ID', $input['MOVTREC_ID'])->update($updateMovement);
        
        return response()->json([
            'success'=>true                                    
        ]);
    }

    public function getEmployeeMovement(Request $request,$mov_id){
        $input =  $request->json()->all();
        //$mov_id = '18111000000543';
        // $empData = DB::select(DB::raw("SELECT mo.*,emp.EMPLOYE_ID,emp.MOVTEMP_ID from HR_MOVT_REC mo
        //             left join HR_MOVT_EMP emp on mo.MOVTREC_ID=emp.MOVTREC_ID
        //             where mo.MOVTREC_ID='$mov_id' "));

        // $empData = DB::select(DB::raw("SELECT emp.EMPLOYE_ID from HR_MOVT_REC mo
        //             left join HR_MOVT_EMP emp on mo.MOVTREC_ID=emp.MOVTREC_ID
        //             where mo.MOVTREC_ID='$mov_id' "));

        $empData = DB::select(DB::raw(" SELECT emp.EMPLOYE_ID,e.EFULL_NAME from HR_MOVT_REC mo
            left join HR_MOVT_EMP emp on mo.MOVTREC_ID=emp.MOVTREC_ID
            left join hr_employee e on emp.EMPLOYE_ID=e.EMPLOYE_ID
            where mo.MOVTREC_ID='$mov_id' "));

        return response()->json([
            'success' => true,
            'result'  =>$empData
        ]);    
    }



    public function empAttendance(Request $request,$empId){
        $input =  $request->json()->all();
        //$empId='18011000000027';
        $today = date('d-M-Y');
        
        $BIOMETICID = DB::selectOne(DB::raw("SELECT e.BIOMETICID from hr_employee e where e.EMPLOYE_ID='$empId'"));
        $countLate = DB::selectOne(DB::raw("SELECT count(a.A_IIN_TIME) CONT_IN_TIME from HR_ATENDNCE a
            where a.BIOMETICID=$BIOMETICID->BIOMETICID
            and  to_char(a.ATEDNCE_DT,'MMYY') =  to_char(SYSDATE,'MMYY')
            and a.A_IIN_TIME>=33360"));

        $getCount = $countLate->CONT_IN_TIME;

        $empAttendance = DB::select(DB::raw("SELECT (atten.A_IIN_TIME)logtime from HR_ATENDNCE atten
           where atten.BIOMETICID=$BIOMETICID->BIOMETICID and atten.ASTATUS_FG='1' and 
           atten.ATEDNCE_DT = TO_DATE('$today','dd-MM-YY')"));
        //print_r($empAttendance);eixt;

        if($empAttendance){
            $loginTime = gmdate('h:i A', $empAttendance[0]->LOGTIME);
        }else{
            $loginTime = 'Attendance not entered yet!';
        } 


        return response()->json([
            'success'    => true,
            'totalLate'  => $getCount,
            'loginTime'    => $loginTime,
                //'logTimeinH' => $loginTime
        ]);
    }

    public function updateEmpMovementAll(Request $request){
         //$mov_id = '18111000000543';
        $input =  $request->json()->all();
        $updateMovement = array(
            'MOVTREC_ID' => $input['MOVTREC_ID'],
            'MOVT_LADDR' => $input['ClientAddress'],
            'CLIENTS_ID' => $input['clientName'],
            'A_DURATION' => $input['durationTime'],
            'MOVEMNT_DT' => date('Y-m-d', strtotime( $input['fromdate'])),
            'EMOVT_DESC' => $input['movementPurpose'],
            'OMTITLE_ID' => $input['movementTitle'],
            'PRESENCEON' => $this->convertSecond($input['presenceOn']),
            'PROJECT_ID' => $input['projectName'],
            'MOVT_ET_DT' => date('Y-m-d', strtotime( $input['todate'])), 
            'VISITS_FRM' => $input['startVisit'],
            'MVTDTYP_ID' => $input['durationType'],
            'M_LATITUDE' => $input['latitude'],
                //'EMPLOYE_ID' => $input['EMPLOYE_ID'],
            'M_LONGITDE' => $input['longitde'],

            );//print_r($updateMovement) ;exit;

        DB::table('HR_MOVT_REC')->where('MOVTREC_ID', $input['MOVTREC_ID'])->update($updateMovement);
        DB::table('HR_MOVT_EMP')->where('MOVTREC_ID', $input['MOVTREC_ID'])->delete(); 

        $empid = $input['EMPLOYE_ID'];
       // echo $empid;exit();
        $array = explode("," , $empid);
        // print_r($array) ;exit;

        //echo count($array);exit;


        for($empu=0;$empu<count($array);$empu++){

            $PRIMARY_DTL=DB::select(DB::raw("SELECT FNC_primekey('SEQ_ATI_EMP_MOVEMENT_DTL','1') NEXT_PK from dual"));
            $PRIMARY_ID_DTL = $PRIMARY_DTL[0]->NEXT_PK;
            $empData[] = array(       
                'MOVTEMP_ID' => $PRIMARY_ID_DTL,
                'MOVTREC_ID' => $input['MOVTREC_ID'],
                'EMPLOYE_ID' => $array[$empu],
                'MOVEMNT_DT' => date('Y-m-d', strtotime($input['fromdate'])),
                  //'UPDATED_BY' => $input['EMPLOYE_ID'],
                'UPDATED_AT' => date("Y-m-d h:i:s")
            );
            //echo $empData;
        }
        print_r($empData);

        DB::table('HR_MOVT_EMP')->where('MOVTREC_ID', $input['MOVTREC_ID'])->insert($empData);

        return response()->json([
            'success'=>true                                    
        ]);



    }

    public function leaveBalance(Request $request){
       $input=  $request->json()->all();
       $P_EMPLOYEID= $input['EMPLOYE_ID']; 
       $currentYear=date('Y');
       $P_LAVBCEYRS= $currentYear; 
       $pdo = DB::getPdo(); 
       $stmt = $pdo->prepare("begin 
        PKG_EMPLEAVE.PRC_LEVBINFO(
        :P_REF_LAB411,
        :P_EMPLOYEID,
        :P_LAVBCEYRS
        );
        end;");
       $stmt->bindParam(':P_REF_LAB411', $P_REF_LAB411, PDO::PARAM_STMT);
       $stmt->bindParam(':P_EMPLOYEID', $P_EMPLOYEID, PDO::PARAM_STR,100);
       $stmt->bindParam(':P_LAVBCEYRS', $P_LAVBCEYRS, PDO::PARAM_STR,100);       
       $stmt->execute();

       oci_execute($P_REF_LAB411, OCI_DEFAULT);
       oci_fetch_all($P_REF_LAB411, $leaveBalenceList, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC );
       oci_free_cursor($P_REF_LAB411);

       $leavAppStatus=DB::select(DB::raw("SELECT l.*,lt.LATYP_NAME
           from HR_LEAVEAPP l
           left join HRV_LAPPTYP lt on l.LAPPTYP_ID=lt.LAPPTYP_ID where l.EMPLOYE_ID=$P_EMPLOYEID"));

       return response()->json([
        'success'=>true,  
        'leaveBalenceList'=>$leaveBalenceList,
        'leavAppStatus'=>$leavAppStatus
    ]);


   }


   public function ticketLookupInfo()
   {

    $clientInfos=DB::table('ATI_CLIENTS')
    ->where('ATI_CLIENTS.ASTATUS_FG','=',1)
    ->orderBy('ATI_CLIENTS.CLIENTS_ID','=','ATI_CLIENTS.CLIENTS_ID')
    ->get();
    $projectInfos=DB::table('ATI_PROJECT')
    ->where('ATI_PROJECT.ASTATUS_FG','=',1)
    ->orderBy('ATI_PROJECT.PROJECT_ID','=','ATI_PROJECT.PROJECT_ID')
    ->get(); 
    $ticketPriorityInfos=DB::select(DB::raw("SELECT TKT_PRI_ID, T_PRIORITY 
        FROM SMV_TKT_PRI WHERE ASTATUS_FG = 1"));
    $ticketTypeInfos=DB::select(DB::raw("SELECT TR_TYPE_ID, T_REQ_TYPE 
     FROM SMV_TR_TYPE WHERE ASTATUS_FG = 1"));
    $ticketModeInfos=DB::select(DB::raw("SELECT TR_MODE_ID, T_REQ_MODE 
     FROM SMV_TR_MODE WHERE ASTATUS_FG = 1"));
    $ticketStatusInfos=DB::select(DB::raw("SELECT TKTSTUS_ID, TICKSTATUS 
     FROM SMV_TKTSTUS WHERE ASTATUS_FG = 1"));
    $ticketTitleInfos=DB::select(DB::raw("SELECT CTICKET_ID, CST_TITLES, PROJECT_ID FROM ATI_CTICKET"));

    $test = array(
        'success'=>true,
        'clientInfos'=>$clientInfos,
        'projectInfos'=>$projectInfos,
        'ticketPriorityInfos'=>$ticketPriorityInfos,
        'ticketTypeInfos' => $ticketTypeInfos,
        'ticketModeInfos'=> $ticketModeInfos,
        'ticketStatusInfos'=> $ticketStatusInfos,
        'ticketTitleInfos'=> $ticketTitleInfos
    );
    return json_encode(array($test)); 
    // return response()->json([
    //     'clientInfos'=>$clientInfos,
    //     'projectInfos'=>$projectInfos,
    //     'ticketPriorityInfos'=>$ticketPriorityInfos,
    //     'ticketTypeInfos' => $ticketTypeInfos,
    //     'ticketModeInfos'=> $ticketModeInfos,
    //     'ticketStatusInfos'=> $ticketStatusInfos,
    //     'ticketTitleInfos'=> $ticketTitleInfos

    // ]);
}

public function submitTicketAttachment(Request $request)
{

}


function submitTicket(Request $request){
    $input=  $request->json()->all();
    $p_clientsid=  $input['clients']['CLIENTS_ID'];
    $p_companyid=  $input['clients']['COMPANY_ID'];  

    $p_projectid=  $input['projects']['PROJECT_ID'];

    $p_csttitles=$input['ticketTitleString'];
    $p_ticktdesc=$input['ticketDescString'];
    //$p_project_name=  $input['projects']['PROJT_NAME']; 
    $p_trmode_id=$input['ticketMode']['TR_MODE_ID'];
    $p_tktpri_id=$input['ticketPriority']['TKT_PRI_ID'];
    $p_ticketuid=$input['ticketTitle']['CTICKET_ID'];
    $p_trtype_id=$input['ticketType']['TR_TYPE_ID'];
    $p_tktusr_id=$input['userCode'];    
    $p_tpri_rmks='';
    $p_performby='';
    $p_companyid='';
    $p_cbranchid='';
    $p_cobunitid='';
    $p_ptgunitid='';
    $p_pkplusval='';

    //$p_ticketuid=$input[''];
    //echo '<pre>';print_r($p_client_id);exit;

    $PRIMARY_IDD=DB::select(DB::raw("SELECT FNC_primekey('SM_CALLINFO_SEQ','1') NEXT_PK from dual"));
    $PRIMARY_ID = $PRIMARY_IDD[0]->NEXT_PK;
    
//start procedure 
    $pdo = DB::getPdo();        
    $save_ticket_info = $pdo->prepare("begin 
       PKG_TKT_INFO.PRC_SMTICKET(
       :p_clientsid,
       :p_companyid, 
       :p_projectid, 
       :p_csttitles, 
       :p_ticktdesc,
       :p_trmode_id, 
       :p_tktpri_id,
       :p_ticketuid,

       :p_ticketuid,
       :p_trtype_id,
       :p_companyid,
       :p_cbranchid,
       :p_cobunitid,
       :p_ptgunitid,
       :p_pkplusval,
       :p_ticket_title
       ); 
       end;");
    $save_ticket_info->bindParam(':p_clientsid', $p_clientsid, PDO::PARAM_STR,14);
    $save_ticket_info->bindParam(':p_companyid', $p_companyid, PDO::PARAM_STR,14);
    $save_ticket_info->bindParam(':p_company_id', $p_company_id, PDO::PARAM_STR,16);
    $save_ticket_info->bindParam(':p_projectid', $p_projectid, PDO::PARAM_STR,14);
    $save_ticket_info->bindParam(':p_csttitles', $p_csttitles, PDO::PARAM_STR,14);
    $save_ticket_info->bindParam(':p_ticktdesc', $p_ticktdesc, PDO::PARAM_STR,14);
    $save_ticket_info->bindParam(':p_trmode_id', $p_trmode_id, PDO::PARAM_STR,14);
    $save_ticket_info->bindParam(':p_tktpri_id', $p_tktpri_id, PDO::PARAM_STR,14);
    $save_ticket_info->bindParam(':p_ticketuid', $p_ticketuid, PDO::PARAM_STR,14);

    $save_ticket_info->bindParam(':p_ticketuid', $p_ticketuid, PDO::PARAM_STR,14);
    $save_ticket_info->bindParam(':p_trtype_id', $p_trtype_id, PDO::PARAM_STR,14);    
    $save_ticket_info->bindParam(':p_tktusr_id', $p_tktusr_id, PDO::PARAM_STR,14);    
    
    $save_ticket_info->bindParam(':p_companyid', $p_companyid, PDO::PARAM_STR,14);
    $save_ticket_info->bindParam(':p_cbranchid', $p_cbranchid, PDO::PARAM_STR,14);
    $save_ticket_info->bindParam(':p_cobunitid', $p_cobunitid, PDO::PARAM_STR,14);
    $save_ticket_info->bindParam(':p_ptgunitid', $p_ptgunitid, PDO::PARAM_STR,14);
    $save_ticket_info->bindParam(':p_pkplusval', $p_pkplusval, PDO::PARAM_STR,14);
    $save_ticket_info->bindParam(':p_ticket_title', $p_ticket_title, PDO::PARAM_STR,14);


    if( $save_ticket_info->execute()){
       return response()->json([
        'success'=>true                                    

    ]);
   }



} 



} // Class

