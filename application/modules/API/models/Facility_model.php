<?php
use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
require APPPATH . 'modules/API/models/Partner_model.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class Facility_model extends Eloquent {

    use SoftDeletes;
    protected $table = "tbl_facility"; // table name

    public function partner()
    {
        return $this->belongsTo('partner_model','partner_id');
    }
}
