<div id="page-wrapper">
    <!--row-->
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb page-header">
                <li><a href="<?php echo base_url('manager/dashboard'); ?>">Dashboard</a></li>
                <li><a href="#">Minute</a></li>
                <li class="active breadcrumb-item"><i class="white-text" aria-hidden="true"></i> <?php echo ucwords($page_name); ?></li>
                <li><span class="glyphicon glyphicon-question-sign" data-toggle="modal" data-target="#helpModal"></span></li>
                <?php echo $this->session->flashdata('tracker_msg'); ?>
            </ol>
        </div>
    </div><!--end row-->
    <!--row-->
    <div class="row">
        <div class="col-lg-12">
             <textarea>Next, use our Get Started docs to setup Tiny!</textarea>
        </div>
    </div><!--end row-->
</div><!--end page wrapper--->

  <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
  <script>
      $(function(){
      tinymce.init({ selector:'textarea' });
  });
    </script>

</script>
