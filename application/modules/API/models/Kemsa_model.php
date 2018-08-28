<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Application\modules\API\models\Drug_model;

class Kemsa_model extends Eloquent {

	use SoftDeletes;
	protected $table = "tbl_kemsa"; // table name
    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];
	
	public function drug()
    {
        return $this->belongsTo('Drug_model','drug_id');
    }

}