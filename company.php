<?php
//category.php
include('./fragments/header.php');
include('database_config_dashboard.php');
if(!isset($_SESSION["type"])){
	header("location:login.php");
}


?>

<span id="alert_action"></span>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
					<div class="row">
						<h3 class="panel-title">Company Details</h3>
					</div>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
					<div class="row" align="right">
						<button type="button" name="add" id="add_button" data-toggle="modal" data-target="#companyModal"
							class="btn btn-success btn-xs">Add</button>
					</div>
				</div>
				<div style="clear:both"></div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-12 table-responsive">
						<table id="company_data" class="table table-bordered table-striped">
							<thead>
							<tr>
									<th>ID</th>
									<th>Company Name</th>
									<th>Contact Number</th>
									<th>Email</th>
									<th>Address</th>
									<th>Status</th>
									<th>Update</th>
									<th>Delete</th>
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
	<div class="modal-dialog">
		<form method="post" id="company_form">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> Add User role</h4>
				</div>
				<div class="modal-body">

					<div class="form-group">
						<label>Enter Company Name</label>
						<input type="text" name="company_name" id="company_name" class="form-control" required />
					</div>

					<div class="form-group">
						<label>Enter Contact Number</label>
						<input type="text" name="contact_number" id="contact_number" class="form-control" required />
					</div>

					<div class="form-group">
						<label>Enter Email</label>
						<input type="email" name="email" id="email" class="form-control" required />
					</div>

					<div class="form-group">
						<label>Enter Address</label>
						<textarea name="address" id="address" class="form-control" required></textarea>
						</div>

    				<div class="modal-footer">
    					<input type="hidden" name="company_id" id="company_id"/>
    					<input type="hidden" name="btn_action" id="btn_action"/>
    					<input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
	
	<?php include('./fragments/script.html'); ?>

<script>


	$(document).ready(function () {
		
		$('#add_button').click(function () {
			$('#company_form')[0].reset();
			$('.modal-title').html("<i class='fa fa-plus'></i> Add Company");
			$('#action').val('Add');
			$('#btn_action').val('Add');
		});

		$(document).on('submit', '#company_form', function (event) {
			event.preventDefault();
			$('#action').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			$.ajax({
				url: "company_action.php",
				method: "POST",
				data: form_data,
				success: function (data) {
					$('#company_form')[0].reset();
					$('#companyModal').modal('hide');
					$('#alert_action').fadeIn().html('<div class="alert alert-success">' + data + '</div>');
					$('#action').attr('disabled', false);
					companydataTable.ajax.reload();
				}
			})
		});

		$(document).on('click', '.update', function () {
			var company_id = $(this).attr("id");
			var btn_action = 'fetch_single';
			$.ajax({
				url: "company_action.php",
				method: "POST",
				data: { company_id: company_id, btn_action: btn_action },
				dataType: "json",
				success: function (data) {
					$('#companyModal').modal('show');
					$('#company_name').val(data.company_name);
					$('#contact_number').val(data.contact_number);
					$('#email').val(data.email);
					$('#address').val(data.address);
					$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Company details");
					$('#company_id').val(company_id);
					$('#action').val('Edit');
					$('#btn_action').val("Edit");
				}
			})
		});

		var companydataTable = $('#company_data').DataTable({
			"processing": true,
			"serverSide": true,
			"order": [],
			"ajax": {
				url: "company_fetch.php",
				type: "POST",

			},
			"columnDefs": [
				{
					"targets": [6, 7],
					"orderable": false,
				},
			],
			"pageLength": 25
		});
		$(document).on('click', '.delete', function () {
			var company_id = $(this).attr('id');
			var status = $(this).data("status");
			var btn_action = 'delete';
			if (confirm("Are you sure you want to change status?")) {
				$.ajax({
					url: "company_action.php",
					method: "POST",
					data: { company_id: company_id, status: status, btn_action: btn_action },
					success: function (data) {
						$('#alert_action').fadeIn().html('<div class="alert alert-info">' + data + '</div>');
						companydataTable.ajax.reload();
					}
				})
			}
			else {
				return false;
			}
		});
	});
</script>

<?php
include('./fragments/footer.html');
?>


				