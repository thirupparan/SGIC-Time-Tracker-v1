<?php


include('database_config_dashboard.php'); 
include('includes/query_execute.inc.php');


require_once 'validations/existValidation.php';


if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{

		$role_name=trim($_POST["role_name"]);
		
			
		if(ifNotexists($connect,"user_role","role_name",$role_name)){
			
		
		$query = "
		INSERT INTO user_role (role_name,role_status) 
		SELECT * FROM (SELECT TRIM(:role_name), :role_status)
		AS tmp
		WHERE NOT EXISTS (
    	SELECT role_name FROM user_role WHERE role_name = TRIM(:role_name)
		) LIMIT 1"
		;
		
		execute_query("User Role inserted","unable to insert User Role",$connect,$query,array(
			':role_name'	=>	$role_name,
			':role_status'	=>	'Active'
		));
		}else{
			echo json_encode(printJsonMsg("Role Name Already exist",'err'));
		}
	}
	
	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "SELECT * FROM user_role WHERE role_id = :role_id";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':role_id'	=>	$_POST["role_id"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['role_name'] = $row['role_name'];
		}
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'Edit')
	{
		$role_name=trim($_POST["role_name"]);
		if(ifNotexists($connect,"user_role","role_name",$role_name)){
		$query = "
		UPDATE user_role set role_name = :role_name
		WHERE role_id = :role_id";

		

		execute_query("User Role Edited","Unable to edit user role",$connect,$query,array(
			':role_name'	=>	$role_name,
			':role_id'		=>	$_POST["role_id"]
		));
	}else{
		echo json_encode(printJsonMsg("Role Name Already exist",'err'));
	}
		
	}

	if($_POST['btn_action'] == 'delete')
	{
		$status = 'Active';
		if($_POST['status'] == 'Active')
		{
			$sql="SELECT count(user.user_id) as usercount FROM user 
					INNER JOIN user_role ON user_role.role_id=user.user_type 
					WHERE user_role.role_id=:role_id AND user.user_status='Active'";
			$statement = $connect->prepare($sql);
			$statement->execute(
				array(
					':role_id'	=>	$_POST["role_id"]
				)
			);
			$result = $statement->fetch(PDO::FETCH_ASSOC);
			
			if($result["usercount"]<=0){
				$status = 'Inactive';	
			}
		}
		
		$query = "
		UPDATE user_role 
		SET role_status = :role_status 
		WHERE role_id = :role_id
		";

		execute_query("User Role Changed","Unable to Change user role",$connect,$query,array(
			':role_status'	=>	$status,
			':role_id'		=>	$_POST["role_id"]
		));	
}
}


?>