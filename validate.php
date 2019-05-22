<?php
include 'database_config_dashboard.php';
require_once 'validations/existValidation.php';

if (isset($_POST['param'])) {
 if ($_POST['param'] == 'rolename') {
  echo (json_encode(ifNotexists($connect, $_POST['value'])));
 }
}
