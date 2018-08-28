<?php
use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Application\modules\API\models\County_model;

defined('BASEPATH') OR exit('No direct script access allowed');

class Subcounty_model extends Eloquent {

    use SoftDeletes;
    protected $table = "tbl_subcounty"; // table name

    public function county()
    {
        return $this->belongsTo('County_model','county_id');
    }

}
