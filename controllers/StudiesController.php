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
            $nama = $_POST['nama'];
            $idlevel = $_POST['idlevel'];
            $keterangan = $_POST['keterangan'];
            $tahun_lulus = $_POST['tahun_lulus'];
            
            // Upload foto
            $foto = '';
            if(isset($_FILES['foto_sekolah']) && $_FILES['foto_sekolah']['error'] == 0) {
                $target_dir = "images/uploads/";
                
                // Buat folder jika belum ada
                if(!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                
                $foto = $target_dir . basename($_FILES["foto_sekolah"]["name"]);
                move_uploaded_file($_FILES["foto_sekolah"]["tmp_name"], $foto);
            }
            
            $this->model->create($nama, $idlevel, $keterangan, $tahun_lulus, $foto);
            echo "<script>window.location.href='index.php?page=studies';</script>";
            exit();
        }
    }
    
    // Proses update data
    public function update() {
        if(isset($_POST['update'])) {
            $id = $_POST['id'];
            $nama = $_POST['nama'];
            $idlevel = $_POST['idlevel'];
            $keterangan = $_POST['keterangan'];
            $tahun_lulus = $_POST['tahun_lulus'];
            
            // Upload foto baru jika ada
            $foto = $_POST['foto_lama'];
            if(isset($_FILES['foto_sekolah']) && $_FILES['foto_sekolah']['error'] == 0) {
                $target_dir = "images/uploads/";
                
                // Buat folder jika belum ada
                if(!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                
                $foto = $target_dir . basename($_FILES["foto_sekolah"]["name"]);
                move_uploaded_file($_FILES["foto_sekolah"]["tmp_name"], $foto);
            }
            
            $this->model->update($id, $nama, $idlevel, $keterangan, $tahun_lulus, $foto);
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
