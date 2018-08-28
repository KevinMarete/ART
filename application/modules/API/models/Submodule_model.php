<?php
/**
 * Description of Submodule_model
 *
 * @author k
 */

defined('BASEPATH') OR exit('No direct script access allowed');
use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Application\modules\API\models\Module_model;

class Submodule_model extends Eloquent {

    use SoftDeletes;
    protected $table = "tbl_submodule"; // table name

    public function module()
    {
        return $this->belongsTo('Module_model','module_id');
    }

}
