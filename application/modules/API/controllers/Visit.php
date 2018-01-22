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
 * @link            https://github.com/KevinMarete/ART
 */
class Visit extends \API\Libraries\REST_Controller  {

    function __construct()
    {
        parent::__construct();
        $this->load->model('visit_model');
    }

    public function index_get()
    {   
        //Default parameters
        $id = (int)$this->get('id');
        $date = $this->get('date');
        $patient = (int) $this->get('patient');

        //Conditions
        $conditions = array(
            'id' => $id,
            'dispensing_date' => $date,
            'patient_adt_id' => $patient
        );
        $conditions = array_filter($conditions);

        // visit from a data store e.g. database
        $visits = $this->visit_model->read($conditions);

        // If parameters don't exist return all the visit
        if ($id <= 0 || $date === NULL || $patient <= 0)
        {
            // Check if the visit data store contains visit (in case the database result returns NULL)
            if ($visits)
            {
                // Set the response and exit
                $this->response($visits, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No visit was found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular visit.
        else {
            // Validate the id/date/patient.
            if ($id <= 0 || $date === NULL || $patient <= 0)
            {
                // Invalid id, set the response and exit.
                $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            // Get the visit from the array, using the id as key for retrieval.
            // Usually a model is to be used for this.

            $visit = NULL;

            if (!empty($visits))
            {      
                foreach ($visits as $key => $value)
                {   
                    if ($value['id'] == $id && $value['dispensing_date'] == $date && $value['patient_adt_id'] == $patient)
                    {
                        $visit = $value;
                    }
                }
            }

            if (!empty($visit))
            {
                $this->set_response($visit, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'visit could not be found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function index_post()
    {   
        $data = array(
            'dispensing_date' => $this->post('dispensing_date'),
            'appointment_date' => $this->post('appointment_date'),
            'appointment_adherence' => $this->post('appointment_adherence'),
            'patient_adt_id' => $this->post('patient_adt_id'),
            'purpose_id' => $this->post('purpose_id'),
            'last_regimen_id' => $this->post('last_regimen_id'),
            'current_regimen_id' => $this->post('current_regimen_id'),
            'change_reason_id' => $this->post('change_reason_id')
        );
        $data = $this->visit_model->insert($data);
        if($data['status'])
        {
            unset($data['status']);
            $this->set_response($data, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
        }
        else
        {
            unset($data['status']);
            $this->set_response([
                'status' => FALSE,
                'message' => 'Error has occurred'
            ], \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // CREATED (201) being the HTTP response code
        }
    }

    public function index_put()
    {   
        $id = (int) $this->get('id');

        // Validate the id.
        if ($id <= 0)
        {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $data = array(
            'dispensing_date' => $this->put('dispensing_date'),
            'appointment_date' => $this->put('appointment_date'),
            'appointment_adherence' => $this->put('appointment_adherence'),
            'patient_adt_id' => $this->put('patient_adt_id'),
            'purpose_id' => $this->put('purpose_id'),
            'last_regimen_id' => $this->put('last_regimen_id'),
            'current_regimen_id' => $this->put('current_regimen_id'),
            'change_reason_id' => $this->put('change_reason_id')
        );
        $data = $this->visit_model->update($id, $data);
        if($data['status'])
        {
            unset($data['status']);
            $this->set_response($data, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
        }
        else
        {
            unset($data['status']);
            $this->set_response([
                'status' => FALSE,
                'message' => 'Error has occurred'
            ], \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // CREATED (201) being the HTTP response code
        }
    }

    public function index_delete()
    {
        $id = (int) $this->get('id');

        // Validate the id.
        if ($id <= 0)
        {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $data = $this->visit_model->delete($id);
        if($data['status'])
        {
            unset($data['status']);
            $this->set_response([
                'status' => TRUE,
                'message' => 'Data is deleted successfully'
            ], \API\Libraries\REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
        }
        else
        {
            unset($data['status']);
            $this->set_response([
                'status' => FALSE,
                'message' => 'Error has occurred'
            ], \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // CREATED (201) being the HTTP response code
        }
    }

}
