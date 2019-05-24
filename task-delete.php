<?php  
 include('database_mysqli_assign_company.php');
 $sql = "DELETE FROM events WHERE id = '".$_POST["id"]."'";  
 if(mysqli_query($connect, $sql))  
 {  
      echo 'Data Deleted';  
 }  
 ?>