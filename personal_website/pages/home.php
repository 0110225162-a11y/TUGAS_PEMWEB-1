<div class="container-fluid">
    <h2 class="mb-4 border-bottom pb-2"><i class="fas fa-tachometer-alt"></i> Halaman Profil</h2>
    
    <div class="card mb-3 shadow-sm border-0">
        <div class="row g-0">
            <!-- Kolom Foto Profil -->
            <div class="col-md-4 d-flex align-items-center justify-content-center bg-light rounded-start">
                <?php
                // Gunakan ID dari session biar otomatis
                $profile_id_owner = 1; 

                $stmt = $pdo->prepare("SELECT profile_picture FROM users WHERE id = ?");
                $stmt->execute([$profile_id_owner]);
                $profile_pic = $stmt->fetchColumn();

                if(!$profile_pic || !file_exists($profile_pic)) {
                    $profile_pic = 'profile_pics/default.jpg';
                }
                ?>
                <!-- disini ditambahin ?t=time biar foto langsung ganti pas diupload-->
                <img 
                src="<?= $profile_pic ?>?t=<?= time() ?>" 
                class="img-fluid shadow-sm p-2 bg-white"
                alt="Foto Profil"
                style="
                    width: 250px;
                    height: 250px;
                    object-fit: cover;
                    border-radius: 15px;
                    border: 4px solid #ffffff; ">
            </div>
            
            <!-- Kolom Biodata dan Tombol -->
            <div class="col-md-8">
                <div class="card-body">
                    <h3 class="card-title">Zikra Mahkota Hasan</h3>
                    <p class="card-text">Halo! Saya Zikra Mahkota Hasan, mahasiswa di STT Nurul Fikri jurusan Teknik Informatika 2025.</p>
                    <p class="card-text">Saya lahir di Kota Bogor, 17 Agustus 2004, saya lulusan dari SDN Batutulis 1 Kota Bogor, dan juga lulusan dari Pondok Pesantren Miftahul Ulum,
                       alhamdulillah saya bertahan di penjara suci itu selama 6 tahun lama nya. Dan saya juga lulusan dari MTsS Miftahul Ulum & MA Miftahul Ulum.</p>
                    <p class="card-text"><small class="text-muted"><i class="fas fa-map-marker-alt"></i> Kampus B STT Nurul Fikri, Indonesia</small></p>
                    
                    <!-- Tombol diarahin langsung ke file upload-->
                    <?php if(isset($_SESSION['role']) && strtolower($_SESSION['role']) == 'admin'): ?>
                        <a href="upload_profile_pic.php" class="btn btn-primary">
                          <i class="fas fa-camera"></i> Ganti Foto Profil
                         </a>
                    <?php endif; ?>
                    
                    <a href="#" class="btn btn-outline-secondary"><i class="fab fa-github"></i> GitHub Saya</a>
                </div>
            </div>
        </div>
    </div>
</div>