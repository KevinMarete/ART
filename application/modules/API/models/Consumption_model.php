<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Application\modules\API\models\Facility_model;

class Consumption_model extends Eloquent {

	use SoftDeletes;
	protected $table = "tbl_consumption"; // table name
	
	public function facility()
    {
        return $this->belongsTo('Facility_model','facility_id');
    }

}