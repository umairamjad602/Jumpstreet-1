<?php

class Model_orders extends CI_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_tables');
		$this->load->model('model_users');
        $this->load->model('model_stock');
	}

	/* get the orders data */
	public function getOrdersData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM orders WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$user_id = $this->session->userdata('id');

		if($user_id == 1) {
			$sql = "SELECT * FROM orders ORDER BY id DESC";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		else {
			$user_data = $this->model_users->getUserData($user_id);
			$sql = "SELECT * FROM orders WHERE store_id IN (" . implode(',', json_decode($user_data['store_id'])) . ") ORDER BY id DESC";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	}

	// get the orders item data
	public function getOrdersItemData($order_id = null)
	{
		if(!$order_id) {
			return false;
		}

		$sql = "SELECT * FROM order_items WHERE order_id = ?";
		$query = $this->db->query($sql, array($order_id));
		return $query->result_array();
	}

	public function create()
	{
		$user_id = $this->session->userdata('id');
		// get store id from user id
//		$user_data = $this->model_users->getUserData($user_id);
		$tabel_id = $this->input->post('table_name');
		$store_id = $this->model_tables->getTableData($tabel_id)['store_id'];
		$date_sys = $this->db->query("SELECT * from end_system_date ")->result(); 
		$bill_no = 'BILPR-'.strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4));
		$date_ord =  date('h:i a');
		$ord_date = $date_ord." ".$date_sys[0]->dat_esystem;
    	$data = array(
    		'bill_no' => $bill_no,
    		'date_time' => strtotime($ord_date),
    		'gross_amount' => $this->input->post('gross_amount_value'),
    		'service_charge_rate' => $this->input->post('service_charge_rate'),
    		'service_charge_amount' => ($this->input->post('service_charge_value') > 0) ?$this->input->post('service_charge_value'):0,
    		'vat_charge_rate' => $this->input->post('vat_charge_rate'),
    		'vat_charge_amount' => ($this->input->post('vat_charge_value') > 0) ? $this->input->post('vat_charge_value') : 0,
    		'net_amount' => $this->input->post('net_amount_value'),
    		'discount' => $this->input->post('discount'),
    		'paid_status' => 2,
    		'user_id' => $user_id,
    		'table_id' => $this->input->post('table_name'),
    		'store_id' => $store_id,
    	);

		$insert = $this->db->insert('orders', $data);
		$order_id = $this->db->insert_id();

		$count_product = count($this->input->post('product'));

    	for($x = 0; $x < $count_product; $x++) {
            $product_id = $this->input->post('product')[$x];
            $product_qty = $this->input->post('qty')[$x];

            $stock_data = $this->model_stock->getStockDataByProductId($product_id);

            if($product_qty > $stock_data['qty']){
                return false;
            }else{
                $data = array(
                    'category_id' => $stock_data['category_id'],
                    'qty' => $stock_data['qty'] - $product_qty,
                    'date_time' => $stock_data['date_time']
                );

                $res = $this->model_stock->update($stock_data['id'],$data);

                if(!$res)
                    return false;
            }


    		$items = array(
    			'order_id' => $order_id,
    			'product_id' => $this->input->post('product')[$x],
    			'qty' => $this->input->post('qty')[$x],
    			'rate' => $this->input->post('rate_value')[$x],
    			'amount' => $this->input->post('amount_value')[$x],
    		);

    		$this->db->insert('order_items', $items);
    	}

    	// update the table status
    	$this->load->model('model_tables');
    	$this->model_tables->update($this->input->post('table_name'), array('available' => 2));

		return ($order_id) ? $order_id : false;
	}

	public function countOrderItem($order_id)
	{
		if($order_id) {
			$sql = "SELECT * FROM order_items WHERE order_id = ?";
			$query = $this->db->query($sql, array($order_id));
			return $query->num_rows();
		}
	}

	public function endOfDay(){

        $sql = "SELECT date_time FROM `orders` ORDER by id DESC LIMIT 1";
        $query = $this->db->query($sql);
        $last_date = $query->row_array()['date_time'];


        $data = array(
            'date_time' => $last_date,
            'is_day_end' => 1,
        );

        $this->db->where('is_day_end', 0);
        $update = $this->db->update('orders', $data);

    }

	public function update($id)
	{
		if($id) {
			$user_id = $this->session->userdata('id');
			$user_data = $this->model_users->getUserData($user_id);
//			$store_id = $user_data['store_id'];
            $order_data = $this->getOrdersData($id);
            $store_id = $this->model_tables->getTableData($order_data['table_id'])['store_id'];
			// update the table info


			$data = $this->model_tables->update($order_data['table_id'], array('available' => 1));

			if($this->input->post('paid_status') == 1) {
	    		$this->model_tables->update($this->input->post('table_name'), array('available' => 1));
	    	}
	    	else {
	    		$this->model_tables->update($this->input->post('table_name'), array('available' => 2));
	    	}

			$data = array(
	    		'gross_amount' => $this->input->post('gross_amount_value'),
	    		'service_charge_rate' => $this->input->post('service_charge_rate'),
	    		'service_charge_amount' => ($this->input->post('service_charge_value') > 0) ?$this->input->post('service_charge_value'):0,
	    		'vat_charge_rate' => $this->input->post('vat_charge_rate'),
	    		'vat_charge_amount' => ($this->input->post('vat_charge_value') > 0) ? $this->input->post('vat_charge_value') : 0,
	    		'net_amount' => $this->input->post('net_amount_value'),
	    		'discount' => $this->input->post('discount'),
	    		'paid_status' => $this->input->post('paid_status'),
	    		'user_id' => $user_id,
	    		'table_id' => $this->input->post('table_name'),
	    		'store_id' => $store_id
	    	);

			$this->db->where('id', $id);
			$update = $this->db->update('orders', $data);

			// now remove the order item data
			$this->db->where('order_id', $id);
			$this->db->delete('order_items');

			$count_product = count($this->input->post('product'));
	    	for($x = 0; $x < $count_product; $x++) {
	    		$items = array(
	    			'order_id' => $id,
	    			'product_id' => $this->input->post('product')[$x],
	    			'qty' => $this->input->post('qty')[$x],
	    			'rate' => $this->input->post('rate_value')[$x],
	    			'amount' => $this->input->post('amount_value')[$x],
	    		);
	    		$this->db->insert('order_items', $items);
	    	}




			return true;
		}
	}



	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('orders');

			$this->db->where('order_id', $id);
			$delete_item = $this->db->delete('order_items');
			return ($delete == true && $delete_item) ? true : false;
		}
	}

	public function countTotalPaidOrders()
	{
		$sql = "SELECT * FROM orders WHERE paid_status = ?";
		$query = $this->db->query($sql, array(1));
		return $query->num_rows();
	}

}
