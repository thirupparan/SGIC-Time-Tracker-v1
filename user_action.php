<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
//$userEmail="'.$_POST["user_email"].'";
$url = "http://localhost/SGIC-Time-Tracker-v1/login.php";
//user_action.php

include 'database_config_dashboard.php';

if (isset($_POST['btn_action'])) {
    if ($_POST['btn_action'] == 'Add') {
        try {
            $query = "
		INSERT INTO user (user_email, user_password, user_name, user_type, user_status)
		VALUES (TRIM(:user_email), TRIM(:user_password), TRIM(:user_name), TRIM(:user_type), :user_status)
		";
            $statement = $connect->prepare($query);
            if ($statement->execute(
                array(
                    ':user_email'    => $_POST["user_email"],
                    ':user_password' => password_hash($_POST["user_password"], PASSWORD_DEFAULT),
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
                    $mail->addAddress($_POST["user_email"], 'Sgic Time Tracker .com');
                    $Body = ' Dear ' . $_POST["user_name"] . ',</br>
                                <p> This is to inform you that SGIC TIME TRACKER SYSTEM login credentials information details  </p> </br>
                                Your Login Email ID : "' . $_POST["user_email"] . '"</br>
                                Your Login Password : "' . $_POST["user_password"] . '" </br>';
        
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
                   echo 'Email message has been sent ';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                } //finshed email function
                $msg ="and";
                            echo $msg.' New User Added ';
                        }
                    } elseif ($statement->rowCount() == 0) {
                        echo 'May be the User Name  OR  Email already exist ';
                    }
                }
            }

        } catch (PDOException $e) {
            echo 'error occured please check ' . $e->getMessage();
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
            if ($_POST['user_password'] != '') {
                $query = "
			UPDATE user SET
			user_name = TRIM(:user_name),
			user_email =TRIM(:user_email),
			user_password ='" . password_hash(trim($_POST["user_password"]), PASSWORD_DEFAULT) . "',
			user_type =:user_type
			WHERE user_id =:user_id
			";
            } else {
                $query = "
			UPDATE user SET
			user_name =TRIM(:user_name),
			user_email =TRIM(:user_email),
			user_type =:user_type
			WHERE user_id =:user_id
			";
            }
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
                    echo 'User Details Edited';
                } elseif ($statement->rowCount() == 0) {
                    echo 'No changes had done on User Details';
                } else {
                    echo 'Error occured';
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
        } catch (PDOException $e) {
            echo 'Error occured : ' . $e->getMessage();
        }
    }
}
