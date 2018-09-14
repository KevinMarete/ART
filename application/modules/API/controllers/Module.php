<?php

/**
 * Description of Module
 *
 * @author k
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'modules/API/models/Module_model.php';

class Module extends \API\Libraries\REST_Controller {

    public function index_get() {
        $id = $this->get('id');

        // If the id parameter doesn't exist return all the modules
        if ($id === NULL) {
            // modules from a data store e.g. database
            $modules = Module_model::all();
    
            // Check if the modules data store contains modules (in case the database result returns NULL)
            if ($modules) {
                // Set the response and exit
                $this->response($modules, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No modules were found'
                        ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular module.
        else {
            $id = (int) $id;

            // Validate the id.
            if ($id <= 0) {
                // Invalid id, set the response and exit.
                $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            // Get the module from the array, using the id as key for retrieval.
            // Usually a model is to be used for this.

            $module = Module_model::find($id);

            if (!empty($module)) {
                $this->set_response($module, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'module could not be found'
                        ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function index_post() {
        $module = new Module_model;
        $module->name = $this->post('name');
        $module->icon = $this->post('icon');

        if ($module->save()) {
            $this->set_response($module, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
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

        $module = Module_model::find($id);
        $module->name = $this->put('name');
        $module->icon = $this->put('icon');

        if ($module->save()) {
            $this->set_response($module, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
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

        $deleted = Module_model::destroy($id);
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
