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
class Patient_adt extends \API\Libraries\REST_Controller  {

    function __construct()
    {
        parent::__construct();
        $this->load->model('patient_adt_model');
    }

    public function index_get()
    {   
        //Default parameters
        $id = (int) $this->get('id');
        $ccc_no = $this->get('ccc_no');
        $enrollment = $this->get('enrollment');
        $start_art = $this->get('start_art');
        $facility = (int) $this->get('facility');
        $regimen = (int) $this->get('regimen');
        $service = (int) $this->get('service');
        $status = (int) $this->get('status');

        //Conditions
        $conditions = array(
            'id' => $id,
            'ccc_number' => $ccc_no,
            'enrollment_date' => $enrollment,
            'start_regimen_date' => $start_art,
            'facility_id' => $facility,
            'current_regimen_id' => $regimen,
            'service_id' => $service,
            'status_id' => $status
        );
        $conditions = array_filter($conditions);

        // patient_adt from a data store e.g. database
        $patient_adts = $this->patient_adt_model->read($conditions);

        // If parameters don't exist return all the patient_adt
        if ($id <= 0 || $ccc_no === NULL || $enrollment === NULL || $start_art === NULL || $facility <= 0 || $regimen <= 0 || $service <= 0 || $status <= 0)
        {
            // Check if the patient_adt data store contains patient_adt (in case the database result returns NULL)
            if ($patient_adts)
            {
                // Set the response and exit
                $this->response($patient_adts, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No patient_adt was found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular patient_adt.
        else {
            // Validate the parameters.
            if ($id <= 0 || $ccc_no === NULL || $enrollment === NULL || $start_art === NULL || $facility <= 0 || $regimen <= 0 || $service <= 0 || $status <= 0)
            {
                // Invalid id, set the response and exit.
                $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            // Get the patient_adt from the array, using the id as key for retrieval.
            // Usually a model is to be used for this.

            $patient_adt = NULL;

            if (!empty($patient_adts))
            {      
                foreach ($patient_adts as $key => $value)
                {   
                    if ($value['id'] == $id && $value['ccc_number'] == $ccc_no && $value['enrollment_date'] == $enrollment && $value['start_regimen_date'] == $start_art && $value['facility_id'] == $facility && $value['current_regimen_id'] == $regimen && $value['service_id'] == $service && $value['status_id'] == $status)
                    {
                        $patient_adt = $value;
                    }
                }
            }

            if (!empty($patient_adt))
            {
                $this->set_response($patient_adt, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'patient_adt could not be found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function index_post()
    {   
        $data = array(
            'ccc_number' => $this->post('ccc_number'),
            'birth_date' => $this->post('birth_date'),
            'gender' => $this->post('gender'),
            'start_height' => $this->post('start_height'),
            'start_weight' => $this->post('start_weight'),
            'start_bsa' => $this->post('start_bsa'),
            'current_height' => $this->post('current_height'),
            'current_weight' => $this->post('current_weight'),
            'current_bsa' => $this->post('current_bsa'),
            'enrollment_date' => $this->post('enrollment_date'),
            'start_regimen_date' => $this->post('start_regimen_date'),
            'status_change_date' => $this->post('status_change_date'),
            'facility_id' => $this->post('facility_id'),
            'start_regimen_id' => $this->post('start_regimen_id'),
            'current_regimen_id' => $this->post('current_regimen_id'),
            'service_id' => $this->post('service_id'),
            'status_id' => $this->post('status_id')
        );
        $data = $this->patient_adt_model->insert($data);
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
            'ccc_number' => $this->put('ccc_number'),
            'birth_date' => $this->put('birth_date'),
            'gender' => $this->put('gender'),
            'start_height' => $this->put('start_height'),
            'start_weight' => $this->put('start_weight'),
            'start_bsa' => $this->put('start_bsa'),
            'current_height' => $this->put('current_height'),
            'current_weight' => $this->put('current_weight'),
            'current_bsa' => $this->put('current_bsa'),
            'enrollment_date' => $this->put('enrollment_date'),
            'start_regimen_date' => $this->put('start_regimen_date'),
            'status_change_date' => $this->put('status_change_date'),
            'facility_id' => $this->put('facility_id'),
            'start_regimen_id' => $this->put('start_regimen_id'),
            'current_regimen_id' => $this->put('current_regimen_id'),
            'service_id' => $this->put('service_id'),
            'status_id' => $this->put('status_id')
        );
        $data = $this->patient_adt_model->update($id, $data);
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

        $data = $this->patient_adt_model->delete($id);
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
