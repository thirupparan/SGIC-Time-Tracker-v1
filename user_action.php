<?php

//user_action.php

include('database_config_dashboard.php');


if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		$query = "
		INSERT INTO user (user_email, user_password, user_name, user_type, user_status) 
		VALUES (:user_email, :user_password, :user_name, :user_type, :user_status)
		";	
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':user_email'		=>	$_POST["user_email"],
				':user_password'	=>	password_hash($_POST["user_password"], PASSWORD_DEFAULT),
				':user_name'		=>	$_POST["user_name"],
				':user_type'		=>	$_POST["user_type"],
				':user_status'		=>	'Active'
			)
		);
		//echo $query;
		if($connect->lastInsertId()>0){
		$query = "
		INSERT INTO user_profile 
		(user_id, first_name, last_name, address, contact_number, photo) 
		VALUES (:user_id, '#####', '#####', '#####', '####', 'person.png');
		";	
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':user_id'		=>	$connect->lastInsertId()
				
			)
		);

		$result = $statement->fetchAll();


		if(isset($result))
		{
			echo 'New User Added ';
		}
	}
	}

	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "
		SELECT * FROM user WHERE user_id = :user_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':user_id'	=>	$_POST["user_id"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['user_email'] = $row['user_email'];
			$output['user_name'] = $row['user_name'];
			$output['user_type'] = $row['user_type'];
		}
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'Edit')
	{
		if($_POST['user_password'] != '')
		{
			$query = "
			UPDATE user SET 
				user_name = '".$_POST["user_name"]."', 
				user_email = '".$_POST["user_email"]."',
				user_password = '".password_hash($_POST["user_password"], PASSWORD_DEFAULT)."' 
				WHERE user_id = '".$_POST["user_id"]."'
			";
		}
		else
		{
			$query = "
			UPDATE user SET 
				user_name = '".$_POST["user_name"]."', 
				user_email = '".$_POST["user_email"]."'
				WHERE user_id = '".$_POST["user_id"]."'
			";
		}
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'User Details Edited';
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
		UPDATE user 
		SET user_status = :user_status 
		WHERE user_id = :user_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':user_status'	=>	$status,
				':user_id'		=>	$_POST["user_id"]
			)
		);	
		$result = $statement->fetchAll();	
		if(isset($result))
		{
			echo 'User Status change to ' . $status;
		}
	}
}

?>