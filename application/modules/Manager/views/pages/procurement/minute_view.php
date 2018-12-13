<style>
    .tabscontainer{
        width: 800px;
        margin: 0 auto;
    }
    ul.tabs{
        margin: 0px;
        padding: 0px;
        list-style: none;
    }
    ul.tabs li{
        background: none;
        color: #222;
        display: inline-block;
        padding: 10px 15px;
        cursor: pointer;
    }

    ul.tabs li.current{
        background: #ededed;
        color: #222;
    }

    .tab-content{
        display: none;
        background: #fff;
        padding: 15px;
    }

    .tab-content.current{
        display: inherit;
    }

    .card {
        margin-top: 1em;

    }

    .cardre {

        background: #4FC3F7;
        padding: 1px; 
        border-radius: 3px; 
        border: 1px solid #1A237E;
    }

    /* IMG displaying */
    .person-card {


    }
    .card-title{
        text-align: center;
        background: #8BC34A; 
        border: 1px solid white; 
        font-weight: bold;
    }
    .person-card .person-img{
        width: 10em;
        position: absolute;
        top: -5em;
        left: 50%;
        margin-left: -5em;
        border-radius: 100%;
        overflow: hidden;
        background-color: white;
    }

    .subject-info-box-1,
    .subject-info-box-2 {
        float: left;
        width: 45%;

        select {
            height: 200px;
            padding: 0;

            option {
                padding: 4px 10px 4px 10px;
            }

            option:hover {
                background: #EEEEEE;
            }
        }
    }

    .subject-info-arrows {
        float: left;
        width: 10%;

        input {
            width: 70%;
            margin-bottom: 5px;
        }
    }
    .badge-info{
        font-size: 14px;
        font-weight: bold;
    }


    /** SPINNER CREATION **/

    .loader {
        position: relative;
        text-align: center;
        margin: 15px auto 35px auto;
        z-index: 9999;
        display: block;
        width: 80px;
        height: 80px;
        border: 10px solid rgba(0, 0, 0, .3);
        border-radius: 50%;
        border-top-color: #000;
        animation: spin 1s ease-in-out infinite;
        -webkit-animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to {
            -webkit-transform: rotate(360deg);
        }
    }

    @-webkit-keyframes spin {
        to {
            -webkit-transform: rotate(360deg);
        }
    }


    /** MODAL STYLING **/

    .modal-content {
        border-radius: 0px;
        box-shadow: 0 0 20px 8px rgba(0, 0, 0, 0.7);
    }

    .modal-backdrop.show {
        opacity: 0.75;
    }

    .loader-txt {
        p {
            font-size: 13px;
            color: #666;
            small {
                font-size: 11.5px;
                color: #999;
            }
        }
    }

    #output {
        padding: 25px 15px;
        background: #222;
        border: 1px solid #222;
        max-width: 350px;
        margin: 35px auto;
        font-family: 'Roboto', sans-serif !important;
        p.subtle {
            color: #555;
            font-style: italic;
            font-family: 'Roboto', sans-serif !important;
        }
        h4 {
            font-weight: 300 !important;
            font-size: 1.1em;
            font-family: 'Roboto', sans-serif !important;
        }
        p {
            font-family: 'Roboto', sans-serif !important;
            font-size: 0.9em;
            b {
                text-transform: uppercase;
                text-decoration: underline;
            }
        }
    }
</style>
<div id="page-wrapper">
    <!--row-->
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb page-header">
                <li><a href="<?php echo base_url('manager/dashboard'); ?>">Dashboard</a></li>
                <li><a href="#">Procurement</a></li>
                <li><a href="#">Meeting</a></li>
                <li class="active breadcrumb-item"><i class="white-text" aria-hidden="true"></i> <?php echo ucwords($page_name); ?></li>
                <li><span class="glyphicon glyphicon-question-sign" data-toggle="modal" data-target="#helpModal"></span></li>

            </ol>
        </div>
    </div><!--end row-->
    <div class="row">
        <div class="col-lg-12">

            <div class="row d-flex align-items-center p-3 my-3 text-white-50">
                <div class="col-12 col-lg-6 col-sm-12 hidden" >                    
                    <select id="theme_selector" class="custom-select col-lg-6 col-sm-12">
                        <option value="arrows">Theme</option>
                        <option value="default">Default</option>
                        <option value="arrows">Arrows</option>
                        <option value="circles">Circles</option>
                        <option value="dots">Dots</option>
                    </select>
                </div>
                <div class="col-12 col-lg-6 col-sm-12">                   
                    <div class="btn-group col-lg-6 col-sm-12" role="group">
                        <!--button class="btn btn-secondary" id="prev-btn" type="button">Previous</button>
                        <button class="btn btn-secondary" id="next-btn" type="button">Next</button>
                        <button class="btn btn-danger" id="reset-btn" type="button">Reset Wizard</button-->
                    </div>
                </div>
            </div>

            <!-- SmartWizard html -->
            <div id="smartwizard">
                <ul>
                    <li><a href="#step-1">Step 1<br /><small>Add Members</small></a></li>
                    <li><a href="#step-2">Step 2<br /><small>How the meeting began</small></a></li>
                    <li><a href="#step-3">Step 3<br /><small>Item Discussions & Recommendations</small></a></li>
                    <li><a href="#step-4">Step 4<br /><small>A.O.B</small></a></li>
                    <li><a href="#step-5">Step 5<br /><small>Meeting Minute Preview</small></a></li>
                </ul>

                <div>
                    <div id="step-1" class="">

                        <h3 class="border-bottom border-gray pb-2">Step 1 Members</h3>
                        <div class="row col-md-12">
                            <div class="col-md-3">
                                <input type="text" class="form-control input-sm" id="memberName" placeholder="Name - Role" />
                            </div>
                            <div class="col-md-3">
                                <input type="email" class="form-control input-sm" id="memberEmail" placeholder="Email" />
                            </div>
                            <div class="col-md-2">
                                <input type="button" class="btn btn-success" value="Add" id="addMember"/>
                            </div>
                        </div>
                        <div class="row" style="padding: 10px;">
                            <div class="subject-info-box-1">
                                <h3>Members Present</h3>
                                <select multiple="multiple" id='lstBox1' class="form-control" style="height:300px;">
                                    <option>Loading Present Members...</option>

                                </select>

                            </div>

                            <div class="subject-info-arrows text-center" style="margin-top:150px;">
                                <input type='button' id='btnRight' value='>' class="btn btn-default" /><br />
                                <input type='button' id='btnLeft' value='<' class="btn btn-default" /><br />
                            </div>

                            <div class="subject-info-box-2">
                                <h3>Members Absent With Apology</h3>
                                <select multiple="multiple" id='lstBox2' class="form-control" style="height:300px;">
                                    <option>Loading Absent Members...</option>
                                </select>
                            </div>

                            <div class="clearfix"></div>
                        </div>

                    </div>
                    <div id="step-2" class="">
                        <h3 class="border-bottom border-gray pb-2">Step 2 Beginning of Meeting</h3>
                        <div>
                            <textarea id="Meeting_start" placeholder="Describe how the meeting Began" style="width:100%;"></textarea>
                        </div>
                    </div>
                    <div id="step-3" class="">
                        <h3 class="border-bottom border-gray pb-2">Step 3 Item Discussions & Recommendations</h3>
                        <div class="container2" style="margin-top: 1em;">

                            <div class="card person-card ">
                                <div class="card-body">

                                    <div class="row">

                                        <div class="form-group col-md-12">
                                            <input id="commodityName" style="height: 50px; font-size: 14px; width: 98%;" type="text" class="form-control" placeholder="Type name of Commodity...e.g Abacavir (ABC) 300mg Tabs" >
                                            <div id="first_name_feedback" class="invalid-feedback">

                                            </div>
                                            <div class="row SPINNER" style="display:none;">
                                                <img src="<?php echo base_url(); ?>public/spinner.gif" alt="Loading Please Wait, Please wait ..."> Loading Data...
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <span class="badge badge-info" style="margin-left:20px;"></span>                             
                                <span class="badge badge-info drugspan" style="margin-left:5px;"></span>  
                                <a style="margin-right:20px; display:none;" href="#tracker" class="btn btn-xs btn-primary tracker_drug pull-right" data-toggle="modal" id="tracker" data-target="#add_procurement_modal" data-drug_id=""> 
                                    <i class="fa fa-search" ></i> View Tracker
                                </a>
                                <div class="alert alert-success" style="width:500px; margin-left: 20px; display: none;"><i class="fa fa-check-circle-o"> Drug discussion and recommendation successfully saved!</i></div>

                            </div>
                            <div class="diskrec" style="display:none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card cardre" style="">
                                            <div class="card-body">
                                                <h5 class="card-title" style="">Previous Discussion</h5>
                                                <div class="form-group DISCUSSION" style="font-size:12px;">
                                                    Loading...
                                                </div>                       
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card cardre"> 
                                            <div class="card-body">
                                                <h5 class="card-title">Previous Recommendation</h5>
                                                <div class="form-group RECOMMENDATION" style="font-size:12px;">
                                                    Loading...
                                                </div>                      
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6" >
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <textarea  class="form-control" id="mdiscussion" placeholder="Discussion" required></textarea>                            
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card"> 
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <textarea  class="form-control" id="mrecommendations" placeholder="Reccommendation" required></textarea>                           
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <button class="btn btn-primary btn-lg" id="SaveCommodity" style="margin-left:30px;">Save</button>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                    <div id="step-4" class="">
                        <h3 class="border-bottom border-gray pb-2">Step 4 A.O.B</h3>
                        <div>
                            <textarea id="Aob" placeholder="Describe how the ended and Any AOBs" style="width:100%;"></textarea>
                        </div>                    
                    </div>
                    <div id="step-5" class="">                      
                        <h3 class="border-bottom border-gray pb-2">Step 5 Meeting Minute Preview</h3>
                        <div id="MINUTE">
                            <p><strong>MINUTES OF PROCUREMENT PLANNING MEETING HELD AT NASCOP ON <span id="meeting_date"></span> FROM 9.00 AM-2.00 PM</strong></p>
                            <p><strong> </strong></p>
                            <p><strong>Members present</strong></p>
                            <ol id="PRESENT">
                            </ol>

                            <p><strong> </strong></p>
                            <p><strong>Absent with Apologies</strong></p>
                            <ol id="ABSENT">
                            </ol>
                            <p> </p>
                            <p id="MeetingStart">The meeting was called to order by Dr Caroline Asin who welcomed members to the monthly procurement meeting. Kevin Marete from CHAI then took the members through the revised new version of the Procurement Planning tracker. Members were in agreement that the new tracker will make the pipeline monitoring of commodities much simpler and more effective. It was agreed that the new tracker will start being used in the next meeting concurrently with the tracker currently in use so as pilot it.</p>
                            <p> </p>
                            <p><strong>M</strong><strong>IN</strong><strong>U</strong><strong>T</strong><strong>E 2: STOCK STATUS PER PRODUCT AND REQUIRED DELIVERIES AND NEW PROCUREMENTS</strong></p>
                            <p><strong> </strong></p>
                            <table class="table table-bordered table-hover">
                                <tbody id="MINUTEBODY">               
                                </tbody>
                            </table>             
                            <p id="AOB" >This is AOB Section</p>                     
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <?php $this->load->view('pages/procurement/commodity_meeting_view'); ?>

    </div><!--end page wrapper--->

    <script type="text/javascript">

        $(document).ready(function () {

            meeting_id = "<?php echo $this->uri->segment(5); ?>";
            

            meeting_date = '';
            drug_id = '';
            loadMinute(meeting_id);
            loadMembers();
            $.getJSON("<?php echo base_url(); ?>Manager/Procurement/loadMeetingDate/" + meeting_id, function (resp) {
                meeting_date = resp[0].meeting_date;
                $('#meeting_date').text(meeting_date);
            });

            tinymce.init({
                selector: 'textarea',
                height: 200,
                theme: 'modern',
                plugins: 'print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help',
                toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
                image_advtab: true

            });

            $('#addMember').click(function () {
                list = $('#lstBox1');
                nameval = $('#memberName').val();
                emailval = $('#memberEmail').val();

                $.post('<?php echo base_url(); ?>Manager/Procurement/membersListAdd', {name: nameval, email: emailval}, function (resp) {
                    loadMembers();
                    $('#memberName').val('');
                    $('#memberEmail').val('');
                }, 'json').done(function () {
                    var present = $('#lstBox1 option');
                    var absent = $('#lstBox2 option');

                    var pvalues = $.map(present, function (option) {
                        return option.value;
                    });
                    var avalues = $.map(absent, function (option) {
                        return option.value;
                    });

                    $.post('<?php echo base_url(); ?>Manager/Procurement/memberUpdates', {present: pvalues, absent: avalues}, function (resp) {

                    }, 'json');
                });



            });

            $("#lstBox1").dblclick(function () {
                $('#lstBox1 option:selected').remove();
            });
            $("#lstBox2").dblclick(function () {
                $('#lstBox2 option:selected').remove();
            });


        });

        function loadMinute(id) {
            $.getJSON('<?php echo base_url(); ?>Manager/Procurement/loadMinute/' + id, function (resp) {
                console.log(resp[0].start)
                tinymce.get('Meeting_start').setContent(resp[0].start);
                tinymce.get('Aob').setContent(resp[0].aob);

            });
        }


        function loadMembers() {
            $.getJSON('<?php echo base_url(); ?>Manager/Procurement/getEmails/x', function (resp) {
                present = $('#lstBox1');
                absent = $('#lstBox2');
                present.empty();
                absent.empty();

                $.each(resp.present, function (i, j) {
                    present.append('<option value="' + j.email + '">' + j.name + '</option>');
                });
                $.each(resp.absent, function (i, j) {
                    absent.append('<option value="' + j.email + '">' + j.name + '</option>');
                });

            });
        }

        (function () {
            $('#SaveCommodity').click(function (e) {

                disc = tinymce.get('mdiscussion').getContent();
                rec = tinymce.get('mrecommendations').getContent();
                saveDiscussionItem(meeting_id, disc, rec, meeting_date, drug_id);

            });

            $('#btnRight').click(function (e) {
                var selectedOpts = $('#lstBox1 option:selected');
                if (selectedOpts.length == 0) {
                    alert("Nothing to move.");
                    e.preventDefault();
                }

                $('#lstBox2').append($(selectedOpts).clone());
                $(selectedOpts).remove();
                e.preventDefault();
            });
            $('#btnAllRight').click(function (e) {
                var selectedOpts = $('#lstBox1 option');
                if (selectedOpts.length == 0) {
                    alert("Nothing to move.");
                    e.preventDefault();
                }

                $('#lstBox2').append($(selectedOpts).clone());
                $(selectedOpts).remove();
                e.preventDefault();
            });
            $('#btnLeft').click(function (e) {
                var selectedOpts = $('#lstBox2 option:selected');
                if (selectedOpts.length == 0) {
                    alert("Nothing to move.");
                    e.preventDefault();
                }

                $('#lstBox1').append($(selectedOpts).clone());
                $(selectedOpts).remove();
                e.preventDefault();
            });
            $('#btnAllLeft').click(function (e) {
                var selectedOpts = $('#lstBox2 option');
                if (selectedOpts.length == 0) {
                    alert("Nothing to move.");
                    e.preventDefault();
                }

                $('#lstBox1').append($(selectedOpts).clone());
                $(selectedOpts).remove();
                e.preventDefault();
            });
        }(jQuery));
        $(document).ready(function () {

            var options = {

                url: function (phrase) {
                    return "<?php echo base_url() . 'Manager/Procurement/getDrugsByName'; ?>";
                },
                getValue: function (element) {
                    return element.name + ' - (' + element.pack_size + 's)-' + element.drug_category;
                },
                ajaxSettings: {
                    dataType: "json",
                    method: "POST",
                    data: {
                        dataType: "json"
                    }
                },
                list: {
                    onChooseEvent: function () {
                        $('#tracker').attr('data-drug_id', '');
                        var selectedItemId = $("#commodityName").getSelectedItemData().id;
                        var selectedItemValue = $("#commodityName").getSelectedItemData().name;
                        drug_id = selectedItemId;
                        $('#tracker').attr('data-drug_id', selectedItemId);
                        // $('.alert-success').hide('slow');
                        $('.SPINNER').show();
                        $.getJSON("<?php echo base_url() . 'Manager/Procurement/getDecision/'; ?>" + selectedItemId, function (resp) {

                            if (resp.length <= 0) {
                                $('.diskrec').show('slow');
                                $('.badge-info').html('No Data Found');
                                $('.drugspan').html('Drug: ' + selectedItemValue);
                                $('.DISCUSSION').html('No Data Found');
                                $('.RECOMMENDATION').html('No Data Found');
                                $('.SPINNER').hide();
                                $('#tracker').show();
                            } else {
                                $('.diskrec').show('slow');
                                $('.DISCUSSION').html(resp[0].discussion);
                                $('.RECOMMENDATION').html(resp[0].recommendation);
                                $('.badge-info').html('Previous Discussion Date: ' + resp[0].decision_date);
                                $('.drugspan').html('Drug: ' + selectedItemValue);
                                $('.SPINNER').hide();
                                $('#tracker').show();
                            }
                        });
                    },
                    onHideListEvent: function () {


                    }
                },
                preparePostData: function (data) {
                    data.phrase = $("#commodityName").val();
                    //data.category = $("#commodityCategory").val();
                    return data;
                },
                requestDelay: 400
            };
            $("#commodityName").easyAutocomplete(options);
            // Step show event
            $("#smartwizard").on("showStep", function (e, anchorObject, stepNumber, stepDirection, stepPosition) {
                // alert(stepNumber)
                $(".FinNish").addClass('disabled');
                $(".FinNish").css('display', 'block');
                $(".Email").addClass('disabled');
                var present = $('#lstBox1 option');
                var absent = $('#lstBox2 option');
                var pvalues = $.map(present, function (option) {
                    return option.text;
                });
                var avalues = $.map(absent, function (option) {
                    return option.text;
                });
                $('#PRESENT,#ABSENT').empty();

                $.each(pvalues, function (i, j) {
                    $('#PRESENT').append('<li>' + j + '</li>')
                });

                $.each(avalues, function (i, j) {
                    $('#ABSENT').append('<li>' + j + '</li>')
                });

                if (stepNumber === 1) {
                    var present = $('#lstBox1 option');
                    var absent = $('#lstBox2 option');

                    var pvalues = $.map(present, function (option) {
                        return option.value;
                    });
                    var avalues = $.map(absent, function (option) {
                        return option.value;
                    });
                    $.post('<?php echo base_url(); ?>Manager/Procurement/memberUpdates', {present: pvalues, absent: avalues}, function (resp) {

                    }, 'json');
                }

                if (stepNumber === 4) {
                    $(".FinNish").removeClass('disabled');
                    $('#MeetingStart').html(tinymce.get('Meeting_start').getContent());
                    $('#AOB').html(tinymce.get('Aob').getContent());
                    $.get('<?php echo base_url(); ?>Manager/Procurement/loadMinutes/' + meeting_id, function (resp) {
                        $('#MINUTEBODY').empty();
                        $('#MINUTEBODY').append(resp);
                    });
                }

                if (stepNumber === 5) {
                    $('.FinNish').css('display', 'none');
                }



                if (stepPosition === 'first') {
                    $("#prev-btn").addClass('disabled');

                } else if (stepPosition === 'final') {

                    $("#next-btn").addClass('disabled');
                } else {
                    $("#prev-btn").removeClass('disabled');
                    $("#next-btn").removeClass('disabled');
                }
            });
            // Toolbar extra buttons
            var btnFinish = $('<button></button>').text('Save')
                    .addClass('btn btn-info FinNish')
                    .on('click', function () {
                        minute_data = $('#MINUTE').html();
                        saveMinute(minute_data, meeting_id);
                    });

            // Smart Wizard
            $('#smartwizard').smartWizard({
                selected: 0,
                theme: 'arrows',
                transitionEffect: 'fade',
                keyNavigation: true,
                showStepURLhash: true,
                toolbarSettings: {
                    toolbarPosition: 'both',
                    toolbarButtonPosition: 'right',
                    toolbarExtraButtons: [btnFinish]
                }
            });
            // External Button Events
            $("#reset-btn").on("click", function () {
                // Reset wizard
                $('#smartwizard').smartWizard("reset");
                return true;
            });
            $("#prev-btn").on("click", function () {
                // Navigate previous
                $('#smartwizard').smartWizard("prev");
                return true;
            });
            $("#next-btn").on("click", function () {
                // Navigate next
                $('#smartwizard').smartWizard("next");
                return true;
            });
            $("#theme_selector").on("change", function () {
                // Change theme
                $('#smartwizard').smartWizard("theme", $(this).val());
                return true;
            });
            // Set selected theme on page refresh
            $("#theme_selector").change();
        });

        saveMinute = function (data, id) {
            var spinHandle = loadingOverlay.activate();
            meeting_start = tinymce.get('Meeting_start').getContent();
            aob = tinymce.get('Aob').getContent();

            $.post('<?php echo base_url(); ?>Manager/Procurement/updateMinutes/' + id, {minute: data, start: meeting_start, aob: aob}, function () {
                loadingOverlay.cancel(spinHandle);
                swal({
                    title: "Minute Saved",
                    text: "Minute has been saved, do you want to dispatch emails!",
                    icon: "success",
                    buttons: true,
                    dangerMode: false,
                })
                        .then((sendEmail) => {
                            if (sendEmail) {
                                var spinHandle = loadingOverlay.activate();
                                $.getJSON('<?php echo base_url(); ?>Manager/Procurement/generateMinute/' + id, function (resp) {
                                    if (resp.status == 'success') {
                                        loadingOverlay.cancel(spinHandle);
                                        swal("Meeting Minutes Saved and emails dispatched to all members", {
                                            icon: "success",
                                        });
                                    } else {

                                    }

                                });

                            } else {
                                swal("You can still go back and make changes if necessary ");
                            }
                        });
            });
        };

        saveDiscussionItem = function (id, disc, rec, mdt, drug_id) {
            $.post('<?php echo base_url(); ?>Manager/Procurement/postDiscussions/', {mid: id, disc: disc, rec: rec, mdt: mdt, drug_id: drug_id}, function () {
                swal({
                    title: "Data Saved!",
                    text: "Item Data Successfully Saved",
                    icon: "success",
                });
                // $('.alert-success').show('slow');
                $('#commodityName').val('');
                $('.diskrec').hide('slow');
                $('.badge-info').html('');
                $('.drugspan').html('');
                tinymce.get('mdiscussion').setContent('');
                tinymce.get('mrecommendations').setContent('');
            }, 'json');
        };


    </script>

