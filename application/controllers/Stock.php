<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Stock';

        $this->load->model('model_stock');
        $this->load->model('model_products');
        $this->load->model('model_category');

    }

    public function index()
    {
        if(!in_array('viewStock', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->data['products'] = $this->model_products->getActiveProductData();
        $this->data['category'] =  $this->model_category->getActiveCategory();
        $this->data['page_title'] = 'Manage Stock';
        $this->render_template('stock/index', $this->data);
    }

    public function selectProductByCat(){
        $cat_id = $this->input->post('cat_id');
        $response = $this->model_products->getProductDataByCat($cat_id);
        echo json_encode($response);
    }

    public function fetchStockData()
    {
        if(!in_array('viewStock', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_stock->getStockData();

        foreach ($data as $key => $value) {

//            $product_data = $this->model_products->getProductData($value['product_id']);
            $category_data = $this->model_category->getCategoryData($value['category_id']);

            $date_time =  date('Y-m-d h:i:s a');

            $buttons = '';

            if(in_array('updateStock', $this->permission)) {
                $buttons = '<button type="button" class="btn btn-default" onclick="editFunc('.$value['id'].'); getProductByCat_Edit();" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
            }

            if(in_array('deleteStock', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            }

            $result['data'][$key] = array(
//                $product_data['name'],
                $category_data['name'],
                $value['qty'],
                $date_time,
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function create()
    {
        if(!in_array('createStock', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

//        $this->form_validation->set_rules('product', 'Product name', 'trim|required');
        $this->form_validation->set_rules('category', 'Category name', 'trim|required');


        if ($this->form_validation->run() == TRUE) {
            $stock_data = $this->model_stock->getStockData();
            $create = false;
            $flag = true;
            foreach ($stock_data as $k => $v){
//                $this->input->post('product') == $v['product_id'] &&
                if ($this->input->post('category') ==  $v['category_id']){
                    $data = array(
//                        'product_id' => $this->input->post('product'),
                        'category_id' => $this->input->post('category'),
                        'qty' => $this->input->post('qty') + $v['qty'],
                        'date_time' => date('Y-m-d h:i:s a')
                    );
                    $create = $this->model_stock->update($v['id'], $data);
                    $flag = false;
                    break;
                }
            }

            if($flag){
                $data = array(
//                    'product_id' => $this->input->post('product'),
                    'category_id' => $this->input->post('category'),
                    'qty' => $this->input->post('qty'),
                    'date_time' => date('Y-m-d')
                );

                $create = $this->model_stock->create($data);
            }

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

    public function getStockValueById()
    {
        $product_id = $this->input->post('product_id');
        if($product_id) {
            $product_data = $this->model_stock->getStockData($product_id);
            echo json_encode($product_data);
        }
    }

    public function getStockDataByProductId(){
        $id = $this->input->post('product_id');
        if($id != null){
            $stock_data = $this->model_stock->getStockDataByProductId($id);

            echo json_encode( $stock_data );
        }
    }


    public function fetchStockDataById($id = null)
    {
        if($id) {

            $data = $this->model_stock->getStockData($id);
            echo json_encode($data);
        }

    }

    public function getTableProductRow()
    {
        $products = $this->model_products->getActiveProductData();
        echo json_encode($products);
    }

    public function update($id)
    {

        if(!in_array('updateStock', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if($id) {

//            $this->form_validation->set_rules('product', 'Product name', 'trim|required');
            $this->form_validation->set_rules('category', 'Category', 'trim|required');
            $this->form_validation->set_rules('qty', 'Quantaty', 'trim|required');
            $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

            if ($this->form_validation->run() == TRUE) {
                $sum = $this->input->post('qty');
                $stock_data = $this->model_stock->getStockData();
                $update = false;
                $flag = true;
                foreach ($stock_data as $k => $v){
//                    $this->input->post('product') == $v['product_id'] &&
                    if ($this->input->post('category') ==  $v['category_id'] && $v['id'] != $id){
                        $sum += $v['qty'];
                        $delete = $this->model_stock->remove($v['id']);
                        $flag = false;
                    }
                    $data = array(
//                        'product_id' => $this->input->post('product'),
                        'category_id' => $this->input->post('category'),
                        'qty' => $sum,
                        'date_time' => date('Y-m-d h:i:s a')
                    );
                    $update = $this->model_stock->update($id,$data);
                }

                if($flag){
                    $data = array(
//                        'product_id' => $this->input->post('product'),
                        'category_id' => $this->input->post('category'),
                        'qty' => $this->input->post('qty'),
                        'date_time' => strtotime(date('Y-m-d h:i:s a'))//$this->input->post('date_time')
                    );

                    $update = $this->model_stock->update($id, $data);
                }

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
        if(!in_array('deleteStock', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $stock_id = $this->input->post('stock_id');

        $response = array();
        if($stock_id) {
            $delete = $this->model_stock->remove($stock_id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed";
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the stock information";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refersh the page again!!";
        }

        echo json_encode($response);
    }


}
