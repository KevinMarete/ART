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
class Visit_item extends \API\Libraries\REST_Controller  {

    function __construct()
    {
        parent::__construct();
        $this->load->model('visit_item_model');
    }

    public function index_get()
    {   
        //Default parameters
        $id = (int) $this->get('id');
        $visit = (int) $this->get('visit');
        $drug = (int) $this->get('drug');

        //Conditions
        $conditions = array(
            'id' => $id,
            'visit_id' => $visit,
            'drug_id' => $drug
        );
        $conditions = array_filter($conditions);

        // visit_item from a data store e.g. database
        $visit_items = $this->visit_item_model->read($conditions);

        // If parameters don't exist return all the visit_item
        if ($id <= 0 || $visit <= 0 || $drug <= 0)
        {
            // Check if the visit_item data store contains visit_item (in case the database result returns NULL)
            if ($visit_items)
            {
                // Set the response and exit
                $this->response($visit_items, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No visit_item was found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular visit_item.
        else {
            // Validate the id/visit/drug.
            if ($id <= 0 || $visit <= 0 || $drug <= 0)
            {
                // Invalid id, set the response and exit.
                $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            // Get the visit_item from the array, using the id as key for retrieval.
            // Usually a model is to be used for this.

            $visit_item = NULL;

            if (!empty($visit_items))
            {      
                foreach ($visit_items as $key => $value)
                {   
                    if ($value['id'] == $id && $value['visit_id'] == $visit && $value['drug_id'] == $drug)
                    {
                        $visit_item = $value;
                    }
                }
            }

            if (!empty($visit_item))
            {
                $this->set_response($visit_item, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'visit_item could not be found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function index_post()
    {   
        $data = array(
            'quantity' => $this->post('quantity'),
            'duration' => $this->post('duration'),
            'pill_count_adherence' => $this->post('pill_count_adherence'),
            'self_reporting_adherence' => $this->post('self_reporting_adherence'),
            'visit_id' => $this->post('visit_id'),
            'dose_id' => $this->post('dose_id'),
            'drug_id' => $this->post('drug_id'),
            'drug_name' => $this->post('drug_name'),
            'packsize' => $this->post('packsize')
        );
        $data = $this->visit_model->insert($data);
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
            'quantity' => $this->put('quantity'),
            'duration' => $this->put('duration'),
            'pill_count_adherence' => $this->put('pill_count_adherence'),
            'self_reporting_adherence' => $this->put('self_reporting_adherence'),
            'visit_id' => $this->put('visit_id'),
            'dose_id' => $this->put('dose_id'),
            'drug_id' => $this->put('drug_id'),
            'drug_name' => $this->put('drug_name'),
            'packsize' => $this->put('packsize')
        );
        $data = $this->visit_model->update($id, $data);
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

        $data = $this->visit_model->delete($id);
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
