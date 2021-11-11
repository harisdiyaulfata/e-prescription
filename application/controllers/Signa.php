<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Signa extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->load->model('M_signa');
   }

   public function index()
   {
      if ($this->session->userdata('logged_in')) {
         $data['signa'] = $this->M_signa->get_data_signa();
         $data['main_view'] = 'data_signa_view';
         $this->load->view('template', array_merge($data));
      } else {
         redirect('login');
      }
   }

   public function edit_signa()
   {
      if ($this->session->userdata('logged_in')) {
         $signa_id = $this->input->post('id_signa');
         $dataSigna = $this->M_signa->get_data_signa_byid($signa_id);
         echo json_encode($dataSigna);
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
               $data_signa = array(
                  'signa_kode'      => $this->input->post('kode_signa'),
                  'signa_nama'      => $this->input->post('nama_signa'),
                  'additional_data' => $this->input->post('catatan'),
                  'created_by'      => $log
               );
               $this->M_signa->insert_signa($data_signa);
            } elseif ($aksi == 'update') {
               $id_signa = $this->input->post('id_signa');
               $modif    = $this->input->post('count_modif') + 1;
               $data_signa = array(
                  'signa_kode'         => $this->input->post('kode_signa'),
                  'signa_nama'         => $this->input->post('nama_signa'),
                  'additional_data'    => $this->input->post('catatan'),
                  'is_active'          => $this->input->post('status'),
                  'modified_count'     => $modif,
                  'last_modified_date' => date("Y-m-d H:i:s"),
                  'last_modified_by'   => $log
               );
               $this->M_signa->update_signa($data_signa, $id_signa);
            }
            redirect('signa');
         }
      } else {
         redirect('login');
      }
   }

   public function delete_signa()
   {
      if ($this->session->userdata('logged_in')) {
         $signa_id = $this->uri->segment(3);
         $log      = $this->session->userdata('id_user');
         $this->M_signa->delete_signa($signa_id, $log);
         redirect('signa');
      } else {
         redirect('login');
      }
   }
}
