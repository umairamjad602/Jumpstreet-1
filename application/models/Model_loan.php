<?php


class Model_loan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getLoanData($id = null)
    {
        if($id != null) {
            $sql = "SELECT * FROM loan WHERE id = ? ORDER BY id DESC";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT * FROM loan ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function countTotalLoan()
    {
        $sql = "SELECT * FROM loan";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    public function create($data = array())
    {
        if($data) {
            $create = $this->db->insert('loan', $data);
            return ($create == true) ? true : false;
        }
    }

    public function update($id = null, $data = array())
    {
        if($id != null && $data) {
            $this->db->where('id', $id);
            $update = $this->db->update('loan', $data);
            return ($update == true) ? true : false;
        }
    }

    public function remove($id)
    {
        if($id != null) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('loan');
            return ($delete == true) ? true : false;
        }
    }

}