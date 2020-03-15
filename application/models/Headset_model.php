<?php

class Headset_model extends CI_Model
{
    public function getHeadset($id = null)
    {
        if ($id == null) {
            return $this->db->get('headset')->result_array();
        } else {
            return $this->db->get_where('headset', ['id_headset' => $id])->result_array();
        }
    }

    public function beliHeadset($data,$id){
        $this->db->update('headset',$data, ['id_headset' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteHeadset($id)
    {
        $this->db -> delete('headset', ['id_headset' => $id]);
        return $this->db->affected_rows();
    }

    public function createHeadset($data){
        $this->db->insert('headset', $data);
        return $this->db->affected_rows();
    }

    public function updateHeadset($data, $id){
        $this->db->update('headset',$data, ['id_headset' => $id]);
        return $this->db->affected_rows();
    }
}
