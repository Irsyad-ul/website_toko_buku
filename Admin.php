<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // Muat model, helper, dan library
        $this->load->model('Admin_model');
        $this->load->model('Buku_model'); 
        $this->load->helper(array('url', 'form'));
        $this->load->library(array('form_validation', 'upload', 'session'));

        // Pengecekan sesi login admin
        if ($this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
    }

    // ================= DASHBOARD =================
    public function dashboard()
    {
        $data['nama_admin'] = $this->session->userdata('nama_lengkap') ?: 'Administrator';
        $this->load->view('admin/dashboard_admin', $data);
    }

    // ================= KELOLA BUKU =================
    public function buku()
    {
        $data['judul'] = 'Kelola Data Buku';
        $data['buku'] = $this->Admin_model->get_all_buku();
        $this->load->view('admin/v_buku_index', $data);
    }

 public function tambah_buku()
{
    $this->load->model('Kategori_model'); 

    $data['judul'] = 'Tambah Buku Baru'; // <-- WAJIB ADA
    $data['kategori'] = $this->Kategori_model->get_all();

    // TAMBAHKAN NAMA ADMIN, AGAR SIDEBAR TIDAK ERROR
    $data['nama_admin'] = $this->session->userdata('nama_lengkap') ?: 'Administrator';

    $this->load->view('admin/v_tambah_buku', $data);
}


 // File: application/controllers/Admin.php

// File: application/controllers/Admin.php

// File: application/controllers/Admin.php (Ganti fungsi simpan_buku)

public function simpan_buku()
{
    $this->form_validation->set_rules('judul', 'Judul Buku', 'required');
    $this->form_validation->set_rules('penulis', 'Penulis', 'required');
    $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');
    $this->form_validation->set_rules('stok', 'Stok', 'required|integer');
    // Tambahkan validasi untuk id_kategori
    $this->form_validation->set_rules('id_kategori', 'Kategori', 'required'); 

    // Muat Model Kategori (Dibutuhkan jika validasi/upload gagal)
    $this->load->model('Kategori_model'); 

    if ($this->form_validation->run() == FALSE) {
        // Jika validasi gagal, panggil kembali tambah_buku untuk memuat data kategori
        
        // Panggil tambah_buku() untuk memastikan semua variabel (termasuk kategori) terdefinisi
        $this->tambah_buku(); 
        return; 
    } 

    // --- Konfigurasi upload yang sudah ada ---
    $config['upload_path']   = './assets/dist/img/'; 
    $config['allowed_types'] = 'gif|jpg|png|jpeg';
    $config['max_size']      = 2048; 
    $config['encrypt_name']  = TRUE; 
    
    // ... (Logika mkdir jika folder belum ada) ...

    $this->load->library('upload'); 
    $this->upload->initialize($config);
    
    if (!$this->upload->do_upload('gambar')) {
        // Jika upload gagal
        $error = array('error_upload' => $this->upload->display_errors());
        
        $data['judul'] = 'Tambah Buku Baru';
        $data['kategori'] = $this->Kategori_model->get_all(); 
        // Tambahkan nama admin agar sidebar tidak error
        $data['nama_admin'] = $this->session->userdata('nama_lengkap') ?: 'Administrator';
        
        $this->load->view('admin/v_tambah_buku', array_merge($data, $error));
    } else {
        // Jika upload sukses
        $upload_data = $this->upload->data();
        $nama_gambar = $upload_data['file_name'];

        $data = array(
            'judul'          => $this->input->post('judul'),
            'penulis'        => $this->input->post('penulis'),
            'penerbit'       => $this->input->post('penerbit'),
            'tahun_terbit'   => $this->input->post('tahun_terbit'),
            'harga'          => $this->input->post('harga'),
            'stok'           => $this->input->post('stok'),
            'deskripsi'      => $this->input->post('deskripsi'),
            
            // >>> INI TEMPATNYA: Ambil id_kategori dari form POST <<<
            'id_kategori'    => $this->input->post('id_kategori'), 
            
            'gambar'         => $nama_gambar
        );
        
        // Pastikan Anda memiliki fungsi 'insert_buku' di Buku_model
        $this->Buku_model->insert_buku($data); 

        $this->session->set_flashdata('success', 'Buku dan gambar berhasil ditambahkan!');
        redirect('admin/buku');
    }
}

    public function edit_buku($id)
    {
        $data['judul'] = 'Edit Data Buku';
        $data['buku'] = $this->Admin_model->get_buku_by_id($id);
        if (!$data['buku']) show_404();

        $this->load->view('admin/v_buku_edit', $data);
    }

    public function update_buku_aksi()
    {
        $id_buku = $this->input->post('id_buku');
        $this->form_validation->set_rules('judul', 'Judul', 'required');
        $this->form_validation->set_rules('penulis', 'Penulis', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->edit_buku($id_buku);
        } else {
            $data = array(
                'judul' => $this->input->post('judul'),
                'penulis' => $this->input->post('penulis'),
                'penerbit' => $this->input->post('penerbit'),
                'tahun_terbit' => $this->input->post('tahun_terbit'),
                'harga' => $this->input->post('harga'),
                'stok' => $this->input->post('stok'),
                'deskripsi' => $this->input->post('deskripsi')
            );

            $this->Admin_model->update_buku($id_buku, $data);
            $this->session->set_flashdata('success', 'Data buku berhasil diperbarui!');
            redirect('admin/buku');
        }
    }

    public function hapus_buku($id)
    {
        $this->Admin_model->delete_buku($id);
        $this->session->set_flashdata('success', 'Data buku berhasil dihapus!');
        redirect('admin/buku');
    }

    // ================= PESANAN =================
    public function pesanan_masuk()
    {
        $data['judul'] = 'Pesanan Masuk';
        $data['pesanan'] = $this->Admin_model->get_all_pesanan();
        $data['nama_admin'] = $this->session->userdata('nama_admin') ?: 'Administrator';
        $this->load->view('admin/v_pesanan_index', $data);
    }

   public function detail_pesanan($id_pesanan)
    {
        $data['judul'] = 'Detail Pesanan';
        $data['header'] = $this->db->select('p.*, u.nama_lengkap')
                                   ->from('pesanan p')
                                   ->join('users u', 'u.user_id = p.user_id')
                                   ->where('p.id_pesanan', $id_pesanan)
                                   ->get()->row();

        $data['detail'] = $this->Admin_model->get_detail_pesanan($id_pesanan);

        if (!$data['header']) show_404();
        $this->load->view('admin/v_pesanan_detail', $data);
    }
// File: application/controllers/Admin.php

public function update_status()
{
    $id_pesanan = $this->input->post('id_pesanan');
    $status_baru = $this->input->post('status_baru');

    if (empty($id_pesanan) || empty($status_baru)) {
        $this->session->set_flashdata('error', 'ID Pesanan atau Status baru tidak valid.');
        redirect('admin/pesanan_masuk');
    }

    // 2. Siapkan data untuk update: HANYA kolom yang ada di tabel 'pesanan'
    $data_update = array(
        'status_pesanan' => $status_baru,
        // HAPUS BARIS INI: 'tgl_diubah' => date('Y-m-d H:i:s') 
    );

    // 3. Panggil Model untuk menyimpan perubahan
    $update_sukses = $this->Admin_model->update_status_pesanan($id_pesanan, $data_update);

    // ... (Logika notifikasi dan redirect lainnya) ...

    // Redirect kembali ke halaman detail pesanan
    redirect('admin/detail_pesanan/' . $id_pesanan);
}

    // ================= CUSTOMER =================
    public function customer()
    {
        $data['judul'] = 'Kelola Customer';
        $data['customer'] = $this->Admin_model->get_all_customer();
        $data['nama_admin'] = $this->session->userdata('nama_admin') ?: 'Administrator';
        $this->load->view('admin/v_customer_index', $data);
    }

    public function delete_customer($user_id)
    {
        if ($this->Admin_model->delete_customer($user_id)) {
            $this->session->set_flashdata('success', 'Customer berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus customer.');
        }

        redirect('admin/customer');
    }

    public function voucher()
{
    $data['judul'] = 'Kelola Voucher Diskon';
    $data['vouchers'] = $this->Admin_model->get_all_vouchers();
    $data['nama_admin'] = $this->session->userdata('nama_admin') ?: 'Administrator';
    
    // Hitung kuota yang sudah digunakan
    foreach ($data['vouchers'] as $voucher) {
        $voucher->used_count = $this->Admin_model->get_voucher_usage_count($voucher->id_voucher);
    }
    
    $this->load->view('admin/v_voucher_index', $data);
}

public function tambah_voucher()
{
    $data['judul'] = 'Tambah Voucher Baru';
    $data['nama_admin'] = $this->session->userdata('nama_admin') ?: 'Administrator';

    $this->form_validation->set_rules('kode_voucher', 'Kode Voucher', 'required|is_unique[vouchers.kode_voucher]');
    $this->form_validation->set_rules('nilai_diskon', 'Nilai Diskon', 'required|numeric|greater_than[0]');
    $this->form_validation->set_rules('kuota_global', 'Kuota Global', 'required|integer|greater_than[0]');
    $this->form_validation->set_rules('tgl_mulai', 'Tanggal Mulai', 'required');
    $this->form_validation->set_rules('tgl_akhir', 'Tanggal Akhir', 'required');

    if ($this->form_validation->run() === FALSE)
    {
        $this->load->view('admin/v_voucher_form', $data);
    }
    else
    {
        $data_voucher = array(
            'kode_voucher' => $this->input->post('kode_voucher'),
            'deskripsi' => $this->input->post('deskripsi'),
            'tipe_diskon' => $this->input->post('tipe_diskon'),
            'nilai_diskon' => $this->input->post('nilai_diskon'),
            'maks_diskon' => $this->input->post('maks_diskon') ?: null,
            'min_pembelian' => $this->input->post('min_pembelian') ?: 0,
            'kuota_global' => $this->input->post('kuota_global'),
            'kuota_per_user' => $this->input->post('kuota_per_user') ?: 1,
            'tgl_mulai' => $this->input->post('tgl_mulai'),
            'tgl_akhir' => $this->input->post('tgl_akhir'),
            'is_active' => $this->input->post('is_active'),
        );

        $this->Admin_model->insert_voucher($data_voucher);
        $this->session->set_flashdata('success', 'Voucher baru berhasil ditambahkan.');
        redirect('admin/voucher');
    }
}

public function edit_voucher($id_voucher)
{
    $voucher = $this->Admin_model->get_voucher_by_id($id_voucher);
    if (!$voucher) show_404();
    
    $data['judul'] = 'Edit Voucher';
    $data['voucher'] = $voucher;
    $data['nama_admin'] = $this->session->userdata('nama_admin') ?: 'Administrator';
    
    // Peraturan validasi: kode_voucher harus unik kecuali kodenya sendiri
    $is_unique_kode = ($this->input->post('kode_voucher') != $voucher->kode_voucher) ? '|is_unique[vouchers.kode_voucher]' : '';

    $this->form_validation->set_rules('kode_voucher', 'Kode Voucher', 'required' . $is_unique_kode);
    $this->form_validation->set_rules('nilai_diskon', 'Nilai Diskon', 'required|numeric|greater_than[0]');
    // ... aturan validasi lainnya ...

    if ($this->form_validation->run() === FALSE)
    {
        $this->load->view('admin/v_voucher_form', $data);
    }
    else
    {
        $data_voucher = array(
            'kode_voucher' => $this->input->post('kode_voucher'),
            'deskripsi' => $this->input->post('deskripsi'),
            'tipe_diskon' => $this->input->post('tipe_diskon'),
            'nilai_diskon' => $this->input->post('nilai_diskon'),
            'maks_diskon' => $this->input->post('maks_diskon') ?: null,
            'min_pembelian' => $this->input->post('min_pembelian') ?: 0,
            'kuota_global' => $this->input->post('kuota_global'),
            'kuota_per_user' => $this->input->post('kuota_per_user') ?: 1,
            'tgl_mulai' => $this->input->post('tgl_mulai'),
            'tgl_akhir' => $this->input->post('tgl_akhir'),
            'is_active' => $this->input->post('is_active'),
        );

        $this->Admin_model->update_voucher($id_voucher, $data_voucher);
        $this->session->set_flashdata('success', 'Voucher berhasil diperbarui.');
        redirect('admin/voucher');
    }
}

public function delete_voucher($id_voucher)
{
    // Perlu dicek apakah ada usage terlebih dahulu (optional)
    // Jika tidak ada foreign key ON DELETE CASCADE, hapus dulu dari voucher_usage
    $this->db->where('id_voucher', $id_voucher)->delete('voucher_usage'); 
    
    if ($this->Admin_model->delete_voucher($id_voucher)) {
        $this->session->set_flashdata('success', 'Voucher berhasil dihapus.');
    } else {
        $this->session->set_flashdata('error', 'Gagal menghapus voucher.');
    }
    redirect('admin/voucher');
}
}