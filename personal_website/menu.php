<?php
// menu.php, lengkap dengan dropdown My Studies (Level & Studies)
?>
<div class="row">
    <div class="col-12">
        <!-- Nah, di tag nav ini kita tambahin position & z-index biar tampil paling depan -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary rounded shadow-sm" style="position: relative; z-index: 1050;">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" href="index.php?page=home">
                    <i class="fas fa-laptop-code"></i> Zikra Project
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    
                    <!-- Kumpulan Menu Sebelah Kiri -->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="index.php?page=home">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?page=about">About Me</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?page=contact">Contact Me</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?page=experience">My Experiences</a></li>
                        
                        <!-- DROPDOWN MY STUDIES -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">My Studies</a>
                            <ul class="dropdown-menu shadow">
                                <li><a class="dropdown-item" href="index.php?page=level">Level</a></li>
                                <li><a class="dropdown-item" href="index.php?page=studies">Studies</a></li>
                            </ul>
                        </li>
                    </ul>
                  
                    <!-- Kumpulan Menu Sebelah Kanan (Login / Logout) -->
                    <ul class="navbar-nav">
                        <?php if(isset($_SESSION['user_id'])): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
    <i class="fas fa-user-circle"></i> 
    <?= htmlspecialchars($_SESSION['username']) ?> 
    (<?= htmlspecialchars(!empty($_SESSION['role']) ? $_SESSION['role'] : 'Anggota') ?>)
</a>
                                <ul class="dropdown-menu dropdown-menu-end shadow">
                                    <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-primary btn-custom" href="login.php"><i class="fas fa-key"></i> Login</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                    
                </div>
            </div>
        </nav>
    </div>
</div>
<br><!-- Kumpulan Menu Sebelah Kanan (Login / Logout) -->
<ul class="navbar-nav">
    <?php if(isset($_SESSION['user_id'])): ?>
        
            </a>
        </li>
    <?php else: ?>
        
    <?php endif; ?>
</ul>