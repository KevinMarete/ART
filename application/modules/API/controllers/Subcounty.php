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
class Subcounty extends \API\Libraries\REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('subcounty_model');
    }

    public function index_get() {
        //Default parameters
        $id = $this->get('id');
        $county = $this->get('county');

        //Conditions
        $conditions = array(
            'id' => $id,
            'county_id' => $county
        );
        $conditions = array_filter($conditions);

        //Subcounties from a data store e.g. database
//        $subcounties = $this->subcounty_model->read($conditions);
        $subcounties = $this->subcounty_model->read();
        //If the id parameter doesn't exist return all the subcounties
        if ($id === NULL) {
            //Check if the subcounties data store contains subcounties (in case the database result returns NULL)
            if ($subcounties) {
                //Set the response and exit
                $this->response($subcounties, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No subcounties were found'
                        ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular subcounty.
        else {
            $id = (int) $id;

            // Validate the id.
            if ($id <= 0) {
                // Invalid id, set the response and exit.
                $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            // Get the subcounty from the array, using the id as key for retrieval.
            // Usually a model is to be used for this.

            $subcounty = NULL;

            if (!empty($subcounties)) {
                foreach ($subcounties as $key => $value) {
                    if ($value['id'] == $id) {
                        $subcounty = $value;
                    }
                }
            }

            if (!empty($subcounty)) {
                $this->set_response($subcounty, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'subcounty could not be found'
                        ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function index_post() {
        $data = array(
            'name' => $this->post('name'),
            'county_id' => $this->post('county_id')
        );
        $data = $this->subcounty_model->insert($data);
        if ($data['status']) {
            unset($data['status']);
            $this->set_response($data, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
        } else {
            unset($data['status']);
            $this->set_response([
                'status' => FALSE,
                'message' => 'Error has occurred'
                    ], \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // CREATED (201) being the HTTP response code
        }
    }

    public function index_put() {
        $id = (int) $this->get('id');

        // Validate the id.
        if ($id <= 0) {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $data = array(
            'name' => $this->put('name'),
            'county_id' => $this->put('county_id')
        );
        $data = $this->subcounty_model->update($id, $data);
        if ($data['status']) {
            unset($data['status']);
            $this->set_response($data, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
        } else {
            unset($data['status']);
            $this->set_response([
                'status' => FALSE,
                'message' => 'Error has occurred'
                    ], \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // CREATED (201) being the HTTP response code
        }
    }

    public function index_delete() {
        $id = (int) $this->get('id');

        // Validate the id.
        if ($id <= 0) {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $data = $this->subcounty_model->delete($id);
        if ($data['status']) {
            unset($data['status']);
            $this->set_response([
                'status' => TRUE,
                'message' => 'Data is deleted successfully'
                    ], \API\Libraries\REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
        } else {
            unset($data['status']);
            $this->set_response([
                'status' => FALSE,
                'message' => 'Error has occurred'
                    ], \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // CREATED (201) being the HTTP response code
        }
    }

}
