<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'modules/API/models/Category_model.php';

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

    public function index_get() {
        //Default parameters
        $id = $this->get('id');
        $county = $this->get('county');

        //If the id parameter doesn't exist return all the subcounties
        if ($id === NULL) {
            //Subcounties from a data store e.g. database
            $subcounties = Subcounty_model::with('county');
            if(!empty($county)) $subcounties = $subcounties->where('county_id', $county);
            $subcounties = $subcounties->get();

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
            $subcounty = Subcounty_model::with('county');
            if(!empty($county)) $subcounty = $subcounty->where('county_id', $county);
            $subcounty = $subcounty->first();

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
        $subcounty = new Subcounty_model;
        $subcounty->name = $this->post('name');
        $subcounty->county_id = $this->post('county_id');
        
        if ($subcounty->save()) {
            $this->set_response($subcounty, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
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

        $subcounty = Subcounty_model::find($id);
        $subcounty->name = $this->put('name');
        $subcounty->county_id = $this->put('county_id');

        if ($subcounty->save()) {
            $this->set_response($subcounty, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
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

        $deleted = Subcounty_model::destroy($id);
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
