<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/**
 *
 * @package         ART
 * @subpackage      API
 * @category        Controller
 * @author          Kevin Marete
 * @license         MIT
 */
class Dashboard extends \API\Libraries\REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('dashboard_model');
    }

    public function patient_get() {
        $year = $this->get('year');
        $month = $this->get('month');
        $service = $this->get('service');

        if (empty($year) || empty($month)) {
            // Set the response and exit
            $this->set_response([
                'status' => FALSE,
                'message' => 'Year or Month not specified!'
                    ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }else {
            $patients = $this->dashboard_model->read($year, $month, $service);

            if (!empty($patients)) {
                $this->set_response($patients, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'No Patient Data Found'
                        ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

}
