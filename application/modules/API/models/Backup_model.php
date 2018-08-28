<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Application\modules\API\models\Facility_model;

class Backup_model extends Eloquent {

	use SoftDeletes;
    protected $table = "tbl_backup"; // table name

    public function facility()
    {
        return $this->belongsTo('Facility_model','facility_id');
    }

}