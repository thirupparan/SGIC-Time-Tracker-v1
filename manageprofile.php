
<?php include('./fragments/header.php');?>
                    <header>
                        <h2 class="page_title">Manage Employees </h2>
                    </header>

                    <!-- Button trigger modal -->
                    <div class="row">
                        <div class="col-md-12">
                    <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal">
                        Add New Profile
                    </button>
                    </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Employee Name</th>
                                    <th>Company Deployed</th>
                                    <th>Position</th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>SGIC/2018/22</td>
                                    <td>Anusanth</td>
                                    <td>Brandix</td>
                                    <td>Software Engineer</td>
                                </tr>

                                <tr>
                                    <td>SGIC/2018/25</td>
                                    <td>Jananthan</td>
                                    <td>Dialog</td>
                                    <td>Software Engineer</td>
                                </tr>
    </tbody>

                            
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
                    <h4 class="modal-title">Add Employee Details</h4>
                </div>
                <div class="modal-body">

                    <div class="content-inner">
                        <div class="form-wrapper">
                            <form>
                            <div class="form-group">
                                    <label class="sr-only">Employee ID</label>
                                    <label>Employee ID</label>
                                    <input type="text" class="form-control" id="title" placeholder="Employee Name">
                                </div>

                                <div class="form-group">
                                    <label class="sr-only">Employee Name</label>
                                    <label>Employee Name</label>
                                    <input type="text" class="form-control" id="title" placeholder="Employee ID">
                                </div>

                               

                                <div class="form-group">
                                    <label class="sr-only">Company Deployed</label>
                                    <label>Company Deployed</label>
                                    <input type="text" class="form-control" id="title" placeholder="Employee ID">
                                </div>

                                <div class="form-group">
                                    <label class="sr-only">Position</label>
                                    <label>Position</label>
                                    <input type="text" class="form-control" id="title" placeholder="Employee ID">
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

    <?php include './fragments/footer.html';?>