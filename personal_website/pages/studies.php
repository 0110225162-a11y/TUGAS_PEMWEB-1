<?php
// pages/studies.php

// --- KEAMANAN BACKEND: HANYA ADMIN YANG BISA UBAH DATA ---
if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin') {
    // Proses Tambah
    if(isset($_POST['save_study'])) {
        $nama = $_POST['nama'];
        $id_level = $_POST['id_level'];
        $keterangan = $_POST['keterangan'];
        $tahun_lulus = $_POST['tahun_lulus'];
        $foto = 'uploads/default_school.jpg';
        if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $target_dir = "uploads/";
            if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
            $foto = $target_dir . time() . "_" . basename($_FILES['foto']['name']);
            move_uploaded_file($_FILES['foto']['tmp_name'], $foto);
        }
        $stmt = $pdo->prepare("INSERT INTO studies (nama, id_level, keterangan, tahun_lulus, foto_sekolah) VALUES (?,?,?,?,?)");
        $stmt->execute([$nama, $id_level, $keterangan, $tahun_lulus, $foto]);
        echo "<script>alert('Data berhasil ditambah!'); window.location.href='?page=studies';</script>";
    }
    // Proses Edit
    if(isset($_POST['update_study'])) {
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $id_level = $_POST['id_level'];
        $keterangan = $_POST['keterangan'];
        $tahun_lulus = $_POST['tahun_lulus'];
        // Foto optional
        if(isset($_FILES['foto_edit']) && $_FILES['foto_edit']['error'] == 0) {
            $target_dir = "uploads/";
            $foto = $target_dir . time() . "_" . basename($_FILES['foto_edit']['name']);
            move_uploaded_file($_FILES['foto_edit']['tmp_name'], $foto);
            $stmt = $pdo->prepare("UPDATE studies SET nama=?, id_level=?, keterangan=?, tahun_lulus=?, foto_sekolah=? WHERE id=?");
            $stmt->execute([$nama, $id_level, $keterangan, $tahun_lulus, $foto, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE studies SET nama=?, id_level=?, keterangan=?, tahun_lulus=? WHERE id=?");
            $stmt->execute([$nama, $id_level, $keterangan, $tahun_lulus, $id]);
        }
        echo "<script>alert('Data berhasil diupdate!'); window.location.href='?page=studies';</script>";
    }
    // Proses Hapus
    if(isset($_GET['delete_study'])) {
        $id = $_GET['delete_study'];
        $stmt = $pdo->prepare("DELETE FROM studies WHERE id = ?");
        $stmt->execute([$id]);
        echo "<script>alert('Data berhasil dihapus!'); window.location.href='?page=studies';</script>";
    }
}

// Ambil data untuk ditampilkan (Semua orang bisa lihat)
$studies = $pdo->query("SELECT studies.*, level.nama as level_nama FROM studies JOIN level ON studies.id_level = level.id ORDER BY studies.id DESC")->fetchAll();
$levels = $pdo->query("SELECT * FROM level")->fetchAll();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3><i class="fas fa-graduation-cap"></i> Riwayat Pendidikan</h3>
        
        <!-- Tombol Tambah HANYA muncul jika role adalah admin -->
        <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin'): ?>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addStudyModal"><i class="fas fa-plus"></i> Tambah Riwayat</button>
        <?php endif; ?>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr><th>NO</th><th>Nama Sekolah</th><th>Jenjang</th><th>Tahun Lulus</th><th>Foto</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php $no=1; foreach($studies as $study): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($study['nama']) ?></td>
                    <td><?= htmlspecialchars($study['level_nama']) ?></td>
                    <td><?= $study['tahun_lulus'] ?></td>
                    <td><img src="<?= $study['foto_sekolah'] ?>" width="50" height="50" style="object-fit:cover;" onerror="this.src='uploads/default_school.jpg'"></td>
                    <td>
                        <!-- Tombol Detail BISA dilihat siapa saja -->
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailStudyModal<?= $study['id'] ?>"><i class="fas fa-eye"></i> Detail</button>
                        
                        <!-- Tombol Edit & Hapus HANYA muncul jika role adalah admin -->
                        <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin'): ?>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editStudyModal<?= $study['id'] ?>"><i class="fas fa-edit"></i> Edit</button>
                            <a href="?page=studies&delete_study=<?= $study['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i> Hapus</a>
                        <?php endif; ?>
                    </td>
                </tr>
                
                <!-- Modal Detail -->
                <div class="modal fade" id="detailStudyModal<?= $study['id'] ?>" tabindex="-1">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <div class="modal-header bg-info text-white">

                            <h5 class="modal-title">
                                Detail Pendidikan
                        </h5>

                    <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    ></button>

            </div>

            <!-- BAGIAN YANG DIUBAH -->
            <div class="modal-body text-center">

                <!-- FOTO DI ATAS -->
                <img
                    src="<?= htmlspecialchars($study['foto_sekolah']) ?>"
                    width="220"
                    class="img-thumbnail mb-3"
                    style="object-fit:cover;border-radius:10px;"
                    onerror="this.src='uploads/default_school.jpg'"
                >

                <!-- DETAIL DI BAWAH FOTO -->
                <div class="text-start">

                    <p>
                        <strong>Nama:</strong>
                        <?= htmlspecialchars($study['nama']) ?>
                    </p>

                    <p>
                        <strong>Jenjang:</strong>
                        <?= htmlspecialchars($study['level_nama']) ?>
                    </p>

                    <p>
                        <strong>Tahun Lulus:</strong>
                        <?= $study['tahun_lulus'] ?>
                    </p>

                    <p>
                        <strong>Keterangan:</strong><br>
                        <?= nl2br(htmlspecialchars($study['keterangan'])) ?>
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

                <!-- Modal Edit (Hanya dirender jika role adalah admin) -->
                <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin'): ?>
                <div class="modal fade" id="editStudyModal<?= $study['id'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="modal-header bg-warning">
                                    <h5 class="modal-title">Edit Pendidikan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id" value="<?= $study['id'] ?>">
                                    <label>Nama Sekolah</label>
                                    <input type="text" name="nama" class="form-control mb-2" value="<?= htmlspecialchars($study['nama']) ?>" required>
                                    <label>Jenjang</label>
                                    <select name="id_level" class="form-control mb-2">
                                        <?php foreach($levels as $level): ?>
                                            <option value="<?= $level['id'] ?>" <?= $level['id']==$study['id_level']?'selected':'' ?>><?= $level['nama'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label>Tahun Lulus</label>
                                    <input type="number" name="tahun_lulus" class="form-control mb-2" value="<?= $study['tahun_lulus'] ?>">
                                    <label>Keterangan</label>
                                    <textarea name="keterangan" class="form-control mb-2" rows="2"><?= htmlspecialchars($study['keterangan']) ?></textarea>
                                    <label>Ganti Foto (opsional)</label>
                                    <input type="file" name="foto_edit" class="form-control mb-2" accept="image/*">
                                    <small>Foto saat ini: <img src="<?= $study['foto_sekolah'] ?>" width="40"></small>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="update_study" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah (Hanya dirender jika role adalah admin) -->
<?php if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin'): ?>
<div class="modal fade" id="addStudyModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Tambah Riwayat Pendidikan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label>Nama Sekolah/Universitas</label>
                    <input type="text" name="nama" class="form-control mb-2" required>
                    <label>Jenjang</label>
                    <select name="id_level" class="form-control mb-2" required>
                        <option value="">Pilih Tingkat</option>
                        <?php foreach($levels as $level): ?>
                            <option value="<?= $level['id'] ?>"><?= $level['nama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label>Tahun Masuk</label>
                    <input type="number" name="tahun_masuk" class="form-control mb-2" required>
                    <label>Tahun Lulus</label>
                    <input type="number" name="tahun_lulus" class="form-control mb-2" required>
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control mb-2" rows="2"></textarea>
                    <label>Foto Sekolah</label>
                    <input type="file" name="foto" class="form-control mb-2" accept="image/*">
                </div>
                <div class="modal-footer">
                    <button type="submit" name="save_study" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>