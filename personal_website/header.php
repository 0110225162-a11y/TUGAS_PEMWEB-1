<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Home Page - Zikra Mahkota Hasan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Fonts(buat lebih modern) */
@import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Poppins:wght@400;500;600&display=swap');

body {
    font-family: 'Inter', sans-serif;
}

/* Navbar styling */
.navbar {
    font-family: 'Poppins', 'Inter', sans-serif;
    backdrop-filter: blur(0px);
    transition: all 0.3s ease;
}

.navbar-brand {
    font-weight: 700;
    font-size: 1.4rem;
    letter-spacing: -0.3px;
    background: linear-gradient(135deg, #2c3e50, #3498db);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent !important;
}

/* Navbar link styling */
.navbar-nav .nav-link {
    font-weight: 500;
    font-size: 0.95rem;
    padding: 0.5rem 1rem;
    margin: 0 0.1rem;
    border-radius: 30px;
    transition: all 0.2s ease;
    color: #2c3e50;
}

body.dark-mode .navbar-nav .nav-link {
    color: #e0e0e0;
}

.navbar-nav .nav-link:hover {
    background-color: rgba(52, 152, 219, 0.1);
    transform: translateY(-2px);
}

/* Dropdown menu styling */
.dropdown-menu {
    border-radius: 16px;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    padding: 0.5rem;
    margin-top: 0.5rem;
    font-family: 'Inter', sans-serif;
}

.dropdown-item {
    border-radius: 12px;
    padding: 0.5rem 1rem;
    font-weight: 500;
    transition: all 0.2s;
}

.dropdown-item:hover {
    background-color: #3498db10;
    transform: translateX(5px);
}

/* Tombol dark mode toggle */
#darkModeToggle {
    border-radius: 40px;
    padding: 0.4rem 1rem;
    font-weight: 500;
    transition: all 0.2s;
    background-color: #f1f3f5;
    border: none;
    color: #1e2a3a;
}

body.dark-mode #darkModeToggle {
    background-color: #2d3748;
    color: #e2e8f0;
}

#darkModeToggle:hover {
    transform: scale(1.02);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* User dropdown (admin) styling */
.navbar-nav .dropdown-toggle::after {
    vertical-align: middle;
}

/* Navbar overall shadow */
.navbar {
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
}
    </style>
</head>
<body>

<div class="container mt-3">
    <!--HEADER (12 Grid dengan Carousel)-->
    <div class="row">
        <div class="col-12">
            <div id="demoCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#demoCarousel" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#demoCarousel" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#demoCarousel" data-bs-slide-to="2"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                     <!-- kita disini ganti link picsum dengan nama file foto-->
                        <img src="img/foto1.jpg" class="d-block w-100" alt="Slide 1">
                        <div class="carousel-caption d-none d-md-block">
                             <h5>Selamat Datang di Website Saya</h5>
                             <p>Zikra Mahkota Hasan - Mahasiswa Teknik Informatika</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="img/foto2.jpg" class="d-block w-100" alt="Slide 2">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Kreatif & Inovatif</h5>
                            <p>Menciptakan solusi digital yang bermanfaat.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="https://picsum.photos/id/30/1500/400" class="d-block w-100" alt="Slide 3">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Terus Belajar & Berkembang</h5>
                            <p>Mengikuti perkembangan teknologi terbaru.</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#demoCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#demoCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>
    </div>
    <!-- AKHIR HEADER -->
    <br>