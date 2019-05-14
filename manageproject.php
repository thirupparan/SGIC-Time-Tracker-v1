<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/default.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>

<body>
    <div class="container-fluid display-table">
        <div class="row display-table-row">
            <!-- side menu -->
            <?php include './fragments/side-navigation.html';?>

            <!-- main content area -->
            <div class="col-md-10 col-sm-11 display-table-cell valign-top">
                <?php include './fragments/top-bar.html';?>

                <!-- Content Section Starts here -->
                <div id="content">
                    <header>
                        <h2 class="page_title">Manage Project </h2>
                    </header>

                    <!-- Button trigger modal -->
                    <div class="row">
                        <div class="col-md-12">
                    <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal">
                        Add New project
                    </button>
                    </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Project Name</th>
                                    <th>Start Date</th>
                                    <th>Status</th>


                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>python</td>
                                    <td>2019- April-1</td>
                                    <td>
                                        <input type="radio" value="inprogress" /> In progress
                                        <input type="radio" value="inprogress" /> Finished
                                    </td>
                                </tr>

                                <tr>
                                    <td>python</td>
                                    <td>2019- April-1</td>
                                    <td>
                                        <input type="radio" value="inprogress" /> In progress
                                        <input type="radio" value="inprogress" /> Finished
                                    </td>
                                </tr>
    </tbody>

                            
                        </table>

                    </div>

                </div>



            </div>
            <!-- Content Section Ends here -->

            <?php include './fragments/footer.html';?>
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
                    <h4 class="modal-title">Add Project Details</h4>
                </div>
                <div class="modal-body">

                    <div class="content-inner">
                        <div class="form-wrapper">
                            <form>

                                <div class="form-group">
                                    <label class="sr-only">Project Name</label>
                                    <label>Project Name</label>
                                    <input type="text" class="form-control" id="title" placeholder="Employee ID">
                                </div>

                                <div class="form-group">
                                    <label class="sr-only">Start Date</label>
                                    <label>Start Date</label>
                                    <input type="text" class="form-control" id="title" placeholder="Employee Name">
                                </div>

                                <div class="form-group">
                                    <label class="sr-only">Description</label>
                                    <label>Description</label>
                                    <input type="text" class="form-control" id="title" placeholder="Employee ID">
                                </div>

                                <div class="form-group">
                                    <label class="sr-only">Remarks</label>
                                    <label>Remarks</label>
                                    <input type="text" class="form-control" id="title" placeholder="Employee Name">
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