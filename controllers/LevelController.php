<?php

require_once 'models/Level.php';
require_once 'koneksi.php';


class LevelController {
    private $model;
    
    public function __construct($db) {
        $this->model = new Level($db);
    }
    
    // Proses tambah data
    public function tambah() {
        if(isset($_POST['simpan'])) {
            $nama = $_POST['nama'];
            $this->model->create($nama);
            echo "<script>window.location.href='index.php?page=level';</script>";
            exit();
        }
    }
    
    // Proses update data
    public function update() {
        if(isset($_POST['update'])) {
            $id = $_POST['id'];
            $nama = $_POST['nama'];
            $this->model->update($id, $nama);
            echo "<script>window.location.href='index.php?page=level';</script>";
            exit();
        }
    }
    
    // Proses hapus data
    public function hapus() {
        if(isset($_GET['hapus'])) {
            $id = $_GET['hapus'];
            $this->model->delete($id);
            echo "<script>window.location.href='index.php?page=level';</script>";
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
}
?>
