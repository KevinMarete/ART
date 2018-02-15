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
class Install extends \API\Libraries\REST_Controller  {

    function __construct()
    {
        parent::__construct();
        $this->load->model('install_model');
    }

    public function index_get()
    {
        // installs from a data store e.g. database
        $installs = $this->install_model->read();

        $id = $this->get('id');

        // If the id parameter doesn't exist return all the installs
        if ($id === NULL)
        {
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

            $install = NULL;

            if (!empty($installs))
            {      
                foreach ($installs as $key => $value)
                {   
                    if ($value['id'] == $id)
                    {
                        $install = $value;
                    }
                }
            }

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
        $data = array(
            'version' => $this->post('version'),
            'setup_date' => $this->post('setup_date'),
            'upgrade_date' => $this->post('upgrade_date'),
            'comments' => $this->post('comments'),
            'contact_name' => $this->post('contact_name'),
            'contact_phone' => $this->post('contact_phone'),
            'emrs_used' => $this->post('emrs_used'),
            'active_patients' => $this->post('active_patients'),
            'is_internet' => $this->post('is_internet'),
            'is_usage' => $this->post('is_usage'),
            'facility_id' => $this->post('facility_id'),
            'user_id' => $this->post('user_id')
        );
        $data = $this->install_model->insert($data);
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
        $id = (int) $this->get('id');

        // Validate the id.
        if ($id <= 0)
        {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $data = array(
            'version' => $this->put('version'),
            'setup_date' => $this->put('setup_date'),
            'upgrade_date' => $this->put('upgrade_date'),
            'comments' => $this->put('comments'),
            'contact_name' => $this->put('contact_name'),
            'contact_phone' => $this->put('contact_phone'),
            'emrs_used' => $this->put('emrs_used'),
            'active_patients' => $this->put('active_patients'),
            'is_internet' => $this->put('is_internet'),
            'is_usage' => $this->put('is_usage'),
            'facility_id' => $this->put('facility_id'),
            'user_id' => $this->put('user_id')
        );
        $data = $this->install_model->update($id, $data);
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
        $id = (int) $this->get('id');

        // Validate the id.
        if ($id <= 0)
        {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $data = $this->install_model->delete($id);
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
