<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'modules/API/models/Nrti_model.php';

/**
 *
 * @package         ART
 * @subpackage      API
 * @category        Controller
 * @author          Kevin Marete
 * @license         MIT
 * @link            https://github.com/KevinMarete/ART
 */
class Nrti extends \API\Libraries\REST_Controller  {

    public function index_get()
    {   
        //Default parameters
        $regimen = $this->get('regimen');

        // If parameters don't exist return all the nrtis
        if ($regimen <= 0)
        {
            // Check if the nrti data store contains nrti (in case the database result returns NULL)
            if ($nrtis)
            {
                //nrtis from a data store e.g. database
                $nrtis = Nrti_model::with('regimen')->get();

                // Set the response and exit
                $this->response($nrtis, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No nrti was found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular nrti.
        else {
            // Validate the regimen_id.
            if ($regimen <= 0)
            {
                // Invalid regimen_id, set the response and exit.
                $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            // Get the nrti from the array, using the regimen_id as key for retrieval.
            // Usually a model is to be used for this.

            $nrti = $nrti = Nnrti_model::with('regimen')->where('regimen_id', $regimen)->first();

            if (!empty($nrti))
            {
                $this->set_response($nrti, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'nrti could not be found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function index_post()
    {   
        $nrti = new Nrti_model;
        $nrti->regimen_id = $this->post('regimen_id');
        $nrti->name = $this->post('name');
        
        if($nrti->save())
        {
            $this->set_response($nrti, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
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

        $nrti = Nrti_model::where('regimen_id', $regimen)->first();
        $nrti->name = $this->put('name');
        
        if($nrti)
        {
            $this->set_response($nrti, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
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

        $deleted = Nrti_model::where('regimen_id', $regimen)->delete();
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
