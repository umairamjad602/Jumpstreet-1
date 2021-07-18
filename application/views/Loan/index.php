

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage
            <small>Loan</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Loan</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12 col-xs-12">

                <div id="messages"></div>

                <?php if(in_array('createLoan', $user_permission)): ?>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add Loan</button>
                    <br /> <br />
                <?php endif; ?>


                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Manage Loan</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="manageTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Phone No</th>
                                <th>CNIC No</th>
                                <th>Given Date</th>
                                <th>Receiving Date</th>
                                <th>Amount</th>
                                <?php if(in_array('updateLoan', $user_permission) || in_array('deleteLoan', $user_permission)): ?>
                                    <th>Action</th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- col-md-12 -->
        </div>
        <!-- /.row -->


    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php if(in_array('createLoan', $user_permission)): ?>
    <!-- create brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="addModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Loan</h4>
                </div>

                <form role="form" action="<?= base_url('loan/create') ?>" method="post" id="createForm">

                    <div class="modal-body">

                        <div class="form-group">
                            <label for="brand_name">Name</label>
                            <input type="text"  required name="geter_name"  class="form-control" id="geter_name" placeholder="Enter Name" >
                        </div>

                        <div class="form-group">
                            <label for="brand_name">Phone No</label>
                            <input type="number"  required name="phoneno"  class="form-control" id="phoneno" placeholder="Enter Phone No" autocomplete="off" >
                        </div>

                        <div class="form-group">
                            <label for="brand_name">CNIC No</label>
                            <input type="number" minlength="14" maxlength="14" required name="cnicno"  class="form-control" id="cnicno" placeholder="Enter CNIC No" autocomplete="off" >
                        </div>

                        <div class="form-group">
                            <label for="active">Given Date</label>
                            <input type="date"  required name="given_date"  class="form-control" id="given_date" >
                        </div>

                        <div class="form-group">
                            <label for="brand_name">Receiving Date</label>
                            <input type="date" min="2020-02-25" required name="receiving_date" onclick="checkDate()" class="form-control" id="receiving_date" >
                        </div>

                        <div class="form-group">
                            <label for="brand_name">Amount</label>
                            <input type="number" min="1" oninput="this.value = Math.abs(this.value)" required name="amount"  class="form-control" id="amount" placeholder="Enter Amount" >
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>

                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php endif; ?>

<?php if(in_array('updateLoan', $user_permission)): ?>
    <!-- edit brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="editModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Loan</h4>
                </div>

                <form role="form" action="<?php echo base_url('loan/update') ?>" method="post" id="updateForm">

                    <div class="modal-body">
                        <div id="messages"></div>

                        <div class="form-group">
                            <label for="brand_name">Name</label>
                            <input type="text"  required name="edit_geter_name"  class="form-control" id="edit_geter_name" placeholder="Enter Name" autocomplete="off" >
                        </div>

                        <div class="form-group">
                            <label for="brand_name">Phone No</label>
                            <input type="number" required name="edit_phoneno"  class="form-control" id="edit_phoneno" placeholder="Enter Phone No" autocomplete="off"  value="">
                        </div>

                        <div class="form-group">
                            <label for="brand_name">CNIC No</label>
                            <input type="number" maxlength="14" minlength="14" required name="edit_cnicno"  class="form-control" id="edit_cnicno" placeholder="Enter CNIC No" autocomplete="off" >
                        </div>

                        <div class="form-group">
                            <label for="active">Given Date</label>
                            <input type="date"  required name="edit_given_date"  class="form-control" id="edit_given_date"  autocomplete="off" >
                        </div>

                        <div class="form-group">
                            <label for="brand_name">Receiving Date</label>
                            <input type="date" required name="edit_receiving_date"  class="form-control" onclick="checkEditDate()" id="edit_receiving_date"  autocomplete="off" >
                        </div>

                        <div class="form-group">
                            <label for="brand_name">Amount</label>
                            <input type="number" min="1" oninput="this.value = Math.abs(this.value)" required name="edit_amount"  class="form-control" id="edit_amount" placeholder="Enter Amount" autocomplete="off" >
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>

                </form>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php endif; ?>

<?php if(in_array('deleteLoan', $user_permission)): ?>
    <!-- remove brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Remove Loan Item</h4>
                </div>

                <form role="form" action="<?php echo base_url('loan/remove') ?>" method="post" id="removeForm">
                    <div class="modal-body">
                        <p>Do you really want to remove?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php endif; ?>

<script type="text/javascript">

    function checkDate() {
        var date = document.getElementById("given_date").value
        document.getElementById("receiving_date").min = date
    }
    function checkEditDate() {
        var date = document.getElementById("edit_given_date").value
        document.getElementById("edit_receiving_date").min = date
    }

    var manageTable;
    var base_url = "<?php echo base_url(); ?>";



    $(document).ready(function() {
        $('#loanMainNav').addClass('active');
        // initialize the datatable
        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + 'loan/fetchLoanData',
            'order': []
        });


        // submit the create from
        $("#createForm").unbind('submit').on('submit', function() {
            var form = $(this);

            // remove the text-danger
            $(".text-danger").remove();

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: form.serialize(), // /converting the form data into array and sending it to server
                dataType: 'json',

                success:function(response) {

                    manageTable.ajax.reload(null, false);

                    if(response.success === true) {
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                            '</div>');


                        // hide the modal
                        $("#addModal").modal('hide');

                        // reset the form
                        $("#createForm")[0].reset();
                        $("#createForm .form-group").removeClass('has-error').removeClass('has-success');

                    } else {

                        if(response.messages instanceof Object) {
                            $.each(response.messages, function(index, value) {
                                var id = $("#"+index);

                                id.closest('.form-group')
                                    .removeClass('has-error')
                                    .removeClass('has-success')
                                    .addClass(value.length > 0 ? 'has-error' : 'has-success');

                                id.after(value);

                            });
                        } else {
                            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
                                '</div>');
                        }
                    }
                }
            });

            return false;
        });

    });

    // edit function
    function editFunc(id)
    {
        $.ajax({
            url: base_url + 'loan/fetchLoanDataById/'+id,
            type: 'get',
            dataType: 'json',
            success:function(response) {

                $("#edit_geter_name").val(response.geter_name);
                $("#edit_phoneno").val(response.phoneno);
                $("#edit_cnicno").val(response.cnicno);
                $("#edit_given_date").val(response.given_date);
                $("#edit_receiving_date").val(response.receiving_date);
                $("#edit_amount").val(response.amount);


                // submit the edit from
                $("#updateForm").unbind('submit').bind('submit', function() {
                    var form = $(this);

                    // remove the text-danger
                    $(".text-danger").remove();

                    $.ajax({
                        url: form.attr('action') + '/' + id,
                        type: form.attr('method'),
                        data: form.serialize(), // /converting the form data into array and sending it to server
                        dataType: 'json',
                        success:function(response) {

                            manageTable.ajax.reload(null, false);

                            if(response.success === true) {

                                $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                                    '</div>');


                                // hide the modal
                                $("#editModal").modal('hide');
                                // reset the form
                                $("#updateForm .form-group").removeClass('has-error').removeClass('has-success');

                            } else {


                                if(response.messages instanceof Object) {
                                    $.each(response.messages, function(index, value) {
                                        var id = $("#"+index);

                                        id.closest('.form-group')
                                            .removeClass('has-error')
                                            .removeClass('has-success')
                                            .addClass(value.length > 0 ? 'has-error' : 'has-success');

                                        id.after(value);

                                    });
                                } else {
                                    $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                        '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
                                        '</div>');
                                }
                            }
                        }
                    });

                    return false;
                });

            }
        });
    }

    // remove functions
    function removeFunc(id)
    {
        if(id != null) {
            $("#removeForm").on('submit', function() {

                var form = $(this);


                // remove the text-danger
                $(".text-danger").remove();

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: { loan_id:id },
                    dataType: 'json',
                    success:function(response) {

                        manageTable.ajax.reload(null, false);
                        // hide the modal
                        $("#removeModal").modal('hide');

                        if(response.success === true) {
                            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                                '</div>');



                        } else {

                            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
                                '</div>');
                        }
                    }
                });

                return false;
            });
        }
    }


</script>