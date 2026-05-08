<?php
// pages/about.php
$experiences = $pdo->query("
    SELECT * FROM experiences 
    ORDER BY start_year DESC
")->fetchAll();

// mengelompokkan berdasarkan tipe
$grouped = [];

foreach($experiences as $exp) {
    $grouped[$exp['type']][] = $exp;
}
?>

<div class="container-fluid">

    <!-- HEADER -->
    <div class="mb-4 border-bottom pb-3">
        <h2 class="fw-bold">
            <i class="fas fa-user-circle text-primary"></i>
            Tentang Saya
        </h2>

        <p class="text-muted mb-0">
            Sedikit cerita tentang diri saya, hobi, minat, dan pengalaman.
        </p>
    </div>

    <!-- CARD UTAMA -->
    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-body p-4">

            <div class="accordion" id="aboutAccordion">

                <!-- HOBI -->
                <div class="accordion-item border rounded-3 mb-3 overflow-hidden">

                    <h2 class="accordion-header">

                        <button
                            class="accordion-button"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapseHobby"
                        >
                            <i class="fas fa-music me-3 text-primary"></i>
                            <strong>Hobi & Minat</strong>
                        </button>

                    </h2>

                    <div
                        id="collapseHobby"
                        class="accordion-collapse collapse show"
                        data-bs-parent="#aboutAccordion"
                    >

                        <div class="accordion-body">

                            <p class="mb-0">
                                <strong>Musik</strong> adalah salah satu hal
                                yang paling saya sukai untuk refresh pikiran.
                                Saya juga sering mendengarkan musik saat
                                ngoding supaya lebih fokus dan nyaman.
                            </p>

                        </div>

                    </div>

                </div>

                <!-- MAKANAN FAVORIT -->
                <div class="accordion-item border rounded-3 mb-3 overflow-hidden">

                    <h2 class="accordion-header">

                        <button
                            class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapseMenu"
                        >
                            <i class="fas fa-utensils me-3 text-danger"></i>
                            <strong>Menu Favorit</strong>
                        </button>

                    </h2>

                    <div
                        id="collapseMenu"
                        class="accordion-collapse collapse"
                        data-bs-parent="#aboutAccordion"
                    >

                        <div class="accordion-body">

                            <p class="mb-0">
                                Saya sangat suka
                                <strong>Nasi Padang</strong>,
                                <strong>Rendang</strong>,
                                <strong>Siomay</strong>,
                                dan <strong>Bakso</strong>.
                            </p>

                        </div>

                    </div>

                </div>

                <!-- ORGANISASI -->
                <?php if(isset($grouped['organisasi'])): ?>

                <div class="accordion-item border rounded-3 mb-3 overflow-hidden">

                    <h2 class="accordion-header">

                        <button
                            class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapseOrg"
                        >
                            <i class="fas fa-users me-3 text-success"></i>
                            <strong>Pengalaman Organisasi</strong>
                        </button>

                    </h2>

                    <div
                        id="collapseOrg"
                        class="accordion-collapse collapse"
                        data-bs-parent="#aboutAccordion"
                    >

                        <div class="accordion-body">

                            <?php foreach($grouped['organisasi'] as $exp): ?>

                                <div class="card border-0 shadow-sm mb-3">

                                    <div class="card-body">

                                        <h5 class="fw-bold mb-1">
                                            <?= htmlspecialchars($exp['title']) ?>
                                        </h5>

                                        <small class="text-muted d-block mb-2">
                                            <?= $exp['start_year'] ?>
                                            -
                                            <?= $exp['end_year'] ?>
                                        </small>

                                        <p class="mb-0">
                                            <?= htmlspecialchars($exp['description']) ?>
                                        </p>

                                    </div>

                                </div>

                            <?php endforeach; ?>

                        </div>

                    </div>

                </div>

                <?php endif; ?>

                <!-- PEKERJAAN -->
                <?php if(isset($grouped['pekerjaan'])): ?>

                <div class="accordion-item border rounded-3 mb-3 overflow-hidden">

                    <h2 class="accordion-header">

                        <button
                            class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapseWork"
                        >
                            <i class="fas fa-briefcase me-3 text-warning"></i>
                            <strong>Pengalaman Kerja</strong>
                        </button>

                    </h2>

                    <div
                        id="collapseWork"
                        class="accordion-collapse collapse"
                        data-bs-parent="#aboutAccordion"
                    >

                        <div class="accordion-body">

                            <?php foreach($grouped['pekerjaan'] as $exp): ?>

                                <div class="card border-0 shadow-sm mb-3">

                                    <div class="card-body">

                                        <h5 class="fw-bold mb-1">
                                            <?= htmlspecialchars($exp['title']) ?>
                                        </h5>

                                        <small class="text-muted d-block mb-2">
                                            <?= $exp['start_year'] ?>
                                            -
                                            <?= $exp['end_year'] ?>
                                        </small>

                                        <p class="mb-0">
                                            <?= htmlspecialchars($exp['description']) ?>
                                        </p>

                                    </div>

                                </div>

                            <?php endforeach; ?>

                        </div>

                    </div>

                </div>

                <?php endif; ?>

                <!-- SERTIFIKASI -->
                <?php if(isset($grouped['sertifikasi'])): ?>

                <div class="accordion-item border rounded-3 mb-3 overflow-hidden">

                    <h2 class="accordion-header">

                        <button
                            class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapseCert"
                        >
                            <i class="fas fa-certificate me-3 text-info"></i>
                            <strong>Sertifikasi</strong>
                        </button>

                    </h2>

                    <div
                        id="collapseCert"
                        class="accordion-collapse collapse"
                        data-bs-parent="#aboutAccordion"
                    >

                        <div class="accordion-body">

                            <?php foreach($grouped['sertifikasi'] as $exp): ?>

                                <div class="card border-0 shadow-sm mb-3">

                                    <div class="card-body">

                                        <h5 class="fw-bold mb-1">
                                            <?= htmlspecialchars($exp['title']) ?>
                                        </h5>

                                        <small class="text-muted d-block mb-2">
                                            <?= $exp['start_year'] ?>
                                        </small>

                                        <p class="mb-0">
                                            <?= htmlspecialchars($exp['description']) ?>
                                        </p>

                                    </div>

                                </div>

                            <?php endforeach; ?>

                        </div>

                    </div>

                </div>

                <?php endif; ?>

                <!-- LAINNYA -->
                <?php if(isset($grouped['lainnya'])): ?>

                <div class="accordion-item border rounded-3 overflow-hidden">

                    <h2 class="accordion-header">

                        <button
                            class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapseOther"
                        >
                            <i class="fas fa-star me-3 text-secondary"></i>
                            <strong>Pengalaman Lainnya</strong>
                        </button>

                    </h2>

                    <div
                        id="collapseOther"
                        class="accordion-collapse collapse"
                        data-bs-parent="#aboutAccordion"
                    >

                        <div class="accordion-body">

                            <?php foreach($grouped['lainnya'] as $exp): ?>

                                <div class="card border-0 shadow-sm mb-3">

                                    <div class="card-body">

                                        <h5 class="fw-bold mb-1">
                                            <?= htmlspecialchars($exp['title']) ?>
                                        </h5>

                                        <small class="text-muted d-block mb-2">
                                            <?= $exp['start_year'] ?>
                                            -
                                            <?= $exp['end_year'] ?>
                                        </small>

                                        <p class="mb-0">
                                            <?= htmlspecialchars($exp['description']) ?>
                                        </p>

                                    </div>

                                </div>

                            <?php endforeach; ?>

                        </div>

                    </div>

                </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

</div>