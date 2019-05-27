<?php

//category_action.php
include 'database_config_dashboard.php';
include 'includes/query_execute.inc.php';
require_once 'validations/existValidation.php';

if (isset($_POST['btn_action'])) {
 if ($_POST['btn_action'] == 'Add') {
  $company_name = trim($_POST["company_name"]);
  $company_Email = trim($_POST["email"]);
  if (ifNotexists($connect, "out_source_company", "company_name", $company_name)) {
   if (ifNotexists($connect, "out_source_company", "email", $company_Email)) {
    $query = "
		INSERT INTO out_source_company (company_name,contact_number,email,address,company_status)
		VALUES (TRIM(:company_name),TRIM(:contact_number),TRIM(:email),TRIM(:address),:company_status)
		";
    execute_query("Company details inserted", "unable to insert Company details", $connect, $query, array(
     ':company_name'   => $_POST["company_name"],
     ':contact_number' => $_POST["contact_number"],
     ':email'          => $_POST["email"],
     ':address'        => $_POST["address"],
     ':company_status' => 'Active',
    ));
   } else {
    echo json_encode(printJsonMsg("Company Email Address Already exist", 'err'));
   }
  } else {
   echo json_encode(printJsonMsg("Company Name Already exist", 'err'));
  }

 }

 if ($_POST['btn_action'] == 'fetch_single') {
  $query     = "SELECT * FROM out_source_company WHERE company_id = :company_id";
  $statement = $connect->prepare($query);
  $statement->execute(
   array(
    ':company_id' => $_POST["company_id"],

   )
  );
  $result = $statement->fetchAll();
  foreach ($result as $row) {
   $output['company_name']   = $row['company_name'];
   $output['contact_number'] = $row['contact_number'];
   $output['email']          = $row['email'];
   $output['address']        = $row['address'];
  }
  echo json_encode($output);
 }

 if ($_POST['btn_action'] == 'Edit') {
  $company_name = trim($_POST["company_name"]);
  if (ifNotexistsLock($connect, "out_source_company", "company_name", $_POST["company_name"], "company_id", $_POST["company_id"])) {
   if (ifNotexistsLock($connect, "out_source_company", "email", $_POST["email"], "company_id", $_POST["company_id"])) {
    $query = "
					UPDATE out_source_company set
					company_name = TRIM(:company_name),
					contact_number =TRIM(:contact_number),
					email =TRIM(:email),
					address=TRIM(:address)
					WHERE company_id = :company_id
					";
    execute_query("Company Details Edited", "Unable to edit Company Details", $connect, $query, array(
     ':company_id'     => $_POST["company_id"],
     ':company_name'   => $_POST["company_name"],
     ':contact_number' => $_POST["contact_number"],
     ':email'          => $_POST["email"],
     ':address'        => $_POST["address"],
    ));
   } else {
    echo json_encode(printJsonMsg("Company Email Address Already exist", 'err'));
   }
  } else {
   echo json_encode(printJsonMsg("Company Name Already exist", 'err'));
  }

 }
 if ($_POST['btn_action'] == 'delete') {
  $status = 'Active';
  if ($_POST['status'] == 'Active') {
   //$status = 'Inactive';
   $sql = "SELECT count(user_company.user_company_id) as userCompanyCount FROM out_source_company
   INNER JOIN user_company ON user_company.company_id=out_source_company.company_id
   WHERE out_source_company.company_id=:company_id AND out_source_company.company_status='Active'";
   $statement = $connect->prepare($sql);
   $statement->execute(
    array(
     ':company_id' => $_POST["company_id"]
    )
   );
   $result = $statement->fetch(PDO::FETCH_ASSOC);

   if ($result["userCompanyCount"] <= 0) {
    $status = 'Inactive';
   }
  }

  $query = "
		UPDATE out_source_company
		SET company_status = :company_status
		WHERE company_id = :company_id
		";
  execute_query("Company Details Changed", "Unable to Change Company Details", $connect, $query, array(
   ':company_status' => $status,
   ':company_id'     => $_POST["company_id"]
  ));
 }
}
