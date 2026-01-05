<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Toko extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Library & Helper
        $this->load->library(['cart', 'form_validation', 'session']);
        $this->load->helper(['form', 'url']);

        // Model
        $this->load->model('Buku_model');
        $this->load->model('Kategori_model');
        $this->load->model('Toko_model');
    }

    /* ==========================
       HALAMAN KATALOG & KATEGORI
       ========================== */
    public function index()
    {
        $data['judul'] = 'Katalog Buku Terbaik';
        $data['buku'] = $this->Buku_model->get_all_buku();
        $data['kategori'] = $this->Kategori_model->get_all();
        $data['nama_customer'] = $this->session->userdata('nama');

        $this->load->view('toko/v_katalog', $data);
    }

    public function kategori($id_kategori = NULL)
    {
        if ($id_kategori === NULL) {
            redirect('toko');
        }

        $data['buku'] = $this->Buku_model->get_buku_by_kategori($id_kategori);
        $data['kategori'] = $this->Kategori_model->get_all();
        $kategori_aktif = $this->Kategori_model->get_by_id($id_kategori);

        $data['kategori_aktif'] = $id_kategori;
        $data['judul'] = 'Kategori: ' . $kategori_aktif->nama_kategori;

        $this->load->view('toko/v_katalog', $data);
    }

    /* ==========================
            DETAIL BUKU
       ========================== */
    public function detail($id_buku)
    {
        $data['buku'] = $this->Buku_model->get_buku_by_id($id_buku);

        if (!$data['buku']) {
            show_404();
        }

        $data['judul'] = 'Detail Buku: ' . $data['buku']->judul;
        $this->load->view('toko/v_detail_buku', $data);
    }

    /* ==========================
              KERANJANG
       ========================== */
    public function add_to_cart($id_buku)
    {
        $buku = $this->Buku_model->get_buku_by_id($id_buku);

        if (!$buku || $buku->stok <= 0) {
            $this->session->set_flashdata('error', 'Buku tidak ditemukan atau stok habis!');
            redirect('toko');
        }

        $data = [
            'id'    => $buku->id_buku,
            'qty'   => 1,
            'price' => $buku->harga,
            'name'  => $buku->judul
        ];

        $this->cart->insert($data);
        $this->session->set_flashdata('success', $buku->judul . ' berhasil ditambahkan ke keranjang!');
        redirect('toko');
    }

    public function keranjang()
    {
        $data['judul'] = 'Keranjang Belanja Anda';
        $this->load->view('toko/v_keranjang', $data);
    }

    public function update_keranjang()
    {
        $i = 1;
        foreach ($this->cart->contents() as $item) {
            $data = [
                'rowid' => $this->input->post('rowid_' . $i),
                'qty'   => $this->input->post('qty_' . $i)
            ];
            $this->cart->update($data);
            $i++;
        }
        $this->session->set_flashdata('success', 'Keranjang berhasil diperbarui!');
        redirect('toko/keranjang');
    }

    public function remove_item($rowid)
    {
        if ($rowid) {
            $this->cart->update(['rowid' => $rowid, 'qty' => 0]);
            $this->session->set_flashdata('success', 'Item berhasil dihapus.');
        }
        redirect('toko/keranjang');
    }

    public function clear_cart()
    {
        $this->cart->destroy();
        $this->session->set_flashdata('success', 'Keranjang dikosongkan.');
        redirect('toko');
    }

    /* ==========================
               CHECKOUT
       ========================== */
    public function checkout()
    {
        // Pastikan keranjang tidak kosong
        if ($this->cart->total_items() == 0) {
            $this->session->set_flashdata('error', 'Keranjang belanja Anda kosong.');
            redirect('toko/keranjang');
        }

        // Pastikan customer sudah login
        if (!$this->session->userdata('user_id')) {
            $this->session->set_flashdata('warning', 'Anda harus login untuk melanjutkan ke Checkout.');
            redirect('auth/login');
        }

        $data['judul'] = 'Checkout Pesanan';
        $this->load->view('toko/v_checkout_form', $data);
    }

    public function proses_pesanan()
    {
        // 1. Set Rules Validasi
        $this->form_validation->set_rules('nama_penerima', 'Nama', 'required|trim');
        $this->form_validation->set_rules('alamat_kirim', 'Alamat', 'required|trim');

        // Aturan baru untuk Metode Pembayaran
       $this->form_validation->set_rules(
    'metode_pembayaran',
    'Metode Pembayaran',
    'required|trim|in_list[transfer_bank,cod,qris,e_wallet]',
    [
        'required' => 'Metode pembayaran wajib dipilih.',
        'in_list'  => 'Metode pembayaran tidak valid.'
    ]
);


        if ($this->form_validation->run() == FALSE) {
            $this->checkout();
            return;
        }

        // Simpan data penerima dan metode pembayaran ke Session
        $this->session->set_userdata('data_checkout', [
            'nama_penerima'      => $this->input->post('nama_penerima'),
            'alamat_kirim'       => $this->input->post('alamat_kirim'),
            'metode_pembayaran'  => $this->input->post('metode_pembayaran')
        ]);

        redirect('toko/place_order');
    }

    /* ==============================
           KONFIRMASI PEMBAYARAN
       ============================== */
  public function konfirmasi_pembayaran($id_pesanan)
{
    $pesanan = $this->Toko_model->get_pesanan_header_by_id($id_pesanan);

    if (!$pesanan) {
        redirect('toko');
    }

    $data = [
        'judul'             => 'Pembayaran Pesanan',
        'id_pesanan'        => $id_pesanan,
        'total_bayar'       => $pesanan->total_bayar,
        'metode_pembayaran' => $pesanan->metode_pembayaran,  // ⬅️ WAJIB ADA
        'waktu_pesanan'     => $pesanan->tanggal_pesan
    ];

    $this->load->view('toko/v_konfirmasi_pembayaran', $data);
}



    /* ==============================
             RIWAYAT PESANAN
       ============================== */
    public function riwayat()
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) redirect('auth/login');

        $data['judul'] = 'Riwayat Pesanan Anda';
        $data['pesanan'] = $this->Toko_model->get_riwayat_pesanan($user_id);

        $this->load->view('toko/v_riwayat_index', $data);
    }

    public function detail_riwayat($id_pesanan)
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) redirect('auth/login');

        $header = $this->db->get_where('pesanan', ['id_pesanan' => $id_pesanan])->row();

        if (!$header || $header->user_id != $user_id) {
            $this->session->set_flashdata('error', 'Pesanan tidak ditemukan.');
            redirect('toko/riwayat');
        }

        $data['judul'] = 'Detail Pesanan #' . $id_pesanan;
        $data['header'] = $header;
        $data['detail'] = $this->Toko_model->get_detail_pesanan_by_id($id_pesanan);

        $this->load->view('toko/v_riwayat_detail', $data);
    }

    public function hapus_pesanan($id_pesanan)
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) redirect('auth/login');

        $pesanan = $this->db->get_where('pesanan', ['id_pesanan' => $id_pesanan])->row();

        if (!$pesanan || $pesanan->user_id != $user_id) {
            $this->session->set_flashdata('error', 'Pesanan tidak ditemukan.');
            redirect('toko/riwayat');
        }

        if ($pesanan->status_pesanan != 'Menunggu Pembayaran' &&
            $pesanan->status_pesanan != 'Dibatalkan') {

            $this->session->set_flashdata('error', 'Pesanan tidak bisa dihapus.');
            redirect('toko/riwayat');
        }

        $this->Toko_model->delete_pesanan_dan_detail($id_pesanan);
        $this->session->set_flashdata('success', 'Riwayat pesanan dihapus.');
        redirect('toko/riwayat');
    }

    /* =======================
           VOUCHER SYSTEM
       ====================== */
    public function apply_voucher()
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) redirect('auth/login');

        $kode = trim($this->input->post('kode_voucher'));
        if (empty($kode)) {
            $this->session->set_flashdata('error', 'Kode voucher tidak boleh kosong.');
            redirect('toko/keranjang');
        }

        $cart_total = $this->cart->total();
        $result = $this->Toko_model->validate_and_calculate_voucher($kode, $user_id, $cart_total);

        if ($result['status']) {
            $this->session->set_userdata('voucher', [
                'id_voucher'   => $result['voucher']->id_voucher,
                'kode_voucher' => $result['voucher']->kode_voucher,
                'diskon'       => $result['voucher']->nilai_diskon_terhitung
            ]);

            $this->session->set_flashdata('success', 'Voucher berhasil digunakan.');
        } else {
            $this->session->unset_userdata('voucher');
            $this->session->set_flashdata('error', $result['message']);
        }

        redirect('toko/keranjang');
    }

    public function remove_voucher()
    {
        $this->session->unset_userdata('voucher');
        $this->session->set_flashdata('success', 'Voucher dihapus.');
        redirect('toko/keranjang');
    }

    /* =======================
           PLACE ORDER
       ====================== */
    public function place_order()
    {
        $user_id = $this->session->userdata('user_id');
        $checkout_data = $this->session->userdata('data_checkout');

        if (!$user_id || $this->cart->total_items() == 0 || !$checkout_data) {
            $this->session->set_flashdata('error', 'Checkout data tidak lengkap. Silakan ulangi proses.');
            redirect('toko/keranjang');
        }

        $voucher = $this->session->userdata('voucher');
        $total_keranjang = $this->cart->total();
        $ongkir = 15000;

        $diskon = $voucher['diskon'] ?? 0;
        $total_bayar_akhir = ($total_keranjang + $ongkir) - $diskon;
        if ($total_bayar_akhir < 0) $total_bayar_akhir = 0;

        $pesanan_data = [
            'user_id' => $user_id,
            'tanggal_pesan' => date('Y-m-d H:i:s'),
            'nama_penerima' => $checkout_data['nama_penerima'],
            'alamat_kirim'  => $checkout_data['alamat_kirim'],
            'total_bayar'   => $total_bayar_akhir,
            'ongkir'        => $ongkir,
            'metode_pembayaran' => $checkout_data['metode_pembayaran'],
            'status_pesanan' => 'Menunggu Pembayaran',
            'id_voucher' => $voucher['id_voucher'] ?? null,
            'kode_voucher_digunakan' => $voucher['kode_voucher'] ?? null,
            'nilai_diskon_voucher'   => $diskon
        ];

        $id_pesanan = $this->Toko_model->insert_pesanan_dan_detail($pesanan_data, $this->cart->contents());

        if ($voucher && $id_pesanan) {
            $this->db->insert('voucher_usage', [
                'id_voucher' => $voucher['id_voucher'],
                'user_id'    => $user_id,
                'id_pesanan' => $id_pesanan
            ]);
            $this->session->unset_userdata('voucher');
        }

        $this->session->unset_userdata('data_checkout');

        $this->cart->destroy();
        $this->session->set_flashdata('success', 'Pesanan berhasil dibuat! Selesaikan pembayaran Anda.');
        redirect('toko/konfirmasi_pembayaran/' . $id_pesanan);
    }
}
