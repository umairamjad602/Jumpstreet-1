<?php


class Model_stock extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

//        $this->load->model('model_products');
//        $this->load->model('model_users');
    }

    public  function getStockDataByProductId($id){
        if($id != null) {
            $sql = "SELECT REPLACE(REPLACE(category_id, '[\"', ''), '\"]', '') as category_id FROM products WHERE id = ?";
            $query = $this->db->query($sql, array($id));
            return $this->getStockDataByCategoryId($query->row_array()['category_id']) ;
        }
    }

    public  function getStockDataByCategoryId($id){
        if($id != null) {
            $sql = "SELECT * FROM stock WHERE category_id = ?";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }
    }


    public function getStockData($id = null)
    {
        if($id) {
            $sql = "SELECT * FROM stock WHERE id = ? ORDER BY id DESC";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT * FROM stock ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();

    }

    public function getStockDataSameAsProduct()
    {
        $sql = "SELECT products.* FROM products join stock ON REPLACE(REPLACE(products.category_id, '[\"', ''), '\"]', '') = stock.category_id";
        $query = $this->db->query($sql);
        return $query->result_array();

    }

//    public function create()
//    {
//        $user_id = $this->session->userdata('id');
//        // get store id from user id
//        $user_data = $this->model_users->getUserData($user_id);
//
//        $data = array(
//            'date_time' => strtotime(date('Y-m-d h:i:s a')),
//            'qty' => $this->input->post('qty'),
//            'category_id' => $this->input->post('category_id'),
//            'product_id' => $this->input->post('product_id'),
//        );
//
//        $insert = $this->db->insert('stock', $data);
//        $stock_id = $this->db->insert_id();
//
//        return ($stock_id) ? $stock_id : false;
//    }

    public function countTotalStock()
    {
        $sql = "SELECT * FROM stock";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }


//    public function update($id)
//    {
//        if($id) {
//
//            $data = array(
//                'date_time' => strtotime(date('Y-m-d h:i:s a')),
//                'qty' => $this->input->post('qty'),
//                'category_id' => $this->input->post('category_id'),
//                'product_id' => $this->input->post('product_id'),
//            );
//
//            $this->db->where('id', $id);
//            $update = $this->db->update('stock', $data);
//
//            return true;
//        }
//        return false;
//    }

    public function create($data = array())
    {
        if($data) {
            $create = $this->db->insert('stock', $data);
            return ($create == true) ? true : false;
        }
    }

    public function update($id = null, $data = array())
    {
        if($id != null && $data) {
            $this->db->where('id', $id);
            $update = $this->db->update('stock', $data);
            return ($update == true) ? true : false;
        }
    }

    public function remove($id)
    {
        if($id) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('stock');

            return ($delete == true) ? true : false;
        }
    }
}
