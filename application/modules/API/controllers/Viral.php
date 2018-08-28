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
class Viral extends \API\Libraries\REST_Controller  {

    function __construct()
    {
        parent::__construct();
        $this->load->model('viral_model');
    }

    public function index_get()
    {
        //Default parameters
        $test_id = $this->get('test_id');
        $patient_adt_id = (int) $this->get('patient_adt_id');

        //Conditions
        $conditions = array(
            'test_id' => $test_id,
            'patient_adt_id' => $patient_adt_id
        );
        $conditions = array_filter($conditions);

        // virals from a data store e.g. database
        $virals = $this->viral_model->read($conditions);

        // If the test_id parameter doesn't exist return all the virals
        if ($test_id === NULL || $patient_adt_id <= 0)
        {
            // Check if the virals data store contains virals (in case the database result returns NULL)
            if ($virals)
            {
                // Set the response and exit
                $this->response($virals, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No virals were found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular viral.
        else {
            $test_id = (int) $test_id;

            // Validate the test_id.
            if ($test_id <= 0 || $patient_adt_id <= 0)
            {
                // Invalid test_id, set the response and exit.
                $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            // Get the viral from the array, using the id as key for retrieval.
            // Usually a model is to be used for this.

            $viral = NULL;

            if (!empty($virals))
            {      
                foreach ($virals as $key => $value)
                {   
                    if ($value['test_id'] == $test_id && $value['patient_adt_id'] == $patient_adt_id)
                    {
                        $viral = $value;
                    }
                }
            }

            if (!empty($viral))
            {
                $this->set_response($viral, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'viral could not be found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function index_post()
    {   
        $data = array(
            'test_id' => $this->post('test_id'),
            'test_date' => $this->post('test_date'),
            'test_result' => $this->post('test_result'),
            'test_justification' => $this->post('test_justification'),
            'patient_adt_id' => $this->post('patient_adt_id'),
            'ccc_number' => $this->post('ccc_number')   
        );
        $data = $this->viral_model->insert($data);
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
        $test_id = (int) $this->get('test_id');

        // Validate the test_id.
        if ($test_id <= 0)
        {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $data = array(
            'test_id' => $this->put('test_id'),
            'test_date' => $this->put('test_date'),
            'test_result' => $this->put('test_result'),
            'test_justification' => $this->put('test_justification'),
            'patient_adt_id' => $this->put('patient_adt_id'),
            'ccc_number' => $this->put('ccc_number')   
        );
        $data = $this->viral_model->update($test_id, $data);
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
        $test_id = (int) $this->get('test_id');

        // Validate the test_id.
        if ($test_id <= 0)
        {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $data = $this->viral_model->delete($test_id);
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
