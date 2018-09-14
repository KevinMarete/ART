<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Application\modules\API\models\Facility_model;
use Application\modules\API\models\Drug_model;

class Stock_model extends Eloquent {

	use SoftDeletes;
	protected $table = "tbl_stock"; // table name
    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];

	public function facility()
    {
        return $this->belongsTo('Facility_model','facility_id');
    }
	
	public function drug()
    {
        return $this->belongsTo('Drug_model','drug_id');
    }

}