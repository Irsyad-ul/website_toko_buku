<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku_model extends CI_Model {

    private $table = 'buku';

    // Ambil semua buku (untuk ditampilkan ke customer)
    public function get_all_buku()
    {
        $this->db->select('b.*, k.nama_kategori');
        $this->db->from('buku b');
        $this->db->join('kategori k', 'k.id_kategori = b.id_kategori', 'left');
        $this->db->order_by('b.judul', 'ASC');
        return $this->db->get()->result();
    }

    // Fungsi baru untuk mengambil buku berdasarkan kategori
    public function get_buku_by_kategori($id_kategori)
    {
        $this->db->select('b.*, k.nama_kategori');
        $this->db->from('buku b');
        $this->db->join('kategori k', 'k.id_kategori = b.id_kategori', 'left');
        $this->db->where('b.id_kategori', $id_kategori);
        $this->db->order_by('b.judul', 'ASC');
        return $this->db->get()->result();
    }

    // Ambil detail buku berdasarkan ID
    public function get_buku_by_id($id_buku)
    {
        return $this->db->get_where($this->table, ['id_buku' => $id_buku])->row();
    }

      public function insert_buku($data)
{
    // Pastikan 'buku' adalah nama tabel Anda yang benar
    return $this->db->insert('buku', $data); 
}
}