<style type="text/css">
    .dangerClass{
        background: lightsalmon;
        color:white;
    }
</style>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb page-header">
                <?php if ($this->uri->segment(3) == 'meeting') { ?>
                    <li><a href="<?php echo base_url('manager/procurement/meeting'); ?>">Procurement</a></li>
                    <li>Meeting</li>
                    <li class="active breadcrumb-item"><i class="white-text" aria-hidden="true"></i>Meeting Dates</li>
                <?php } else { ?>
                    <li><a href="<?php echo base_url('manager/dashboard'); ?>">Dashboard</a></li>
                    <li>Admin</li>
                    <li class="active breadcrumb-item"><i class="white-text" aria-hidden="true"></i> <?php echo ucwords(str_replace('_', ' ', $page_name)); ?></li>
                <?php } ?>
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
                    <div class="btn-group" role="group" id="action_btn" aria-label="...">
                        <button type="button" class="btn btn-default" onclick="add_<?php echo $page_name; ?>()"> 
                            <i class="fa fa-plus-square"></i> Add
                        </button>
                        <button type="button" class="btn btn-default" id="edit_btn" onclick="edit_<?php echo $page_name; ?>()"> 
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        <button type="button" class="btn btn-default" id="del_btn" onclick="delete_<?php echo $page_name; ?>()"> 
                            <i class="fa fa-trash"></i> Remove
                        </button>
                        <?php if ($page_name == 'meeting') { ?>
                            <button type="button" class="btn btn-default" id="view_btn" onclick="view()"> 
                                <i class="fa fa-zoom "></i> View
                            </button>
                        <?php } ?>
                        <br/>
                        <i class="label label-warning">Click on table row for Edit/Remove</i>
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table <?php
                    if ($this->uri->segment(3) == 'drug') {
                        
                    } else {
                        echo 'table-striped';
                    };
                    ?> table-bordered table-hover" id="dataTables-listing">
                        <thead>
                            <tr>
                                <?php
                                $remove_labels = array('created_at', 'updated_at', 'deleted_at');
                                $skip_pages_names = array('install', 'dhis_elements', 'user');
                                $replace_labels = array(
                                    'county_id' => 'County',
                                    'generic_id' => 'Generic',
                                    'formulation_id' => 'Formulation',
                                    'parent_id' => 'parent name',
                                    'subcounty_id' => 'Subcounty',
                                    'partner_id' => 'Partner',
                                    'category_id' => 'Category',
                                    'service_id' => 'Service',
                                    'line_id' => 'Line',
                                    'facility_id' => 'facility name',
                                    'module_id' => 'module name',
                                    'submodule_id' => 'submodule',
                                    'foldername' => 'folder name',
                                    'firstname' => 'first name',
                                    'lastname' => 'last name',
                                    'regimen_id' => 'regimen',
                                    'drug_id' => 'drug name',
                                    'role_id' => 'role'
                                );
                                foreach ($columns as $column) {
                                    //Replace labels
                                    if (in_array($column, array_keys($replace_labels))) {
                                        $column = $replace_labels[$column];
                                    }
                                    //Remove '_' to ' ' for all headings except install, dhis_elements and user settings
                                    if (!in_array($page_name, $skip_pages_names) && !in_array($column, $remove_labels)) {
                                        echo"<th>" . ucwords(str_replace('_', ' ', $column)) . "</th>";
                                    }
                                }
                                if ($page_name == 'install') {
                                    ?>
                                    <th>ID</th>
                                    <th>Version</th> 
                                    <th>Facility</th> 
                                    <th>Setup Date</th>
                                    <th>Contact Name</th> 
                                    <th>Contact Phone</th> 
                                    <th>Emrs Used</th>
                                    <th>Active Patients</th> 
                                    <th>Is Usage</th> 
                                    <th>Is Internet</th> 
                                    <th>Assignee</th> 
                                    <?php
                                }
                                if ($page_name == 'dhis_elements') {
                                    ?>
                                    <th>Id</th>
                                    <th>Code</th>
                                    <th>Dhis Name</th>
                                    <th>Dhis Report</th>
                                    <th>Target Report</th>
                                    <th>Target Name</th>
                                    <th>Target Category</th>
                                    <th>Target Element</th>
                                    <?php
                                }
                                if ($page_name == 'user') {
                                    ?>
                                    <th>Id</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email Address</th>
                                    <th>Phone Number</th>
                                    <th>Role</th>
<?php } ?>

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
<?php
if ($page_name != 'backup') {
    $this->load->view('pages/admin/' . $page_name . '_view');
}
?>

<script>
    var save_method;
    var table;
    var selected_id = 0;
    selected_date = '';
    $('#edit_btn').prop('disabled', true);
    $('#del_btn').prop('disabled', true);
    $('#view_btn').prop('disabled', true);

    //hide action_btn for table_view backup and user
<?php if ($page_name == 'backup') { ?>
        $('#action_btn').hide(true);
<?php } ?>

    $(document).ready(function () {
        table = $('#dataTables-listing').DataTable({
            //responsive: true,
            "scrollX": true,
            "createdRow": function (row, data, dataIndex) {
                if (data[12] >= '0' && data[12] <= '2') {
                    $(row).addClass('dangerClass');
                } else if (data[12] >= '2' && data[12] <= '4') {
                    $(row).addClass('warningClass');
                } else if (data[12] >= '4' && data[12] <= '6') {
                    $(row).addClass('infoClass');
                } else {
                    $(row).addClass('noClass');
                }
            },
            ajax: "<?php echo base_url() . 'Manager/Admin/get_data/tbl_' . $page_name . '/'; ?>",
            select: {
                style: 'single',
            },
        });
    });

    //tr.selected on tbody click
    $('#dataTables-listing tbody').on('click', 'tr', function () {
        selected_id = (table.row(this).data())[0];
        selected_date = (table.row(this).data())[1];

        if ($(this).hasClass('selected')) {
            $('#edit_btn').prop('disabled', true);
            $('#del_btn').prop('disabled', true);
            $('#view_btn').prop('disabled', true);
            $(this).removeClass('selected');
        } else {
            table.$('tr.selected').removeClass('selected');
            $('#edit_btn').prop('disabled', false);
            $('#del_btn').prop('disabled', false);
            $('#view_btn').prop('disabled', false);
            $(this).addClass('selected');
        }

    });

    function view() {
        window.location.href = '<?= base_url(); ?>manager/procurement/minute/ART/' + selected_date;
    }
    ;

    //function add data to db_table
    function add_<?php echo $page_name; ?>() {
        save_method = 'add';
        $('#form')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $('#modal_form').modal('show');
        $('.modal-title').text('Add <?php echo ucwords(str_replace('_', ' ', $page_name)); ?>');

        //Get all facilities not installed
        var facilityinstallURL = '<?= base_url(); ?>API/facility_install';
        $("#facility").empty();
        $.getJSON(facilityinstallURL, function (facilities) {
            $("#facility").append($("<option value=''>Select Facility</option>"));
            $.each(facilities, function (index, facility) {
                $("#facility").append($("<option value='" + facility.id + "'>" + facility.name.toUpperCase() + "</option>"));
            });
        });

        //regimen_drug
        $('.regimen_drug_edit').hide(true);
        $('.regimen_drug_add').show(true);

        var regimenURL = '<?= base_url(); ?>API/regimen_regimen_drug';
        $("#regimen_add").empty()
        $.getJSON(regimenURL, function (regimens) {
            $("#regimen_add").append($("<option value=''>Select Regimen</option>"));
            $.each(regimens, function (index, regimen) {
                $("#regimen_add").append($("<option value='" + regimen.id + "'>" + regimen.name.toUpperCase() + "</option>"));
            });
        });
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

        //Remove required class on all DIVs
        $('div').removeClass('has-error');

        //Get all facilities
        var facilityURL = '<?= base_url(); ?>API/facility';
        $.getJSON(facilityURL, function (facilities) {
            $.each(facilities, function (index, facility) {
                $("#facility").append($("<option value='" + facility.id + "'>" + facility.name.toUpperCase() + "</option>"));
            });
        });

        //regimen_drug
        $('.regimen_drug_add').hide(true);
        $('.regimen_drug_edit').show(true);

        var regimenURL = '<?= base_url(); ?>API/regimen';
        $("#regimen_edit").empty()
        $.getJSON(regimenURL, function (regimens) {
            $("#regimen_edit").append($("<option value=''>Select Regimen</option>"));
            $.each(regimens, function (index, regimen) {
                $("#regimen_edit").append($("<option value='" + regimen.id + "'>" + regimen.name.toUpperCase() + "</option>"));
            });
        });

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
                //dhis_elements
                $('[name="dhis_code"]').val(data.dhis_code);
                $('[name="dhis_name"]').val(data.dhis_name);
                $('[name="dhis_report"]').val(data.dhis_report);
                $('[name="target_report"]').val(data.target_report);
                $('[name="target_name"]').val(data.target_name);
                $('[name="target_category"]').val(data.target_category);
                $('[name="target_id"]').val(data.target_id);
                //dose
                $('[name="value"]').val(data.value);
                $('[name="frequency"]').val(data.frequency);
                //drug
                $('[name="strength"]').val(data.strength);
                $('[name="packsize"]').val(data.packsize);
                $('[name="generic_id"]').val(data.generic_id);
                $('[name="formulation_id"]').val(data.formulation_id);
                $('[name="drug_category"]').val(data.drug_category);
                $('[name="min_mos"]').val(data.min_mos);
                $('[name="max_mos"]').val(data.max_mos);
                $('[name="amc_months"]').val(data.amc_months);
                $('[name="stock_status"]').val(data.stock_status);
                $('[name="kemsa_code"]').val(data.kemsa_code);
                $('[name="facility_amc"]').val(data.facility_amc);
                $('[name="short_expiry"]').val(data.short_expiry);
                $('[name="expiry_date"]').val(data.expiry_date);
                $('[name="regimen_category"]').val(data.regimen_category);
                //generic
                $('[name="abbreviation"]').val(data.abbreviation);
                //meeting
                $('[name="meeting_date"]').val(data.meeting_date);
                //module
                $('[name="icon"]').val(data.icon);
                //mailing_list
                $('[name="name"]').val(data.name);
                $('[name="email"]').val(data.email);
                $('[name="email_type"]').val(data.email_type);
                //install
                $('[name="facility_id"]').val(data.facility_id);
                $('[name="contact_name"]').val(data.contact_name);
                $('[name="contact_name"]').trigger('change');
                $('[name="contact_phone"]').val(data.contact_phone);
                $('[name="version"]').val(data.version);
                $('[name="setup_date"]').val(data.setup_date);
                $('[name="upgrade_date"]').val(data.upgrade_date);
                $('[name="comments"]').val(data.comments);
                $("input[name=is_usage][value=" + data.is_usage + "]").prop('checked', true);
                $("input[name=is_internet][value=" + data.is_internet + "]").prop('checked', true);
                $('select[name="emrs_used"] option[value="' + data.emrs_used + '"]').prop('selected', true);
                $('[name="active_patients"]').val(data.active_patients);
                $('[name="user_id"]').val(data.user_id);
                //regimen
                $('[name="code"]').val(data.code);
                $('[name="description"]').val(data.description);
                $('[name="category_id"]').val(data.category_id);
                $('[name="service_id"]').val(data.service_id);
                $('[name="line_id"]').val(data.line_id);
                //regimen_drug
                $('[name="regimen_id"]').val(data.regimen_id);
                $('[name="drug_id"]').val(data.drug_id);
                //role_submodule
                $('[name="role_id"]').val(data.role_id)

                // alert(data.role_id)
                $('[name="submodule_id"]').val(data.submodule_id);

                //  alert(data.role_id)

                //User
                $('[name="firstname"]').val(data.firstname);
                $('[name="lastname"]').val(data.lastname);
                $('[name="email_address"]').val(data.email_address);
                $('[name="phone_number"]').val(data.phone_number);
                $('[name="role"]').val(data.role_id);


                //facility
                $('[name="mflcode"]').val(data.mflcode);
                $('[name="category"]').val(data.category);
                $('[name="dhiscode"]').val(data.dhiscode);
                $('[name="longitude"]').val(data.longitude);
                $('[name="latitude"]').val(data.latitude);
                $('[name="subcounty_id"]').val(data.subcounty_id);
                $('[name="partner_id"]').val(data.partner_id);
                $('[name="parent_id"]').val(data.parent_id);
                //submodule
                $('[name="module_id"]').val(data.module_id);

                $('#modal_form').modal('show');
                //select2
                $(".select2").select2({
                    width: '100%',
                    allowClear: true,
                    // dropdownParent: $("#modal_form")
                }).trigger('change');

                $('.modal-title').text('Edit <?php echo ucwords(str_replace('_', ' ', $page_name)); ?>');
            },
            error: function ()
            {
                swal('Error', 'Error getting <?php echo str_replace('_', ' ', $page_name); ?>', 'error');
            }
        });
    }

    //function refresh db_table
    function reload_table() {
        table.ajax.reload(null, false);
        $('#edit_btn').prop('disabled', true);
        $('#del_btn').prop('disabled', true);
    }

    function save() {
        //$('#btnSave').text('saving...');
       // $('#btnSave').attr('disabled', true);
        var url;

        if (save_method == 'add') {
            url = "<?php echo base_url('Manager/Admin/add_data/tbl_' . $page_name); ?>";
        } else {
            url = "<?php echo base_url('Manager/Admin/update_data/tbl_' . $page_name); ?>";
        }
        $.ajax({
            url: url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function (data)
            {
                if (data.status) {
                    $('#modal_form').modal('hide');
                    swal('<?php echo ucwords(str_replace('_', ' ', $page_name)); ?>', 'Add/updation success!', 'success');
                    reload_table();
                } else {
                    if (data.message) {
                        swal('Error', data.message, 'error');
                    } else {
                        for (var i = 0; i < data.inputerror.length; i++)
                        {
                            $('[name="' + data.inputerror[i] + '"]').parent().addClass('has-error');
                            $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
                        }
                        //Show required labels in select2
                        $('.select2').removeClass('select2-hidden-accessible');
                        $('span.select2-container').css('color', '#a94442');//red color for required
                    }
                }
                $('#btnSave').text('save');
                $('#btnSave').attr('disabled', false);
            },
            error: function (data)
            {
                swal('Error', 'Error adding / updating <?php echo str_replace('_', ' ', $page_name); ?>', 'error');
                $('#btnSave').text('save');
                $('#btnSave').attr('disabled', false);

            }
        });
    }

    //function remove data from db_table
    function delete_<?php echo $page_name; ?>() {

        swal({
            title: "Remove Alert",
            text: "Are you sure, You want to delete this <?php echo str_replace('_', ' ', $page_name); ?>?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "<?php echo base_url('Manager/Admin/delete_data/tbl_' . $page_name); ?>/" + this.selected_id,
                    type: "POST",
                    dataType: "JSON",
                    success: function ()
                    {
                        swal('<?php echo ucwords(str_replace('_', ' ', $page_name)); ?>', 'deletion success!', 'success');
                        $('#modal_form').modal('hide');
                        reload_table();
                    },
                    error: function ()
                    {
                        swal('Error', 'Error deleting <?php echo str_replace('_', ' ', $page_name); ?>!', 'error');
                    }
                });
            }
        });
    }
</script>