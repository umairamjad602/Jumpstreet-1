<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Loan extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();
        $this->load->model('model_loan');
        $this->data['page_title'] = 'Loan';
    }

    public function index()
    {
        if(!in_array('viewLoan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->data['page_title'] = 'Manage Loan';
        $this->render_template('Loan/index', $this->data);
    }

    public function fetchLoanData()
    {
        if(!in_array('viewLoan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_loan->getLoanData();

        foreach ($data as $key => $value) {

            $buttons = '';

            if(in_array('updateLoan', $this->permission)) {
                $buttons = '<button type="button" class="btn btn-default" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
            }

            if(in_array('deleteLoan', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            }

            $result['data'][$key] = array(
                $value['geter_name'],
                $value['phoneno'],
                $value['cnicno'],
                $value['given_date'],
                $value['receiving_date'],
                $value['amount'],
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function create()
    {
        if(!in_array('createLoan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if (true) {
            $data = array(
                'geter_name' => $this->input->post('geter_name'),
                'phoneno' => $this->input->post('phoneno'),
                'cnicno' => $this->input->post('cnicno'),
                'given_date' => $this->input->post('given_date'),
                'receiving_date' => $this->input->post('receiving_date'),
                'amount' => $this->input->post('amount'),
            );

            $create = $this->model_loan->create($data);

            if($create == true) {
                $response['success'] = true;
                $response['messages'] = 'Succesfully created';
            }
            else {
                $response['success'] = false;
                $response['messages'] = 'Error in the database while creating the brand information';
            }
        }
        else {
            $response['success'] = false;
            foreach ($_POST as $key => $value) {
                $response['messages'][$key] = form_error($key);
            }
        }

        echo json_encode($response);
    }




    public function update($id)
    {

        if(!in_array('updateLoan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if($id != null) {

            $this->form_validation->set_rules('geter_name', 'Geter Name', 'trim|required');
            $this->form_validation->set_rules('given_date', 'Given Date', 'trim|required');
            $this->form_validation->set_rules('receiving_date', 'Receiving Date', 'trim|required');
            $this->form_validation->set_rules('amount', 'Amount ', 'trim|required');
            $this->form_validation->set_rules('paid_status', 'Paid Status', 'trim|required');
            $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

            if (TRUE) {

                $data = array(
                    'geter_name' => $this->input->post('edit_geter_name'),
                    'phoneno' => $this->input->post('edit_phoneno'),
                    'cnicno' => $this->input->post('edit_cnicno'),
                    'given_date' => $this->input->post('edit_given_date'),
                    'receiving_date' => $this->input->post('edit_receiving_date'),
                    'amount' => $this->input->post('edit_amount'),
                );

                $update = $this->model_loan->update($id, $data);
                if($update == true) {
                    $response['success'] = true;
                    $response['messages'] = 'Succesfully updated';
                }
                else {
                    $response['success'] = false;
                    $response['messages'] = 'Error in the database while updated the brand information';
                }
            }
            else {
                $response['success'] = false;
                foreach ($_POST as $key => $value) {
                    $response['messages'][$key] = form_error($key);
                }
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = 'Error please refresh the page again!!';
        }

        echo json_encode($response);
    }

    public function remove()
    {
        if(!in_array('deleteLoan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $loan_id = $this->input->post('loan_id');

        $response = array();
        if($loan_id == 0 || $loan_id) {
            $delete = $this->model_loan->remove($loan_id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed";
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the loan information";
            }
        }else {
            $response['success'] = false;
            $response['messages'] = "Refersh the page again!!";
        }

        echo json_encode($response);
    }


    public function getLoanValueById()
    {
        $loan_id = $this->input->post('id');
        if($loan_id) {
            $loan_data = $this->model_loan->getLoanData($loan_id);
            echo json_encode($loan_data);
        }
    }

    public function fetchLoanDataById($id = null)
    {
        if($id != null) {
            $data = $this->model_loan->getLoanData($id);
            echo json_encode($data);
        }

    }


}