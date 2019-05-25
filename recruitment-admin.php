<?php
//profile.php
include('./fragments/header.php');
include('database_config_dashboard.php');
include('includes/query_execute.inc.php');
include('function.php');


?>
<div id="companyModal" class="modal fade">
	<div class="modal-dialog">

		<form id="company_form">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> Manage Recruitment</h4>
				</div>
				<div class="modal-body">
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
						<input type="date" name="recruited_date" id="recruited_date" class="form-control" required />
					</div>

					<div class="form-group">
						<label>Contract Period</label>
						<input type="text" name="Contract_Period" id="Contract_Period" class="form-control" required />
					</div>


					<input type="hidden" name="user_id_company" id="user_id_company"
						value="<?php echo $_GET['userid'];?>" />

				</div>
				<div class="modal-footer">
					<input type="submit" name="btn_action_company" id="btn_action_company" class="btn btn-info"
						value="Add" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>


<div class="row">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="#">User List</a></li>
			<li class="active">recruitments</li>
		</ol>
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
						<button type="button" name="add" id="add_button" class="btn btn-primary btn-xs">Add</button>
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

				<div class="col-md-12 ">
					<div class="panel panel-success">
						<div class="panel-heading">
							Recruited Details

						</div>
						<div class="panel-body">

							<div class="col-md-4">
								<div class="thumbnail">
									<table class="table">
										<tr>
											<th align="right">Recruited at</th>
											<th><?php echo $row['company_name'];?></th>
										</tr>
										<tr>
											<th align="right">Recruited as :</th>
											<th><?php echo $row['work_role'];?></th>
										</tr>

										<tr>
											<th align="right">Work Title :</th>
											<th>Software Engineer</th>
										</tr>

									</table>
								</div>

								<div class="thumbnail">
									<table class="table">

										<tr>
											<th align="right">Recruited on</th>
											<th><?php echo $row['recruited_date'];?></th>
										</tr>
										<tr>
											<th align="right">Contract Period</th>
											<th><?php echo $row['contract_period'];?></th>
										</tr>
										<tr>
											<th align="right">Left On</th>





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

							<div class="col-md-8">
								<table class="table table-bordered">
									<tr>
										<th>Project Name</th>
										<th>Start Date</th>
										<th>Progress</th>
									</tr>
								</table>
							</div>





						</div>
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



		$('#add_button').on('click', function () {

			$('#companyModal').modal('show');

		});

	});
</script>

<?php
include('./fragments/footer.html');
?>