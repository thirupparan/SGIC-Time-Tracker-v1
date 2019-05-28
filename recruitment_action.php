<?php  
 //action.php  
 if(isset($_POST["action_company"]))  
 {  
      $output = '';  
      include('database_mysqli_assign_company.php');
      if($_POST["action_company"] =="Add")  
      {  
          $user_id_company = mysqli_real_escape_string($connect, $_POST["user_id_company"]);  
           $company_name = mysqli_real_escape_string($connect, $_POST["company_name"]);
           $recruited_date = mysqli_real_escape_string($connect, $_POST["recruited_date"]);
           $work_role = mysqli_real_escape_string($connect, $_POST["work_role"]);
           $Contract_Period = mysqli_real_escape_string($connect, $_POST["Contract_Period"]); 
           
            
           $procedure = "  
                CREATE PROCEDURE insertUser(IN user_id_company int(11), company_name int(11),recruited_date date,work_role varchar(100),Contract_Period varchar(100))  
                BEGIN  
                INSERT INTO user_company(user_id, company_id,recruited_date,working_status,work_role,Contract_Period) VALUES (user_id_company, company_name,recruited_date,'Working',work_role,Contract_Period);   
                END;  
           ";  
           if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS insertUser"))  
           {  
                if(mysqli_query($connect, $procedure))  
                {  
                    $sql="SELECT `user_company_id` FROM `user_company` WHERE `user_id`='{$user_id_company}' AND `recruited_date`='{$recruited_date}'";
                    $result=mysqli_query($connect,$sql);
                    if(mysqli_num_rows($result)>0){
                    echo  '<div class="alert alert-danger" role="alert">Failed to Add record</div>';
                    }else{

                    
                    

                     $query = "CALL insertUser('".$user_id_company."', '".$company_name."','".$recruited_date."','".$work_role."','".$Contract_Period."')";  
                     if(mysqli_query($connect, $query)){
                         echo '<div class="alert alert-success" role="alert">Data Inserted</div>';
                     }  else{
                          echo '<div class="alert alert-danger" role="alert">Failed to Add record</div>';
                     }
                    }
                       
                }  
           }  
      }  
      if($_POST["action_company"] == "Edit")  
      {  
          $company_name = mysqli_real_escape_string($connect, $_POST["company_name"]);
          $recruited_date = mysqli_real_escape_string($connect, $_POST["recruited_date"]);
          $work_role = mysqli_real_escape_string($connect, $_POST["work_role"]);
          $Contract_Period = mysqli_real_escape_string($connect, $_POST["Contract_Period"]);
          $procedure = "  
                CREATE PROCEDURE updateUser(IN u_c_id int(11),company_name int(11),recruited_date1 date,work_role1 varchar(100),Contract_Period1 varchar(100))  
                BEGIN   
                UPDATE user_company SET company_id = company_name, recruited_date = recruited_date1,work_role = work_role1,Contract_Period = Contract_Period1
                WHERE user_company_id = u_c_id;  
                END;   
           ";  
               
           if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS updateUser"))  
           { 
                if(mysqli_query($connect, $procedure))  
                {  
                    
                    $query = "CALL updateUser('".$_POST["user_company_id"]."', '".$company_name."', '".$recruited_date."', '".$work_role."', '".$Contract_Period."' )"; 

                     if(mysqli_query($connect, $query)){
                         echo '<div class="alert alert-success" role="alert">Data Updated</div>';
                     }  else{
                         echo '<div class="alert alert-danger" role="alert">Failed to Update</div>';
                     }
                   
                }  
           }  
      }  
      if($_POST["action_company"] == "Delete")  
      {  
           $procedure = "  
           CREATE PROCEDURE deleteUser(IN u_c_id int(11))  
           BEGIN   
           DELETE FROM user_company WHERE user_company_id = u_c_id;  
           END;  
           ";  
           if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS deleteUser"))  
           {  
                if(mysqli_query($connect, $procedure))  
                {  
                     $query = "CALL deleteUser('".$_POST["user_company_id"]."')";  
                     if(mysqli_query($connect, $query)){
                         echo '<div class="alert alert-success" role="alert">Data Deleted</div>';
                    }  else{
                        echo '<div class="alert alert-danger" role="alert">Failed to Delete</div>';
                    } 
                }  
           }  
      }  

      if($_POST["action_company"] == "TERMINATE")  {
           require_once 'database_config_dashboard.php';
           $dot=trim($_POST['date_of_termination']);
           $recruitId=trim($_POST['recruitment_id']);

          $dbrecruitdate=$connect->query("SELECT `recruited_date` FROM `user_company` WHERE `user_company_id`={$recruitId}");
          $rowDate=$dbrecruitdate->fetch(PDO::FETCH_ASSOC);

          if(strtotime($rowDate['recruited_date'])<strtotime($dot)){
                  try
                    {
                         $connect->beginTransaction();
                              $query1=$connect->query("INSERT INTO `termination` (`user_company_id`, `date_of_termination`) VALUES ('{$recruitId}', '{$dot}')");
                              $query2=$connect->query("UPDATE `user_company` SET `working_status` = 'Not_working' WHERE `user_company`.`user_company_id` = {$recruitId} ");
                         $connect->commit();
                         echo '<div class="alert alert-success" role="alert">Successfully Terminated</div>';
                    }
                    catch(Exception $e)
                    { 
                         $connect->rollBack();
                         echo '<div class="alert alert-danger" role="alert">Failed to Terminate</div>';
                    }
          }else{
               echo "failed";
          }

        
      }
 }  
 ?>  