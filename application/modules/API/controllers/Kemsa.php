<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'modules/API/models/Kemsa_model.php';

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

    public function index_get()
    {   
        //Default parameters
        $year = $this->get('year');
        $month = $this->get('month');
        $drug = (int) $this->get('drug');

        // If parameters don't exist return all the kemsa
        if ($drug <= 0)
        {
            // kemsa from a data store e.g. database
            $kemsas = Kemsa_model::with('drug');
            if(!empty($month)) $kemsas = $kemsas->where('period_month', $month);
            if(!empty($year)) $kemsas = $kemsas->where('period_year', $year);
            $kemsas = $kemsas->get();

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

            $kemsa = Kemsa_model::with('drug');
            if(!empty($drug)) $kemsa = $kemsa->where('drug_id', $drug);
            if(!empty($month)) $kemsa = $kemsa->where('period_month', $month);
            if(!empty($year)) $kemsa = $kemsa->where('period_year', $year);
            $kemsa = $kemsa->first();

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
        $kemsa = new Kemsa_model;
        $kemsa->issue_total = $this->post('issue_total');
        $kemsa->soh_total = $this->post('soh_total');
        $kemsa->supplier_total = $this->post('supplier_total');
        $kemsa->received_total = $this->post('received_total');
        $kemsa->period_year = $this->post('period_year');
        $kemsa->period_month = $this->post('period_month');
        $kemsa->drug_id = $this->post('drug_id');
        
        if($kemsa->save())
        {
            $this->set_response($kemsa, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
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
        $drug = (int) $this->query('drug');

        // Validate drug.
        if ($drug <= 0)
        {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $kemsa = Kemsa_model::where('drug_id', $drug);
        if(!empty($month)) $kemsa = $kemsa->where('period_month', $month);
        if(!empty($year)) $kemsa = $kemsa->where('period_year', $year);
        $kemsa = $kemsa->first();

        $kemsa->issue_total = $this->put('issue_total');
        $kemsa->soh_total = $this->put('soh_total');
        $kemsa->supplier_total = $this->put('supplier_total');
        $kemsa->received_total = $this->put('received_total');
        
        if($kemsa->save())
        {
            $this->set_response($kemsa, \API\Libraries\REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
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
        $drug = (int) $this->query('drug');

        // Validate drug.
        if ($drug <= 0)
        {
            // Set the response and exit
            $this->response(NULL, \API\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $kemsa = Kemsa_model::where('drug_id', $drug);
        if(!empty($month)) $kemsa = $kemsa->where('period_month', $month);
        if(!empty($year)) $kemsa = $kemsa->where('period_year', $year);
        
        $deleted = $kemsa->delete();

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
