<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    private $table = 'users';

    // Fungsi untuk memvalidasi login
    public function check_login($email)
    {
        return $this->db->get_where($this->table, ['email' => $email])->row();
    }

    // Fungsi untuk registrasi user baru (customer)
    public function register($data)
    {
        return $this->db->insert($this->table, $data);
    }
    
    // Anda bisa tambahkan fungsi lain di sini
    // (get_all_users, get_user_by_id, dll.)

}