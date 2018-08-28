<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Application\modules\API\models\Regimen_model;
use Application\modules\API\models\Drug_model;

class Regimen_drug_model extends Eloquent {

	use SoftDeletes;
    protected $table = "tbl_regimen_drug"; // table name

	public function regimen()
    {
        return $this->belongsTo('Regimen_model','regimen_id');
    }
	
	public function drug()
    {
        return $this->belongsTo('Drug_model','drug_id');
    }

}