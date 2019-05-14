
<?php 
include('./fragments/header.php');
require_once('database_config_dashboard.php');
if(!isset($_SESSION['type']))
{
	header("location:login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
</head>

<body>
    <div class="container-fluid display-table">
        <div class="row display-table-row">
            <!-- main content area -->
            <div class="col-md-10 col-sm-11 display-table-cell valign-top">
                <!-- Content Section Starts here -->
                <div id="content">
                    <header>
                        <h2 class="page_title">Attendance </h2>
                    </header>

                    <form>
                        <div class="row">

                            <div class="col-md-4">

                                <div class="form-group">
                                    <label class="sr-only">Time In</label>
                                    <label>Time In</label>
                                    <input type="text" class="form-control" id="title" placeholder="Time In">
                                    <input type="button" id="title" value="I'm in">
                                </div>
                            </div>

                            <div class="col-md-4">

                                    <div class="form-group">
                                        <label class="sr-only">Time Out</label>
                                        <label>Time out</label>
                                        <input type="text" class="form-control" id="title" placeholder="Time Out">
                                        <input type="button" id="title" value="I'm out">
                                    </div>
                                </div>

                                <div class="col-md-4 text-center">
<h3>Working Hours</h3>
<h4>7hrs 56 min</h4>
    </div>

                        </div>

                    </form>
                </div>

                <div id="content">
                    <header>
                        <h2 class="page_title">Manage Tasks </h2>
                    </header>

                    <!-- Button trigger modal -->
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary pull-right" data-toggle="modal"
                                data-target="#myModal">
                                Add New Task
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Project</th>
                                        <th>Task</th>
                                        <th>Estimated Time</th>
                                        <th>Status</th>
                                        <th>Work log</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>HR System</td>
                                        <td>profile UI</td>
                                        <td>30 mins</td>
                                        <td>Not Started</td>
                                        <td><button class="btn btn-sm btn-primary">log</button></td>
                                    </tr>

                                    <tr>
                                        <td>HR System</td>
                                        <td>login</td>
                                        <td>1 hr</td>
                                        <td>[ Started : 12.37 am ] [time elapsed : 25 min]
                                            <button>Pause</button><button>Complete</button></td>
                                        <td><button class="btn btn-sm btn-primary disabled">log</button></td>
                                    </tr>

                                    <tr>
                                        <td>Other</td>
                                        <td>Office works</td>
                                        <td>2 hr</td>
                                        <td>Not Started</td>
                                        <td><button class="btn btn-sm btn-primary">log</button></td>
                                    </tr>
                                    <tr>
                                        <td>Other</td>
                                        <td>Office works</td>
                                        <td>2 hr</td>
                                        <td>Completed : Time spent : 35min</td>
                                        <td><button class="btn btn-sm btn-primary disabled">log</button></td>
                                    </tr>


                                </tbody>

                                <tfoot>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Total hours spent : 7 hr</td>
                                </tfoot>

                            </table>

                        </div>

                    </div>



                </div>
                <!-- Content Section Ends here -->
            </div>
        </div>
    </div>

    <!-- Modal window goes here -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add New Task</h4>
                </div>
                <div class="modal-body">

                    <div class="content-inner">
                        <div class="form-wrapper">
                            <form>

                                <div class="form-group">
                                    <label class="sr-only">Project Name</label>
                                    <label>Project Name</label>
                                    <select data-placeholder="Estimated time" class="form-control">
                                        <option>HR system</option>
                                        <option>Defect Tracker</option>
                                        <option>Task management</option>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="sr-only">Task Name</label>
                                    <label>Task Name</label>
                                    <input type="text" class="form-control" id="title" placeholder="Task Name">
                                </div>

                                <div class="form-group">
                                    <label class="sr-only">From</label>
                                    <label>From</label>
                                    <input type="text" class="form-control" id="title" placeholder="Task Name">
                                </div>

                                <div class="form-group">
                                    <label class="sr-only">to</label>
                                    <label>to</label>
                                    <input type="text" class="form-control" id="title" placeholder="Task Name">
                                </div>

                                <div class="form-group">
                                    <label class="sr-only">Description</label>
                                    <label>Description</label>
                                    <textarea class="form-control" placeholder="Write a Description about task"
                                        name="article"></textarea>
                                </div>



                            </form>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/default.js"></script>
</body>

</html>
<?php
include('./fragments/footer.html');
?>