<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_resep extends CI_Model
{

   public function get_data_resep()
   {
      return $this->db->order_by('header_id', 'desc')->get('header_transaksi')->result();
   }

   public function get_data_resep_byId($header_id)
   {
      return $this->db->where('header_id', $header_id)->get('header_transaksi')->result();
   }

   public function get_data_detailResep_byId($header_id)
   {
      return $this->db->query("SELECT b.detail_id AS detailIdJenis, b.jenis_racikan,b.nama_obat,d.signa_nama 
                              FROM header_transaksi AS a 
                              RIGHT JOIN detail_transaksi_jenis AS b ON a.header_id = b.header_id 
                              RIGHT JOIN detail_transaksi_obat AS c ON b.detail_id = c.detail_id_jenis 
                              INNER JOIN signa_m AS d ON b.signa_id = d.signa_id 
                              INNER JOIN obatalkes_m AS e ON c.obat_id = e.obatalkes_id 
                              WHERE a.header_id = $header_id
                              GROUP BY b.detail_id,b.jenis_racikan,b.nama_obat,d.signa_nama")->result();
   }

   public function insert_header_transaksi($data)
   {
      $this->db->trans_begin();
      $this->db->insert('header_transaksi', $data);
      $id = $this->db->insert_id();

      if ($this->db->trans_status() == FALSE) {
         $this->db->trans_rollback();
         $result = 0;
      } else {
         $this->db->trans_commit();
         $result = 1;
         return $id;
      }
      // return $result;
      // return TRUE;
   }

   public function insert_detail_transaksi_jenis($data1)
   {
      $this->db->trans_begin();
      $this->db->insert('detail_transaksi_jenis', $data1);
      $id = $this->db->insert_id();

      if ($this->db->trans_status() == FALSE) {
         $this->db->trans_rollback();
         $result = 0;
      } else {
         $this->db->trans_commit();
         $result = 1;
         return $id;
      }
      // return $result;
      // return TRUE;
   }

   public function insert_detail_transaksi_obat($data2)
   {
      $this->db->trans_begin();
      $this->db->insert('detail_transaksi_obat', $data2);

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

   public function update_stok_obat($obat_id, $jumlah_obat)
   {
      $this->db->query("UPDATE obatalkes_m SET stok = (SELECT stok - $jumlah_obat WHERE obatalkes_id = $obat_id) WHERE obatalkes_id = $obat_id");
      return TRUE;
   }

   // public function update_obat($data_obat, $obatalkes_id)
   // {
   //    $this->db->where('obatalkes_id', $obatalkes_id)->update('obatalkes_m', $data_obat);
   //    return TRUE;
   // }

   // public function delete_obat($obatalkes_id, $log)
   // {
   //    $this->db->query("UPDATE obatalkes_m SET is_deleted = 1, deleted_date = now(), deleted_by = $log WHERE obatalkes_id = $obatalkes_id");
   //    return TRUE;
   // }
}
