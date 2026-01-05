<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $judul; ?> | Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/admin_voucher_form.css'); ?>"> 
</head>
<body>
    
    <div class="main-wrapper">
        
        <div class="sidebar">
            <h2>Admin Panel</h2>
            <ul class="nav-links">
                <li>
                    <a href="<?php echo site_url('admin/dashboard'); ?>">
                        <i class="fas fa-chart-line"></i>
                        <span class="link_name">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url('admin/buku'); ?>">
                        <i class="fas fa-book"></i>
                        <span class="link_name">Kelola Buku</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url('admin/voucher'); ?>" class="active">
                        <i class="fas fa-tags"></i>
                        <span class="link_name">Kelola Voucher</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url('admin/pesanan'); ?>">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="link_name">Kelola Pesanan</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url('admin/customer'); ?>">
                        <i class="fas fa-users"></i>
                        <span class="link_name">Kelola Customer</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url('auth/logout'); ?>">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="link_name">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="content-wrapper">
            
            <div class="content-header">
                <h2><i class="fas fa-tag"></i> <?php echo $judul; ?></h2>
                <div class="user-info">Hi, <strong><?php echo $nama_admin; ?></strong></div>
            </div>
            
            <div class="main-content">
                
                <div class="form-container">
                    
                    <?php 
                        // Tentukan URL form: Jika ada $voucher, ini adalah Edit, jika tidak, ini adalah Tambah
                        $action_url = isset($voucher) ? site_url('admin/edit_voucher/' . $voucher->id_voucher) : site_url('admin/tambah_voucher');
                    ?>
                    <?php echo form_open($action_url); ?>

                        <div class="form-group">
                            <label for="kode_voucher">Kode Voucher <span style="color: red;">*</span></label>
                            <input type="text" name="kode_voucher" value="<?php echo set_value('kode_voucher', $voucher->kode_voucher ?? ''); ?>" required placeholder="Contoh: MERDEKA78">
                            <?php echo form_error('kode_voucher', '<div class="error-message">', '</div>'); ?>
                        </div>
                        
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" rows="3" placeholder="Deskripsi singkat voucher"><?php echo set_value('deskripsi', $voucher->deskripsi ?? ''); ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="tipe_diskon">Tipe Diskon <span style="color: red;">*</span></label>
                            <select name="tipe_diskon" id="tipe_diskon" required>
                                <?php $tipe_selected = set_value('tipe_diskon', $voucher->tipe_diskon ?? 'persen'); ?>
                                <option value="persen" <?php echo ($tipe_selected == 'persen') ? 'selected' : ''; ?>>Persentase (%)</option>
                                <option value="tetap" <?php echo ($tipe_selected == 'tetap') ? 'selected' : ''; ?>>Nominal Tetap (Rp)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="nilai_diskon">Nilai Diskon <span style="color: red;">*</span></label>
                            <input type="number" name="nilai_diskon" value="<?php echo set_value('nilai_diskon', $voucher->nilai_diskon ?? ''); ?>" required min="1" placeholder="Misal: 10 (untuk 10% atau Rp 10.000)">
                            <?php echo form_error('nilai_diskon', '<div class="error-message">', '</div>'); ?>
                        </div>
                        
                        <div class="form-group" id="maks_diskon_group">
                            <label for="maks_diskon">Maksimal Diskon (Rp) (Kosongkan jika tidak ada batas)</label>
                            <input type="number" name="maks_diskon" value="<?php echo set_value('maks_diskon', $voucher->maks_diskon ?? ''); ?>" placeholder="Misal: 50000">
                        </div>

                        <div class="form-group">
                            <label for="min_pembelian">Minimum Pembelian (Rp) <span style="color: red;">*</span></label>
                            <input type="number" name="min_pembelian" value="<?php echo set_value('min_pembelian', $voucher->min_pembelian ?? 0); ?>" required min="0" placeholder="Misal: 100000">
                        </div>
                        
                        <hr>
                        <h4>Pengaturan Kuota & Waktu</h4>

                        <div class="form-group">
                            <label for="kuota_global">Kuota Global <span style="color: red;">*</span></label>
                            <input type="number" name="kuota_global" value="<?php echo set_value('kuota_global', $voucher->kuota_global ?? 100); ?>" required min="1" placeholder="Total voucher yang tersedia">
                            <?php echo form_error('kuota_global', '<div class="error-message">', '</div>'); ?>
                        </div>

                        <div class="form-group">
                            <label for="kuota_per_user">Kuota Per User (Kali) <span style="color: red;">*</span></label>
                            <input type="number" name="kuota_per_user" value="<?php echo set_value('kuota_per_user', $voucher->kuota_per_user ?? 1); ?>" required min="1" placeholder="Maksimum penggunaan per customer">
                        </div>
                        
                        <div class="form-group">
                            <label for="tgl_mulai">Tanggal & Waktu Mulai <span style="color: red;">*</span></label>
                            <?php 
                                // Format tanggal agar kompatibel dengan input type="datetime-local" (Y-m-d\TH:i)
                                $tgl_mulai = set_value('tgl_mulai', $voucher->tgl_mulai ?? date('Y-m-d H:i'));
                                $tgl_mulai_formatted = date('Y-m-d\TH:i', strtotime($tgl_mulai));
                            ?>
                            <input type="datetime-local" name="tgl_mulai" value="<?php echo $tgl_mulai_formatted; ?>" required>
                            <?php echo form_error('tgl_mulai', '<div class="error-message">', '</div>'); ?>
                        </div>

                        <div class="form-group">
                            <label for="tgl_akhir">Tanggal & Waktu Berakhir <span style="color: red;">*</span></label>
                            <?php 
                                $tgl_akhir = set_value('tgl_akhir', $voucher->tgl_akhir ?? date('Y-m-d H:i', strtotime('+1 month')));
                                $tgl_akhir_formatted = date('Y-m-d\TH:i', strtotime($tgl_akhir));
                            ?>
                            <input type="datetime-local" name="tgl_akhir" value="<?php echo $tgl_akhir_formatted; ?>" required>
                            <?php echo form_error('tgl_akhir', '<div class="error-message">', '</div>'); ?>
                        </div>
                        
                        <div class="form-group">
                            <label>Status</label>
                            <div class="checkbox-group">
                                <?php 
                                    // Pastikan nilai default 1 (aktif) jika tidak ada data voucher
                                    $is_active_checked = set_value('is_active', $voucher->is_active ?? 1); 
                                ?>
                                <input type="checkbox" name="is_active" value="1" id="is_active" <?php echo ($is_active_checked == 1) ? 'checked' : ''; ?>>
                                <label for="is_active" style="margin: 0; font-weight: 400;">Aktifkan Voucher</label>
                            </div>
                        </div>

                        <hr>
                        
                        <a href="<?php echo site_url('admin/voucher'); ?>" class="btn-back"><i class="fas fa-arrow-left"></i> Batal</a>
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-save"></i> <?php echo isset($voucher) ? 'Simpan Perubahan' : 'Buat Voucher'; ?>
                        </button>
                    <?php echo form_close(); ?>
                </div>

            </div>
            
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tipeDiskon = document.getElementById('tipe_diskon');
            const maksDiskonGroup = document.getElementById('maks_diskon_group');

            function toggleMaksDiskon() {
                // Tampilkan Maksimal Diskon hanya jika tipe diskon adalah Persentase
                if (tipeDiskon.value === 'persen') {
                    maksDiskonGroup.style.display = 'block';
                } else {
                    maksDiskonGroup.style.display = 'none';
                    // Hapus nilai maks_diskon jika tidak digunakan untuk menghindari validasi error
                    document.querySelector('input[name="maks_diskon"]').value = '';
                }
            }

            // Jalankan saat halaman dimuat (untuk inisiasi nilai saat Edit atau ada kesalahan validasi)
            toggleMaksDiskon();

            // Jalankan saat nilai dropdown berubah
            tipeDiskon.addEventListener('change', toggleMaksDiskon);
        });
    </script>
</body>
</html>