<?php
//profile.php
include('./fragments/header.php');
include('database_config_dashboard.php');
include('includes/query_execute.inc.php');
include('function.php');

$useractiveSql="SELECT `user_status` FROM `user` WHERE `user_id`={$_GET["userid"]}";
$res=getResult($connect,$useractiveSql);

$statusActive='Active';
if($res['user_status']!='Active'){
	$statusActive='Inactive';
	
	
}
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
						<select name="work_role" id="work_role" class="form-control" required />
							<option>Associate Software Engineer</option>
							<option>Associate Q-A Engineer</option>
							<option> Software Engineer</option>
							<option> Q-A Engineer</option>
							<option> Tech Lead</option>
							<option> Architect</option>
						<select>
					</div>

					<div class="form-group">
						<label for="recruited_date">Recruited Date</label>
						<input type="date" name="recruited_date" id="recruited_date" class="form-control" required />
					</div>

					<div class="form-group">
						<label>Contract Period (In months)</label>
						<input type="number" name="Contract_Period" id="Contract_Period" class="form-control" required min="0"/>
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

<?php

if($statusActive!='Active'){
	echo "<div class='alert alert-danger' role='alert'>The Account is in Deactive , So you can only view the Details </div>";
}
?>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-8 col-xs-6">
						<h3 class="panel-title">Company Assignment</h3>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-4 col-xs-6 pull-right">
					<?php
					if($statusActive=='Active'){
					$workStatusQuery="SELECT count(`working_status`) as workcount FROM `user_company` WHERE `user_id`='{$_GET["userid"]}' AND `working_status`='Working'";

					$res=getResult($connect,$workStatusQuery);
				
					if($res['workcount']>0){
						echo "<span class='alert-danger '>Can not Assign Company Since the User is Alredy Working</span>";
						echo "<button type='button' name='add' id='add_button' class='btn btn-primary btn-xs pull-right' disabled>Add</button>";
					}else{
						echo "<button type='button' name='add' id='add_button' class='btn btn-primary btn-xs pull-right'>Add</button>";
					}
				}else{
					
					echo "<button type='button' name='add' id='add_button' class='btn btn-primary btn-xs pull-right' disabled>Add</button>";
				}
					?>
						
					</div>
				</div>

				<div class="clear:both"></div>
			</div>
			<div class="panel-body">
				<div id="alert_company_action"></div>
				<div id="result"></div>
			</div>
		</div>

	</div>
</div>



<!-- Modal -->
<div class="modal fade" id="terminationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
  <form id="company_termination">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Termination</h4>
      </div>
      <div class="modal-body">
	 
		<div class="form-group">
						<label for="termination_date">Date of termination</label>
						<input type="date" name="date_of_termination" id="date_of_termination" class="form-control" required />
					</div>
					<input type="hidden" name="recruitment_id" id="recruitment_id"/>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger" >Terminate</button>
	  </div>
	  </form>
    </div>
  </div>
</div>


<?php include('./fragments/script.html')?>



<script>

function fetchCompany(userid) {
			var btn_action = 'fetch_single';
			var action = "select";
			$.ajax({
				url: "recruitment_select.php?status=<?php echo $statusActive;?>",
				method: "POST",
				data: { action: action, user_id: userid },
				success: function (data) {
					$('#result').html(data);
				}
			});
		}
 
	$(document).ready(function () {

		fetchCompany("<?php echo $_GET['userid'];?>") 

		$(document).on('submit', '#company_form', function (event) {
			event.preventDefault();
			$('#btn_action_company').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			console.log(form_data);
			$.ajax({
				url: "recruitment_action.php",
				method: "POST",
				data: form_data + "&action_company=Add",
				success: function (data) {
					$('#company_form')[0].reset();
					$('#companyModal').modal('hide');
					$('#alert_company_action').html(data);
					$('#btn_action_company').attr('disabled', false);
					fetchCompany("<?php echo $_GET['userid'];?>") ;
						$('#alert_company_action').html(data);
						setTimeout(() => {
						window.location.reload();
						}, 1500);
					
					
					
					
				}
			});
		});


		$(document).on('submit', '#company_termination', function (event) {
			event.preventDefault();
			//$('#btn_action_company').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			console.log(form_data);
			$.ajax({
				url: "recruitment_action.php",
				method: "POST",
				data: form_data + "&action_company=TERMINATE",
				success: function (data) {
					$('#company_form')[0].reset();
					$('#companyModal').modal('hide');
					$('#alert_company_action').html(data);
					$('#btn_action_company').attr('disabled', false);
					fetchCompany("<?php echo $_GET['userid'];?>") ;
						$('#alert_company_action').html(data);
						setTimeout(() => {
						window.location.reload();
						}, 1500);
					
					
					
					
				}
			});
		});

		$('#add_button').on('click', function () {
			$('#companyModal').modal('show');

		});

		$(document).on('click', '.terminate', function () {
			var id = $(this).attr("id");
			$('#recruitment_id').val(id);
			$('#terminationModal').modal('show');
			
		});

		$(document).on('click', '.delete_company', function () {
			var id = $(this).attr("id");
			
			if (confirm("Are you sure you want to remove this data?")) {
				var action = "Delete";
				$.ajax({
					url: "recruitment_action.php",
					method: "POST",
					data: { user_company_id: id, action_company: action },
					success: function (data) {
						//alert-danger
						fetchCompany("<?php echo $_GET['userid'];?>") ;
						$('#alert_company_action').html(data);
						setTimeout(() => {
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