<?php
include 'database_config_dashboard.php';
require_once 'validations/existValidation.php';

if (isset($_POST['param'])) {
 if ($_POST['param'] == 'rolename') {
  echo (json_encode(ifNotexists($connect, "user_role", "role_name", $_POST['value'])));
 } elseif ($_POST['param'] == 'company_name') {
  if ($_POST['action'] == 'Add') {
   echo (json_encode(ifNotexists($connect, "out_source_company", "company_name", $_POST['value'])));
  } elseif ($_POST['action'] == 'Edit') {
   echo (json_encode(ifNotexistsLock($connect, "out_source_company", "company_name", $_POST['value'], "company_id", $_POST['actionvalue'])));
  }
 } elseif ($_POST['param'] == 'email') {
  if ($_POST['action'] == 'Add') {
   echo (json_encode(ifNotexists($connect, "out_source_company", "email", $_POST['value'])));
  } elseif ($_POST['action'] == 'Edit') {
   echo (json_encode(ifNotexistsLock($connect, "out_source_company", "email", $_POST['value'], "company_id", $_POST['actionvalue'])));
  }
 }
}
