<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb page-header">
                <li><a href="<?php echo base_url('manager/dashboard'); ?>">Dashboard</a></li>
                <li>Admin</li>
                <li class="active breadcrumb-item"><i class="white-text" aria-hidden="true"></i> <?php echo ucwords(str_replace('_', ' ', $page_name)); ?></li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <!--Add button controls-->
                    <div class="btn-group" role="group" aria-label="...">
                        <button type="button" class="btn btn-default" onclick="add_<?php echo $page_name; ?>()"> <i class="fa fa-plus-square"></i> Add</button>
                        <button type="button" class="btn btn-default" onclick="edit_<?php echo $page_name; ?>()"> <i class="fa fa-edit"></i> Edit</button>
                        <button type="button" class="btn btn-default" onclick="delete_<?php echo $page_name; ?>()"> <i class="fa fa-trash"></i> Remove</button>
                        <br/>
                        <br/>
                        <i class="label label-warning">Click on table row for Edit/Remove</i>
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-listing">
                        <thead>
                            <tr>
                                <?php
                                foreach ($columns as $column) {
                                    if ($column == 'county_id') {
                                        $column = 'County';
                                    }
                                    if ($column == 'generic_id') {
                                        $column = 'Generic';
                                    }
                                    if ($column == 'formulation_id') {
                                        $column = 'Formulation';
                                    }
                                    if ($column == 'subcounty_id') {
                                        $column = 'Subcounty';
                                    }
                                    if ($column == 'partner_id') {
                                        $column = 'Partner';
                                    }
                                    if ($column == 'category_id') {
                                        $column = 'Category';
                                    }
                                    if ($column == 'service_id') {
                                        $column = 'Service';
                                    }
                                    if ($column == 'line_id') {
                                        $column = 'Line';
                                    }
                                    echo"<th>" . ucwords($column) . "</th>";
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div><!-- /#page-wrapper -->

<!--load settings_view_pages modal-->
<?php $this->load->view('pages/admin/' . $page_name . '_view') ?>

<script>
    var save_method;
    var table;
    var selected_id = 0;
    $(document).ready(function () {
        table = $('#dataTables-listing').DataTable({
            responsive: true,
            ajax: "<?php echo base_url() . 'Manager/Admin/get_data/tbl_' . $page_name . '/'; ?>",
            select: {
                style: 'single',
            }

        });

    });
    $('#dataTables-listing tbody').on('click', 'tr', function () {
        selected_id = (table.row(this).data())[0];
    });

    //function add data to db_table
    function add_<?php echo $page_name; ?>() {
        save_method = 'add';
        $('#form')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $('#modal_form').modal('show');
        $('.modal-title').text('Add <?php echo ucwords(str_replace('_', ' ', $page_name)); ?>');
        //select2
        $(".select2").select2({
            width: '100%',
            allowClear: true,
            dropdownParent: $("#modal_form")
        });
    }

    //function edit db_table data
    function edit_<?php echo $page_name; ?>() {
        save_method = 'update';
        $('#form')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();

        $.ajax({
            url: "<?php echo base_url('Manager/Admin/edit_data/tbl_' . $page_name); ?>/" + this.selected_id,
            type: "GET",
            dataType: "JSON",
            success: function (data)
            {
                //commmon to most tables
                $('[name="id"]').val(data.id);
                $('[name="name"]').val(data.name);
                //subcounty
                $('[name="county_id"]').val(data.county_id);
                //dose
                $('[name="value"]').val(data.value);
                $('[name="frequency"]').val(data.frequency);
                //drug
                $('[name="strength"]').val(data.strength);
                $('[name="packsize"]').val(data.packsize);
                $('[name="generic_id"]').val(data.generic_id);
                $('[name="formulation_id"]').val(data.formulation_id);
                //generic
                $('[name="abbreviation"]').val(data.abbreviation);
                //regimen
                $('[name="code"]').val(data.code);
                $('[name="description"]').val(data.description);
                $('[name="category_id"]').val(data.category_id);
                $('[name="service_id"]').val(data.service_id);
                $('[name="line_id"]').val(data.line_id);
                //facility
                $('[name="mflcode"]').val(data.mflcode);
                $('[name="category"]').val(data.category);
                $('[name="dhiscode"]').val(data.dhiscode);
                $('[name="longitude"]').val(data.longitude);
                $('[name="latitude"]').val(data.latitude);
                $('[name="subcounty_id"]').val(data.subcounty_id);
                $('[name="partner_id"]').val(data.partner_id);

                $('#modal_form').modal('show');

                //select2
                $(".select2").select2({
                    width: '100%',
                    allowClear: true,
                    dropdownParent: $("#modal_form")
                });
                $('.modal-title').text('Edit <?php echo ucwords($page_name); ?>');

            },
            error: function ()
            {
                swal('Error', 'Error getting <?php echo $page_name;?>', 'error');
            }
        });
    }

    //function refresh table
    function reload_table() {
        table.ajax.reload(null, false);
    }

    function save() {
        $('#btnSave').text('saving...');
        $('#btnSave').attr('disabled', true);
        var url;

        if (save_method == 'add') {
            url = "<?php echo base_url('Manager/Admin/add_data'); ?>";
        } else {
            url = "<?php echo base_url('Manager/Admin/update_data'); ?>";
        }
        $.ajax({
            url: url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function (data)
            {

                if (data.status)
                {
                    $('#modal_form').modal('hide');
                     swal('<?php echo ucwords($page_name); ?>', 'Add/updation success!', 'success');
                    reload_table();
                } else
                {
                    for (var i = 0; i < data.inputerror.length; i++)
                    {
                        $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error');
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
                    }
                }
                $('#btnSave').text('save');
                $('#btnSave').attr('disabled', false);


            },
            error: function ()
            {
                swal('Error', 'Error adding / updating <?php echo $page_name; ?>', 'error');
                $('#btnSave').text('save');
                $('#btnSave').attr('disabled', false);

            }
        });
    }

    //function remove data from db_table
    function delete_<?php echo $page_name; ?>() {
        if (confirm('Are you sure you want to delete this <?php echo $page_name; ?>?'))
        {

            $.ajax({
                url: "<?php echo base_url('Manager/Admin/delete_data/tbl_' . $page_name); ?>/" + this.selected_id,
                type: "POST",
                dataType: "JSON",
                success: function ()
                {
                    swal('<?php echo ucwords($page_name); ?>', 'deletion success!', 'success');
                    $('#modal_form').modal('hide');
                    reload_table();
                },
                error: function ()
                {
                    swal('Error', 'Error deleting <?php echo $page_name; ?>!', 'error');
                }
            });

        }
    }
</script>