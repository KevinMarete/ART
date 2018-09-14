<?php

/**
 * Description of Submodule
 *
 * @author k
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'modules/API/models/Submodule_model.php';

class Submodule extends \API\Libraries\REST_Controller {

    public function index_get() {
        //Default parameters
        $id = $this->get('id');
        $module = $this->get('module');

        //If the id parameter doesn't exist return all the submodules
        if ($id === NULL) {
            //$submodules from a data store e.g. database
            $submodules = Submodule_model::with('module');
            if(!empty($module)) $submodules = $submodules->where('module_id', $module);
            $submodules = $submodules->get();

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

            $submodule = Submodule_model::with('module');
            if(!empty($module)) $submodule = $submodule->where('module_id', $module);
            $submodule = $submodule->where('id', $id)->first();

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
        $submodule = new Submodule_model;
        $submodule->name = $this->post('name');
        $submodule->module_id = $this->post('module_id');

        if ($submodule->save()) {
            $this->set_response($submodule, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Error has occurred'
                    ], \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // CREATED (201) being the HTTP response code
        }
    }

    public function index_put() {
        $id = (int) $this->query('id');

        // Validate the id.
        if ($id <= 0) {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $submodule = Submodule_model::find($id);
        $submodule->name = $this->put('name');
        $submodule->module_id = $this->put('module_id');

        if ($submodule->save()) {
            $this->set_response($submodule, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Error has occurred'
                    ], \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // CREATED (201) being the HTTP response code
        }
    }

    public function index_delete() {
        $id = (int) $this->query('id');

        // Validate the id.
        if ($id <= 0) {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $deleted = Submodule_model::destroy($id);
        if ($deleted) {
            $this->set_response([
                'status' => TRUE,
                'message' => 'Data is deleted successfully'
                    ], \API\Libraries\REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Error has occurred'
                    ], \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // CREATED (201) being the HTTP response code
        }
    }

}
