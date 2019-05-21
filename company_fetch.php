<?php

//category_fetch.php

include('database_config_dashboard.php');

$query = '';

$output = array();

$query .= "SELECT * FROM out_source_company ";

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE company_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR company_status LIKE "%'.$_POST["search"]["value"].'%" ';
}

if(isset($_POST['order']))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY company_id DESC ';
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
	$statusCheck='';
	if($row['company_status'] == 'Active')
	{
		
		$statusCheck ='<input type="checkbox" name="delete" checked id="'.$row["company_id"].'" class="delete"  data-status="'.$row["company_status"].'">';
		$updatebutton='<button type="button" name="update" id="'.$row["company_id"].'" class="btn btn-warning btn-xs update">Edit</button>';
	}
	else
	{
		
		$statusCheck ='<input type="checkbox" name="delete"  id="'.$row["company_id"].'" class="delete"  data-status="'.$row["company_status"].'">';
		$updatebutton='<button type="button" name="update" disabled id="'.$row["company_id"].'" class="btn btn-warning btn-xs update">Edit</button>';
	}
	$sub_array = array();
	$sub_array[] = $row['company_id'];
	$sub_array[] = $row['company_name'];
	$sub_array[] = $row['contact_number'];
	$sub_array[] = $row['email'];
	$sub_array[] = $row['address'];
	$sub_array[] = $updatebutton;
	$sub_array[] = $statusCheck;
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
	$statement = $connect->prepare("SELECT * FROM out_source_company");
	$statement->execute();
	return $statement->rowCount();
}


echo json_encode($output);

?>