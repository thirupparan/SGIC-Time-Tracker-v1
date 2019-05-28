<?php  
 //select.php  
 $output = '';  
 include('database_mysqli_assign_company.php'); 


 
 $statusActive='Active';
 if($_GET["status"]!='Active'){
      $statusActive='Inactive';
      
      
 }

 if(isset($_POST["action"]))  
 {  
      $procedure = "  
      CREATE PROCEDURE selectUser(IN u_id int(11))  
      BEGIN  
      SELECT 
		oc.company_name,uc.recruited_date,uc.working_status,uc.user_company_id,uc.work_role,uc.contract_period,ter.date_of_termination
		FROM USER_COMPANY uc JOIN out_source_company oc 
		ON uc.company_id = oc.company_id
		LEFT JOIN termination ter
		ON ter.user_company_id=uc.user_company_id
		WHERE user_id=u_id ORDER BY user_company_id DESC; 
      END;  
      ";  
      if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS selectUser"))  
      {  
           if(mysqli_query($connect, $procedure))  
           {  
                $query = "CALL selectUser(".$_POST['user_id'].")";  
                $result = mysqli_query($connect, $query);  
                
                if(mysqli_num_rows($result) > 0)  
                {  
                     while($row = mysqli_fetch_array($result))  
                     {  
                          ?>
<div class="col-md-12 ">
	<div class="panel panel-success">
		<div class="panel-heading">
			Recruited Details

			<span class="pull-right">
				<?php
							if($statusActive=='Active'){
								echo "<button class='btn btn-small btn-primary delete_company' style='padding:0px;width:200%;' id='{$row['user_company_id']}' ><i class='fa fa-trash'   aria-hidden='true'></i></button>";

							}else{
								echo "<button class='btn btn-small btn-primary delete_company' style='padding:0px;width:200%;' id='{$row['user_company_id']}' disabled><i class='fa fa-trash'   aria-hidden='true'></i></button>";
							}
							?>
			</span>
		</div>
		<div class="panel-body">

			<div class="col-md-6">
				<div class="thumbnail">
					<table class="table">
						<tr>
							<th align="right">Recruited at</th>
							<th><?php echo $row['company_name'];?></th>
						</tr>
						<tr>
							<th align="right">Recruited as :</th>
							<th><?php echo $row['work_role'];?></th>
						</tr>

						<tr>
							<th align="right">Work Title :</th>
							<th>Software Engineer</th>
						</tr>

					</table>
				</div>


			</div>

			<div class="col-md-6">
				<div class="thumbnail">
					<table class="table">

						<tr>
							<th align="right">Recruited on</th>
							<th><?php echo $row['recruited_date'];?></th>
						</tr>
						<tr>
							<th align="right">Contract Period</th>
							<th><?php echo $row['contract_period'];?> (months)</th>
						</tr>
						<tr>
							<th align="right">Working Staus</th>





							<?php 
						if( $row['working_status']=='Working') {
                                   echo "<th>
                                   <span style='color:green'>Working</span>
                                   <button class='btn btn-xs btn-danger pull-right terminate' id='{$row['user_company_id']}'>Terminate</button></th>";
						}else{
							echo "<td>Left on : {$row['date_of_termination']}</td>";
						}
						
						?>
						</tr>
					</table>
				</div>
			</div>





		</div>
	</div>
</div>
<?php
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