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
class Patient extends \API\Libraries\REST_Controller  {

    function __construct()
    {
        parent::__construct();
        $this->load->model('patient_model');
    }

    public function index_get()
    {   
        //Default parameters
        $year = $this->get('year');
        $month = $this->get('month');
        $facility = (int) $this->get('facility');
        $regimen = (int) $this->get('regimen');

        //Conditions
        $conditions = array(
            'period_year' => $year,
            'period_month' => $month,
            'facility_id' => $facility,
            'regimen_id' => $regimen
        );
        $conditions = array_filter($conditions);

        // patient from a data store e.g. database
        $patients = $this->patient_model->read($conditions);

        // If parameters don't exist return all the patient
        if ($facility <= 0 || $regimen <= 0)
        {
            // Check if the patient data store contains patient (in case the database result returns NULL)
            if ($patients)
            {
                // Set the response and exit
                $this->response($patients, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No patient was found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular patient.
        else {
            // Validate the id.
            if ($facility <= 0 || $regimen <= 0)
            {
                // Invalid id, set the response and exit.
                $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            // Get the patient from the array, using the id as key for retrieval.
            // Usually a model is to be used for this.

            $patient = NULL;

            if (!empty($patients))
            {      
                foreach ($patients as $key => $value)
                {   
                    if ($value['period_year'] == $year && $value['period_month'] == $month && $value['facility_id'] == $facility && $value['regimen_id'] == $regimen)
                    {
                        $patient = $value;
                    }
                }
            }

            if (!empty($patient))
            {
                $this->set_response($patient, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'patient could not be found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function index_post()
    {   
        $data = array(
            'total' => $this->post('total'),
            'period_year' => $this->post('period_year'),
            'period_month' => $this->post('period_month'),
            'facility_id' => $this->post('facility_id'),
            'regimen_id' => $this->post('regimen_id')
        );
        $data = $this->patient_model->insert($data);
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
        $facility = (int) $this->get('facility');
        $regimen = (int) $this->get('regimen');

        $conditions = array(
            'period_year' => $this->get('year'),
            'period_month' => $this->get('month'),
            'facility_id' => $facility,
            'regimen_id' => $regimen
        );

        // Validate facility and regimen.
        if ($facility <= 0 || $regimen <= 0)
        {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $data = array(
            'total' => $this->put('total')
        );
        $data = $this->patient_model->update($conditions, $data);
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
        $facility = (int) $this->get('facility');
        $regimen = (int) $this->get('regimen');

        $conditions = array(
            'period_year' => $this->get('year'),
            'period_month' => $this->get('month'),
            'facility_id' => $facility,
            'regimen_id' => $regimen
        );

        // Validate facility and regimen.
        if ($facility <= 0 || $regimen <= 0)
        {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $data = $this->patient_model->delete($conditions);
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
