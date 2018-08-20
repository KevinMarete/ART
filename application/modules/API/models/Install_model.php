<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Application\modules\API\models\Facility_model;
use Application\modules\API\models\User_model;

class Install_model extends Eloquent {

	use SoftDeletes;
	protected $table = "tbl_install"; // table name
	
	public function facility()
    {
        return $this->belongsTo('Facility_model', 'facility_id');
	}
	
	public function user()
    {
        return $this->belongsTo('User_model', 'user_id');
    }

}