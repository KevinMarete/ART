<div id="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('manager/dashboard'); ?>">Dashboard</a></li>
                <li>Admin</li>
                <li class="active breadcrumb-item"><i class="white-text" aria-hidden="true"></i><?php echo $page_name;?></li>
            </ol>
            <!-- /.col-lg-12 -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-default" onclick="add_facility()"><i class="fa fa-plus-square-o"></i> Add Facility</button>
            <button class="btn btn-default" onclick="reload_table()"><i class="fa fa-refresh"></i> Refresh</button>
            <br>
            <br>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">

            <table id="table" class="table table-striped table-bordered table-responsive table-condensed" width="100%">
                <thead>
                    <tr>
                        <th>Facility Name</th>
                        <th>MflCode</th>
                        <th>Category</th>
                        <th>DhisCode</th>
                        <th>Longitude</th>
                        <th>Latitude</th>
                        <th>SubCounty Name</th>
                        <th>Partner Name</th>
                        <th>Action</th>
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
                "url": "<?php echo base_url('Manager/settings/Facility/ajax_list'); ?>",
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



    function add_facility()
    {
        save_method = 'add';
        $('#form')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $('#modal_form').modal('show');
        $('.modal-title').text('Add Facility');

        //select2 for Category
        $("#category_id").select2({
            placeholder: "---Select Category---",
            allowClear: true,
            dropdownParent: $("#modal_form")
        });

        //select2 for Subcounty
        $("#subcounty").select2({
            placeholder: "---Select SubCounty---",
            allowClear: true,
            dropdownParent: $("#modal_form")
        });
        //select2 for Partner
        $("#partner").select2({
            placeholder: "---Select Partner---",
            allowClear: true,
            dropdownParent: $("#modal_form")
        });
    }

    function edit_facility_listing(id)
    {
        save_method = 'update';
        $('#form')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        //select2 for Category
        $("#category_id").select2({
            allowClear: true,
            dropdownParent: $("#modal_form")
        });

        //select2 for Subcounty
        $("#subcounty").select2({
            allowClear: true,
            dropdownParent: $("#modal_form")
        });
        //select2 for Partner
        $("#partner").select2({
            allowClear: true,
            dropdownParent: $("#modal_form")
        });

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo base_url('Manager/settings/Facility/ajax_edit'); ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data)
            {

                $('[name="id"]').val(data.id);
                $('[name="name"]').val(data.name);
                $('[name="mflcode"]').val(data.mflcode);
                $('[name="category"]').val(data.category).trigger('change');
                $('[name="dhiscode"]').val(data.dhiscode);
                $('[name="longitude"]').val(data.longitude);
                $('[name="latitude"]').val(data.latitude);
                $('[name="subcounty_id"]').val(data.subcounty_id).trigger('change');
                $('[name="partner_id"]').val(data.partner_id).trigger('change');

                $('#modal_form').modal('show');
                $('.modal-title').text('Edit Facility');

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
            url = "<?php echo base_url('Manager/settings/Facility/ajax_add'); ?>";
        } else {
            url = "<?php echo base_url('Manager/settings/Facility/ajax_update'); ?>";
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
                alert('Error adding / update data');
                $('#btnSave').text('save');
                $('#btnSave').attr('disabled', false);

            }
        });
    }

    function delete_facility_listing(id)
    {
        if (confirm('Are you sure you want to delete this facility?'))
        {
            $.ajax({
                url: "<?php echo base_url('Manager/settings/Facility/ajax_delete'); ?>/" + id,
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

<!-- Add or Edit modal -->
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
                            <label class="control-label col-md-3">Facility Name</label>
                            <div class="col-md-9">
                                <input id="name" name="name" placeholder="Facility Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">MflCode</label>
                            <div class="col-md-9">
                                <input id="mflcode" name="mflcode" placeholder="MflCode" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Category</label>
                            <div class="col-md-9">
                                <select name="category" id="category_id" class="form-control" style="width: 100%">
                                    <option value="">---Select Category---</option>
                                    <option value="central">Central</option>
                                    <option value="satellite">Satellite</option>
                                    <option value="standalone">Standalone</option>
                                </select>
                                <span class="help-block"></span>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">DhisCode</label>
                            <div class="col-md-9">
                                <input id="dhiscode" name="dhiscode" placeholder="DhisCode" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Longitude</label>
                            <div class="col-md-9">
                                <input id="longitude" name="longitude" placeholder="Longitude" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Latitude</label>
                            <div class="col-md-9">
                                <input id="latitude" name="latitude" placeholder="Latitude" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Sub County</label>
                            <div class="col-md-9">
                                <select name="subcounty_id" id="subcounty" class="form-control" style="width: 100%">
                                    <option value="">----Select SubCounty---</option>
                                    <?php foreach ($get_subcounty as $row) { ?>                                        
                                        <option value="<?= $row->id ?>"><?= $row->name ?></option>
                                    <?php } ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Partner Name</label>
                            <div class="col-md-9">
                                <select name="partner_id" id="partner" class="form-control" style="width: 100%">
                                    <option value="">----Select Partner----</option>
                                    <?php foreach ($get_partner as $row) { ?>
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
                <button type="button" id="btnSave" onclick="save()">Save</button>
                <button type="button" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->