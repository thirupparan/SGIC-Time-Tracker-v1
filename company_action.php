<?php

//category_action.php
include('database_config_dashboard.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		$query = "
		INSERT INTO out_source_company (company_name,contact_number,email,address,company_status) 
		VALUES (:company_name,:contact_number,:email,:address,:company_status)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':company_name'	=>	$_POST["company_name"],
				':contact_number'	=>	$_POST["contact_number"],
				':email'	=>	$_POST["email"],
				':address'	=>	$_POST["address"],
				':company_status'	=>	'Active'
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Company Details Added';
		
		}
	}
	
	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "SELECT * FROM out_source_company WHERE company_id = :company_id";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':company_id'	=>	$_POST["company_id"]
			
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['company_name'] = $row['company_name'];
			$output['contact_number'] = $row['contact_number'];
			$output['email'] = $row['email'];
			$output['address'] = $row['address'];
		}
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'Edit')
	{
		$query = "
		UPDATE out_source_company set company_name = :company_name,contact_number =:contact_number,email =:email,address=:address
		WHERE company_id = :company_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':company_id'		=>	$_POST["company_id"],
				':company_name'	=>	$_POST["company_name"],
				':contact_number'		=>	$_POST["contact_number"],
				':email'		=>	$_POST["email"],
				':address'		=>	$_POST["address"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Company Details Edited';
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
		UPDATE out_source_company 
		SET company_status = :company_status 
		WHERE company_id = :company_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':company_status'	=>	$status,
				':company_id'		=>	$_POST["company_id"]
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