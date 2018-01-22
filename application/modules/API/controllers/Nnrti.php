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
class Nnrti extends \API\Libraries\REST_Controller  {

    function __construct()
    {
        parent::__construct();
        $this->load->model('nnrti_model');
    }

    public function index_get()
    {   
        //Default parameters
        $regimen = $this->get('regimen');

        //Conditions
        $conditions = array(
            'regimen_id' => $regimen
        );
        $conditions = array_filter($conditions);

        //nnrtis from a data store e.g. database
        $nnrtis = $this->nnrti_model->read($conditions);

        // If parameters don't exist return all the nnrtis
        if ($regimen <= 0)
        {
            // Check if the nnrti data store contains nnrti (in case the database result returns NULL)
            if ($nnrtis)
            {
                // Set the response and exit
                $this->response($nnrtis, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No nnrti was found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular nnrti.
        else {
            // Validate the regimen_id.
            if ($regimen <= 0)
            {
                // Invalid regimen_id, set the response and exit.
                $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            // Get the nnrti from the array, using the regimen_id as key for retrieval.
            // Usually a model is to be used for this.

            $nnrti = NULL;

            if (!empty($nnrtis))
            {      
                foreach ($nnrtis as $key => $value)
                {   
                    if ($value['regimen_id'] == $regimen)
                    {
                        $nnrti = $value;
                    }
                }
            }

            if (!empty($nnrti))
            {
                $this->set_response($nnrti, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'nnrti could not be found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function index_post()
    {   
        $data = array(
            'regimen_id' => $this->post('regimen_id'),
            'name' => $this->post('name')
        );
        $data = $this->nnrti_model->insert($data);
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
        $regimen_id = (int) $this->get('regimen');

        // Validate the regimen_id.
        if ($regimen_id <= 0)
        {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $data = array(
            'name' => $this->put('name')
        );
        $data = $this->nnrti_model->update($regimen_id, $data);
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
        $regimen_id = (int) $this->get('regimen');

        // Validate the regimen_id.
        if ($regimen_id <= 0)
        {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $data = $this->nnrti_model->delete($regimen_id);
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
