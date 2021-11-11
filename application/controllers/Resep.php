<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Resep extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->load->model(array('M_resep', 'M_obat', 'M_signa'));
      $this->db = $this->load->database('default', TRUE);
   }

   public function index()
   {
      if ($this->session->userdata('logged_in')) {
         $data['resep']     = $this->M_resep->get_data_resep();
         $data['main_view'] = 'data_resep_view';
         $this->load->view('template', array_merge($data));
      } else {
         redirect('login');
      }
   }

   public function formulir()
   {
      if ($this->session->userdata('logged_in')) {
         $data['obat']      = $this->M_obat->get_data_obat();
         $data['signa']     = $this->M_signa->get_data_signa();
         $data['main_view'] = 'formulir_view';
         $this->load->view('template', array_merge($data));
      } else {
         redirect('login');
      }
   }

   public function set_obat()
   {
      if ($this->session->userdata('logged_in')) {
         $jenis        = $this->input->post('jenis');
         $html         = '';

         if ($jenis == "non_racikan") {
            $obatalkes_id = $this->input->post('id_obat');
            $signa_id     = $this->input->post('id_signa');
            $jumlah       = $this->input->post('jumlah');

            $dataObat     = $this->M_obat->get_data_obat_byid($obatalkes_id);
            $dataSigna    = $this->M_signa->get_data_signa_byid($signa_id);

            foreach ($dataObat as $dt_obat) {
               $obat = $dt_obat->obatalkes_nama;
            }
            foreach ($dataSigna as $dt_signa) {
               $signa = $dt_signa->signa_nama;
            }

            $html      =  '<tr>
                              <td>Non Racikan
                                 <input type="hidden" class="form-control" name="jenis_racikan[]" value="Non Racikan">
                              </td>
                              <td>' . $obat . '
                                 <input type="hidden" class="form-control" name="obat_id[]" value="' . $obatalkes_id . '">
                              </td>
                              <td>' . $signa . '
                                 <input type="hidden" class="form-control" name="signa_id[]" value="' . $signa_id . '">
                              </td>
                              <td>' . $jumlah . '
                                 <input type="hidden" class="form-control" name="jumlah_obat[]" value="' . $jumlah . '">
                              </td>
                              <td>
                                 <button type="button" class="btn btn-danger btn-sm hapus_row" value="">Hapus</button>
                              </td>
                           </tr>';
         } elseif ($jenis == 'racikan') {
            $nama_racikan     = $this->input->post('nama_racikan');
            $id_signa_racikan = $this->input->post('id_signa_racikan');
            $id_obat_racikan  = $this->input->post('id_obat_racikan');
            $jumlah_racikan   = $this->input->post('jumlah_racikan');

            $dataSigna    = $this->M_signa->get_data_signa_byid($id_signa_racikan);
            foreach ($dataSigna as $dt_signa) {
               $signa = $dt_signa->signa_nama;
            }

            $forClass = str_replace(' ', '', $nama_racikan);
            $jml = count($id_obat_racikan);
            for ($i = 0; $i < $jml; $i++) {
               $dataObat     = $this->M_obat->get_data_obat_byid($id_obat_racikan[$i]);
               foreach ($dataObat as $dt_obat) {
                  $obat = $dt_obat->obatalkes_nama;
               }

               if ($i == 0) {
                  $html = '<tr class="' . $forClass . $id_signa_racikan . '">
                              <td rowspan="' . $jml . '">Racikan ' . $nama_racikan . '
                                 <input type="hidden" class="form-control" name="jenis_racikan[]" value="Racikan ' . $nama_racikan . '">
                              </td>
                              <td>' . $obat . '
                                 <input type="hidden" class="form-control" name="obat_id[]" value="' . $id_obat_racikan[$i] . '">
                              </td>
                              <td rowspan="' . $jml . '">' . $signa . '
                                 <input type="hidden" class="form-control" name="signa_id[]" value="' . $id_signa_racikan . '">
                              </td>
                              <td>' . $jumlah_racikan[$i] . '
                                 <input type="hidden" class="form-control" name="jumlah_obat[]" value="' . $jumlah_racikan[$i] . '">
                              </td>
                              <td rowspan="' . $jml . '">
                                 <button type="button" class="btn btn-danger btn-sm hapus_row" value="' . $forClass . $id_signa_racikan . '">Hapus</button>
                              </td>
                           </tr>';
               } else {
                  $html .= '<tr class="' . $forClass . $id_signa_racikan . '">
                              <td>' . $obat . '
                                 <input type="hidden" class="form-control" name="jenis_racikan[]" value="Racikan ' . $nama_racikan . '">
                                 <input type="hidden" class="form-control" name="obat_id[]" value="' . $id_obat_racikan[$i] . '">
                                 <input type="hidden" class="form-control" name="signa_id[]" value="' . $id_signa_racikan . '">
                              </td>
                              <td>' . $jumlah_racikan[$i] . '
                                 <input type="hidden" class="form-control" name="jumlah_obat[]" value="' . $jumlah_racikan[$i] . '">
                              </td>
                           </tr>';
               }
            }
         } else {
         }
         echo $html;
      } else {
         redirect('login');
      }
   }

   public function simpan()
   {
      if ($this->session->userdata('logged_in')) {
         $log           = $this->session->userdata('id_user');

         //header transaksi
         $no_ktp        = $this->input->post('no_ktp');
         $nama_pasien   = $this->input->post('nama_pasien');
         $alamat        = $this->input->post('alamat');
         $no_hp         = $this->input->post('no_hp');
         $diagnosa      = $this->input->post('diagnosa');
         //detail transaksi
         $jenis_racikan = $this->input->post('jenis_racikan');
         $obat_id       = $this->input->post('obat_id');
         $signa_id      = $this->input->post('signa_id');
         $jumlah_obat   = $this->input->post('jumlah_obat');

         $jml = count($jenis_racikan);

         if ($this->input->post('submit')) {
            $data = array(
               'no_ktp'      => $no_ktp,
               'nama_pasien' => $nama_pasien,
               'alamat'      => $alamat,
               'no_hp'       => $no_hp,
               'diagnosa'    => $diagnosa,
               'created_by'  => $log
            );
            $maxid = $this->M_resep->insert_header_transaksi($data);

            $cek          = '';
            $maxid_detail = '';
            for ($i = 0; $i < $jml; $i++) {
               if ($jenis_racikan[$i] == 'Non Racikan') {
                  $dataObat     = $this->M_obat->get_data_obat_byid($obat_id[$i]);
                  foreach ($dataObat as $dt_obat) {
                     $nama_obat = $dt_obat->obatalkes_nama;
                  }

                  $data1 = array(
                     'header_id'     => $maxid,
                     'jenis_racikan' => 'Non Racikan',
                     'nama_obat'     => $nama_obat,
                     'signa_id'      => $signa_id[$i],
                  );
                  $maxid_detail = $this->M_resep->insert_detail_transaksi_jenis($data1);

                  $data2 = array(
                     'detail_id_jenis' => $maxid_detail,
                     'obat_id'         => $obat_id[$i],
                     'jumlah'          => $jumlah_obat[$i]
                  );
                  $this->M_resep->insert_detail_transaksi_obat($data2);
                  $this->M_resep->update_stok_obat($obat_id[$i], $jumlah_obat[$i]);
               } else {
                  if ($cek != $jenis_racikan[$i]) {
                     $data1 = array(
                        'header_id'     => $maxid,
                        'jenis_racikan' => 'Racikan',
                        'nama_obat'     => $jenis_racikan[$i],
                        'signa_id'      => $signa_id[$i],
                     );
                     $maxid_detail = $this->M_resep->insert_detail_transaksi_jenis($data1);

                     $data2 = array(
                        'detail_id_jenis' => $maxid_detail,
                        'obat_id'         => $obat_id[$i],
                        'jumlah'          => $jumlah_obat[$i]
                     );
                     $this->M_resep->insert_detail_transaksi_obat($data2);
                     $this->M_resep->update_stok_obat($obat_id[$i], $jumlah_obat[$i]);
                  } else {
                     $data2 = array(
                        'detail_id_jenis' => $maxid_detail,
                        'obat_id'         => $obat_id[$i],
                        'jumlah'          => $jumlah_obat[$i]
                     );
                     $this->M_resep->insert_detail_transaksi_obat($data2);
                     $this->M_resep->update_stok_obat($obat_id[$i], $jumlah_obat[$i]);
                  }
                  $cek = $jenis_racikan[$i];
               }
            }
            redirect('resep');
         }
      } else {
         redirect('login');
      }
   }

   public function lihatResep()
   {
      if ($this->session->userdata('logged_in')) {
         $header_id = $this->input->post('header_id');
         $dataResep = $this->M_resep->get_data_resep_byId($header_id);
         $dataDetail = $this->M_resep->get_data_detailResep_byId($header_id);

         foreach ($dataResep as $dt_resep) {
            $no_ktp        = $dt_resep->no_ktp;
            $nama_pasien   = $dt_resep->nama_pasien;
            $alamat        = $dt_resep->alamat;
            $no_hp         = $dt_resep->no_hp;
            $diagnosa      = $dt_resep->diagnosa;
         }
         $html = '<tr>
                     <td width="15%">NIK KTP</td>
                     <td width="35%">: ' . $no_ktp . '</td>
                     <td width="15%">No. HP</td>
                     <td width="35%">: ' . $no_hp . '</td>
                  </tr>
                  <tr>
                     <td>Nama</td>
                     <td>: ' . $nama_pasien . '</td>
                     <td>Diagnosa</td>
                     <td>: ' . $diagnosa . '</td>
                  </tr>
                  <tr>
                     <td>Alamat</td>
                     <td>: ' . $alamat . '</td>
                  </tr>';
         $html1 = '';
         $no = 0;
         foreach ($dataDetail as $dt_detail) {
            $no++;
            $jenis_racikan  = $dt_detail->jenis_racikan;
            $nama_obat      = $dt_detail->nama_obat;
            $signa_nama     = $dt_detail->signa_nama;

            $html1 .= '<tr>
                           <td>' . $no . '</td>
                           <td>' . $nama_obat . '</td>
                           <td>' . $signa_nama . '</td>
                        </tr>';
         }
         echo $html . '/////' . $html1;
      } else {
         redirect('login');
      }
   }
}
