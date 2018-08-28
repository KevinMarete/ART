<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'modules/API/models/Regimen_drug_model.php';

/**
 *
 * @package         ART
 * @subpackage      API
 * @category        Controller
 * @author          Kevin Marete
 * @license         MIT
 * @link            https://github.com/KevinMarete/ART
 */
class Regimen_drug extends \API\Libraries\REST_Controller  {

    public function index_get()
    {   
        //Default parameters
        $regimen = $this->get('regimen');

        // If parameters don't exist return all the regimen_drugs
        if ($regimen <= 0)
        {
            //regimen_drugs from a data store e.g. database
            $regimen_drugs = Regimen_drug_model::with('drug','regimen')->get();
    
            // Check if the regimen_drug data store contains regimen_drug (in case the database result returns NULL)
            if ($regimen_drugs)
            {
                // Set the response and exit
                $this->response($regimen_drugs, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No regimen_drug was found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular regimen_drug.
        else {
            // Validate the regimen_id.
            if ($regimen <= 0)
            {
                // Invalid regimen_id, set the response and exit.
                $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            // Get the regimen_drug from the array, using the regimen_id as key for retrieval.
            // Usually a model is to be used for this.

            $regimen_drug = Regimen_drug_model::with('drug','regimen')->where('regimen_id', $regimen)->first();

            if (!empty($regimen_drug))
            {
                $this->set_response($regimen_drug, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'regimen_drug could not be found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function index_post()
    {   
        $regimen_drug = new Regimen_drug_model;
        $regimen_drug->regimen_id = $this->post('regimen_id');
        $regimen_drug->drug_id = $this->post('drug_id');

        if($regimen_drug->save())
        {
            $this->set_response($regimen_drug, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
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
        $regimen_id = (int) $this->query('regimen');

        // Validate the regimen_id.
        if ($regimen_id <= 0)
        {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $regimen_drug = Regimen_drug_model::where('regimen_id', $regimen_id)->first();
        $regimen_drug->drug_id = $this->put('drug_id');

        if($regimen_drug->save())
        {
            $this->set_response($regimen_drug, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
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
        $regimen_id = (int) $this->query('regimen');

        // Validate the regimen_id.
        if ($regimen_id <= 0)
        {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $deleted = Regimen_drug_model::where("regimen_id", $regimen_id)->delete();
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
