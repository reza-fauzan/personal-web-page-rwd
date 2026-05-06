<?php

require_once 'models/Studies.php';
require_once 'models/Level.php';
require_once 'koneksi.php';

class StudiesController {
    private $model;
    private $levelModel;
    
    public function __construct($db) {
        $this->model = new Studies($db);
        $this->levelModel = new Level($db);
    }
    
    // Proses tambah data
    public function tambah() {
        if(isset($_POST['simpan'])) {
            // Ambil data dari form
            $nama = $_POST['nama'];
            $idlevel = $_POST['idlevel'];
            $keterangan = $_POST['keterangan'];
            $tahun_lulus = $_POST['tahun_lulus'];
            
            // Proses upload foto (business logic)
            $foto = $this->uploadFoto();
            
            // Simpan ke database lewat model
            $this->model->create($nama, $idlevel, $keterangan, $tahun_lulus, $foto);
            
            // Redirect
            echo "<script>window.location.href='index.php?page=studies';</script>";
            exit();
        }
    }
    
    // Method untuk upload foto (business logic)
    private function uploadFoto() {
        $foto = '';
        
        if(isset($_FILES['foto_sekolah']) && $_FILES['foto_sekolah']['error'] == 0) {
            $target_dir = "images/uploads/";
            
            // Buat folder jika belum ada
            if(!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            
            // Generate nama file unik
            $file_extension = pathinfo($_FILES["foto_sekolah"]["name"], PATHINFO_EXTENSION);
            $file_name = time() . '_' . basename($_FILES["foto_sekolah"]["name"]);
            $foto = $target_dir . $file_name;
            
            // Upload file
            move_uploaded_file($_FILES["foto_sekolah"]["tmp_name"], $foto);
        }
        
        return $foto;
    }
    
    // Proses update data
    public function update() {
        if(isset($_POST['update'])) {
            // Ambil data dari form
            $id = $_POST['id'];
            $nama = $_POST['nama'];
            $idlevel = $_POST['idlevel'];
            $keterangan = $_POST['keterangan'];
            $tahun_lulus = $_POST['tahun_lulus'];
            
            // Cek apakah ada foto baru
            $foto = $_POST['foto_lama'];
            if(isset($_FILES['foto_sekolah']) && $_FILES['foto_sekolah']['error'] == 0) {
                // Hapus foto lama jika ada
                if(!empty($foto) && file_exists($foto)) {
                    unlink($foto);
                }
                // Upload foto baru
                $foto = $this->uploadFoto();
            }
            
            // Update ke database lewat model
            $this->model->update($id, $nama, $idlevel, $keterangan, $tahun_lulus, $foto);
            
            // Redirect
            echo "<script>window.location.href='index.php?page=studies';</script>";
            exit();
        }
    }
    
    // Proses hapus data
    public function hapus() {
        if(isset($_GET['hapus'])) {
            $id = $_GET['hapus'];
            $this->model->delete($id);
            echo "<script>window.location.href='index.php?page=studies';</script>";
            exit();
        }
    }
    
    // Ambil semua data
    public function index() {
        return $this->model->getAll();
    }
    
    // Ambil data untuk edit
    public function edit($id) {
        return $this->model->getById($id);
    }
    
    // Ambil semua level untuk dropdown
    public function getLevels() {
        return $this->levelModel->getAll();
    }
}
?>
