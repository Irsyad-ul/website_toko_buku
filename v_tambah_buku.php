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
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        .btn-submit { background-color: #4cd3c2; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: 600; }
        .error-message { color: #e74c3c; font-size: 0.9em; margin-top: -10px; margin-bottom: 10px; }
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
        
        <a href="<?php echo site_url('admin/buku'); ?>" style="text-decoration: none; color: #555; display: block; margin-bottom: 15px;">&larr; Kembali ke Daftar Buku</a>

        <div class="card" style="padding: 20px;">
            <?php echo form_open_multipart('admin/simpan_buku'); ?>
            
            <div class="form-group">
                <label for="id_kategori">Kategori</label>
                <select name="id_kategori" required>
                    <option value="">Pilih Kategori</option>
                    <?php 
                    // Pastikan variabel $kategori ada (dikirim dari Controller)
                    if (isset($kategori) && is_array($kategori)):
                        foreach ($kategori as $k): 
                    ?>
                        <option value="<?php echo $k->id_kategori; ?>" 
                            <?php echo set_select('id_kategori', $k->id_kategori); ?>>
                            <?php echo $k->nama_kategori; ?>
                        </option>
                    <?php 
                        endforeach;
                    endif;
                    ?>
                </select>
                <?php echo form_error('id_kategori', '<div class="error-message">', '</div>'); ?>
            </div>
            
            <div class="form-group">
                <label for="judul">Judul Buku</label>
                <input type="text" name="judul" value="<?php echo set_value('judul'); ?>" required>
                <?php echo form_error('judul', '<div class="error-message">', '</div>'); ?>
            </div>
            
            <div class="form-group">
                <label for="penulis">Penulis</label>
                <input type="text" name="penulis" value="<?php echo set_value('penulis'); ?>" required>
                <?php echo form_error('penulis', '<div class="error-message">', '</div>'); ?>
            </div>
            
            <div class="form-group">
                <label for="penerbit">Penerbit</label>
                <input type="text" name="penerbit" value="<?php echo set_value('penerbit'); ?>">
            </div>
            
            <div class="form-group">
                <label for="tahun_terbit">Tahun Terbit</label>
                <input type="number" name="tahun_terbit" value="<?php echo set_value('tahun_terbit', date('Y')); ?>" min="1900" max="<?php echo date('Y'); ?>">
            </div>
            
            <div class="form-group">
                <label for="harga">Harga (Rp)</label>
                <input type="number" name="harga" value="<?php echo set_value('harga'); ?>" required>
                <?php echo form_error('harga', '<div class="error-message">', '</div>'); ?>
            </div>
            
            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" name="stok" value="<?php echo set_value('stok'); ?>" required>
                <?php echo form_error('stok', '<div class="error-message">', '</div>'); ?>
            </div>
            
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" rows="5"><?php echo set_value('deskripsi'); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="gambar">Cover Buku (JPG/PNG)</label>
                <input type="file" name="gambar" id="gambar" accept=".jpg, .jpeg, .png" required>
                <small>Ukuran maksimal 2MB</small>
                
                <?php 
                // Menampilkan error upload jika ada
                if (isset($error_upload)): 
                    echo '<div class="error-message">' . $error_upload . '</div>';
                endif; 
                ?>
            </div>

            <button type="submit" class="btn-submit">Simpan Buku</button>
            <?php echo form_close(); ?>
        </div>
    </div>
</body>
</html>