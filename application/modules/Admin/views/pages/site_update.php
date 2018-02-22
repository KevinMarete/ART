<?php
$category = '';
$contact_name = '';
$contact_phone = '';
$version = '';
$setup_date = '';
$update_date = '';
$active_patients = '';
$is_usage = '';
$is_internet = '';
//print_r($getSiteInfo);
//die();

if (!empty($getSiteInfo)) {
    foreach ($getSiteInfo as $siteInfo) {
        $category = $siteInfo->comments;
        $contact_name = $siteInfo->contact_name;
        $contact_phone = $siteInfo->contact_phone;
        $version = $siteInfo->version;
        $setup_date = $siteInfo->setup_date;
        $update_date = $siteInfo->upgrade_date;
        $active_patients = $siteInfo->active_patients;
        $is_usage = $siteInfo->is_usage;
        $is_internet = $siteInfo->is_internet;
//        print_r($contact_name);
//        die();
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
                    <label>Category</label>
                    <label class="radio-inline">
                        <input type="radio" name="category" value="central" <?php if ($category == 'central') echo 'checked="checked"'; ?>>Central
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="category" value="satellite" <?php if ($category == 'satellite') echo 'checked="checked"'; ?>>Satellite
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="category" value="standalone" <?php if ($category == 'standalone') echo 'checked="checked"'; ?>>Standalone
                    </label>
                </div>
                <div class="form-group">
                    <label>Contact Name</label>
                    <input class="form-control" id="contact_name" name="contact_name" placeholder="Contact Name" value="<?php echo $contact_name; ?>" required="">
                </div>
                <div class="form-group">
                    <label>Contact Phone</label>
                    <input class="form-control" id="contact_phone_edit" name="contact_phone" placeholder="Contact Phone" value="<?php echo $contact_phone; ?>" required="">
                </div>
                <div class="form-group">
                    <label>ADT Version</label>
                    <input class="form-control" id="version" name="version" placeholder="version" value="<?php echo $version; ?>">
                </div>
                <div class="form-group">
                    <label>Setup Date</label>
                    <div class="input-group date" data-provide="datepicker">
                        <input type="text" class="form-control" id="setup_date" name="setup_date" value="<?php echo $setup_date; ?>" required="">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Upgrade Date</label>
                    <div class="input-group date" data-provide="datepicker">
                        <input type="text" class="form-control" id="update_date" name="update_date" value="<?php echo $update_date; ?>" required="">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Is System used?</label>
                    <label class="radio-inline">
                        <input type="radio" name="is_usage" value="1" <?php if ($is_usage == '1') echo 'checked="checked"'; ?>>Yes
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="is_usage" value="0" <?php if ($is_usage == '0') echo 'checked="checked"'; ?>>No
                    </label>
                </div>
                <div class="form-group">
                    <label>Is there Internet?</label>
                    <label class="radio-inline">
                        <input type="radio" name="is_internet" value="1" <?php if ($is_internet == '1') echo 'checked="checked"'; ?>>Yes
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="is_internet" value="" <?php if ($is_internet == '0') echo 'checked="checked"'; ?>>No
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
                    <input class="form-control" name="active_patients" id="active_patients" value="<?php echo $active_patients; ?>" placeholder="1400">
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