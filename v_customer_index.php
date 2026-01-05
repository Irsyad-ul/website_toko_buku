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
        .btn-action { padding: 6px 10px; font-size: 0.9em; border-radius: 4px; text-decoration: none; margin-right: 5px; }
        .btn-view { background-color: #17a2b8; color: white; }
        .btn-delete { background-color: #dc3545; color: white; }
    </style>
</head>
<body>
    
    <div class="sidebar">
        <div class="logo">Toko Buku Admin</div>
        <div class="user-info">
            <p>Admin Saat Ini:</p>
            <strong><?php echo $nama_admin; ?></strong>
        </div>
        <ul class="sidebar-menu">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="<?php echo site_url('admin/buku'); ?>"><i class="fas fa-book-open"></i> Kelola Data Buku</a></li>
            <li><a href="<?php echo site_url('admin/pesanan_masuk'); ?>"><i class="fas fa-shopping-cart"></i> Pesanan Masuk</a></li> 
            <li><a href="<?php echo site_url('admin/customer'); ?>" class="active"><i class="fas fa-users"></i> Kelola User</a></li>
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
            
            <?php if (!empty($customer)): ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>No. Telepon</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($customer as $cust): ?>
                            <tr>
                                <td><?php echo $no++; ?>.</td>
                                <td><?php echo $cust->nama_lengkap; ?></td>
                                <td><?php echo $cust->email; ?></td>
                                <td><?php echo $cust->no_telp ?? '-'; ?></td>
                                <td><?php echo date('d M Y', strtotime($cust->created_at)); ?></td>
                                <td>
                                    <a href="#" class="btn-action btn-view" title="Lihat Detail"><i class="fas fa-eye"></i></a>
                                    <a href="<?php echo site_url('admin/delete_customer/' . $cust->user_id); ?>" 
                                       class="btn-action btn-delete" 
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus customer ini? Semua data pesanan yang terkait juga akan terpengaruh.')" 
                                       title="Hapus Customer"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="text-align: center; padding: 30px;">Belum ada data customer yang terdaftar.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>