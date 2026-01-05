<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Buku | Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/custom_admin.css'); ?>">
    <style>
        .data-table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; border-radius: 8px; overflow: hidden; }
        .data-table th, .data-table td { padding: 12px; text-align: left; border-bottom: 1px solid #f0f0f0; }
        .data-table th { background-color: #2c3e50; color: white; font-weight: 600; }
        .data-table tr:hover { background-color: #fcfcfc; }
        .action-btn { padding: 5px 10px; margin-right: 5px; border-radius: 4px; text-decoration: none; font-size: 0.9em; }
        .btn-edit { background-color: #f39c12; color: white; }
        .btn-delete { background-color: #e74c3c; color: white; }
        .btn-tambah { padding: 10px 15px; background-color: #4cd3c2; color: white; text-decoration: none; border-radius: 5px; margin-bottom: 20px; display: inline-block; font-weight: 600; }
        .flash-success { background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
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
            <li><a href="<?php echo site_url('admin/buku'); ?>" class="active"><i class="fas fa-book-open"></i> Kelola Data Buku</a></li>
            <li><a href="<?php echo site_url('admin/pesanan_masuk'); ?>"><i class="fas fa-shopping-cart"></i> Pesanan Masuk</a></li>
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

        <a href="<?php echo site_url('admin/tambah_buku'); ?>" class="btn-tambah">
            <i class="fas fa-plus"></i> Tambah Buku
        </a>

        <div class="card">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>deskripsi</th>
                        <th>gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($buku)): ?>
                        <?php foreach ($buku as $b): ?>
                            <tr>
                                <td><?php echo $b->id_buku; ?></td>
                                <td><?php echo $b->judul; ?></td>
                                <td><?php echo $b->penulis; ?></td>
                                <td><?php echo $b->penerbit; ?></td>
                                <td>Rp <?php echo number_format($b->harga, 0, ',', '.'); ?></td>
                                <td><?php echo $b->stok; ?></td>
                                <td><?php echo $b->deskripsi; ?></td>
                                <td><?php echo $b->gambar; ?></td>
                                <td>
                                    <a href="<?php echo site_url('admin/edit_buku/' . $b->id_buku); ?>" class="action-btn btn-edit"><i class="fas fa-edit"></i> Edit</a>
                                    <a href="<?php echo site_url('admin/hapus_buku/' . $b->id_buku); ?>" class="action-btn btn-delete" onclick="return confirm('Yakin ingin menghapus buku ini?');"><i class="fas fa-trash-alt"></i> Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center;">Belum ada data buku.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>