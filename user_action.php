<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
//$userEmail="'.$_POST["user_email"].'";
$urlglobal = "http://localhost/SGIC-Time-Tracker-v1/login.php";
//user_action.php

include 'database_config_dashboard.php';
include('function.php');
include_once('includes/query_execute.inc.php');
require_once 'validations/existValidation.php';

if (isset($_POST['btn_action'])) {
    if ($_POST['btn_action'] == 'Add') {
        $user_name = trim($_POST["user_name"]);
        $user_email=trim($_POST["user_email"]);
        if (ifNotexists($connect, "user", "user_name", $user_name)) {
            if (ifNotexists($connect, "user", "user_email", $user_email)) {
        $userpassrnd=randomPassword();
        try {
            $query = "
		INSERT INTO user (user_email, user_password, user_name, user_type, user_status)
		VALUES (TRIM(:user_email), TRIM(:user_password), TRIM(:user_name), TRIM(:user_type), :user_status)
		";
            $statement = $connect->prepare($query);
            if ($statement->execute(
                array(
                    ':user_email'    => $_POST["user_email"],
                    ':user_password' => password_hash($userpass, PASSWORD_DEFAULT),
                    ':user_name'     => $_POST["user_name"],
                    ':user_type'     => $_POST["user_type"],
                    ':user_status'   => 'Active',
                )
            )) {
                if ($statement->rowCount() > 0) {
                    //echo $query;
                    if ($connect->lastInsertId() > 0) {
                        $query = "
		INSERT INTO user_profile
		(user_id, first_name, last_name, address, contact_number, photo)
		VALUES (TRIM(:user_id),TRIM('#####'),TRIM('#####'),TRIM('#####'),TRIM('####'),TRIM('person.png'));
		";
                        $statement = $connect->prepare($query);
                        if ($statement->execute(
                            array(
                                ':user_id' => $connect->lastInsertId(),

                            )
                        )) {
         
                        if(sendMailNotification($_POST["user_name"],$_POST["user_email"],$userpassrnd,$urlglobal)){
                         
                                writeJsonMsg('Email send and New User Added','success');
                                
                        }else{
                              
                               writeJsonMsg('Mail not send  but New User Added','err');
                            }
                            
                        }
                    } elseif ($statement->rowCount() == 0) {
                        writeJsonMsg('May be the User Name  OR  Email already exist ','err');
                    }
                }
            }

        } catch (PDOException $e) {
            writeJsonMsg('error occured please check '. $e->getMessage(),'err');
        }
    } 
    
    else {
        writeJsonMsg('User Email Address Already exist','err');
       }
    } else {
        writeJsonMsg('User Name Already exist','err');
       }
    }

    if ($_POST['btn_action'] == 'fetch_single') {
        $query = "
		SELECT * FROM user WHERE user_id = :user_id
		";
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                ':user_id' => $_POST["user_id"],
            )
        );
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $output['user_email'] = $row['user_email'];
            $output['user_name']  = $row['user_name'];
            $output['user_type']  = $row['user_type'];
        }
        echo json_encode($output);
    }

    if ($_POST['btn_action'] == 'Edit') {
        try {
           
                $query = "
			UPDATE user SET
			user_name =TRIM(:user_name),
			user_email =TRIM(:user_email),
			user_type =:user_type
			WHERE user_id =:user_id
			";
            
            $statement = $connect->prepare($query);
            if ($statement->execute(
                array(
                    ':user_name'  => $_POST["user_name"],
                    ':user_email' => $_POST["user_email"],
                    ':user_type'  => $_POST["user_type"],
                    ':user_id'    => $_POST["user_id"],
                )
            )) {
                if ($statement->rowCount() > 0) {
                    writeJsonMsg('User Details Edited','success');
                } elseif ($statement->rowCount() == 0) {
                    writeJsonMsg('No changes had done on User Details','err');
                } else {
                    
                    writeJsonMsg('Error occured','err');
                }
            }
        } catch (PDOException $e) {
            echo 'Error occured : ' . $e->getMessage();
        }
    }

    if ($_POST['btn_action'] == 'delete') {
        $status = 'Active';
        if ($_POST['status'] == 'Active') {
            $status = 'Inactive';
        }

      
        try {

            $sql="SELECT user_role.role_status as usercount FROM user JOIN user_role ON user.user_type =user_role.role_id WHERE user.user_id =:user_id";
			
			$result = getResultwihParam($connect,$sql,array(
                		':user_id'     => $_POST["user_id"]
            ));
		
            if($result["usercount"]=='Active'){
            $query = "
		UPDATE user
		SET user_status = :user_status
		WHERE user_id = :user_id
		";
            $statement = $connect->prepare($query);
            if ($statement->execute(
                array(
                    ':user_status' => $status,
                    ':user_id'     => $_POST["user_id"],
                )
            )) {
                echo 'User Status change to ' . $status;
            }
        }else{
            echo "User Cannot be changed because the User role is Deactivated";
        }
        } catch (PDOException $e) {
            echo 'Error occured : ' . $e->getMessage();
        }
    }
}


function sendMailNotification($username,$useremail,$userpass,$url){
        //email function start
        // Load Composer's autoloader
        require 'phpmailer/vendor/autoload.php';

        // Instantiation and passing `true` enables exceptions
                $mail = new PHPMailer(true);
        
                try {
                    //Server settings
                    //$mail->SMTPDebug = 1; // Enable verbose debug output
                    $mail->isSMTP(); // Set mailer to use SMTP
                    $mail->Host       = 'smtp.gmail.com'; // Specify main and backup SMTP servers
                    $mail->SMTPAuth   = true; // Enable SMTP authentication
                    $mail->Username   = 'samuelgnanamhrm@gmail.com'; // SMTP username
                    $mail->Password   = 'SGIC123456'; // SMTP password
                    $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
                    $mail->Port       = 587; // TCP port to connect to
        
                    //Recipients
                    $mail->setFrom('samuelgnanamhrm@gmail.com', 'TIME TRACKER LOGIN INFORMATION');
                    $mail->addAddress($useremail, 'Sgic Time Tracker .com');
                    $Body = ' Dear ' . $username . ',</br>
                                <p> This is to inform you that SGIC TIME TRACKER SYSTEM login credentials information details  </p> </br>
                                Your Login Email ID : "' . $useremail . '"</br>
                                Your Login Password : "' . $userpass . '" </br>';
        
                    $Body .= '<p>Here is your web site login link : </br>';
                    $Body .= '<a href ="' . $url . '">' . $url . '</a></P></br>';
                    $Body .= '<p> After Login please change your password ... </P>';
                    // Content
                    $mail->isHTML(true); // Set email format to HTML
                    $mail->Subject = 'SGIC TIME TRACKER SYSTEM login credentials information details';
                    $mail->Body    = $Body;
                    $mail->AltBody = strip_tags($Body);
        
                    $mail->send();
                    //header("location:user.php?newuser_added=success");
                   return true;
                } catch (Exception $e) {
                    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    return false;
                } //finshed email function
}

