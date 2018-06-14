<?php

/**
 * Description of Submodule
 *
 * @author k
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Submodule extends \API\Libraries\REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('submodule_model');
    }

    public function index_get() {
        //Default parameters
        $id = $this->get('id');
        $module = $this->get('module');

        //Conditions
        $conditions = array(
            'id' => $id,
            'module_id' => $module
        );
        $conditions = array_filter($conditions);

        //$submodules from a data store e.g. database
        $submodules = $this->submodule_model->read($conditions);
//        $submodules = $this->submodule_model->read();
        //If the id parameter doesn't exist return all the submodules
        if ($id === NULL) {
            //Check if the submodules data store contains submodules (in case the database result returns NULL)
            if ($submodules) {
                //Set the response and exit
                $this->response($submodules, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No submodules were found'
                        ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular submodule.
        else {
            $id = (int) $id;

            // Validate the id.
            if ($id <= 0) {
                // Invalid id, set the response and exit.
                $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            // Get the submodule from the array, using the id as key for retrieval.
            // Usually a model is to be used for this.

            $submodule = NULL;

            if (!empty($submodules)) {
                foreach ($submodules as $key => $value) {
                    if ($value['id'] == $id) {
                        $submodule = $value;
                    }
                }
            }

            if (!empty($submodule)) {
                $this->set_response($submodule, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'submodule could not be found'
                        ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function index_post() {
        $data = array(
            'name' => $this->post('name'),
            'module_id' => $this->post('module_id')
        );
        $data = $this->submodule_model->insert($data);
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
            'module_id' => $this->put('module_id')
        );
        $data = $this->submodule_model->update($id, $data);
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

        $data = $this->submodule_model->delete($id);
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
