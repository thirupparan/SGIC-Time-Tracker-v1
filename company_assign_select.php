<?php  
 //select.php  
 $output = '';  
 include('database_mysqli_assign_company.php'); 
 if(isset($_POST["action"]))  
 {  
      $procedure = "  
      CREATE PROCEDURE selectUser(IN u_id int(11))  
      BEGIN  
      SELECT  oc.company_name,uc.recruited_date,uc.working_status,uc.user_company_id,uc.work_role,uc.contract_period
      FROM USER_COMPANY uc JOIN out_source_company oc 
      ON uc.company_id = oc.company_id 
      WHERE user_id=u_id ORDER BY user_company_id DESC; 
      END;  
      ";  
      if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS selectUser"))  
      {  
           if(mysqli_query($connect, $procedure))  
           {  
                $query = "CALL selectUser(".$_POST['user_id'].")";  
                $result = mysqli_query($connect, $query);  
                $output .= '  
                     <table class="table table-bordered">  
                          <tr> 
                                   
									<th>Company Name</th>
									<th>Recruited Date</th>
                                             <th>Work Role</th>
                                             <th>contact Period</th>
                                             <th>Working Status</th>
                                             <th>Action</th> 
									
                                
                          </tr>  
                ';  
                if(mysqli_num_rows($result) > 0)  
                {  
                     while($row = mysqli_fetch_array($result))  
                     {  
                          $output .= '  
                               <tr>  
                                    <td>'.$row["company_name"].'</td>  
                                    <td>'.$row["recruited_date"].'</td> 
                                    <td>'.$row["work_role"].'</td>
                                    <td>'.$row["contract_period"].'</td>
                                    <td>'.$row["working_status"].'</td>
                                    <td>
                                    <span><button type="button" name="update_company" id="'.$row["user_company_id"].'" class="update_company btn btn-success btn-xs">U</button></span>
                                    <button type="button" name="delete_company" id="'.$row["user_company_id"].'" class="delete_company btn btn-danger btn-xs">D</button></td>  
                               </tr>  
                          ';  
                     }  
                }  
                else  
                {  
                     $output .= '  
                          <tr>  
                               <td colspan="4">Data not Found</td>  
                          </tr>  
                     ';  
                }  
                $output .= '</table>';  
                echo $output;  
           }  
      }  
 }  
 ?>