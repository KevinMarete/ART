<?php
use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

defined('BASEPATH') OR exit('No direct script access allowed');

class Change_reason_model extends Eloquent {

	use SoftDeletes;
    protected $table = "tbl_change_reason"; // table name
    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];

}