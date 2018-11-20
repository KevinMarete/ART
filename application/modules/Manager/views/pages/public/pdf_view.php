<!DOCTYPE html>
<html lang="en">
    <head>
        <style>
            table {table-layout: fixed;width:1000px; padding:10px;}
            th {text-align: left; background-color: #4CAF50;color: white; height: 50px;}
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12 ">
                    <div class=" panel panel-default">
                        <div class="panel-heading text-center">
                            <h3 class="panel-title"><b>PROCUREMENT PLANNING MEETING MINUTE</b></h3>
                        </div>
                        <div class="panel-body" id="panel-head" >
                            <div id="step-5" class="">
                                <?php echo html_entity_decode($minutes[0]->minute); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
