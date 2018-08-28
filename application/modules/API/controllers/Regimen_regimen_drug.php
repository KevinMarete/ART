<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'modules/API/models/Regimen_model.php';
require APPPATH . 'modules/API/models/Regimen_drug_model.php';
require APPPATH . 'modules/API/models/Vw_regimen_list_model.php';

class Regimen_regimen_drug extends \API\Libraries\REST_Controller  {

    public function index_get()
    {
        $id = $this->get('id');

        // If the id parameter doesn't exist return all the regimens
        if ($id === NULL)
        {
            // regimens from a data store e.g. database
            $regimen_drugs = Regimen_drug_model::all()->pluck('regimen_id');
            $regimens = Regimen_model::with('category', 'line', 'service')->whereNotIn('id', $regimen_drugs)->orderBy('name', 'ASC')->get();
    
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

            $regimen_drugs = Regimen_drug_model::all()->pluck('regimen_id');
            $regimen = Regimen_model::with('category', 'line', 'service')->whereNotIn('id', $regimen_drugs)->where('id', $id)->first();

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
        $id = $this->get('id');

        // If the id parameter doesn't exist return all the regimens
        if ($id === NULL)
        {
            // regimens from a data store e.g. database
            $regimens = Vw_regimen_list_model::all();
    
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

            $regimen = Vw_regimen_list_model::find($id);

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
        $regimen = new Regimen_model;
        $regimen->code = $this->post('code');
        $regimen->name = $this->post('name');
        $regimen->description = $this->post('description');
        $regimen->category_id = $this->post('category_id');
        $regimen->service_id = $this->post('service_id');
        $regimen->line_id = $this->post('line_id');

        if($regimen->save())
        {
            $this->set_response($regimen, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
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

        $regimen = Regimen_model::find($id);
        $regimen->code = $this->put('code');
        $regimen->name = $this->put('name');
        $regimen->description = $this->put('description');
        $regimen->category_id = $this->put('category_id');
        $regimen->service_id = $this->put('service_id');
        $regimen->line_id = $this->put('line_id');

        if($regimen->save())
        {
            $this->set_response($regimen, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
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

        $deleted = Regimen_model::destroy($id);
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
