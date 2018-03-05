var save_method; //for save method string
var table;

$(document).ready(function () {

    //datatables
    table = $('#table').DataTable({

        "processing": true,
        "serverSide": true,
        "order": [],

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "County/ajax_list",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "targets": [-1], //last column
                "orderable": false,
            },
        ],

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
    $('.modal-title').text('ADD COUNTY');
}

function edit_county(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url: "County/ajax_edit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function (data)
        {

            $('[name="id"]').val(data.id);
            $('[name="name"]').val(data.name);

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('EDIT COUNTY'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
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
        url = "County/ajax_add";
    } else {
        url = "County/ajax_update";
    }

    // ajax adding data to database
    $.ajax({
        url: url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function (data)
        {

            if (data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
            } else
            {
                for (var i = 0; i < data.inputerror.length; i++)
                {
                    $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('save');
            $('#btnSave').attr('disabled', false);


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save');
            $('#btnSave').attr('disabled', false); //set button enable 

        }
    });
}

function delete_county(id)
{
    if (confirm('Are you sure you want to delete this County?'))
    {
        // ajax delete data to database
        $.ajax({
            url: "County/ajax_delete/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

    }
}