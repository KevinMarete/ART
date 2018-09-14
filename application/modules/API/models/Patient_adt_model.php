<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Application\modules\API\models\Regimen_model;
use Application\modules\API\models\Service_model;
use Application\modules\API\models\Status_model;

class Patient_adt_model extends Eloquent {

	use SoftDeletes;
	protected $table = "tbl_patient_adt"; // table name
    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];
	
	public function start_regimen()
    {
        return $this->belongsTo('Regimen_model','start_regimen_id');
    }
	
	public function current_regimen()
    {
        return $this->belongsTo('Regimen_model','current_regimen_id');
    }
	
	public function service()
    {
        return $this->belongsTo('Service_model','service_id');
    }
	
	public function status()
    {
        return $this->belongsTo('Status_model','status_id');
    }

}