<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model'); // Muat User_model
        $this->load->helper('url');
    // ...
    }

    // Menampilkan halaman login
    public function index()
    {
        // Jika sudah login, lempar sesuai role
        if($this->session->userdata('role') == 'admin') {
            redirect('admin/dashboard');
        } elseif($this->session->userdata('role') == 'customer') {
            redirect('customer/dashboard');
        }
        
        $this->load->view('auth/login'); // Tampilkan view login
    }

    // Proses login
    public function process_login()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal
            $this->load->view('auth/login');
        } else {
            // Jika validasi sukses
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->User_model->check_login($email);

            // Cek jika user ada
            if ($user) {
                // Cek kesesuaian password (WAJIB pakai password_verify!)
                if (password_verify($password, $user->password)) {
                    
                    // Buat session
                    $session_data = array(
                        'user_id'   => $user->user_id,
                        'email'     => $user->email,
                        'nama'      => $user->nama_lengkap,
                        'role'      => $user->role,
                        'logged_in' => TRUE
                    );
                    $this->session->set_userdata($session_data);

                    // Redirect berdasarkan role
                    if ($user->role == 'admin') {
                        redirect('admin/dashboard');
                    } elseif ($user->role == 'customer') {
                        redirect('customer/dashboard');
                    }

                } else {
                    // Jika password salah
                    $this->session->set_flashdata('error', 'Email atau Password salah!');
                    redirect('auth');
                }
            } else {
                // Jika email tidak ditemukan
                $this->session->set_flashdata('error', 'Email atau Password salah!');
                redirect('auth');
            }
        }
    }

    // Menampilkan halaman registrasi
    public function register()
    {
        $data['judul'] = 'Daftar Akun Baru';
        // PERBAIKAN: Jika nama file view Anda adalah v_register.php, 
        // pastikan memanggilnya dengan nama yang sesuai atau tambahkan 'v_' di sini.
        $this->load->view('auth/register', $data); 
    }

    // Proses registrasi
    public function process_register()
    {
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('passconf', 'Konfirmasi Password', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembalikan data judul dan muat view
            $data['judul'] = 'Daftar Akun Baru';
            $this->load->view('auth/register', $data); // PERBAIKAN NAMA VIEW DAN KIRIM DATA
        } else {
            // ... (lanjutan logika registrasi)
            $data = array(
                'nama_lengkap' => $this->input->post('nama_lengkap'),
                'email'        => $this->input->post('email'),
                'password'     => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role'         => 'customer',
                'tgl_daftar'   => date('Y-m-d H:i:s') // Tambahkan tanggal daftar
            );

            if ($this->User_model->register($data)) {
                $this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login.');
                redirect('auth/login'); // Arahkan ke auth/login, bukan auth saja
            } else {
                $this->session->set_flashdata('error', 'Registrasi gagal, coba lagi!');
                redirect('auth/register');
            }
        }
     }

    // Proses Logout
    public function logout()
    {
        // Hapus semua data session yang terkait dengan login
        $this->session->sess_destroy(); 
        
        // Alihkan pengguna kembali ke halaman login utama
        redirect('auth'); 
    }
}