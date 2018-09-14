<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Application\modules\API\models\Formulation_model;
use Application\modules\API\models\Generic_model;

class Drug_model extends Eloquent {

	use SoftDeletes;
    protected $table = "tbl_drug"; // table name
    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];

    public function formulation()
    {
        return $this->belongsTo('Formulation_model','formulation_id');
    }

    public function generic()
    {
        return $this->belongsTo('Generic_model','generic_id');
    }

}