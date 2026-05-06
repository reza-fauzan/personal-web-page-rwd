<?php

require_once 'models/Member.php';
require_once 'koneksi.php';

class MemberController {
    private $model;
    
    public function __construct($db) {
        $this->model = new Member($db);
    }
    
    // Proses login
    public function login() {
        if(isset($_POST['login'])) {
            // Ambil data dari form
            $email = $_POST['email'];
            $password = sha1($_POST['password']); // Enkripsi password dengan SHA1
            
            // Cek login lewat model
            $result = $this->model->login($email, $password);
            
            if($result['success']) {
                // Login berhasil, buat session
                $_SESSION['user_id'] = $result['data']['id'];
                $_SESSION['fullname'] = $result['data']['fullname'];
                $_SESSION['email'] = $result['data']['email'];
                $_SESSION['role'] = $result['data']['role'];
                $_SESSION['foto'] = $result['data']['foto'];
                $_SESSION['is_login'] = true;
                
                // Redirect ke halaman home
                echo "<script>window.location.href='index.php';</script>";
                exit();
            } else {
                // Login gagal
                $_SESSION['error'] = $result['message'];
                echo "<script>window.location.href='login.php';</script>";
                exit();
            }
        }
    }
    
    // Proses logout
    public function logout() {
        // Hapus semua session
        session_unset();
        session_destroy();
        
        // Redirect ke login
        echo "<script>window.location.href='login.php';</script>";
        exit();
    }
    
    // Cek apakah user sudah login
    public function isLogin() {
        return isset($_SESSION['is_login']) && $_SESSION['is_login'] === true;
    }
    
    // Cek role user
    public function checkRole($role) {
        if(!$this->isLogin()) {
            return false;
        }
        return $_SESSION['role'] === $role;
    }
    
    // Ambil data user yang sedang login
    public function getCurrentUser() {
        if(!$this->isLogin()) {
            return null;
        }
        
        return [
            'id' => $_SESSION['user_id'],
            'fullname' => $_SESSION['fullname'],
            'email' => $_SESSION['email'],
            'role' => $_SESSION['role'],
            'foto' => $_SESSION['foto']
        ];
    }
    
    // Proses tambah member baru (register)
    public function register() {
        if(isset($_POST['register'])) {
            // Ambil data dari form
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $password = sha1($_POST['password']); // Enkripsi password
            $role = isset($_POST['role']) ? $_POST['role'] : 'mahasiswa'; // Default role
            
            // Validasi: Cek apakah role admin dan sudah ada admin
            if($role === 'admin') {
                $adminCount = $this->model->countAdmin();
                if($adminCount > 0) {
                    $_SESSION['error'] = 'Role admin sudah ada, hanya boleh 1 admin';
                    echo "<script>window.location.href='register.php';</script>";
                    exit();
                }
            }
            
            // Proses upload foto
            $foto = $this->uploadFoto();
            
            // Cek apakah email sudah terdaftar
            $existing = $this->model->getByEmail($email);
            if($existing) {
                $_SESSION['error'] = 'Email sudah terdaftar';
                echo "<script>window.location.href='register.php';</script>";
                exit();
            }
            
            // Simpan ke database lewat model
            $result = $this->model->create($fullname, $email, $password, $role, $foto);
            
            if($result['success']) {
                $_SESSION['success'] = 'Registrasi berhasil, silakan login';
                echo "<script>window.location.href='login.php';</script>";
                exit();
            } else {
                $_SESSION['error'] = $result['message'];
                echo "<script>window.location.href='register.php';</script>";
                exit();
            }
        }
    }
    
    // Method untuk upload foto (business logic)
    private function uploadFoto() {
        $foto = '';
        
        if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $target_dir = "images/uploads/";
            
            // Buat folder jika belum ada
            if(!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            
            // Generate nama file unik
            $file_extension = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
            $file_name = time() . '_' . basename($_FILES["foto"]["name"]);
            $foto = $target_dir . $file_name;
            
            // Upload file
            move_uploaded_file($_FILES["foto"]["tmp_name"], $foto);
        }
        
        return $foto;
    }
    
    // Ambil semua member
    public function index() {
        return $this->model->getAll();
    }
    
    // Ambil member untuk edit
    public function edit($id) {
        return $this->model->getById($id);
    }
    
    // Proses update member
    public function update() {
        if(isset($_POST['update'])) {
            // Ambil data dari form
            $id = $_POST['id'];
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $role = $_POST['role'];
            
            // Cek apakah password diubah
            $password = $_POST['password_lama'];
            if(!empty($_POST['password_baru'])) {
                $password = sha1($_POST['password_baru']);
            }
            
            // Cek apakah ada foto baru
            $foto = $_POST['foto_lama'];
            if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
                // Hapus foto lama jika ada
                if(!empty($foto) && file_exists($foto)) {
                    unlink($foto);
                }
                // Upload foto baru
                $foto = $this->uploadFoto();
            }
            
            // Update ke database lewat model
            $result = $this->model->update($id, $fullname, $email, $password, $role, $foto);
            
            if($result['success']) {
                // Update session jika user edit profile sendiri
                if($id == $_SESSION['user_id']) {
                    $_SESSION['fullname'] = $fullname;
                    $_SESSION['email'] = $email;
                    $_SESSION['role'] = $role;
                    $_SESSION['foto'] = $foto;
                }
                
                echo "<script>window.location.href='index.php?page=member';</script>";
                exit();
            }
        }
    }
    
    // Proses hapus member
    public function hapus() {
        if(isset($_GET['hapus'])) {
            $id = $_GET['hapus'];
            
            // Tidak boleh hapus diri sendiri
            if($id == $_SESSION['user_id']) {
                $_SESSION['error'] = 'Tidak bisa menghapus akun sendiri';
                echo "<script>window.location.href='index.php?page=member';</script>";
                exit();
            }
            
            $this->model->delete($id);
            echo "<script>window.location.href='index.php?page=member';</script>";
            exit();
        }
    }
}
?>
