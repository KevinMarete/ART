<?php
use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Application\modules\API\models\Subcounty_model;

defined('BASEPATH') OR exit('No direct script access allowed');

class County_model extends Eloquent {

	use SoftDeletes;
    protected $table = "tbl_county"; // table name

    public function subcounties()
    {
        return $this->hasMany('Subcounty_model','county_id');
    }

}