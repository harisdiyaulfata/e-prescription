<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_login extends CI_Model
{
   public function login($username, $password)
   {
      return $this->db->where('username', $username)->where('password', md5($password))->where('is_active', 1)->get('user')->result();
      // if ($query->num_rows() > 0) {
      //    return TRUE;
      // } else {
      //    return FALSE;
      // }
   }
}
