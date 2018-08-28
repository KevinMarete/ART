<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role_model extends Eloquent {

	use SoftDeletes;
    protected $table = "tbl_role"; // table name
    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];

}