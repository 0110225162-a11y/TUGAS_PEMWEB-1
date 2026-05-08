
<?php
// pages/experience.php

// ===============================
// KEAMANAN BACKEND
// HANYA ADMIN BISA CRUD
// ===============================
if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin') {

    // =========================
    // TAMBAH DATA
    // =========================
    if(isset($_POST['save_experience'])) {

        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $start_year = $_POST['start_year'];
        $end_year = $_POST['end_year'];
        $type = $_POST['type'];

        $foto = 'uploads/default_experience.jpg';

        // upload foto
        if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {

            $allowed = ['jpg','jpeg','png','gif','webp'];

            $file_name = $_FILES['foto']['name'];
            $tmp = $_FILES['foto']['tmp_name'];

            $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if(in_array($ext, $allowed)) {

                $target_dir = "uploads/";

                if(!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                $new_name = time() . "_" . uniqid() . "." . $ext;

                $foto = $target_dir . $new_name;

                move_uploaded_file($tmp, $foto);
            }
        }

        $stmt = $pdo->prepare("
            INSERT INTO experiences
            (title, description, start_year, end_year, type, foto)
            VALUES (?,?,?,?,?,?)
        ");

        $stmt->execute([
            $title,
            $description,
            $start_year,
            $end_year,
            $type,
            $foto
        ]);

        echo "
        <script>
            alert('Pengalaman berhasil ditambah!');
            window.location.href='?page=experience';
        </script>
        ";
    }

    // =========================
    // UPDATE DATA
    // =========================
    if(isset($_POST['update_experience'])) {

        $id = $_POST['id'];

        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $start_year = $_POST['start_year'];
        $end_year = $_POST['end_year'];
        $type = $_POST['type'];

        // ambil foto lama
        $stmtOld = $pdo->prepare("
            SELECT foto
            FROM experiences
            WHERE id=?
        ");

        $stmtOld->execute([$id]);

        $oldData = $stmtOld->fetch();

        // upload foto baru
        if(isset($_FILES['foto_edit']) && $_FILES['foto_edit']['error'] == 0) {

            $allowed = ['jpg','jpeg','png','gif','webp'];

            $file_name = $_FILES['foto_edit']['name'];

            $tmp = $_FILES['foto_edit']['tmp_name'];

            $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if(in_array($ext, $allowed)) {

                $target_dir = "uploads/";

                if(!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                $new_name = time() . "_" . uniqid() . "." . $ext;

                $foto = $target_dir . $new_name;

                move_uploaded_file($tmp, $foto);

                // hapus foto lama
                if(
                    !empty($oldData['foto']) &&
                    $oldData['foto'] != 'uploads/default_experience.jpg' &&
                    file_exists($oldData['foto'])
                ) {
                    unlink($oldData['foto']);
                }

                $stmt = $pdo->prepare("
                    UPDATE experiences
                    SET
                        title=?,
                        description=?,
                        start_year=?,
                        end_year=?,
                        type=?,
                        foto=?
                    WHERE id=?
                ");

                $stmt->execute([
                    $title,
                    $description,
                    $start_year,
                    $end_year,
                    $type,
                    $foto,
                    $id
                ]);
            }

        } else {

            $stmt = $pdo->prepare("
                UPDATE experiences
                SET
                    title=?,
                    description=?,
                    start_year=?,
                    end_year=?,
                    type=?
                WHERE id=?
            ");

            $stmt->execute([
                $title,
                $description,
                $start_year,
                $end_year,
                $type,
                $id
            ]);
        }

        echo "
        <script>
            alert('Pengalaman berhasil diupdate!');
            window.location.href='?page=experience';
        </script>
        ";
    }

    // =========================
    // HAPUS DATA
    // =========================
    if(isset($_GET['delete_exp'])) {

        $id = $_GET['delete_exp'];

        // ambil foto
        $stmtFoto = $pdo->prepare("
            SELECT foto
            FROM experiences
            WHERE id=?
        ");

        $stmtFoto->execute([$id]);

        $fotoData = $stmtFoto->fetch();

        // hapus data
        $stmt = $pdo->prepare("
            DELETE FROM experiences
            WHERE id=?
        ");

        $stmt->execute([$id]);

        // hapus file foto
        if(
            !empty($fotoData['foto']) &&
            $fotoData['foto'] != 'uploads/default_experience.jpg' &&
            file_exists($fotoData['foto'])
        ) {
            unlink($fotoData['foto']);
        }

        echo "
        <script>
            alert('Pengalaman berhasil dihapus!');
            window.location.href='?page=experience';
        </script>
        ";
    }
}

// ===============================
// AMBIL DATA
// ===============================
$experiences = $pdo->query("
    SELECT *
    FROM experiences
    ORDER BY start_year DESC, id DESC
")->fetchAll();
?>

<style>

.exp-card{
    border:none;
    border-radius:30px;
    overflow:hidden;
    background:#fff;
    box-shadow:0 5px 18px rgba(0,0,0,0.08);
    transition:0.3s;
    position:relative;
}

.exp-card:hover{
    transform:translateY(-6px);
}

/* ========================= */
/* FOTO DIPERKECIL */
/* ========================= */
.exp-img{
    width:100%;
    height:260px; /* sebelumnya 260px */
    object-fit:cover;
    object-position:center top; /* biar muka gak ketutupan */
}

/* ========================= */
/* TAHUN DIPINDAH KE BAWAH */
/* ========================= */
.exp-year{
    position:absolute;
    top:10px;
    right:10px;
    background:rgba(24,37,61,0.92);
    color:white;
    padding:8px 10px;
    border-radius:14px;
    font-size:10px;
    font-weight:bold;
    backdrop-filter:blur(3px);
    box-shadow:0 4px 12px rgba(0,0,0,0.2);
}

/* BODY */
.exp-body{
    padding:25px;
}

.exp-title{
    font-size:20px;
    font-weight:700;
    margin-bottom:10px;
    line-height:1.4;
}

.exp-desc{
    color:#666;
    min-height:58px;
    line-height:1.6;
}

/* BUTTON */
.exp-action{
    display:flex;
    align-items:center;
    gap:10px;
    margin-top:20px;
}

.btn-detail{
    border-radius:40px;
    padding:8px 28px;
    font-weight:600;
}

.btn-icon{
    width:42px;
    height:42px;
    border-radius:60%;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#f7f7f7;
    text-decoration:none;
    border:none;
    box-shadow:0 3px 10px rgba(0,0,0,0.08);
    transition:0.2s;
}

.btn-icon:hover{
    transform:scale(1.08);
}

/* RESPONSIVE HP */
@media(max-width:768px){

    .exp-img{
        height:200px;
    }

    .exp-title{
        font-size:19px;
    }

    .exp-year{
        font-size:16px;
        padding:7px 16px;
    }

}

</style>

<div class="container-fluid">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1 class="fw-bold text-primary">
                <i class="fas fa-briefcase"></i>
                Riwayat Pengalaman
            </h1>

            <p class="text-muted">
                Daftar perjalanan karir dan organisasi.
            </p>

        </div>

        <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin'): ?>

        <button
            class="btn btn-primary btn-lg rounded-pill px-4 shadow"
            data-bs-toggle="modal"
            data-bs-target="#addExpModal"
        >
            <i class="fas fa-plus"></i>
            Tambah Baru
        </button>

        <?php endif; ?>

    </div>

    <hr>

    <!-- CARD -->
    <div class="row">

        <?php if(count($experiences) > 0): ?>

            <?php foreach($experiences as $exp): ?>

            <div class="col-md-4 mb-4">

                <div class="exp-card">

                    <!-- FOTO -->
                    <div class="position-relative">

                        <img
                            src="<?= htmlspecialchars($exp['foto']) ?>"
                            class="exp-img"
                            onerror="this.src='uploads/default_experience.jpg'"
                        >

                        <div class="exp-year">
                            <?= htmlspecialchars($exp['start_year']) ?>
                            -
                            <?= htmlspecialchars($exp['end_year']) ?>
                        </div>

                    </div>

                    <!-- BODY -->
                    <div class="exp-body">

                        <div class="exp-title">
                            <?= htmlspecialchars($exp['title']) ?>
                        </div>

                        <div class="exp-desc">

                            <?= substr(
                                htmlspecialchars($exp['description']),
                                0,
                                65
                            ) ?>...

                        </div>

                        <!-- BUTTON -->
                        <div class="exp-action">

                            <!-- DETAIL -->
                            <button
                                class="btn btn-outline-primary btn-detail"
                                data-bs-toggle="modal"
                                data-bs-target="#detailExpModal<?= $exp['id'] ?>"
                            >
                                Detail
                            </button>

                            <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin'): ?>

                            <!-- EDIT -->
                            <button
                                class="btn-icon text-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editExpModal<?= $exp['id'] ?>"
                            >
                                <i class="fas fa-pen"></i>
                            </button>

                            <!-- DELETE -->
                            <a
                                href="?page=experience&delete_exp=<?= $exp['id'] ?>"
                                class="btn-icon text-danger"
                                onclick="return confirm('Yakin hapus pengalaman ini?')"
                            >
                                <i class="fas fa-trash"></i>
                            </a>

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

            </div>

            <!-- ===================== -->
            <!-- MODAL DETAIL -->
            <!-- ===================== -->
            <div
                class="modal fade"
                id="detailExpModal<?= $exp['id'] ?>"
                tabindex="-1"
            >

                <div class="modal-dialog">

                    <div class="modal-content">

                        <div class="modal-header bg-info text-white">

                            <h5 class="modal-title">
                                Detail Pengalaman
                            </h5>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                            ></button>

                        </div>

                        <div class="modal-body text-center">

                            <img
                                src="<?= htmlspecialchars($exp['foto']) ?>"
                                width="220"
                                class="img-thumbnail mb-3"
                                style="object-fit:cover;border-radius:10px;"
                                onerror="this.src='uploads/default_experience.jpg'"
                            >

                            <div class="text-start">

                                <p>
                                    <strong>Judul:</strong>
                                    <?= htmlspecialchars($exp['title']) ?>
                                </p>

                                <p>
                                    <strong>Tipe:</strong>
                                    <?= htmlspecialchars($exp['type']) ?>
                                </p>

                                <p>
                                    <strong>Tahun:</strong>
                                    <?= htmlspecialchars($exp['start_year']) ?>
                                    -
                                    <?= htmlspecialchars($exp['end_year']) ?>
                                </p>

                                <p>
                                    <strong>Deskripsi:</strong><br>
                                    <?= nl2br(htmlspecialchars($exp['description'])) ?>
                                </p>

                            </div>

                        </div>

                        <div class="modal-footer">

                            <button
                                class="btn btn-secondary"
                                data-bs-dismiss="modal"
                            >
                                Tutup
                            </button>

                        </div>

                    </div>

                </div>

            </div>

            <!-- ===================== -->
            <!-- MODAL EDIT -->
            <!-- ===================== -->
            <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin'): ?>

            <div
                class="modal fade"
                id="editExpModal<?= $exp['id'] ?>"
                tabindex="-1"
            >

                <div class="modal-dialog">

                    <div class="modal-content">

                        <form method="POST" enctype="multipart/form-data">

                            <div class="modal-header bg-warning">

                                <h5 class="modal-title">
                                    Edit Pengalaman
                                </h5>

                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                ></button>

                            </div>

                            <div class="modal-body">

                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?= $exp['id'] ?>"
                                >

                                <label>Judul</label>

                                <input
                                    type="text"
                                    name="title"
                                    class="form-control mb-2"
                                    value="<?= htmlspecialchars($exp['title']) ?>"
                                    required
                                >

                                <label>Deskripsi</label>

                                <textarea
                                    name="description"
                                    class="form-control mb-2"
                                    rows="3"
                                ><?= htmlspecialchars($exp['description']) ?></textarea>

                                <label>Tahun Mulai</label>

                                <input
                                    type="number"
                                    name="start_year"
                                    class="form-control mb-2"
                                    value="<?= htmlspecialchars($exp['start_year']) ?>"
                                >

                                <label>Tahun Selesai</label>

                                <input
                                    type="number"
                                    name="end_year"
                                    class="form-control mb-2"
                                    value="<?= htmlspecialchars($exp['end_year']) ?>"
                                >

                                <label>Tipe</label>

                                <select
                                    name="type"
                                    class="form-control mb-2"
                                >

                                    <option
                                        value="organisasi"
                                        <?= $exp['type']=='organisasi'?'selected':'' ?>
                                    >
                                        Organisasi
                                    </option>

                                    <option
                                        value="pekerjaan"
                                        <?= $exp['type']=='pekerjaan'?'selected':'' ?>
                                    >
                                        Pekerjaan
                                    </option>

                                    <option
                                        value="sertifikasi"
                                        <?= $exp['type']=='sertifikasi'?'selected':'' ?>
                                    >
                                        Sertifikasi
                                    </option>

                                    <option
                                        value="lainnya"
                                        <?= $exp['type']=='lainnya'?'selected':'' ?>
                                    >
                                        Lainnya
                                    </option>

                                </select>

                                <label>Ganti Foto</label>

                                <input
                                    type="file"
                                    name="foto_edit"
                                    class="form-control mb-2"
                                    accept="image/*"
                                >

                            </div>

                            <div class="modal-footer">

                                <button
                                    type="submit"
                                    name="update_experience"
                                    class="btn btn-primary"
                                >
                                    Update
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

            <?php endif; ?>

            <?php endforeach; ?>

        <?php else: ?>

        <div class="col-12">

            <div class="alert alert-secondary text-center">
                Belum ada data pengalaman
            </div>

        </div>

        <?php endif; ?>

    </div>

</div>

<!-- ===================== -->
<!-- MODAL TAMBAH -->
<!-- ===================== -->
<?php if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin'): ?>

<div class="modal fade" id="addExpModal" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form method="POST" enctype="multipart/form-data">

                <div class="modal-header bg-success text-white">

                    <h5 class="modal-title">
                        Tambah Pengalaman Baru
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>

                <div class="modal-body">

                    <label>Judul Pengalaman</label>

                    <input
                        type="text"
                        name="title"
                        class="form-control mb-2"
                        required
                    >

                    <label>Deskripsi</label>

                    <textarea
                        name="description"
                        class="form-control mb-2"
                        rows="3"
                    ></textarea>

                    <label>Tahun Mulai</label>

                    <input
                        type="number"
                        name="start_year"
                        class="form-control mb-2"
                    >

                    <label>Tahun Selesai</label>

                    <input
                        type="number"
                        name="end_year"
                        class="form-control mb-2"
                    >

                    <label>Tipe</label>

                    <select
                        name="type"
                        class="form-control mb-2"
                    >

                        <option value="organisasi">
                            Organisasi
                        </option>

                        <option value="pekerjaan">
                            Pekerjaan
                        </option>

                        <option value="sertifikasi">
                            Sertifikasi
                        </option>

                        <option value="lainnya">
                            Lainnya
                        </option>

                    </select>

                    <label>Foto</label>

                    <input
                        type="file"
                        name="foto"
                        class="form-control mb-2"
                        accept="image/*"
                    >

                </div>

                <div class="modal-footer">

                    <button
                        type="submit"
                        name="save_experience"
                        class="btn btn-primary"
                    >
                        Simpan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?php endif; ?>
