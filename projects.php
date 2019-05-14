<?php
//category.php
include('./fragments/header.php');
include('database_config_dashboard.php');
if(!isset($_SESSION['type']))
{
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
						<h3 class="panel-title">Projects Details</h3>
					</div>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
					<div class="row" align="right">
						<button type="button" name="add" id="add_button" data-toggle="modal" data-target="#projectModal"
							class="btn btn-success btn-xs">Add</button>
					</div>
				</div>
				<div style="clear:both"></div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-12 table-responsive">
						<table id="project_data" class="table table-bordered table-striped">
							<thead>
							<tr>
									<th>ID</th>
									<th>Project Name</th>
									<th>Start date</th>
									<th>Description</th>
									<th>Remarks</th>
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

<div id="projectModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="project_form">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> Add project detalis</h4>
				</div>
				<div class="modal-body">

					<div class="form-group">
						<label>Project Name</label>
						<input type="text" name="project_name" id="project_name" class="form-control" required />
					</div>

					<div class="form-group">
						<label>Start Date</label>
						<input type="date" name="start_date" id="start_date" class="form-control" required />
					</div>

					

					<div class="form-group">
						<label>Description</label>
						<textarea name="description" id="description" class="form-control" required></textarea>
					</div>

					<div class="form-group">
						<label>Remarks</label>
						<textarea name="remarks" id="remarks" class="form-control" required></textarea>
					</div>

    				<div class="modal-footer">
    					<input type="hidden" name="project_id" id="project_id"/>
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
			$('#project_form')[0].reset();
			$('.modal-title').html("<i class='fa fa-plus'></i> Add project details");
			$('#action').val('Add');
			$('#btn_action').val('Add');
		});

		$(document).on('submit', '#project_form', function (event) {
			event.preventDefault();
			$('#action').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			console.log(form_data);
			$.ajax({
				url: "projects_action.php",
				method: "POST",
				data: form_data,
				success: function (data) {
					$('#project_form')[0].reset();
					$('#projectModal').modal('hide');
					$('#alert_action').fadeIn().html('<div class="alert alert-success">' + data + '</div>');
					$('#action').attr('disabled', false);
					projectsdataTable.ajax.reload();
					setTimeout(function () {
							window.location.reload();
						}, 1500);
				}
			})
		});

		$(document).on('click', '.update', function () {
			var project_id = $(this).attr("id");
			var btn_action = 'fetch_single';
			$.ajax({
				url: "projects_action.php",
				method: "POST",
				data: { project_id: project_id, btn_action: btn_action },
				dataType: "json",
				success: function (data) {
					$('#projectModal').modal('show');
					$('#project_name').val(data.project_name);
					$('#start_date').val(data.start_date);
					$('#description').val(data.description);
					$('#remarks').val(data.remarks);
					$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit profile details");
					$('#project_id').val(project_id);
					$('#action').val('Edit');
					$('#btn_action').val("Edit");
					setTimeout(function () {
							window.location.reload();
						}, 1500);
					
				}
			})
		});

		var projectsdataTable = $('#project_data').DataTable({
			"processing": true,
			"serverSide": true,
			"order": [],
			"ajax": {
				url: "projects_fetch.php",
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
			var project_id = $(this).attr('id');
			var status = $(this).data("status");
			var btn_action = 'delete';
			if (confirm("Are you sure you want to change status?")) {
				$.ajax({
					url: "projects_action.php",
					method: "POST",
					data: { project_id: project_id, status: status, btn_action: btn_action },
					success: function (data) {
						$('#alert_action').fadeIn().html('<div class="alert alert-info">' + data + '</div>');
						projectsdataTable.ajax.reload();
						setTimeout(function () {
							window.location.reload();
						}, 1500);
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


				