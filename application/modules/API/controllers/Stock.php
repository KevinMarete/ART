<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'modules/API/models/Stock_model.php';

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

    public function index_get()
    {   
        //Default parameters
        $year = $this->get('year');
        $month = $this->get('month');
        $facility = (int) $this->get('facility');
        $drug = (int) $this->get('drug');

        // If parameters don't exist return all the stock
        if ($facility <= 0 || $drug <= 0)
        {
            // stock from a data store e.g. database
            $stocks = Stock_model::with('facility','drug');
            if(!empty($month)) $stocks = $stocks->where('period_month', $month);
            if(!empty($year)) $stocks = $stocks->where('period_year', $year);
            $stocks = $stocks->get();

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

            $stock = Stock_model::with('facility','drug');
            if(!empty($facility)) $stock = $stock->where('facility_id', $facility);
            if(!empty($drug)) $stock = $stock->where('drug_id', $drug);
            if(!empty($month)) $stock = $stock->where('period_month', $month);
            if(!empty($year)) $stock = $stock->where('period_year', $year);
            $stock = $stock->first();

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
        $stock = new Stock_model;
        $stock->total = $this->post('total');
        $stock->period_year = $this->post('period_year');
        $stock->period_month = $this->post('period_month');
        $stock->facility_id = $this->post('facility_id');
        $stock->drug_id = $this->post('drug_id');
        
        if($stock->save())
        {
            $this->set_response($stock, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
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
        $facility = (int) $this->get('facility');
        $drug = (int) $this->get('drug');

        // Validate facility and drug.
        if ($facility <= 0 || $drug <= 0)
        {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $stock = Stock_model::where('facility_id', $facility)->where('drug_id', $drug);
        if(!empty($month)) $stock = $stock->where('period_month', $month);
        if(!empty($year)) $stock = $stock->where('period_year', $year);
        $stock = $stock->first();
        $stock->total = $this->put('total');
        
        if($stock->save())
        {
            $this->set_response($stock, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
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
        $facility = (int) $this->get('facility');
        $drug = (int) $this->get('drug');

        // Validate facility and drug.
        if ($facility <= 0 || $drug <= 0)
        {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $stock = Stock_model::where('facility_id', $facility)->where('drug_id', $drug);
        if(!empty($month)) $stock = $stock->where('period_month', $month);
        if(!empty($year)) $stock = $stock->where('period_year', $year);
        $deleted = $stock->delete();
        
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
