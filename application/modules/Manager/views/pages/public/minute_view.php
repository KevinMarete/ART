<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="NASCOP">

        <title><?php echo $page_title; ?></title>

        <!-- Bootstrap Core CSS -->
        <link href="<?php echo base_url() . 'public/manager/lib/sbadmin2/vendor/bootstrap/css/bootstrap.min.css'; ?>" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="<?php echo base_url() . 'public/manager/lib/sbadmin2/vendor/metisMenu/metisMenu.min.css'; ?>" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="<?php echo base_url() . 'public/manager/lib/sbadmin2/dist/css/sb-admin-2.css'; ?>" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="<?php echo base_url() . 'public/manager/lib/sbadmin2/vendor/font-awesome/css/font-awesome.min.css'; ?>" rel="stylesheet" type="text/css">

        <!--favicon-->
        <link href="<?php echo base_url() . 'public/dashboard/img/favicon.ico'; ?>" rel="shortcut icon" type="text/css" >

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body oncontextmenu="return false" onkeydown="return false;" onmousedown="return false;">
        <style>
            #panel-header{
                -webkit-filter: blur(10px); /* Chrome, Opera, etc. */
                filter: url('blur.svg#blur'); /* Older FF and others - http://jordanhollinger.com/media/blur.svg */
                filter: blur(10px); /* Firefox 35+, eventually all */
            }
        </style>

        <div class="container">
            <div class="row">
                <div class="col-md-12 ">
                    <div class=" panel panel-default">
                        <div class="panel-heading text-center">
                            <img src="<?php echo base_url() . 'public/manager/img/nascop_logo.png'; ?>" class="img-responsive center-block" alt="nascop">
                            <h3 class="panel-title"><b>PROCUREMENT PLANNING MEETING MINUTE</b></h3>
                            <?php echo $this->session->flashdata('user_msg'); ?>
                        </div>
                        <div class="panel-body" id="panel-header" >
                            <div id="step-5" class="">
                                <p><strong>MINUTES OF PROCUREMENT PLANNING MEETING HELD AT NASCOP ON 13/9/2018 FROM 9.00 AM-1.00 PM</strong></p>
                                <p><strong> </strong></p>
                                <p><strong>Members present</strong></p>
                                <ol start="16">
                                    <li>Carol Asin-NASCOP-Chairperson</li>
                                    <li>Dr Peter Mwangi- KEMSA</li>
                                    <li>Charles Lwanga-USAID</li>
                                    <li>Douglas Onyancha- KEMSA</li>
                                    <li>Alex Kinoti- USAID</li>
                                    <li>Evelyn Wachuka- KEMSA</li>
                                    <li>Regina Mucuha-NASCOP</li>
                                    <li>Christine Malati- USAID/WASHINGTON</li>
                                    <li>John Kabuchi-KEMSA</li>
                                    <li>James Batuka- USAID</li>
                                    <li>Edward Musau- NASCOP</li>
                                    <li>Alphonse Ochieng- CHAI</li>
                                    <li>Kevin Marete- CHAI</li>
                                    <li>Nelius Mwangi- NASCOP</li>
                                    <li>Laura Oyiengo- NASCOP</li>
                                    <li>Roseline Warutere- NASCOP<strong><br /></strong></li>
                                </ol>
                                <p><strong> </strong></p>
                                <p><strong>Absent with Apologies</strong></p>
                                <ol>
                                    <li>Dr Evans Imbuki.</li>
                                    <li>Claire Obonyo-TNT</li>
                                    <li>Margaret Ndubi-TNT</li>
                                </ol>
                                <p> </p>
                                <p>The meeting was called to order by Dr Caroline Asin who welcomed members to the monthly procurement meeting. Kevin Marete from CHAI then took the members through the revised new version of the Procurement Planning tracker. Members were in agreement that the new tracker will make the pipeline monitoring of commodities much simpler and more effective. It was agreed that the new tracker will start being used in the next meeting concurrently with the tracker currently in use so as pilot it.</p>
                                <p> </p>
                                <p><strong>M</strong><strong>IN</strong><strong>U</strong><strong>T</strong><strong>E 2: STOCK STATUS PER PRODUCT AND REQUIRED DELIVERIES AND NEW PROCUREMENTS</strong></p>
                                <p><strong> </strong></p>
                                <table class="table table-bordered table-hover">
                                    <tbody>
                                        <tr>
                                            <td width="193">
                                                <p><strong>Product</strong></p>
                                            </td>
                                            <td width="358">
                                                <p><strong>Discussion</strong></p>
                                            </td>
                                            <td width="350">
                                                <p><strong>Recommendations</strong></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" width="901">
                                                <p><strong>Antiretroviral therapy</strong></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Abacavir (ABC) 300mg Tabs</p>
                                            </td>
                                            <td width="358">
                                                <p>The product is at less than 1MOS. Projected to deplete with the September 2018 issues.</p>
                                                <p>To withhold issuance of FDC and encourage redistribution of the single formulations.</p>
                                            </td>
                                            <td width="350">
                                                <p>FDC (ABC/3TC) 600/300mg stocks available at KEMSA and distribution projected to begin from November 2018, with review.</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Abacavir/Lamivudine</p>
                                                <p>(ABC/3TC)120/60mg FDC Tabs</p>
                                            </td>
                                            <td width="358">
                                                <p> </p>
                                                <p>Product is at 4.8 months of stock.</p>
                                                <p>760,372 more packs under GF expected in September.</p>
                                                <p> </p>
                                            </td>
                                            <td width="350">
                                                <p> </p>
                                                <p>Monitor stocks.</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Abacavir/Lamivudine</p>
                                                <p>(ABC/3TC)600/300mg FDC Tabs</p>
                                            </td>
                                            <td width="358">
                                                <p>KEMSA has started received this product, with 75K packs delivered in Aug 2018 and 24,275 packs in Sept</p>
                                            </td>
                                            <td width="350">
                                                <p>The rest of the consignment expected in Sep</p>
                                                <p>The commodities team to verify how much of the SD ABC’s and 3TC’ is at facilities to curb any gap</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Atazanavir/Ritonavir (ATV/r) 300/100mg tabs</p>
                                            </td>
                                            <td width="358">
                                                <p> </p>
                                                <p>There is a Procurement of 500,000 packs under USAID</p>
                                                <p> </p>
                                                <p> </p>
                                            </td>
                                            <td width="350">
                                                <p> </p>
                                                <p>This was to factor in transition of clients on LPV/R 200/50mg</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Dolutegravir 50mg</p>
                                                <p> </p>
                                            </td>
                                            <td width="358">
                                                <p>Product was stocked out as at end August 2018. KEMSA received 10,000 packs in early September</p>
                                                <p> </p>
                                            </td>
                                            <td width="350">
                                                <p> </p>
                                                <p>Review delivery schedule for pending quantity of 100K in view of availability of TLD FDC</p>
                                                <p> </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Efavirenz (EFV)</p>
                                                <p>200mg Tabs</p>
                                            </td>
                                            <td width="358">
                                                <p>Product is at 13 MOS</p>
                                                <p>Delivery of 100,000 packs will be done in October 2018</p>
                                                <p> </p>
                                            </td>
                                            <td width="350">
                                                <p> </p>
                                                <p>Majority of children using NVP tablets adult will be moved to EFV 200mg and the consumptions is projected to go up, with this transition.</p>
                                                <p>To be monitored closely with the release of revised ARTguidelines</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Efavirenz (EFV)</p>
                                                <p>600mg Tabs</p>
                                                <p> </p>
                                            </td>
                                            <td width="358">
                                                <p>The product is at 2MOS</p>
                                                <p>There are no pending deliveries, stocks projected to deplete from KEMSA in October 2018.</p>
                                                <p> </p>
                                            </td>
                                            <td width="350">
                                                <p> </p>
                                                <p>KEMA confirmed on distribution of TLD which has started based on the quantities agreed upon for smart push in the monthly Order management planning meeting.</p>
                                                <p> </p>
                                                <p>USAID will advise the implementing partners to train facility staff on new ART guidelines implementation to avoid stocks crisis</p>
                                                <p> </p>
                                                <p> </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Lamivudine (3TC) 150mg Tabs</p>
                                            </td>
                                            <td width="358">
                                                <p>Is at 5 MOS</p>
                                                <p>No pending stocks</p>
                                                <p>Product is on phase out with the last consignment projected to be shipped out of KEMSA in November 2018.</p>
                                            </td>
                                            <td width="350">
                                                <p> </p>
                                                <p>To monitor available stocks at facility level, in line with ABC 300mg stocks</p>
                                                <p> </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Lamivudine (3TC)</p>
                                                <p>liquid 10mg/ml</p>
                                            </td>
                                            <td width="358">
                                                <p>Good MOS</p>
                                                <p> </p>
                                            </td>
                                            <td width="350">
                                                <p>To monitor available stock as it is used by patients with renal problems</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Lopinavir/ritonavir (LPV/r) 200/50mg Tabs</p>
                                            </td>
                                            <td width="358">
                                                <p> </p>
                                                <p>MOS is at 3 MOS as at end September 2018</p>
                                                <p>Product also on proposed phase out and there are no pending stocks</p>
                                                <p>The clinical team was proposing for stocks to retain the current patients on LPV/r and this will have negative implications on the already contracted quantities for ATV/r that factored a transition of all clients to ATV/r.</p>
                                                <p>The clinical team needs to give a justification for procurement of stocks to sustain continuing patients</p>
                                            </td>
                                            <td width="350">
                                                <p> </p>
                                                <p>A rational assumption will be determined by the clinical team to see how many patients will not tolerate the ATV/r and will need a few packs of the LPV/r.</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Lopinavir/ritonavir (LPV/r) liquid 80/20mg/ml</p>
                                            </td>
                                            <td width="358">
                                                <p>Product is at 11 MOS</p>
                                                <p>31,458 bottles expected under GF-NFM Yr 2. 20,000 packs were delivered in June and 11,458 Packs to come in Jan 2019. Need to review the delivery schedule for the pending stocks with re-introduction of pellets</p>
                                            </td>
                                            <td width="350">
                                                <p> </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Lopinavir/ritonavir</p>
                                                <p>(LPV/r )pellets</p>
                                                <p>40/10mg capsules</p>
                                            </td>
                                            <td width="358">
                                                <p>Discussions on the procurement to be done in a different meeting later in the afternoon.</p>
                                                <p>35,000 pending supplies, with 5000 already committed for delivery in November 2018.</p>
                                            </td>
                                            <td width="350">
                                                <p>Has been out of stock for several months</p>
                                                <p> </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Lopinavir/ritonavir (LPV/r ) 100/25mg</p>
                                            </td>
                                            <td width="358">
                                                <p>Product at 8.9 MOS,</p>
                                                <p>To monitor the issues trends and consumption.</p>
                                                <p>With the projected issues of approximately 12,000 packs per month, there is need to plan for a new procurement. (100,000 packs were proposed for procurement)</p>
                                                <p> </p>
                                                <p> </p>
                                            </td>
                                            <td width="350">
                                                <p> </p>
                                                <p>Product has been stocked out for some time and was restocked in July 2018.</p>
                                                <p> </p>
                                                <p> </p>
                                                <p> </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p> </p>
                                                <p>Nevirapine (NVP)</p>
                                                <p>200mg Tabs</p>
                                            </td>
                                            <td width="358">
                                                <p>Product at less than 1 MOS</p>
                                                <p>Is a transition product</p>
                                                <p>There are no pending stocks and the product is expected to get depleted at KEMSA in September 2018</p>
                                                <p> </p>
                                                <p> </p>
                                                <p> </p>
                                            </td>
                                            <td width="350">
                                                <p>Clinical team to be notified of this red flag.</p>
                                                <p>Transition of eligible patients on TLN needs to be fast-tracked with the release of guidelines</p>
                                                <p>Facility stocks need to be determined in view of transition (OMP team) and advise clinical team accordingly</p>
                                                <p>Facilities to be issued with some TLD stocks.</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Nevirapine (NVP) Suspension 10mg/ml</p>
                                            </td>
                                            <td width="358">
                                                <p> </p>
                                                <p>Product is at 17 MOS</p>
                                            </td>
                                            <td width="350">
                                                <p>Need to fast-track GF procurement so as to have stocks at KEMSA by Jan 2019.</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Tenofovir (TDF) 300mg Tabs</p>
                                            </td>
                                            <td width="358">
                                                <p>Requested for 1000 packs under USAID</p>
                                            </td>
                                            <td width="350">
                                                <p>Need to hasten reverse logistics for quantities erroneously distributed</p>
                                                <p> </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Tenofovir/ Lamivudine (TDF/3TC) FDC (300/300mg) Tabs</p>
                                            </td>
                                            <td width="358">
                                                <p>Product is at 1MOS as at end Aug 2018</p>
                                                <p>There were proposals for the program to consider procurement of the 90’s pack size which has less cost implications compared to the pack size of 30’s. The same applies for the TLE.  However, the 90’s packaging is larger in size and may inconvenience some patients</p>
                                                <p>KEMSA reported that manufacturer had an issue with Lamivudine API, which delayed delivery of 200k packs.</p>
                                                <p> </p>
                                                <p> </p>
                                                <p> </p>
                                            </td>
                                            <td width="350">
                                                <p>More need to be procured urgently; Proposed 600K packs under USAID, with delivery planned for October 2018.  </p>
                                                <p>These stocks to support transition and patients on 2<sup>nd</sup> line</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Tenofovir</p>
                                                <p>/Emtricitabine</p>
                                                <p>(TDF/FTC) Tablets</p>
                                                <p>300/200mg, packs</p>
                                            </td>
                                            <td width="358">
                                                <p>Was stocked out as at end August 2018 (15,416 packs received in August under Jillinde were all distributed in August.</p>
                                                <p>KEMSA received 12000 packs in early Sept 2018 and the balance to be delivered (188,000) as at end October 2018.</p>
                                                <p>62,697 under Jillinde expected in November 2018.</p>
                                                <p> </p>
                                                <p> </p>
                                            </td>
                                            <td width="350">
                                                <p> </p>
                                                <p>KEMSA to expedite on pending deliveries.</p>
                                                <p> </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Tenofovir/Lamivudine/ Efavirenz(TDF/3TC/EFV)</p>
                                                <p>FDC(300/300/600mg) Tabs</p>
                                            </td>
                                            <td width="358">
                                                <p>At 2 MOS</p>
                                                <p>3M packs of TLE 600mg are awaiting contracting but with discussions on whether to split the procurement against the TLE 400mg</p>
                                                <p>Procurement of TLE 400mg has been initiated. and contracted.</p>
                                            </td>
                                            <td width="350">
                                                <p>Product was previously earmarked for total transition, but needed for a particular patient cohort</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Tenofovir/ Lamivudine/ Efavirenz (TDF/3TC/EFV)</p>
                                                <p>FDC(300/300/400mg) Tabs</p>
                                            </td>
                                            <td width="358">
                                                <p> </p>
                                                <p>Last distribution was done in May 2018, for Nairobi County.</p>
                                                <p> </p>
                                            </td>
                                            <td width="350">
                                                <p> </p>
                                                <p>An emergency procurement of 600k packs of TLE 400mg for women of reproductive potential in Nairobi County who are currently on TLE 400mg has been initiated.</p>
                                                <p>200K initial packs expected for distribution in September 2018. </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Tenofovir/ Lamivudine/ Dolutegravir (TDF/3TC/DTG) FDC (300/300/50mg)</p>
                                            </td>
                                            <td width="358">
                                                <p>Is available at KEMSA</p>
                                                <p> </p>
                                                <p>3M packs under USAID put on hold in view of the advisory on its use</p>
                                                <p> </p>
                                            </td>
                                            <td width="350">
                                                <p> </p>
                                                <p>The OMT worked out on facility-stocks for smart push distribution in September</p>
                                                <p> </p>
                                                <p>A team to input projected consumption data on the tracker</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Zidovudine (AZT) liquid 10mg/ml</p>
                                            </td>
                                            <td width="358">
                                                <p> </p>
                                                <p>Product is at 1.3MOS</p>
                                                <p>Available stocks both at facility and KEMSA to be monitored.</p>
                                                <p> </p>
                                            </td>
                                            <td width="350">
                                                <p> </p>
                                                <p>50k packs under USAID expected in October were pushed for delivery to 30<sup>th</sup> November 2018.</p>
                                                <p>KEMSA to negotiate with the supplier whether they can avail some stocks before November 2018</p>
                                                <p>Available stocks to be monitored.</p>
                                                <p>GF procurement should be fast-tracked to have stocks in Jan 2018</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Zidovudine 300mg</p>
                                            </td>
                                            <td width="358">
                                                <p>Is at 5MOS.</p>
                                                <p>Proposing a procurement of 1,000 packs under USAID.</p>
                                            </td>
                                            <td width="350">
                                                <p>Continue monitoring the stocks</p>
                                                <p> </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Zidovudine/Lamivudine (AZT/3TC) FDC (300/150mg) Tabs</p>
                                            </td>
                                            <td width="358">
                                                <p>One of the products being phased out as first line.</p>
                                                <p>Current MOS is 10 MOS</p>
                                            </td>
                                            <td width="350">
                                                <p>Consumption will reduce at some point when the transition begins.</p>
                                                <p>Advice on roll out process after guidelines launch</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Zidovudine/Lamivudine (AZT/3TC) FDC (60/30mg) Tabs</p>
                                            </td>
                                            <td width="358">
                                                <p> </p>
                                                <p> </p>
                                                <p> </p>
                                                <p> </p>
                                            </td>
                                            <td width="350">
                                                <p> </p>
                                                <p>Some stocks are at risk of expiry due to diminishing uptake.</p>
                                                <p>More stocks under GF will be required for 2<sup>nd</sup> line use beyond 2019</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Zidovudine/Lamivudine ne/Nevirapine (AZT/3TC/NVP)</p>
                                                <p>FDC 300/150/200mg) Tabs</p>
                                            </td>
                                            <td width="358">
                                                <p> </p>
                                                <p>Is at 6 MOS</p>
                                                <p> </p>
                                                <p>No other procurements for this product</p>
                                            </td>
                                            <td width="350">
                                                <p>To monitor stock levels in preparation for transition</p>
                                                <p>Product on phase out</p>
                                                <p> </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Zidovudine/ Lamivudine/Nevirapine (AZT/3TC/NVP) FDC (60/30/50mg) tabs</p>
                                            </td>
                                            <td width="358">
                                                <p>At 41 MOS.</p>
                                                <p>There were challenges in identifying a recipient for donations through CHAI, since majority of countries are embracing new WHO guidelines and moving away from the product for pediatrics.</p>
                                                <p>There are no pending deliveries but the product is at risk of expiries (estimated 220k packs at risk).</p>
                                            </td>
                                            <td width="350">
                                                <p>Issues from KEMSA declined to an average of 7,700 (Jan to July 2018)</p>
                                                <p>TNT to submit justification on high MOS to GF (220k at risk of expiry)</p>
                                                <p> </p>
                                                <p> </p>
                                                <p> </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Raltegravir 400mg</p>
                                            </td>
                                            <td width="358">
                                                <p>Available stocks at KEMSA were 71 packs as at end August 2018.</p>
                                                <p>The program to consider use of DTG to Raltegravir 400mg.</p>
                                                <p>USAID to procure 1,000 packs (in proposal)</p>
                                                <p> </p>
                                            </td>
                                            <td width="350">
                                                <p>KEMSA to expedite GF procurements.</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Raltegravir 100mg</p>
                                            </td>
                                            <td width="358">
                                                <p>Call done for pending quantity (80)</p>
                                                <p>79 packs available at KEMSA</p>
                                                <p> </p>
                                            </td>
                                            <td width="350">
                                                <p>Stock to be monitored to prevent future stock outs.</p>
                                                <p>Will be phased out to introduce the granules</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Raltegravir 25mg</p>
                                            </td>
                                            <td width="358">
                                                <p>Call done for pending quantity (200)</p>
                                                <p>50 packs available at KEMSA</p>
                                            </td>
                                            <td width="350">
                                                <p>Stock to be monitored to prevent future stock outs.</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Darunavir 600mg</p>
                                            </td>
                                            <td width="358">
                                                <p>KEMSA received some stocks</p>
                                                <p>To monitor stocks</p>
                                                <p> </p>
                                            </td>
                                            <td width="350">
                                                <p> </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Darunavir 150mg</p>
                                            </td>
                                            <td width="358">
                                                <p>Donation product</p>
                                            </td>
                                            <td rowspan="3" width="350">
                                                <p>Program following up on import permit.</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Darunavir 75 mg</p>
                                            </td>
                                            <td width="358">
                                                <p>Donation product</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Etraverine 100mg</p>
                                            </td>
                                            <td width="358">
                                                <p>Donation product</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Ritonavir syrup</p>
                                            </td>
                                            <td width="358">
                                                <p> </p>
                                                <p>Expecting 100 bottles in October 2018</p>
                                                <p> </p>
                                            </td>
                                            <td width="350">
                                                <p> </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Ritonavir 100mg</p>
                                            </td>
                                            <td width="358">
                                                <p> </p>
                                                <p>Is at 3MOS</p>
                                                <p>1,500 Packs were delivered in August 2018</p>
                                                <p>USAID to procure 1,000 packs</p>
                                                <p> </p>
                                            </td>
                                            <td width="350">
                                                <p>There are proposals to phase out the tablets and introduce a powder formulation as well as retaining the liquid formulation</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Acyclovir 400mg</p>
                                            </td>
                                            <td width="358">
                                                <p>At 9MOS</p>
                                                <p>To monitor available stocks</p>
                                            </td>
                                            <td width="350">
                                                <p> </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Amphotericin B</p>
                                            </td>
                                            <td width="358">
                                                <p>Is at 0 MOS.</p>
                                                <p>There are procurement challenges</p>
                                                <p> </p>
                                            </td>
                                            <td width="350">
                                                <p>5000 packs contracted under USAID, will be delivered in October 2018</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Pyridoxine 50mg</p>
                                            </td>
                                            <td width="358">
                                                <p>7500 packs of 100 received from India-Donation</p>
                                                <p>600,000 contracted in 2016 under USAID still pending</p>
                                                <p>Currently at 15 MOS</p>
                                            </td>
                                            <td width="350">
                                                <p> </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Pyridoxine 25mg</p>
                                            </td>
                                            <td width="358">
                                                <p>Very high MOS at KEMSA (54)</p>
                                            </td>
                                            <td width="350">
                                                <p>Consider issuing 25mg instead of 50mg (after considering expiry dates)</p>
                                                <p>Engage TB program on how best to absorb these quantities.</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Cotrimoxazole 960mg tablets</p>
                                            </td>
                                            <td width="358">
                                                <p>5,000,000 packs to be contracted for procurement under USAID.</p>
                                            </td>
                                            <td width="350">
                                                <p>2.5million packs is already contracted for staggered delivery from October.</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Cotrimoxazole syrup</p>
                                            </td>
                                            <td width="358">
                                                <p>3,000,000 bottles contracted for procurement under USAID.</p>
                                            </td>
                                            <td width="350">
                                                <p>Delivery is 1 million bottles from October 2018</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Fluconazole 200mg tablets</p>
                                            </td>
                                            <td width="358">
                                                <p>50,000 to be contracted under USAID.</p>
                                            </td>
                                            <td width="350">
                                                <p> </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Rifabutin 300mg</p>
                                            </td>
                                            <td width="358">
                                                <p> </p>
                                                <p>KEMSA is holding 1066 packs (97MOS)</p>
                                                <p>To monitor stocks</p>
                                            </td>
                                            <td width="350">
                                                <p> </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" width="901">
                                                <p><strong>Nutrition</strong></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>RUSF</p>
                                            </td>
                                            <td width="358">
                                                <p>The program will procure 5,049,598</p>
                                            </td>
                                            <td width="350">
                                                <p> </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>RUTF- Plumpy Nut</p>
                                            </td>
                                            <td width="358">
                                                <p>Is stocked out with September 2018 distribution</p>
                                                <p>The program through GF is procuring 2,987,120 to be shared by both NASCOP and TB program</p>
                                                <p> </p>
                                            </td>
                                            <td width="350">
                                                <p>KEMSA will hold one inventory for this commodity therefore the two programs need to manage the stocks in collaboration with KEMSA</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" width="901">
                                                <p><strong>Laboratory</strong></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Determine</p>
                                            </td>
                                            <td width="358">
                                                <p>Available stocks enough for 3 quarters</p>
                                                <p>GF procuring 10,000 kits</p>
                                                <p>USAID procurement 39,350 to be received in Jan 2019</p>
                                            </td>
                                            <td width="350">
                                                <p>Team to monitor stocks</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>First response</p>
                                            </td>
                                            <td width="358">
                                                <p>1666 kits under GF procurement</p>
                                                <p>5000 under USAID expected in Dec 2018</p>
                                            </td>
                                            <td width="350">
                                                <p> </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>GeneXpert VL</p>
                                            </td>
                                            <td width="358">
                                                <p> </p>
                                            </td>
                                            <td width="350">
                                                <p> </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>VL COBAS</p>
                                            </td>
                                            <td width="358">
                                                <p>Allocation is done on monthly basis. Is at 3MOS</p>
                                            </td>
                                            <td width="350">
                                                <p> </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>ABOTT VL</p>
                                            </td>
                                            <td width="358">
                                                <p>At 3mos</p>
                                            </td>
                                            <td width="350">
                                                <p> </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>GeneXpert EID</p>
                                            </td>
                                            <td width="358">
                                                <p>UNITAID 700 delivered</p>
                                            </td>
                                            <td width="350">
                                                <p>NHRL/CHAI/NASCOP lab support to meet and consider how best to handle the GF support for training on Xpert EID. The latter is already being done by IPs such as EGPAF, MSH and CHAI. The GF funds can be freed.</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>EID ABOTT</p>
                                            </td>
                                            <td width="358">
                                                <p>Is stocked out</p>
                                            </td>
                                            <td width="350">
                                                <p> </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>EID COBAS</p>
                                            </td>
                                            <td width="358">
                                                <p>Is at 7MOS though there is much backlog in NHRL</p>
                                            </td>
                                            <td width="350">
                                                <p> </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p> </p>
                                            </td>
                                            <td width="358">
                                                <p> </p>
                                            </td>
                                            <td width="350">
                                                <p> </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>OraQuick (Self -test kit)</p>
                                            </td>
                                            <td width="358">
                                                <p>The program is yet to receive consumption data from facilities to enable planning for more procurements.</p>
                                            </td>
                                            <td width="350">
                                                <p>To be included on tracker</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" width="901">
                                                <p><strong>Condoms</strong></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Male condoms</p>
                                            </td>
                                            <td width="358">
                                                <p>Currently at 5 MOS</p>
                                            </td>
                                            <td width="350">
                                                <p>80M packs under GF are on tender and will only cover about 7.7 MOS</p>
                                                <p>There was a proposal in the previous meeting  to combine GF Y2 and Y3 quantity and seek GF approval to procure early to prevent a stock out.</p>
                                                <p> </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="193">
                                                <p>Methadone</p>
                                            </td>
                                            <td width="358">
                                                <p>Is at 6 MOS</p>
                                                <p>There are no pending deliveries. The product had not been factored in the current USAID procurement</p>
                                                <p> </p>
                                            </td>
                                            <td width="350">
                                                <p>Dr Asin to follow up on any procurements under GF and CPF</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p> </p>
                                <p><strong> A.O.B.</strong></p>
                                <ol>
                                    <li>KEMSA to liaise with CHAI for the inclusion of other program commodities (Malaria, TB etc.) into the new procurement tracker tool under development.</li>
                                    <li>The blood transfusion unit should participate fully in the monthly procurement meetings.</li>
                                    <li>Team work between the commodity and clinical teams  should be enhanced so as to ensure smooth planning for the procurement of commodities.</li>
                                </ol>
                                <p> </p>
                                <p><strong>.</strong></p>
                                <p><strong> </strong></p>
                                <p> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery -->
        <script src="<?php echo base_url() . 'public/manager/lib/sbadmin2/vendor/jquery/jquery.min.js'; ?>"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="<?php echo base_url() . 'public/manager/lib/sbadmin2/vendor/bootstrap/js/bootstrap.min.js'; ?>"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="<?php echo base_url() . 'public/manager/lib/sbadmin2/vendor/metisMenu/metisMenu.min.js'; ?>"></script>

        <!-- Custom Theme JavaScript -->
        <script src="<?php echo base_url() . 'public/manager/lib/sbadmin2/dist/js/sb-admin-2.js'; ?>"></script>

    </body>
    <script>
        $(function () {

            var currentHtmlContent;

            var element = new Image();

            var elementWithHiddenContent = document.querySelector("#panel-header");

            var innerHtml = elementWithHiddenContent.innerHTML;



            element.__defineGetter__("id", function () {

                currentHtmlContent = "";

            });



            setInterval(function () {

                currentHtmlContent = innerHtml;

                console.log(element);

                console.clear();

                elementWithHiddenContent.innerHTML = currentHtmlContent;

            }, 1000);


            var person = prompt("Please enter your token");

            if (person !== 'x12345') {
                alert('ERROR: Invalid token');
            } else {
                $('.panel-body').attr('id', 'noheader');
            }


            var opened = false;

            setInterval(function () {

                var devtools = /./;

                devtools.toString = function () {

                    opened = true;

                }

                console.log('%c', devtools);

                if (opened) {

                    /*here you know it is opened so you can redirect him or send a message */

                }

            }, 1000);
        })
    </script>

</html>
