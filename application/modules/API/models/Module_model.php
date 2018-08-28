<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module_model extends Eloquent {

	use SoftDeletes;
    protected $table = "tbl_module"; // table name

}