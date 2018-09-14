<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'modules/API/models/Consumption_model.php';

/**
 *
 * @package         ART
 * @subpackage      API
 * @category        Controller
 * @author          Kevin Marete
 * @license         MIT
 * @link            https://github.com/KevinMarete/ART
 */
class Consumption extends \API\Libraries\REST_Controller  {

    public function index_get()
    {   
        //Default parameters
        $year = $this->get('year');
        $month = $this->get('month');
        $facility = (int) $this->get('facility');
        $drug = (int) $this->get('drug');

        // If parameters don't exist return all the consumption
        if ($facility <= 0 || $drug <= 0)
        {
            // consumption from a data store e.g. database
            $consumptions = Consumption_model::with('facility');
            if(!empty($year)) $consumptions = $consumptions->where('period_year', $year);
            if(!empty($month)) $consumptions = $consumptions->where('period_month', $month);
            if(!empty($facility)) $consumptions = $consumptions->where('facility_id', $facility);
            if(!empty($drug)) $consumptions = $consumptions->where('drug_id', $drug);
            $consumptions = $consumptions->get();

            // Check if the consumption data store contains consumption (in case the database result returns NULL)
            if ($consumptions)
            {
                // Set the response and exit
                $this->response($consumptions, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No consumption was found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular consumption.
        else {
            // Validate the facility/drug.
            if ($facility <= 0 || $drug <= 0)
            {
                // Invalid id, set the response and exit.
                $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            // Get the consumption from the array, using the id as key for retrieval.
            // Usually a model is to be used for this.

            $consumptions = Consumption_model::with('facility');
            if(!empty($year)) $consumptions = $consumptions->where('period_year', $year);
            if(!empty($month)) $consumptions = $consumptions->where('period_month', $month);
            if(!empty($facility)) $consumptions = $consumptions->where('facility_id', $facility);
            if(!empty($drug)) $consumptions = $consumptions->where('drug_id', $drug);
            $consumptions = $consumptions->first();

            if (!empty($consumption))
            {
                $this->set_response($consumption, \API\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'consumption could not be found'
                ], \API\Libraries\REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function index_post()
    {   
        $consumption = new Consumption_model;
        $consumption->total = $this->post('total');
        $consumption->period_year = $this->post('period_year');
        $consumption->period_month = $this->post('period_month');
        $consumption->facility_id = $this->post('facility_id');
        $consumption->drug_id = $this->post('drug_id');

        if($consumption->save())
        {
            $this->set_response($consumption, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
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
        $facility = (int) $this->query('facility');
        $drug = (int) $this->query('drug');
        $year = $this->query('year');
        $month = $this->query('month');

        // Validate facility and drug.
        if ($facility <= 0 || $drug <= 0)
        {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $consumption = Consumption_model::with('facility');
        if(!empty($year)) $consumption = $consumption->where('period_year', $year);
        if(!empty($month)) $consumption = $consumption->where('period_month', $month);
        if(!empty($facility)) $consumption = $consumption->where('facility_id', $facility);
        if(!empty($drug)) $consumption = $consumption->where('drug_id', $drug);
        $consumption = $consumption->first();

        $consumption->total = $this->put('total');

        if($consumption->save())
        {
            $this->set_response($consumption, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
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
        $facility = (int) $this->query('facility');
        $drug = (int) $this->query('drug');
        $year = $this->query('year');
        $month = $this->query('month');

        // Validate facility and drug.
        if ($facility <= 0 || $drug <= 0)
        {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $consumption = Consumption_model::with('facility');
        if(!empty($year)) $consumption = $consumption->where('period_year', $year);
        if(!empty($month)) $consumption = $consumption->where('period_month', $month);
        if(!empty($facility)) $consumption = $consumption->where('facility_id', $facility);
        if(!empty($drug)) $consumption = $consumption->where('drug_id', $drug);
        $deleted = $consumption->delete();

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
