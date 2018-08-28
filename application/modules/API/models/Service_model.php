<?php
use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

defined('BASEPATH') OR exit('No direct script access allowed');

class Service_model extends Eloquent {

	use SoftDeletes;
	protected $table = "tbl_service"; // table name
	
}