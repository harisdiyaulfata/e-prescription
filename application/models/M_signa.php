<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_signa extends CI_Model
{

   public function get_data_signa()
   {
      return $this->db->where('is_deleted', 0)->where('is_active', 1)->order_by('signa_id', 'desc')->get('signa_m')->result();
   }

   public function get_data_signa_byid($signa_id)
   {
      return $this->db->where('signa_id', $signa_id)->get('signa_m')->result();
   }

   public function insert_signa($data_signa)
   {
      $this->db->trans_begin();
      $this->db->insert('signa_m', $data_signa);

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

   public function update_signa($data_signa, $signa_id)
   {
      $this->db->where('signa_id', $signa_id)->update('signa_m', $data_signa);
      return TRUE;
   }

   public function delete_signa($signa_id, $log)
   {
      $this->db->query("UPDATE signa_m SET is_deleted = 1, deleted_date = now(), deleted_by = $log WHERE signa_id = $signa_id");
      return TRUE;
   }
}
