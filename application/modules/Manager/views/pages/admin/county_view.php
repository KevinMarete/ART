<div id="page-wrapper">
    <div class="row">
        <div class="col-md-5">
            <h3>Counties</h3>
        </div>
        <div class="col-md-7">
            <ol class="breadcrumb">
                  <li><a href="<?php echo base_url('manager/dashboard'); ?>">Dashboard</a></li>
                <li class="active breadcrumb-item"><i class="fa fa-angle-double-right mx-2 white-text" aria-hidden="true"></i> County</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-default" onclick="add_county()"><i class="fa fa-plus-square"></i> Add County</button>
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
                        <th class="col-md-11">County Name</th>
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

            //load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo base_url('Manager/County/ajax_list'); ?>",
                "type": "POST"
            },

            //last column
            "columnDefs": [
                {
                    "targets": [-1],
                    "orderable": false,
                },
            ]

        });

        //set input/textarea/select event when change value, remove class error and remove text help block 
        $("input").change(function () {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });

    });

    function add_county()
    {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $('#modal_form').modal('show');
        $('.modal-title').text('Add County');
    }

    function edit_county(id)
    {
        save_method = 'update';
        //reset form on modals
        $('#form')[0].reset();
        //clear error class
        $('.form-group').removeClass('has-error');
        //clear error string
        $('.help-block').empty();

        //Ajax Load data from ajax
        $.ajax({
            url: "County/ajax_edit/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data)
            {

                $('[name="id"]').val(data.id);
                $('[name="name"]').val(data.name);
                //show bootstrap modal when complete loaded
                $('#modal_form').modal('show');
                //Set title to Bootstrap modal title
                $('.modal-title').text('Edit County');

            },
            error: function ()
            {
                alert('Error get data from ajax');
            }
        });
    }

    function reload_table()
    {
        //reload datatable ajax
        table.ajax.reload(null, false);
    }

    function save()
    {
        $('#btnSave').text('saving...');
        $('#btnSave').attr('disabled', true);
        var url;

        if (save_method == 'add') {
            url = "<?php echo base_url('Manager/County/ajax_add'); ?>";
        } else {
            url = "<?php echo base_url('Manager/County/ajax_update'); ?>";
        }

        //ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function (data)
            {
                //if success close modal and reload ajax table
                if (data.status)
                {
                    $('#modal_form').modal('hide');
                    reload_table();
                } else
                {
                    for (var i = 0; i < data.inputerror.length; i++)
                    {
                        //select parent twice to select div form-group class and add has-error class
                        $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error');
                        //select span help-block class set text error string
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
                //set button enable
                $('#btnSave').attr('disabled', false);

            }
        });
    }

    function delete_county(id)
    {
        if (confirm('Are you sure you want to delete this County?'))
        {
            //ajax delete data to database
            $.ajax({
                url: "<?php echo base_url('Manager/County/ajax_delete/'); ?>" + id,
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
                            <label class="control-label col-md-3">County Name</label>
                            <div class="col-md-9">
                                <input name="name" placeholder="County Name" class="form-control" type="text">
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