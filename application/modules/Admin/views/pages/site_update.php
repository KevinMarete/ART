<?php
if (!empty($getSiteInfo)) {
    foreach ($getSiteInfo as $siteInfo) {
        
    }
}
?>
<div id="page-wrapper">
    <div class="row">
        <h3>EDIT INSTALLED SITES</h3>
    </div>
    <form role="form" action="<?php echo base_url() . 'Admin/Sites/updateSite'; ?>" method="POST">
        <div class="row">

            <div class="col-md-4">
                <div class="form-group">
                    <label>Facility Name</label>
                    <input class="form-control" id="name" name="name" value="<?php echo $siteInfo->name; ?>" readonly="">
                    <input type="hidden" value="<?php echo $siteInfo->install_id; ?>" name="install_id" id="userId" />  
                </div>
                <div class="form-group">
                    <label>MFL Code</label>
                    <input class="form-control" id="mflcode" name="mflcode" value="<?php echo $siteInfo->mflcode; ?>" placeholder="mflcode" readonly="">
                </div>
                <div class="form-group">
                    <label>County</label>
                    <input class="form-control" id="county" name="county" value="<?php echo $siteInfo->county_name; ?>" readonly="">
                </div>
                <div class="form-group">
                    <label>Subcounty</label>
                    <input class="form-control" id="subcounty" name="subcounty" value="<?php echo $siteInfo->subcounty_name; ?>" readonly="">
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <label class="radio-inline">
                        <input type="radio" name="comments" value="central" <?php if ($siteInfo->comments == 'central') echo 'checked="checked"'; ?>>Central
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="comments" value="satellite" <?php if ($siteInfo->comments == 'satellite') echo 'checked="checked"'; ?>>Satellite
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="comments" value="standalone" <?php if ($siteInfo->comments == 'standalone') echo 'checked="checked"'; ?>>Standalone
                    </label>
                </div>
                <div class="form-group">
                    <label>Contact Name</label>
                    <input class="form-control" id="contact_name" name="contact_name" placeholder="Contact Name" value="<?php echo $siteInfo->contact_name; ?>" required="">
                </div>
                <div class="form-group">
                    <label>Contact Phone</label>
                    <input class="form-control" id="contact_phone" name="contact_phone" placeholder="Contact Phone" value="<?php echo $siteInfo->contact_phone; ?>" required="">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>ADT Version</label>
                    <input class="form-control" id="version" name="version" placeholder="version" value="<?php echo $siteInfo->version; ?>">
                </div>
                <div class="form-group">
                    <label>Setup Date</label>
                    <div class="input-group date" data-provide="datepicker">
                        <input type="text" class="form-control" id="setup_date" name="setup_date" value="<?php echo $siteInfo->setup_date; ?>" required="">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label>Upgrade Date</label>
                    <div class="input-group date" data-provide="datepicker">
                        <input type="text" class="form-control" id="update_date" name="update_date" value="<?php echo $siteInfo->upgrade_date; ?>" required="">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Is System used?</label>
                    <label class="radio-inline">
                        <input type="radio" name="is_usage" value="1" <?php if ($siteInfo->is_usage == '1') echo 'checked="checked"'; ?>>Yes
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="is_usage" value="0" <?php if ($siteInfo->is_usage == '0') echo 'checked="checked"'; ?>>No
                    </label>
                </div>
                <div class="form-group">
                    <label>Is there Internet?</label>
                    <label class="radio-inline">
                        <input type="radio" name="is_internet" value="1" <?php if ($siteInfo->is_internet == '1') echo 'checked="checked"'; ?>>Yes
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="is_internet" value="" <?php if ($siteInfo->is_internet == '0') echo 'checked="checked"'; ?>>No
                    </label>
                </div>
                <div class="form-group">
                    <label>EMRS Used</label>
                    <select multiple class="form-control" name="emrs_used[]" id="emrs_used">
                        <option>IQCARE</option>
                        <option>CPAD</option>
                        <option>KENYAEMR</option>
                        <option>OPENMRS</option>
                        <option>EDITT</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Active Patients</label>
                    <input class="form-control" name="active_patients" id="active_patients" value="<?php echo $siteInfo->active_patients; ?>" placeholder="1400">
                </div>
                <div class="form-group">
                    <label>Assigned To</label>
                    <input class="form-control" id="user" name="user_id" value="<?php echo $siteInfo->user_name; ?>" readonly="">
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Submit" />
                </div>
            </div>

        </div>
    </form> 
</div>
<script src="<?php echo base_url() . 'public/admin/js/sites.js'; ?>"></script>