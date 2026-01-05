<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // INI PENGAMAN ANDA (GUARD)
        if($this->session->userdata('role') != 'customer') {
            $this->session->set_flashdata('error', 'Anda harus login sebagai customer!');
            redirect('auth');
        }
    }

    public function dashboard() {
        
        // =========================================================
        // ✅ PERBAIKAN: MUAT LIBRARY CART DI SINI
        // Ini mengatasi error "Call to a member function total_items() on null"
        $this->load->library('cart'); 
        // =========================================================

        // 1. Siapkan data untuk dikirim ke view
        $data['nama_customer'] = $this->session->userdata('nama');

        // 2. Muat view dashboard customer dan kirim datanya
        $this->load->view('customer/dashboard_customer', $data);
    }

    // Nanti di sini Anda bisa tambahkan fungsi lain
    // ...
}
?>