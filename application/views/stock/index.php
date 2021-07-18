

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage
            <small>Stock</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Stock</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12 col-xs-12">

                <div id="messages"></div>

                <?php if(in_array('createStock', $user_permission)): ?>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addModal" onclick="getProductByCat()">Add Stock</button>
                    <br /> <br />
                <?php endif; ?>


                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Manage Stock</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="manageTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
<!--                                <th>Product Name</th>-->
                                <th>Category Name</th>
                                <th>Quantity</th>
                                <th>Date Time</th>
                                <?php if(in_array('updateStock', $user_permission) || in_array('deleteStock', $user_permission)): ?>
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

<?php if(in_array('createStock', $user_permission)): ?>
    <!-- create brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="addModal" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Stock</h4>
                </div>

                <form role="form" action="<?= base_url('stock/create') ?>" method="post" id="createForm">

                    <div class="modal-body">
                        <div id="messages"></div>

                         <div class="form-group">
                            <label for="active">Category</label>
                            <select class="form-control select_group" data-live-search="true" id="category" name="category" onclick="getProductByCat()" onchange="getProductByCat()">
                                <?php foreach ($category as $k => $v): ?>
                                    <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

<!--                        <div class="form-group">-->
<!--                            <label for="brand_name">Product Name</label>-->
<!--                            <select class="form-control select_group" data-live-search="true" id="product"  name="product">-->
<!---->
<!--                            </select>-->
<!--                        </div>-->

                        <div class="form-group">
                            <label for="brand_name">Quantity</label>
                            <input type="number" min="0" oninput="this.value = Math.abs(this.value)" required name="qty"  class="form-control" id="qty" placeholder="Enter Quantity" >
                        </div>

                        <div class="form-group">
                            <label for="brand_name">Date Time</label>
                            <input type="text" class="form-control" id="date_time" name="date_time" disabled value="<?=date('Y-m-d') ?>">
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

<?php if(in_array('updateStock', $user_permission)): ?>
    <!-- edit brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="editModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Stock</h4>
                </div>

                <form role="form" action="<?php echo base_url('stock/update') ?>" method="post" id="updateForm">

                    <div class="modal-body">
                        <div id="messages"></div>

                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control" data-live-search="true" id="edit_category" onclick="getProductByCat_Edit()" onchange="getProductByCat_Edit()" name="category" >
                                <?php foreach ($category as $k => $v): ?>
                                    <option value="<?= $v['id'] ?>"> <?= $v['name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

<!--                        <div class="form-group">-->
<!--                            <label for="brand_name">Product Name</label>-->
<!--                            <select class="form-control select_group" id="edit_product" name="product" >-->
<!---->
<!--                            </select>-->
<!--                        </div>-->

                        <div class="form-group">
                            <label for="brand_name">Quantity</label>
                            <input type="number" min="0" oninput="this.value = Math.abs(this.value)" name="qty" required  class="form-control" id="edit_qty" placeholder="Enter Quantity" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="brand_name">Date Time</label>
                            <input type="datetime-local" class="form-control" id="edit_date_time" disabled name="date_time"  value="<?= date('Y-m-d') ?>">
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

<?php if(in_array('deleteStock', $user_permission)): ?>
    <!-- remove brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Remove Stock Item</h4>
                </div>

                <form role="form" action="<?php echo base_url('stock/remove') ?>" method="post" id="removeForm">
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

    var manageTable;
    var base_url = "<?php echo base_url(); ?>";

    $(document).ready(function() {
        $(function() {
            $('select').selectize({
                sortField: 'text'
            });
        });

        $('#stockMainNav').addClass('active');
        // initialize the datatable
        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + 'stock/fetchStockData',
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


    function getProductByCat_Edit() {

        var cat_id = document.getElementById("edit_category").value;

        $.ajax({
            url: base_url + 'stock/selectProductByCat',
            type: 'post',
            data: {cat_id : cat_id},
            dataType: 'json',
            success:function(response) {

                var len = response.length;

                $("#edit_product").empty();
                for( var i = 0; i<len; i++){
                    var id = response[i]['id'];
                    var name = response[i]['name'];

                    $("#edit_product").append("<option value='"+id+"'>"+name+"</option>");

                }
            }
        });

    }

    function getProductByCat(){

        var cat_id = document.getElementById("category").value;

        $.ajax({
            url: base_url + 'stock/selectProductByCat',
            type: 'post',
            data: {cat_id : cat_id},
            dataType: 'json',
            success:function(response) {

                var len = response.length;

                $("#product").empty();
                for( var i = 0; i<len; i++){
                    var id = response[i]['id'];
                    var name = response[i]['name'];

                    $("#product").append("<option value='"+id+"'>"+name+"</option>");

                }
            }
        });

    }

    // edit function
    function editFunc(id)
    {
        $.ajax({
            url: base_url + 'stock/fetchStockDataById/'+id,
            type: 'post',
            dataType: 'json',
            success:function(response) {


                $("#edit_product").val(response.product_id);
                $("#edit_category").val(response.category_id);
                $("#edit_qty").val(response.qty);
                $("#edit_date_time").val(response.date_time);


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
        if(id) {
            $("#removeForm").on('submit', function() {

                var form = $(this);

                // remove the text-danger
                $(".text-danger").remove();

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: { stock_id:id },
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
