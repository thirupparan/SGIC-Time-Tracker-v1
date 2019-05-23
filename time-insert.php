<?php  
session_start();

include('database_config_dashboard.php'); 
include('includes/query_execute.inc.php');
require_once 'includes/message.inc.php';

if($_POST["action"]=='time_in'){


$sql="INSERT INTO attendance (time_in,time_out,user_id,date)
SELECT * FROM (SELECT :timein ,'00:00',:userid,:date) AS tmp
WHERE NOT EXISTS (
    SELECT date FROM attendance WHERE date = :dateex
) LIMIT 1";


execute_query("Successfully Updated Time In","Cannot Allowed to change ",$connect,$sql,array(
    ':timein'=>$_POST["timein"],
    ':userid'=>$_SESSION["user_id"],
    ':date'=>$_POST["date"],
    ':dateex'=>$_POST["date"]
));

}else if($_POST["action"]=='time_out'){
    $timeout=strtotime($_POST["timeout"]);
    $timein=strtotime(getTimeInbyDate($connect,$_SESSION["user_id"],$_POST["date"]));
$timediff=$timeout-$timein;

    if($timediff>0){
        $sql="UPDATE attendance SET time_out = :timeout WHERE attendance.user_id=:userid AND attendance.date = :date";
       

        execute_query("Successfully Updated Time Out","Cannot Allowed to change ",$connect,$sql,array(
            ':timeout'=>$_POST["timeout"],
            ':userid'=>$_SESSION["user_id"],
            ':date'=>$_POST["date"],
            
        ));
    }else{
       
        echo json_encode(printJsonMsg('Time out is Less than Time in ','err'));
        
    }
    

}


function getTimeInbyDate($connect,$userid,$date){

    $sqlGetTimeIn="SELECT `time_in` FROM `attendance` WHERE attendance.user_id='{$userid}' AND attendance.date = '{$date}'";
    $result=getResult($connect,$sqlGetTimeIn);
    return $result['time_in'];
		

       
}

?> 

