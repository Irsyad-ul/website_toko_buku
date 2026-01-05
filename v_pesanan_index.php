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
        .data-table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; border-radius: 8px; overflow: hidden; }
        .data-table th, .data-table td { padding: 12px; text-align: left; border-bottom: 1px solid #f0f0f0; }
        .data-table th { background-color: #2c3e50; color: white; font-weight: 600; }
        .data-table tr:hover { background-color: #fcfcfc; }
        .btn-detail { padding: 8px 12px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px; font-size: 0.9em; }
        .status-badge { padding: 5px 10px; border-radius: 4px; color: white; font-weight: 600; font-size: 0.85em;}
        .status-Menunggu-Pembayaran { background-color: #ffc107; color: #333; }
        .status-Diproses { background-color: #007bff; }
        .status-Dikirim { background-color: #28a745; }
        .status-Selesai { background-color: #6c757d; }
        .status-Dibatalkan { background-color: #dc3545; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">Toko Buku Admin</div>
        <div class="user-info">
            <p>Admin Saat Ini:</p>
            <strong><?php echo $this->session->userdata('nama') ?: 'Administrator'; ?></strong>
        </div>
        <ul class="sidebar-menu">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="<?php echo site_url('admin/buku'); ?>"><i class="fas fa-book-open"></i> Kelola Data Buku</a></li>
            <li><a href="<?php echo site_url('admin/pesanan_masuk'); ?>" class="active"><i class="fas fa-shopping-cart"></i> Pesanan Masuk</a></li>
            <li><a href="<?php echo site_url('admin/customer'); ?>"><i class="fas fa-users"></i> Kelola User</a></li>
            <li><a href="<?php echo site_url('auth/logout'); ?>" style="color: #e74c3c;"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <div class="content-wrapper">
        <div class="content-header">
            <h1><?php echo $judul; ?></h1>
        </div>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="flash-success"><?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>

        <div class="card">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Tgl. Pesan</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pesanan)): ?>
                        <?php foreach ($pesanan as $p): ?>
                            <tr>
                                <td>#<?php echo $p->id_pesanan; ?></td>
                                <td><?php echo date('d M Y H:i', strtotime($p->tanggal_pesan)); ?></td>
                                <td><?php echo $p->nama_lengkap; ?></td>
                                <td>Rp <?php echo number_format($p->total_bayar, 0, ',', '.'); ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo str_replace(' ', '-', $p->status_pesanan); ?>">
                                        <?php echo $p->status_pesanan; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo site_url('admin/detail_pesanan/' . $p->id_pesanan); ?>" class="btn-detail"><i class="fas fa-eye"></i> Detail</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">Belum ada pesanan masuk.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>