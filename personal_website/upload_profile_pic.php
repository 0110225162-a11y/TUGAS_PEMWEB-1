<?php
session_start();
// Koneksi database
require_once 'config/database.php';

// 1. Proteksi Login
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = '';
$error = '';

// 2. LOGIKA PROSES UPLOAD
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_picture'])) {
    $target_dir = "profile_pics/";
    
    // Bikin folder kalau belum ada
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_extension = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));
    $file_name = "user_" . $user_id . "_" . time() . "." . $file_extension;
    $target_file = $target_dir . $file_name;

    //disini kita Cek apakah beneran gambar atau bukan, biar gak asal upload file sembarangan
    $check = getimagesize($_FILES['profile_picture']['tmp_name']);
    if($check !== false) {
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
            
            // UPDATE DATABASE
            $stmt = $pdo->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
            if($stmt->execute([$target_file, $user_id])) {
                $_SESSION['profile_picture'] = $target_file;
                $message = "Foto profil berhasil diganti.";
            } else {
                $error = "Database gagal diupdate.";
            }
        } else {
            $error = "Gagal mindahin file ke folder. Cek permission folder profile_pics!";
        }
    } else {
        $error = "File itu bukan gambar!";
    }
}

//AMBIL DATA TERBARU UNTUK PREVIEW
$stmt = $pdo->prepare("SELECT username, profile_picture FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$row = $stmt->fetch();
$foto_sekarang = (!empty($row['profile_picture']) && file_exists($row['profile_picture'])) 
                 ? $row['profile_picture'] 
                 : 'profile_pics/default.jpg';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ganti Foto Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="mb-0">Ganti Foto Profil</h5>
                    </div>
                    <div class="card-body text-center">
                        
                        <?php if($message): ?>
                            <div class="alert alert-success"><?= $message ?></div>
                        <?php endif; ?>

                        <?php if($error): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>

                        <div class="mb-4">
                            <!-- t=time biar gak kena cache browser-->
                            <img src="<?= $foto_sekarang ?>?t=<?= time() ?>" 
                                 class="rounded-circle border shadow-sm" 
                                 style="width: 150px; height: 150px; object-fit: cover;">
                            <h4 class="mt-2"><?= htmlspecialchars($row['username']) ?></h4>
                        </div>

                        <!-- ACTION KOSONG BIAR TETAP DI HALAMAN INI -->
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3 text-start">
                                <label class="form-label">Pilih File Foto</label>
                                <input type="file" name="profile_picture" class="form-control" required>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-upload"></i> Upload & Simpan
                                </button>
                                <a href="index.php?page=home" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                                </a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>