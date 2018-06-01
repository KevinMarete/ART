<div id="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('manager/dashboard'); ?>">Dashboard</a></li>
                <li>Admin</li>
                <li class="active breadcrumb-item"><i class="white-text" aria-hidden="true"></i><?php echo $page_name;?></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-default" onclick="add_drug()"><i class="fa fa-plus-square-o"></i> Add Drug</button>
            <button class="btn btn-default" onclick="reload_table()"><i class="fa fa-refresh"></i> Refresh</button>
            <br/>
            <br/>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <table id="table" class="table table-striped table-bordered table-responsive table-condensed" width="100%">
                <thead>
                    <tr>
                        <th class="col-md-3">Strength</th>
                        <th class="col-md-3">Pack Size</th>
                        <th class="col-md-3">Generic Name</th>
                        <th class="col-md-2">Formulation</th>
                        <th class="col-md-1">Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table> 
        </div>
    </div>

</div>

<script>
    var save_method; //for save method string
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
                "url": "<?php echo base_url('Manager/settings/Drug/ajax_list'); ?>",
                "type": "POST"
            },
            "columnDefs": [
                {
                    "targets": [-1], //last column
                    "orderable": false,
                },
            ],

        });
        $("input").change(function () {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });

    });

    function add_drug()
    {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $('#modal_form').modal('show');
        $('.modal-title').text('Add Drug');

        //select2 for Generic
        $("#generic_id").select2({
            placeholder: "---Select Generic---",
            allowClear: true,
            dropdownParent: $("#modal_form")
        });
        //select2 for Formulation
        $("#formulation_id").select2({
            placeholder: "---Select Formulation---",
            allowClear: true,
            dropdownParent: $("#modal_form")
        });
    }

    function edit_drug(id)
    {
        save_method = 'update';
        $('#form')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();

        //select2 for Generic
        $("#generic_id").select2({
            allowClear: true,
            dropdownParent: $("#modal_form")
        });
        //select2 for Formulation
        $("#formulation_id").select2({
            allowClear: true,
            dropdownParent: $("#modal_form")
        });

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo base_url('Manager/settings/Drug/ajax_edit'); ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data)
            {

                $('[name="id"]').val(data.id);
                $('[name="strength"]').val(data.strength);
                $('[name="packsize"]').val(data.packsize);
                $('[name="generic_id"]').val(data.generic_id).trigger('change');
                $('[name="formulation_id"]').val(data.formulation_id).trigger('change');

                $('#modal_form').modal('show');
                $('.modal-title').text('Edit Drug');

            },
            error: function ()
            {
                alert('Error get data from ajax');
            }
        });
    }

    function reload_table()
    {
        table.ajax.reload(null, false); //reload datatable ajax 
    }

    function save()
    {
        $('#btnSave').text('saving...');
        $('#btnSave').attr('disabled', true);
        var url;

        if (save_method == 'add') {
            url = "<?php echo base_url('Manager/settings/Drug/ajax_add'); ?>";
        } else {
            url = "<?php echo base_url('Manager/settings/Drug/ajax_update'); ?>";
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

    function delete_drug(id)
    {
        if (confirm('Are you sure you want to delete this Drug?'))
        {
            // ajax delete data to database
            $.ajax({
                url: "<?php echo base_url('Manager/settings/Drug/ajax_delete'); ?>/" + id,
                type: "POST",
                dataType: "JSON",
                success: function (data)
                {
                    //if success reload ajax table
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
                            <label class="control-label col-md-3">Strength</label>
                            <div class="col-md-9">
                                <input name="strength" placeholder="Strength" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Pack Size</label>
                            <div class="col-md-9">
                                <input name="packsize" placeholder="Pack Size" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Generic</label>
                            <div class="col-md-9">
                                <select name="generic_id" id="generic_id" class="form-control" style="width: 100%">
                                    <option value="">---Select Generic----</option>
                                    <?php foreach ($get_generic as $row) { ?>
                                        <option value="<?= $row->id ?>"><?= $row->name ?></option>
                                    <?php } ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Formulation</label>
                            <div class="col-md-9">
                                <select name="formulation_id" id="formulation_id" class="form-control" style="width: 100%">
                                    <option value="">---Select Formulation----</option>
                                    <?php foreach ($get_formulation as $row) { ?>
                                        <option value="<?= $row->id ?>"><?= $row->name ?></option>
                                    <?php } ?>
                                </select>
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