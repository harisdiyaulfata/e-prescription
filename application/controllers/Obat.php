<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Obat extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->load->model('M_obat');
   }

   public function index()
   {
      if ($this->session->userdata('logged_in')) {
         $data['obat']      = $this->M_obat->get_data_obat();
         $data['main_view'] = 'data_obat_view';
         $this->load->view('template', array_merge($data));
      } else {
         redirect('login');
      }
   }

   public function edit_obat()
   {
      if ($this->session->userdata('logged_in')) {
         $obatalkes_id = $this->input->post('id_obat');
         $dataObat     = $this->M_obat->get_data_obat_byid($obatalkes_id);
         echo json_encode($dataObat);
      } else {
         redirect('login');
      }
   }

   public function simpan()
   {
      if ($this->session->userdata('logged_in')) {
         $log  = $this->session->userdata('id_user');
         $aksi = $this->uri->segment(3);
         if ($this->input->post('submit')) {
            if ($aksi == 'save') {
               $data_obat = array(
                  'obatalkes_kode'  => $this->input->post('kode_obat'),
                  'obatalkes_nama'  => $this->input->post('nama_obat'),
                  'stok'            => $this->input->post('qty_obat'),
                  'additional_data' => $this->input->post('catatan'),
                  'created_by'      => $log
               );
               $this->M_obat->insert_obat($data_obat);
            } elseif ($aksi == 'update') {
               $id_obat = $this->input->post('id_obat');
               $modif   = $this->input->post('count_modif') + 1;
               $data_obat = array(
                  'obatalkes_kode'     => $this->input->post('kode_obat'),
                  'obatalkes_nama'     => $this->input->post('nama_obat'),
                  'stok'               => $this->input->post('qty_obat'),
                  'additional_data'    => $this->input->post('catatan'),
                  'is_active'          => $this->input->post('status'),
                  'modified_count'     => $modif,
                  'last_modified_date' => date("Y-m-d H:i:s"),
                  'last_modified_by'   => $log
               );
               $this->M_obat->update_obat($data_obat, $id_obat);
            }
            redirect('obat');
         }
      } else {
         redirect('login');
      }
   }

   public function delete_obat()
   {
      if ($this->session->userdata('logged_in')) {
         $obatalkes_id = $this->uri->segment(3);
         $log          = $this->session->userdata('id_user');
         $this->M_obat->delete_obat($obatalkes_id, $log);
         redirect('obat');
      } else {
         redirect('login');
      }
   }
}
