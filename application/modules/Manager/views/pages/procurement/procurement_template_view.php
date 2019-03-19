<link href="<?php echo base_url() . 'public/manager/lib/sbadmin2/vendor/bootstrap/css/bootstrap.min.css'; ?>" rel="stylesheet">
<div class="row col-md-10 col-md-offset-1">
    <div class="table-responsive">
        <strong><em>Procurement History</em></strong>

        <table class="table table-bordered table-striped">
            <thead>
                <tr> 
                    <th>
                        Commodity
                    </th>
                    <th>
                        Zidovudine/Lamivudine/Nevirapine 300/300/200
                    </th>
                    <th>
                        Period   2018 | 2019
                    </th>
                    <th>
                        Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec
                    </th>
                </tr>

            </thead>
            <tr>
                <td colspan="2">Proposed</td>
                <td><input type="number" class="form-control" name='proposed' id='proposed' value='300000' placeholder="Enter Proposed Quantity"/></td>
                <td><input type="text" class="form-control" name='date' id='date' value="01-03-2019" placeholder="Select Date"/></td>
                <td><textarea class="form-control comments" placeholder="Enter Comment"></textarea></td>
            </tr>
            <tr>
                <td rowspan="3">Funding Agent</td>
                <td>USG</td>
                <td><input type="number" class="form-control" name='proposed' value="150000" id='proposed' placeholder="Enter Proposed Quantity"/></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>GF</td>
                <td><input type="number" class="form-control" name='proposed' value="125000" id='proposed' placeholder="Enter Proposed Quantity"/></td>
                <td></td>
                <td></td>

            </tr>
            <tr>
                <td>CPF</td>
                <td><input type="number" class="form-control" name='proposed' value="125000" id='proposed' placeholder="Enter Proposed Quantity"/></td>
                <td></td>
                <td></td>

            </tr>
            <tr>
                <td colspan="2">Contracted</td>
                <td><input type="number" class="form-control" value="250000" name='contracted' id='proposed' placeholder="Contracted Quantity"/></td>
                <td><input type="text" class="form-control"  value="20-03-2019" name='date' id='date' placeholder="Select Date"/></td>
                <td><textarea class="form-control comments" placeholder="Enter Comment">Cipla Ltd,Abot Ltd,x-supplier</textarea></td>

            </tr>
            <tr>
                <td colspan="2">Call-Down</td>
                <td><input type="number" class="form-control" value="200000" name='call_down' id='call_down' placeholder="Call-Down Quantity"/></td>
                <td><input type="text" class="form-control" name='date'  value="21-03-2019" id='date' placeholder="Select Date"/></td>
                <td><textarea class="form-control comments" placeholder="Enter Comment" >USG will avail funds next month for more</textarea></td>

            </tr>
            <tr>
                <td colspan="2">Available Call-Down</td>
                <td><input type="number" class="form-control" name='avail_call_down' value="50000" id='avail_call_down' placeholder="Available Call-Down Quantity"/></td></td>
                <td></td>
                <td><textarea class="form-control comments" placeholder="Enter Comment">Will be acted upon next month</textarea></td>

            </tr>
            <tr>
                <td colspan="2">
                    <select class="form-control" >
                        <option value="Scheduled">Scheduled</option>
                        <option value="Partial">Partial Delivery</option>
                        <option value="Full">Full Delivery</option>
                    </select>
                </td>
                <td><input type="number" class="form-control" name='delivered' id='delivered' value="150000" placeholder="Delivered Quantity"/></td>
                <td><input type="text" class="form-control"  value="15-04-2019" name='date' id='date' placeholder="Select Date"/></td>
                <td><textarea class="form-control comments" >Full delivery could not be made due to x reason</textarea></td>

            </tr>
            <tr>
                <td colspan="2">Pending Delivery</td>
                <td><input type="number" class="form-control" name='delivered' id='delivered' value="50000" placeholder="Delivered Quantity"/></td>
                <td></td>
                <td><textarea class="form-control comments" placeholder="Enter Comment">Cipla Promised to deliver this end of April</textarea></td>

            </tr>
            <tr>
                <td colspan="2">General Comments</td>
                <td colspan="3"><textarea class="form-control comments" placeholder="Enter Comment">Procurement commenced a bit late because Notification,Evaluation and Advartisement took a bit of time. USG Noted that the quantities were a bit high and needed justification. Later consent/Authorization to procure was given.</textarea></td>

            </tr>
        </table>

    </div>
</div>
