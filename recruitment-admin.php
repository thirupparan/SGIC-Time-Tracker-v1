<?php
//profile.php
include('./fragments/header.php');
include('database_config_dashboard.php');
include('includes/query_execute.inc.php');
include('function.php');


?>
<div id="companyModal" class="modal fade">
		<div class="modal-dialog">

			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> Manage Recruitment</h4>
				</div>
				<div class="modal-body">

					<div class="panel panel-default">
						<div class="panel-body">
							<form id="company_form">


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
									<input type="text" name="work_role" id="work_role" class="form-control" required />
								</div>
								
								<div class="form-group">
									<label for="recruited_date">Recruited Date</label>
									<input type="date" name="recruited_date" id="recruited_date" class="form-control"
										required />
								</div>

								<div class="form-group">
									<label>Contract Period</label>
									<input type="text" name="Contract_Period" id="Contract_Period" class="form-control"
										required />
								</div>


								<input type="hidden" name="action_company" id="action_company" />
								<input type="hidden" name="user_company_id" id="user_company_id" />
								<input type="hidden" name="user_id_company" id="user_id_company" />
								<input type="submit" name="btn_action_company" id="btn_action_company"
									class="btn btn-info" value="Add" />


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

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
						<h3 class="panel-title">Company Assignment</h3>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
						<button type="button" name="add" id="add_button" data-toggle="modal" data-target="#companyModal"
							class="btn btn-primary btn-xs">Add</button>
					</div>
				</div>

				<div class="clear:both"></div>
			</div>
			<div class="panel-body">

		<?php
	
 
   
			$query = "CALL selectUser(".$_GET['userid'].")";  
			$result = getAll($connect,$query);  
			
			foreach($result  as $row){
				?>

		<div class="panel panel-default margin-2">
			<div class="panel-heading">
				Works at - <?php echo $row['company_name'];?>
				<span class="pull-right">Works as - <?php echo $row['work_role'];?></span>
			</div>
			<div class="panel-body">




				<table class="table">
					<tr>
						<th>Recruited on</th>
						<th>Contract Period</th>
						<th>Left On</th>
					</tr>
					<tr>
						<th><?php echo $row['recruited_date'];?></th>
						<th><?php echo $row['contract_period'];?></th>

						<?php 
						if( $row['working_status']=='Working') {
							echo '<th><button>Notify Leave</button></th>';
						}else{
							echo '<td>dd-mm-yyyy</td>';
						}
						
						?>
					</tr>
				</table>

			</div>
		</div>
		<?php 
				 }
				 	
				 
				?>


</div>
		</div>

	</div>
</div>


				

<?php include('./fragments/script.html')?>

<script>

	$(document).ready(function () {
		alert('tes');
		$(document).on('submit', '#company_form', function (event) {
			event.preventDefault();
			$('#btn_action_company').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			console.log(form_data);
			$.ajax({
				url: "company_assign_action.php",
				method: "POST",
				data: form_data + "&action_company=Add",
				success: function (data) {
					// $('#alert_company_action').html(data);
					// fetchCompany(userid);
					// setTimeout(() => {
					// 	$('#alert_company_action').html('');
					// }, 1500);
					// $('#btn_action_company').attr('disabled', false);
					window.location.reload();
					//console.log(data);
				}
			});
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

		$('#add_button').on('click', function () {
			
			//$('#companyModal').modal('show');
			alert('test');
		});

	});
</script>

<?php
include('./fragments/footer.html');
?>