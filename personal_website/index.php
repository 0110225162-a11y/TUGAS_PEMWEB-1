<?php
session_start();
require_once 'config/database.php';

// 1. LOGIKA UPLOAD
if (isset($_FILES['profile_picture'])) {
    $target_dir = "profile_pics/";
    if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }
    
    $file_extension = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));
    $file_name = time() . '_' . $_SESSION['user_id'] . '.' . $file_extension;
    $target_file = $target_dir . $file_name;
    
    if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
        $stmt = $pdo->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
        $stmt->execute([$target_file, $_SESSION['user_id']]);
        $_SESSION['profile_picture'] = $target_file;
        
        
        // Ambil halaman asal dari URL, kalau gak ada balik ke halaman yang lagi dibuka
        $redirect_page = isset($_GET['page']) ? $_GET['page'] : 'home';
        header("Location: index.php?page=" . $redirect_page . "&status=success");
        exit();
    }
}

// 2. LOGIKA ROUTING (DIPERKUAT)
$page = isset($_GET['page']) ? $_GET['page'] : 'about'; // Default ke about kalau kosong
$allowed_pages = ['home', 'about', 'contact', 'level', 'studies', 'experience'];

if (!in_array($page, $allowed_pages)) {
    $page = 'about'; // Jaga-jaga kalau ada page aneh, balikin ke about
}

include 'header.php';
include 'menu.php'; 
?>

<div class="container mt-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <?php include 'sidebar.php'; ?>
        </div>
        
        <!-- Konten Utama -->
        <div class="col-md-9">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <?php
                    // disini kita menggunakan path absolut biar gak bingung nyari filenya
                    $file_path = dirname(__FILE__) . "/pages/{$page}.php";
                    
                    if (file_exists($file_path)) {
                        include $file_path;
                    } else {
                        // Kalau file gak ada, kita kasih tau file mana yang ilang buat debug
                        echo "<div class='alert alert-danger'>
                                <strong>Waduh!</strong> File <code>pages/{$page}.php</code> gak ketemu bray. 
                                Cek lagi nama filenya di folder pages!
                              </div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>