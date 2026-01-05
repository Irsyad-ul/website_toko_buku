<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Toko_model extends CI_Model {

    /**
     * Proses checkout dan simpan header + detail pesanan
     */
    public function proses_checkout($data_penerima)
    {
        $pesanan = [
            'tanggal_pesan' => date('Y-m-d H:i:s'),
            'nama_penerima' => $data_penerima['nama_penerima'],
            'alamat_kirim'  => $data_penerima['alamat_kirim'],
            'total_bayar'   => $this->cart->total(),
            'status_pesanan'=> 'Menunggu Pembayaran'
        ];

        $this->db->insert('pesanan', $pesanan);
        $id_pesanan = $this->db->insert_id();

        // Simpan detail item
        foreach ($this->cart->contents() as $item) {
            $detail = [
                'id_pesanan' => $id_pesanan,
                'id_buku'    => $item['id'],
                'jumlah'     => $item['qty'],
                'harga'      => $item['price'],
            ];
            $this->db->insert('detail_pesanan', $detail);
        }

        $this->cart->destroy();
        return $id_pesanan;
    }

    /**
     * Ambil header pesanan berdasarkan ID
     */
    public function get_pesanan_header_by_id($id_pesanan)
    {
      $this->db->select('id_pesanan, user_id, total_bayar, status_pesanan, tanggal_pesan, batas_bayar, metode_pembayaran');

        $this->db->from('pesanan');
        $this->db->where('id_pesanan', $id_pesanan);
        return $this->db->get()->row();
    }

    /**
     * Ambil riwayat pesanan user
     */
    public function get_riwayat_pesanan($user_id)
    {
        $this->db->select('*');
        $this->db->from('pesanan');
        $this->db->where('user_id', $user_id);
        $this->db->order_by('tanggal_pesan', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Ambil detail satu pesanan
     */
    public function get_detail_pesanan_by_id($id_pesanan)
    {
        $this->db->select('*');
        $this->db->from('detail_pesanan');
        $this->db->where('id_pesanan', $id_pesanan);
        return $this->db->get()->result();
    }

    /**
     * Hapus pesanan + detailnya
     */
    public function delete_pesanan_dan_detail($id_pesanan)
    {
        // Hapus detail
        $this->db->where('id_pesanan', $id_pesanan);
        $this->db->delete('detail_pesanan');

        // Hapus header
        $this->db->where('id_pesanan', $id_pesanan);
        return $this->db->delete('pesanan');
    }

    /**
     * Validasi voucher & hitung diskon
     */
    public function validate_and_calculate_voucher($kode_voucher, $user_id, $total_pembelian)
    {
        $now = date('Y-m-d H:i:s');

        // Ambil voucher
        $this->db->where('kode_voucher', $kode_voucher);
        $this->db->where('is_active', 1);
        $this->db->where('tgl_mulai <=', $now);
        $this->db->where('tgl_akhir >=', $now);
        $voucher = $this->db->get('vouchers')->row();

        if (!$voucher) {
            return ['status' => false, 'message' => 'Voucher tidak ditemukan atau sudah kadaluarsa.'];
        }

        // Cek kuota global
        $usage_count = $this->db->get_where('voucher_usage', [
            'id_voucher' => $voucher->id_voucher
        ])->num_rows();

        if ($usage_count >= $voucher->kuota_global) {
            return ['status' => false, 'message' => 'Kuota penggunaan voucher sudah habis.'];
        }

        // Cek kuota per user
        $user_usage_count = $this->db->get_where('voucher_usage', [
            'id_voucher' => $voucher->id_voucher,
            'user_id'    => $user_id
        ])->num_rows();

        if ($user_usage_count >= $voucher->kuota_per_user) {
            return ['status' => false, 'message' => 'Anda sudah mencapai batas penggunaan voucher ini.'];
        }

        // Cek minimal pembelian
        if ($total_pembelian < $voucher->min_pembelian) {
            return ['status' => false, 'message' => 'Minimal belanja: Rp ' . number_format($voucher->min_pembelian, 0, ',', '.')];
        }

        // Hitung diskon
        $diskon = 0;

        if ($voucher->tipe_diskon == 'persen') {
            $diskon = $total_pembelian * ($voucher->nilai_diskon / 100);

            if ($voucher->maks_diskon > 0 && $diskon > $voucher->maks_diskon) {
                $diskon = $voucher->maks_diskon;
            }

        } else { 
            $diskon = $voucher->nilai_diskon;
            if ($diskon > $total_pembelian) {
                $diskon = $total_pembelian;
            }
        }

        $voucher->nilai_diskon_terhitung = round($diskon);

        return [
            'status'  => true,
            'message' => 'Voucher berhasil diterapkan!',
            'voucher' => $voucher
        ];
    }

    public function insert_pesanan_dan_detail($pesanan_data, $cart_contents)
{
    // Insert header pesanan
    $this->db->insert('pesanan', $pesanan_data);
    $id_pesanan = $this->db->insert_id();

    if (!$id_pesanan) return false;

    // Insert detail
    foreach ($cart_contents as $item) {
        $detail = [
            'id_pesanan' => $id_pesanan,
            'id_buku'    => $item['id'],
            'jumlah'     => $item['qty'],
            'harga'      => $item['price'],
        ];
        $this->db->insert('detail_pesanan', $detail);
    }

    return $id_pesanan;
}

}
