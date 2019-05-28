<?php
//profile.php
include('./fragments/header.php');
include('database_config_dashboard.php');

try{
$query = "
SELECT 
user_profile.first_name,user_profile.last_name,user_profile.address,user_profile.address,user_profile.contact_number,user_profile.photo,user.user_name,user.user_email,user.user_password FROM user_profile INNER JOIN user ON user_profile.user_id=user.user_id
WHERE user.user_id = '".$_SESSION["user_id"]."'
";

//echo $query;

$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$user_name = '';
$first_name = '';
$last_name = '';
$address = '';
$contact_number = '';
$user_email = '';
$user_password = '';
$photo = '';
$profile_id = '';
$user_id = '';
foreach($result as $row)
{
	$user_name = $row['user_name'];
	$first_name = $row['first_name'];
	$last_name = $row['last_name'];
	$address = $row['address'];
	$contact_number = $row['contact_number'];
	$photo = $row['photo'];
	$user_email = $row['user_email'];
	$user_password = $row['user_password'];
}
}catch(PDOException $e){
	echo 'error occured please check ' .$e->getMessage();
}

?>


	<div class="row">

		<!-- profile panel starts here -->
		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="panel panel-default margin-2">
				<div class="panel-heading">Profile</div>
				<div class="panel-body">
					<form method="post" id="edit_profile_form">
						<!-- enctype="multipart/form-data" -->
						<span id="profile_message"></span>


						<div class="form-group">
							<label>User Name</label>
							<input type="text" name="user_name" id="user_name" class="form-control"
								value="<?php echo $user_name; ?>" required readonly />
						</div>
						<div class="form-group">
							<label>First Name</label>
							<input type="text" name="first_name" id="first_name" class="form-control"
								value="<?php echo $first_name; ?>" required maxlength=30 />
						</div>

						<div class="form-group">
							<label>Last Name</label>
							<input type="text" name="last_name" id="last_name" class="form-control"
								value="<?php echo $last_name; ?>" required maxlength=30/>
						</div>

						<div class="form-group">
							<label>Contact Number</label>
							<input type="text" name="contact_number" id="contact_number" class="form-control"
								value="<?php echo $contact_number; ?>" required maxlength=13/>
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" name="user_email" id="user_email" class="form-control" required readonly
								value="<?php echo $user_email; ?>" />
						</div>

						<div class="form-group">
							<label>Address</label>
							<textarea name="address" id="address" class="form-control" rows="3" cols="3" style="resize:none;" required maxlength=40>
								<?php echo $address; ?>
							</textarea>

						</div>

						<div class="form-group">
							<input type="hidden" name="action" value="edit_profile" />
							<input type="submit" name="edit_profile" id="edit_prfile" value="Edit"
								class="btn btn-info" />
						</div>

					</form>
				</div>
			</div>
		</div>
		<!-- profile panel ends here -->

		
		<div class="col-md-6 col-sm-12 col-xs-12">

			<!-- Profile photo management -->
			<div class="panel panel-default margin-2">
				<div class="panel-heading">Change profile photo</div>
				<div class="panel-body">
					<span id="photo_upload"></span>
					<form method="post" id="edit_photo_form" action="upload.php">
						<label>Choose the file to change profile photo</label>

						<div class="form-group">
							<label>Profile Image</label>
							<input type="file" name="photo" id="photo" accept=".jpg,.png" class="form-control" />
							<span id="empty_file"></span>
						</div>

						<div class="form-group">
							<input type="submit" name="edit_profile_photo" id="edit_profile_photo"
								value="Edit profile photo" class="btn btn-info" />
						</div>
						<div class="progress">
							<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0"
								aria-valuemax="100"></div>
						</div>
						<div id="targetLayer" style="display:none;"></div>
					</form>

					<div id="loader-icon" style="display:none;"><img src="loader.gif" /></div>
				</div>
			</div>
			<!-- Profile photo management ends here-->


			<!-- change password  -->
			<div class="panel panel-default margin-2">
				<div class="panel-heading">Change Password</div>
				<div class="panel-body">
					<span id="pwd_message"></span>
					<form method="post" id="edit_password_form">
						<label>Leave Password blank if you do not want to change</label>
						<div class="form-group">
							<label>Current Password <span>*</span></label>
							<input type="password" name="user_current_password" id="user_current_password"
								class="form-control" required/>
						</div>


						<div class="form-group">
							<label>New Password</label>
							<input type="password" name="user_new_password" id="user_new_password"
								class="form-control" onKeyUp="checkPasswordStrength();" required/>
								<div id="password-strength-status"></div>
						</div>
						<div class="form-group">
							<label>Re-enter Password</label>
							<input type="password" name="user_re_enter_password" id="user_re_enter_password"
								class="form-control" required />
							<span id="error_password"></span>
						</div>
						<div class="form-group">
							<input type="hidden" name="action" value="change_password" />
							<input type="hidden" name="password_strength" id="password_strength"/>
							<input type="submit" name="change_password" id="change_password" value="Change password"
								class="btn btn-info" />
						</div>
					</form>
				</div>
			</div>

			<!-- change password ends here -->

		</div>

	</div>







<?php include('./fragments/script.html'); ?>
<script>
//change password jquary


function checkPasswordStrength() {
		var number = /([0-9])/;
		var alphabets = /([a-zA-Z])/;
		var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
		if($('#user_new_password').val().length<6) {
		$('#password-strength-status').removeClass();
		$('#password-strength-status').css({"background-color": "#E4DB11","border":"#BBB418 1px solid"});
		$('#password-strength-status').html("Weak (should be atleast 6 characters.)");
		$('#password_strength').val('weak');
		} else {  	
		if($('#user_new_password').val().match(number) && $('#user_new_password').val().match(alphabets) && $('#user_new_password').val().match(special_characters)) {            
		$('#password-strength-status').removeClass();
		$('#password-strength-status').css({"background-color": "#12CC1A","border":"#0FA015 1px solid"});
		
		$('#password-strength-status').html("Strong");
		$('#password_strength').val('strong');
		} else {
		$('#password-strength-status').removeClass();
		$('#password-strength-status').css({"background-color": "#FF6600","border":"#AA4502 1px solid"});
		$('#password-strength-status').html("Medium (should include alphabets, numbers and special characters.)");
		$('#password_strength').val('medium');
		}}
		
		}

		


	$(document).ready(function () {
		$('#edit_password_form').on('submit', function (event) {
			event.preventDefault();
			if ($('#user_new_password').val() != '') {
				if ($('#user_new_password').val() != $('#user_re_enter_password').val()) {
					$('#error_password').html('<label class="text-danger">Password Not Match</label>');
					return false;
				}
				else {
					$('#error_password').html('');
				}
			}

			if($('#password_strength').val()=='strong'){
				var form_data = $(this).serialize();
				$('#change_password').attr('disabled', 'disabled');
			$('#user_re_enter_password').attr('required', false);
			$.ajax({
				url: "edit_profile.php",
				method: "POST",
				data: form_data,
				success: function (data) {
					$('#change_password').attr('disabled', false);
					$('#user_current_password').val('');
					$('#user_new_password').val('');
					$('#user_re_enter_password').val('');
					$('#pwd_message').html(data);
					$('#error_password').html('');
					$('#password-strength-status').remove();
					setTimeout(function () {
							$('#pwd_message').html('');	
						}, 1500);
				}
			})
				
			}else{
				$('#error_password').html('<label class="text-danger">Your password need to be strong In order to change password</label>');
			}
			
			
		});

		
	});
		//edit profile jquary
	$(document).ready(function () {
		$.validator.addMethod("noSpace", function(value, element) { 
  return value.indexOf(" ") < 0 && value != ""; 
}, "No space please and don't leave it empty");

$.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Please check your input."
);




		var validatorprofile = $('#edit_profile_form').validate({
			 
		rules:{
			first_name:{
				required:true,
				noSpace:true,
				regex: "^[a-zA-Z'.\\s]{1,40}$" 
			},
			last_name:{
				required:true,
				noSpace:true,
				regex: "^[a-zA-Z'.\\s]{1,40}$" 
			},
			contact_number:{
				required:true,
				digits:true,
				minlength:10,
				maxlength:10
			},
			address:{
				required:true,
				minlength:10,
				maxlength:40
			}
		},
		messages:{
			user_name:{
				required:"please Enter First Name",
				noSpace:"Spaces Not Allowed",
				regex:"Only character allowed"
			},
			last_name:{
				required:"please Enter First Name",
				noSpace:"Spaces Not Allowed",
				regex:"Only character allowed"
			},
			contact_number:{
				required:"please Enter Contact Number",
				minlength:"phone number must be of 10 numbers",
				maxlength:"phone number must be of 10 numbers"

			},
			address:{
				required:"please enter Address",
				minlength:"Address should be atleast 10 characters",
				maxlength:"Address should not exceed 40 characters"
			}
		}
		});

		$('#edit_profile_form').on('submit', function (event) {
			event.preventDefault();
			var form_data = $(this).serialize();
			console.log(form_data);
			$('#edit_profile').attr('disabled', 'disabled');
			//$('#user_re_enter_password').attr('required', false);
			$.ajax({
				url: "edit_profile.php",
				method: "POST",
				data: form_data,
				success: function (data) {
					$('#edit_prfile').attr('disabled', false);
					$('#first_name').val('');
					$('#last_name').val('');
					$('#contact_number').val('');
					$('#address').val('');
					$('#user_name').val('');
					$('#user_email').val('');
					$('#photo').val('');
					$('#profile_message').html(data);
					setTimeout(function () {
							window.location.reload();	
						}, 1500);
				}
			})
		});
	});
	//photo upload jquary
	$(document).ready(function () {
		$('#edit_photo_form').submit(function (event) {
			if($('#photo').val()==''){
				$('#empty_file').html('<label class="text-danger">Please Choose file </label>');
					return false;
			}else{
			if ($('#photo').val()) {
				event.preventDefault();
				$('#loader-icon').show();
				$('#targetLayer').hide();
				var form_data = $(this).serialize();
				console.log(form_data);
				$(this).ajaxSubmit({
					data: form_data,
					target: '#targetLayer',
					beforeSubmit: function () {
						$('.progress-bar').width('50%');
					},
					uploadProgress: function (event, position, total, percentageComplete) {
						$('.progress-bar').animate({
							width: percentageComplete + '%'
						}, {
								duration: 1000
							});
					},
					success: function (data) {
						$('#loader-icon').hide();
						//$('#targetLayer').show();
						$('#photo_upload').html(data);

						setTimeout(function () {
							window.location.reload();
						}, 1500);
					},
					
					resetForm: true
				});
			}
		}
			return false;
		});

		
	

	});
</script>

<?php
include('./fragments/footer.html');
?>