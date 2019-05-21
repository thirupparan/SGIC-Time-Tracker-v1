<?php

include('./fragments/header.php');
if(!isset($_SESSION["type"])){
	header("location:index.php");
}

include('function.php');


?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
						<h3 class="panel-title">User List</h3>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
						<button type="button" name="add" id="add_button" data-toggle="modal" data-target="#userModal"
							class="btn btn-primary btn-xs">Add</button>
					</div>
				</div>

				<div class="clear:both"></div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-12 table-responsive">
					<span id="alert_action"></span>
					<?php
// if(isset($_GET["newuser_added"])){
//     if($_GET["newuser_added"]=="success"){
//         echo '<div class="alert alert-success">new user added </div>';
//     }
// }
// ?>
						<table id="user_data" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>ID</th>
									<th>Email</th>
									<th>Name</th>
									<th>Role</th>
									<th>Edit</th>
									<th>Active/Inactive</th>
									<th>Recruitments</th>

								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
 
<div id="companyModal" class="modal fade">
	<div class="modal-dialog modal-lg">
	
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Manage Recruitment</h4>
			</div>
			<div class="modal-body">

				<div class="panel panel-default">
					<div class="panel-body">
						<form id="company_form">
							<div class="row">
								<div class="col-md-5">
									<div class="form-group">
										<label for="company_name">Select Company</label>
										<select name="company_name" id="company_name" class="form-control" required>
											<option value="">Select Company</option>
											<?php echo fill_company_list($connect); ?>
											<!-- <option value="Other">Other</option> -->
										</select>
									</div>

									<div class="form-group">
										<label>Work Role</label>
										<input type="text" name="work_role" id="work_role" class="form-control"
											required />
									</div>
								</div>

								<div class="col-md-5">
									<div class="form-group">
										<label for="recruited_date">Recruited Date</label>
										<input type="date" name="recruited_date" id="recruited_date"
											class="form-control" required />
									</div>

									<div class="form-group">
										<label>Contract Period</label>
										<input type="text" name="Contract_Period" id="Contract_Period"
											class="form-control" required />
									</div>
								</div>

								<div class="col-md-2">
									<br /><br/><br/><br/><br/>
									<input type="hidden" name="action_company" id="action_company" />
									<input type="hidden" name="user_company_id" id="user_company_id" />
									<input type="hidden" name="user_id_company" id="user_id_company" />
									<input type="submit" name="btn_action_company" id="btn_action_company"
										class="btn btn-info" value="Add" />
								</div>
							</div>
						</form>
						<span id="alert_company_action"></span>
					</div>
				</div>

				<div id="result">
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div id="userModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="user_form" autocomplete="off">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> Add User</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Enter User Name</label>
						<input type="text" name="user_name" id="user_name" class="form-control" required />
					</div>
					<div class="form-group">
						<label>Enter User Email</label>
						<input type="email" name="user_email" id="user_email" class="form-control" required />
					</div>
					<div class="form-group">
						<label class="sr-only">Enter User Password</label>
						<input type="hidden" name="user_password" id="user_password" class="form-control" value ="<?php echo randomPassword();?>"required />
					</div>

					<div class="form-group">
						<label>Select User Role</label>
						<select name="user_type" id="user_type" class="form-control" required>
							<option value="">Select User Type</option>
							<?php echo fill_user_role_list($connect); ?>
							<!-- <option value="Other">Other</option> -->
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="user_id" id="user_id" />
					<input type="hidden" name="btn_action" id="btn_action" />
					<input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>

	</div>
</div>

<?php include('./fragments/script.html')?>
<script>
	//assign company  data table
	$(document).ready(function () {

		// getting user id
		var userid = null;

		function fetchCompany() {
			var btn_action = 'fetch_single';
			var action = "select";
			$.ajax({
				url: "company_assign_select.php",
				method: "POST",
				data: { action: action, user_id: userid },
				success: function (data) {
					$('#recruited_date').val('');
					$('#company_name').val('');
					$('#companyModal .modal-title').html('Manage Recruitment');
					$('#work_role').val('');
					$('#Contract_Period').val('');
					$('#user_id_company').val(userid);
					$('#action_company').val("Add");
					$('#btn_action_company').val("Add");
					$('#result').html(data);
				
				}
			});
		}


		$(document).on('click', '.company', function () {
			userid = $(this).attr("id");
			fetchCompany();
		});

		

		$(document).on('submit', '#company_form', function (event) {
			event.preventDefault();
			$('#btn_action_company').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			$.ajax({
				url: "company_assign_action.php",
				method: "POST",
				data: form_data,
				success: function (data) {
					$('#alert_company_action').html(data);
					fetchCompany(userid);
					setTimeout(() => {
						$('#alert_company_action').html('');
					}, 1500);
					$('#btn_action_company').attr('disabled', false);
				}
			});
		});


		//assign company update
		$(document).on('click', '.update_company', function () {
			var id = $(this).attr("id");
			$('#action_company').val("Edit");
			$('#btn_action_company').val("Edit");
			$.ajax({
				url: "company_assign_fetch.php",
				method: "POST",
				data: { user_company_id: id },
				dataType: "json",
				success: function (data) {
					$('#company_name').val(data.company_id);
					$('#recruited_date').val(data.recruited_date);
					$('#user_company_id').val(data.user_company_id);
					$('#work_role').val(data.work_role);
					$('#Contract_Period').val(data.contract_period);
				}
			})
		});

		//assign company delete
		$(document).on('click', '.delete_company', function () {
			var id = $(this).attr("id");
			//alert(id);
			if (confirm("Are you sure you want to remove this data?")) {
				var action = "Delete";
				$.ajax({
					url: "company_assign_action.php",
					method: "POST",
					data: { user_company_id: id, action_company: action },
					success: function (data) {
						fetchCompany();
						$('#alert_company_action').html(data);
						setTimeout(() => {
							$('#alert_company_action').html('');
						}, 1500);
					}
				})
			}
			else {
				return false;
			}
		});

		$(document).on('click', '.company', function () {
			var id = $(this).attr("id");
			$('#companyModal').modal('show');
		});

	


	

		$('#add_button').click(function () {
			$('#user_form')[0].reset();
			$('.modal-title').html("<i class='fa fa-plus'></i> Add User");
			$('#action').val("Add");
			$('#btn_action').val("Add");
		});

		var userdataTable = $('#user_data').DataTable({
			"processing": true,
			"serverSide": true,
			"order": [],
			"language": {
    			"search": "Search by Email or Name:"
 				 },
			"ajax": {
				url: "user_fetch.php",
				type: "POST",

			},
			"columnDefs": [
				{
					"targets": [4,5,6],
					"orderable": false
				}
			],
			"fnDrawCallback": function() {
            jQuery('#user_data .delete').bootstrapToggle({
				on: 'Active',
      			off: 'Inactive',
				size:'mini'
			});
		},
			"pageLength": 25
		});

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




		$('#user_form').validate({
			 
		rules:{
			user_name:{
				required:true,
				noSpace:true,
				regex: "^[a-zA-Z'.\\s]{1,40}$" 
			},
			user_email:{
				required:true,
				email:true
			}
		},
		messages:{
			user_name:{
				required:"please Enter User name",
				noSpace:"Spaces Not Allowed",
				regex:"Only character allowed"
			},
			user_email:{
				required:"please Enter Email",
				noSpace:"Spaces Not Allowed",
				email:"please provide valid email"
			}
		}
		});
		

		$(document).on('submit', '#user_form', function (event) {
			event.preventDefault();

			$('#action').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			//console.log(form_data);
			$.ajax({
				url: "user_action.php",
				method: "POST",
				data: form_data,
				success: function (data) {
					$('#user_form')[0].reset();
					$('#userModal').modal('hide');
					$('#alert_action').fadeIn().html('<div class="alert alert-success">' + data + '</div>');
					$('#action').attr('disabled', false);
					userdataTable.ajax.reload();
					setTimeout(() => {
						$('#alert_action').html('');
					}, 1500);
				}
			})
		});

		$(document).on('click', '.update', function () {
			var user_id = $(this).attr("id");
			var btn_action = 'fetch_single';
			$.ajax({
				url: "user_action.php",
				method: "POST",
				data: { user_id: user_id, btn_action: btn_action },
				dataType: "json",
				success: function (data) {
					$('#userModal').modal('show');
					$('#user_name').val(data.user_name);
					$('#user_email').val(data.user_email);
					$('#user_form .modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit User");
					$('#user_id').val(user_id);
					$("#user_type").val(data.user_type);
					$('#action').val('Update');
					$('#btn_action').val('Edit');
					$('#user_password').attr('required', false);

				}
			})
		});

		$(document).on('change', '.delete', function () {
			var user_id = $(this).attr("id");
			var status = $(this).data('status');
			var btn_action = "delete";
			if (confirm("Are you sure you want to change status?")) {
				$.ajax({
					url: "user_action.php",
					method: "POST",
					data: { user_id: user_id, status: status, btn_action: btn_action },
					success: function (data) {
						$('#alert_action').fadeIn().html('<div class="alert alert-info">' + data + '</div>');
						userdataTable.ajax.reload();
						setTimeout(() => {
						$('#alert_action').html('');
					}, 1500);
					}
				})
			}
			else {
				userdataTable.ajax.reload();
				return false;
			}
		});

	});
</script>

<?php
include('./fragments/footer.html');
?>