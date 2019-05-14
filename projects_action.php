<?php

//project_action.php
session_start();
if(!isset($_SESSION["type"])){
  header("location:login.php");
}

include('database_config_dashboard.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		$query = "
		INSERT INTO project (user_id,project_name,start_date,description,remarks,project_status) 
		VALUES (:user_id,:project_name,:start_date,:description,:remarks,:project_status)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':user_id'	=>	$_SESSION["user_id"],
				':project_name'	=>	$_POST["project_name"],
				':start_date'	=>	$_POST["start_date"],
				':description'	=>	$_POST["description"],
				':remarks'	=>	$_POST["remarks"],
				':project_status'	=>	'In_progress'
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Project Details Added';
		
		}
	}
	
	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "SELECT * FROM project WHERE project_id = :project_id";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':project_id'	=>	$_POST["project_id"]
			
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['project_name'] = $row['project_name'];
			$output['start_date'] = $row['start_date'];
			$output['description'] = $row['description'];
			$output['remarks'] = $row['remarks'];
		}
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'Edit')
	{
		$query = "
		UPDATE project set project_name = :project_name,start_date =:start_date,description =:description,remarks=:remarks
		WHERE project_id = :project_id
		";
		
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':project_id'	=>	$_POST["project_id"],
				':project_name'	=>	$_POST["project_name"],
				':start_date'=>	$_POST["start_date"],
				':description'		=>	$_POST["description"],
				':remarks'		=>	$_POST["remarks"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Project Details Edited';
		}
	}
	if($_POST['btn_action'] == 'delete')
	{
		$status = 'In_progress';
		if($_POST['status'] == 'In_progress')
		{
			$status = 'Finished';	
		}
		$query = "
		UPDATE project 
		SET project_status = :project_status 
		WHERE project_id = :project_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':project_status'	=>	$status,
				':project_id'		=>	$_POST["project_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Company status change to ' . $status;
		}
	}
}

?>