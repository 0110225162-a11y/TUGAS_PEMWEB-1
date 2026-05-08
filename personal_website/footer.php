<!-- FOOTER: 12 Grid dengan Alerts -->
<div class="row footer">
    <div class="col-12">
        <div class="alert alert-secondary text-center mb-0" role="alert">
            <i class="fas fa-copyright"></i> 2026 Web Portofolio - Zikra Mahkota Hasan. Dibuat dengan Bootstrap.
            <hr>
            <small>Versi 2.0 | Nurul Fikri</small>
        </div>
    </div>
</div>
<!-- AKHIR FOOTER -->

<script>
// Dark Mode Toggle
const toggleBtn = document.getElementById('darkModeToggle');
const modeText = document.getElementById('modeText');
const icon = toggleBtn.querySelector('i');

// Cek local storage untuk tema yang tersimpan
if (localStorage.getItem('theme') === 'dark') {
    document.body.classList.add('dark-mode');
    icon.classList.remove('fa-moon');
    icon.classList.add('fa-sun');
    modeText.innerText = 'Light';
} else {
    document.body.classList.remove('dark-mode');
    icon.classList.remove('fa-sun');
    icon.classList.add('fa-moon');
    modeText.innerText = 'Dark';
}

toggleBtn.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');
    if (document.body.classList.contains('dark-mode')) {
        localStorage.setItem('theme', 'dark');
        icon.classList.remove('fa-moon');
        icon.classList.add('fa-sun');
        modeText.innerText = 'Light';
    } else {
        localStorage.setItem('theme', 'light');
        icon.classList.remove('fa-sun');
        icon.classList.add('fa-moon');
        modeText.innerText = 'Dark';
    }
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>