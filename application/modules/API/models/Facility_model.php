<?php
use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Application\modules\API\models\Partner_model;
use Application\modules\API\models\Subcounty_model;

defined('BASEPATH') OR exit('No direct script access allowed');

class Facility_model extends Eloquent {

    use SoftDeletes;
    protected $table = "tbl_facility"; // table name

    public function partner()
    {
        return $this->belongsTo('partner_model','partner_id');
    }

    public function subcounty()
    {
        return $this->belongsTo('Subcounty_model','subcounty_id');
    }
}
