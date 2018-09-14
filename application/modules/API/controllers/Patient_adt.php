<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'modules/API/models/Patient_adt_model.php';

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

        // If parameters don't exist return all the patient_adt
        if ($id <= 0 || $ccc_no === NULL || $enrollment === NULL || $start_art === NULL || $facility <= 0 || $regimen <= 0 || $service <= 0 || $status <= 0)
        {
            // patient_adt from a data store e.g. database
            $patient_adts = Patient_adt_model::with('start_regimen','current_regimen', 'service', 'status')->get();

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

            $patient_adt = Patient_adt_model::with('start_regimen','current_regimen', 'service', 'status');
            if(!empty($id)) $patient_adt = $patient_adt->where('id', $id);
            if(!empty($ccc_no)) $patient_adt = $patient_adt->where('ccc_number', $ccc_no);
            if(!empty($enrollment)) $patient_adt = $patient_adt->where('enrollment_date', $enrollment);
            if(!empty($start_art)) $patient_adt = $patient_adt->where('start_regimen_date', $start_art);
            if(!empty($facility)) $patient_adt = $patient_adt->where('facility_id', $facility);
            if(!empty($regimen)) $patient_adt = $patient_adt->where('current_regimen_id', $regimen);
            if(!empty($service)) $patient_adt = $patient_adt->where('service_id', $service);
            if(!empty($status)) $patient_adt = $patient_adt->where('status_id', $status);
            $patient_adt = $patient_adt->first();

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
        $patient_adt = new Patient_adt_model;
        $patient_adt->ccc_number = $this->post('ccc_number');
        $patient_adt->birth_date = $this->post('birth_date');
        $patient_adt->gender = $this->post('gender');
        $patient_adt->start_height = $this->post('start_height');
        $patient_adt->start_weight = $this->post('start_weight');
        $patient_adt->start_bsa = $this->post('start_bsa');
        $patient_adt->current_height = $this->post('current_height');
        $patient_adt->current_weight = $this->post('current_weight');
        $patient_adt->current_bsa = $this->post('current_bsa');
        $patient_adt->enrollment_date = $this->post('enrollment_date');
        $patient_adt->start_regimen_date = $this->post('start_regimen_date');
        $patient_adt->status_change_date = $this->post('status_change_date');
        $patient_adt->facility_id = $this->post('facility_id');
        $patient_adt->start_regimen_id = $this->post('start_regimen_id');
        $patient_adt->current_regimen_id = $this->post('current_regimen_id');
        $patient_adt->service_id = $this->post('service_id');
        $patient_adt->status_id = $this->post('status_id');
        
        if($patient_adt->save())
        {
            $this->set_response($patient_adt, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
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
        $id = (int) $this->query('id');

        // Validate the id.
        if ($id <= 0)
        {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $patient_adt = Patient_adt_model::find($id);
        $patient_adt->ccc_number = $this->post('ccc_number');
        $patient_adt->birth_date = $this->post('birth_date');
        $patient_adt->gender = $this->post('gender');
        $patient_adt->start_height = $this->post('start_height');
        $patient_adt->start_weight = $this->post('start_weight');
        $patient_adt->start_bsa = $this->post('start_bsa');
        $patient_adt->current_height = $this->post('current_height');
        $patient_adt->current_weight = $this->post('current_weight');
        $patient_adt->current_bsa = $this->post('current_bsa');
        $patient_adt->enrollment_date = $this->post('enrollment_date');
        $patient_adt->start_regimen_date = $this->post('start_regimen_date');
        $patient_adt->status_change_date = $this->post('status_change_date');
        $patient_adt->facility_id = $this->post('facility_id');
        $patient_adt->start_regimen_id = $this->post('start_regimen_id');
        $patient_adt->current_regimen_id = $this->post('current_regimen_id');
        $patient_adt->service_id = $this->post('service_id');
        $patient_adt->status_id = $this->post('status_id');
        
        if($patient_adt->save())
        {
            $this->set_response($patient_adt, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
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
        $id = (int) $this->query('id');

        // Validate the id.
        if ($id <= 0)
        {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $deleted = Patient_adt_model::destroy($id);
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
