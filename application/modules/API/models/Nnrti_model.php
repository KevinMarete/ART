<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Application\modules\API\models\Regimen_model;

class Nnrti_model extends Eloquent {

	use SoftDeletes;
	protected $table = "tbl_nnrti"; // table name
	
	public function regimen()
    {
        return $this->belongsTo('Regimen_model','regimen_id');
    }

}