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
class Kemsa extends \API\Libraries\REST_Controller  {

    function __construct()
    {
        parent::__construct();
        $this->load->model('kemsa_model');
    }

    public function index_get()
    {   
        //Default parameters
        $year = $this->get('year');
        $month = $this->get('month');
        $drug = (int) $this->get('drug');

        //Conditions
        $conditions = array(
            'period_year' => $year,
            'period_month' => $month,
            'drug_id' => $drug
        );
        $conditions = array_filter($conditions);

        // kemsa from a data store e.g. database
        $kemsas = $this->kemsa_model->read($conditions);

        // If parameters don't exist return all the kemsa
        if ($drug <= 0)
        {
            // Check if the kemsa data store contains kemsa (in case the database result returns NULL)
            if ($kemsas)
            {
                // Set the response and exit
                $this->response($kemsas, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No kemsa was found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular kemsa.
        else {
            // Validate the id.
            if ($drug <= 0)
            {
                // Invalid id, set the response and exit.
                $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            // Get the kemsa from the array, using the id as key for retrieval.
            // Usually a model is to be used for this.

            $kemsa = NULL;

            if (!empty($kemsas))
            {      
                foreach ($kemsas as $key => $value)
                {   
                    if ($value['period_year'] == $year && $value['period_month'] == $month && $value['drug_id'] == $drug)
                    {
                        $kemsa = $value;
                    }
                }
            }

            if (!empty($kemsa))
            {
                $this->set_response($kemsa, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'kemsa could not be found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function index_post()
    {   
        $data = array(
            'issue_total' => $this->post('issue_total'),
            'soh_total' => $this->post('soh_total'),
            'supplier_total' => $this->post('supplier_total'),
            'received_total' => $this->post('received_total'),
            'period_year' => $this->post('period_year'),
            'period_month' => $this->post('period_month'),
            'drug_id' => $this->post('drug_id')
        );
        $data = $this->kemsa_model->insert($data);
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
        $drug = (int) $this->get('drug');

        $conditions = array(
            'period_year' => $this->get('year'),
            'period_month' => $this->get('month'),
            'drug_id' => $drug
        );

        // Validate drug.
        if ($drug <= 0)
        {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $data = array(
            'issue_total' => $this->put('issue_total'),
            'soh_total' => $this->put('soh_total'),
            'supplier_total' => $this->put('supplier_total'),
            'received_total' => $this->put('received_total')
        );
        $data = $this->kemsa_model->update($conditions, $data);
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
        $drug = (int) $this->get('drug');

        $conditions = array(
            'period_year' => $this->get('year'),
            'period_month' => $this->get('month'),
            'drug_id' => $drug
        );

        // Validate drug.
        if ($drug <= 0)
        {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $data = $this->kemsa_model->delete($conditions);
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
