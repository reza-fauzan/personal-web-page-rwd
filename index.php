<?php
// Proses controller sebelum output HTML
if(isset($_GET['page'])) {
    $page = $_GET['page'];
    
    // Proses controller untuk level
    if($page == 'level') {
        require_once 'koneksi.php';
        require_once 'controllers/LevelController.php';
        $controller = new LevelController($dbh);
        $controller->tambah();
        $controller->update();
        $controller->hapus();
    }
    
    // Proses controller untuk studies
    if($page == 'studies') {
        require_once 'koneksi.php';
        require_once 'controllers/StudiesController.php';
        $controller = new StudiesController($dbh);
        $controller->tambah();
        $controller->update();
        $controller->hapus();
    }
}

// Setelah proses controller, baru tampilkan HTML
include_once 'kode_atas.php';
include_once 'header.php';
include_once 'menu.php';
echo '</br>';
include_once 'sidebar.php';
include_once 'main.php';
echo '</br>';
include_once 'footer.php';  
include_once 'kode_bawah.php';