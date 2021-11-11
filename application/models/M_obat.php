<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_obat extends CI_Model
{

   public function get_data_obat()
   {
      return $this->db->where('is_deleted', 0)->where('is_active', 1)->order_by('obatalkes_id', 'desc')->get('obatalkes_m')->result();
   }

   public function get_data_obat_byid($obatalkes_id)
   {
      return $this->db->where('obatalkes_id', $obatalkes_id)->get('obatalkes_m')->result();
   }

   public function insert_obat($data_obat)
   {
      $this->db->trans_begin();
      $this->db->insert('obatalkes_m', $data_obat);

      if ($this->db->trans_status() == FALSE) {
         $this->db->trans_rollback();
         $result = 0;
      } else {
         $this->db->trans_commit();
         $result = 1;
      }
      return $result;
      return TRUE;
   }

   public function update_obat($data_obat, $obatalkes_id)
   {
      $this->db->where('obatalkes_id', $obatalkes_id)->update('obatalkes_m', $data_obat);
      return TRUE;
   }

   public function delete_obat($obatalkes_id, $log)
   {
      $this->db->query("UPDATE obatalkes_m SET is_deleted = 1, deleted_date = now(), deleted_by = $log WHERE obatalkes_id = $obatalkes_id");
      return TRUE;
   }
}
