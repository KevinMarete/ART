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
                        <i class="label label-default">click on table row for Edit/Remove</i>
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-listing">
                        <thead>
                            <tr>
                                <?php
                                foreach ($columns as $column) {
                                    if($column == 'county_id'){
                                        $column = 'County';
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
    function add_<?php echo $page_name; ?>()
    {
        save_method = 'add';
        $('#form')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $('#modal_form').modal('show');
        $('.modal-title').text('Add <?php echo ucwords(str_replace('_', ' ', $page_name)); ?>');
    }

    //function edit db_table data
    function edit_<?php echo $page_name; ?>()
    {
        save_method = 'update';
        $('#form')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();

        $.ajax({
            url: "<?php echo base_url('Manager/Admin/ajax_edit/tbl_' . $page_name); ?>/" + this.selected_id,
            type: "GET",
            dataType: "JSON",
            success: function (data)
            {
                //commmon to all
                $('[name="id"]').val(data.id);
                $('[name="name"]').val(data.name);
                //county
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

                $('#modal_form').modal('show');
                $('.modal-title').text('Edit <?php echo ucwords($page_name); ?>');

            },
            error: function ()
            {
                alert('Error getting data');
            }
        });
    }

    //function refresh table
    function reload_table()
    {
        table.ajax.reload(null, false);
    }

    function save()
    {
        $('#btnSave').text('saving...');
        $('#btnSave').attr('disabled', true);
        var url;

        if (save_method == 'add') {
            url = "<?php echo base_url('Manager/Admin/add_data'); ?>";
        } else {
            url = "<?php echo base_url('Manager/Admin/ajax_update'); ?>";
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
                alert('Error adding / updating data');
                $('#btnSave').text('save');
                $('#btnSave').attr('disabled', false);

            }
        });
    }

    //function remove data from db_table
    function delete_<?php echo $page_name; ?>()
    {
        if (confirm('Are you sure you want to delete this <?php echo $page_name; ?>?'))
        {
            $.ajax({
                url: "<?php echo base_url('Manager/Admin/ajax_delete/tbl_'.$page_name); ?>/" + this.selected_id,
                type: "POST",
                dataType: "JSON",
                success: function (data)
                {
                    $('#modal_form').modal('hide');
                    reload_table();
                },
                error: function ()
                {
                    alert('Error deleting data');
                }
            });

        }
    }
</script>