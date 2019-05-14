<?php  
session_start();
include('database_mysqli_assign_company.php');

if($_POST["action"]=='time_in'){


$sql="INSERT INTO attendance (time_in,time_out,user_id,date)
SELECT * FROM (SELECT '".$_POST["timein"]."','00:00','".$_SESSION["user_id"]."','".$_POST["date"]."') AS tmp
WHERE NOT EXISTS (
    SELECT date FROM attendance WHERE date = '".$_POST["date"]."'
) LIMIT 1";

execute_query($connect,$sql);



}else if($_POST["action"]=='time_out'){
$sql="UPDATE attendance SET time_out = '".$_POST["timeout"]."' WHERE attendance.user_id='".$_SESSION["user_id"]."' AND attendance.date = '".$_POST["date"]."'";

execute_query($connect,$sql);
}

function execute_query($connect,$sql){
     if(mysqli_query($connect, $sql))  
     {  
           if(mysqli_affected_rows($connect)>0){
               echo 'sucess';
           }else if(mysqli_affected_rows($connect)==0){
               echo 'Action already exist';
           }else{
               echo 'Error'; 
           }
     }  
}
?> 

