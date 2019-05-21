<?php
include './fragments/header.php';
include 'database_config_dashboard.php';
if (!isset($_SESSION['type'])) {
    header("location:login.php");
}
?>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
                <div class="panel-heading">
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                        <div class="row">
                            <h3 class="panel-title">User Role</h3>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                        <div class="row" align="right">
                             <button type="button" name="add" id="add_button" data-toggle="modal" data-target="#userroleModal" class="btn btn-success btn-xs">Add</button>
                        </div>
                    </div>
                    <div style="clear:both"></div>
                </div>
                <div class="panel-body">
                    <div class="row">
                    	<div class="col-sm-12 table-responsive">
						<span id="alert_action"></span>
                    		<table id="role_data" class="table table-bordered table-striped">
                    			<thead><tr>
									<th>ID</th>
									<th>User role</th>
									<th>Edit</th>
									<th>Active/Inactive</th>
								</tr></thead>
                    		</table>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="userroleModal" class="modal fade">
    	<div class="modal-dialog">
		
    		<form method="post" id="userrole_form"  autocomplete="off">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add User role</h4>
    				</div>
    				<div class="modal-body">

					<span id="alert_msg_modal"></span>
    					<label>Enter User role</label>
						<input type="text" name="role_name" id="role_name" class="form-control" required />
    				</div>
    				<div class="modal-footer">
    					<input type="hidden" name="role_id" id="role_id"/>
    					<input type="hidden" name="btn_action" id="btn_action"/>
    					<input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
	<?php
include './fragments/script.html';
?>
<script>


$(document).ready(function(){

	jQuery.validator.addMethod("noSpace", function(value, element) { 
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
	$('#add_button').click(function(){
		$('#userrole_form')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add Role");
		$('#action').val('Add');
		$('#btn_action').val('Add');
	});

	$('#userrole_form').validate({
		rules:{
			role_name:{
				required:true,
				noSpace:true,
				regex: "^[a-zA-Z'.\\s]{1,40}$" 
			}
		},
		messages:{
			role_name:{
				required:"please Enter Role name",
				noSpace:"Spaces Not Allowed",
				regex:"Only character allowed"
			}
		}
	});

	$(document).on('submit','#userrole_form', function(event){
		event.preventDefault();
		$('#action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		console.log(form_data);
		$.ajax({
			url:"userrole_action.php",
			method:"POST",
			data:form_data,
			dataType:"json",
			success:function(data)
			{
				//console.log(data);
				if(data.type=='success'){
					$('#userrole_form')[0].reset();
					$('#userroleModal').modal('hide');
			 		$('#alert_action').fadeIn().html('<div class="alert alert-success">'+data.msg+'</div>');
					 $('#action').attr('disabled', false);
					roledataTable.ajax.reload();
					setTimeout(() => {
						$('#alert_action').html('');
					}, 1500);
				}else if(data.type=='err'){
					$('#alert_msg_modal').fadeIn().html('<div class="alert alert-danger">'+data.msg+'</div>');
					$('#action').attr('disabled', false);
				}
			}
		})
	});

	$(document).on('click', '.update', function(){
		var role_id = $(this).attr("id");
		var btn_action = 'fetch_single';
		$.ajax({
			url:"userrole_action.php",
			method:"POST",
			data:{role_id:role_id, btn_action:btn_action},
			dataType:"json",
			success:function(data)
			{
				$('#userroleModal').modal('show');
				$('#role_name').val(data.role_name);
				$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Category");
				$('#role_id').val(role_id);
				$('#action').val('Update');
				$('#btn_action').val("Edit");
			}
		})
	});

	var roledataTable = $('#role_data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"userrole_fetch.php",
			type:"POST"
		},
		"columnDefs":[
			{
				"targets":[2, 3],
				"orderable":false,
			},
		]
		,
		"fnDrawCallback": function() {
            jQuery('#role_data .delete').bootstrapToggle({
				on: 'Active',
      			off: 'Inactive',
				  size:'mini'
			});
		},
		"pageLength": 25
	});
	$(document).on('change', '.delete', function(){
		var role_id = $(this).attr('id');
		var status = $(this).data("status");
		var btn_action = 'delete';
		if(confirm("Are you sure you want to change status?"))
		{
			$.ajax({
				url:"userrole_action.php",
				method:"POST",
				data:{role_id:role_id, status:status, btn_action:btn_action},
				dataType:"json",
				success:function(data)
				{
					if(data.type=='success'){
					$('#alert_action').fadeIn().html('<div class="alert alert-info">'+data.msg+'</div>');
					roledataTable.ajax.reload();
					setTimeout(() => {
						$('#alert_action').html('');
					}, 1500);
					}
				}
			})
		}
		else
		{
			roledataTable.ajax.reload();
			return false;
		}
	});


});
</script>

<?php
include './fragments/footer.html';
?>
<?php 

