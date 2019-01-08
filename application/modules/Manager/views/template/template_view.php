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

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Upload Template</h4>
                </div>
                <div class="modal-body">
                    <form id="myform" method="post">
                        <div class="form-group">
                            <input  type="file" id="myfile" />
                        </div>
                        <div class="form-group">
                            <div class="progress">
                                <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
                            </div>

                            <div class="msg"></div>

                        </div>

                        <input type="button" id="btn" class="btn-success" value="Upload" />
                    </form>
                </div>
                <!--                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>-->
            </div>

        </div>
    </div>
    <script>
        $(function () {
            $('#btn').click(function () {
                $('.myprogress').css('width', '0');
                $('.msg').text('');
                $('#PROGRESS').show();

                var formData = new FormData();
                formData.append('myfile', $('#myfile')[0].files[0]);
                formData.append('filename', 'inventory');
                $('#btn').attr('disabled', 'disabled').hide();
                img = '<img src="<?php echo base_url(); ?>public/spinner.gif" width="50px"/>';
                $('.msg').html(img + " Updating Template Please Wait...");
                $.ajax({
                    url: "<?php echo base_url(); ?>Manager/Orders/upload",
                    data: formData,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    // this part is progress bar
                    xhr: function () {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                percentComplete = parseInt(percentComplete * 100);
                                $('.myprogress').text(percentComplete + '%');
                                $('.myprogress').css('width', percentComplete + '%');
                            }
                        }, false);
                        return xhr;
                    },
                    success: function (data) {
                        alert(data)
                        if (data === 'Template Successfully Uploaded') {
                            $('.msg').html('');
                            $('.msg').html('');
                            $('.msg').html(data);
                            $('#btn').addAttr('disabled');
                        } else {
                            $('.myprogress').css('width', '0');
                            $('.msg').html('');
                            $('.msg').html('');
                            $('.msg').html(data);
                            $('.myprogress').text(0 + '%');
                            $('#btn').show();
                            $('#btn').removeAttr('disabled');

                        }
                    }
                });
            });
        })
    </script>
</html>