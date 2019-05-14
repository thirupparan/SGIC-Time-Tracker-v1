<?php  
 $connect = mysqli_connect("localhost", "root", "manager", "sgic-user");  
 $sql = "DELETE FROM events WHERE id = '".$_POST["id"]."'";  
 if(mysqli_query($connect, $sql))  
 {  
      echo 'Data Deleted';  
 }  
 ?>