<?php
function fill_user_role_list($connect)
{
 $query = "
	SELECT role_id,role_name FROM user_role WHERE role_status ='Active' ";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $output = '';
 foreach ($result as $row) {
  $output .= '<option value="' . $row["role_id"] . '">' . $row["role_name"] . '</option>';
 }
 return $output;
 echo $output;
}

function fill_company_list($connect)
{
 $query = "
	SELECT company_name,company_id FROM out_source_company WHERE company_status ='Active'";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $output = '';
 foreach ($result as $row) {
  $output .= '<option value="' . $row["company_id"] . '">' . $row["company_name"] . '</option>';
 }
 return $output;
 echo $output;
}

function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

//echo randomPassword();
