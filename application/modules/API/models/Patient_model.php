<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Application\modules\API\models\Regimen_model;
use Application\modules\API\models\Facility_model;


class Patient_model extends Eloquent {

	use SoftDeletes;
    protected $table = "tbl_patient"; // table name

	public function regimen()
    {
        return $this->belongsTo('Regimen_model','regimen_id');
    }

	public function facility()
    {
        return $this->belongsTo('Facility_model','facility_id');
    }

}