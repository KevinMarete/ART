<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'modules/API/models/Drug_model.php';
require APPPATH . 'modules/API/models/Vw_drug_list_model.php';

/**
 *
 * @package         ART
 * @subpackage      API
 * @category        Controller
 * @author          Kevin Marete
 * @license         MIT
 * @link            https://github.com/KevinMarete/ART
 */
class Drug extends \API\Libraries\REST_Controller  {

    public function index_get()
    {

        $id = $this->get('id');

        // If the id parameter doesn't exist return all the drugs
        if ($id === NULL)
        {
            // drugs from a data store e.g. database
            $drugs = Drug_model::with('generic', 'formulation')->get();

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

            $drug = Drug_model::where('id',$id)->with('generic', 'formulation')->first();

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
        $id = $this->get('id');

        // If the id parameter doesn't exist return all the drugs
        if ($id === NULL)
        {
            // drugs from a data store e.g. database
            $drugs = Vw_drug_list_model::all();

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

            $drug = Vw_drug_list_model::find($id);

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
        $drug = new Drug_model;
        $drug->strength = $this->post('strength');
        $drug->packsize = $this->post('packsize');
        $drug->generic_id = $this->post('generic_id');
        $drug->formulation_id = $this->post('formulation_id');
        
        if($drug->save())
        {
            $this->set_response($drug, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
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

        $drug = Drug_model::find($id);
        $drug->strength = $this->post('strength');
        $drug->packsize = $this->post('packsize');
        $drug->generic_id = $this->post('generic_id');
        $drug->formulation_id = $this->post('formulation_id');
        
        if($drug->save())
        {
            $this->set_response($drug, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
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

        $deleted = Drug_model::destroy($id);
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
