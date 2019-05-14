<?php  
 $connect = mysqli_connect("localhost", "root", "manager", "sgic-user");  
 $sql = "INSERT INTO events(project_id,title, duration,description,start,end) VALUES('".$_POST["project"]."','".$_POST["taskname"]."', '".$_POST["duration"]."','".$_POST["description"]."','".$_POST["date"]."','".$_POST["date"]."')";
 if(mysqli_query($connect, $sql))  
 {  
      echo 'Data Inserted';  
 }  
 ?> 
 