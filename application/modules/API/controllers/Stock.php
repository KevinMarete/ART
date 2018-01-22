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
class Stock extends \API\Libraries\REST_Controller  {

    function __construct()
    {
        parent::__construct();
        $this->load->model('stock_model');
    }

    public function index_get()
    {   
        //Default parameters
        $year = $this->get('year');
        $month = $this->get('month');
        $facility = (int) $this->get('facility');
        $drug = (int) $this->get('drug');

        //Conditions
        $conditions = array(
            'period_year' => $year,
            'period_month' => $month,
            'facility_id' => $facility,
            'drug_id' => $drug
        );
        $conditions = array_filter($conditions);

        // stock from a data store e.g. database
        $stocks = $this->stock_model->read($conditions);

        // If parameters don't exist return all the stock
        if ($facility <= 0 || $drug <= 0)
        {
            // Check if the stock data store contains stock (in case the database result returns NULL)
            if ($stocks)
            {
                // Set the response and exit
                $this->response($stocks, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No stock was found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular stock.
        else {
            // Validate the id.
            if ($facility <= 0 || $drug <= 0)
            {
                // Invalid id, set the response and exit.
                $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            // Get the stock from the array, using the id as key for retrieval.
            // Usually a model is to be used for this.

            $stock = NULL;

            if (!empty($stocks))
            {      
                foreach ($stocks as $key => $value)
                {   
                    if ($value['period_year'] == $year && $value['period_month'] == $month && $value['facility_id'] == $facility && $value['drug_id'] == $drug)
                    {
                        $stock = $value;
                    }
                }
            }

            if (!empty($stock))
            {
                $this->set_response($stock, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'stock could not be found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function index_post()
    {   
        $data = array(
            'total' => $this->post('total'),
            'period_year' => $this->post('period_year'),
            'period_month' => $this->post('period_month'),
            'facility_id' => $this->post('facility_id'),
            'drug_id' => $this->post('drug_id')
        );
        $data = $this->stock_model->insert($data);
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
        $facility = (int) $this->get('facility');
        $drug = (int) $this->get('drug');

        $conditions = array(
            'period_year' => $this->get('year'),
            'period_month' => $this->get('month'),
            'facility_id' => $facility,
            'drug_id' => $drug
        );

        // Validate facility and drug.
        if ($facility <= 0 || $drug <= 0)
        {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $data = array(
            'total' => $this->put('total')
        );
        $data = $this->stock_model->update($conditions, $data);
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
        $facility = (int) $this->get('facility');
        $drug = (int) $this->get('drug');

        $conditions = array(
            'period_year' => $this->get('year'),
            'period_month' => $this->get('month'),
            'facility_id' => $facility,
            'drug_id' => $drug
        );

        // Validate facility and drug.
        if ($facility <= 0 || $drug <= 0)
        {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $data = $this->stock_model->delete($conditions);
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
