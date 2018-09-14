<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'modules/API/models/Install_model.php';

/**
 *
 * @package         ART
 * @subpackage      API
 * @category        Controller
 * @author          Kevin Marete
 * @license         MIT
 * @link            https://github.com/KevinMarete/ART
 */
class Install extends \API\Libraries\REST_Controller  {

    public function index_get()
    {
        $id = $this->get('id');

        // If the id parameter doesn't exist return all the installs
        if ($id === NULL)
        {
            // installs from a data store e.g. database
            $installs = Install_model::with('facility','user')->get();
    
            // Check if the installs data store contains installs (in case the database result returns NULL)
            if ($installs)
            {
                // Set the response and exit
                $this->response($installs, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No installs were found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular install.
        else {
            $id = (int) $id;

            // Validate the id.
            if ($id <= 0)
            {
                // Invalid id, set the response and exit.
                $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            // Get the install from the array, using the id as key for retrieval.
            // Usually a model is to be used for this.

            $install = Install_model::with('facility','user')->find($id);

            if (!empty($install))
            {
                $this->set_response($install, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'install could not be found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function index_post()
    {   
        $install = new Install_model;
        $install->version = $this->post('version');
        $install->setup_date = $this->post('setup_date');
        $install->upgrade_date = $this->post('update_date');
        $install->comments = $this->post('comments');
        $install->contact_name = $this->post('contact_name');
        $install->contact_phone = $this->post('contact_phone');
        $install->emrs_used = $this->post('emrs_used');
        $install->active_patients = $this->post('active_patients');
        $install->is_internet = $this->post('is_internet');
        $install->is_usage = $this->post('is_usage');
        $install->facility_id = $this->post('facility_id');
        $install->user_id = $this->post('user_id');
        
        if($install->save())
        {
            $this->set_response($install, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
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

        $install = Install_model::find($id);
        $install->version = $this->put('version');
        $install->setup_date = $this->put('setup_date');
        $install->upgrade_date = $this->put('upgrade_date');
        $install->comments = $this->put('comments');
        $install->contact_name = $this->put('contact_name');
        $install->contact_phone = $this->put('contact_phone');
        $install->emrs_used = $this->put('emrs_used');
        $install->active_patients = $this->put('active_patients');
        $install->is_internet = $this->put('is_internet');
        $install->is_usage = $this->put('is_usage');
        $install->facility_id = $this->put('facility_id');
        $install->user_id = $this->put('user_id');
        
        if($install->save())
        {
            $this->set_response($install, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
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

        $deleted = Install_model::destroy($id);
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
