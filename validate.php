<?php
include 'database_config_dashboard.php';
require_once 'validations/existValidation.php';

if (isset($_POST['param'])) {
 if ($_POST['param'] == 'rolename') {
  echo (json_encode(ifNotexists($connect,"user_role","role_name", $_POST['value'])));
 }elseif($_POST['param'] == 'company_name'){
    echo (json_encode(ifNotexists($connect,"out_source_company","company_name", $_POST['value'])));
 }elseif($_POST['param'] == 'email'){
   echo (json_encode(ifNotexists($connect,"out_source_company","email", $_POST['value'])));
}
}
