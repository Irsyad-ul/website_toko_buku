<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_model extends CI_Model {

    public function get_all()
    {
        // Mengambil semua kategori, diurutkan berdasarkan nama
        $this->db->order_by('nama_kategori', 'ASC');
        return $this->db->get('kategori')->result();
    }

    public function get_by_id($id_kategori)
    {
        // Mengambil kategori berdasarkan ID
        return $this->db->get_where('kategori', array('id_kategori' => $id_kategori))->row();
    }
}