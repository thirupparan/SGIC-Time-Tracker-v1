<?php

//category_action.php
include('database_config_dashboard.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		$query = "
		INSERT INTO user_role (role_name,role_status) 
		SELECT * FROM (SELECT TRIM(:role_name), :role_status)
		AS tmp
WHERE NOT EXISTS (
    SELECT role_name FROM user_role WHERE role_name = TRIM(:role_name)
) LIMIT 1"
		;


		$statement = $connect->prepare($query);
		if($statement->execute(
			array(
				':role_name'	=>	$_POST["role_name"],
				':role_status'	=>	'Active'
			)
		))
		{
			if($statement->rowCount()>0){
				echo 'Role Name Added';
			}else if($statement->rowCount()==0){
				echo 'May be the Role Name already exist ';
			}else{
				echo 'error occured please check ';
			}
			
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
		try{
		$query = "
		UPDATE user_role set role_name = TRIM(:role_name)  
		WHERE role_id = :role_id";
		$statement = $connect->prepare($query);
		if($statement->execute(
			array(
				':role_name'	=>	$_POST["role_name"],
				':role_id'		=>	$_POST["role_id"]
			)
		))
		
		{
			if($statement->rowCount()>0){
				echo 'Role Name Edited';
			}else{
				echo 'error occured please check';
			}
			
		}
	}catch(PDOException $e)
		{
		echo 'Error occured : ' . $e->getMessage();
		}
	}


	if($_POST['btn_action'] == 'delete')
	{
		$status = 'Active';
		if($_POST['status'] == 'Active')
		{
			$status = 'Inactive';	
		}
	try{
		$query = "
		UPDATE user_role 
		SET role_status = :role_status 
		WHERE role_id = :role_id
		";
		$statement = $connect->prepare($query);
		if($statement->execute(
			array(
				':role_status'	=>	$status,
				':role_id'		=>	$_POST["role_id"]
			)
		))
		
		{
			echo 'Role status change to ' . $status;
		}
	}catch(PDOException $e)
	{
	echo 'Error occured : ' . $e->getMessage();
	}
	}
}

?>