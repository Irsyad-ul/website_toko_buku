<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $judul; ?> | Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/admin_voucher.css'); ?>"> 
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
                
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
                <?php endif; ?>

                <a href="<?php echo site_url('admin/tambah_voucher'); ?>" class="link-tambah">
                    <i class="fas fa-plus"></i> Tambah Voucher Baru
                </a>

                <?php if ($vouchers): ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Deskripsi</th>
                            <th>Diskon</th>
                            <th>Min. Beli</th>
                            <th>Periode Aktif</th>
                            <th>Kuota</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($vouchers as $v): ?>
                        <tr>
                            <td><span class="voucher-code"><?php echo $v->kode_voucher; ?></span></td>
                            <td><?php echo $v->deskripsi ?: '-'; ?></td>
                            <td>
                                <?php if ($v->tipe_diskon == 'persen'): ?>
                                    <?php echo $v->nilai_diskon; ?>%
                                    <?php if ($v->maks_diskon > 0): ?>
                                        <span class="quota-info">(Max: Rp <?php echo number_format($v->maks_diskon, 0, ',', '.'); ?>)</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    Rp <?php echo number_format($v->nilai_diskon, 0, ',', '.'); ?>
                                <?php endif; ?>
                            </td>
                            <td>Rp <?php echo number_format($v->min_pembelian, 0, ',', '.'); ?></td>
                            <td>
                                <span class="quota-info">Mulai: <?php echo date('d M y H:i', strtotime($v->tgl_mulai)); ?></span>
                                <span class="quota-info">Akhir: <?php echo date('d M y H:i', strtotime($v->tgl_akhir)); ?></span>
                            </td>
                            <td>
                                Global: **<?php echo $v->used_count; ?>**/<?php echo $v->kuota_global; ?>
                                <span class="quota-info">(Per User: <?php echo $v->kuota_per_user; ?>x)</span>
                            </td>
                            <td>
                                <?php if ($v->is_active && strtotime($v->tgl_akhir) >= time()): ?>
                                    <span class="status-aktif">Aktif</span>
                                <?php elseif (strtotime($v->tgl_akhir) < time()): ?>
                                    <span class="status-nonaktif status-kadaluarsa">Kadaluarsa</span>
                                <?php else: ?>
                                    <span class="status-nonaktif">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="action-links">
                                <a href="<?php echo site_url('admin/edit_voucher/' . $v->id_voucher); ?>" class="link-edit"><i class="fas fa-edit"></i> Edit</a>
                                <a href="<?php echo site_url('admin/delete_voucher/' . $v->id_voucher); ?>" class="link-delete" onclick="return confirm('Yakin ingin menghapus voucher <?php echo $v->kode_voucher; ?>? Ini akan menghapus semua riwayat penggunaannya.');">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <p class="text-center">Belum ada data voucher yang tersedia.</p>
                <?php endif; ?>

            </div>
            
        </div>
    </div>
    
</body>
</html>