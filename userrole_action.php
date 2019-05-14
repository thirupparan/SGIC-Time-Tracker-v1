<?php

//category_action.php
include('database_config_dashboard.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		$query = "
		INSERT INTO user_role (role_name,role_status) 
		VALUES (:role_name,:role_status)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':role_name'	=>	$_POST["role_name"],
				':role_status'	=>	'Active'
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Role Name Added';
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
		$query = "
		UPDATE user_role set role_name = :role_name  
		WHERE role_id = :role_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':role_name'	=>	$_POST["role_name"],
				':role_id'		=>	$_POST["role_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Role Name Edited';
		}
	}
	if($_POST['btn_action'] == 'delete')
	{
		$status = 'Active';
		if($_POST['status'] == 'Active')
		{
			$status = 'Inactive';	
		}
		$query = "
		UPDATE user_role 
		SET role_status = :role_status 
		WHERE role_id = :role_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':role_status'	=>	$status,
				':role_id'		=>	$_POST["role_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Role status change to ' . $status;
		}
	}
}

?>