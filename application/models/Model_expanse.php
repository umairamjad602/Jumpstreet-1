<?php


class Model_expanse extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getExpanseData($id = null)
    {
        if($id != null) {
            $sql = "SELECT * FROM expanse WHERE id = ? ORDER BY id DESC";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT * FROM expanse ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function countTotalExpanse()
    {
        $sql = "SELECT * FROM expanse";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    public function create($data = array())
    {
        if($data) {
            $create = $this->db->insert('expanse', $data);
            return ($create == true) ? true : false;
        }
    }

    public function update($id = null, $data = array())
    {
        if($id != null && $data) {
            $this->db->where('id', $id);
            $update = $this->db->update('expanse', $data);
            return ($update == true) ? true : false;
        }
    }

    public function remove($id)
    {
        if($id != null) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('expanse');
            return ($delete == true) ? true : false;
        }
    }

}