<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $judul; ?> | Admin</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/custom_admin.css'); ?>"> 
    
    <style>
        /* Container untuk detail utama */
        .detail-group-wrapper { display: flex; gap: 20px; margin-bottom: 20px; }
        .detail-col { flex: 1; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .detail-col h3 { border-bottom: 1px solid #eee; padding-bottom: 10px; margin-top: 0; margin-bottom: 15px; color: #333; }
        .detail-col p { margin: 8px 0; line-height: 1.5; }
        .detail-col strong { color: #2c3e50; font-weight: 600; }
        
        /* Tabel Item */
        .detail-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .detail-table th, .detail-table td { padding: 12px; border: 1px solid #ddd; text-align: left; font-size: 0.9em; }
        .detail-table th { background-color: #ecf0f1; }
        
        /* Status Badge */
        .status-badge { padding: 5px 10px; border-radius: 4px; font-weight: bold; color: white; display: inline-block; font-size: 0.9em;}
        .status-Menunggu-Pembayaran { background-color: #ffc107; color: #333; }
        .status-Diproses { background-color: #007bff; }
        .status-Dikirim { background-color: #28a745; }
        .status-Selesai { background-color: #6c757d; }
        .status-Dibatalkan { background-color: #dc3545; }
        
        /* Form Update Status */
        .status-update-form { display: flex; align-items: center; gap: 10px; margin-top: 25px; padding: 15px; background: #f0f8ff; border: 1px solid #cceeff; border-radius: 8px; }
        .status-update-form select { padding: 8px; border-radius: 5px; border: 1px solid #007bff; }
        .status-update-form button { background-color: #007bff; color: white; padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s; }
        .status-update-form button:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    
    <div class="sidebar">
        <div class="logo">Toko Buku Admin</div>
        <div class="user-info">
            <p>Admin Saat Ini:</p>
            <strong><?php echo $nama_admin ?? ($this->session->userdata('nama_lengkap') ?: 'Administrator'); ?></strong> 
        </div>
        <ul class="sidebar-menu">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="<?php echo site_url('admin/buku'); ?>"><i class="fas fa-book-open"></i> Kelola Data Buku</a></li>
            <li><a href="<?php echo site_url('admin/pesanan_masuk'); ?>" class="active"><i class="fas fa-shopping-cart"></i> Pesanan Masuk</a></li>
            <li><a href="#"><i class="fas fa-users"></i> Kelola User</a></li>
            <li><a href="<?php echo site_url('auth/logout'); ?>" style="color: #e74c3c;"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>
    <div class="content-wrapper">
        <div class="content-header">
            <h1>Detail Pesanan #<?php echo $header->id_pesanan; ?></h1>
            <a href="<?php echo site_url('admin/pesanan_masuk'); ?>" class="btn-secondary" style="float: right; margin-top: -35px;"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="flash-success"><?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>

        <div class="detail-group-wrapper">
            
            <div class="detail-col">
                <h3>Informasi Pesanan <i class="fas fa-info-circle"></i></h3>
                <p><strong>Status:</strong> 
                    <span class="status-badge status-<?php echo str_replace(' ', '-', $header->status_pesanan); ?>">
                        <?php echo $header->status_pesanan; ?>
                    </span>
                </p>
                <p><strong>Total Bayar:</strong> <span style="font-size: 1.2em; color: #e67e22; font-weight: bold;">Rp <?php echo number_format($header->total_bayar, 0, ',', '.'); ?></span></p>
                <p><strong>Tanggal Pesan:</strong> <?php echo date('d M Y H:i', strtotime($header->tanggal_pesan)); ?></p>
                <p><strong>Batas Bayar:</strong> <?php echo date('d M Y H:i', strtotime($header->batas_bayar)); ?></p>

                <div class="status-update-form">
                    <?php echo form_open('admin/update_status'); ?>
                        <input type="hidden" name="id_pesanan" value="<?php echo $header->id_pesanan; ?>">
                        <label for="status_pesanan" style="margin: 0;">Ubah Status:</label>
                        <select name="status_baru">
                            <option value="Menunggu Pembayaran" <?php echo ($header->status_pesanan == 'Menunggu Pembayaran') ? 'selected' : ''; ?>>Menunggu Pembayaran</option>
                            <option value="Diproses" <?php echo ($header->status_pesanan == 'Diproses') ? 'selected' : ''; ?>>Diproses</option>
                            <option value="Dikirim" <?php echo ($header->status_pesanan == 'Dikirim') ? 'selected' : ''; ?>>Dikirim</option>
                            <option value="Selesai" <?php echo ($header->status_pesanan == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
                            <option value="Dibatalkan" <?php echo ($header->status_pesanan == 'Dibatalkan') ? 'selected' : ''; ?>>Dibatalkan</option>
                        </select>
                        <button type="submit"><i class="fas fa-save"></i> Update</button>
                    <?php echo form_close(); ?>
                </div>
            </div>

            <div class="detail-col">
                <h3>Informasi Pengiriman <i class="fas fa-truck"></i></h3>
                <p><strong>Customer:</strong> <?php echo $header->nama_lengkap; ?></p>
                <p><strong>Nama Penerima:</strong> <?php echo $header->nama_penerima; ?></p>
                <p><strong>Alamat Kirim:</strong> <?php echo nl2br($header->alamat_kirim); ?></p>
            </div>
            
        </div>
        <div class="card" style="padding: 20px;">
            <h2>Daftar Item Pesanan <i class="fas fa-list-ul"></i></h2>
            <table class="detail-table">
                <thead>
                    <tr>
                        <th>Judul Buku</th>
                        <th>Harga Satuan</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $grand_total = 0; ?>
                    <?php foreach ($detail as $item): ?>
                    <?php $subtotal = $item->qty * $item->harga_satuan; $grand_total += $subtotal; ?>
                    <tr>
                        <td><?php echo $item->judul_buku; ?></td>
                        <td>Rp <?php echo number_format($item->harga_satuan, 0, ',', '.'); ?></td>
                        <td><?php echo $item->qty; ?></td>
                        <td>Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: right; font-weight: bold; font-size: 1.1em; background-color: #f8f8f8;">TOTAL KESELURUHAN:</td>
                        <td style="font-weight: bold; font-size: 1.1em; background-color: #f8f8f8;">
                            <strong>Rp <?php echo number_format($grand_total, 0, ',', '.'); ?></strong>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        </div>
</body>
</html>