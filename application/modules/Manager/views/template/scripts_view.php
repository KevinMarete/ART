<script src="<?php echo base_url() . 'public/manager/js/tinymce/tinymce.min.js'; ?>"></script>
<!--Bootstrap Core JavaScript-->
<script src="<?php echo base_url() . 'public/manager/lib/bootstrap/3.3.7/js/bootstrap.min.js'; ?>"></script>
<!--highcharts-->
<script src="<?php echo base_url() . 'public/dashboard/lib/highcharts/js/highcharts.js'; ?>"></script>
<script src="<?php echo base_url() . 'public/dashboard/lib/highcharts/js/exporting.js'; ?>"></script>
<script src="<?php echo base_url() . 'public/dashboard/lib/highcharts/js/offline-exporting.js'; ?>"></script>
<script src="<?php echo base_url() . 'public/dashboard/lib/highcharts/js/drilldown.js'; ?>"></script>
<script src="<?php echo base_url() . 'public/dashboard/lib/highcharts/js/export-data.js'; ?>"></script>
<!-- Metis Menu Plugin JavaScript -->
<script src="<?php echo base_url() . 'public/manager/lib/sbadmin2/vendor/metisMenu/metisMenu.min.js'; ?>"></script>
<!-- Morris Charts JavaScript -->
<script src="<?php echo base_url() . 'public/manager/lib/sbadmin2/vendor/raphael/raphael.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'public/manager/lib/sbadmin2/vendor/morrisjs/morris.min.js'; ?>"></script>
<!-- DataTables JavaScript -->
<script src="<?php echo base_url() . 'public/manager/lib/sbadmin2/vendor/datatables/js/jquery.dataTables.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'public/manager/lib/sbadmin2/vendor/datatables-plugins/dataTables.bootstrap.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'public/manager/lib/sbadmin2/vendor/datatables-responsive/dataTables.responsive.js'; ?>"></script>
<script src="<?php echo base_url() . 'public/manager/lib/sbadmin2/vendor/datatables/js/dataTables.buttons.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'public/manager/lib/sbadmin2/vendor/datatables/js/dataTables.select.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'public/manager/lib/sbadmin2/vendor/datatables-plugins/average().js'; ?>"></script>
<script src="<?php echo base_url() . 'public/manager/lib/sbadmin2/vendor/datatables-plugins/sum().js'; ?>"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.2/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>
<!--select2 js-->
<script src="<?php echo base_url() . 'public/manager/lib/select2/js/select2.js'; ?>"></script>
<!--bootstrap-sweetalert--->
<script src="<?php echo base_url() . 'public/manager/lib/bootstrap-sweetalert/js/sweetalert.min.js'; ?>"></script>
<!--datepicker-->
<script src="<?php echo base_url() . 'public/manager/lib/bootstrap-datepicker-1.6.4/js/bootstrap-datepicker.min.js'; ?>"></script>
<!--chosen-->
<script src="<?php echo base_url() . 'public/manager/lib/chosen_v1.8.3/chosen.jquery.min.js'; ?>"></script>
<!--bootstrap-multiselect-->
<script src="<?php echo base_url() . 'public/manager/lib/bootstrap-multiselect/js/bootstrap-multiselect.js'; ?>"></script>
<!--disable_back_button-->
<script type="text/javascript" src="<?php echo base_url() . 'public/dashboard/js/disable_back_button.js'; ?>"></script>
<!--spin-->
<script type="text/javascript" src="<?php echo base_url() . 'public/dashboard/js/spin.min.js'; ?>"></script>
<!--bootbox-->
<script type="text/javascript" src="<?php echo base_url() . 'public/manager/lib/bootbox/js/bootbox.min.js'; ?>"></script>
<!--blockUI-->
<script type="text/javascript" src="<?php echo base_url() . 'public/manager/lib/blockUI/js/jquery.blockUI.js'; ?>"></script>
<!--sweetalert-->
<script type="text/javascript" src="<?php echo base_url() . 'public/manager/js/sweetalert.min.js'; ?>"></script>
<!--tabledit-->
<script type="text/javascript" src="<?php echo base_url() . 'public/manager/js/jquery.tabledit.min.js'; ?>"></script>
<!--jexcel-->
<script type="text/javascript" src="<?php echo base_url() . 'public/manager/lib/jexcel/js/excel-formula.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'public/manager/lib/jexcel/js/jquery.jexcel.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'public/dashboard/js/jquery.tabletojson.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'public/manager/js/jquery.smartWizard.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'public/manager/js/jquery.easy-autocomplete.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'public/manager/lib/timepicker/js/jquery.timepicker.min.js'; ?>"></script>
<!-- Custom Theme JavaScript -->
<script src="<?php echo base_url() . 'public/manager/lib/sbadmin2/dist/js/sb-admin-2.js'; ?>"></script>
<script src="<?php echo base_url() . 'public/manager/js/loadingOverlay.js'; ?>"></script>
<script src="<?php echo base_url() . 'public/manager/js/jquery.mtz.monthpicker.js'; ?>"></script> 

<script type="text/javascript">
    $(function () {
    	var sidemenu_class = '.<?php echo $page_name; ?>';
        $(sidemenu_class).addClass("active-page");
        $(sidemenu_class).closest('ul').addClass("in"); //Open Collapsed side-menu
        $.get("<?php echo base_url() ?>Manager/procurement/reminder/q");
    });
</script>