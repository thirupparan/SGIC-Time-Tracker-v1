<?php
include('./fragments/header.php');
if(!isset($_SESSION['type']))
{
	header("location:login.php");
}

$timein='';
$timeout='';
$connect = mysqli_connect("localhost", "root", "manager", "sgic-user");  
$sqltime="SELECT `time_in`,`time_out` FROM `attendance` WHERE `user_id`=".$_SESSION['user_id']." AND `date`='".$_GET['date']."'";
$result = mysqli_query($connect, $sqltime);
if(mysqli_num_rows($result) > 0)  
{  
     while($row = mysqli_fetch_array($result))  {
$timein=$row['time_in'] !=null ? $row['time_in']:'';
$timeout=$row['time_out'] !=null ? $row['time_out']:'';
     }
}
 ?>

 <!-- Content Section Starts here -->
                <div id="content">

                    <header>
                        <h2 class="page_title">Attendance </h2>
                    </header>

                    
                        <div class="row">

                            <div class="col-md-4">
                            <form id="formTimeIn">
                                <div class="form-group">
                                    <label class="sr-only">Time In</label>
                                    <label>Time In</label>
                                    <input type="time" class="form-control" id="timeIn" value="<?php echo $timein; ?>" name="timeIn" placeholder="hh:mm:ss">
                                    <input type="hidden" name="action" value="time_in"/>
                                    <input type="submit" id="title" value="I'm in">
                                </div>
                                </form>
                            </div>

                   

                            <div class="col-md-4">
                            <form id="formTimeOut">
                                    <div class="form-group">
                                        <label class="sr-only">Time Out</label>
                                        <label>Time out</label>
                                        <input type="time" class="form-control" id="timeOut" value="<?php echo $timeout; ?>" name="timeOut" placeholder="hh:mm:ss">
                                        <input type="hidden" name="action" value="time_out"/>
                                        <input type="submit" id="title1" value="I'm out">
                                    </div>
                                    </form>
                                </div>

                                <div class="col-md-4 text-center">
                                   <h3>Working Hours</h3>
                                   <h4>7hrs 56 min</h4>
                                   </div>

                        </div>

                    
                </div>
				
				
				
				
           <!-- Content Section Starts here -->
                <div id="content">
               <form>
                    <input type="hidden" id="hiddendate" value="<?php echo $_GET['date'];?>" />
               </form>
               <div id="live_data"></div>
          </div>
		  
 

<?php include('./fragments/script.html')?>

<script>
     $(document).ready(function () {
          var hdate = $('#hiddendate').val();


$('#formTimeIn').submit(function(event){
     event.preventDefault();
     var timein=$('#timeIn').val();
     var action=$(this).find('input[type="hidden"]')[0].value;
     
     $.ajax({
                    url: "time-insert.php",
                    method: "POST",
                    data:  {action:action,timein:timein,date:hdate},
                    success: function (data) {
                        alert(data);
                    }
               });

});

$('#formTimeOut').submit(function(event){
     event.preventDefault();
     var timeout=$('#timeOut').val();
     var action=$(this).find('input[type="hidden"]')[0].value;
    
     $.ajax({
                    url: "time-insert.php",
                    method: "POST",
                    data:  {action:action,timeout:timeout,date:hdate},
                    success: function (data) {
                        alert(data);
                    }
               });

});

          function fetch_data() {
               $.ajax({
                    url: "select-task.php?date=" + hdate,
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
               //alert("hello");
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

               // console.log(project);
               // console.log(title);
               // console.log(duration);
               // console.log(description);
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