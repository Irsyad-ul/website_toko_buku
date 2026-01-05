<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin | Toko Buku</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/custom_admin.css'); ?>"> 
</head>

<body>
    
    <div class="sidebar">
        <div class="logo">
            Toko Buku Admin
        </div>

        <div class="user-info">
            <p>Admin Saat Ini:</p>
            <strong><?php echo $nama_admin; ?></strong>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="#" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            </li>
            <li>
        <a href="<?php echo site_url('admin/voucher'); ?>">
            <i class="fas fa-tags"></i>
            <span class="link_name">Kelola Voucher</span>
        </a>
    </li>
            <li>
                <a href="<?php echo site_url('admin/buku'); ?>"><i class="fas fa-book-open"></i> Kelola Data Buku</a>
            </li>
           <li>
           <!-- START: MENU DENGAN NOTIFIKASI PESANAN BARU -->
           <a href="<?php echo site_url('admin/pesanan_masuk'); ?>" class="order-link">
                <i class="fas fa-shopping-cart"></i> Pesanan Masuk
                <?php 
                // Asumsi variabel $total_pesanan_baru sudah dikirim dari Controller
                $total_pesanan_baru = isset($total_pesanan_baru) ? $total_pesanan_baru : 0; 
                if ($total_pesanan_baru > 0): ?>
                    <span class="badge-notif-admin"><?php echo $total_pesanan_baru; ?></span>
                <?php endif; ?>
           </a>
           <!-- END: MENU DENGAN NOTIFIKASI PESANAN BARU -->
            </li>
            <li>
                <a href="<?php echo site_url('admin/customer'); ?>"><i class="fas fa-users"></i> Kelola User</a>
            </li>
            <li>
                <a href="<?php echo site_url('auth/logout'); ?>" style="color: #e74c3c;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
        
    </div>
    <div class="content-wrapper">
        <div class="content-header">
            <h1>Dashboard Administrator</h1>
        </div>
        
        <p>Selamat datang, <?php echo $nama_admin; ?> Ini adalah ringkasan aktivitas toko Anda:</p>

        <div class="info-cards">
            
            <div class="card buku">
                <i class="card-icon fas fa-book"></i>
                <h4>TOTAL BUKU</h4>
                <p>12</p> </div>
            
        
            
            <div class="card customer">
                <i class="card-icon fas fa-user-friends"></i>
                <h4>TOTAL CUSTOMER</h4>
                <p>3</p> </div>
     
        </div>

    </div>
    </body>
</html>