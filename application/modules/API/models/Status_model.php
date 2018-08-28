<?php
use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

defined('BASEPATH') OR exit('No direct script access allowed');

class Status_model extends Eloquent {

	use SoftDeletes;
    protected $table = "tbl_status"; // table name

}