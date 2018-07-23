<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Regimen_regimen_drug extends \API\Libraries\REST_Controller  {

    function __construct()
    {
        parent::__construct();
        $this->load->model('regimen_regimen_drug_model');
    }

    public function index_get()
    {
        // regimens from a data store e.g. database
        $regimens = $this->regimen_regimen_drug_model->read();

        $id = $this->get('id');

        // If the id parameter doesn't exist return all the regimens
        if ($id === NULL)
        {
            // Check if the regimens data store contains regimens (in case the database result returns NULL)
            if ($regimens)
            {
                // Set the response and exit
                $this->response($regimens, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No regimens were found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular regimen.
        else {
            $id = (int) $id;

            // Validate the id.
            if ($id <= 0)
            {
                // Invalid id, set the response and exit.
                $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            // Get the regimen from the array, using the id as key for retrieval.
            // Usually a model is to be used for this.

            $regimen = NULL;

            if (!empty($regimens))
            {      
                foreach ($regimens as $key => $value)
                {   
                    if ($value['id'] == $id)
                    {
                        $regimen = $value;
                    }
                }
            }

            if (!empty($regimen))
            {
                $this->set_response($regimen, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'regimen could not be found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function list_get()
    {
        // regimens from a data store e.g. database
        $regimens = $this->regimen_regimen_drug_model->read_list();

        $id = $this->get('id');

        // If the id parameter doesn't exist return all the regimens
        if ($id === NULL)
        {
            // Check if the regimens data store contains regimens (in case the database result returns NULL)
            if ($regimens)
            {
                // Set the response and exit
                $this->response($regimens, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No regimens were found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular regimen.
        else {
            $id = (int) $id;

            // Validate the id.
            if ($id <= 0)
            {
                // Invalid id, set the response and exit.
                $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            // Get the regimen from the array, using the id as key for retrieval.
            // Usually a model is to be used for this.

            $regimen = NULL;

            if (!empty($regimens))
            {      
                foreach ($regimens as $key => $value)
                {   
                    if ($value['id'] == $id)
                    {
                        $regimen = $value;
                    }
                }
            }

            if (!empty($regimen))
            {
                $this->set_response($regimen, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'regimen could not be found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function index_post()
    {   
        $data = array(
            'code' => $this->post('code'),
            'name' => $this->post('name'),
            'description' => $this->post('description'),
            'category_id' => $this->post('category_id'),
            'service_id' => $this->post('service_id'),
            'line_id' => $this->post('line_id')
        );
        $data = $this->regimen_regimen_drug_model->insert($data);
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
            'code' => $this->put('code'),
            'name' => $this->put('name'),
            'description' => $this->put('description'),
            'category_id' => $this->put('category_id'),
            'service_id' => $this->put('service_id'),
            'line_id' => $this->put('line_id')
        );
        $data = $this->regimen_regimen_drug_model->update($id, $data);
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

        $data = $this->regimen_regimen_drug_model->delete($id);
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
