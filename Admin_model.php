<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    private $table = 'buku';

    // R - READ: Ambil semua data buku
    public function get_all_buku()
    {
        return $this->db->get($this->table)->result();
    }

    // R - READ: Ambil data buku berdasarkan ID
    public function get_buku_by_id($id_buku)
    {
        return $this->db->get_where($this->table, ['id_buku' => $id_buku])->row();
    }

    // C - CREATE: Simpan data buku baru
    public function insert_buku($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // U - UPDATE: Update data buku
    public function update_buku($id_buku, $data)
    {
        $this->db->where('id_buku', $id_buku);
        return $this->db->update($this->table, $data);
    }

    // D - DELETE: Hapus data buku
    public function delete_buku($id_buku)
    {
        $this->db->where('id_buku', $id_buku);
        return $this->db->delete($this->table);
    }

    public function get_all_pesanan()
    {
        // Menggabungkan tabel pesanan dengan tabel users untuk menampilkan nama customer
        $this->db->select('p.*, u.nama_lengkap'); // <--- Menggunakan kolom nama_lengkap dari tabel users
        $this->db->from('pesanan p');
        $this->db->join('users u', 'u.user_id = p.user_id', 'left'); // <--- JOIN ke tabel users
        $this->db->order_by('p.tanggal_pesan', 'DESC');
        return $this->db->get()->result();
    }

    public function get_detail_pesanan($id_pesanan)
    {
        $this->db->select('*');
        $this->db->from('detail_pesanan');
        $this->db->where('id_pesanan', $id_pesanan);
        return $this->db->get()->result();
    }

    public function get_all_customer()
    {
        // Asumsi tabel customer adalah 'users' dan tidak ada filter admin (admin harusnya disimpan di tabel terpisah atau memiliki flag role)
        $this->db->select('*');
        $this->db->from('users');
        $this->db->order_by('nama_lengkap', 'ASC');
        return $this->db->get()->result();
    }

    public function delete_customer($user_id)
    {
        // PERHATIAN: Hati-hati dalam menghapus user yang mungkin memiliki pesanan. 
        // Anda mungkin perlu menghapus/mengubah pesanan terkait terlebih dahulu.
        
        // Contoh sederhana (hanya menghapus user):
        $this->db->where('user_id', $user_id);
        return $this->db->delete('users');
    }

    public function update_status_pesanan($id_pesanan, $data)
{
    // Tentukan baris mana yang akan diupdate
    $this->db->where('id_pesanan', $id_pesanan);
    
    // Jalankan query update pada tabel 'pesanan'
    return $this->db->update('pesanan', $data); 
    // Fungsi update() CodeIgniter akan mengembalikan TRUE jika sukses, FALSE jika gagal.
}

public function get_all_vouchers()
{
    return $this->db->order_by('tgl_mulai', 'DESC')->get('vouchers')->result();
}

public function get_voucher_by_id($id_voucher)
{
    return $this->db->get_where('vouchers', ['id_voucher' => $id_voucher])->row();
}

public function insert_voucher($data)
{
    $this->db->insert('vouchers', $data);
    return $this->db->insert_id();
}

public function update_voucher($id_voucher, $data)
{
    $this->db->where('id_voucher', $id_voucher);
    return $this->db->update('vouchers', $data);
}

public function delete_voucher($id_voucher)
{
    $this->db->where('id_voucher', $id_voucher);
    return $this->db->delete('vouchers');
}

// Fungsi untuk mendapatkan total penggunaan voucher
public function get_voucher_usage_count($id_voucher)
{
    return $this->db->get_where('voucher_usage', ['id_voucher' => $id_voucher])->num_rows();
}
}