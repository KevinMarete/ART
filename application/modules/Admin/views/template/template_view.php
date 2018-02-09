<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="NASCOP">
    <meta name="author" content=NASCOP"">
    <title><?php echo $page_title; ?></title>
    <!--Styles-->
    <?php $this->load->view('styles_view'); ?>
</head>
<body>
    <div id="wrapper">
        <!-- Navigation -->
        <?php $this->load->view('navbar_view'); ?>
        <!-- Content -->
        <?php $this->load->view($content_view); ?>
    </div>
    <!--Scripts-->
    <?php $this->load->view('scripts_view'); ?>
</body>
</html>