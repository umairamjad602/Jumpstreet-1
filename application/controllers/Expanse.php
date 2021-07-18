<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Expanse extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();
        $this->load->model('model_expanse');
        $this->data['page_title'] = ' Expanse';
    }

    public function index()
    {
        if(!in_array('viewExpanse', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->data['page_title'] = 'Manage Daily Expanse';
        $this->render_template('expanse/index', $this->data);
    }

    public function fetchExpanseData()
    {
        if(!in_array('viewExpanse', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_expanse->getExpanseData();

        foreach ($data as $key => $value) {

            $buttons = '';

            if(in_array('updateExpanse', $this->permission)) {
                $buttons = '<button type="button" class="btn btn-default" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
            }

            if(in_array('deleteExpanse', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            }

            $result['data'][$key] = array(
                $value['expanse_date'],
                $value['comment'],
                $value['amount'],
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function create()
    {
        if(!in_array('createExpanse', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if (true) {
            $data = array(
                'expanse_date' => $this->input->post('expanse_date'),
                'comment' => $this->input->post('comment'),
                'amount' => $this->input->post('amount'),
            );

            $create = $this->model_expanse->create($data);

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

        if(!in_array('updateExpanse', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if($id != null) {

            if (TRUE) {

                $data = array(
                    'expanse_date' => $this->input->post('edit_expanse_date'),
                    'comment' => $this->input->post('edit_comment'),
                    'amount' => $this->input->post('edit_amount'),
                );

                $update = $this->model_expanse->update($id, $data);
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
        if(!in_array('deleteExpanse', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $expanse_id = $this->input->post('expanse_id');

        $response = array();
        if($expanse_id == 0 || $expanse_id) {
            $delete = $this->model_expanse->remove($expanse_id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed";
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the expanse information";
            }
        }else {
            $response['success'] = false;
            $response['messages'] = "Refersh the page again!!";
        }

        echo json_encode($response);
    }


    public function getExpanseValueById()
    {
        $expanse_id = $this->input->post('id');
        if($expanse_id) {
            $expanse_data = $this->model_expanse->getExpanseData($expanse_id);
            echo json_encode($expanse_data);
        }
    }

    public function fetchExpanseDataById($id = null)
    {
        if($id != null) {
            $data = $this->model_expanse->getExpanseData($id);
            echo json_encode($data);
        }

    }


}