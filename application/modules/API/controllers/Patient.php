<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'modules/API/models/Patient_model.php';

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

    public function index_get()
    {   
        //Default parameters
        $year = $this->get('year');
        $month = $this->get('month');
        $facility = (int) $this->get('facility');
        $regimen = (int) $this->get('regimen');

        // If parameters don't exist return all the patient
        if ($facility <= 0 || $regimen <= 0)
        {
            // patient from a data store e.g. database
            $patients = Patient_model::with('regimen', 'facility')->where('regimen_id', $regimen)->where('facility_id', $facility);
            if(!empty($year)) $patients = $patients->where('period_year', $year);
            if(!empty($month)) $patients = $patients->where('period_month', $month);
            $patients = $patients->get();            
    
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

            $patient = Patient_model::with('regimen', 'facility')->where('facility_id', $facility)->where('regimen_id', $regimen)->first();

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
        $patient = new Patient_model;
        $patient->total = $this->post('total');
        $patient->period_year = $this->post('period_year');
        $patient->period_month = $this->post('period_month');
        $patient->facility_id = $this->post('facility_id');
        $patient->regimen_id = $this->post('regimen_id');

        if($patient->save())
        {
            $this->set_response($patient, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Error has occurred'
            ], \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // CREATED (201) being the HTTP response code
        }
    }

    public function index_put()
    {   
        $facility = (int) $this->query('facility');
        $regimen = (int) $this->query('regimen');
        $year = (int) $this->query('year');
        $month = (int) $this->query('month');

        // Validate facility and regimen.
        if ($facility <= 0 || $regimen <= 0)
        {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $patient = Patient_model::where('facility_id', $facility)->where('regimen_id', $regimen);
        if(!empty($year)) $patient = $patient->where('period_year', $year);
        if(!empty($month)) $patient = $patient->where('period_month', $month);
        $patient = $patient->first();

        $patient->total = $this->put('total');

        if($patient->save())
        {
            $this->set_response($patient, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Error has occurred'
            ], \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // CREATED (201) being the HTTP response code
        }
    }

    public function index_delete()
    {
        $facility = (int) $this->query('facility');
        $regimen = (int) $this->query('regimen');
        $year = (int) $this->query('year');
        $month = (int) $this->query('month');

        // Validate facility and regimen.
        if ($facility <= 0 || $regimen <= 0)
        {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $patient = Patient_model::where('facility_id', $facility)->where('regimen_id', $regimen);
        if(!empty($year)) $patient = $patient->where('period_year', $year);
        if(!empty($month)) $patient = $patient->where('period_month', $month);
        $deleted = $patient->delete();

        if($deleted)
        {
            $this->set_response([
                'status' => TRUE,
                'message' => 'Data is deleted successfully'
            ], \API\Libraries\REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Error has occurred'
            ], \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // CREATED (201) being the HTTP response code
        }
    }

}
