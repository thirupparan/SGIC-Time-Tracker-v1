<?php

//category_fetch.php
session_start();
if(!isset($_SESSION["type"])){
  header("location:login.php");
}
include('database_config_dashboard.php');

$query = '';

$output = array();

$query .= "SELECT * FROM project WHERE user_id = '".$_SESSION["user_id"]."' AND";

if(isset($_POST["search"]["value"]))
{
	$query .= '(project_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR project_status LIKE "%'.$_POST["search"]["value"].'%" )';
}

if(isset($_POST['order']))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY project_id DESC ';
}

if($_POST['length'] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$data = array();

$filtered_rows = $statement->rowCount();

foreach($result as $row)
{
	$status = '';
	if($row['project_status'] == 'In_progress')
	{
		$status = '<span class="label label-success">In progress</span>';
	}
	else
	{
		$status = '<span class="label label-danger">Finished</span>';
	}
	$sub_array = array();
	$sub_array[] = $row['project_id'];
	$sub_array[] = $row['project_name'];
	$sub_array[] = $row['start_date'];
	$sub_array[] = $row['description'];
	$sub_array[] = $row['remarks'];
	$sub_array[] = $status;
	$sub_array[] = '<button type="button" name="update" id="'.$row["project_id"].'" class="btn btn-warning btn-xs update">Update</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["project_id"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["project_status"].'">Delete</button>';
	$data[] = $sub_array;
}

$output = array(
	"draw"			=>	intval($_POST["draw"]),
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=> 	get_total_all_records($connect),
	"data"				=>	$data
);

function get_total_all_records($connect)
{
	$statement = $connect->prepare("SELECT * FROM project");
	$statement->execute();
	return $statement->rowCount();
}


echo json_encode($output);

?>