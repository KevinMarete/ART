<div id="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('manager/dashboard'); ?>">Dashboard</a></li>
                <li>Admin</li>
                <li class="active breadcrumb-item"><i class="white-text" aria-hidden="true"></i><?php echo $page_name; ?></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-default" onclick="add_service()"><i class="fa fa-plus-square-o"></i> Add Service</button>
            <button class="btn btn-default" onclick="reload_table()"><i class="fa fa-refresh"></i> Refresh</button>
            <br/>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">           
            <br/>
            <table id="table" class="table table-striped table-bordered table-responsive table-condensed" width="100%">
                <thead>
                    <tr>
                        <th class="col-ld-11 col-md-8 col-xs-6">Service Name</th>
                        <th class="col-lg-1 col-md-4 col-xs-6">Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    var save_method;
    var table;

    $(document).ready(function () {

        //datatables
        table = $('#table').DataTable({

            "processing": true,
            "language": {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
            },
            "serverSide": true,
            "order": [],

            "ajax": {
                "url": "<?php echo base_url('Manager/settings/Service/ajax_list'); ?>",
                "type": "POST"
            },
            "columnDefs": [
                {
                    "targets": [-1],
                    "orderable": false,
                },
            ],

        });
        $("input").change(function () {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });

    });

    function add_service()
    {
        save_method = 'add';
        $('#form')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $('#modal_form').modal('show');
        $('.modal-title').text('Add Service');
    }

    function edit_service(id)
    {
        save_method = 'update';
        $('#form')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo base_url('Manager/settings/Service/ajax_edit'); ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data)
            {

                $('[name="id"]').val(data.id);
                $('[name="name"]').val(data.name);

                $('#modal_form').modal('show');
                $('.modal-title').text('Edit Service');

            },
            error: function ()
            {
                alert('Error get data from ajax');
            }
        });
    }

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
            url = "<?php echo base_url('Manager/settings/Service/ajax_add'); ?>";
        } else {
            url = "<?php echo base_url('Manager/settings/Service/ajax_update'); ?>";
        }

        // ajax adding data to database
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
                alert('Error adding / update data');
                $('#btnSave').text('save');
                $('#btnSave').attr('disabled', false);

            }
        });
    }

    function delete_service(id)
    {
        if (confirm('Are you sure you want to delete this Service?'))
        {
            $.ajax({
                url: "<?php echo base_url('Manager/settings/Service/ajax_delete'); ?>/" + id,
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

<!-- Add or Edit County modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Service Name</label>
                            <div class="col-md-9">
                                <input name="name" placeholder="Service Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-default">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->