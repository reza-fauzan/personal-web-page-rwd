<div class="col-md-9">
<?php
// Cek apakah ada parameter page di URL
if(isset($_GET['page'])) {
    $page = $_GET['page'];
    
    // Daftar halaman yang diizinkan
    $allowed_pages = ['home', 'about_me', 'contact_me', 'level', 'studies'];
    
    // Cek apakah halaman ada dalam daftar yang diizinkan
    if(in_array($page, $allowed_pages)) {
        $file = $page . '.php';
        
        // Cek apakah file ada
        if(file_exists($file)) {
            include_once $file;
        } else {
            echo '<h1>Halaman tidak ditemukan</h1>';
        }
    } else {
        echo '<h1>Halaman tidak valid</h1>';
    }
} else {
    // Halaman default (Home) - load home.php
    if(file_exists('home.php')) {
        include_once 'home.php';
    } else {
        echo '<h1>Welcome to Home Page</h1>';
        echo '<p>Selamat datang di halaman personal Nur Alya Nabila</p>';
    }
}
?>
</div>
</div>