<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Application\modules\API\models\Category_model;
use Application\modules\API\models\Line_model;
use Application\modules\API\models\Service_model;


class Regimen_model extends Eloquent {

	use SoftDeletes;
	protected $table = "tbl_regimen"; // table name
	
	public function category()
    {
        return $this->belongsTo('Category_model','category_id');
    }
	
	public function line()
    {
        return $this->belongsTo('Line_model','line_id');
    }
	
	public function service()
    {
        return $this->belongsTo('Service_model','service_id');
    }

}