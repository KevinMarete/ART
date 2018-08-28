<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vw_drug_list_model extends Eloquent {

    protected $table = "vw_drug_list"; // table name

}