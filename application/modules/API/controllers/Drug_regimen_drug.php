<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Drug_regimen_drug extends \API\Libraries\REST_Controller  {

    function __construct()
    {
        parent::__construct();
        $this->load->model('drug_regimen_drug_model');
    }

    public function index_get()
    {
        // drugs from a data store e.g. database
        $drugs = $this->drug_regimen_drug_model->read();

        $id = $this->get('id');

        // If the id parameter doesn't exist return all the drugs
        if ($id === NULL)
        {
            // Check if the drugs data store contains drugs (in case the database result returns NULL)
            if ($drugs)
            {
                // Set the response and exit
                $this->response($drugs, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No drugs were found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular drug.
        else {
            $id = (int) $id;

            // Validate the id.
            if ($id <= 0)
            {
                // Invalid id, set the response and exit.
                $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            // Get the drug from the array, using the id as key for retrieval.
            // Usually a model is to be used for this.

            $drug = NULL;

            if (!empty($drugs))
            {      
                foreach ($drugs as $key => $value)
                {   
                    if ($value['id'] == $id)
                    {
                        $drug = $value;
                    }
                }
            }

            if (!empty($drug))
            {
                $this->set_response($drug, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'drug could not be found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function list_get()
    {
        // drugs from a data store e.g. database
        $drugs = $this->drug_regimen_drug_model->read_list();

        $id = $this->get('id');

        // If the id parameter doesn't exist return all the drugs
        if ($id === NULL)
        {
            // Check if the drugs data store contains drugs (in case the database result returns NULL)
            if ($drugs)
            {
                // Set the response and exit
                $this->response($drugs, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No drugs were found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular drug.
        else {
            $id = (int) $id;

            // Validate the id.
            if ($id <= 0)
            {
                // Invalid id, set the response and exit.
                $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            // Get the drug from the array, using the id as key for retrieval.
            // Usually a model is to be used for this.

            $drug = NULL;

            if (!empty($drugs))
            {      
                foreach ($drugs as $key => $value)
                {   
                    if ($value['id'] == $id)
                    {
                        $drug = $value;
                    }
                }
            }

            if (!empty($drug))
            {
                $this->set_response($drug, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'drug could not be found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function index_post()
    {   
        $data = array(
            'strength' => $this->post('strength'),
            'packsize' => $this->post('packsize'),
            'generic_id' => $this->post('generic_id'),
            'formulation_id' => $this->post('formulation_id')
        );
        $data = $this->drug_regimen_drug_model->insert($data);
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
            'strength' => $this->put('strength'),
            'packsize' => $this->put('packsize'),
            'generic_id' => $this->put('generic_id'),
            'formulation_id' => $this->put('formulation_id')
        );
        $data = $this->drug_regimen_drug_model->update($id, $data);
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

        $data = $this->drug_regimen_drug_model->delete($id);
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
