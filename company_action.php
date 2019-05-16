<?php

//category_action.php
include('database_config_dashboard.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		try{
		$query = "
		INSERT INTO out_source_company (company_name,contact_number,email,address,company_status) 
		VALUES (TRIM(:company_name),TRIM(:contact_number),TRIM(:email),TRIM(:address),:company_status)
		";
		$statement = $connect->prepare($query);
		if($statement->execute(
			array(
				':company_name'	=>	$_POST["company_name"],
				':contact_number'	=>	$_POST["contact_number"],
				':email'	=>	$_POST["email"],
				':address'	=>	$_POST["address"],
				':company_status'	=>	'Active'
			)
		)){
			if($statement->rowCount()>0){
				echo 'Company Details Added';
			}else{
			echo 'error occured please check';
			}
		}
		}catch(PDOException $e)
		{
	echo 'Error occured : ' . $e->getMessage();
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
		try{
		$query = "
		UPDATE out_source_company set 
		company_name = TRIM(:company_name),
		contact_number =TRIM(:contact_number),
		email =TRIM(:email),
		address=TRIM(:address)
		WHERE company_id = :company_id
		";
		$statement = $connect->prepare($query);
		if($statement->execute(
			array(
				':company_id'		=>	$_POST["company_id"],
				':company_name'		=>	$_POST["company_name"],
				':contact_number'	=>	$_POST["contact_number"],
				':email'			=>	$_POST["email"],
				':address'			=>	$_POST["address"]
			)
		)){
			if($statement->rowCount()>0){
				echo 'Company Details Edited';
			}else if($statement->rowCount()==0){
				echo 'No changes had done on Company';
			}else{
				echo 'Error occured';
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
		UPDATE out_source_company 
		SET company_status = :company_status 
		WHERE company_id = :company_id
		";
		$statement = $connect->prepare($query);
		if($statement->execute(
			array(
				':company_status'	=>	$status,
				':company_id'		=>	$_POST["company_id"]
			)
		))
		{
			echo 'Company status change to ' . $status;
		}
	}catch(PDOException $e)
	{
	echo 'Error occured : ' . $e->getMessage();
	}
	}
}

?>