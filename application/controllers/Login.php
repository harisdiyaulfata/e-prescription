<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->load->model('M_login');
   }

   public function index()
   {
      if ($this->session->userdata('logged_in')) {
         redirect('Dashboard');
      } else {
         $this->load->view('login');
      }
   }

   public function do_login()
   {
      if ($this->input->post('submit')) {
         $this->form_validation->set_rules('username', 'username', 'trim|required');
         $this->form_validation->set_rules('password', 'password', 'trim|required');

         if ($this->form_validation->run()) {
            $username  = $this->input->post('username');
            $password  = $this->input->post('password');
            $data_user = $this->M_login->login($username, $password);
            foreach ($data_user as $dt) {
               $id_user = $dt->id_user;
               $name    = $dt->name;
            }
            if (count($data_user) > 0) {
               $session = array(
                  'id_user'   => $id_user,
                  'name'      => $name,
                  'username'  => $username,
                  'logged_in' => TRUE
               );

               $this->session->set_userdata($session);
               redirect('Dashboard');
            } else {
               $data['notif'] = 'Login Gagal';
               $this->load->view('login', $data);
            }
         } else {
            $data['notif'] = validation_errors();
            $this->load->view('login', $data);
         }
      }
   }

   public function logout()
   {
      $this->session->sess_destroy();
      $this->session->set_flashdata('result_login', '<br>You have Already Logout.');
      redirect('login');
   }
}
