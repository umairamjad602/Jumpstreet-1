<?php
date_default_timezone_set("Asia/Karachi");
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends Admin_Controller
{
	var $currency_code = 'Rs';

	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Orders';

		$this->load->model('model_orders');
		$this->load->model('model_tables');
		$this->load->model('model_products');
		$this->load->model('model_company');
		$this->load->model('model_stores');

		$this->currency_code = $this->company_currency();
	}

	/*
	* It only redirects to the manage order page
	*/
	public function index()
	{
		if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Manage Orders';
		$this->render_template('orders/index', $this->data);
	}

	/*
	* Fetches the orders data from the orders table
	* this function is called from the datatable ajax function
	*/
	public function end_of_the_day(){
		$query = $this->db->query("SELECT * from end_system_date")->result();
		$data = array(
			'dat_esystem' => date('d-m-Y')
		);
		if (!empty($query)) {
			$this->db->where('id', '1');
			$this->db->update('end_system_date', $data);
		}else{
			$this->db->insert('end_system_date', $data);
		}
		redirect('orders/index');
	}
	public function fetchOrdersData()
	{
		if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$result = array('data' => array());

		$data = $this->model_orders->getOrdersData();

		foreach ($data as $key => $value) {

			$store_data = $this->model_stores->getStoresData($value['store_id']);

			$count_total_item = $this->model_orders->countOrderItem($value['id']);
			$date = date('d-m-Y', $value['date_time']);
			$time = date('h:i a', $value['date_time']);
			
			$date_time = $date . ' ' . $time;

			// button
			$buttons = '';

			if(in_array('viewOrder', $this->permission)) {
				$buttons .= '<a target="__blank" href="'.base_url('orders/printDiv/'.$value['id']).'" class="btn btn-default"><i class="fa fa-print"></i></a>';
			}

			if(in_array('updateOrder', $this->permission)) {
				$buttons .= ' <a href="'.base_url('orders/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			}

			if(in_array('deleteOrder', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}

			$buttons .= '&nbsp;&nbsp;<a href="'.base_url('orders/printQT/'.$value['id']).'" target="__blank" class="btn btn-primary" >QT</a>';

			if($value['paid_status'] == 1) {
				$paid_status = '<span class="label label-success">Paid</span>';
			}
			else {
				$paid_status = '<span class="label label-warning">Not Paid</span>';
			}
			$storename = null;
            if(isset($store_data['name']))
                $storename = $store_data['name'];
            elseif (isset($store_data[0]['name']))
                $storename = $store_data[0]['name'];
            $tabelname = $this->model_tables->getTableData($value["table_id"])["table_name"];
			$result['data'][$key] = array(
				$value['id'],
				$storename,
				$tabelname,
				$date_time,
				$count_total_item,
				$value['net_amount'],
				$paid_status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	/*
	* If the validation is not valid, then it redirects to the create page.
	* If the validation for each input field is valid then it inserts the data into the database
	* and it stores the operation message into the session flashdata and display on the manage group page
	*/
	public function create()
	{
		if(!in_array('createOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Add Order';

		$this->form_validation->set_rules('product[]', 'Product name', 'trim|required');
        $this->form_validation->set_rules('table_name[]', 'Table name', 'trim|required');


        if ($this->form_validation->run() == TRUE) {


        	$order_id = $this->model_orders->create();

        	if($order_id) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('orders/update/'.$order_id, 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('orders/create/', 'refresh');
        	}
        }
        else {
            // false case
            $this->data['table_data'] = $this->model_tables->getActiveTable();
        	$company = $this->model_company->getCompanyData(1);
        	$this->data['company_data'] = $company;
        	$this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
        	$this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

        	$this->data['products'] = $this->model_stock->getStockDataSameAsProduct();

            $this->render_template('orders/create', $this->data);
        }
	}

	/*
	* It gets the product id passed from the ajax method.
	* It checks retrieves the particular product data from the product id
	* and return the data into the json format.
	*/
	public function getProductValueById()
	{
		$product_id = $this->input->post('product_id');
		if($product_id) {
			$product_data = $this->model_products->getProductData($product_id);
			echo json_encode($product_data);
		}
	}

	/*
	* It gets the all the active product inforamtion from the product table
	* This function is used in the order page, for the product selection in the table
	* The response is return on the json format.
	*/
	public function getTableProductRow()
	{
		$products = $this->model_stock->getStockDataSameAsProduct();
		echo json_encode($products);
	}

	/*
	* If the validation is not valid, then it redirects to the edit orders page
	* If the validation is successfully then it updates the data into the database
	* and it stores the operation message into the session flashdata and display on the manage group page
	*/
	public function update($id)
	{
		if(!in_array('updateOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		if(!$id) {
			redirect('dashboard', 'refresh');
		}



		$this->data['page_title'] = 'Update Order';

		$this->form_validation->set_rules('product[]', 'Product name', 'trim|required');


        if ($this->form_validation->run() == TRUE) {

        	$update = $this->model_orders->update($id);

        	if($update == true) {
        		$this->session->set_flashdata('success', 'Successfully updated');
        		redirect('orders/update/'.$id, 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('orders/update/'.$id, 'refresh');
        	}
        }
        else {
            // false case
        	$this->data['table_data'] = $this->model_tables->getActiveTable();

        	$company = $this->model_company->getCompanyData(1);
        	$this->data['company_data'] = $company;
        	$this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
        	$this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

        	$result = array();
        	$orders_data = $this->model_orders->getOrdersData($id);

        	if(empty($orders_data)) {
        		$this->session->set_flashdata('errors', 'The request data does not exists');
        		redirect('orders', 'refresh');
        	}

    		$result['order'] = $orders_data;
    		$orders_item = $this->model_orders->getOrdersItemData($orders_data['id']);

    		foreach($orders_item as $k => $v) {
    			$result['order_item'][] = $v;
    		}

    		$table_id = $result['order']['table_id'];
    		$table_data = $this->model_tables->getTableData($table_id);
    		
    		$result['order_table'] = $table_data;

    		$this->data['order_data'] = $result;

        	$this->data['products'] = $this->model_stock->getStockDataSameAsProduct();



            $this->render_template('orders/edit', $this->data);
        }
	}

    public function endOfDay(){

        if(!in_array('endOfDay', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->model_orders->endOfDay();

        $response = array();

        $response['success'] = true;
        $response['messages'] = "Successfully Day Changed";

        echo json_encode($response);
    }

	/*
	* It removes the data from the database
	* and it returns the response into the json format
	*/
	public function remove()
	{
		if(!in_array('deleteOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$order_id = $this->input->post('order_id');

		$query = $this->db->query("SELECT * from orders where id = '$order_id' ")->result();
		// echo "<pre>"; print_r($query); die();

		$table_id = $query[0]->table_id;
		$this->db->set('available', '1');
		$this->db->where('id', $table_id);
		$this->db->update('tables');

        $response = array();
        if($order_id) {
            $delete = $this->model_orders->remove($order_id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed";
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the product information";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refersh the page again!!";
        }

        echo json_encode($response);
	}

	/*
	* It gets the product id and fetch the order data.
	* The order print logic is done here
	*/
	public function printDiv($id)
	{
		if(!in_array('viewOrder', $this->permission)) {
          	redirect('dashboard', 'refresh');
  		}

		if($id) {
			
			$this->db->set('paid_status', '1');
			$this->db->where('id', $id);
			$this->db->update('orders');


			$order_data = $this->model_orders->getOrdersData($id);
			$orders_items = $this->model_orders->getOrdersItemData($id);
			$company_info = $this->model_company->getCompanyData(1);
			$store_data = $this->model_stores->getStoresData($order_data['store_id']);

			$table_id = $order_data['table_id'];
			$this->db->set('available', 1);
			$this->db->where('id', $table_id);
			$this->db->update('tables');

			$order_date = date('d/m/Y h:i:s', $order_data['date_time']);
			$paid_status = ($order_data['paid_status'] == 1) ? "Paid" : "Unpaid";

			$table_data = $this->model_tables->getTableData($order_data['table_id']);

			if ($order_data['discount'] > 0) {
				$discount = $order_data['discount'];
			}
			else {
				$discount = '0';
			}
            $temStoreName = null;
			if(isset($store_data['name']))
			    $temStoreName = $store_data['name'];
			elseif (isset($store_data[0]['name']))
                $temStoreName = $store_data[0]['name'];


			$html = '<!-- Main content -->
			<!DOCTYPE html>
			<html>
			<head>
			  <meta charset="utf-8">
			  <meta http-equiv="X-UA-Compatible" content="IE=edge">
			  <title>Invoice</title>
			  <!-- Tell the browser to be responsive to screen width -->
			  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
			  <!-- Bootstrap 3.3.7 -->
			  <link rel="stylesheet" href="'.base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css').'">
			  <!-- Font Awesome -->
			  <link rel="stylesheet" href="'.base_url('assets/bower_components/font-awesome/css/font-awesome.min.css').'">
			  <link rel="stylesheet" href="'.base_url('assets/dist/css/AdminLTE.min.css').'">
			</head>
			<body onload="window.print();">

			<div class="wrapper">
			  <section class="invoice">
			  <img class="img-thumbnail rounded" src="'.base_url().'/assets/images/JumpStreet2.jpeg" style="margin: auto; display: block; width:100px">
			    <!-- title row -->
			    <div class="row">
			      <div class="col-xs-12">
			        <h2 class="page-header" style="font-weight: 700;">
			          '.$company_info['company_name'].'
			          <small class="pull-right">Date: '.$order_date.'</small>
			        </h2>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- info row -->
			    <div class="row invoice-info">
			    
			      <div class="col-sm-4 invoice-col">
			       
			        <b>Bill ID: </b> '.$order_data['id'].'<br>
			        <b>Store Name: </b> '.$temStoreName.'<br>
			        <b>Table name: </b> '.$table_data['table_name'].'<br>
			        <b>Total items: </b> '.count($orders_items).'<br><br>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->

			    <!-- Table row -->
			    <div class="row">
			      <div class="col-xs-12 table-responsive">
			        <table class="table table-striped">
			          <thead>
			          <tr>
			            <th>Product name</th>
			            <th>Price</th>
			            <th>Qty</th>
			            <th>Amount</th>
			          </tr>
			          </thead>
			          <tbody>';

			          foreach ($orders_items as $k => $v) {

			          	$product_data = $this->model_products->getProductData($v['product_id']);

			          	$html .= '<tr>
				            <td>'.$product_data['name'].'</td>
				            <td>'.$this->currency_code . ' ' .$v['rate'].'</td>
				            <td>'.$v['qty'].'</td>
				            <td>'.$this->currency_code . ' ' .$v['amount'].'</td>
			          	</tr>';
			          }

			          $html .= '</tbody>
			        </table>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->

			    <div class="row">

			      <div class="col-xs-6 pull pull-right">

			        <div class="table-responsive">
			          <table class="table">
			            <tr>
			              <th style="width:50%">Gross Amount:</th>
			              <td>'.$this->currency_code . ' ' .$order_data['gross_amount'].'</td>
			            </tr>';

			            if($order_data['service_charge_amount'] > 0) {
			            	$html .= '<tr>
				              <th>Service Charge ('.$order_data['service_charge_rate'].'%)</th>
				              <td>'.$this->currency_code .' '.$order_data['service_charge_amount'].'</td>
				            </tr>';
			            }

			            if($order_data['vat_charge_amount'] > 0) {
			            	$html .= '<tr>
				              <th>Vat Charge ('.$order_data['vat_charge_rate'].'%)</th>
				              <td>'.$this->currency_code .' '.$order_data['vat_charge_amount'].'</td>
				            </tr>';
			            }


			            $html .=' <tr>
			              <th>Discount in %:</th>
			              <td>'.$discount.'</td>
			            </tr>
			            <tr>
			              <th>Net Amount:</th>
			              <td>'.$this->currency_code . ' ' .$order_data['net_amount'].'</td>
			            </tr>
			            <tr>
			              <th>Paid Status:</th>
			              <td>'.$paid_status.'</td>
			            </tr>
			          </table>
			        </div>
			      </div>
			      <!-- /.col -->
			    </div>
			     <footer>
			        <pre>  Contact:    | Address:
  0533-521000 | Near Science College G.T Road Gujrat,  
              | insta/FB: jumpstreetcafepk 
			    <footer>Its better here </footer>
			    <!-- /.row -->
			  </section>
			  <!-- /.content -->
			</div>
		</body>
	</html>';

			  echo $html;
		}
	}

	public function printQT($id)
	{
		if(!in_array('viewOrder', $this->permission)) {
          	redirect('dashboard', 'refresh');
  		}

		if($id) {
			

			$order_data = $this->model_orders->getOrdersData($id);
			$orders_items = $this->model_orders->getOrdersItemData($id);
			$company_info = $this->model_company->getCompanyData(1);
			$store_data = $this->model_stores->getStoresData($order_data['store_id']);


			$order_date = date('d/m/Y h:i:s', $order_data['date_time']);
			$paid_status = ($order_data['paid_status'] == 1) ? "Paid" : "Unpaid";

			$table_data = $this->model_tables->getTableData($order_data['table_id']);

			if ($order_data['discount'] > 0) {
				$discount = $order_data['discount'];
			}
			else {
				$discount = '0';
			}
            $temStoreName = null;
			if(isset($store_data['name']))
			    $temStoreName = $store_data['name'];
			elseif (isset($store_data[0]['name']))
                $temStoreName = $store_data[0]['name'];


			$html = '<!-- Main content -->
			<!DOCTYPE html>
			<html>
			<head>
			  <meta charset="utf-8">
			  <meta http-equiv="X-UA-Compatible" content="IE=edge">
			  <title>Invoice</title>
			  <!-- Tell the browser to be responsive to screen width -->
			  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
			  <!-- Bootstrap 3.3.7 -->
			  <link rel="stylesheet" href="'.base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css').'">
			  <!-- Font Awesome -->
			  <link rel="stylesheet" href="'.base_url('assets/bower_components/font-awesome/css/font-awesome.min.css').'">
			  <link rel="stylesheet" href="'.base_url('assets/dist/css/AdminLTE.min.css').'">
			</head>
			<body onload="window.print();">

			<div class="wrapper">
			  <section class="invoice">
			  <img class="img-thumbnail rounded" src="'.base_url().'/assets/images/JumpStreet2.jpeg" style="margin: auto; display: block; width:100px">
			    <!-- title row -->
			    <div class="row">
			      <div class="col-xs-12">
			        <h2 class="page-header" style="font-weight: 700;">
			          '.$company_info['company_name'].'
			          <small class="pull-right">Date: '.$order_date.'</small>
			        </h2>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- info row -->
			    <div class="row invoice-info">
			    
			      <div class="col-sm-4 invoice-col">
			       
			        <b>Bill ID: </b> '.$order_data['id'].'<br>
			        <b>Store Name: </b> '.$temStoreName.'<br>
			        <b>Table name: </b> '.$table_data['table_name'].'<br>
			        <b>Total items: </b> '.count($orders_items).'<br><br>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->

			    <!-- Table row -->
			    <div class="row">
			      <div class="col-xs-12 table-responsive">
			        <table class="table table-striped">
			          <thead>
			          <tr>
			            <th>Product name</th>
			            
			            <th>Qty</th>
			            
			          </tr>
			          </thead>
			          <tbody>';

			          foreach ($orders_items as $k => $v) {

			          	$product_data = $this->model_products->getProductData($v['product_id']);

			          	$html .= '<tr>
				            <td>'.$product_data['name'].'</td>
				            <td>'.$v['qty'].'</td>
				            
			          	</tr>';
			          }

			          $html .= '</tbody>
			        </table>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->
			    <!-- /.row -->
			  </section>
			  <!-- /.content -->
			</div>
		</body>
	</html>';

			  echo $html;
		}
	}

}