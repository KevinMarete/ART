<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <!--<title>elFinder 2.1.x source version with PHP connector</title>-->
        <title><?php echo $page_title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2" /> 
        <!-- elFinder initialization (REQUIRED) -->
        <?php $this->load->view('styles_view'); ?>
        <?php echo "<script>path = '" . base_url() . "'</script>" ?>
        <script type="text/javascript" charset="utf-8">
            // Documentation for client options:
            // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
            $(document).ready(function () {
                if (navigator.onLine) { // true|false
                    $.notify('Connection Active, Intitalizing...', 'success');
                } else {
                    $.notify('You are offline Please go online and refresh page.., ', 'error');
                }
                $('#elfinder').elfinder({
                    url: path + 'public/ftp/file_manager/php/connector.minimal.php' // connector URL (REQUIRED)
                });
            });

        </script>
    </head>
    <body>
        <!--navbar-->
        <?php $this->load->view('navbar_view'); ?>
        <!-- Element where elFinder will be created (REQUIRED) -->
        <div id="elfinder"></div>
        <?php $this->load->view('scripts_view'); ?>
    </body>
</html>