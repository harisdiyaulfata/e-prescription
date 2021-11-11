<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
   public function index()
   {
      if ($this->session->userdata('logged_in')) {
         $data['main_view'] = 'dashboard.php';
         $this->load->view('template', array_merge($data));
      } else {
         redirect('Login');
      }
   }
}
