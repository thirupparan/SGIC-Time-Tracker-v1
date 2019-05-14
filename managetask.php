<?php
//category.php
include('./fragments/header.php');
require_once('database_config_dashboard.php');
if(!isset($_SESSION['type']))
{
	header("location:login.php");
}


?>

<!-- Content Section Starts here -->
<div id="content">
    <header>
        <h2 class="page_title">Manage Tasks </h2>
    </header>

    <!-- Button trigger modal -->
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal">
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


                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>HR System</td>
                        <td>profile UI</td>
                        <td>30 mins</td>
                        <td>
                            <button class="btn btn-primary">View</button>
                            <button class="btn btn-warning">Edit</button>
                            <button class="btn btn-danger">Delete</button>
                        </td>
                    </tr>

                    <tr>
                        <td>HR System</td>
                        <td>login</td>
                        <td>1 hr</td>
                        <td>
                            <button class="btn btn-primary">View</button>
                            <button class="btn btn-warning">Edit</button>
                            <button class="btn btn-danger">Delete</button>
                        </td>
                    </tr>

                    <tr>
                        <td>Other</td>
                        <td>Office works</td>
                        <td>2 hr</td>
                        <td>
                            <button class="btn btn-primary">View</button>
                            <button class="btn btn-warning">Edit</button>
                            <button class="btn btn-danger">Delete</button>
                        </td>
                    </tr>


                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Total time : 8hr </td>
                    </tr>
                </tfoot>

            </table>

        </div>

    </div>



</div>
<!-- Content Section Ends here -->


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
                                <label class="sr-only">Estimated Time</label>
                                <label>Estimated Time</label>
                                <select data-placeholder="Estimated time" class="form-control">
                                    <option></option>
                                    <option>30 min</option>
                                    <option>1 hr</option>
                                    <option>1 hr 30 min</option>
                                    <option>2 hr</option>
                                    <option>2 hr 30 min</option>
                                    <option>3 hr</option>
                                    <option>3 hr 30 min</option>
                                    <option>4 hr</option>
                                    <option>4 hr 30 min</option>
                                    <option>5 hr</option>
                                    <option>5 hr 30 min</option>
                                    <option>6 hr</option>
                                    <option>6 hr 30 min</option>
                                    <option>7 hr</option>
                                    <option>7 hr 30 min</option>
                                    <option>8 hr</option>

                                </select>
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
<?php
include('./fragments/footer.html');
?>