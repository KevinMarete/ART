<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="NASCOP">
        <meta name="author" content=NASCOP"">
        <title><?php echo ucwords(str_replace('_', ' ', $page_title)); ?></title>
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
    
    <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="helpModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Help Manual</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Help Narrative              
            </div>
           
        </div>
    </div>
</div>
</html>