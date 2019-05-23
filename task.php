<?php
include('./fragments/header.php');
if(!isset($_SESSION['type']))
{
	header("location:login.php");
}
include('database_mysqli_assign_company.php'); 
$timein='';
$timeout='';

$sqltime="SELECT `time_in`,`time_out` FROM `attendance` WHERE `user_id`=".$_SESSION['user_id']." AND `date`='".$_GET['date']."'";
$result = mysqli_query($connect, $sqltime);
if(mysqli_num_rows($result) > 0)  
{  
     while($row = mysqli_fetch_array($result))  {
$timein=$row['time_in'] !=null ? $row['time_in']:'';
$timeout=$row['time_out'] !=null ? $row['time_out']:'';
     }
}

$currentdate=strtotime(date("Y-m-d"));
$gotDate= strtotime($_GET['date']);

$disabledstatus="enabled";
if($currentdate>$gotDate){
     $disabledstatus="disabled";
}

echo $disabledstatus;
 ?>

 <!-- Content Section Starts here -->
 <link rel="stylesheet" href="css/bootstrap-clockpicker.min.css">
                <div id="content">

                    <header>
                        <h2 class="page_title">Attendance </h2>
                    </header>

                    
                        <div class="row">

                            <div class="col-md-4">
                            <form id="formTimeIn">
                                <div class="form-group text-center">
                                    <label class="sr-only">Time In</label>
                                    <label for=>Time In</label>

                                    <div class="input-group clockpicker">
                                        <input type="text" class="form-control" id="timein" value="<?php echo $timein; ?>" name="timein" readonly>
                                        <span class="input-group-addon">
                                             <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                   </div>
                                  
                                    <input type="hidden" name="action" value="time_in"/>
                                    <br/>
                                    <input type="submit" id="btntimeIn" class="btn btn-primary"  value="I'm in">
                                </div>
                                </form>
                            </div>

                            <div class="col-md-4 text-center">
                                   <h4><?php echo $_GET['date'];?></h4>
                                   <h3>Working Hours</h3>
                                   <h4>-hrs --mins</h4>
                                   </div>
                   

                            <div class="col-md-4">
                            <form id="formTimeOut">
                                    <div class="form-group text-center">
                                        <label class="sr-only">Time Out</label>
                                        <label>Time out</label>
                                        <div class="input-group clockpicker">
                                        <input type="text" class="form-control" id="timeout" value="<?php echo $timeout; ?>" name="timeout" readonly>
                                        <span class="input-group-addon">
                                             <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                   </div>
                                      
                                        <input type="hidden" name="action" value="time_out"/>
                                        <br/>
                                        <input type="submit" id="btntimeOut" class="btn btn-primary" value="I'm out">
                                    </div>
                                    </form>
                                </div>

                               

                        </div>

                    
                </div>
				
				
				
				
           <!-- Content Section Starts here -->
                <div id="content">
               <form>
                    <input type="hidden" id="hiddendate" value="<?php echo $_GET['date'];?>" />
               </form>
               <div id="live_data" ></div>
          </div>
		  
 

<?php include('./fragments/script.html')?>
<script src="js/bootstrap-clockpicker.min.js"></script>
<script type="text/javascript">
$('.clockpicker').clockpicker({
    placement: 'bottom',
    align: 'left',
    donetext: 'Done'
});
</script>

<script>
     $(document).ready(function () {
          if(isNaN($('#timeIn').val())){
               
               $("#btntimeOut").attr("disabled", false);
          }else{
               
               $("#btntimeOut").attr("disabled", true);
          }
          var hdate = $('#hiddendate').val();


$('#formTimeIn').submit(function(event){
     event.preventDefault();
    var formdata= $(this).serialize();
     var serializedata=formdata+ "&date="+hdate;
    
     $.ajax({
                    url: "time-insert.php",
                    method: "POST",
                    data:  serializedata ,
                    success: function (data) {
                        alert(data);
                    }
               });

});

$('#formTimeOut').submit(function(event){
     event.preventDefault();
     var serializedata=formdata+ "&date="+hdate;
     
     
    
     $.ajax({
                    url: "time-insert.php",
                    method: "POST",
                    data:  serializedata ,
                    success: function (data) {
                        alert(data);
                    }
               });

});

          function fetch_data() {
               $.ajax({
                    url: "select-task.php?uistate=<?php echo $disabledstatus;?>&date="+hdate,
                    method: "POST",
                    data: { date: hdate },
                    success: function (data) {
                         $('#live_data').html(data);
                    }
               });
          }
          fetch_data();


          $(document).on('click', '#btn_add', function () {
               var project=$('#project').val();
               var taskname = $('#taskname').text();
               var duration = $('#duration').val();
               var description = $('#description').text();
               var totaltime=$('#label-time').text();
               
               if (project == '') {
                    alert("please choose project");
                    return false;
               }
               if (taskname == '') {
                    alert("Enter Task Name");
                    return false;
               }
               if (duration == '') {
                    alert("Enter Duration");
                    return false;
               } if (description == '') {
                    alert("Enter Description");
                    return false;
               }

               if(Number(totaltime)+Number(duration)>480){
                    alert("Cant' allow , exceed 8 hrs");
                    return false;
               }
             
               $.ajax({
                    url: "insert-task.php",
                    method: "POST",
                    data: { project:project,taskname: taskname, duration: duration, description: description, date: hdate },
                    dataType: "text",
                    success: function (data) {
                        
                         alert(data);
                         fetch_data();
                    }
               })

          });

          function edit_data(id, text, column_name) {
               $.ajax({
                    url: "edit-task.php",
                    method: "POST",
                    data: { id: id, text: text, column_name: column_name },
                    dataType: "text",
                    success: function (data) {
                         alert(data);
                         fetch_data();
                    }
               });
          }
          $(document).on('change', '.projects', function () {
               var id = $(this).data("id0");
               var project_id = $(this).val();
              edit_data(id, project_id, "project_id");
              //alert("id :"+id +"duration:"+duration);
          });
          $(document).on('blur', '.taskname', function () {
               var id = $(this).data("id1");
               var taskname = $(this).text();
               edit_data(id, taskname, "title");
          });
          $(document).on('change', '.duration', function () {
               var id = $(this).data("id2");
               var duration = $(this).val();
               edit_data(id, duration, "duration");
              //alert("id :"+id +"duration:"+duration);
          });
          $(document).on('blur', '.description', function () {
               var id = $(this).data("id3");
               var description = $(this).text();
               edit_data(id, description, "description");
          });

          $(document).on('click', '.btn_delete', function () {
               var id = $(this).data("id3");
               if (confirm("Are you sure you want to delete this?")) {
                    $.ajax({
                         url: "delete-task.php",
                         method: "POST",
                         data: { id: id },
                         dataType: "text",
                         success: function (data) {
                              alert(data);
                              fetch_data();
                         }
                    });
               }
          });
     });  
</script>


<?php
include('./fragments/footer.html');
?>